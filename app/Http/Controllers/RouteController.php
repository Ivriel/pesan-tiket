<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $routeList = Route::all();
        return view('routes.index',[
            'listRoute' =>$routeList
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('routes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'departure' => 'required|string',
            'arrival' => 'required|string'
        ]);

        Route::create($validatedData);
        return redirect()->route('routes.index');
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
    public function edit(Route $route)
    {
        return view('routes.edit',[
            'route'=>$route
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'departure' => 'required|string',
            'arrival' => 'required|string'
        ];
        $validatedData = $request->validate($rules);
        Route::where('id',$id)->update($validatedData);

        return redirect()->route('routes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Route::destroy($id);
        return redirect()->route('routes.index');
    }
}
