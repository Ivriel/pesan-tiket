<?php

namespace App\Http\Controllers;

use App\Models\Transportation;
use App\Models\Type;
use Illuminate\Http\Request;

class TransportationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transportationList = Transportation::with('type')->get();
        return view('transportations.index',[
            'transportationList' => $transportationList
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listType = Type::all();
        return view('transportations.create',[
            'listType' => $listType
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'total_seat' => 'required|integer|min:1',
            'type_id' => 'required|exists:types,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = null;
        if($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('transportations','public');
        }

        Transportation::create([
            'name' => $request->name,
            'code' => $request->code,
            'total_seat' => $request->total_seat,
            'type_id' => $request->type_id,
            'image'=> $imagePath
        ]);

        return redirect()->route('transportations.index');

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
    public function edit(Transportation $transportation)
    {
        return view('transportations.edit',[
            'transportation' => $transportation,
            'listType' => Type::all()
        ]);
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
        Transportation::destroy($id);
        return redirect()->route('transportations.index');
    }
}
