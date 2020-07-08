<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use App\Trx_document;
use App\mst_messenger;
use App\Trx_documents_spd;
use App\Trx_doc_history AS History;
use PDF;
use Log;
use DB;

class FinanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Admin Settle Finance');
    }
//#region SPK Finance
    public function showSPK(){

        return view('form.financeDoc.SPK.index');
    }

    public function loadDataSPK()
    {
        $data_msg_spk = DB::table(DB::raw("
            (select
                to_char(a.tgl_arsip, 'DD-MM-YYYY') as tgl_arsip, 
                a.kode_arsip, 
                a.user_pengarsip, 
                c.tgl_serah_terima
            from trx_documents a
            left join (
                select 
                    document_number,
                    status_id,
                    b1.created_at as status_date,
                    b2.status_name,
                    b2.status_category,
                    row_number() OVER (PARTITION BY document_number ORDER BY b1.id DESC) AS baris
                from trx_doc_histories b1
                left join mst_document_status b2 on b1.status_id::bigint = b2.id
            )  b on a.number = b.document_number and b.baris = 1
            left join (
                select 
                    document_number,
                    to_char(b1.created_at, 'DD-MM-YYYY HH:mm') as tgl_serah_terima,
                    row_number() OVER (PARTITION BY document_number ORDER BY b1.id DESC) AS baris
                from trx_doc_histories b1
                left join mst_document_status b2 on b1.status_id::bigint = b2.id
                where b2.status_name = 'reject_doc' -- OR b2.status_name = 'process_messenger'
            )  c on a.number = c.document_number and c.baris = 1
            where ((b.status_name = 'reject_doc' and b.status_category = 'finance') OR (b.status_name = 'pilih_messenger' and b.status_category = 'messenger')) 
            and a.type_id = '1'
            and kode_arsip is not null
            group by 
            b.status_name,
            a.tgl_arsip, 
            a.kode_arsip, 
            a.user_pengarsip, 
            c.tgl_serah_terima
            order by kode_arsip desc) z"))->get();
            $data = array();
            foreach($data_msg_spk as $q => $value){
                array_push($data,[
                    'no' => $q+1,
                    'kode_arsip'=>$value->kode_arsip,
                    'user_pengarsip'=>$value->user_pengarsip,
                    'tgl_arsip'=>$value->tgl_arsip,
                    'tgl_serah_terima'=>$value->tgl_serah_terima
                ]);
            }

        return json_encode($data);
        
    }

    public function detailSPK($kode_arsip){
        $arsip = DB::table(DB::raw("
        (select  
            a.number, 
            b.status_name, 
            b.status_category, 
            b.status_date,
            to_char(a.tgl_arsip, 'DD-MM-YYYY HH:mm') as tgl_arsip, 
            a.kode_arsip, 
            a.user_pengarsip, 
            c.tgl_serah_terima,
            a.customer,
            to_char(a.tender_time,'DD-MM-YYYY HH:mm') as tender_time,
            a.openget,
            a.catatan
        from trx_documents a
        left join (
            select 
                document_number,
                status_id,
                b1.created_at as status_date,
                b2.status_name,
                b2.status_category,
                row_number() OVER (PARTITION BY document_number ORDER BY b1.id DESC) AS baris
            from trx_doc_histories b1
            left join mst_document_status b2 on b1.status_id::bigint = b2.id
        )  b on a.number = b.document_number and b.baris = 1
        left join (
            select 
                document_number,
                to_char(b1.created_at, 'DD-MM-YYYY HH:mm') as tgl_serah_terima,
                row_number() OVER (PARTITION BY document_number ORDER BY b1.id DESC) AS baris
            from trx_doc_histories b1
            left join mst_document_status b2 on b1.status_id::bigint = b2.id
            --where b2.status_name = 'process_messenger\'
            where b2.status_name like '%messenger%'
        )  c on a.number = c.document_number and c.baris = 1
        where ((b.status_name = 'reject_doc' and b.status_category = 'finance') OR (b.status_name = 'pilih_messenger' 
        and b.status_category = 'messenger')) and a.type_id = '1' and kode_arsip = '$kode_arsip'
        order by kode_arsip desc) z"))->get(); 


        if(count($arsip)> 0){

            $msg_all = DB::table('mst_messengers')
            ->where('status', 'LIKE', '%Active%')
            ->get();

        return view('form.financeDoc.SPK.detail')->with(['arsip' => $arsip, 'msg_all' => $msg_all]);
        } else {

            return view('form.financeDoc.SPK.index');
        }
    }

    public function printSPK(Request $request)
    {

        $kolom = $this->kolomSPK($request->to);
        // var_dump($request);
    
        $select = "";
        foreach ($request->to as $row) {
            // Kalo ada driver_name, diambil jg driver_id 
            if($row == 'driver_name'){
                $select .= "coalesce(driver_id, '') || '-' || coalesce(driver_name, '') as driver_name,";
            }elseif($row == 'secondary_driver_name'){
                $select .= "coalesce(secondary_driver_id, '') || '-' || coalesce(secondary_driver_name, '') as secondary_driver_name,";
            }else{
                $select .= $row.",";
            }
        }
        
        $select_kolom = rtrim($select, ",");


        $data = DB::table(DB::raw("
        (select  
            a.number, 
            b.status_name, 
            b.status_category, 
            b.status_date,
            to_char(a.tgl_arsip, 'DD-MM-YYYY') as tgl_arsip,  
            a.kode_arsip, 
            a.user_pengarsip, 
            c.tgl_serah_terima,
            a.customer,
            to_char(a.tender_time, 'DD-MM-YYYY') as tender_time,
            a.openget,
            a.catatan,
            a.prepayment_status,
            case
                when a.is_complete is true then 'Complete'
                else 'Not Complete'
            end as is_complete,
            a.updated_by,
            a.ccms_number,
            a.driver_id,
            a.driver_name,
            a.secondary_driver_name,
            a.unit,
            a.order_number,
            a.route_name
        from trx_documents a
        left join (
            select 
                document_number,
                status_id,
                b1.created_at as status_date,
                b2.status_name,
                b2.status_category,
                row_number() OVER (PARTITION BY document_number ORDER BY b1.id DESC) AS baris
            from trx_doc_histories b1
            left join mst_document_status b2 on b1.status_id::bigint = b2.id
        )  b on a.number = b.document_number and b.baris = 1
        left join (
            select 
                document_number,
                to_char(b1.created_at, 'DD-MM-YYYY HH:mm') as tgl_serah_terima,
                row_number() OVER (PARTITION BY document_number ORDER BY b1.id DESC) AS baris
            from trx_doc_histories b1
            left join mst_document_status b2 on b1.status_id::bigint = b2.id
            --where b2.status_name = 'process_messenger'
            where b2.status_name like '%messenger%'
        )  c on a.number = c.document_number and c.baris = 1
        where ((b.status_name = 'reject_doc' and b.status_category = 'finance') OR (b.status_name = 'pilih_messenger' and b.status_category = 'messenger')) 
        and a.type_id = '1' and kode_arsip = '$request->kode_arsip'
        order by kode_arsip desc) z"))->selectRaw($select_kolom)->get();

        if($request->msg_select == NULL){
            
             $dataMsg = $request->nama_msg_.' - '.$request->msg_hp2_;
             $messenger_id = 'others';
             $others_msg_name = $request->nama_msg_;
             $others_msg_hp = $request->msg_hp2_;

        } else {

             $dataMsg = $request->msg_select.' - '.$request->msg_hp1;
             $messenger_id = $request->msg_select;
             $others_msg_name = $request->nama_msg_;
             $others_msg_hp = $request->msg_hp2_;
        }
    
            
    
        if($data){
    
         // Param yg akan dikirim pdf\
                $params['kolom_header']    = $kolom;
                $params['kolom_table']     = $request->to;
                $params['kode_arsip']      = $request->kode_arsip;
                $params['tanggal_arsip']   = $request->tgl_arsip;
                $params['messenger']      = $dataMsg;
                $params['user_admin']      = $request->user_arsip;
                $params['documents']       = $data;   

            foreach ($data as $key => $value) {
            
                    $updateDoc = DB::table('trx_documents')->where('number',$value->number)
                     ->update([
                         'messenger_id' => $messenger_id,     
                         'others_msg_name' => $others_msg_name,
                         'others_msg_hp' => $others_msg_hp,
                         'last_status' => 'process_messenger',
                         'tgl_serah_terima' => date('Y-m-d'),
                         'openget' => 'open'
                     ]);
    
                    
                    //Inser into trx_history

                    $historyLog = new History;
                    $historyLog->document_number = $value->number;
                    $historyLog->status_id = 9;
                    $historyLog->remark = '';
                    $historyLog->user_id = Session::get('nama_user').' '.Session::get('nama_user_last');
                    $historyLog->save();
        
               
            }
            
            $pdf = PDF::loadview('form.financeDoc.SPK.print', $params);
            
            return $pdf->stream();
            
        } else{
            
            return false;
        }             
        
    }

    protected function kolomSPK($params)
    {
        $kolom = [];
        foreach ($params as $kolom_data) {
            switch ($kolom_data) {
                
                
                case 'number': array_push($kolom, 'SPK'); break;
                case 'customer': array_push($kolom, 'Customer'); break;
                case 'driver_name': array_push($kolom, 'Driver Name'); break;
                case 'secondary_driver_name': array_push($kolom, 'Driver Name 2'); break;
                case 'unit': array_push($kolom, 'No Polisi'); break;    
                case 'order_number': array_push($kolom, 'Order Number'); break;
                case 'route_name': array_push($kolom, 'Route'); break;
                case 'ccms_number': array_push($kolom, 'CCMS Number'); break;
                case 'tender_time': array_push($kolom, 'Tender Time'); break;
                case 'prepayment_status': array_push($kolom, 'Prepayment Status OTM'); break;
                case 'openget': array_push($kolom, 'Status Dokument'); break;
                case 'updated_by': array_push($kolom, 'User'); break;
                case 'is_complete': array_push($kolom, 'Status Dokumen'); break;
                case 'catatan': array_push($kolom, 'Remarks'); break;
                

                          
                default:

                    break;
            }

       }

       return $kolom;
    }

//#endregion

//#region SPK Trailer

public function showSPKTrailer(){

    return view('form.financeDoc.SPKTrailer.index');
}

public function loadDataSPKTrailer()
{
    $data_msg_spk = DB::table(DB::raw("
            (select 
               -- a.number as document_number, 
               -- b.status_name, 
                --b.status_category, 
               -- b.status_date,
               -- a.tgl_arsip, 
               -- a.kode_arsip, 
                --a.user_pengarsip, 
                --c.tgl_serah_terima
                to_char(a.tgl_arsip, 'DD-MM-YYYY') as tgl_arsip, 
                a.kode_arsip, 
                a.user_pengarsip, 
                c.tgl_serah_terima
            from trx_documents a
            left join (
                select 
                    document_number,
                    status_id,
                    b1.created_at as status_date,
                    b2.status_name,
                    b2.status_category,
                    row_number() OVER (PARTITION BY document_number ORDER BY b1.id DESC) AS baris
                from trx_doc_histories b1
                left join mst_document_status b2 on b1.status_id::bigint = b2.id
            )  b on a.number = b.document_number and b.baris = 1
            left join (
                select 
                    document_number,
                    to_char(b1.created_at, 'DD-MM-YYYY HH:mm') as tgl_serah_terima,
                    row_number() OVER (PARTITION BY document_number ORDER BY b1.id DESC) AS baris
                from trx_doc_histories b1
                left join mst_document_status b2 on b1.status_id::bigint = b2.id
                where b2.status_name = 'reject_doc'
                --where b2.status_name like '%messenger%'
            )  c on a.number = c.document_number and c.baris = 1
            --where b.status_name = 'reject_doc' and b.status_category = 'finance' and a.type_id = '1' 
            where ((b.status_name = 'reject_doc' and b.status_category = 'finance') OR (b.status_name = 'pilih_messenger' and b.status_category = 'messenger')) 
            and a.type_id = '2'
            and kode_arsip is not null
            group by 
            b.status_name,
            a.tgl_arsip, 
            a.kode_arsip, 
            a.user_pengarsip, 
            c.tgl_serah_terima
            order by kode_arsip desc) z"))->get(); 

    $data = array();
    foreach($data_msg_spk as $q => $value){
        array_push($data,[
            'no' => $q+1,
            'kode_arsip'=>$value->kode_arsip,
            'user_pengarsip'=>$value->user_pengarsip,
            'tgl_arsip'=>$value->tgl_arsip,
            'tgl_serah_terima'=>$value->tgl_serah_terima
        ]);
    }

return json_encode($data);
    
}

public function detailSPKTrailer($kode_arsip){

    $arsip = DB::table(DB::raw("
        (select  
            a.number, 
            b.status_name, 
            b.status_category, 
            b.status_date,
            to_char(a.tgl_arsip,'DD-MM-YYYY') as tgl_arsip, 
            a.kode_arsip, 
            a.user_pengarsip, 
            c.tgl_serah_terima,
            a.customer,
            to_char(a.tender_time, 'DD-MM-YYYY') as tender_time,
            a.openget,
            a.catatan
        from trx_documents a
        left join (
            select 
                document_number,
                status_id,
                b1.created_at as status_date,
                b2.status_name,
                b2.status_category,
                row_number() OVER (PARTITION BY document_number ORDER BY b1.id DESC) AS baris
            from trx_doc_histories b1
            left join mst_document_status b2 on b1.status_id::bigint = b2.id
        )  b on a.number = b.document_number and b.baris = 1
        left join (
            select 
                document_number,
                to_char(b1.created_at, 'DD-MM-YYYY HH:mm') as tgl_serah_terima,
                row_number() OVER (PARTITION BY document_number ORDER BY b1.id DESC) AS baris
            from trx_doc_histories b1
            left join mst_document_status b2 on b1.status_id::bigint = b2.id
            --where b2.status_name = 'process_messenger'
            where b2.status_name like '%messenger%'
        )  c on a.number = c.document_number and c.baris = 1
        where ((b.status_name = 'reject_doc' and b.status_category = 'finance') OR (b.status_name = 'pilih_messenger' 
        and b.status_category = 'messenger')) and a.type_id = '2' and kode_arsip = '$kode_arsip'
        order by kode_arsip desc) z"))->get();

        $msg_all = DB::table('mst_messengers')
        ->where('status', 'LIKE', '%Active%')
        ->get();
    if(count($arsip)> 0){

    return view('form.financeDoc.SPKTrailer.detail')->with(['arsip' => $arsip, 'msg_all' => $msg_all]);
    } else {
        return view('form.financeDoc.SPKTrailer.index');
    }
}

public function printSPKTrailer(Request $request)
{

    $kolom = $this->kolomSPKTrailer($request->to);

    $select = "";
        foreach ($request->to as $row) {
            // Kalo ada driver_name, diambil jg driver_id 
            if($row == 'driver_name'){
                $select .= "coalesce(driver_id, '') || '-' || coalesce(driver_name, '') as driver_name,";
            }elseif($row == 'secondary_driver_name'){
                $select .= "coalesce(secondary_driver_id, '') || '-' || coalesce(secondary_driver_name, '') as secondary_driver_name,";
            }else{
                $select .= $row.",";
            }
        }
        
        $select_kolom = rtrim($select, ",");


        $data = DB::table(DB::raw("
                (select  
                    a.number, 
                    b.status_name, 
                    b.status_category, 
                    b.status_date,
                    to_char(a.tgl_arsip, 'DD-MM-YYYY') as tgl_arsip, 
                    a.kode_arsip, 
                    a.user_pengarsip, 
                    c.tgl_serah_terima,
                    a.customer,
                    to_char(a.tender_time, 'DD-MM-YYYY') as tender_time,
                    a.openget,
                    a.catatan,
                    a.prepayment_status,
                    case
                        when a.is_complete is true then 'Complete'
                        else 'Not Complete'
                    end as is_complete,
                    a.updated_by,
                    a.ccms_number,
                    a.driver_id,
                    a.driver_name,
                    a.secondary_driver_name,
                    a.unit,
                    a.order_number,
                    a.route_name
                from trx_documents a
                left join (
                    select 
                        document_number,
                        status_id,
                        b1.created_at as status_date,
                        b2.status_name,
                        b2.status_category,
                        row_number() OVER (PARTITION BY document_number ORDER BY b1.id DESC) AS baris
                    from trx_doc_histories b1
                    left join mst_document_status b2 on b1.status_id::bigint = b2.id
                )  b on a.number = b.document_number and b.baris = 1
                left join (
                    select 
                        document_number,
                        to_char(b1.created_at, 'DD-MM-YYYY HH:mm') as tgl_serah_terima,
                        row_number() OVER (PARTITION BY document_number ORDER BY b1.id DESC) AS baris
                    from trx_doc_histories b1
                    left join mst_document_status b2 on b1.status_id::bigint = b2.id
                    --where b2.status_name = 'process_messenger'
                    where b2.status_name like '%messenger%'
                )  c on a.number = c.document_number and c.baris = 1
                where ((b.status_name = 'reject_doc' and b.status_category = 'finance') OR (b.status_name = 'pilih_messenger' and b.status_category = 'messenger')) 
                and a.type_id = '2' and kode_arsip = '$request->kode_arsip'
                order by kode_arsip desc) z"))->selectRaw($select_kolom)->get();

        if($request->msg_select == NULL){
            
             $dataMsg = $request->nama_msg_.' - '.$request->msg_hp2_;
             $messenger_id = 'others';
             $others_msg_name = $request->nama_msg_;
             $others_msg_hp = $request->msg_hp2_;

        } else {

             $dataMsg = $request->msg_select.' - '.$request->msg_hp1;
             $messenger_id = $request->msg_select;
             $others_msg_name = $request->nama_msg_;
             $others_msg_hp = $request->msg_hp2_;
        }
        

    if($data){

     // Param yg akan dikirim pdf\
            $params['kolom_header']    = $kolom;
            $params['kolom_table']     = $request->to;
            $params['kode_arsip']      = $request->kode_arsip;
            $params['tanggal_arsip']   = $request->tgl_arsip;
            $params['messenger']      = $dataMsg;
            $params['user_admin']      = $request->user_arsip;
            $params['documents']       = $data;   
            
            // var_dump($params['documents']['number']);die(); exit();
            
            foreach ($data as $key => $value) {
            
                $updateDoc = DB::table('trx_documents')->where('number', $value->number)
                 ->update([
                     'messenger_id' => $messenger_id,     
                     'others_msg_name' => $others_msg_name,
                     'others_msg_hp' => $others_msg_hp,
                     'last_status' => 'process_messenger',
                     'tgl_serah_terima' => date('Y-m-d'),
                     'openget' => 'open'
                 ]);

                
                //Inser into trx_history

                $historyLog = new History;
                $historyLog->document_number = $value->number;
                $historyLog->status_id = 9;
                $historyLog->remark = '';
                $historyLog->user_id = Session::get('nama_user').' '.Session::get('nama_user_last');
                $historyLog->save();
    
           
        }
        
        
        $pdf = PDF::loadview('form.financeDoc.SPKTrailer.print', $params);
        
        return $pdf->stream();
        
    } else{
        
        return false;
    }             
    
}

protected function kolomSPKTrailer($params)
{
    $kolom = [];
    foreach ($params as $kolom_data) {
        switch ($kolom_data) {
            
            
            case 'number': array_push($kolom, 'SPK'); break;
            case 'customer': array_push($kolom, 'Customer'); break;
            case 'driver_name': array_push($kolom, 'Driver Name'); break;
            case 'secondary_driver_name': array_push($kolom, 'Driver Name 2'); break;
            case 'unit': array_push($kolom, 'No Polisi'); break;    
            case 'order_number': array_push($kolom, 'Order Number'); break;
            case 'route_name': array_push($kolom, 'Route'); break;
            case 'ccms_number': array_push($kolom, 'CCMS Number'); break;
            case 'tender_time': array_push($kolom, 'Tender Time'); break;
            case 'prepayment_status': array_push($kolom, 'Prepayment Status OTM'); break;
            case 'openget': array_push($kolom, 'Status Dokument'); break;
            case 'catatan': array_push($kolom, 'Remarks'); break;
            case 'updated_by': array_push($kolom, 'User'); break;
            case 'is_complete': array_push($kolom, 'Status Dokumen'); break;
            

                      
            default:

                break;
        }

   }

   return $kolom;
}
//#endregion SPK Trailer

//#region SPD Controller

    public function showSPD(){

        return view('form.financeDoc.SPD.index');
    }


    public function loadDataSPD()
    {
        $data_msg_spd = DB::table(DB::raw("
        (select
            ---a.number as document_number, 
            ---b.status_name, 
            ---b.status_category, 
            ---b.status_date,
            to_char(a.tgl_arsip, 'DD-MM-YYYY') as tgl_arsip, 
            a.kode_arsip, 
            a.user_pengarsip, 
            c.tgl_serah_terima
        from trx_documents_spd a
        left join (
            select 
                document_number,
                status_id,
                b1.created_at as status_date,
                b2.status_name,
                b2.status_category,
                row_number() OVER (PARTITION BY document_number ORDER BY b1.id DESC) AS baris
            from trx_doc_histories b1
            left join mst_document_status b2 on b1.status_id::bigint = b2.id
        )  b on a.number = b.document_number and b.baris = 1
        left join (
            select 
                document_number,
                to_char(b1.created_at, 'DD-MM-YYYY HH:mm') as tgl_serah_terima,
                row_number() OVER (PARTITION BY document_number ORDER BY b1.id DESC) AS baris
            from trx_doc_histories b1
            left join mst_document_status b2 on b1.status_id::bigint = b2.id
            --where b2.status_name = 'process_messenger'
            where b2.status_name like '%messenger%'
        )  c on a.number = c.document_number and c.baris = 1
        where ((b.status_name = 'reject_doc' and b.status_category = 'finance') OR (b.status_name = 'pilih_messenger' and b.status_category = 'messenger')) 
        and kode_arsip is not null
        group by 
        a.tgl_arsip, 
        a.kode_arsip, 
        a.user_pengarsip, 
        c.tgl_serah_terima
        order by kode_arsip desc) z"))->get();  
            
            $data = array();
            foreach($data_msg_spd as $q => $value){
                array_push($data,[
                    'no' => $q+1,
                    'kode_arsip'=>$value->kode_arsip,
                    'user_pengarsip'=>$value->user_pengarsip,
                    'tgl_arsip'=>$value->tgl_arsip,
                    'tgl_serah_terima'=>$value->tgl_serah_terima
                ]);
            }

        return json_encode($data);
        
    }

    public function detailSPD($kode_arsip){

        $arsip = DB::table(DB::raw("
                (select  
                    a.number, 
                    b.status_name, 
                    b.status_category, 
                    b.status_date,
                    to_char(a.tgl_arsip, 'DD-MM-YYYY') as tgl_arsip, 
                    a.kode_arsip, 
                    a.user_pengarsip, 
                    c.tgl_serah_terima,
                    a.customer_name,
                    a.driver_name,
                    to_char(a.created_at, 'DD-MM-YYYY') as created_at,
                    a.openget,
                    a.catatan
                from trx_documents_spd a
                left join (
                    select 
                        document_number,
                        status_id,
                        b1.created_at as status_date,
                        b2.status_name,
                        b2.status_category,
                        row_number() OVER (PARTITION BY document_number ORDER BY b1.id DESC) AS baris
                    from trx_doc_histories b1
                    left join mst_document_status b2 on b1.status_id::bigint = b2.id
                )  b on a.number = b.document_number and b.baris = 1
                left join (
                    select 
                        document_number,
                        to_char(b1.created_at, 'DD-MM-YYYY HH:mm') as tgl_serah_terima,
                        row_number() OVER (PARTITION BY document_number ORDER BY b1.id DESC) AS baris
                    from trx_doc_histories b1
                    left join mst_document_status b2 on b1.status_id::bigint = b2.id
                    --where b2.status_name = 'process_messenger'
                    where b2.status_name like '%messenger%'
                )  c on a.number = c.document_number and c.baris = 1
                where ((b.status_name = 'reject_doc' and b.status_category = 'finance') OR (b.status_name = 'pilih_messenger' and b.status_category = 'messenger')) 
                and kode_arsip = '$kode_arsip'
                order by kode_arsip desc) z"))->get();  

            $msg_all = DB::table('mst_messengers')
            ->where('status', 'LIKE', '%Active%')
            ->get();
            
    if(count($arsip)> 0){
        return view('form.financeDoc.SPD.detail',compact('arsip','msg_all'));
    } else {
        return view('form.financeDoc.SPD.index');
    }
    }

    public function printSPD(Request $request)
    {

        // Berhubung kolomnya berbeda, jadi dibuatkan function buat ubah kolomnya
 
        $kolom = $this->kolomSPD($request->to_spd);
        
        
        
        // Buat Custom Select untuk Query
        $select = "";
        foreach ($request->to_spd as $row) {
            // Kalo ada driver_name, diambil jg driver_id 
            if($row == 'driver_name'){
                $select .= "coalesce(driver_id, '') || '-' || coalesce(driver_name, '') as driver_name,";
            } else {
                $select .= $row.",";
            }
        }
        
        $select_kolom = rtrim($select, ",");


        
        $data = DB::table(DB::raw("
                (select  
                    a.number, 
                    b.status_name, 
                    b.status_category, 
                    b.status_date,
                    to_char(a.tgl_arsip, 'DD-MM-YYYY') as tgl_arsip, 
                    a.kode_arsip, 
                    a.user_pengarsip, 
                    c.tgl_serah_terima,
                    a.customer_name,
                    to_char(a.created_at, 'DD-MM-YYYY') as created_at,
                    a.openget,
                    a.approve_spd_date,
                    a.catatan,
                    --a.prepayment_status,
                    case
                        when a.is_complete is true then 'Complete'
                        else 'Not Complete'
                    end as is_complete,
                    a.updated_by,
                    --a.ccms_number,
                    a.driver_id,
                    a.driver_name,
                    --a.secondary_driver_name,
                    --a.unit,
                    a.order_number
                    --a.route_name
                from trx_documents_spd a
                left join (
                    select 
                        document_number,
                        status_id,
                        b1.created_at as status_date,
                        b2.status_name,
                        b2.status_category,
                        row_number() OVER (PARTITION BY document_number ORDER BY b1.id DESC) AS baris
                    from trx_doc_histories b1
                    left join mst_document_status b2 on b1.status_id::bigint = b2.id
                )  b on a.number = b.document_number and b.baris = 1
                left join (
                    select 
                        document_number,
                        to_char(b1.created_at, 'DD-MM-YYYY HH:mm')as tgl_serah_terima,
                        row_number() OVER (PARTITION BY document_number ORDER BY b1.id DESC) AS baris
                    from trx_doc_histories b1
                    left join mst_document_status b2 on b1.status_id::bigint = b2.id
                   --where b2.status_name = 'process_messenger'
                   where b2.status_name like '%messenger%'
                )  c on a.number = c.document_number and c.baris = 1
                where ((b.status_name = 'reject_doc' and b.status_category = 'finance') OR (b.status_name = 'pilih_messenger' and b.status_category = 'messenger')) 
                and kode_arsip = '$request->kode_arsip') z"))->selectRaw($select_kolom)->get();

        if($request->msg_select == NULL){
            
             $dataMsg = $request->nama_msg_.' - '.$request->msg_hp2_;
             $messenger_id = 'others';
             $others_msg_name = $request->nama_msg_;
             $others_msg_hp = $request->msg_hp2_;

        } else {

             $dataMsg = $request->msg_select.' - '.$request->msg_hp1;
             $messenger_id = $request->msg_select;
             $others_msg_name = $request->nama_msg_;
             $others_msg_hp = $request->msg_hp2_;
        }

        

    if($data){

     // Param yg akan dikirim pdf\
            $params['kolom_header']    = $kolom;
            $params['kolom_table']     = $request->to_spd;
            $params['kode_arsip']      = $request->kode_arsip;
            $params['tanggal_arsip']   = $request->tgl_arsip;
            $params['messengger']      = $dataMsg;
            $params['user_admin']      = $request->user_arsip;
            $params['documents']       = $data;   
            
            // var_dump($params); die(); exit();

            foreach ($data as $key => $value) {
            
                $updateDoc = DB::table('trx_documents_spd')->where('order_number', $value->order_number)
                 ->update([
                     'messenger_id' => $messenger_id,     
                     'others_msg_name' => $others_msg_name,
                     'others_msg_hp' => $others_msg_hp,
                     'last_status' => 'process_messenger',
                     'tgl_serah_terima' => date('Y-m-d'),
                     'openget' => 'open'
                 ]);

                
                //Inser into trx_history

                $historyLog = new History;
                $historyLog->document_number = $value->order_number;
                $historyLog->status_id = 9;
                $historyLog->remark = '';
                $historyLog->user_id = Session::get('nama_user').' '.Session::get('nama_user_last');
                $historyLog->save();
    
           
        }
     
     
            $pdf = PDF::loadview('form.financeDoc.SPD.print', $params);
            
            return $pdf->stream();
            
        } else{
            
            return false;
        }             
        
        }
    
    
    
     protected function kolomSPD($params)
    {   
        $kolom = [];

        foreach ($params as $kolom_data) {

            switch ($kolom_data) {
                
                
                case 'number': array_push($kolom, 'SPD'); break;
                case 'customer_name': array_push($kolom, 'Customer'); break;
                case 'order_number': array_push($kolom, 'Order Number'); break;
                case 'driver_name': array_push($kolom, 'Driver Name'); break;
                case 'status_erp': array_push($kolom, 'Status ERP'); break;
                case 'status_spd': array_push($kolom, 'Status SPD'); break;
                case 'depo_name': array_push($kolom, 'Depo'); break;
                case 'openget': array_push($kolom, 'Status Dokument'); break;
                case 'approve_spd_date': array_push($kolom, 'Tender Time'); break;
                case 'amount': array_push($kolom, 'Amount'); break;
                case 'user_pengarsip': array_push($kolom, 'User'); break;
                case 'catatan': array_push($kolom, 'Remarks'); break;

                          
                        
                default:

                    break;
            }

       }

       return $kolom;
    }
//#endregion SPD Controller

}
