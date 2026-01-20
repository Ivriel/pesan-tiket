<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Schedule $schedule)
    {
        // Load relasi yang diperlukan untuk booking
        $schedule->load([
            'transportation', // Load transportation
            'route',          // Load route (departure & arrival)
            'transactions.transactionDetails', // Load existing bookings untuk cek seat availability
        ]);

        // Get available types untuk transportation ini
        $availableTypes = \App\Models\Type::all();

        return view('bookings.index', [
            'schedule' => $schedule,
            'availableTypes' => $availableTypes,
        ]);
    }

    public function listBooking()
    {
        $user = auth()->user();

        if ($user->role === 'pelanggan') {
            $bookings = Transaction::with('schedule', 'user', 'type')
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        } else {
            $bookings = Transaction::with('schedule', 'user', 'type')
                ->latest()
                ->get();
        }

        return view('bookings.list', [
            'bookings' => $bookings,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function payBooking(string $id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('user_id', auth()->user()->id) // pastikan yang bisa cancel cuma dia doang
            ->firstOrFail();

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Hanya pesanan pending yang bisa dibayar.');
        }

        $transaction->update(['status' => 'success']);

        return redirect()->route('bookings.list')->with('success', 'Pembayaran berhasil! Status tiket anda kini sukses');
    }

    public function cancelBooking(string $id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->firstOrFail();

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Pesanan yang sudah diproses tidak bisa dicancel');
        }

        $transaction->update(['status' => 'cancel']);

        return redirect()->route('bookings.list')->with('success', 'Pesanan berhasil dibatalkan.');
    }

    /**
     * Get available seats for AJAX request
     */
    public function getAvailableSeats(Request $request)
    {
        $scheduleId = $request->schedule_id;
        $typeId = $request->type_id;

        $schedule = Schedule::with('transportation')->findOrFail($scheduleId);
        $totalSeats = $schedule->transportation->total_seat;

        // Get booked seats untuk schedule ini (regardless of type)
        $bookedSeats = \App\Models\TransactionDetail::whereHas('transaction', function ($query) use ($scheduleId) {
            $query->where('schedule_id', $scheduleId)
                ->where('status', '!=', 'cancel');
        })->pluck('seat_number')->toArray();

        $availableSeats = [];
        for ($i = 1; $i <= $totalSeats; $i++) {
            $availableSeats[] = [
                'number' => $i,
                'available' => ! in_array($i, $bookedSeats),
            ];
        }

        return response()->json([
            'seats' => $availableSeats,
            'total_seats' => $totalSeats,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'type_id' => 'required|exists:types,id',
            'passengers' => 'required|array|min:1',
            'passengers.*.name' => 'required|string|max:255',
            'passengers.*.phone' => 'required|string|max:20',
            'passengers.*.seat_number' => 'required|integer|min:1',
        ]);

        // Validasi seat availability
        $scheduleId = $request->schedule_id;
        $requestedSeats = collect($request->passengers)->pluck('seat_number')->toArray();

        // Check if any requested seat is already booked
        $bookedSeats = \App\Models\TransactionDetail::whereHas('transaction', function ($query) use ($scheduleId) {
            $query->where('schedule_id', $scheduleId)
                ->where('status', '!=', 'cancel');
        })->whereIn('seat_number', $requestedSeats)->pluck('seat_number')->toArray();

        if (! empty($bookedSeats)) {
            return back()->withErrors([
                'seats' => 'Kursi nomor '.implode(', ', $bookedSeats).' sudah dipesan.',
            ]);
        }

        // Check for duplicate seats in request
        if (count($requestedSeats) !== count(array_unique($requestedSeats))) {
            return back()->withErrors([
                'seats' => 'Tidak boleh memilih kursi yang sama untuk penumpang berbeda.',
            ]);
        }

        // Calculate total amount
        $type = \App\Models\Type::findOrFail($request->type_id);
        $totalAmount = $type->price * count($request->passengers);

        // Generate booking code
        $bookingCode = 'BK'.date('Ymd').str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        // Create transaction
        $transaction = Transaction::create([
            'booking_code' => $bookingCode,
            'user_id' => auth()->id(),
            'schedule_id' => $scheduleId,
            'type_id' => $request->type_id,
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        // Create transaction details for each passenger
        foreach ($request->passengers as $passenger) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'passenger_name' => $passenger['name'],
                'passenger_phone' => $passenger['phone'],
                'seat_number' => $passenger['seat_number'],
            ]);
        }

        return redirect()->route('bookings.list')->with('success', 'Tiket berhasil dipesan! Kode booking: '.$bookingCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bookingDetail = Transaction::with(['user', 'schedule', 'type'])->findOrFail($id);
        $passengers = TransactionDetail::where('transaction_id', $id)->get();

        return view('bookings.show', [
            'bookingDetail' => $bookingDetail,
            'passengers' => $passengers,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
