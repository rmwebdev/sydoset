@extends('layout.master')

@section('title','Register Document - SPD')

@section('css')
<style type="text/css">
    .shipmentLabel {
        font-size: 14px;
        font-weight: 400;
        vertical-align: top;
        text-transform: capitalize;
    }

    .text-left {
        text-align:left;
    }

    .text-center {
        text-align:center;
    }

    .deleteDetail{
        cursor:pointer;
    }

    .form-control {
        font-size: 12px;
        font-weight: 700;
    }

    .dataTables_filter {
        float: left !important;
    }

    .bootstrap-datetimepicker-widget.dropdown-menu {
        z-index: 9999 !important;
    }

    .dataTables_wrapper.dt-bootstrap4 .row:nth-child(2){
        width:auto !important;
    }

    .dt-td-center{
        text-align:center !important;
    }

    .form-inline label {
        display: block;
    }

    /* .dropdown-menu.show {
        display: block;
        line-height: normal !important;
        top: 2.5em !important;
        padding-left: 1em;
    }
    .dropdown-toggle::after {
        content: none !important;
    } */

    /* .dropdown-menu {
        left: auto !important;
        right: 0px !important;
    } */
    #tbl_kel_doc.table.dataTable thead th, #tbl_kel_doc.table.dataTable tbody td{
        text-align:center !important;

    }
    #tbl_kel_doc.table.dataTable thead th{
        font-weight:500;
    }
    table.dataTable thead th, table.dataTable thead td {
        border-bottom: 1px solid #d2d2d2 !important;
    }

    table.dataTable.no-footer {
        border-bottom: 1px solid #d2d2d2 !important;
    }

    .table td, .table th {
        vertical-align:middle !important;
    }

    #tbl_attr.table>caption+thead>tr:first-child>td, #tbl_attr.table>caption+thead>tr:first-child>th, #tbl_attr.table>colgroup+thead>tr:first-child>td, #tbl_attr.table>colgroup+thead>tr:first-child>th, #tbl_attr.table>thead:first-child>tr:first-child>td, #tbl_attr.table>thead:first-child>tr:first-child>th {
        border-top: 0px solid transparent;
    }
    #tbl_history.table>caption+thead>tr:first-child>td, #tbl_history.table>caption+thead>tr:first-child>th, #tbl_history.table>colgroup+thead>tr:first-child>td, #tbl_history.table>colgroup+thead>tr:first-child>th, #tbl_history.table>thead:first-child>tr:first-child>td, #tbl_history.table>thead:first-child>tr:first-child>th {
        border-top: 0px solid transparent;
    }
    table.dataTable td, table.dataTable th {
        -webkit-box-sizing: border-box !important;
        box-sizing: border-box !important;
    }
    .table>thead:first-child>tr:first-child>th {
        border-top: 1px solid #dee2e6;
    }

    .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
        border-left: 0px solid transparent !important;
        border-right: 0px solid transparent !important;
        border-top: 0px solid transparent !important;
    }

    .form-check{
        margin-bottom:16px;
        padding-left: 0px;
    }

    

</style>
    
@endsection

