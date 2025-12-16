<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Reservation;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function create(Request $request)
{
    $rooms = Room::all();

    // チェックイン日(空室判定用ユーザーが選んだ日付を取得。未選択は今日)
    $checkInDate = $request->input('check_in_date', now()->toDateString());

    // 各部屋タイプごとに空室判定を追加
    foreach ($rooms as $room) {
        $reservedCount = Reservation::where('room_id', $room->id)
            ->whereDate('check_in', $checkInDate)
            ->where('status', 'confirmed')
            ->count();

        $room->reserved_count = $reservedCount;
        $room->remaining_rooms = max(0, $room->total_rooms - $reservedCount);
        $room->available      = $room->remaining_rooms > 0;
    }

    // 予約一覧（ログイン時のみ）
    $reservations = auth()->check()
        ? Reservation::with('room')
            -> where('user_id', auth()->id())
            -> orderBy('check_in', 'desc')
            -> get()
        : collect(); //未ログイン時は空コレクション

    return view('booking.create', compact('rooms', 'reservations', 'checkInDate'));
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id'       => 'required|exists:rooms,id',
            'guest_count'   => 'required|integer|min:1',
            'selected_plans'=> 'array',
            'check_in_date' => 'required|date|after_or_equal:today',//当日以降は選べないようにする
        ]);

        $room = Room::findOrFail($validated['room_id']);
        $checkOutDate = Carbon::parse($validated['check_in_date'])->addDay();

        // 料金計算
        $totalPrice = $room->price ;
        if (in_array('breakfast', $validated['selected_plans'] ?? [])) {
            $totalPrice += 3000 * $validated['guest_count'];
        }

        // reservations テーブルに保存
        $reservation = Reservation::create([
            'user_id'     => auth()->id(),
            'room_id'     => $validated['room_id'],
            'check_in'    => $validated['check_in_date'],
            'guests'      => $validated['guest_count'],
            'total_price' => $totalPrice,
            'status'      => 'confirmed',
        ]);

        // セッションに予約情報を渡す

        return redirect()->route('booking.create')->with('booking', [
            'id'            => $reservation->id,
            'room_name'     => $room->type_name,
            'check_in'      => $reservation->check_in->format('Y-m-d'),
            'check_out_date'=> $checkOutDate->format('Y-m-d'), // ← 表示用
            'guests'        => $reservation->guests,
            'total_price'   => $reservation->total_price,
        ]);
    }

    // 予約完了画面の表示
    public function complete()
    {
    return view('booking.complete');


    }

    public function index()
    {
        $reservations = Reservation::with('room')
        ->where('user_id', auth()->id())->get();

        return view('booking.index', compact('reservations'));
    }

    public function cancel($id)
    {
        $reservation = Reservation::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $reservation->delete();

        return redirect()->route('booking.create')
            ->with('success', '予約を削除しました');
    }
}

