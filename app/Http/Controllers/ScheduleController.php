<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Schedule;
use App\Models\Transportation;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listSchedule = Schedule::all();

        return view('schedules.index', [
            'schedules' => $listSchedule,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $routeList = Route::all();
        $transportationList = Transportation::all();

        return view('schedules.create', [
            'transportations' => $transportationList,
            'routes' => $routeList,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'transportation_id' => 'required|exists:transportations,id',
            'route_id' => 'required|exists:routes,id',
            'date_departure' => 'required|date|after_or_equal:now', // tanggal dan waktu gabisa lampau. minimal harus sekarang
            'date_arrival' => 'required|date|after:date_departure', // harus setelah departure
            'price' => 'required|numeric|min:0',
        ]);

        Schedule::create($validatedData);

        return redirect()->route('schedules.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        return view('schedules.edit', [
            'schedule' => $schedule,
            'transportations' => Transportation::all(),
            'routes' => Route::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'transportation_id' => 'required|exists:transportations,id',
            'route_id' => 'required|exists:routes,id',
            'date_departure' => 'required|date|after_or_equal:now', // tanggal dan waktu gabisa lampau. minimal harus sekarang
            'date_arrival' => 'required|date|after:date_departure', // harus setelah departure
            'price' => 'required|numeric|min:0',
        ];
        $validatedData = $request->validate($rules);
        Schedule::where('id', $id)->update($validatedData);

        return redirect()->route('schedules.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Schedule::destroy($id);

        return redirect()->route('schedules.index');
    }
}
