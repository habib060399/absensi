<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\CurlController;
use Illuminate\Http\Request;
use App\Models\User;

class RfidController extends Controller
{
    
    public function index()
    {
        //
    }

    
    public function store(Request $request)
    {
        $curl = new CurlController();
        $response = $curl->curlWa();
       $data = User::create([
        'rfid_tag' => $request->rfid_tag
       ]);

       return response()->json([
        'status' => true,
        'message' => 200,
        'response' => $response
       ]);
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
