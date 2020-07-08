@extends('layout.master')

@section('title','Proccess Document - SPK')

@section('css')
<style type="text/css">
    .shipmentLabel {
        font-size: 14px;
        font-weight: 500;
        vertical-align: top;
        text-transform: capitalize;
        color : #1d1e4b;
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

    #tbl_attr tbody tr td {
        padding:0.75rem !important;
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
                               
                                <?php if($type== 1){ ?>
                                <h4 id="detailJudul" style="font-weight:600;color:#1d1e4b;">DETAIL SPK FINANCE</h4>
                                <?php }  else { ?>

                                    <h4 id="detailJudul" style="font-weight:600;color:#1d1e4b;">DETAIL SPK TRAILER FINANCE</h4>
                                <?php } ?>
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
                                                        <label class="col-lg-4 col-md-4 col-xs-4 shipmentLabel" style="font-weight: 700;vertical-align: top;padding-right:0px;">Barcode</label>
                                                        <label class="col-lg-1 col-md-1 col-xs-1 shipmentLabel" style="vertical-align: top;width:20px !important;padding-right:0px;padding-left:0px;text-align:center;">:</label>
                                                        <label class="col-lg-6 col-md-6 col-xs-6 shipmentLabel" id="lbl_barcode" name="lbl_barcode" style="padding-left:0px;">{{$data[0]->barcode_number}}</label>
                                                        <label class="col-lg-4 col-md-4 col-xs-4 shipmentLabel" style="font-weight: 700;vertical-align: top;padding-right:0px;">Customer</label>
                                                        <label class="col-lg-1 col-md-1 col-xs-1 shipmentLabel" style="vertical-align: top;width:20px !important;padding-right:0px;padding-left:0px;text-align:center;">:</label>
                                                        <label class="col-lg-6 col-md-6 col-xs-6 shipmentLabel" id="lbl_customer" name="lbl_customer" style="padding-left:0px;">{{$data[0]->customer}}</label>
                                                        <label class="col-lg-4 col-md-4 col-xs-4 shipmentLabel" style="font-weight: 700;vertical-align: top;padding-right:0px;">Unit</label>
                                                        <label class="col-lg-1 col-md-1 col-xs-1 shipmentLabel" style="vertical-align: top;width:20px !important;padding-right:0px;padding-left:0px;text-align:center;">:</label>
                                                        <label class="col-lg-6 col-md-6 col-xs-6 shipmentLabel" id="lbl_unit" name="lbl_unit" style="padding-left:0px;">{{$data[0]->unit}}</label>
                                                        <label class="col-lg-4 col-md-4 col-xs-4 shipmentLabel" style="font-weight: 700;vertical-align: top;padding-right:0px;">Order Number</label>
                                                        <label class="col-lg-1 col-md-1 col-xs-1 shipmentLabel" style="vertical-align: top;width:20px !important;padding-right:0px;padding-left:0px;text-align:center;">:</label>
                                                        <label class="col-lg-6 col-md-6 col-xs-6 shipmentLabel" id="lbl_order_number" name="lbl_order_number" style="padding-left:0px;"> 
                                                            @if (trim($data[0]->order_number) == '' || $data[0]->order_number == 'null')
                                                                -
                                                            @else
                                                                {{$data[0]->order_number}}
                                                            @endif
                                                        </label>
                                                        @if (trim($data[0]->ccms_number) == '' || $data[0]->ccms_number == 'null' || $data[0]->ccms_number == '-')
                                                            <label class="col-lg-4 col-md-4 col-xs-4 shipmentLabel" style="font-weight: 700;opacity:0.5;padding-right:0px;">CCMS Number</label>
                                                            <label class="col-lg-1 col-md-1 col-xs-1 shipmentLabel" style="vertical-align: top;opacity:0.5;width:20px !important;padding-right:0px;padding-left:0px;text-align:center;">:</label>
                                                            <label class="col-lg-6 col-md-6 col-xs-6 shipmentLabel" id="lbl_ccms_number" name="lbl_ccms_number" style="opacity:0.5;padding-left:0px;">
                                                                -
                                                            </label>    
                                                        @else
                                                            <label class="col-lg-4 col-md-4 col-xs-4 shipmentLabel" style="font-weight: 700;padding-right:0px;">CCMS Number</label>
                                                            <label class="col-lg-1 col-md-1 col-xs-1 shipmentLabel" style="vertical-align: top;width:20px !important;padding-right:0px;padding-left:0px;text-align:center;">:</label>
                                                            <label class="col-lg-6 col-md-6 col-xs-6 shipmentLabel" id="lbl_ccms_number" name="lbl_ccms_number" style="padding-left:0px;">
                                                                {{$data[0]->ccms_number}}
                                                            </label>    
                                                        @endif
                                                        
                                                        <label class="col-lg-4 col-md-4 col-xs-4 shipmentLabel" style="font-weight: 700;padding-right:0px;">Route Name</label>
                                                        <label class="col-lg-1 col-md-1 col-xs-1 shipmentLabel" style="vertical-align: top;width:20px !important;padding-right:0px;padding-left:0px;text-align:center;">:</label>
                                                        <label class="col-lg-6 col-md-6 col-xs-6 shipmentLabel" id="lbl_route" name="lbl_route" style="padding-left:0px;">{{$data[0]->route_name}}</label>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-12 col-xs-12" style="padding-left: 0px !important;">
                                                        <label class="col-lg-4 col-md-4 col-xs-4 shipmentLabel" style="font-weight: 700;padding-right:0px;">Doc. Last Status</label>
                                                        <label class="col-lg-1 col-md-1 col-xs-1 shipmentLabel" style="vertical-align: top;width:20px !important;padding-right:0px;padding-left:0px;text-align:center;">:</label>
                                                        <label class="col-lg-6 col-md-6 col-xs-6 shipmentLabel" id="lbl_last_status" name="lbl_last_status" style="padding-left:0px;">
                                                                {{$data[0]->last_status}}
                                                        </label>
                                                        <label class="col-lg-4 col-md-4 col-xs-4 shipmentLabel" style="font-weight: 700;padding-right:0px;">Driver 1</label>
                                                        <label class="col-lg-1 col-md-1 col-xs-1 shipmentLabel" style="vertical-align: top;width:20px !important;padding-right:0px;padding-left:0px;text-align:center;">:</label>
                                                        <label class="col-lg-6 col-md-6 col-xs-6 shipmentLabel" id="lbl_driver" name="lbl_driver" style="padding-left:0px;">
                                                            @if($data[0]->driver_name == "-")
                                                                {{$data[0]->driver_id}}
                                                            @else
                                                                {{$data[0]->driver_id." - ".$data[0]->driver_name}}
                                                            @endif
                                                        </label>
                                                        <label class="col-lg-4 col-md-4 col-xs-4 shipmentLabel" style="font-weight: 700;padding-right:0px;">Driver 2</label>
                                                        <label class="col-lg-1 col-md-1 col-xs-1 shipmentLabel" style="vertical-align: top;width:20px !important;padding-right:0px;padding-left:0px;text-align:center;">:</label>
                                                        <label class="col-lg-6 col-md-6 col-xs-6 shipmentLabel" id="lbl_driver_2" name="lbl_driver_2" style="padding-left:0px;">
                                                            @if($data[0]->secondary_driver_name == "-")
                                                                {{$data[0]->secondary_driver_id}}
                                                            @else
                                                                {{$data[0]->secondary_driver_id." - ".$data[0]->secondary_driver_name}}
                                                            @endif
                                                        </label>
                                                        <label class="col-lg-4 col-md-4 col-xs-4 shipmentLabel" style="font-weight: 700;padding-right:0px;">OTM Status</label>
                                                        <label class="col-lg-1 col-md-1 col-xs-1 shipmentLabel" style="vertical-align: top;width:20px !important;padding-right:0px;padding-left:0px;text-align:center;">:</label>
                                                        <label class="col-lg-6 col-md-6 col-xs-6 shipmentLabel" id="lbl_otm_status" name="lbl_otm_status" style="padding-left:0px;">{{$data[0]->payment_status}}</label>
                                                        <label class="col-lg-4 col-md-4 col-xs-4 shipmentLabel" style="font-weight: 700;padding-right:0px;">ADD Cost</label>
                                                        <label class="col-lg-1 col-md-1 col-xs-1 shipmentLabel" style="vertical-align: top;width:20px !important;padding-right:0px;padding-left:0px;text-align:center;">:</label>
                                                        <label class="col-lg-6 col-md-6 col-xs-6 shipmentLabel" id="lbl_add_cost" name="lbl_add_cost" style="padding-left:0px;">{{$data[0]->addcost}}</label>
                                                    </div>
                                                <!-- </div> -->
                                            </div>
                                            <!-- <div class="row"> -->
                                                <div class="col-lg-12" style="padding-left:0px !important;padding-right:0px !important">
                                                    <hr style="border-top: 1px solid #000;">
                                                    <div class="col-lg-6 form-group form-inline" style="display:none">
                                                        <label class="col-form-label" style="font-size: 12pt;padding-right: 1em;"><b>KELENGKAPAN DOKUMEN</b></label>
                                                        <select class="form-control col-lg-4" name="kel_doc" id="kel_doc">
                                                            <option value="-1">PILIH PROJECT</option>
                                                            @foreach($mstProject as $project)
                                                                <option value="{{$project->id}}">{{$project->project_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            <!-- </div> -->
                                            <!-- <div class="row"> -->
                                                <div class="col-12">
                                                    <table id="tbl_kel_doc" name="tbl_kel_doc" class="table" style="width:100%">
                                                    </table>
                                                </div>
                                        </div>
                                        
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
            <button class="btn btn-info float-right" style="background: transparent;color: #0d66fa;border: 0px; margin-right: 16px;" onClick="goBack({{$type}})" type="button">BATAL</button>
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
    <script src="{{ asset('js/multiselect.js')}}"></script>
    <script src="{{ asset('ElaAdminAsset/assets/js/lib/ext/accounting.min.js') }}"></script>
    <script src="{{ asset('autoNumeric/autoNumeric.js') }}"></script>
    <script type="text/javascript">
        var table;
        var tableAttr;
        (function($) {
            $(document).ready(function() {

                $("#selReason").select2();

                $(window).keydown(function(event){
                    if(event.keyCode == 13) {
                        event.preventDefault();
                        return false;
                    }
                    if(event.keyCode == 27) {

                        event.preventDefault();
                        return history.back();
                    }
                   
                });

                $("#kel_doc").select2({
                    tags: true
                });

                if ({{$verified}} != null) {
                    $("#kel_doc").val({{$verified}});
                    $("#kel_doc").select2({disabled:true});
                    $('#btnAddRow').prop('disabled',false);
                }

                if ({{$verifiedAttr}} != null) {
                    $("#kel_doc_attr").val({{$verifiedAttr}});
                    $("#kel_doc_attr").select2({disabled:true});
                }

                $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    var target = $(e.target).attr("href") // activated tab
                    if (target == '#menu3') {
                        tableHistory.ajax.reload();
                    }
                });

                tableAttr = $('#tbl_attr').DataTable({
                    ajax: {
                        url: '/getDataAttrProccessDoc',
                        type:"POST",
                        dataSrc:'',
                        data : {
                            number: $('#lbl_doc_number').text(),
                            project: (({{$verifiedAttr}} != null) ? 'inserted' : function() { return $('#kel_doc_attr').val() })
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
                                    return '<input type="text" class="form-control value_attr" name="value_attr_'+meta["row"]+'" style="box-sizing:border-box;" readonly value="'+full.value+'"/>';    
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
                            title: 'REMARK',
                            render: function(data, type, full, meta)
                            {
                                if (full.remark) {
                                    return '<input type="text" class="form-control remark_attr" style="box-sizing:border-box;" name="remark_attr_'+meta["row"]+'" value="'+full.remark+'" readonly/>';
                                }
                                return '<input type="text" class="form-control remark_attr" style="box-sizing:border-box;" name="remark_attr_'+meta["row"]+'" readonly/>';
                                
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
                        $('td:eq(7) .id_attr',nRow).attr('name', 'id_attr_'+iDisplayIndex);
                        $('td:eq(3) .value_attr',nRow).autoNumeric('init',{aPad: false,aSep: '.',aDec:','});
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
                                            '<input type="text" class="form-control form_datetime date_attr"  name="date_attr_0" placeholder="yyyy-mm-dd hh:mm" readonly>'+
                                                '<div class="input-group-append">'+
                                                    '<div class="input-group-text"><i class="form-control-feedback fa fa-calendar"></i></div>'+
                                                '</div>'+
                                            '</div>',
                        '<input type="text" class="form-control remark_attr" style="box-sizing:border-box;" name="remark_attr_0"/>',
                        '<span><img id="deleteDetailAttr" class="deleteDetailAttr" onClick="deleteDetailAttr(0);" src="{{ asset('icon/trash.png')}}"></span>',
                        '<input type="text" style="width:20px" class="id_attr" name="id_attr_0" value=""/>'
                    ] ).draw(); 
                    $(".form_datetime").datetimepicker({
                        autoclose:true
                    });
                });
                
                table = $('#tbl_kel_doc').DataTable({
                    ajax: {
                        url: '/getDataKelengkapanProccessDoc',
                        type:"POST",
                        dataSrc:'',
                        data : {
                            number: $('#lbl_doc_number').text(),
                            project: (({{$verified}} != null) ? 'inserted' : function() { return $('#kel_doc').val() })
                        }
                    },
                    "ordering":false,
                    "bLengthChange" : false, //thought this line could hide the LengthMenu\
                    "bInfo":false,
                    "paging":   false,
                    "searching": false,
                    "columns":[
                        {   
                            orderable: false, 
                            className: 'dt-td-center',
                            title: 'ADA',
                            render: function(data, type, full, meta)
                            {
                                console.log(full.is_exist);
                                if (full.is_exist) {
                                    return '<label class="containerCheck" style="width:18px !important;"><input type="checkbox" name="ada_check_'+meta["row"]+'" value="1" checked><span class="checkmark"></span></label>';    
                                }
                                return '<label class="containerCheck" style="width:18px !important;"><input type="checkbox" name="ada_check_'+meta["row"]+'" value="1"><span class="checkmark"></span></label>';
                                
                            }
                        },
                        {   
                            orderable: false, 
                            className: 'dt-td-center',
                            title: 'JENIS DOKUMEN',
                            render: function(data, type, full, meta)
                            {
                                console.log(meta['row']);
                                if (full.doc_pelengkap_name) {
                                    return '<input type="text" class="form-control jen-doc" name="jenis_doc_'+meta["row"]+'" style="box-sizing:border-box;" readonly value="'+full.doc_pelengkap_name+'"/>';    
                                } 

                                return '<input type="text" class="form-control jen-doc" name="jenis_doc_'+meta["row"]+'" style="box-sizing:border-box;" readonly/>';
                                
                            }
                        },
                        {   
                            orderable: false, 
                            className: 'dt-td-center',
                            title: 'TANGGAL',
                            render: function(data, type, full, meta)
                            {
                                if (full.tanggal_dokumen) {
                                    return '<input type="text" class="form-control form_datetime date-doc"  name="tanggal_'+meta["row"]+'" placeholder="yyyy-mm-dd" readonly value="'+full.tanggal_dokumen+'">';
                                }
                                return '<input type="text" class="form-control form_datetime date-doc"  name="tanggal_'+meta["row"]+'" placeholder="yyyy-mm-dd" readonly>';
                                
                            }
                        },
                        {   
                            orderable: false, 
                            className: 'dt-td-center',
                            title: 'JAM',
                            render: function(data, type, full, meta)
                            {
                                if (full.jam) {
                                    return '<input type="text" class="form-control form_datetime jam-doc"  name="jam_'+meta["row"]+'" placeholder="hh:mm" readonly value="'+full.jam+'">';
                                }
                                return '<input type="text" class="form-control form_datetime jam-doc"  name="jam_'+meta["row"]+'" placeholder="hh:mm" readonly>';
                                
                            }
                        },
                        {   
                            orderable: false, 
                            className: 'dt-td-center',
                            title: 'NILAI',
                            render: function(data, type, full, meta)
                            {
                                if (full.nilai) {
                                    return '<input type="text" class="form-control nilai-doc" style="box-sizing:border-box;" name="nilai_'+meta["row"]+'" value="'+full.nilai+'" readonly/>';    
                                }
                                return '<input type="text" class="form-control nilai-doc" style="box-sizing:border-box;" name="nilai_'+meta["row"]+'" readonly/>';
                                
                            }
                        },
                        {   
                            orderable: false, 
                            className: 'dt-td-center',
                            title: 'REMARK',
                            render: function(data, type, full, meta)
                            {
                                if (full.remark) {
                                    return '<input type="text" class="form-control remark-doc" style="box-sizing:border-box;" name="remarks_'+meta["row"]+'" value="'+full.remark+'" readonly/>';
                                }
                                return '<input type="text" class="form-control remark-doc" style="box-sizing:border-box;" name="remarks_'+meta["row"]+'" readonly/>';
                                
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
                        $('td:eq(0) .containerCheck input[type="checkbox"]',nRow).attr('name', 'ada_check_'+iDisplayIndex);
                        $('td:eq(1) .jen-doc',nRow).attr('name', 'jenis_doc_'+iDisplayIndex);
                        $('td:eq(2) .date-doc',nRow).attr('name', 'tanggal_doc_'+iDisplayIndex);
                        $('td:eq(3) .jam-doc',nRow).attr('name', 'jam_doc_'+iDisplayIndex);
                        $('td:eq(4) .nilai-doc',nRow).attr('name', 'nilai_doc_'+iDisplayIndex);
                        $('td:eq(5) .remark-doc',nRow).attr('name', 'remark_doc_'+iDisplayIndex);
                        $('td:eq(4) .nilai-doc',nRow).autoNumeric('init',{aPad: false,aSep: '.',aDec:','}); 
                        console.log("NROW");
                        console.log(nRow);
                        return nRow;
                    },
                    'columnDefs': [
                        {
                            "targets": [0], // your case first column
                            "className": "text-center",
                            "width": "18px"
                        },
                        {
                            "targets": [1], // your case first column
                            "className": "text-left",
                            "width": "200px"
                        },
                        {
                            "targets": [2,3,4,5], // your case first column
                            "className": "text-center"
                        },
                    ]
                });

                $("#kel_doc").on("change", function (e) { 
                    // console.log($('#kel_doc').val());
                    $('#tbl_kel_doc').DataTable().ajax.reload()
                    $('#btnAddRow').prop('disabled',false);
                });

                $('#tbl_kel_doc_wrapper').children().eq(1).children().css( "padding-left", "0px" );
                $('#tbl_kel_doc_wrapper').children().eq(1).children().css( "padding-right", "0px" );            
                $('#tbl_kel_doc_wrapper').children().eq(1).css( "width", "100%" );
                $( table.table().container() ).removeClass( 'form-inline' );
                $( table.table().container() ).removeClass( 'no-footer' );

                tableHistory = $('#tbl_history').DataTable({
                    ajax: {
                        url: '/getHistoryProccessDoc',
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
                        {title:'No', data:'id',className: 'dt-td-center',},
                        {title:'DATE LOG', data:'created_at',className: 'dt-td-center',},
                        {title:'TIME', data:'created_at',className: 'dt-td-center',},
                        {title:'USER', data:'user_id',className: 'dt-td-center',},
                        {title:'STATUS', data:'status_name',className: 'dt-td-center',},
                        {title:'REMARK', data:'remark',className: 'dt-td-center',},
                    ],
                    'columnDefs': [
                        {
                            "targets": 0, // your case first column
                            // "className": "text-center",
                            "width": "30px"
                        },
                        {
                            "targets": [1], // your case first column
                            // "className": "text-left",
                            "width": "200px",
                            render:function(data){
                                console.log('history');
                                
                                console.log(data);
                                
                               return moment(data).format('DD MMMM YYYY');
                            }
                        },
                        {
                            "targets": [2], // your case first column
                            // "className": "text-left",
                            render:function(data){
                               return moment(data).format('HH:mm');
                            }
                        },
                        {
                            "targets": [3,4,5], // your case first column
                            // "className": "text-left"
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
                        '<span><img id="deleteDetail" class="deleteDetail" onClick="openModal(\'deleteKel\',0);" src="{{ asset('icon/trash.png')}}"></span>',
                        '<input type="text"/>'
                    ] ).draw(); 
                });
                $(".form_datetime").datetimepicker({
                    autoclose:true
                });

            });
        })(jQuery);

    function deleteDetails(index) {
        (function($) {
            var data = table.row( index ).data();

            console.log(data);

            if (data['id'] != '' && data['id'] != undefined) {

                $.ajax({
                    method: "POST",
                    url: "{{route('actionDeleteDetail')}}",
                    data: { 
                        detail_id: data['id'],
                        type:1
                    },
                    success: function (data) { 
                        if(data.stat == 1){
                            toastr.success(data.msg,'Success');
                            table.row(index).remove().draw();
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
                table.row(index).remove().draw();
                $('#exampleModal').modal('hide');
            }
            console.log( table.page.info()['recordsTotal']); 
        })(jQuery);
    }

    function pairingBarcode(type) {
        (function($) {
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
                    }
                    
                },
                error: function (jqXHR, textStatus, errorThrown) { 
                    toastr.error(errorThrown,textStatus);
                }
            });
        })(jQuery);
    }




    function goBack(type) {
        if (type == 1) {
            window.location.href = "{{URL::to('/procesDocSPK')}}";   
        } else {
            window.location.href = "{{URL::to('/procesDocSPKTrailer')}}";
        }
        
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

    function submitDoc() {
        

        (function($) {
            let html = '';
            $('.modal-body').empty();
            var validate = 0;
            var notCheck = 0;
            table.rows().every(function () {
                var htmls = this.node();
                var row = {};
                console.log($('td:eq(1) .jen-doc',htmls).val());
                if($('td:eq(0) .containerCheck input[type="checkbox"]:checked',htmls).val() != undefined) validate++;
                // if($('td:eq(1) .jen-doc',htmls).val() == '') validateJenDok++;
                if(!$('td:eq(0) .containerCheck input[type="checkbox"]:checked',htmls).val()) notCheck++;
                // console.log('test');
                // console.log($('td:eq(0) .containerCheck input[type="checkbox"]:checked',htmls).val());
                
            });


            if (validate == 0) {
                toastr.warning('Mohon pastikan minimal satu dokumen ada','Warning');
                return false;
            }

            if (notCheck > 0) {
                    html = 
                    '<label class="control-label" style="color: #1d1e4b;margin-bottom:2em;">Dokumen tidak lengkap! Proses tidak bisa dilanjutkan, pilih alasan.</label>'+
                    '<select class="form-control" id="selReason"> '+
                        '<option value="-1" >PILIH ALASAN</option>';
                        <?php 
                            for ($i=0; $i < count($reasonType); $i++) { ?>
                                html += '<option value="<?php echo $reasonType[$i]->name?>"><?php echo $reasonType[$i]->name?></option>';
                            <?php } ?>
                    html +='</select>';
                    // '<textarea class="form-control" id="textAlasan" rows="5" style="resize:none;" placeholder="isi catatan" required></textarea>';    
                    $('#btnTidak').removeAttr( "data-dismiss" )
                    $('#btnTidak').text("TUTUP");
                    $('#btnTidak').attr('data-dismiss','modal');
                    $('#btnYa').text("PENDING");
                    $('#btnYa').attr('onclick', 'actionButton("PENDING")');
            }  else {
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
                    '<select class="form-control" id="selReason"> '+
                        '<option value="-1" >PILIH ALASAN</option>';
                        <?php 
                            for ($i=0; $i < count($reasonType); $i++) { ?>
                                html += '<option value="<?php echo $reasonType[$i]->name?>"><?php echo $reasonType[$i]->name?></option>';
                            <?php } ?>
                    html +='</select>';
                    // '<textarea class="form-control" id="textAlasan" rows="5" style="resize:none;" placeholder="isi catatan"></textarea>';    
                    $('#btnTidak').removeAttr( "data-dismiss" )
                    $('#btnTidak').text("PENDING");
                    $('#btnTidak').attr('onclick', 'actionButton("PENDING")');
                    $('#btnYa').text("SETTLE");
                    $('#btnYa').attr('onclick', 'actionButton("SETTLE")');
                }
              
            $("#selReason").select2({
                    tags: true
            });
            $('.modal-body').append(html);
            $('#exampleModal').modal('show');
            
        })(jQuery);
    }

    function actionButton(params) {
        (function($) {

            if ($('#selReason').val() == -1 && (params == 'PENDING')) {
                toastr.warning('Silahkan pilih alasan terlebih dahulu');
                return false;    
            }
            var dataPelengkap = new Array();
            var dataAttribut = new Array();
            var validate = 0;
            table.rows().every(function () {
                var html = this.node();
                var row = {};
                row['isExist'] = $('td:eq(0) .containerCheck input[type="checkbox"]:checked',html).val() != undefined ? $('td:eq(0) .containerCheck input[type="checkbox"]:checked',html).val() : 0;
                row['jenis_doc'] = $('td:eq(1) .jen-doc',html).val();
                row['tanggal_doc'] = $('td:eq(2) .date-doc',html).val();
                row['jam_doc'] = $('td:eq(3) .jam-doc',html).val();
                row['nilai_doc'] = $('td:eq(4) .nilai-doc',html).val();
                row['remark_doc'] = $('td:eq(5) .remark-doc',html).val();
                row['id'] = this.data()["id"] != undefined ? this.data()["id"] : '';
                dataPelengkap.push(row);
            });
            

            tableAttr.rows().every(function () {
                var html = this.node();
                var row = {};
                row['attribut'] = $('td:eq(1) .attr',html).val();
                row['attribut_label'] = $('td:eq(2) .lbl_attr',html).val();
                row['attribut_value'] = $('td:eq(3) .value_attr',html).val();
                row['attribut_date'] = $('td:eq(4) .date_attr',html).val();
                row['attribut_remark'] = $('td:eq(5) .remark_attr',html).val();
                row['attribut_id'] = this.data()["id"] != undefined ? this.data()["id"] : '';
                dataAttribut.push(row);
            });

            $.ajax({
                method: "POST",
                url: "{{route('submitProcessDoc')}}",
                data: { 
                    kel_doc: $('#kel_doc').val(), 
                    projectAttr: $('#kel_doc_attr').val(), 
                    dataKelengkapan:  dataPelengkap,
                    dataAttribut: dataAttribut,
                    doc_number: $('#lbl_doc_number').text(),
                    catatan : $('#selReason').val(),
                    kelengkapan : $("input[name='radioDoc']:checked").val(),
                    type : params
                },
                success: function (data) { 
                    if(data.stat == 1){
                        window.location.replace("{{url()->previous()}}");
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
        })(jQuery);
    }
    </script>
@endsection