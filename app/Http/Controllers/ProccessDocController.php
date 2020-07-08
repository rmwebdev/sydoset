<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trx_document;
use App\Trx_doc_pelengkap AS Pelengkap;
use App\trx_doc_pelengkaps_spd AS pelengkap_spd;
use App\mst_doc_pelengkaps AS mst_pelengkap;
use App\Trx_doc_history AS History;
use App\mst_document_status AS mstStatus;
use App\mst_document_types AS mstType;
use App\Trx_documents_spd AS doc_spd;
use App\trx_doc_pelengkap_attribut AS attr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use Log;
use DB;

class ProccessDocController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('role:Admin Settle Finance|Admin Pooling Exim');
    }

    public function indexSPK()
    {
        return view('form.processDokumen.SPK.indexSPK');
    }

    public function indexSPD()
    {
        return view('form.processDokumen.SPD.index');
    }

    public function indexSPKTrailer()
    {
        return view('form.processDokumen.SPK.indexSPKTrailer');
    }

    public function getDatatabel(Request $req)
    {
        $data = DB::table('trx_documents AS doc')
                ->select(DB::raw('row_number() OVER (ORDER BY doc.id desc) AS No'),'doc.*','status_date')
                ->leftJoin(DB::raw("(
                    SELECT * from (
                        SELECT
                        id,
                        document_number,
                        
                        CAST (status_id AS bigint) as status_id,
                        row_number() OVER (PARTITION BY document_number ORDER BY id DESC) AS baris
                    FROM trx_doc_histories) a
                    where a.baris = 1
                ) as hist"), function ($join) {
                    $join->on('hist.document_number','=','doc.number');
                })
                ->leftJoin(DB::raw("(
                    SELECT document_number, status_id, baris, status_date from (
                        SELECT
                        id,
                        document_number,
                        CAST (status_id AS bigint) as status_id,
                        row_number() OVER (PARTITION BY document_number ORDER BY id DESC) AS baris,
                        created_at::date as status_date
                    FROM trx_doc_histories where status_id = '1') b
                    where b.baris = 1
                ) reg"), function ($join) {
                    $join->on('reg.document_number','=','doc.number');
                })
                ->leftJoin('mst_document_status AS stat', 'hist.status_id', 'stat.id')
                ->whereNotNull('doc.last_status')
                ->where('doc.type_id',$req->type)
                // ->where('stat.status_category','finance')
                ->where('stat.status_category', '=', 'finance')
                ->where(function($query) {   // kondisi di last_status
                    return $query->where('last_status', '=', 'pending')
                                    
                        ->orWhere('last_status', '=', 'registration_doc');
                        
                })   
                ->where('doc.openget','get')
                ->orderBy('status_date', 'desc')
                ->get();

        return json_encode($data);
    }

    public function regDocMasuk(Request $req)  
    {
        
        // dd($req->all());

        $doc_number = trim($req->barcode);

        if ($req->$doc_number == '') {
            $notification = array(
                'message' => 'Barcode atau SPK Number wajib diisi salah satu!',
                'alert-type' => 'warning'
            );
        }
            $data = Trx_document::whereRaw("(last_status = 'process_messenger' OR last_status = 'direct')")
                    ->where('type_id',$req->type)->whereRaw("barcode_number = '".$doc_number."' OR kode_arsip = '".$doc_number."' OR number = '".$doc_number."' OR order_number = '".$doc_number."'")->get();
            

        $notif = [
            'stat'=>1,
            'msg'=>'Data di tambakan ke list',
            'data'=>$data
        ];

        if (count($data) == 0) {
            # code...
            $notif = [
                'stat'=>2,
                'msg'=>'Data tidak ditemukan',
                'data'=>[]
            ];
        }

        return $notif;
    }

    public function regDocMasukSPD(Request $req)
    {
        
        // dd($req->all());

        $doc_number = trim($req->barcode);

        if ($req->$doc_number == '') {
            $notification = array(
                'message' => 'Barcode atau SPK Number wajib diisi salah satu!',
                'alert-type' => 'warning'
            );
        }
            $data = doc_spd::whereRaw("(last_status = 'process_messenger' OR last_status = 'direct')")
                    ->whereRaw("barcode_number = '".$doc_number."' OR kode_arsip = '".$doc_number."' OR number = '".$doc_number."' OR order_number = '".$doc_number."'")
                    ->get();
            

        $notif = [
            'stat'=>1,
            'msg'=>'Data di tambakan ke list',
            'data'=>$data
        ];

        if (count($data) == 0) {
            # code...
            $notif = [
                'stat'=>2,
                'msg'=>'Data tidak ditemukan',
                'data'=>[]
            ];
        }

        return $notif;
    }


    public function submitDocFinance(Request $req)
    {
        

        $dataParam = $req->data;

        // dd($dataParam);
        // var_dump($dataParam);exit();die();
        DB::beginTransaction();
        try {
            for ($i=0; $i < count($dataParam); $i++) { 
                # code...
                if ($req->type == 1) {
                    # code...
                    $data = Trx_document::where('number',$dataParam[$i]['doc_number'])
                    ->update([
                        'updated_at'        => 'NOW()',
                        'last_status'       => 'registration_doc',
                        'openget'           => 'get',
                        // 'is_complete'       => 1,
                        'is_reject'         => 0,
                        'updated_by'        => Session::get('nama_user').' '.Session::get('nama_user_last'),
                        'user_pengarsip'    => Session::get('nama_user').' '.Session::get('nama_user_last')
                    ]);
               
                }else {
                    $data = doc_spd::where('number',$dataParam[$i]['doc_number'])
                    ->update([
                        'updated_at'        => 'NOW()',
                        'last_status'       => 'registration_doc',
                        'openget'           => 'get',
                        // 'is_complete'       => 1,
                        'is_reject'         => 0,
                        'updated_by'        => Session::get('nama_user').' '.Session::get('nama_user_last'),
                        'user_pengarsip'    => Session::get('nama_user').' '.Session::get('nama_user_last')
                    ]);
                }
                
                    
                $historyLog = new History;
                $historyLog->document_number = $dataParam[$i]['doc_number'];
                $historyLog->status_id = 10;
                $historyLog->remark = '';
                $historyLog->user_id = Session::get('nama_user').' '.Session::get('nama_user_last');
                $historyLog->save();

            }
            DB::commit();
            Session::flash('message', 'Data berhasil tersimpan');
            Session::flash('alert-type', 'success');
            return response(['stat'=>1,'msg'=>'data berhasil disimpan'], 200);
        } catch (QueryException $ex) {
            DB::rollBack();
            return response($ex->getMessage(), 400);

            }
    }


    public function insertProccessDocSPK($id)
    {
        $base64 = base64_decode($id);
        $dataParam = json_decode($base64);
        $doc_number = $dataParam->number;
        $user_id = $this->getUserId();

        $data = Trx_document::select(DB::raw("
            CASE 
                WHEN UPPER(approved_add_cost_status) = UPPER('buy_cost_mod_approved') THEN 'ADD COST APPROVED'
                WHEN UPPER(approved_add_cost_status) = UPPER('buy_cost_mod_nochange') THEN 'NO ADD COST'
                ELSE UPPER(approved_add_cost_status)
            END AS addcost,
            CASE 
            WHEN UPPER(prepayment_status) = UPPER('advance_paid') THEN 'PREPAYMENT PAID'
            WHEN UPPER(prepayment_status) = UPPER('advance_settled') THEN 'PREPAYMENT SETTLE'
            WHEN UPPER(prepayment_status) = UPPER('advance_not_paid') THEN 'UNPAID'
            WHEN UPPER(prepayment_status) = UPPER('advance_sent_to_orafin') THEN 'PREPAYMENT SENT TO ERP'
            WHEN UPPER(prepayment_status) = UPPER('advance_imported') THEN 'IMPORTED'
            WHEN UPPER(prepayment_status) = UPPER('advance_cancelled') THEN 'CANCEL'
            WHEN UPPER(prepayment_status) = UPPER('advance_not_sent_to_orafin') THEN 'NEW'
            WHEN UPPER(prepayment_status) = UPPER('advance_not_paid') AND updated_at IS NOT NULL THEN 'NEW'
            END AS payment_status, *
        "))->where('number',$doc_number)->get();
        $dataDetail = DB::table('trx_doc_pelengkaps')->select(DB::raw('distinct projects_id,document_number'))->where('document_number',$doc_number)->first();
        $dataDetailAttr = DB::table('trx_doc_pelengkap_attributs')->select(DB::raw('distinct projects_id,document_number'))->where('document_number',$doc_number)->first();
        $mstProject = [];
        $reasonType = DB::table('mst_reason')->get();
        if ($dataDetail) {
            # code...
            $mstProject = DB::table('mst_projects')
                        ->select('id','name as project_name')
                        ->where('id',$dataDetail->projects_id)
                        ->get();
        }
        

        if (count($data)==0) {
            # code...
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning'
            );
            return Redirect::to('regDocSPK')->with($notification);
        }

        if ($dataDetail != '') {
            $verified = $dataDetail->projects_id;
        } else {
            $verified = 'null';
        }

        if ($dataDetailAttr != '') {
            $verifiedAttr = $dataDetailAttr->projects_id;
        } else {
            $verifiedAttr = 'null';
        }

        

        return view('form.processDokumen.SPK.insertProccessDocSPK',
        [
            'data'=>$data,
            'mstProject' => $mstProject,
            'verified' => $verified,
            'verifiedAttr' => $verifiedAttr,
            'type'=>$dataParam->type,
            'reasonType'=>$reasonType
        ]);
    }

    public function addOpenDoc(Request $req)
    {
        if ($req->type == 3) {
            $data = DB::table('trx_documents_spd AS doc')
                ->leftJoin(DB::raw("(
                    SELECT * from (
                        SELECT
                        id,
                        document_number,
                        CAST (status_id AS bigint) as status_id,
                        row_number() OVER (PARTITION BY document_number ORDER BY id DESC) AS baris
                    FROM trx_doc_histories) a
                    where a.baris = 1
                ) as hist"), function ($join) {
                    $join->on('hist.document_number','=','doc.number');
                })
                ->leftJoin('mst_document_status AS stat', 'hist.status_id', 'stat.id')
                ->whereNotNull('doc.last_status')
                ->where('doc.barcode_number', $req->barcode)
                ->where('stat.status_category','finance')
                ->where('doc.openget','get')
                ->where('doc.last_status','processing_doc')->get();
        } else {
            $data = DB::table('trx_documents AS doc')
                ->leftJoin(DB::raw("(
                    SELECT * from (
                        SELECT
                        id,
                        document_number,
                        CAST (status_id AS bigint) as status_id,
                        row_number() OVER (PARTITION BY document_number ORDER BY id DESC) AS baris
                    FROM trx_doc_histories) a
                    where a.baris = 1
                ) as hist"), function ($join) {
                    $join->on('hist.document_number','=','doc.number');
                })
                ->leftJoin('mst_document_status AS stat', 'hist.status_id', 'stat.id')
                ->whereNotNull('doc.last_status')
                ->where('doc.type_id',$req->type)
                ->where('stat.status_category','finance')
                ->where('doc.openget','get')
                ->where('doc.last_status','processing_doc')
                ->where('barcode_number', $req->barcode)
                ->get();
            // $data = Trx_document::where('barcode_number', $req->barcode)->where('last_status','settle_operation')->get();
        }
        

        $notif = [
            'stat'=>1,
            'msg'=>'Data ditemukan',
            'data'=>$data
        ];

        if (count($data) == 0) {
            # code...
            $notif = [
                'stat'=>2,
                'msg'=>'Data tidak ditemukan',
                'data'=>[]
            ];
        }

        return $notif;
    }

    public function submitOpenDocument(Request $req)
    {
        $dataParam = $req->data;
        // var_dump($dataParam);exit();die();
        DB::beginTransaction();
        try {
            for ($i=0; $i < count($dataParam); $i++) { 
                # code...
                if ($req->type == 1) {
                    # code...
                    $data = Trx_document::where('number',$dataParam[$i]['doc_number'])
                    ->update([
                        'updated_at'        => 'NOW()',
                        'last_status'       => 'settle_operation',
                        'openget'           => 'open',
                        // 'is_complete'       => 1,
                        'is_reject'         => 0,
                        'updated_by'        => Session::get('nama_user').' '.Session::get('nama_user_last'),
                        'user_pengarsip'    => Session::get('nama_user').' '.Session::get('nama_user_last')
                    ]);
                } else {
                    $data = doc_spd::where('number',$dataParam[$i]['doc_number'])
                    ->update([
                        'updated_at'        => 'NOW()',
                        'last_status'       => 'settle_operation',
                        'openget'           => 'open',
                        // 'is_complete'       => 1,
                        'is_reject'         => 0,
                        'updated_by'        => Session::get('nama_user').' '.Session::get('nama_user_last'),
                        'user_pengarsip'    => Session::get('nama_user').' '.Session::get('nama_user_last')
                    ]);
                }
                
                    
                $historyLog = new History;
                $historyLog->document_number = $dataParam[$i]['doc_number'];
                $historyLog->status_id = 13;
                $historyLog->remark = '';
                $historyLog->user_id = Session::get('nama_user').' '.Session::get('nama_user_last');
                $historyLog->save();
            }
            DB::commit();
            Session::flash('message', 'Data berhasil tersimpan');
            Session::flash('alert-type', 'success');
            return response(['stat'=>1,'msg'=>'data berhasil disimpan'], 200);
        } catch (QueryException $ex) {
            DB::rollBack();
            return response($ex->getMessage(), 400);
        }
    }

    public function actionKembalikan(Request $req)
    {
        $dataParam = json_decode($req->dataParam);

        // dd($req->all());
        
        if ($req->type == 1) {
            DB::beginTransaction();
            try {
                foreach ($dataParam as $key => $value) {
                    # code...
                    $data = Trx_document::where('number',$value->doc_number)
                        ->update([
                            'updated_at' => 'NOW()',
                            'last_status' => 'reject_doc',
                            'openget' => 'open',
                            'catatan' => $req->catatan,
                            'is_reject' => 1,
                            'updated_by' => Session::get('nama_user').' '.Session::get('nama_user_last')
                        ]);
                        
                    $historyLog = new History;
                    $historyLog->document_number = $value->doc_number;
                    $historyLog->status_id = 14;
                    $historyLog->remark = $req->catatan;
                    $historyLog->user_id = Session::get('nama_user').' '.Session::get('nama_user_last');
                    $historyLog->save();
                }

                DB::commit();
                return response(['stat'=>1,'msg'=>'data berhasil disimpan'], 200);
            } catch (QueryException $ex) {
                DB::rollBack();
                return response($ex->getMessage(), 400);
            }
        } else if ($req->type == 2){
            DB::beginTransaction();
            try {
                // return $dataParam;
                foreach ($dataParam as $key => $value) {
                    # code...
                    $data = doc_spd::where('number',$value->doc_number)
                        ->update([
                            'updated_at' => 'NOW()',
                            'last_status' => 'reject_doc',
                            'openget' => 'open',
                            'catatan' => $req->catatan,
                            'is_reject' => 1
                        ]);
                        
                    $historyLog = new History;
                    $historyLog->document_number = $value->doc_number;
                    $historyLog->status_id = 14;
                    $historyLog->remark = $req->catatan;
                    $historyLog->user_id = Session::get('nama_user').' '.Session::get('nama_user_last');
                    $historyLog->save();
                }

                DB::commit();
                return response(['stat'=>1,'msg'=>'data berhasil disimpan'], 200);
            } catch (QueryException $ex) {
                DB::rollBack();
                return response($ex->getMessage(), 400);
            }
        }
        
    }

    public function getHistory(Request $req)
    {
        $data = DB::table('trx_doc_histories AS hist')->select('hist.id','hist.document_number','hist.created_at','hist.remark','user_id','sts.status_name')
        ->leftJoin('mst_document_status AS sts', DB::raw('CAST(hist.status_id AS bigint)'), 'sts.id')
        ->where('document_number', $req->number)->orderBy('hist.id','desc')->get();

        return json_encode($data);
    }

    public function getDataAttr(Request $req)
    {
        $user_id = $this->getUserId();
        $data = DB::table('trx_doc_pelengkap_attributs')
                ->where('document_number', $req->number)
                ->where('is_delete','false')
                ->get();
        

        return json_encode($data);
    }

    public function getDataKelengkapan(Request $req)
    {
        $user_id = $this->getUserId();
        if ($req->project == 'inserted') {
            $data = Pelengkap::where('document_number', $req->number)->where('is_delete','false')->get();    
        } else {
            $data = DB::table('doc_pelengkap_settings AS set')
                        ->select('doc.id AS id_doc','doc.name AS doc_pelengkap_name')
                        ->leftJoin('mst_doc_pelengkaps AS doc','doc.id',DB::raw('CAST(set.doc_pelengkap_id AS bigint)'))
                        ->where('set.user_id',$user_id)
                        ->where('set.projects_id',$req->project)
                        ->get();
        }
        

        return json_encode($data);
    }

    public function submitProcessDoc(Request $req)
    {

        $doc_number = $req->doc_number;
        $complete = 0;
        if ($req->kelengkapan == 'lengkap') {
            $complete = 1;
        }

        if ($req->type == 'SETTLE') {
            $last_status = 'settle_operation';
            $openGet = 'get';
        } else if ($req->type == 'PENDING') {
            $last_status = 'pending';
            $openGet = 'get';
        }

        

        DB::beginTransaction();
        try {
            $data = Trx_document::where('number',$doc_number)
                    ->update([
                        'last_status' => $last_status,
                        'openget' => $openGet,
                        'is_complete' => $complete,
                        'catatan' => $req->catatan,
                        'updated_at' => 'NOW()',
                        'is_reject'         => 0,
                        'updated_by'        => Session::get('nama_user').' '.Session::get('nama_user_last'),
                        'user_pengarsip'    => Session::get('nama_user').' '.Session::get('nama_user_last')
                    ]);
            
            if (isset($req->dataKelengkapan)) {
                foreach ($req->dataKelengkapan as $key => $value) {
                    $mstType = mstType::where('id',2)->first();
                    $dataDetailUpdate = Pelengkap::where('id',$value['id'])
                                        ->update([
                                            'doc_pelengkap_name' => strtoupper($value['jenis_doc']),
                                            'type_id' => $mstType->id,
                                            'projects_id' => $req->kel_doc,
                                            'document_number' => $doc_number,
                                            'tanggal_dokumen' => $value['tanggal_doc'],
                                            // 'nilai' => $value['nilai_doc'],
                                            'is_exist' => $value['isExist'],
                                            'remark' => $value['remark_doc']
                                        ]);
                }
            }

            if (isset($req->dataAttribut)) {
                foreach ($req->dataAttribut as $key2 => $value2) {
                    if (empty($value2['attribut_id'])) {
                        # code...
                        $dataAttr = new attr;
                        $dataAttr->document_number = $doc_number;
                        $dataAttr->projects_id = $req->projectAttr;
                        $dataAttr->attribut = $value2['attribut'];
                        $dataAttr->label = $value2['attribut_label'];
                        // $dataAttr->value = $value2['attribut_value'];
                        $dataAttr->date = $value2['attribut_date'];
                        $dataAttr->remark = $value2['attribut_remark'];
                        $dataAttr->save();
                    } else {
                        $dataAttrUpdate = attr::where('id',$value2['attribut_id'])
                                            ->update([
                                                'projects_id' => $req->projectAttr,
                                                'attribut' => $value2['attribut'],
                                                'label' => $value2['attribut_label'],
                                                // 'value' => $value2['attribut_value'],
                                                'date' => $value2['attribut_date'],
                                                'remark' => $value2['attribut_remark']
                                            ]);
                    }
                }
            }
            
            $mstStatus = DB::table('mst_document_status')->where('status_name',$last_status)->where('status_category','finance')->get();


            

            $historyLog = new History;
            $historyLog->document_number = $doc_number;
            $historyLog->status_id = $mstStatus[0]->id;
            $historyLog->remark = $req->catatan;
            $historyLog->user_id = Session::get('nama_user').' '.Session::get('nama_user_last');
            $historyLog->save();

            DB::commit();
            Session::flash('message', 'Data berhasil settlement');
            Session::flash('alert-type', 'success');
            return response(['stat'=>1,'msg'=>'Data berhasil settlement'], 200);
        } catch (QueryException $ex) {
            DB::rollBack();
            return response($ex->getMessage(), 400);
        }
    }


    public function getDatatabelSPD(Request $req)
    {
        $data = DB::table('trx_documents_spd AS doc')
         ->select(DB::raw('row_number() OVER (ORDER BY doc.id desc) AS No, coalesce(to_char(doc.approve_spd_date, \'dd Mon YYYY\'), \'-\') As approve_date_formated'),'doc.*','status_date')
                ->leftJoin(DB::raw("(
                    SELECT * from (
                        SELECT
                        id,
                        document_number,
                        CAST (status_id AS bigint) as status_id,
                        row_number() OVER (PARTITION BY document_number ORDER BY id DESC) AS baris
                    FROM trx_doc_histories) a
                    where a.baris = 1
                ) as hist"), function ($join) {
                    $join->on('hist.document_number','=','doc.number');
                })
                ->leftJoin(DB::raw("(
                    SELECT document_number, status_id, baris, status_date from (
                        SELECT
                        id,
                        document_number,
                        CAST (status_id AS bigint) as status_id,
                        row_number() OVER (PARTITION BY document_number ORDER BY id DESC) AS baris,
                        created_at::date as status_date
                    FROM trx_doc_histories where status_id = '1') b
                    where b.baris = 1
                ) reg"), function ($join) {
                    $join->on('reg.document_number','=','doc.number');
                })


                ->leftJoin('mst_document_status AS stat', 'hist.status_id', 'stat.id')
                ->whereNotNull('doc.last_status')
                ->where('stat.status_category', '=', 'finance')
                ->where(function($query) {   // kondisi di last_status
                    return $query->where('last_status', '=', 'pending')
                                    
                        ->orWhere('last_status', '=', 'registration_doc');
                        
                })   
                ->where('doc.openget','get')
                ->orderBy('status_date', 'desc')
                ->get();

        return json_encode($data);
    }

    public function searchSPD(Request $req)
    {
        $doc_number = trim($req->domain.$req->numbering);

        if ($req->barcodeSearch == '' && $doc_number == '') {
            $notification = array(
                'message' => 'Barcode atau SPK Number wajib diisi salah satu!',
                'alert-type' => 'warning'
            );
            return Redirect::to('procesDocSPD')->with($notification);
        }

        $notification = array(
            'message' => 'Dokumen berhasil diterima',
            'alert-type' => 'success'
        );
        // var_dump($doc_number);

        $dataCheck = DB::table('trx_documents_spd AS doc')
                ->select(DB::raw('row_number() OVER (ORDER BY doc.id desc) AS No'),'doc.*')
                ->leftJoin(DB::raw("(
                    SELECT * from (
                        SELECT
                        id,
                        document_number,
                        CAST (status_id AS bigint) as status_id,
                        row_number() OVER (PARTITION BY document_number ORDER BY id DESC) AS baris
                    FROM trx_doc_histories) a
                    where a.baris = 1
                ) as hist"), function ($join) {
                    $join->on('hist.document_number','=','doc.number');
                })
                ->leftJoin('mst_document_status AS stat', 'hist.status_id', 'stat.id')
                ->whereNotNull('doc.last_status')
                ->where('stat.status_category','finance')
                ->where('doc.openget','get');
        if ($doc_number != '' && $req->barcodeSearch == '') {
            $dataCheck = $dataCheck->where('number',$doc_number)->get();
        } else if ($doc_number == '' && $req->barcodeSearch != '') {
            # code...
            $dataCheck = $dataCheck->where('barcode_number', $req->barcodeSearch)->get();
        } else {
            $dataCheck = [];
        }

        if (count($dataCheck)>0) {
            # code...
            $notification = array(
                'message' => 'Data sudah ada dilist!',
                'alert-type' => 'warning'
            );
            return Redirect::to('procesDocSPD')->with($notification);
        }

        try {
            $data = doc_spd::whereRaw("(last_status = 'process_messenger' OR last_status = 'direct')");
            if ($doc_number != '' && $req->barcodeSearch == '') {
                $data = $data->where('number',$doc_number)->get();
            } else if ($doc_number == '' && $req->barcodeSearch != '') {
                # code...
                $data = $data->where('barcode_number', $req->barcodeSearch)->get();
            } else {
                $data = [];
            }

            // var_dump($data[0]->number);exit();die();

            if (count($data)==0) {
                # code...
                $notification = array(
                    'message' => 'Data tidak ditemukan!',
                    'alert-type' => 'warning'
                );
                return Redirect::to('procesDocSPD')->with($notification);
            }

            //insert history terima document
            DB::beginTransaction();
            try {
                if ($doc_number != '') {
                    # code...
                    $dataUpdate = doc_spd::where('number',$doc_number)
                        ->update([
                            'last_status' => 'registration_doc',
                            'openget' => 'get',
                            // 'is_complete' => true,
                            'updated_at' => 'NOW()',
                            'updated_by' => Session::get('nama_user').' '.Session::get('nama_user_last')
                        ]);
                } else if ($req->barcodeSearch != '') {
                    $dataUpdate = doc_spd::where('barcode_number',$req->barcodeSearch)
                        ->update([
                            'last_status' => 'registration_doc',
                            'openget' => 'get',
                            // 'is_complete' => true,
                            'updated_at' => 'NOW()',
                            'updated_by' => Session::get('nama_user').' '.Session::get('nama_user_last')
                        ]);
                }
                

                $historyLog = new History;
                $historyLog->document_number = $data[0]->number;
                $historyLog->status_id = 10;
                $historyLog->remark = '';
                $historyLog->user_id = Session::get('nama_user').' '.Session::get('nama_user_last');
                $historyLog->save();
                
                DB::commit();
                return Redirect::to('procesDocSPD')->with($notification);
            } catch (QueryException $ex) {
                DB::rollBack();
                Log::info($ex->getMessage());
                $notification = array(
                    'message' => 'Something went wrong!',
                    'alert-type' => 'error'
                );
                return Redirect::to('procesDocSPD')->with($notification);
            }

            return Redirect::to('procesDocSPD')->with($notification);
        } catch (QueryException $ex) {
            //throw $th;
            Log::info($ex->getMessage());
            $notification = array(
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            );
            return Redirect::to('procesDocSPD')->with($notification);

        }
    }

    public function insertProcessDocSPD($id)
    {
        $base64 = base64_decode($id);
        $dataParam = json_decode($base64);
        $doc_number = $dataParam->number;
        $user_id = $this->getUserId();
        // var_dump($user_id);

        $data = doc_spd::select(DB::raw("REPLACE (amount, ',', '') as amount_no_comma,*
        "))->where('number',$doc_number)->get();
        $dataDetail = DB::table('trx_doc_pelengkaps_spd')->select(DB::raw('id,container,trx_doc_pelengkaps_spd,fleet,type,container_pengganti,nilai_kuitansi,is_available'))->where('trx_documents_spd_number',$doc_number)->get();
        $mstProject = DB::table('doc_pelengkap_settings AS set')
                        ->select('prj.id','prj.name AS project_name')->distinct()
                        ->leftJoin('mst_projects AS prj','prj.id',DB::raw('CAST(set.projects_id AS bigint)'))
                        ->where('set.user_id',$user_id)
                        ->get();
        $dataDetailAttr = DB::table('trx_doc_pelengkap_attributs')->select(DB::raw('distinct projects_id,document_number, created_at'))->orderBy('created_at','desc')->where('document_number',$doc_number)->first();
        

        if (count($data)==0) {
            # code...
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning'
            );
            return Redirect::to('indexSPD')->with($notification);
        }

        if ($dataDetailAttr != '') {
            $verified = $dataDetailAttr->projects_id;
        } else {
            $verified = 'null';
        }

        return view('form.processDokumen.SPD.insertDocSPD',
        [
            'data'=>$data,
            'dataDetail' => $dataDetail,
            'count_container' => count($dataDetail),
            'mstProject' => $mstProject,
            'verified' => $verified
        ]);
    }

    public function getDataContainer(Request $req)
    {
        $user_id = $this->getUserId();
        // if ($req->project == 'inserted') {
            $data = DB::table('trx_doc_pelengkaps_spd')->select(DB::raw('id,container,trx_doc_pelengkaps_spd AS number,fleet,type,container_pengganti,nilai_kuitansi,is_available'))->where('trx_documents_spd_number',$req->number)->get();
        // } else {
        //     $data = DB::table('doc_pelengkap_settings AS set')
        //                 ->select('doc.id AS id_doc','doc.name AS doc_pelengkap_name')
        //                 ->leftJoin('mst_doc_pelengkaps AS doc','doc.id',DB::raw('CAST(set.projects_id AS bigint)'))
        //                 ->where('set.user_id',$user_id)
        //                 ->where('set.projects_id',$req->project)
        //                 ->get();
        // }
        

        return json_encode($data);
    }

    public function submitProcessDocSPD(Request $req)
    {
        $doc_number = $req->doc_number;
        // var_dump($req->all());exit();die();
        $complete = 0;
        if ($req->kelengkapan == 'lengkap') {
            $complete = 1;
        }

        if ($req->type == 'SETTLE') {
            $last_status = 'settle_operation';
            $openGet = 'get';
        } else if ($req->type == 'PENDING') {
            $last_status = 'pending';
            $openGet = 'get';
        }
        DB::beginTransaction();
        try {
            $data = doc_spd::where('number',$doc_number)
                    ->update([
                        'last_status' => $last_status,
                        'openget' => $openGet,
                        'is_complete' => $complete,
                        'updated_at' => 'NOW()',
                        'catatan' => $req->catatan,
                        'is_bundle' => $req->bundle_kwit,
                        'selisih_tipe' => $req->selisih_tipe,
                        'is_reject'         => 0,
                        'updated_by'        => Session::get('nama_user').' '.Session::get('nama_user_last'),
                        'user_pengarsip'    => Session::get('nama_user').' '.Session::get('nama_user_last')
                    ]);
            
            if (isset($req->dataKelengkapan)) {
                # code...
                foreach ($req->dataKelengkapan as $key => $value) {
                    $dataDetail = new pelengkap_spd;
                    if (empty($value['id'])) {
                        # code...
                        $dataDetail->type = $value['type'];
                        $dataDetail->container = $value['container'];
                        $dataDetail->trx_documents_spd_number = $doc_number;
                        $dataDetail->fleet = $value['panjang'];
                        $dataDetail->container_pengganti = $value['container_pengganti'];
                        $dataDetail->is_available = $value['isExist'];
                        // $dataDetail->nilai_kuitansi = $value['jml_kwt'];
                        // $dataDetail->user_id = Session::get('nama_user').' '.Session::get('nama_user_last');
                        $dataDetail->save();
                    } else {
                        $dataDetailUpdate = pelengkap_spd::where('id',$value['id'])
                                            ->update([
                                                'container' => strtoupper($value['container']),
                                                'type' => $value['type'],
                                                'fleet' => $value['panjang'],
                                                'container_pengganti' => $value['container_pengganti'],
                                                // 'nilai_kuitansi' => $value['jml_kwt'],
                                                'is_available' => $value['isExist']
                                            ]);
                    }
                }
            }

            if (isset($req->dataAttribut)) {
                foreach ($req->dataAttribut as $key2 => $value2) {
                    if (empty($value2['attribut_id'])) {
                        # code...
                        $dataAttr = new attr;
                        $dataAttr->document_number = $doc_number;
                        $dataAttr->projects_id = $req->kel_doc_attr;
                        $dataAttr->attribut = $value2['attribut'];
                        $dataAttr->label = $value2['attribut_label'];
                        // $dataAttr->value = $value2['attribut_value'];
                        $dataAttr->date = $value2['attribut_date'];
                        $dataAttr->remark = $value2['attribut_remark'];
                        $dataAttr->save();
                    } else {
                        $dataAttrUpdate = attr::where('id',$value2['attribut_id'])
                                            ->update([
                                                'projects_id' => $req->kel_doc_attr,
                                                'attribut' => $value2['attribut'],
                                                'label' => $value2['attribut_label'],
                                                // 'value' => $value2['attribut_value'],
                                                'date' => $value2['attribut_date'],
                                                'remark' => $value2['attribut_remark']
                                            ]);
                    }
                }
            }
            
            $mstStatus = DB::table('mst_document_status')->where('status_name',$last_status)->where('status_category','finance')->first();

            $historyLog = new History;
            $historyLog->document_number = $doc_number;
            $historyLog->status_id = $mstStatus->id;
            $historyLog->remark = $req->catatan;
            $historyLog->user_id = Session::get('nama_user').' '.Session::get('nama_user_last');
            $historyLog->save();

            DB::commit();
            Session::flash('message', 'Data berhasil settlement');
            Session::flash('alert-type', 'success');
            return response(['stat'=>1,'msg'=>'Data berhasil settlement'], 200);
        } catch (QueryException $ex) {
            DB::rollBack();
            return response($ex->getMessage(), 400);
        }
    }

    private function getUserId(){
        $user       = base64_decode(Session::get('token'));
        $user_id    = json_decode($user);

        return $user_id->key_1;
    }
}
