<?php
namespace App\Webhook;

use App\Models\Report;
use Illuminate\Support\Facades\Log;

header('Content-Type: application/json; charset=utf-8');

$json = file_get_contents('php://input');
$data = json_decode($json, true);
Log::info('ini response webhook update message whatsapp ', $data);
if(!empty($data)){
    $device = isset($data['device']);
    $id = $data['id'];
    $stateid = $data['stateid'];
    $status= $data['status'];
    $state = $data['state'];

    if(isset($id) && isset($stateid)){
        Report::where('id', $id)->update([
            'status' => $status,
            'state' => $state,
            'stateid' => $stateid
        ]);
    }else if(isset($id) && !isset($stateid)){
        Report::where('id', $id)->update([
            'status' => $status
        ]);
    }else{
        Report::where('stateid', $stateid)->update(['state' => $state]);
    }
}
