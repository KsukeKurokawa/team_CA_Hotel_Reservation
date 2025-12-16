<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Carbon\Carbon;

class AdminReservationController extends Controller
{
    public function index()
    {
        $start = Carbon::now()->startOfWeek();

        $end = Carbon::now()->endOfWeek();

        $reservations = Reservation::with(['user', 'room'])
            ->whereBetween('check_in', [$start, $end])
            ->orderBy('check_in')
            ->get()
            ->groupBy(function ($reservation) {
                return Carbon::parse($reservation->check_in)
                    ->format('Y年m月d日 (D)');
            });

        return view('admin.reservations.index', compact('reservations'));
    }

    public function edit(Reservation $reservation)
    {
        $reservation->load(['room', 'user']);
        return view('admin.reservations.edit', compact('reservation'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'check_in'    => ['required', 'date'],
            'guests'      => ['required', 'integer', 'min:1','max:4'],
            'total_price' => ['required', 'integer', 'min:0'],
            'status'      => ['required', 'in:confirmed,cancelled'],
        ]);

        $reservation->update($validated);

        return redirect()->route('admin.reservations.index')
            ->with('success', '予約を更新しました');
    }

    public function destroy(Reservation $reservation)
{
    $reservation->delete();

    return redirect()->route('admin.reservations.index')
                     ->with('success', '予約を削除しました');
}
}
