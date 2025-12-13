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
        // 1. データベースからすべての部屋タイプを取得
        $rooms = Room::orderBy('created_at', 'desc')->get();

        // 2. rooms/index.blade.php にデータを渡して表示
        return view('rooms.index', [
            'rooms' => $rooms
        ]);
    }



    public function create()
    {
        return view('rooms.create');
    }


    public function show(string $id)
    {
        // 1. 詳細表示対象の部屋タイプをIDで取得
        $room = \App\Models\Room::findOrFail($id);

        // 2. 詳細ビューにデータを渡して表示
        return view('rooms.show', compact('room'));
    }



    public function edit(string $id)
    {
        // 1. 編集対象の部屋タイプをIDで取得
        $room = \App\Models\Room::findOrFail($id);

        // 2. 編集ビューにデータを渡して表示
        // ファイル名: resources/views/rooms/edit.blade.php を想定
        return view('rooms.edit', compact('room'));
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
                RoomImage::create([
                    'room_id' => $room->id,
                    'image_url' => $url,
                    'sort_order' => $sortOrder,
                ]);
                $sortOrder++;
            }

            DB::commit();

            // 4. リダイレクト
            return redirect()->route('rooms.index')->with('success', $room->type_name . ' が正常に登録されました。');
        } catch (\Exception $e) {
            DB::rollback();

            \Log::error('部屋タイプ登録エラー: ' . $e->getMessage());

            return back()->withInput()->withErrors(['error' => '部屋タイプの登録中にエラーが発生しました。']);
        }
    }



    public function update(Request $request, string $id)
    {
        $room = Room::findOrFail($id);

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

            // 既存の関連画像レコードを全て削除
            $room->images()->delete();

            // new_image_urlsから空の値をフィルタリングし、新しい画像を登録
            $imageUrls = array_filter($request->new_image_urls);
            $sortOrder = 1;

            foreach ($imageUrls as $url) {
                // $room->images()リレーションを使用してRoomImageを登録
                $room->images()->create([
                    'image_url' => $url,
                    'sort_order' => $sortOrder,
                ]);
                $sortOrder++;
            }

            DB::commit();

            // 4. リダイレクト
            return redirect()->route('rooms.index')->with('success', $room->type_name . ' が正常に更新されました。');
        } catch (\Exception $e) {
            DB::rollback();

            \Log::error('部屋タイプ更新エラー: ' . $e->getMessage());

            return back()->withInput()->withErrors(['error' => '部屋タイプの更新中にエラーが発生しました。']);
        }
    }



    public function destroy(string $id)
    {
        // 1. 削除対象の部屋タイプを取得
        $room = \App\Models\Room::findOrFail($id);

        $typeName = $room->type_name;

        // 2. 論理削除を実行
        $room->delete();

        // 3. リダイレクト
        return redirect()->route('rooms.index')->with('success', $typeName . ' が正常に削除されました。');
    }



}

