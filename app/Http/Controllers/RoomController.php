<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    /**
     * 部屋タイプの一覧を表示する (R: Read - Index).
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 1. データベースからすべての部屋タイプを取得
        // 最新の登録順に並べるのが一般的です
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


    public function store(Request $request)
    {
        // 1. バリデーション: 全てのルールを統合
        $validated = $request->validate([
            // roomsテーブルのデータ
            'type_name'   => 'required|string|max:100|unique:rooms,type_name',
            'description' => 'required|string',
            'price'       => ['required', 'integer', 'in:120000,200000'], // 配列形式で in ルールを適用
            'capacity'    => 'required|integer|min:1|max:4',
            'total_rooms' => 'required|integer|min:1|max:5',

            // room_imagesテーブル用のデータ（nullable, URL形式）
            'image_url' => 'nullable|url|max:255',
        ]);

        // 2. roomsテーブルへの保存
        // 💡 フォームの入力名とDBのカラム名が一致しているため、そのまま使用可能
        $dataToStore = [
            'type_name'   => $validated['type_name'],
            'description' => $validated['description'],
            'price'       => $validated['price'],
            'capacity'    => $validated['capacity'],
            'total_rooms' => $validated['total_rooms'],
        ];

        // 💡 Room::create を実行 (Roomモデルはuse App\Models\Room;でインポートされている前提)
        $room = \App\Models\Room::create($dataToStore);

        // 3. 💡 room_imagesテーブルへの画像の保存
        if ($request->filled('image_url')) {
            $room->images()->create([
                'image_url' => $validated['image_url'],
                'sort_order' => 1,
            ]);
        }

        // 4. リダイレクト (一覧ページに戻る)
        return redirect()->route('rooms.index')->with('success', $room->type_name . ' が正常に登録されました。');
    }


    /**
     * 特定の部屋タイプを編集するためのフォームを表示する (U: Update - Edit).
     */
    public function edit(string $id)
    {
        // 1. 編集対象の部屋タイプをIDで取得 (見つからない場合は404)
        $room = \App\Models\Room::findOrFail($id);

        // 2. 編集ビューにデータを渡して表示
        // 💡 ファイル名: resources/views/rooms/edit.blade.php を想定
        return view('rooms.edit', compact('room'));
    }

    /**
     * フォームから送信された更新内容をデータベースに保存する (U: Update - Update).
     */
    public function update(Request $request, string $id)
    {
        // 1. 編集対象の部屋タイプを取得
        $room = \App\Models\Room::findOrFail($id);

        // 2. バリデーション (画像URLのバリデーションを追加)
        $validated = $request->validate([
            // 部屋データ
            'type_name' => 'required|string|max:100|unique:rooms,type_name,' . $room->id,
            'description' => 'required|string', // 必須に変更
            'price' => ['required', 'integer', 'in:120000,200000'],
            'capacity' => 'required|integer|min:1|max:4',
            'total_rooms' => 'required|integer|min:1|max:5',

            // 💡 画像データ (nullable|url を追加)
            'image_url' => 'nullable|url|max:255',
        ]);

        // 3. roomsテーブルのデータを更新
        $dataToUpdate = [
            'type_name'   => $validated['type_name'],
            'description' => $validated['description'],
            'price'       => $validated['price'],
            'capacity'    => $validated['capacity'],
            'total_rooms' => $validated['total_rooms'],
        ];
        $room->update($dataToUpdate);

        // 4. 💡 room_imagesテーブルの更新/保存ロジック
        if ($request->filled('image_url')) {
            // 新しい画像URLがある場合
            // まず、この部屋に紐づく既存の画像を全て削除 (簡単化のため)
            $room->images()->delete();

            // 新しい画像を1枚目として登録
            $room->images()->create([
                'image_url' => $validated['image_url'],
                'sort_order' => 1,
            ]);
        } else {
            // 画像URLが空欄の場合、既存の画像も削除する
            $room->images()->delete();
        }

        // 5. リダイレクト (一覧ページに戻る)
        return redirect()->route('rooms.index')->with('success', $room->type_name . ' の情報が正常に更新されました。');
    }


    /**
     * 特定の部屋タイプをデータベースから削除する (D: Delete - Destroy).
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        // 1. 削除対象の部屋タイプを取得
        $room = \App\Models\Room::findOrFail($id);

        $typeName = $room->type_name; // メッセージ用に名前を保持

        // 2. 削除を実行 (論理削除が実行される)
        $room->delete();

        // 3. リダイレクト (一覧ページに戻る)
        return redirect()->route('rooms.index')->with('success', $typeName . ' が正常に削除されました。');
    }



}

