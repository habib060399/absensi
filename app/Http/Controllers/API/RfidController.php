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
        $user = new User();
        $curl = new CurlController();

        $getUser = $user->getUser($request->rfid_tag);

        if($getUser){
            return response()->json([
                'status' => 'Name tag telah terdeteksi',
                'message' => 200,                
               ]);
        }else{
            $data = User::create([
             'rfid_tag' => $request->rfid_tag
            ]);
     
            return response()->json([
             'status' => 'Name tag berhasil ditambahkan ke database',
             'message' => 200,
             'response' => $response
            ]);
        }        
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
