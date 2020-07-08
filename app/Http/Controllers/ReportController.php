<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trx_document;
use App\mst_messenger;
use App\Trx_documents_spd;
use App\Trx_doc_history AS History;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use PDF;
use Log;
use DB;

class ReportController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware();
    // }

    public function index()
    {
        return view('form.reporting.index');
    }


    public function docKembaliData(Request $request)
    {
        $date_from = $request->date_from;
        $date_to = $request->date_to;


        $docData = DB::table(DB::raw("(select a.customer,
        a.order_number as order,
        a.driver_name,
        a.secondary_driver_name,
        a.NUMBER as SHIPMENT,
        a.ccms_number,
        b.status_id,
        a.last_status,
        to_char(b.created_at, 'DD-MM-YYYY  HH:mm:ss') as created_at
        
        from trx_documents a
        inner join trx_doc_histories b on a.number=b.document_number
        where b.status_id= '6' and a.last_status='reject_doc' and to_char(b.created_at,'dd-mm-yyyy')between '$date_from' and '$date_to' 
        -- reject tanggal to char
        group by
        a.customer,
        a.order_number ,
        a.NUMBER,
        a.ccms_number,
        b.status_id,
        a.last_status,
        a.driver_name,
        a.secondary_driver_name,
        b.created_at) z"))->get();

        
        $data = array();
            foreach($docData as $q => $value){
                array_push($data,[
                    'no' => $q+1,
                    'driver_name' => ($value->driver_name != null ? $value->driver_name : $value->secondary_driver_name($value->secondary_driver_name != null ? $value->secondary_driver_name :'-')),
                    'customer'=>$value->customer,
                    'order'=>$value->order,
                    'shipment'=>$value->shipment,
                    'no_ccms'=>$value->ccms_number,
                    'status_doc'=>$value->last_status,
                    // 'status_doc'=>'Dikembalikan',
                    'tgl_kembali'=>date('d-m-yy H:i', strtotime($value->created_at)) 
                ]);
            }return json_encode($data);
    }


    public function leadTimeData(Request $request)
    {
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $docData = DB::table(DB::raw("
        ( select b.customer,
        b.no_order,
        b.SHIPMENT,
       b.ccms_number,
       b.tgl_tender,
       b.tanggal_jam_terima_dokumen,
       b.tanggal_jam_Settle_operation,
       b.tanggal_jam_kasih_messenger,
       b.tanggal_jam_terima_finance,
       replace(b.lead_time::text,'days','hari') as lead_time
        from
       (select a.customer,
        a.no_order,
        a.SHIPMENT,
       a.ccms_number,
       a.tgl_tender,
       a.tanggal_jam_terima_dokumen,
       a.tanggal_jam_Settle_operation,
       a.tanggal_jam_kasih_messenger,
       a.tanggal_jam_terima_finance,
       (a.tanggal_jam_terima_dokumen::timestamp - a.tgl_tender::timestamp)as lead_time
        from
       (select a.customer,
       a.order_number as no_order,
       a.NUMBER as SHIPMENT,
       a.ccms_number,
       a.tender_time as tgl_tender,
       max(dd.tanggal_jam_terima_dokumen) as tanggal_jam_terima_dokumen,
       max(aa.tanggal_jam_Settle_operation)as tanggal_jam_Settle_operation,
       max(bb.tanggal_jam_kasih_messenger)as tanggal_jam_kasih_messenger,
       max(cc.tanggal_jam_terima_finance)as tanggal_jam_terima_finance
       from trx_documents a
       inner join trx_doc_histories b on a.number=b.document_number
       left join (
       		select 
       			a.document_number,
       			a.status_id,
       			a.created_at as tanggal_jam_Settle_operation,
       			row_number() OVER (PARTITION BY a.document_number ORDER BY a.id DESC) AS baris
       		from trx_doc_histories a
       		where a.status_id = '13'
       ) aa on aa.document_number = a.number and aa.baris = 1
       left join (
       		select 
       			a.document_number,
       			a.status_id,
       			a.created_at as tanggal_jam_kasih_messenger,
       			row_number() OVER (PARTITION BY a.document_number ORDER BY a.id DESC) AS baris
       		from trx_doc_histories a
       		where a.status_id = '7'
       ) bb on bb.document_number = a.number and bb.baris = 1
       left join (
       		select 
       			a.document_number,
       			a.status_id,
       			a.created_at as tanggal_jam_terima_finance,
       			row_number() OVER (PARTITION BY a.document_number ORDER BY a.id DESC) AS baris
       		from trx_doc_histories a
       		where a.status_id = '10'
       ) cc on cc.document_number = a.number and cc.baris = 1
       left join (
       		select 
       			a.document_number,
       			a.status_id,
       			a.created_at as tanggal_jam_terima_dokumen,
       			row_number() OVER (PARTITION BY a.document_number ORDER BY a.id DESC) AS baris
       		from trx_doc_histories a
       		where a.status_id = '1'
       ) dd on dd.document_number = a.number and dd.baris = 1
	   where to_char(b.created_at,'dd-mm-yyyy') between '$date_from' and '$date_to'
       group by
       a.customer,
       a.order_number ,
       a.NUMBER,
       a.ccms_number,
       a.tgl_serah_terima,
       a.tender_time)a)b
       
       ) z"))->get(); 

       
        $data = array();
            foreach($docData as $q => $value){
                array_push($data,[
                    'no' => $q+1,
                    'customer'=>$value->customer,
                    'order'=>$value->no_order,
                    'shipment'=>$value->shipment,
                    'no_ccms'=>$value->ccms_number,
                    'tender_time' =>($value->tgl_tender != null ? date('d-m-yy H:i', strtotime($value->tgl_tender)) : ' - '),
                    'tgl_register'=> ($value->tanggal_jam_terima_dokumen != null ? date('d-m-yy H:i', strtotime($value->tanggal_jam_terima_dokumen)) : ' - '),
                    'tgl_proses'=> ($value->tanggal_jam_settle_operation != null ? date('d-m-yy H:i', strtotime($value->tanggal_jam_settle_operation)) : ' - '),
                    // 'tgl_settle'=> ($value->tanggal_jam_settle_operation != null ? date('d-m-yy H:i', strtotime($value->tanggal_jam_settle_finance)) : ' - '),
                    'tgl_msg'=> ($value->tanggal_jam_kasih_messenger != null ? date('d-m-yy H:i', strtotime($value->tanggal_jam_kasih_messenger)) : ' - '),
                    'tgl_finance'=> ($value->tanggal_jam_terima_finance != null ? date('d-m-yy H:i', strtotime($value->tanggal_jam_terima_finance)) : ' - '),
                    // 'today'=> substr($value->today, -0, -6).' hour'
                    'today'=>($value->lead_time != '' ? substr($value->lead_time, -0, -6).' jam' : ' - ')
                ]);
            }return json_encode($data);
        }

    public function outstandingData(Request $request)
    {
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        
        $docData = DB::table(DB::raw("
        (SELECT a.customer,
            a.order_number AS order,
            a.number AS shipment,
            a.ccms_number,
            a.tender_time,
            a.last_status,
            a.prepayment_date as today
            FROM trx_documents a
            JOIN trx_doc_histories b ON a.number::text = b.document_number::text
            WHERE b.status_id::text  is null and to_char(b.created_at,'dd-mm-yyyy')between '$date_from' and '$date_to'
            group by  a.customer,
            a.order_number, 
            a.number,
            a.ccms_number,
            a.tender_time,
            a.last_status,
            a.prepayment_date) z"))->get(); 


        
        $data = array();
            foreach($docData as $q => $value){
                array_push($data,[
                    'no' => $q+1,
                    'customer'=>$value->customer,
                    'order'=>$value->order,
                    'shipment'=>$value->shipment,
                    'status_doc'=>$value->last_status,
                    'no_ccms'=>$value->ccms_number,
                    'tender_time' =>($value->tender_time != null ? date('d-m-yy H:i', strtotime($value->tender_time)) : ' - '), // != '' ? Carbon::createFromFormat('Y-m-d H:i:s', $value->tender_time)->diff(now())->format('%d hari %h jam') : ' - '),
                    'today'=>($value->today != '' ? Carbon::createFromFormat('Y-m-d H:i:s', $value->today)->diff(now())->format('%d hari %h jam') : ' - ')
                    
                ]);
            }return json_encode($data);
    }

    public function docTerimaData(Request $request)
    {
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $docData = DB::table(DB::raw("
        (SELECT a.customer,
        a.order_number AS order,
        a.number AS shipment,
        a.ccms_number,
        a.tender_time,
        a.prepayment_date as today
       FROM trx_documents a
         JOIN trx_doc_histories b ON a.number::text = b.document_number::text
         WHERE b.status_id::text in('1','2','3','5') and to_char(b.created_at,'dd-mm-yyyy')between '$date_from' and '$date_to'
         group by  a.customer,
        a.order_number, 
        a.number,
        a.ccms_number,
        a.tender_time,
        a.prepayment_date) z"))->get();

        $data = array();
            foreach($docData as $q => $value){
                array_push($data,[
                    'no' => $q+1,
                    'customer'=>$value->customer,
                    'order'=>$value->order,
                    'shipment'=>$value->shipment,
                    'no_ccms'=>$value->ccms_number,
                    'tender_time' => ($value->tender_time != null ? date('d-m-yy H:i', strtotime($value->tender_time)) : ' - '),
                    'today'=>($value->today != '' ? Carbon::createFromFormat('Y-m-d H:i:s', $value->today)->diff(now())->format('%d hari %h jam') : ' - ')
                
                ]);
            }return json_encode($data);
    }

    public function docFinanceData(Request $request)
    {
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $docData = DB::table(DB::raw("
        (SELECT a.customer,
        a.order_number AS order,
        a.number AS shipment,
        a.ccms_number,
        a.tender_time  ,
        now() - a.prepayment_date as today
       FROM trx_documents a
         JOIN trx_doc_histories b ON a.number::text = b.document_number::text
         WHERE b.status_id::text in('10','11','12') and to_char(b.created_at,'dd-mm-yyyy')between '$date_from' and '$date_to'
         group by  a.customer,
        a.order_number, 
        a.number,
        a.ccms_number,
        a.tender_time,
        a.prepayment_date) z"))->get();

        $data = array();
            foreach($docData as $q => $value){
                array_push($data,[
                    'no' => $q+1,
                    'customer'=>$value->customer,
                    'order'=>$value->order,
                    'shipment'=>$value->shipment,
                    'no_ccms'=>$value->ccms_number,
                    'tender_time' => ($value->tender_time != null ? date('d-m-yy H:i', strtotime($value->tender_time)) : ' - '),
                    'today'=>($value->today != '' ? Carbon::createFromFormat('Y-m-d H:i:s', $value->today)->diff(now())->format('%d hari %h jam') : ' - ')
                
                ]);
            }return json_encode($data);
    }

    public function docOperationData(Request $request)
    {
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $docData = DB::table(DB::raw("
        (SELECT a.customer,
        a.order_number AS order,
        a.number AS shipment,
        a.ccms_number,
        a.tender_time,
        a.prepayment_date as today
       FROM trx_documents a
         JOIN trx_doc_histories b ON a.number::text = b.document_number::text
         WHERE b.status_id::text in('4','7') and to_char(b.created_at,'dd-mm-yyyy')between '$date_from' and '$date_to'
         group by  a.customer,
        a.order_number, 
        a.number,
        a.ccms_number,
        a.tender_time,
        a.prepayment_date) z"))->get();
        $data = array();

            foreach($docData as $q => $value){
                array_push($data,[
                    'no' => $q+1,
                    'customer'=>$value->customer,
                    'order'=>$value->order,
                    'shipment'=>$value->shipment,
                    'no_ccms'=>$value->ccms_number,
                    'tender_time' => ($value->tender_time != null ? date('d-m-yy H:i', strtotime($value->tender_time)) : ' - '),
                    'today'=>($value->today != '' ? Carbon::createFromFormat('Y-m-d H:i:s', $value->today)->diff(now())->format('%d hari %h jam') : ' - ')
                ]);
            }return json_encode($data);
    }

    public function docMessenggerData(Request $request)
    {
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $docData = DB::table(DB::raw("
        (SELECT a.customer,
        a.order_number AS order,
        a.number AS shipment,
        a.ccms_number,
        a.tender_time,
        a.prepayment_date as today
       FROM trx_documents a
         JOIN trx_doc_histories b ON a.number::text = b.document_number::text
         WHERE b.status_id::text in('8','9') and to_char(b.created_at,'dd-mm-yyyy')between '$date_from' and '$date_to'
         group by  a.customer,
        a.order_number, 
        a.number,
        a.ccms_number,
        a.tender_time,
        a.prepayment_date) z"))->get();

        $data = array();
            foreach($docData as $q => $value){
                array_push($data,[
                    'no' => $q+1,
                    'customer'=>$value->customer,
                    'order'=>$value->order,
                    'shipment'=>$value->shipment,
                    'no_ccms'=>$value->ccms_number,
                    'tender_time' => ($value->tender_time != null ? date('d-m-yy H:i', strtotime($value->tender_time)) : ' - '),
                    'today'=>($value->today != '' ? Carbon::createFromFormat('Y-m-d H:i:s', $value->today)->diff(now())->format('%d hari %h jam') : ' - ')
                
                ]);
            }return json_encode($data);
    }
}
