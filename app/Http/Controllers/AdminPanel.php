<?php

namespace App\Http\Controllers;

use App\Models\TgGroup;
use Illuminate\Http\Request;

class AdminPanel extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['groups'] = TgGroup::all();

        return view('adminpanel/adminpanel', ['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $base = TgGroup::find($id);
        $base->update($request->all());
        return $base;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
