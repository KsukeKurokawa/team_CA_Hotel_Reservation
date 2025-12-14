<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('images')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.rooms.index', [
            'rooms' => $rooms
        ]);
    }



    public function show(Room $room)
    {
        $room->load('images');

        return view('admin.rooms.show', compact('room'));
    }



    public function edit(Room $room)
    {
        $room->load('images');

        return view('admin.rooms.edit', compact('room'));
    }


    public function create()
    {
        return view('admin.rooms.create');
    }



    public function store(Request $request)
    {
        // 1. バリデーション
        $validated = $request->validate([
            // roomsテーブルのデータ
            'type_name'   => 'required|string|max:100|unique:rooms,type_name',
            'description' => 'required|string',
            'price'       => ['required', 'integer', 'in:120000,200000'],
            'capacity'    => 'required|integer|min:1|max:4',
            'total_rooms' => 'required|integer|min:1|max:5',
            'plan' => ['required', 'integer', 'in:0'], // 現時点では0（素泊まり）のみ必須で許可

            // 複数画像URLに対応したバリデーション(最大5枚)
            'new_image_urls' => 'nullable|array|max:5',
            'new_image_urls.*' => 'nullable|url|max:2048',
        ]);

        // トランザクション開始
        DB::beginTransaction();

        try {
            // 2. roomsテーブルへの保存
            $room = Room::create([
                'type_name'   => $validated['type_name'],
                'description' => $validated['description'],
                'price'       => $validated['price'],
                'capacity'    => $validated['capacity'],
                'total_rooms' => $validated['total_rooms'],
                'plan' => $validated['plan'],
            ]);

            // 3. room_imagesテーブルへの画像の保存 (複数対応)
            $imageUrls = array_filter($request->new_image_urls);
            $sortOrder = 1;

            foreach ($imageUrls as $url) {
                $room->images()->create([
                    'image_url' => $url,
                    'sort_order' => $sortOrder,
                ]);
                $sortOrder++;
            }


            DB::commit();

            // 4. リダイレクト
            return redirect()->route('admin.rooms.index')->with('success', $room->type_name . ' が正常に登録されました。');
        } catch (\Exception $e) {
            DB::rollback();

            \Log::error('部屋タイプ登録エラー: ' . $e->getMessage());

            return back()->withInput()->withErrors(['error' => '部屋タイプの登録中にエラーが発生しました。']);
        }
    }



    public function update(Request $request, Room $room)
    {
        // 1. バリデーション: uniqueルールから自分自身を除外 (更新時の必須対応)
        $validated = $request->validate([
            'type_name'   => 'required|string|max:100|unique:rooms,type_name,' . $room->id, // ★ 自分自身を除外
            'description' => 'required|string',
            'price'       => ['required', 'integer', 'in:120000,200000'],
            'capacity'    => 'required|integer|min:1|max:4',
            'total_rooms' => 'required|integer|min:1|max:5',
            'plan' => ['required', 'integer', 'in:0'], // 現時点では0（素泊まり）のみ必須で許可

            // 複数画像URLに対応したバリデーション
            'new_image_urls' => 'nullable|array|max:5',
            'new_image_urls.*' => 'nullable|url|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // 2. roomsテーブルの更新
            $room->update([
                'type_name'   => $validated['type_name'],
                'description' => $validated['description'],
                'price'       => $validated['price'],
                'capacity'    => $validated['capacity'],
                'total_rooms' => $validated['total_rooms'],
                'plan' => $validated['plan'],
            ]);

            // 3. 画像の更新処理 (既存を削除し、新しいURLで再登録)

            // new_image_urls が送られてきた場合のみ画像を更新する
            if ($request->filled('new_image_urls')) {

                // 既存の関連画像を削除
                $room->images()->delete();

                $imageUrls = array_filter($request->new_image_urls);
                $sortOrder = 1;

                foreach ($imageUrls as $url) {
                    $room->images()->create([
                        'image_url' => $url,
                        'sort_order' => $sortOrder,
                    ]);
                    $sortOrder++;
                }
            }
            DB::commit();

            // 4. リダイレクト
            return redirect()->route('admin.rooms.index')->with('success', $room->type_name . ' が正常に更新されました。');
        } catch (\Exception $e) {
            DB::rollback();

            \Log::error('部屋タイプ更新エラー: ' . $e->getMessage());

            return back()->withInput()->withErrors(['error' => '部屋タイプの更新中にエラーが発生しました。']);
        }
    }



    public function destroy(Room $room)
    {
        // 1. 削除対象の部屋タイプは $room に格納されている
        $typeName = $room->type_name;

        DB::beginTransaction();

        try {
            // 部屋の論理削除を実行
            $room->delete();

            DB::commit();

            // 3. リダイレクト
            return redirect()->route('admin.rooms.index')->with('success', $typeName . ' が正常に削除されました。');
        } catch (\Exception $e) {
            DB::rollback();

            \Log::error('部屋タイプ削除エラー: ' . $e->getMessage());

            return back()->withErrors(['error' => '部屋タイプの削除中にエラーが発生しました。']);
        }
    }
}