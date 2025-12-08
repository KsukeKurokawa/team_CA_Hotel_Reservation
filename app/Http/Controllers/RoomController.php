<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        return view('rooms.index');
    }


    public function create()
    {
        return view('rooms.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            // type_name => 部屋タイプ名
            'type_name'   => 'required|string|max:100',
            // description => 説明
            'description' => 'required|string',
            // 料金は in ルールで厳密に120000か200000のみを許可
            'price'       => 'required|integer|in:120000,200000',
            // 定員は 1 から 4 の範囲に制限
            'capacity'    => 'required|integer|min:1|max:4',
            // 合計部屋数は 1 から 5 の範囲に制限
            'total_rooms' => 'required|integer|min:1|max:5',
        ]);

        $dataToStore = [
            'type_name'        => $validated['type_name'],
            'description' => $validated['description'],
            'price'       => $validated['price'],
            'capacity'    => $validated['capacity'],
            'total_rooms' => $validated['total_rooms'],
        ];

        $room = Room::create($dataToStore);

        return redirect()->route('rooms.index')->with('success', $room->type_name . ' が正常に登録されました。');
    }

    public function show(Room $room)
    {
        //
    }


    public function edit(Room $room)
    {
        //
    }


    public function update(Request $request, Room $room)
    {
        //
    }


    public function destroy(Room $room)
    {
        //
    }
}