@section('content')
<form action="" method="" id="postSubmitRegDoc">
    @csrf
    <div class="row" style="margin-bottom: 1.5em;">
        <div class="col-lg-12">
            <div class="card" style="margin-bottom:0px !important;min-height: 80vh;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-body">        
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 style="font-weight:600;color:#1d1e4b;">DETAIL SPD</h4>
                                    <hr style="margin-bottom:0px;border-top: 1.5px solid #000;"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a data-toggle="tab" href="#home"  class="nav-link active" role="tab" aria-controls="home" aria-selected="true" id="home-tab">Dokumen</a>
                                        </li>
                                        <!-- <li class="nav-item">
                                            <a data-toggle="tab" href="#menu1" class="nav-link" role="tab" aria-controls="menu1" aria-selected="false" id="menu1-tab">Referensi</a>
                                        </li> -->
                                        <li class="nav-item">
                                            <a data-toggle="tab" href="#menu2" class="nav-link" role="tab" aria-controls="menu2" aria-selected="false" id="menu2-tab">Atribut</a>
                                        </li>
                                        <li class="nav-item">
                                            <a data-toggle="tab" href="#menu3" class="nav-link" role="tab" aria-controls="menu3" aria-selected="false" id="menu3-tab">Riwayat</a>
                                        </li>
                                        <span class="labelShipment" id="lbl_doc_number">{{$data[0]->number}}</span>
                                    </ul> 
                                    <div class="tab-content">
                                        <div id="home" class="tab-pane fade active show" role="tabpanel" aria-labelledby="home-tab">
                                            <div class="row">
                                                <!-- <div class="col-lg-12" style="padding-left:0px !important;"> -->
                                                    <div class="col col-lg-6 col-md-12 col-xs-12" style="padding-left: 0px !important;">
                                                        <label class="col-lg-4 col-md-4 col-xs-4 shipmentLabel" style="font-weight: 700;vertical-align: top;padding-right:0px !important;">Customer</label>
                                                        <label class="col-lg-1 col-md-1 col-xs-1 shipmentLabel" style="vertical-align: top;padding-left:0px !important;padding-right:0px !important;text-align:center;width:20px !important;">:</label>
                                                        <label class="col-lg-6 col-md-6 col-xs-6 shipmentLabel" id="lbl_customer" name="lbl_customer" style="padding-left:0px !important;">{{$data[0]->customer_name}}</label>
                                                        <label class="col-lg-4 col-md-4 col-xs-4 shipmentLabel" style="font-weight: 700;vertical-align: top;padding-right:0px !important;">Order Number</label>
                                                        <label class="col-lg-1 col-md-1 col-xs-1 shipmentLabel" style="vertical-align: top;padding-left:0px !important;padding-right:0px !important;text-align:center;width:20px !important;">:</label>
                                                        <label class="col-lg-6 col-md-6 col-xs-6 shipmentLabel" id="lbl_order_number" name="lbl_order_number" style="padding-left:0px !important;"> 
                                                            @if (trim($data[0]->order_number) == '' || $data[0]->order_number == 'null')
                                                                -
                                                            @else
                                                                {{$data[0]->order_number}}
                                                            @endif
                                                        </label>
                                                        <label class="col-lg-4 col-md-4 col-xs-4 shipmentLabel" style="font-weight: 700;padding-right:0px !important;">Depo</label>
                                                        <label class="col-lg-1 col-md-1 col-xs-1 shipmentLabel" style="vertical-align: top;padding-left:0px !important;padding-right:0px !important;text-align:center;width:20px !important;">:</label>
                                                        <label class="col-lg-6 col-md-6 col-xs-6 shipmentLabel" id="lbl_route" name="lbl_route" style="padding-left:0px !important;">{{$data[0]->depo_name}}</label>
                                                        <label class="col-lg-4 col-md-4 col-xs-4 shipmentLabel" style="font-weight: 700;padding-right:0px !important;">Status SPD</label>
                                                        <label class="col-lg-1 col-md-1 col-xs-1 shipmentLabel" style="vertical-align: top;padding-left:0px !important;padding-right:0px !important;text-align:center;width:20px !important;">:</label>
                                                        <label class="col-lg-6 col-md-6 col-xs-6 shipmentLabel" id="lbl_driver" name="lbl_driver" style="padding-left:0px !important;">
                                                            @if($data[0]->status_spd == "-")
                                                                {{$data[0]->status_spd}}
                                                            @else
                                                                {{$data[0]->status_spd}}
                                                            @endif
                                                        </label>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-12 col-xs-12" style="padding-left: 0px !important;">
                                                        <label class="col-lg-4 col-md-4 col-xs-4 shipmentLabel" style="font-weight: 700;padding-right:0px !important;">Nama</label>
                                                        <label class="col-lg-1 col-md-1 col-xs-1 shipmentLabel" style="vertical-align: top;padding-right:0px !important;padding-left:0px !important;width:20px !important;">:</label>
                                                        <label class="col-lg-6 col-md-6 col-xs-6 shipmentLabel" id="lbl_driver_2" name="lbl_driver_2" style="padding-left:0px !important;">
                                                            @if($data[0]->driver_name == "-")
                                                                {{$data[0]->driver_id}}
                                                            @else
                                                                {{$data[0]->driver_id." - ".$data[0]->driver_name}}
                                                            @endif
                                                        </label>
                                                        <label class="col-lg-4 col-md-4 col-xs-4 shipmentLabel" style="font-weight: 700;padding-right:0px !important;">ERP Status</label>
                                                        <label class="col-lg-1 col-md-1 col-xs-1 shipmentLabel" style="vertical-align: top;padding-right:0px !important;padding-left:0px !important;width:20px !important;">:</label>
                                                        <label class="col-lg-6 col-md-6 col-xs-6 shipmentLabel" id="lbl_otm_status" name="lbl_otm_status" style="padding-left:0px !important;">{{$data[0]->status_erp}}</label>
                                                    </div>
                                                <!-- </div> -->
                                            </div>
                                            <!-- <div class="row"> -->
                                                <div class="col-lg-12" style="padding-left:0px !important;padding-right:0px !important">
                                                    <hr style="border-top: 1px solid #000;">
                                                    <div class="row">
                                                        <div class="col-lg-6 form-inline">
                                                            <label class="col-form-label" style="font-size: 12pt;padding-right: 1em;"><b>Jumlah Container</b></label>
                                                            <input type="text" class="form-control col-lg-4" name="kel_doc" id="kel_doc" value="{{$count_container}}" readonly/>
                                                        </div>
                                                        <div class="col-lg-6 form-inline">
                                                            <label class="col-form-label col-4" style="text-align:left;">Nilai SPD</label>
                                                            <input type="text" class="form-control col-7" name="nilai_spd" id="nilai_spd" value="{{$data[0]->amount_no_comma}}" style="font-weight:500;" readonly/>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            <!-- </div> -->
                                            <!-- <div class="row"> -->
                                                <div class="col-12">
                                                    <table id="tbl_kel_doc" name="tbl_kel_doc" class="table" style="width:100%">
                                                    </table>
                                                </div>
                                            <!-- </div> -->
                                            <!-- <div class="row"> -->
                                                <div class="col-lg-12" style="border-bottom: 1px solid #000;margin-bottom:2em;">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="clearfix" style="margin-top:1em;padding-bottom:6em;vertical-align:middle">
                                                                <label class="containerCheck" style="width:18px !important;">
                                                                    @if($data[0]->is_bundle)
                                                                        <input type="checkbox" name="checkBundlKwiKwit" id="checkBundlKwit" value="1" checked >
                                                                    @else
                                                                        <input type="checkbox" name="checkBundlKwit" id="checkBundlKwit" value="1">
                                                                    @endif
                                                                    <span class="checkmark"></span>
                                                                    <span style="vertical-align: middle;font-weight:700;font-style:italic;padding-left:8px">Dalam satu kuitansi</span>
                                                                </label>
                                                                <!-- <button class="btn" style="font-size: 14px;float:left;background:transparent !important; color:#0d66fa;font-weight:700;text-decoration: underline;" type="button" id="btnAddRow" name="btnAddRow">+ADD</button> -->
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="clearfix" style="margin-top:1em;padding-bottom:6em;vertical-align:middle;">
                                                                <div class="form-group form-inline">
                                                                    <label class="col-form-label col-4" style="margin-right:12px;text-align:left;">Total Kuitansi</label>
                                                                    <input type="text" class="form-control col-7" name="total_kwitansi" id="total_kwitansi" style="font-weight:500;" readonly/>
                                                                </div>
                                                                <!-- <div class="form-group form-inline">
                                                                    <label class="col-form-label col-4" style="margin-right:12px;text-align:left;">Nilai SPD</label>
                                                                    <input type="text" class="form-control col-7" name="nilai_spd" id="nilai_spd" value="{{$data[0]->amount_no_comma}}" style="font-weight:500;" readonly/>
                                                                </div> -->
                                                                <div class="form-group form-inline">
                                                                    <label class="col-form-label col-4" style="margin-right:12px;text-align:left;">Selisih</label>
                                                                    <input type="text" class="form-control col-7" name="selisih" id="selisih" style="font-weight:500;" readonly/>
                                                                </div>
                                                                <div class="form-group form-inline">
                                                                    <label class="col-form-label col-4" style="margin-right:12px;text-align:left;"></label>
                                                                    <!-- <input type="text" class="form-control col-7" name="selisih" id="selisih" style="font-weight:500;" readonly/> -->
                                                                    <select class="form-control col-7" id="selectPay">
                                                                        <option></option>
                                                                        <option>Cash</option>
                                                                        <option>Loan</option>
                                                                    </select>
                                                                </div>
                                                                <!-- <button class="btn" style="font-size: 14px;float:left;background:transparent !important; color:#0d66fa;font-weight:700;text-decoration: underline;" type="button" id="btnAddRow" name="btnAddRow">+ADD</button> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <!-- </div> -->
                                            
                                            <div class="col-lg-7">
                                                <div class="form-group" style="line-height: normal;margin-bottom: 0px;">
                                                    <label for="inputBarcode" style="font-weight: 700;font-size: 14px;">REGISTRASI BARCODE</label>
                                                        <div class="form-row">
                                                            @if(trim($data[0]->barcode_number) == '' || trim($data[0]->barcode_number) == 'null')
                                                                <div class="col-6">
                                                                    <input type="text" class="form-control" id="inputBarcode" name="inputBarcode">
                                                                </div>
                                                                <div class="col-3">
                                                                    <button class="btn btn-info" style="font-size: 14px;margin-left: 1em;" type="button" id="btnReg" name="btnReg" onclick="pairingBarcode(2);">REGISTRASI</button>
                                                                </div>
                                                            @else
                                                                <div class="col-6">
                                                                    <input type="text" class="form-control" id="inputBarcode" value="{{$data[0]->barcode_number}}" readonly>
                                                                </div>
                                                                <div class="col-3">
                                                                    <button class="btn btn-info" style="font-size: 14px;margin-left: 1em;" id="btnReg" name="btnReg" DISABLED>REGISTRASI</button>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        
                                                    <!-- </div> -->
                                                    <i><p style="font-size: 12px;margin-bottom: 0px;">Pastikan anda telah melakukan penempelan barcode pada spk dan telah sesuai</p></i>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div id="menu1" class="tab-pane fade" role="tabpanel" aria-labelledby="menu1-tab">
                                            <div class="col-lg-12 clearfix" style="margin-top:1em;margin-bottom:2em">
                                                <label style="color:#1d1e4b;font-size:16px;font-weight:700;padding-right: 1em;float:left">ADDITIONAL COST</label>
                                                <p style="font-size: 12px;float:right">OTM Add Cost Status: <b style="color:#1d1e4b;">Add Cost - ApproveD</b></p>
                                            </div>
                                            
                                            <table id="refTable" class="table" style="border-top-color:#ddd;">
                                                <thead>
                                                    <tr>
                                                        <th style="vertical-align:top;">NO</th>
                                                        <th>CUSTOMER</th>
                                                        <th>ROUTE</th>
                                                        <th>COST DESCRIPTION</th>
                                                        <th>ADVANCE COST</th>
                                                        <th>KUITANSI</th>
                                                        <th>TANGGAL</th>
                                                        <th>NILAI</th>
                                                        <th>REMARKS</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="border-bottom: 1px solid #dee2e6;">
                                                    <tr>
                                                        <td>1.</td>
                                                        <td>System Architect</td>
                                                        <td>Edinburgh</td>
                                                        <td>61</td>
                                                        <td>2011/04/25</td>
                                                        <td>
                                                            <center><label class="containerCheck">
                                                                <input type="checkbox">
                                                                <span class="checkmark"></span>
                                                            </label></center>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"/>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"/>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"/>
                                                        </td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                        </div> -->
                                        <div id="menu2" class="tab-pane fade" role="tabpanel" aria-labelledby="menu2-tab">
                                            <!-- <div class="row"> -->
                                            <div class="col-lg-12" style="padding-left:0px !important;padding-right:0px !important">
                                                    <div class="col-lg-6 form-group form-inline"  style="padding-left:0px !important;padding-right:0px !important">
                                                        <label class="col-form-label" style="font-size: 12pt;padding-right: 1em;"><b>ATRIBUT</b></label>
                                                        <select class="form-control col-lg-4" name="kel_doc_attr" id="kel_doc_attr">
                                                            <option value="-1">PILIH PROJECT</option>
                                                            @foreach($mstProject as $project)
                                                                <option value="{{$project->id}}">{{$project->project_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            <!-- </div> -->
                                            <div class="col-lg-12">
                                                <table id="tbl_attr" class="table" style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th style="vertical-align:top;">No.</th>
                                                            <th>ATRIBUT</th>
                                                            <th>LABEL</th>
                                                            <th>VALUE</th>
                                                            <th>DATE</th>
                                                            <th>REMARK</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                            
                                            <div class="clearfix" style="margin-top:1em;margin-bottom:2em;border-bottom: 1px solid #000;padding-bottom:6em;">
                                                <button class="btn" style="font-size: 14px;float:left;background:transparent !important; color:#0d66fa;font-weight:700;text-decoration: underline;" type="button" id="btnAddRowAttr" name="btnAddRowAttr">+ADD</button>
                                            </div>
                                        </div>
                                        <div id="menu3" class="tab-pane fade" role="tabpanel" aria-labelledby="menu3-tab">
                                            <!-- <div class="row"> -->
                                                <div class="col-lg-12" style="padding-left:0px !important;padding-right:0px !important">
                                                    <div class="col-lg-6 form-group form-inline"  style="padding-left:0px !important;padding-right:0px !important">
                                                        <label class="col-form-label" style="font-size: 12pt;padding-right: 1em;"><b>HISTORY LOG DOCUMENT</b></label>
                                                    </div>
                                                </div>
                                            <!-- </div> -->
                                            <!-- <div class="row"> -->
                                                <div class="col-lg-12">
                                                    <table id="tbl_history" class="table" style="width:100%;">
                                                    </table>
                                                </div>
                                            <!-- </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- /.row -->
            </div>
        </div><!-- /# column -->
    </div>

    <div class="row">
        <div class="col-lg-12 clearfix">
            <button type="button" class="btn btn-info float-right" onClick="submitDoc();">SUBMIT</button>
            <button class="btn btn-info float-right" style="background: transparent;color: #0d66fa;border: 0px; margin-right: 16px;" onClick="goBack()" type="button">BATAL</button>
        </div>
    </div>
</form>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <label class="modal-title" id="exampleModalLabel">Perhatian!</label>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary col-md-6" id="btnTidak" data-dismiss="modal">TIDAK</button>
        <button type="button" class="btn btn-primary col-md-6" id="btnYa">YA</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="{{ asset('ElaAdminAsset/assets/js/lib/ext/accounting.min.js') }}"></script>
<script src="{{ asset('autoNumeric/autoNumeric.js') }}"></script>
    <script type="text/javascript">
        var table;
        var tableAttr;
        (function($) {
            $(document).ready(function() {
                console.log('tets');
                console.log('{{$data[0]->selisih_tipe}}');
                

                $('#selectPay').val('{{$data[0]->selisih_tipe}}');
                window.addEventListener("keyup", function(e){ if(e.keyCode == 27) history.back(); }, false);

                $('#nilai_spd').val(accounting.formatNumber({{$data[0]->amount_no_comma}}));

                // $(window).keydown(function(event){
                //     if(event.keyCode == 13) {
                //         event.preventDefault();
                //         return false;
                //     }
                // });

                

                if ({{$verified}} != null) {
                    $("#kel_doc_attr").val({{$verified}});
                    $("#kel_doc_attr").select2({disabled:true});
                }

                $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    var target = $(e.target).attr("href"); // activated tab
                    if (target == '#menu3') {
                        tableHistory.ajax.reload();
                    }
                });

                tableAttr = $('#tbl_attr').DataTable({
                    ajax: {
                        url: '/getDataAttr',
                        type:"POST",
                        dataSrc:'',
                        data : {
                            number: $('#lbl_doc_number').text(),
                            project: (({{$verified}} != null) ? 'inserted' : function() { return $('#kel_doc_attr').val() })
                        }
                    },
                    "ordering":false,
                    "bLengthChange" : false, //thought this line could hide the LengthMenu\
                    "bInfo":false,
                    "paging":   false,
                    "searching": false,
                    // 'columnDefs': [
                    //     {
                    //         "targets": 0, // your case first column
                    //         "className": "text-center",
                    //         "width": "30px"
                    //     },
                    //     {
                    //         "targets": [1], // your case first column
                    //         "className": "text-left",
                    //         "width": "200px"
                    //     },
                    //     {
                    //         "targets": [2,3,4,5], // your case first column
                    //         "className": "text-center"
                    //     },
                    // ],
                    "columns":[
                        {   
                            orderable: false, 
                            className: 'dt-td-center',
                            title: 'No.',
                            render: function(data, type, full, meta)
                            {
                                console.log(meta['row']);
                                if (full.id) {
                                    return '<label>'+full.id+'</label>';    
                                } 

                                return '<label>0</label>';
                                
                            }
                        },
                        {   
                            orderable: false, 
                            className: 'dt-td-center',
                            title: 'ATTRIBUT',
                            render: function(data, type, full, meta)
                            {
                                console.log(meta['row']);
                                if (full.attribut) {
                                    return '<input type="text" class="form-control attr" name="attr_'+meta["row"]+'" style="box-sizing:border-box;" readonly value="'+full.attribut+'"/>';    
                                } 

                                return '<input type="text" class="form-control attr" name="attr_'+meta["row"]+'" style="box-sizing:border-box;"/>';
                                
                            }
                        },
                        {   
                            orderable: false, 
                            className: 'dt-td-center',
                            title: 'LABEL',
                            render: function(data, type, full, meta)
                            {
                                console.log(meta['row']);
                                if (full.label) {
                                    return '<input type="text" class="form-control lbl_attr" name="lbl_attr_'+meta["row"]+'" style="box-sizing:border-box;" readonly value="'+full.label+'"/>';    
                                } 

                                return '<input type="text" class="form-control lbl_attr" name="lbl_attr_'+meta["row"]+'" style="box-sizing:border-box;"/>';
                                
                            }
                        },
                        {   
                            orderable: false, 
                            className: 'dt-td-center',
                            title: 'VALUE',
                            render: function(data, type, full, meta)
                            {
                                console.log(meta['row']);
                                if (full.value) {
                                    return '<input type="text" class="form-control value_attr" name="value_attr_'+meta["row"]+'" style="box-sizing:border-box;" readonly value="'+full.value_no_comma+'"/>';    
                                } 

                                return '<input type="text" class="form-control value_attr" name="value_attr_'+meta["row"]+'" style="box-sizing:border-box;"/>';
                                
                            }
                        },
                        {   
                            orderable: false, 
                            className: 'dt-td-center',
                            title: 'DATE',
                            render: function(data, type, full, meta)
                            {
                                if (full.date) {
                                    return '<div class="input-group has-feedback">'+
                                            '<input type="text" class="form-control form_datetime date_attr"  name="date_attr_'+meta["row"]+'" placeholder="yyyy-mm-dd" readonly value="'+full.date+'">'+
                                                '<div class="input-group-append">'+
                                                    '<div class="input-group-text"><i class="form-control-feedback fa fa-calendar"></i></div>'+
                                                '</div>'+
                                            '</div>';
                                }
                                return '<div class="input-group has-feedback">'+
                                            '<input type="text" class="form-control form_datetime date_attr"  name="date_attr_'+meta["row"]+'" placeholder="yyyy-mm-dd" readonly>'+
                                                '<div class="input-group-append">'+
                                                    '<div class="input-group-text"><i class="form-control-feedback fa fa-calendar"></i></div>'+
                                                '</div>'+
                                            '</div>';
                                
                            }
                        },
                        {   
                            orderable: false, 
                            className: 'dt-td-center',
                            title: 'KETERANGAN',
                            render: function(data, type, full, meta)
                            {
                                if (full.remark) {
                                    return '<input type="text" class="form-control remark_attr" style="box-sizing:border-box;" name="remark_attr_'+meta["row"]+'" value="'+full.remark+'"/>';
                                }
                                return '<input type="text" class="form-control remark_attr" style="box-sizing:border-box;" name="remark_attr_'+meta["row"]+'"/>';
                                
                            }
                        },
                        {   
                            orderable: false, 
                            className: 'dt-td-center',
                            title: '',
                            render: function(data, type, full, meta)
                            {

                                return '<span><img id="deleteDetailAttr" class="deleteDetailAttr" onClick="openModal(\'deleteAttr\','+meta["row"]+');" src="{{ asset('icon/trash.png')}}"></span>';
                                
                            }
                        },
                        {
                            title:'ID',
                            orderable: false, 
                            className: 'dt-td-center',
                            visible:false,
                            render: function(data, type, full, meta)
                            {
                                if (full.id) {
                                    return '<input type="text" style="width:20px" class="id_attr" name="id_attr_'+meta["row"]+'" value="'+full.id+'"/>';
                                }
                                return '<input type="text" style="width:20px" class="id_attr" name="id_attr_'+meta["row"]+'" value=""/>';
                                
                            }
                        },
                    ],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull )
                    {
                        var index = iDisplayIndex +1;
                        $('td:eq(0)',nRow).text(index);
                        $('td:eq(1) .attr',nRow).attr('name', 'attr_'+iDisplayIndex);
                        $('td:eq(2) .lbl_attr',nRow).attr('name', 'lbl_attr_'+iDisplayIndex);
                        $('td:eq(3) .value_attr',nRow).attr('name', 'value_attr_'+iDisplayIndex);
                        $('td:eq(4) .date_attr',nRow).attr('name', 'date_attr_'+iDisplayIndex);
                        $('td:eq(5) .remark_attr',nRow).attr('name', 'remark_attr_'+iDisplayIndex);
                        $('td:eq(6) .deleteDetailAttr',nRow).attr('onClick', 'openModal(\'deleteAttr\','+iDisplayIndex+');');
                        $('td:eq(7) .id_attr',nRow).attr('name', 'id_attr_'+iDisplayIndex);
                        $('td:eq(3) .value_attr',nRow).autoNumeric('init',{aPad: false,aSep: ',',aDec:'.'});
                        $(".form_datetime").datetimepicker({
                            autoclose:true,
                            minView : 2,
                            format:'yyyy-mm-dd'
                        });
                        return nRow;
                    },
                });
                $('#tbl_attr_wrapper').children().eq(1).children().css( "padding-left", "0px" );
                $('#tbl_attr_wrapper').children().eq(1).children().css( "padding-right", "0px" );
                $('#tbl_attr_wrapper').children().eq(1).css( "width", "100%" );

                $("#btnAddRowAttr").on('click', function() {
                    console.log(tableAttr.rows().count());
                    var index = tableAttr.rows().count();
                    tableAttr.row.add( [
                        -1,
                        '<input type="text" class="form-control attr" name="attr_0" style="box-sizing:border-box;"/>',
                        '<input type="text" class="form-control lbl_attr" name="lbl_attr_0" style="box-sizing:border-box;"/>',
                        '<input type="text" class="form-control value_attr" name="value_attr_0" style="box-sizing:border-box;"/>',
                        '<div class="input-group has-feedback">'+
                                            '<input type="text" class="form-control form_datetime date_attr"  name="date_attr_0" placeholder="yyyy-mm-dd" readonly>'+
                                                '<div class="input-group-append">'+
                                                    '<div class="input-group-text"><i class="form-control-feedback fa fa-calendar"></i></div>'+
                                                '</div>'+
                                            '</div>',
                        '<input type="text" class="form-control remark_attr" style="box-sizing:border-box;" name="remark_attr_0"/>',
                        '<span><img id="deleteDetailAttr" class="deleteDetailAttr" onClick="deleteDetailAttr(0);" src="{{ asset('icon/trash.png')}}"></span>',
                        '<input type="text" style="width:20px" class="id_attr" name="id_attr_0" value=""/>'
                    ] ).draw(); 
                    $(".form_datetime").datetimepicker({
                        autoclose:true,
                        minView : 2,
                        format:'yyyy-mm-dd'
                    });
                });
                
                table = $('#tbl_kel_doc').DataTable({
                    ajax: {
                        url: '/getDataContainer',
                        type:"POST",
                        dataSrc:'',
                        data : {
                            number: $('#lbl_doc_number').text()
                        }
                    },
                    "ordering":false,
                    "bLengthChange" : false, //thought this line could hide the LengthMenu\
                    "bInfo":false,
                    "paging":   false,
                    "searching": false,
                    "initComplete": function( settings, json ) {
                        var jumlah = 0;
                        for (let index = 0; index < json.length; index++) {
                            //    const element = array[index];
                            console.log(json[index]['nilai_kuitansi']);
                            nilai = (json[index]['nilai_kuitansi'] == '' || json[index]['nilai_kuitansi'] == null) ? 0 : json[index]['nilai_kuitansi'];
                            jumlah += parseInt(accounting.unformat(nilai));
                        }
                        
                        $('#total_kwitansi').val(accounting.formatNumber(jumlah));
                        nilaiSPD = ($('#nilai_spd').val() == '' || $('#nilai_spd').val() == null) ? 0 : $('#nilai_spd').val();
                        var selisih = parseInt(accounting.unformat(nilaiSPD))- jumlah;
                        $('#selisih').val(accounting.formatNumber(selisih));
                    },
                    "columns":[
                        {   
                            orderable: false, 
                            className: 'dt-td-center',
                            title: 'KUITANSI',
                            render: function(data, type, full, meta)
                            {
                                console.log(full.is_available);
                                if (full.is_available) {
                                    return '<label class="containerCheck" style="width:18px !important;"><input type="checkbox" name="ada_check_'+meta["row"]+'" value="1" checked><span class="checkmark"></span></label>';    
                                }
                                return '<label class="containerCheck" style="width:18px !important;"><input type="checkbox" name="ada_check_'+meta["row"]+'" value="1"><span class="checkmark"></span></label>';
                                
                            }
                        },
                        {   
                            orderable: false, 
                            title: 'CONTAINER',
                            render: function(data, type, full, meta)
                            {
                                console.log(meta['row']);
                                if (full.container) {
                                    return full.container;//'<input type="text" class="form-control jen-doc" name="jenis_doc_'+meta["row"]+'" style="box-sizing:border-box;" readonly value="'+full.container+'"/>';    
                                }

                                return full.container;//'<input type="text" class="form-control jen-doc" name="jenis_doc_'+meta["row"]+'" style="box-sizing:border-box;"/>';
                                
                            }
                        },
                        {   
                            orderable: false, 
                            title: 'PANJANG',
                            render: function(data, type, full, meta)
                            {
                                if (full.fleet) {
                                    return '<input type="text" class="form-control jen-doc" name="panjang_'+meta["row"]+'" style="box-sizing:border-box;" value="'+full.fleet+'" readonly/>';
                                }
                                return '<input type="text" class="form-control jen-doc" name="panjang_'+meta["row"]+'" style="box-sizing:border-box;"/>';
                                
                            }
                        },
                        {   
                            orderable: false, 
                            title: 'TIPE',
                            render: function(data, type, full, meta)
                            {
                                if (full.type) {
                                    return '<input type="text" class="form-control nilai-doc" style="box-sizing:border-box;" name="nilai_'+meta["row"]+'" value="'+full.type+'" readonly/>';    
                                }
                                return '<input type="text" class="form-control nilai-doc" style="box-sizing:border-box;" name="nilai_'+meta["row"]+'"/>';
                                
                            }
                        },
                        {   
                            orderable: false, 
                            title: 'CONTAINER PENGGANTI',
                            render: function(data, type, full, meta)
                            {
                                if (full.container_pengganti) {
                                    return '<input type="text" class="form-control remark-doc" style="box-sizing:border-box;" name="remarks_'+meta["row"]+'" value="'+full.container_pengganti+'"/>';
                                }
                                return '<input type="text" class="form-control remark-doc" style="box-sizing:border-box;" name="remarks_'+meta["row"]+'"/>';
                                
                            }
                        },
                        {   
                            orderable: false, 
                            title: 'JUMLAH KUITANSI',
                            render: function(data, type, full, meta)
                            {

                                if (full.nilai_kuitansi) {
                                    return '<input type="text" class="form-control jml-kwit" style="box-sizing:border-box;" id="jml_kwt_'+meta["row"]+'" onchange="calculate(this)" value="'+full.nilai_kuitansi+'"/>';
                                }
                                return '<input type="text" class="form-control jml-kwit" style="box-sizing:border-box;" id="jml_kwt_'+meta["row"]+'" onchange="calculate(this)"/>';
                                
                            }
                        },
                        {
                            title:'ID',
                            orderable: false, 
                            className: 'dt-td-center',
                            visible:false,
                            render: function(data, type, full, meta)
                            {
                                if (full.id) {
                                    return '<input type="text" style="width:20px" class="id-table" name="id_'+meta["row"]+'" value="'+full.id+'"/>';
                                }
                                return '<input type="text" style="width:20px" class="id-table" name="id_'+meta["row"]+'" value=""/>';
                                
                            }
                        },
                    ],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull )
                    {
                        var index = iDisplayIndex +1;
                        $('td:eq(5) .jml-kwit',nRow).autoNumeric('init',{aPad: false,aSep: ',',aDec:'.'});
                        console.log(nRow);
                        return nRow;
                    },
                    // 'columnDefs': [
                    //     {
                    //         "targets": [0], // your case first column
                    //         "className": "text-center",
                    //         "width": "18px"
                    //     },
                    //     {
                    //         "targets": [1], // your case first column
                    //         "className": "text-left",
                    //         "width": "200px"
                    //     },
                    //     {
                    //         "targets": [2,3,4,5], // your case first column
                    //         "className": "text-center"
                    //     },
                    // ]
                });

                $("#kel_doc").on("change", function (e) { 
                    console.log($('#kel_doc').val());
                    $('#tbl_kel_doc').DataTable().ajax.reload()
                });

                $('#tbl_kel_doc_wrapper').children().eq(1).children().css( "padding-left", "0px" );
                $('#tbl_kel_doc_wrapper').children().eq(1).children().css( "padding-right", "0px" );            
                $('#tbl_kel_doc_wrapper').children().eq(1).css( "width", "100%" );
                $( table.table().container() ).removeClass( 'form-inline' );
                $( table.table().container() ).removeClass( 'no-footer' );

                tableHistory = $('#tbl_history').DataTable({
                    ajax: {
                        url: '/getHistory',
                        type:"POST",
                        dataSrc:'',
                        data : {
                            number: $('#lbl_doc_number').text()
                        }
                    },
                    "ordering":false,
                    "bLengthChange" : false, //thought this line could hide the LengthMenu\
                    "bInfo":false,
                    "paging":   false,
                    "searching": false,
                    "columns":[
                        {title:'No', data:'id'},
                        {title:'DATE LOG', data:'created_at'},
                        {title:'TIME', data:'created_at'},
                        {title:'USER', data:'user_id'},
                        {title:'STATUS', data:'status_name'},
                        {title:'REMARK', data:'remark'},
                    ],
                    'columnDefs': [
                        {
                            "targets": 0, // your case first column
                            "className": "text-center",
                            "width": "30px"
                        },
                        {
                            "targets": [1], // your case first column
                            "className": "text-center",
                            "width": "200px",
                            render:function(data){
                               return moment(data).format('DD-MM-YYYY');
                            }
                        },
                        {
                            "targets": [2], // your case first column
                            "className": "text-center",
                            render:function(data){
                               return moment(data).format('HH:mm');
                            }
                        },
                        {
                            "targets": [3,4,5], // your case first column
                            "className": "text-center",
                        },
                    ],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull )
                    {
                        var index = iDisplayIndex +1;
                        $('td:eq(0)',nRow).text(index);
                    }
                });

                $('#tbl_history_wrapper').children().eq(1).children().css( "padding-left", "0px" );
                $('#tbl_history_wrapper').children().eq(1).children().css( "padding-right", "0px" );
                $('#tbl_history_wrapper').children().eq(1).css( "width", "100%" );

                $("#btnAddRow").on('click', function() {
                    console.log(table.rows().count());
                    var index = table.rows().count();
                    table.row.add( [
                        '<label class="containerCheck" style="width:18px !important;"><input type="checkbox" name="ada_check_'+index+'" value="1"><span class="checkmark"></span></label>',
                        '<input type="text" class="form-control jen-doc" name="jenis_doc_'+index+'" style="box-sizing:border-box;"/>',
                        '<div class="input-group has-feedback">'+
                        '<input type="text" class="form-control form_datetime date-doc"  name="tanggal_'+index+'" placeholder="yyyy-mm-dd hh:mm" readonly>'+
                            '<div class="input-group-append">'+
                                '<div class="input-group-text"><i class="form-control-feedback fa fa-calendar"></i></div>'+
                            '</div>'+
                            
                        '</div>',
                        '<input type="text" class="form-control nilai-doc" style="box-sizing:border-box;" name="nilai_'+index+'" />',
                        '<input type="text" class="form-control remark-doc" style="box-sizing:border-box;" name="remarks_'+index+'" />',
                        '<span><img id="deleteDetail" class="deleteDetail" onClick="deleteDetails(0);" src="{{ asset('icon/trash.png')}}"></span>',
                        '<input type="text"/>'
                    ] ).draw(); 
                $(".form_datetime").datetimepicker({
                    autoclose:true
                });

                $('#inputBarcode').keypress(function (e) {
                    // e.preventDefault();
                    var key = e.which;
                    value = $(this).val();
                    
                    if(key == 13)  // the enter key code
                    {
                        if (value.length > 6) {
                            toastr.warning("Nomor barcode tidak sesuai.");
                            $(this).val('');
                            return false;    
                        }
                        e.preventDefault();
                        
                    }
                });  
            });

        });

        
    })(jQuery);

    function deleteDetails(index) {
        (function($) {
            table.row(index).remove().draw();
            
            console.log( table.page.info()['recordsTotal']); 
        })(jQuery);
    }

    function pairingBarcode(type) {
        (function($) {

            
            count = $('#inputBarcode').val();
            if (count.length > 6) {
                toastr.warning("Nomor barcode tidak sesuai.");
                $('#inputBarcode').val('');
                return false;
            }
            if($('#inputBarcode').val() == ''){
                $('#inputBarcode').focus();
                $('#inputBarcode').addClass('is-invalid');
                return;
            }
            $.ajax({
                method: "POST",
                url: "{{route('pairingBarcode')}}",
                data: { 
                    doc_number: $('#lbl_doc_number').text(), 
                    barcode:  $('#inputBarcode').val(),
                    type:type
                },
                success: function (data) { 
                    if(data.stat == 1){
                        $('#inputBarcode').prop('disabled', true);
                        $('#btnReg').prop('disabled',true);
                        toastr.success(data.msg);
                    } else {
                        $('#inputBarcode').val('');
                        toastr.warning(data.msg);
                    }
                    
                },
                error: function (jqXHR, textStatus, errorThrown) { 
                    toastr.error(errorThrown,textStatus);
                }
            });
        })(jQuery);
    }

    function goBack() {
        window.history.back();
    }

    function submitDoc() {
        

        (function($) {
            let html = '';
            $('.modal-body').empty();
            if ("{{Session::get('role')}}" == 'Admin Operation Exim' && $('#inputBarcode').val() != '') {
                html = 
                '<label class="control-label" style="color: #1d1e4b;">Apakah anda yakin ingin melanjutkan proses?</label>'+
                '<textarea class="form-control" id="textAlasan" rows="5" style="resize:none;" placeholder="isi catatan"></textarea>';    
                $('#btnTidak').text("TIDAK");
                $('#btnYa').text("YA");
                $('#btnYa').attr('onclick', 'actionButton("PAIR")');
            } else if ($('#inputBarcode').val() == '') {
                html = 
                '<label class="control-label" style="color: #1d1e4b;">Anda belum Melakukan Pairing Document dengan Barcode, Lanjutkan?</label>'+
                '<textarea class="form-control" id="textAlasan" rows="5" style="resize:none;" placeholder="isi catatan"></textarea>';    
                $('#btnTidak').text("TIDAK");
                $('#btnYa').text("YA");
                $('#btnYa').attr('onclick', 'actionButton("NOT_PAIR")');
            } else {
                html = 
                '<label class="control-label" style="color: #1d1e4b;margin-bottom:2em;">Anda akan melakukan Proses Registrasi Dokumen, apakah dokumen sudah lengkap ?</label>'+
                '<div class="form-check">'+
                    '<input class="form-check-input" type="radio" name="radioDoc" id="radioDocLengkap" value="lengkap" checked>'+
                    '<label class="form-check-label" for="radioDocLengkap">'+
                        'Lengkap'+
                    '</label>'+
                '</div>'+
                '<div class="form-check">'+
                    '<input class="form-check-input" type="radio" name="radioDoc" id="radioDocTidakLengkap" value="tidak lengkap">'+
                    '<label class="form-check-label" for="radioDocTidakLengkap">'+
                        'Tidak Lengkap'+
                    '</label>'+
                '</div>'+
                '<textarea class="form-control" id="textAlasan" rows="5" style="resize:none;" placeholder="isi catatan"></textarea>';    
                $('#btnTidak').removeAttr( "data-dismiss" )
                $('#btnTidak').text("PENDING");
                $('#btnTidak').attr('onclick', 'actionButton("PENDING")');
                $('#btnYa').text("SETTLE");
                $('#btnYa').attr('onclick', 'actionButton("SETTLE")');
            }
            
            $('.modal-body').append(html);
            $('#exampleModal').modal('show');
            
        })(jQuery);
    }

    function actionButton(params) {
        (function($) {
            var dataPelengkap = new Array();
            var dataAttribut = new Array();
            table.rows().every(function () {
                var html = this.node();
                var row = {};
                row['isExist'] = $('td:eq(0) .containerCheck input[type="checkbox"]:checked',html).val() != undefined ? $('td:eq(0) .containerCheck input[type="checkbox"]:checked',html).val() : 0;
                row['container'] = $('td:eq(1)',html).text();
                row['panjang'] = $('td:eq(2) .jen-doc',html).val();
                row['type'] = $('td:eq(3) .nilai-doc',html).val();
                row['container_pengganti'] = $('td:eq(4) .remark-doc',html).val();
                row['jml_kwt'] = $('td:eq(5) .jml-kwit',html).val();
                row['id'] = this.data()["id"] != undefined ? this.data()["id"] : '';
                dataPelengkap.push(row);
            });

            tableAttr.rows().every(function () {
                var html = this.node();
                var row = {};
                console.log(this.data());
                
                row['attribut'] = $('td:eq(1) .attr',html).val();
                row['attribut_label'] = $('td:eq(2) .lbl_attr',html).val();
                row['attribut_value'] = $('td:eq(3) .value_attr',html).val();
                row['attribut_date'] = $('td:eq(4) .date_attr',html).val();
                row['attribut_remark'] = $('td:eq(5) .remark_attr',html).val();
                row['attribut_id'] = this.data()["id"] != undefined ? this.data()["id"] : '';
                dataAttribut.push(row);
            });
            console.log(dataPelengkap);
            $.ajax({
                method: "POST",
                url: "{{route('submitRegDocSPD')}}",
                data: { 
                    kel_doc: $('#kel_doc').val(), 
                    dataKelengkapan:  dataPelengkap,
                    dataAttribut: dataAttribut,
                    doc_number: $('#lbl_doc_number').text(),
                    catatan : $('#textAlasan').val(),
                    kel_doc_attr : $('#kel_doc_attr').val(),
                    bundle_kwit:($('#checkBundlKwit:checked').val() != 1) ? 0 : 1,
                    kelengkapan : $("input[name='radioDoc']:checked").val(),
                    total_kwit:$('#total_kwitansi').val(),
                    nilai_spd:$('#nilai_spd').val(),
                    selisih:$('#selisih').val(),
                    selisih_tipe:$('#selectPay').val(),
                    type : params
                },
                success: function (data) { 
                    if(data.stat == 1){
                        window.location.replace("{{url('/regDocSPD')}}");
                    } else {
                        toastr.warning(data.msg);
                        $('#exampleModal').modal('hide');
                    }
                    
                },
                error: function (jqXHR, textStatus, errorThrown) { 
                    toastr.error(errorThrown,textStatus);
                }
            });
        })(jQuery);
    }

    function openModal(params,row){
        let html = '';
        (function($) {
            $('.modal-body').empty();
            if (params == 'deleteKel') {
                html = 
                '<label class="control-label" style="color: #1d1e4b;">Anda akan menghapus data kelengkapan</label>';
                $('#btnTidak').text("TIDAK");
                $('#btnYa').text("YA");
                $('#btnYa').attr('onclick', 'deleteDetails('+row+')');
            } else if(params == 'deleteAttr'){
                html = 
                '<label class="control-label" style="color: #1d1e4b;">Anda akan menghapus data attribut</label>';
                $('#btnTidak').text("TIDAK");
                $('#btnYa').text("YA");
                $('#btnYa').attr('onclick', 'deleteDetailAttrs('+row+')');
            }

            $('.modal-body').append(html);
            $('#exampleModal').modal('show');
        })(jQuery);
    }

    function calculate(param) {
        (function($) {    
            jumlah = 0;
            table.rows().every(function () {
                var html = this.node();
                nilai = ($('td:eq(5) .jml-kwit',html).val() == ''||$('td:eq(5) .jml-kwit',html).val() == null) ? 0 : $('td:eq(5) .jml-kwit',html).val();
                jumlah += parseInt(nilai.replace(/,/g,''));
            });
            
            $('#total_kwitansi').val(accounting.formatNumber(jumlah));
            nilaiSPD = ($('#nilai_spd').val() == '' || $('#nilai_spd').val() == null) ? 0 : $('#nilai_spd').val();
            var selisih = jumlah - parseInt(accounting.unformat(nilaiSPD));
            $('#selisih').val(accounting.formatNumber(selisih));
        })(jQuery);
    }

    function deleteDetailAttrs(index) {
        (function($) {
            var data = tableAttr.row( index ).data();

            console.log(data['id']);

            if (data['id'] != '' && data['id'] != undefined) {
                $.ajax({
                    method: "POST",
                    url: "{{route('actionDeleteDetail')}}",
                    data: { 
                        detail_id: data['id'],
                        type:2
                    },
                    success: function (data) { 
                        if(data.stat == 1){
                            toastr.success(data.msg,'Success');
                            tableAttr.row(index).remove().draw();
                            $('#exampleModal').modal('hide');
                        } else {
                            toastr.warning(data.msg,'Warning');
                        }
                        
                    },
                    error: function (jqXHR, textStatus, errorThrown) { 
                        toastr.error(errorThrown,textStatus);
                    }
                }); 
                
            } else {
                tableAttr.row(index).remove().draw();
                $('#exampleModal').modal('hide');
            }
            console.log( tableAttr.page.info()['recordsTotal']); 
        })(jQuery);
    }

        
    </script>
@endsection