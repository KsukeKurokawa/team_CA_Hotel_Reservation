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
        // 関連画像もロード
        $room->load('images');

        // 自分以外の部屋数の合計を取得
        $existingRoomsCount = Room::where('id', '!=', $room->id)->sum('total_rooms');

        // 残り作成可能な部屋数を計算
        $remainingRooms = 5 - $existingRoomsCount;

        return view('admin.rooms.edit', compact('room', 'remainingRooms'));
    }



    public function create()
    {
        $existingRoomsCount = Room::sum('total_rooms');
        $remainingRooms = 5 - $existingRoomsCount;

        return view('admin.rooms.create', compact('remainingRooms'));
    }



    public function store(Request $request)
    {
        // 1. バリデーション（最大値は一旦5までに）
        $validated = $request->validate([
            'type_name'   => 'required|string|max:100|unique:rooms,type_name',
            'description' => 'required|string',
            'price'       => ['required', 'integer', 'in:120000,200000'],
            'capacity'    => 'required|integer|min:1|max:4',
            'total_rooms' => 'required|integer|min:1|max:5',
            'plan'        => ['required', 'integer', 'in:0'],
            'new_image_urls' => 'nullable|array|max:5',
            'new_image_urls.*' => 'nullable|url|max:2048',
        ]);

        // 追加制約：全タイプでの合計部屋数
        $existingRoomsCount = Room::sum('total_rooms'); // 既存の合計
        $requestedRooms = $validated['total_rooms'];

        if ($existingRoomsCount + $requestedRooms > 5) {
            return back()->withInput()->withErrors([
                'total_rooms' => '全体で最大5室までしか作成できません。現在の合計: ' . $existingRoomsCount,
            ]);
        }

        DB::beginTransaction();

        try {
            // 2. roomsテーブルへの保存
            $room = Room::create([
                'type_name'   => $validated['type_name'],
                'description' => $validated['description'],
                'price'       => $validated['price'],
                'capacity'    => $validated['capacity'],
                'total_rooms' => $validated['total_rooms'],
                'plan'        => $validated['plan'],
            ]);

            // 3. room_imagesテーブルへの保存
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

            return redirect()->route('admin.rooms.index')->with('success', $room->type_name . ' が正常に登録されました。');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('部屋タイプ登録エラー: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => '部屋タイプの登録中にエラーが発生しました。']);
        }
    }



    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'type_name'   => 'required|string|max:100|unique:rooms,type_name,' . $room->id,
            'description' => 'required|string',
            'price'       => ['required', 'integer', 'in:120000,200000'],
            'capacity'    => 'required|integer|min:1|max:4',
            'total_rooms' => 'required|integer|min:1|max:5',
            'plan'        => ['required', 'integer', 'in:0'],
            'new_image_urls' => 'nullable|array|max:5',
            'new_image_urls.*' => 'nullable|url|max:2048',
        ]);

        // ★ 更新時用の合計チェック
        $existingRoomsCount = Room::where('id', '!=', $room->id)->sum('total_rooms');
        $requestedRooms = $validated['total_rooms'];

        if ($existingRoomsCount + $requestedRooms > 5) {
            return back()->withInput()->withErrors([
                'total_rooms' => '全体で最大5室までしか作成できません。現在の合計: ' . $existingRoomsCount . '室',
            ]);
        }

        DB::beginTransaction();

        try {
            // roomsテーブルの更新
            $room->update([
                'type_name'   => $validated['type_name'],
                'description' => $validated['description'],
                'price'       => $validated['price'],
                'capacity'    => $validated['capacity'],
                'total_rooms' => $validated['total_rooms'],
                'plan'        => $validated['plan'],
            ]);

            // 画像の更新処理
            if ($request->filled('new_image_urls')) {
                $room->images()->delete();

                $imageUrls = array_filter($request->new_image_urls);
                $sortOrder = 1;
                foreach ($imageUrls as $url) {
                    $room->images()->create([
                        'image_url'  => $url,
                        'sort_order' => $sortOrder,
                    ]);
                    $sortOrder++;
                }
            }

            DB::commit();

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