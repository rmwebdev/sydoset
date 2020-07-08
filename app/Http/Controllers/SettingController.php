<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\mst_messenger;

class SettingController extends Controller
{
    
    
    public function General()
    {
        return view('form.Settings.master_setting.general');
    }
    
    
    public function Validasi()
    {
        return view('form.Settings.master_setting.validasi');
    }
    
    
    public function masterDoc()
    {
        return view('form.Settings.master_setting.master_document');
    }
    
    public function addMsg()
    {
        return view('form.Settings.master_msg.index');
    }

    public function loadDataMsg()
    {
            $dataMsg = mst_messenger::orderBy('id', 'desc')->get();

            $data = array();
            foreach($dataMsg as $q => $value){
                array_push($data,[
                    'no' => $q+1,
                    'id'=> $value->id,
                    'noNpk'=>$value->npk,
                    'nama'=>$value->nama,
                    'no_hp'=>$value->NoHP,
                    'status'=>$value->status
                ]);
            }

        return json_encode($data); 

    }
    public function addDataMsg(Request $request)
    {
        $msg = new mst_messenger;

        $msg->npk = $request->input('noNpk');
        $msg->nama = $request->input('namaMsg');
        $msg->NoHP = $request->input('nohpMsg');
        $msg->status = $request->status;

        $msg->save();
    }

    public function editDataMsg(Request $request)
    {
        $msg = mst_messenger::find($request->id);

        $msg->npk = $request->input('noNpk');
        $msg->nama = $request->input('namaMsg');
        $msg->NoHP = $request->input('nohpMsg');
        $msg->status = $request->status;

        $msg->save();

        
    }

    public function deleteDataMsg($id)
    {
        $msg = mst_messenger::find($id);

        $msg->delete();
        return $msg;
    }
}
