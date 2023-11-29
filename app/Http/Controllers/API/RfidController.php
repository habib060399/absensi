<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
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
        $modelUser = new User();
        $controllerUser = new UserController();
        $curl = new CurlController();

        $getUser = $modelUser->getUser($request->rfid_tag);

        if($getUser){
            $controllerUser->cekAbsensi($request->rfid_tag);
            
        }else{
            $data = User::create([
             'rfid_tag' => $request->rfid_tag
            ]);
     
            return response()->json([
             'status' => 'Name tag berhasil ditambahkan ke database',
             'message' => 200,            
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
