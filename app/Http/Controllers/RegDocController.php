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

class RegDocController extends Controller
{
    //Register Document SPK 
    public function __construct()
    {
        $this->middleware('role:Admin Operation Exim|Admin Settle Operation|Admin Pooling Exim');
    }
    
    public function regDocSPK()
    {
        return view('form.registerDokumen.SPK.index');
    }

    public function regDocSPKTrailer()
    {
        return view('form.registerDokumen.SPK.indexTrailer');
    }

    public function getDatatableSPK(Request $req)
    {
        // $type = $req->type;
        // var_dump('test');exit();die();
        if (Session::get('role') == 'Admin Pooling Exim') {
            $data = DB::table('trx_documents AS doc')
                ->select(DB::raw('row_number() OVER (ORDER BY doc.id desc) AS No'),'doc.*','status_date')
                ->leftJoin(DB::raw("(
                    SELECT document_number, status_id, baris from (
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
                ->whereRaw("doc.last_status not in ('registration_doc','barcode_belum_pairing')")
                ->where('doc.type_id',$req->type)
                ->where('stat.status_category','admin')
                ->where('doc.openget','get')
                ->orderBy('id', 'desc')
                ->get();
            return json_encode($data);
        }

        $data = DB::table('trx_documents AS doc')
                ->select(DB::raw('row_number() OVER (ORDER BY doc.id desc) AS No'),'doc.*','status_date')
                ->leftJoin(DB::raw("(
                    SELECT document_number, status_id, baris from (
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
                ->where('stat.status_category','admin')
                ->where('doc.openget','get')
                ->orderBy('id', 'desc')
                ->get();

        return json_encode($data);
    }

    public function getSPKNumber(Request $req)
    {
        $search = $req->search;
        $domain = $req->domain;
        $data = Trx_document::select(DB::raw("distinct ON (number) number, substring(number from '.........$') as text, id"))
                ->whereRaw("REPLACE(number, substring(number from '.........$'), '' ) = '".$domain."' AND substring(number from '.........$') ilike '%".$search."%'")
                ->where('type_id',$req->type)
                ->get();

        
        return $data;
    }

    public function searchSPK(Request $req)
    {
        $doc_number = trim($req->numbering);
        // return $doc_number;

        $notification = array(
            'message' => 'Dokumen berhasil diterima',
            'stat' => 'success'
        );

        try {
            //code...
            $data = Trx_document::where('number',$doc_number)->where('type_id',$req->type)->get();
            // return $data;

            if (count($data)==0) {
                # code...
                $notification = array(
                    'message' => 'Data tidak ditemukan!',
                    'stat' => 'warning'
                );
                if($req->type == 1){
                    return $notification;//Redirect::to('regDocSPK')->with($notification);
                } else if($req->type == 2){
                    return $notification;//Redirect::to('regDocSPKTrailer')->with($notification);
                }
                
            }

            //insert history terima document
            DB::beginTransaction();
            try {
                $dataUpdate = Trx_document::where('number',$doc_number)
                        ->update([
                            'last_status' => 'registration_doc',
                            'openget' => 'get',
                            // 'is_complete' => false,
                            'updated_at' => 'NOW()',
                            'updated_by' => Session::get('nama_user').' '.Session::get('nama_user_last')
                        ]);

                $historyLog = new History;
                $historyLog->document_number = $doc_number;
                $historyLog->status_id = 1;
                $historyLog->remark = '';
                $historyLog->user_id = Session::get('nama_user').' '.Session::get('nama_user_last');
                $historyLog->save();

                
                
                DB::commit();
                if($req->type == 1){
                    return $notification;//Redirect::to('regDocSPK')->with($notification);
                } else if($req->type == 2){
                    return $notification;//Redirect::to('regDocSPKTrailer')->with($notification);
                }
            } catch (QueryException $ex) {
                DB::rollBack();
                Log::info($ex->getMessage());
                $notification = array(
                    'message' => 'Something went wrong!',
                    'stat' => 'error'
                );
                if($req->type == 1){
                    return $notification;//Redirect::to('regDocSPK')->with($notification);
                } else if($req->type == 2){
                    return $notification;//Redirect::to('regDocSPKTrailer')->with($notification);
                }
            }

            if($req->type == 1){
                return $notification;//Redirect::to('regDocSPK')->with($notification);
            } else if($req->type == 2){
                return $notification;//Redirect::to('regDocSPKTrailer')->with($notification);
            }
        } catch (QueryException $ex) {
            //throw $th;
            Log::info($ex->getMessage());
            $notification = array(
                'message' => 'Something went wrong!',
                'stat' => 'error'
            );
            if($req->type == 1){
                return $notification;//Redirect::to('regDocSPK')->with($notification);
            } else if($req->type == 2){
                return $notification;//Redirect::to('regDocSPKTrailer')->with($notification);
            }

        }
        
    }
    
    public function insertDocSPK($id)
    {
        $base64 = base64_decode($id);
        $dataParam = json_decode($base64);
        $doc_number = $dataParam->number;
        $user_id = $this->getUserId();
        // var_dump($user_id);

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
        $mstProject = DB::table('doc_pelengkap_settings AS set')
                        ->select('prj.id','prj.name AS project_name')->distinct()
                        ->leftJoin('mst_projects AS prj','prj.id',DB::raw('CAST(set.projects_id AS bigint)'))
                        ->where('set.user_id',$user_id)
                        ->get();
        $dataDetail = DB::table('trx_doc_pelengkaps')->select(DB::raw('distinct projects_id,document_number, created_at'))->orderBy('created_at','desc')->where('document_number',$doc_number)->first();
        $dataDetailAttr = DB::table('trx_doc_pelengkap_attributs')->select(DB::raw('distinct projects_id,document_number, created_at'))->where('document_number',$doc_number)->orderBy('created_at','desc')->first();
        $reasonType = DB::table('mst_reason')->get();
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

        return view('form.registerDokumen.SPK.insertDocSPK',
        [
            'data'=>$data,
            'mstProject' => $mstProject,
            'verified' => $verified,
            'verifiedAttr' => $verifiedAttr,
            'reasonType' => $reasonType
        ]);
    }

    public function submitRegDoc(Request $req)
    {
        $doc_number = $req->doc_number;
        // var_dump($req->all());exit();die();
        $complete = 0;
        if ($req->kelengkapan == 'lengkap') {
            $complete = 1;
        }

        if ($req->type == 'SETTLE') {
            $barcode = Trx_document::select('barcode_number')->where('number',$doc_number)->first();
            if (empty($barcode->barcode_number)) {
                # code...
                return response(['stat'=>2,'msg'=>'Barcode number belum di registrasi'], 201);
            }
            $last_status = 'operation_process';
            $openGet = 'open';
        } else if ($req->type == 'PENDING') {
            $last_status = 'pending';
            $openGet = 'get';
        } else if ($req->type == 'NOT_PAIR') {
            $last_status = 'barcode_belum_pairing';
            $openGet = 'get';
        } else if($req->type == 'PAIR') {
            $last_status = 'barcode_sudah_pairing';
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
                        'updated_by' => Session::get('nama_user').' '.Session::get('nama_user_last')
                    ]);
            
            if (isset($req->dataKelengkapan)) {
                $checkKelengkapan = Pelengkap::select('projects_id')->where('document_number',$doc_number)->groupBy('projects_id')->first();
                // var_dump($checkKelengkapan);exit();die();
                if ($checkKelengkapan != null) {
                    # code...
                    if ($checkKelengkapan->projects_id != $req->kel_doc) {
                        # code...
                        $deletePelengkap = Pelengkap::where('document_number',$doc_number)->delete();
                    }
                }
                
                foreach ($req->dataKelengkapan as $key => $value) {
                    $dataDetail = new Pelengkap;
                    $mstPelengkap = mst_pelengkap::whereRaw("upper(name) = '".strtoupper($value['jenis_doc'])."'")->first();
                    $mstType = mstType::where('id',2)->first();
                    $insertMstPelengkap = new mst_pelengkap;

                    if (isset($value['tanggal_doc'])) {
                        $tanggal_doc = $value['tanggal_doc'];
                    } else {
                        $tanggal_doc = null;
                    }

                    if (isset($value['jam_doc'])) {
                        $jam_doc = $value['jam_doc'];
                    } else {
                        $jam_doc = null;
                    }

                    if (isset($value['nilai_doc'])) {
                        $nilai_doc = preg_replace('/\./', '', $value['nilai_doc']);
                    } else {
                        $nilai_doc = null;
                    }

                    if (isset($value['remark_doc'])) {
                        $remark_doc = $value['remark_doc'];
                    } else {
                        $remark_doc = null;
                    }

                    if (empty($mstPelengkap->id)) {
                        $insertMstPelengkap->name = strtoupper($value['jenis_doc']);
                        $insertMstPelengkap->save();
                    }
                    if (empty($value['id'])) {
                        # code...
                        $dataDetail->doc_pelengkap_name = strtoupper($value['jenis_doc']);
                        $dataDetail->is_delete = 0;
                        $dataDetail->type_id = $mstType->id;
                        $dataDetail->projects_id = $req->kel_doc;
                        $dataDetail->document_number = $doc_number;
                        $dataDetail->tanggal_dokumen = $tanggal_doc;
                        $dataDetail->jam = $jam_doc;
                        $dataDetail->nilai = $nilai_doc;
                        $dataDetail->is_exist = $value['isExist'];
                        $dataDetail->remark = $remark_doc;
                        $dataDetail->user_id = Session::get('nama_user').' '.Session::get('nama_user_last');
                        $dataDetail->save();
                    } else {
                        $dataDetailUpdate = Pelengkap::where('id',$value['id'])
                                            ->update([
                                                'doc_pelengkap_name' => strtoupper($value['jenis_doc']),
                                                'type_id' => $mstType->id,
                                                'projects_id' => $req->kel_doc,
                                                'document_number' => $doc_number,
                                                'tanggal_dokumen' => $tanggal_doc,
                                                'jam' => $jam_doc,
                                                'nilai' =>$nilai_doc,
                                                'is_exist' => $value['isExist'],
                                                'remark' => $remark_doc
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
                        $dataAttr->projects_id = $req->projectAttr;
                        $dataAttr->attribut = $value2['attribut'];
                        $dataAttr->label = $value2['attribut_label'];
                        $dataAttr->value = preg_replace('/\./', '', $value2['attribut_value']);
                        $dataAttr->date = $value2['attribut_date'];
                        $dataAttr->remark = $value2['attribut_remark'];
                        $dataAttr->save();
                    } else {
                        $dataAttrUpdate = attr::where('id',$value2['attribut_id'])
                                            ->update([
                                                'projects_id' => $req->projectAttr,
                                                'attribut' => $value2['attribut'],
                                                'label' => $value2['attribut_label'],
                                                'value' => preg_replace('/\./', '', $value2['attribut_value']),
                                                'date' => $value2['attribut_date'],
                                                'remark' => $value2['attribut_remark']
                                            ]);
                    }
                }
            }
            
            $mstStatus = DB::table('mst_document_status')
                            ->where('status_name',$last_status)
                            ->where('status_category','admin')
                            ->get();
            
            // return $mstStatus;
            $historyLog = new History;
            $historyLog->document_number = $doc_number;
            $historyLog->status_id = $mstStatus[0]->id;
            $historyLog->remark = $req->catatan;
            $historyLog->user_id = Session::get('nama_user').' '.Session::get('nama_user_last');
            $historyLog->save();

            DB::commit();
            Session::flash('message', 'Data berhasil tersimpan');
            Session::flash('alert-type', 'success');
            return response(['stat'=>1,'msg'=>'data berhasil disimpan'], 200);
        } catch (QueryException $ex) {
            DB::rollBack();
            return response($ex->getMessage(), 400);
        }
    }

    public function pairingBarcode(Request $req)
    {
        $doc_number = $req->doc_number;
        $barcode    = $req->barcode;
        $type       = $req->type;
        if ($type == 1) {
            $checkbarcode = Trx_document::where('barcode_number',$barcode)->count();
            if ($checkbarcode > 0) {
                # code...
                return response(['stat'=>2,'msg'=>'Barcode sudah pernah di pakai'], 200);
            }
        } else if($type == 2) {
            $checkbarcode = doc_spd::where('barcode_number',$barcode)->count();
            if ($checkbarcode > 0) {
                # code...
                return response(['stat'=>2,'msg'=>'Barcode sudah pernah di pakai'], 200);
            }
        }
        

        if ($type == 1) {
            DB::beginTransaction();
            try {
                $data = Trx_document::where('number',$doc_number)
                        ->update([
                            'barcode_number' => $barcode,
                            'updated_at' => 'NOW()',
                            'last_status' => 'barcode_sudah_pairing',
                            'openget' => 'get',
                            // 'is_complete' => 0,
                            'is_reject' => 0,
                            'updated_by' => Session::get('nama_user').' '.Session::get('nama_user_last')
                        ]);
                        
                $historyLog = new History;
                $historyLog->document_number = $doc_number;
                $historyLog->status_id = 3;
                $historyLog->remark = '';
                $historyLog->user_id = Session::get('nama_user').' '.Session::get('nama_user_last');
                $historyLog->save();

                DB::commit();
                return response(['stat'=>1,'msg'=>'data berhasil disimpan'], 200);
            } catch (QueryException $ex) {
                DB::rollBack();
                return response($ex->getMessage(), 400);
            }
        } else if($type == 2) {
            DB::beginTransaction();
            try {
                $data = doc_spd::where('number',$doc_number)
                        ->update([
                            'barcode_number' => $barcode,
                            'updated_at' => 'NOW()',
                            'last_status' => 'barcode_sudah_pairing',
                            'openget' => 'get',
                            // 'is_complete' => 0,
                            'is_reject' => 0
                        ]);
                        
                $historyLog = new History;
                $historyLog->document_number = $doc_number;
                $historyLog->status_id = 3;
                $historyLog->remark = '';
                $historyLog->user_id = Session::get('nama_user').' '.Session::get('nama_user_last');
                $historyLog->save();

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

    public function getDataKelengkapan(Request $req)
    {
        $user_id = $this->getUserId();
        // return $user_id;
        if ($req->project == 'inserted') {
            $data = Pelengkap::where('document_number', $req->number)->where('is_delete','false')->get();    
        } else {
            // $data = DB::table('doc_pelengkap_settings AS set')
            //             ->select('doc.id AS id_doc','doc.name AS doc_pelengkap_name')
            //             ->leftJoin('mst_doc_pelengkaps AS doc','doc.id',DB::raw('CAST(set.doc_pelengkap_id AS bigint)'))
            //             ->where('set.user_id',$user_id)
            //             ->where('set.projects_id',$req->project)
            //             ->get();

            $data = DB::select(DB::raw("
                select 
                    c.id,
                    a.projects_id,
                    b.id as id_doc,
                    upper(b.name) as doc_pelengkap_name,
                    c.is_exist	,
                    c.tanggal_dokumen,
                    c.nilai,
                    c.remark,
                    a.is_date_value,
                    to_char(c.jam, 'HH24:MI') as jam
                from doc_pelengkap_settings a
                left join mst_doc_pelengkaps b on b.id::character varying = a.doc_pelengkap_id
                left join trx_doc_pelengkaps c on a.projects_id = c.projects_id 
                    and upper(b.name) = upper(c.doc_pelengkap_name) 
                    and c.document_number = '".$req->number."'
                where  a.projects_id = '".$req->project."' and a.user_id = '".$user_id."' and (c.is_delete is false and c.is_delete is null)
                union all
                select
                    a.id,
                    a.projects_id,
                    b.id as id_doc,
                    upper(b.name) as doc_pelengkap_name,
                    a.is_exist	,
                    a.tanggal_dokumen,
                    a.nilai,
                    a.remark,
                    c.is_date_value,
                    to_char(a.jam, 'HH24:MI') as jam
                from trx_doc_pelengkaps a
                left join mst_doc_pelengkaps b on upper(b.name) = upper(a.doc_pelengkap_name)
                left join doc_pelengkap_settings c on c.doc_pelengkap_id = b.id::character varying and a.projects_id = c.projects_id and c.user_id = '".$user_id."'
                where a.document_number = '".$req->number."' and c.id is null and a.projects_id = '".$req->project."' and a.is_delete is false"));
        }
        

        return json_encode($data);
    }

    public function getDataAttr(Request $req)
    {
        $user_id = $this->getUserId();
        $data = DB::table('trx_doc_pelengkap_attributs')->select(DB::raw("REPLACE (value, ',', '') as value_no_comma,*
                "))
                ->where('document_number', $req->number)
                ->where('is_delete','false')
                ->get();
        

        return json_encode($data);
    }

    public function actionKembalikan(Request $req)
    {
        $dataParam = json_decode($req->dataParam);
        
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
                            // 'is_complete' => 0,
                            'catatan' =>$req->catatan,
                            'is_reject' => 1,
                            'updated_by' => Session::get('nama_user').' '.Session::get('nama_user_last')
                        ]);
                        
                    $historyLog = new History;
                    $historyLog->document_number = $value->doc_number;
                    $historyLog->status_id = 6;
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
                foreach ($dataParam as $key => $value) {
                    # code...
                    $data = doc_spd::where('number',$value->doc_number)
                        ->update([
                            'updated_at' => 'NOW()',
                            'last_status' => 'reject_doc',
                            'openget' => 'open',
                            // 'is_complete' => 0,
                            'catatan' =>$req->catatan,
                            'is_reject' => 1
                        ]);
                        
                    $historyLog = new History;
                    $historyLog->document_number = $value->doc_number;
                    $historyLog->status_id = 6;
                    $historyLog->remark = '';
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

    public function actionDeleteDetail(Request $req)
    {
        if ($req->type == 1) {
            # code...
            DB::beginTransaction();
            try {
                $data = Pelengkap::where('id', $req->detail_id)->update([
                    'is_delete'=>1,
                    'updated_at'=>'NOW()'
                ]);  
                DB::commit();
                if($data > 0){
                    return ['stat'=>1,'msg'=>'Data berhasil di hapus'];
                } else {
                    return ['stat'=>2,'msg'=>'Data gagal di hapus'];
                }
            } catch (QueryException $ex) {
                //throw $th;
                Log::info($ex->getMessage());
                return ['stat'=>2,'msg'=>'Ada kesalahan pada server']   ;
            }
        } else {
            DB::beginTransaction();
            try {
                $data = attr::where('id', $req->detail_id)->update([
                    'is_delete'=>1,
                    'updated_at'=>'NOW()'
                ]);  
                DB::commit();
                if($data > 0){
                    return ['stat'=>1,'msg'=>'Data berhasil di hapus'];
                } else {
                    return ['stat'=>2,'msg'=>'Data gagal di hapus'];
                }
            } catch (QueryException $ex) {
                //throw $th;
                Log::info($ex->getMessage());
                return ['stat'=>2,'msg'=>'Ada kesalahan pada server']   ;
            }
        }
        
    }

    public function addOpenDoc(Request $req)
    {
        if ($req->type == 3) {
            $data = doc_spd::where('barcode_number', $req->barcode)->where('last_status','operation_process')->get();
        } else {
            $data = Trx_document::where('barcode_number', $req->barcode)->where('last_status','operation_process')->get();
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
        $nomor_arsip = DB::select("select lpad(nextval('public.seq_generate_arsip')::text, 4, '0') AS nextval");
        if ($req->metode == 2) {
            DB::beginTransaction();
            try {
                for ($i=0; $i < count($dataParam); $i++) { 
                    # code...
                    if ($req->type == 1) {
                        # code...
                        $data = Trx_document::where('number',$dataParam[$i]['doc_number'])
                        ->update([
                            'kode_arsip'        => 'ARSIP'.date("Ymd").'-'.$nomor_arsip[0]->nextval,
                            'tgl_arsip'         => 'NOW()',
                            'updated_at'        => 'NOW()',
                            'last_status'       => 'pilih_mesenger',
                            'openget'           => 'get',
                            // 'is_complete'       => 1,
                            'is_reject'         => 0,
                            'updated_by'        => Session::get('nama_user').' '.Session::get('nama_user_last'),
                            'user_pengarsip'    => Session::get('nama_user').' '.Session::get('nama_user_last')
                        ]);
                    } else {
                        $data = doc_spd::where('number',$dataParam[$i]['doc_number'])
                        ->update([
                            'kode_arsip'        => 'ARSIP'.date("Ymd").'-'.$nomor_arsip[0]->nextval,
                            'tgl_arsip'         => 'NOW()',
                            'updated_at'        => 'NOW()',
                            'last_status'       => 'pilih_mesenger',
                            'openget'           => 'get',
                            // 'is_complete'       => 1,
                            'is_reject'         => 0,
                            'updated_by'        => Session::get('nama_user').' '.Session::get('nama_user_last'),
                            'user_pengarsip'    => Session::get('nama_user').' '.Session::get('nama_user_last')
                        ]);
                    }
                    
                        
                    $historyLog = new History;
                    $historyLog->document_number = $dataParam[$i]['doc_number'];
                    $historyLog->status_id = 7;
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
            
        } else {
            DB::beginTransaction();
            try {
                for ($i=0; $i < count($dataParam); $i++) { 
                    # code...
                    if ($req->type == 1) {
                        # code...
                        $data = Trx_document::where('number',$dataParam[$i]['doc_number'])
                        ->update([
                            'kode_arsip' => 'ARSIP'.date("Ymd").'-'.$nomor_arsip[0]->nextval,
                            'updated_at' => 'NOW()',
                            'tgl_arsip'         => 'NOW()',
                            'last_status' => 'direct',
                            'openget' => 'open',
                            // 'is_complete' => 1,
                            'is_reject' => 0,
                            'updated_by' => Session::get('nama_user').' '.Session::get('nama_user_last'),
                            'user_pengarsip' => Session::get('nama_user').' '.Session::get('nama_user_last')
                        ]);
                    } else {
                        $data = doc_spd::where('number',$dataParam[$i]['doc_number'])
                        ->update([
                            'kode_arsip' => 'ARSIP'.date("Ymd").'-'.$nomor_arsip[0]->nextval,
                            'updated_at' => 'NOW()',
                            'tgl_arsip'         => 'NOW()',
                            'last_status' => 'direct',
                            'openget' => 'open',
                            // 'is_complete' => 1,
                            'is_reject' => 0,
                            'updated_by' => Session::get('nama_user').' '.Session::get('nama_user_last'),
                            'user_pengarsip' => Session::get('nama_user').' '.Session::get('nama_user_last')
                        ]);
                    }
                        
                    $historyLog = new History;
                    $historyLog->document_number = $dataParam[$i]['doc_number'];
                    $historyLog->status_id = 8;
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
    }

    public function getTerimaDok(Request $req)
    {
        if ($req->type == 3) {
            if (!$req->search) {
                $data = doc_spd::select('number','order_number','customer_name','approve_spd_date')->whereRaw("number = '-1'")->groupBy('number','order_number','customer_name','approve_spd_date')->get();    
            } else {
                $data = doc_spd::select('number','order_number','customer_name','approve_spd_date')->whereRaw("(number ilike '%".$req->search."%' OR order_number ilike '%".$req->search."%' OR customer_name ilike '%".$req->search."%' OR barcode_number ilike '%".$req->search."%')")->groupBy('number','order_number','customer_name','approve_spd_date')->get();
            }
        } else {
            if (!$req->search) {
                $data = Trx_document::select('number','order_number','ccms_number','tender_time')->whereRaw("number = '-1'")->where('type_id',$req->type)->groupBy('number','order_number','ccms_number','tender_time')->get();    
            } else {
                $data = Trx_document::select('number','order_number','ccms_number','tender_time')->whereRaw("(number ilike '%".$req->search."%' OR order_number ilike '%".$req->search."%' OR ccms_number ilike '%".$req->search."%' OR barcode_number ilike '%".$req->search."%')")->where('type_id',$req->type)->groupBy('number','order_number','ccms_number','tender_time')->get();
            }
        }
        
        
        return json_encode($data);
    }
    //END SPK

    //Register Document SPD
    public function regDocSPD()
    {
        return view('form.registerDokumen.SPD.index');
    }
    
    public function searchSPD(Request $req)
    {
        $doc_number = trim($req->numbering);

        $notification = array(
            'message' => 'Dokumen berhasil diterima',
            'stat' => 'success'
        );

        try {
            //code...
            $data = doc_spd::where('number',$doc_number)->get();

            if (count($data)==0) {
                # code...
                $notification = array(
                    'message' => 'Data tidak ditemukan!',
                    'stat' => 'warning'
                );
                return $notification;//Redirect::to('regDocSPD')->with($notification);
                
            }

            //insert history terima document
            DB::beginTransaction();
            try {
                $dataUpdate = doc_spd::where('number',$doc_number)
                        ->update([
                            'last_status' => 'registration_doc',
                            'openget' => 'get',
                            // 'is_complete' => false,
                            'updated_at' => 'NOW()'
                        ]);

                $historyLog = new History;
                $historyLog->document_number = $doc_number;
                $historyLog->status_id = 1;
                $historyLog->remark = '';
                $historyLog->user_id = Session::get('nama_user').' '.Session::get('nama_user_last');
                $historyLog->save();
                
                DB::commit();
                return $notification;//Redirect::to('regDocSPD')->with($notification);
            } catch (QueryException $ex) {
                DB::rollBack();
                Log::info($ex->getMessage());
                $notification = array(
                    'message' => 'Something went wrong!',
                    'stat' => 'error'
                );
                return $notification; //Redirect::to('regDocSPD')->with($notification);
            }

            return $notification;//Redirect::to('regDocSPD')->with($notification);
        } catch (QueryException $ex) {
            //throw $th;
            Log::info($ex->getMessage());
            $notification = array(
                'message' => 'Something went wrong!',
                'stat' => 'error'
            );
            return $notification; //Redirect::to('regDocSPD')->with($notification);

        }

        // return view('form.registerDokumen.SPD.insertDocSPD',['data'=>$data]);
    }

    public function getDatatableSPD()
    {
        // $data = DB::table('trx_documents_spd AS doc')
        //         ->leftJoin('mst_document_status AS stat', 'doc.last_status', 'stat.status_name')
        //         ->whereNotNull('doc.last_status')
        //         ->where('stat.status_category','admin')
        //         ->where('doc.openget','get')
        //         ->get();

        if (Session::get('role') == 'Admin Pooling Exim') {
            $data = DB::table('trx_documents_spd AS doc')
                ->select(DB::raw('row_number() OVER (ORDER BY doc.id desc) AS No, coalesce(to_char(doc.approve_spd_date, \'dd Mon YYYY\'), \'-\') As approve_date_formated'),'doc.*','status_date')
                ->leftJoin(DB::raw("(
                    SELECT document_number, status_id, baris from (
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
                ->whereRaw("doc.last_status not in ('registration_doc','barcode_belum_pairing')")
                ->where('stat.status_category','admin')
                ->where('doc.openget','get')
                ->orderBy('id', 'desc')
                ->get();
            return json_encode($data);
        }

        $data = DB::table('trx_documents_spd AS doc')
                ->select(DB::raw('row_number() OVER (ORDER BY doc.id desc) AS No, coalesce(to_char(doc.approve_spd_date, \'dd Mon YYYY\'), \'-\') As approve_date_formated'),'doc.*','status_date')
                ->leftJoin(DB::raw("(
                    SELECT document_number, status_id, baris from (
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
                ->where('stat.status_category','admin')
                ->where('doc.openget','get')
                ->orderBy('id', 'desc')
                ->get();

        return json_encode($data);
    }

    public function insertDocSPD($id)
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
        $dataDetailAttr = DB::table('trx_doc_pelengkap_attributs')->select(DB::raw("distinct projects_id,document_number, created_at"))->orderBy('created_at','desc')->where('document_number',$doc_number)->first();
        

        if (count($data)==0) {
            # code...
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning'
            );
            return Redirect::to('regDocSPD')->with($notification);
        }

        if ($dataDetailAttr != '') {
            $verified = $dataDetailAttr->projects_id;
        } else {
            $verified = 'null';
        }

        return view('form.registerDokumen.SPD.insertDocSPD',
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

    public function submitRegDocSPD(Request $req)
    {
        $doc_number = $req->doc_number;
        // var_dump($req->all());exit();die();
        $complete = 0;
        if ($req->kelengkapan == 'lengkap') {
            $complete = 1;
        }

        if ($req->type == 'SETTLE') {
            $barcode = doc_spd::select('barcode_number')->where('number',$doc_number)->first();
            if (empty($barcode->barcode_number)) {
                # code...
                return response(['stat'=>2,'msg'=>'Barcode number belum di registrasi'], 201);
            }
            $last_status = 'operation_process';
            $openGet = 'open';
        } else if ($req->type == 'PENDING') {
            $last_status = 'pending';
            $openGet = 'get';
        } else if ($req->type == 'NOT_PAIR') {
            $last_status = 'barcode_belum_pairing';
            $openGet = 'get';
        } else if($req->type == 'PAIR') {
            $last_status = 'barcode_sudah_pairing';
            $openGet = 'get';
        }
        DB::beginTransaction();
        try {
            $data = doc_spd::where('number',$doc_number)
                    ->update([
                        'last_status' => $last_status,
                        'openget' => $openGet,
                        'is_complete' => $complete,
                        'is_reject'=>0,
                        'updated_at' => 'NOW()',
                        'catatan' => $req->catatan,
                        'is_bundle' => $req->bundle_kwit,
                        'selisih_tipe' => $req->selisih_tipe,
                        'amount'=>preg_replace('/\,/', '', $req->nilai_spd),
                        'updated_by' => Session::get('nama_user').' '.Session::get('nama_user_last')
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
                        $dataDetail->nilai_kuitansi = preg_replace('/\,/', '', $value['jml_kwt']);
                        // $dataDetail->user_id = Session::get('nama_user').' '.Session::get('nama_user_last');
                        $dataDetail->save();
                    } else {
                        $dataDetailUpdate = pelengkap_spd::where('id',$value['id'])
                                            ->update([
                                                'container' => strtoupper($value['container']),
                                                'type' => $value['type'],
                                                'fleet' => $value['panjang'],
                                                'container_pengganti' => $value['container_pengganti'],
                                                'nilai_kuitansi' => preg_replace('/\,/', '', $value['jml_kwt']),
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
                        $dataAttr->value = preg_replace('/\,/', '', $value2['attribut_value']);
                        $dataAttr->date = $value2['attribut_date'];
                        $dataAttr->remark = $value2['attribut_remark'];
                        $dataAttr->save();
                    } else {
                        $dataAttrUpdate = attr::where('id',$value2['attribut_id'])
                                            ->update([
                                                'projects_id' => $req->kel_doc_attr,
                                                'attribut' => $value2['attribut'],
                                                'label' => $value2['attribut_label'],
                                                'value' => preg_replace('/\,/', '', $value2['attribut_value']),
                                                'date' => $value2['attribut_date'],
                                                'remark' => $value2['attribut_remark']
                                            ]);
                    }
                }
            }
            
            $mstStatus = DB::table('mst_document_status')->where('status_name',$last_status)->get();

            $historyLog = new History;
            $historyLog->document_number = $doc_number;
            $historyLog->status_id = $mstStatus[0]->id;
            $historyLog->remark = $req->catatan;
            $historyLog->user_id = Session::get('nama_user').' '.Session::get('nama_user_last');
            $historyLog->save();

            DB::commit();
            Session::flash('message', 'Data berhasil tersimpan');
            Session::flash('alert-type', 'success');
            return response(['stat'=>1,'msg'=>'data berhasil disimpan'], 200);
        } catch (QueryException $ex) {
            DB::rollBack();
            return response($ex->getMessage(), 400);
        }
    }
    //END SPD

    private function getUserId(){
        $user       = base64_decode(Session::get('token'));
        $user_id    = json_decode($user);

        return $user_id->key_1;
    }
}
