<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trx_document;
use App\Trx_documents_spd;
use Log;
use DB;
class StatusDokumenController extends Controller
{
    //
    public function index(Request $request){
        return view('form.statusDoc.index');
    }
    public function getDatatableSPKSPD(Request $request)
    {
        $spk = DB::table('trx_documents AS spk')
                ->select('number','driver_name','driver_id','customer','last_status','created_at')
                ->where('last_status','=','registration_doc')
                ->orWhere('last_status','=','barcode_belum_pairing')
                ->get();
        $spd = DB::table('trx_documents_spd AS spd')
                ->select('number','driver_name','driver_id','customer_name AS customer','last_status','created_at')
                ->where('last_status','=','registration_doc')
                ->orWhere('last_status','=','barcode_belum_pairing')
                ->get();
        $data = array_merge($spk->toArray(),$spd->toArray());
        $sortdata = collect($data)->sortBy('created_at')->values()->all();
        //print_r ($sortdata);
        return json_encode($sortdata);

    }
}
