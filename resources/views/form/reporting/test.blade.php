@extends('layout.master')

@section('title','Reporting')

@section('css')
    <style type="text/css">
    .select2 {
       height: 38px !important;
    }
  

      ._btn_Msg {

    width: 100px;
    border-radius: 6px;
    background-color: #0d66fa;
    text-align: left center!important;
    height: 36px;
    /* margin-right: 5px; */
    float: right !important;
    /* background-image: url("../img/icon-go.png")no-repeat center right; */


      }

.tbl {
    border-style: hidden;
    margin:none;
        }
    #tblDetail_wrapper{
        width:100%;
    }

table.dataTable tbody td {
    padding: 10px 15px !important;
    line-height: 1.5;
}
.dataTables_paginate .pagination li.active a {
    background: #1d1e4b;
    border-color: #1d1e4b;
    border-radius: 2px;
    color: #fff;
    }
.dataTables_paginate .pagination li a:hover {
    background: #1d1e4b;
    color: #fff;
}


/* width */
::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #888;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555;
}

.dataTables_scrollBody table {
    margin-left:0px !important;
}

    .Group-9 {
  width: 464px;
  height: 432px;
  object-fit: contain;
  opacity: 0.8;
  display: block;
  margin-left: auto;
  margin-right: auto;
    }

  .Icon-Go {
  height: 28px;
  object-fit: contain;
  margin-bottom:5px;

}
.form_datetime{
    height: 30px;
}
.primary {
  border-radius: 6px;
}
.dt-buttons {
    width: 40%;
    float: right;
    margin-top: 20px;
    justify-content: flex-end !important;

}
.div_table.table {
    max-width:none !important;
    /* margin-top:-100px; */
}

div.dataTables_wrapper div.dataTables_paginate ul.pagination {
    margin: 20px 2px !important;
    white-space: nowrap;
    justify-content: flex-start !important;

}
.selection{
    font-size: smaller !important;
}
.select2-results__option{
    font-size: smaller !important;
}
.tbl-report {
    /* font-size:smaller !important; */
}


 
div.dataTables_wrapper {
        width:1000px;
        margin: 0 auto;
    }

div.dataTables_scrollHead thead tr[role="row"]{
    /* display:none !important; */
    /* display: table-column !important; */
    text-align: center !important;
}
</style>
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/scroller/2.0.2/css/scroller.bootstrap4.min.css"/> --}}

@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card" style="margin-bottom:0px !important">

            <div class="row">
                <div class="col-lg-12">

                    <div class="card-body" style="min-height:95vh">
                        <div class="row mb-4" style="">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12 mb-4">
                                        <h4 class="box-title text-uppercase">laporan</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">

                                        <div class="form-group" id="div_report">
                                            <label for="appendedPrependedInput">PILIH LAPORAN &nbsp;<span
                                                    style="color:red;">*</span></label><br />
                                            <select style="width:450px;" name="selectreport" id="selectreport"
                                                class="form-control selectreport">
                                                <option value="0" selected="selected">PILIH LAPORAN</option>
                                                <option value="dockembali">Laporan dokumen yang dikembalikan ke driver</option>
                                                {{-- ok --}}
                                                <option value="leadTime">Laporan Leadtime Dokumen</option>
                                                <option value="docoutstanding">Shipment Outstanding - SJ belum dikembalikan oleh
                                                    driver</option>{{-- ok --}}
                                                <option value="docterima">Dokumen sudah diterima belum operation process
                                                </option> {{-- ok --}}
                                                <option value="docfinance">Dokumen sudah terima finance belum settle operation
                                                </option>{{-- ok --}}
                                                <option value="docoperation">Dokumen sudah diterima admin operation belum ke
                                                    kurir</option>{{-- ok --}}
                                                <option value="docmessengger">Dokumen sudah di kurir belum serah terima finance
                                                </option> {{-- ok --}}

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6" style="float: right;">

                                        <div class="form-group" id="div_date_valid_from"
                                            style="float: left; display: inline-block; margin-right: 10px; width:35%;">
                                            <label for="appendedPrependedInput">Dari Tanggal <span
                                                    style="color:red;">*</span></label>
                                            <input type="text" name="txt_date_valid_from" id="txt_date_valid_from"
                                                class="form-control form_datetime" readonly="readonly" />
                                        </div>
                                        <div class="form-group" id="div_date_valid_to"
                                            style="float: left; display: inline-block; width:35%;">
                                            <label for="appendedPrependedInput">Sampai Tanggal<span
                                                    style="color:red;">*</span></label>
                                            <input type="text" name="txt_date_valid_to" id="txt_date_valid_to"
                                                class="form-control form_datetime" readonly="readonly" />
                                        </div>
                                        <div class="form-group" id="div_export" style="float: right;">
                                            <button type="button" class="btn btn-primary btn-sm primary"
                                                style="width:100px; float: right; display: inline-block; margin-top:28px;"
                                                onClick="submitReport();">Submit</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive div_table" id="datatbl"></div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
{{--    --}}
@endsection
@section('js')
<script src="{{ asset('js/multiselect.js')}}"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>


<script>


(function($) {
    $(document).ready(function() {

        $(".selectreport").select2({});

        $('.form_datetime').datetimepicker({
        format: 'dd-mm-yyyy',
        startView: 'month',
        minView: 'month',
        autoclose: true
        });

        $('#datatbl').append('<img id="img_report" src="{{asset('img/group-9@3x.png')}}"class="Group-9">');


        


    });


    $('#selectreport').on('change', function(){

    });

    }(jQuery));



    function submitReport(){
        (function($) {


            if ($('#selectreport').val()== 0) {
                location.reload();
                toastr['error']('Please Select Report');
                return false;
            } else if ($('#txt_date_valid_from').val()=='') {
                toastr['error']('Please Select Date Valid From');
                return false;
            } else if ($('#txt_date_valid_to').val()=='') {
                toastr['error']('Please Select Date Valid To');
                return false;
            }

            //Report select
           if($('#selectreport').val() == 'dockembali'){//Report Dokumen Kembali

        
            $('#datatbl').empty();

            // $('#img_report').addClass('invisible');

            $('#datatbl').append('<table class="table nowrap tbl-report" id="dockembali" style="width:100%"></table>');
            var table;
            table = $('#dockembali').on( 'processing.dt', function ( e, settings, processing ) {
            }).dataTable({

                dom: 'rtiBp',
                    buttons: [
                        { extend:'excel',
                        text: 'Export &nbsp; <img src="../img/icon-go.png")">',
                        className:'btn btn-primary _btn_Msg',
                        filename: 'Laporan dokumen yang dikembalikan ke driver',
                        title: ' '
                        }
                    ],
                        "deferRender":    true,
                        "scrollX":        true,
                        "scrollCollapse": true,
                        "scroller":       true,
                        "ordering":false,
                        "searching": true,
                        "pageLength" : 10,
                        "bInfo":false,
                        "oLanguage": {
                            "oPaginate": {
                                "sPrevious": "<<",
                                "sNext" : ">>"
                            }
                        },

                        language: {
                     search: "_INPUT_",
                        searchPlaceholder: 'Pencarian'
                    }, 
                ajax: {
                            url: '/docKembaliData',
                            type:"POST",
                            dataSrc:'',
                            data : {
                                date_from: $('#txt_date_valid_from').val(),
                                date_to: $('#txt_date_valid_to').val(),
                            }
                        },
                columns: [

                            { data:'no', title:'No',className: 'dt-td-center',width:"20px"},
                            { data:'driver_name', title:'NAMA DRIVER',className: 'dt-td-left'},
                            { data:'customer', title:'CUSTOMER',className: 'dt-td-left'},
                            { data:'order', title:'ORDER',className: 'dt-td-center'},
                            { data:'shipment', title:'SHIPMENT',className: 'dt-td-left'},
                            { data:'no_ccms', title:'CCMS',className: 'dt-td-center'},
                            // { data:'status_doc', title:'STATUS DOKUMEN',className: 'dt-td-center'},
                            { data:'tgl_kembali', title:'TGL KEMBALI',className: 'dt-td-center'},
                           ],
                });

                var htmlButton = '<div class="row"><div class="col-lg-12 clearfix"><div class="dropdown" style="float:right;line-height:1.5;">'+
                '<input type="text" class="form-control" style="display: inline !important;width:200px !important;vertical-align:middle !important;height: 30px; " placeholder="Pencarian" id="searchDatatable"/>'+
                '<button type="button" class="btn btn-secondary" id="resetTable" style="background:transparent;border-color:transparent;" onClick="resetSearchDatatable()"><i class="fa fa-undo" style="color:#8d8ea4; margin-right:-10px;"></i></button>'+
                '</div></div></div>';

                $( ".dataTables_wrapper" ).prepend( htmlButton );

                $('#searchDatatable').keyup(function(e){
                    if(e.keyCode == 13)
                    {
                        table.fnFilter($(this).val());
                    }
                });

            }
            else if ($('#selectreport').val() == 'leadTime'){ //Report shipment outstanding

            
                $('#datatbl').empty();

                $('#datatbl').append('<table class="table tbl-report nowrap" id="leadTime" style="width:100%"></table>');
                // $('#datatbl').append('<table class="table display nowrap table-striped table-bordered scroll-horizontal-vertical" id="leadTime"></table>');
            var table;
            table = $('#leadTime').on( 'processing.dt', function ( e, settings, processing ) {
            }).dataTable({

                dom: 'rtiBp',
                    buttons: [
                        { extend:'excel',
                        text: 'Export &nbsp; <img src="../img/icon-go.png")">',
                        className:'btn btn-primary _btn_Msg',
                        filename: 'Laporan dokumen Leadtime',
                        title: ' '
                        }
                    ],
                        "deferRender":    true,
                        "scrollX":        true,
                        "ordering":false,
                        "searching": true,
                        "pageLength" : 10,
                        "bInfo":false,
                        "oLanguage": {
                            "oPaginate": {
                                "sPrevious": "<<",
                                "sNext" : ">>"
                            }
                        },
                ajax: {
                            url: '/leadTimeData',
                            type:"POST",
                            dataSrc:'',
                            data : {
                                date_from: $('#txt_date_valid_from').val(),
                                date_to: $('#txt_date_valid_to').val(),
                            }
                        },
                        columns: [

                            { data:'no', title:'No',className: 'dt-td-center',width:"20px"},
                            { data:'customer', title:'CUSTOMER',className: 'dt-td-left'},
                            { data:'no_ccms', title:'CCMS',className: 'dt-td-left'},
                            { data:'order', title:'ORDER',className: 'dt-td-left'},
                            { data:'shipment', title:'SHIPMENT',className: 'dt-td-left'},
                            { data:'tender_time', title:'TGL TENDER',className: 'dt-td-center'},
                            { data:'tgl_register', title:'TGL TERIMA DOKUMEN ',className: 'dt-td-center'},
                            { data:'tgl_proses', title:'TGL PROSSES',className: 'dt-td-center'},
                            { data:'tgl_msg', title:'TGL MESSENGGER',className: 'dt-td-center'},
                            { data:'tgl_finance', title:'TGL FINANCE',className: 'dt-td-center'},
                            { data:'today', title:'LEADTIME',className: 'dt-td-center'},
                           ],
                });

                var htmlButton = '<div class="row"><div class="col-lg-12 clearfix"><div class="dropdown" style="float:right;line-height:1.5;">'+
                '<input type="text" class="form-control" style="display: inline !important;width:200px !important;vertical-align:middle !important;height: 30px; " placeholder="Pencarian" id="searchDatatable"/>'+
                '<button type="button" class="btn btn-secondary" id="resetTable" style="background:transparent;border-color:transparent;" onClick="resetSearchDatatable()"><i class="fa fa-undo" style="color:#8d8ea4; margin-right:-10px;"></i></button>'+
                '</div></div></div>';

                $( ".dataTables_wrapper" ).prepend( htmlButton );

                $('#searchDatatable').keyup(function(e){
                    if(e.keyCode == 13)
                    {
                        table.fnFilter($(this).val());
                    }
                });
            }
            else if ($('#selectreport').val() == 'docoutstanding'){ //Report shipment outstanding


            $('#datatbl').empty();

            $('#datatbl').append('<table class="table nowrap tbl-report" id="docoutstanding" style="width:100%"></table>');
            var table;
            table = $('#docoutstanding').on( 'processing.dt', function ( e, settings, processing ) {
            }).dataTable({

                dom: 'rtiBp',
                    buttons: [
                        { extend:'excel',
                        text: 'Export &nbsp; <img src="../img/icon-go.png")">',
                        className:'btn btn-primary _btn_Msg',
                        filename: 'Laporan dokumen yang dikembalikan ke driver',
                        title: ' '
                        }
                    ],
                        "deferRender":    true,
                        "scrollX": true,
                        "ordering":false,
                        "searching": true,
                        "pageLength" : 10,
                        "bInfo":false,
                        "oLanguage": {
                            "oPaginate": {
                                "sPrevious": "<<",
                                "sNext" : ">>"
                            }
                        },
                ajax: {
                            url: '/outstandingData',
                            type:"POST",
                            dataSrc:'',
                            data : {
                                date_from: $('#txt_date_valid_from').val(),
                                date_to: $('#txt_date_valid_to').val(),
                            }
                        },
                        columns: [

                            { data:'no', title:'No',className: 'dt-td-center',width:"30px"},
                            { data:'customer', title:'CUSTOMER',className: 'dt-td-left'},
                            { data:'order', title:'ORDER',className: 'dt-td-left'},
                            { data:'shipment', title:'SHIPMENT',className: 'dt-td-left'},
                            { data:'no_ccms', title:'CCMS',className: 'dt-td-left'},
                            { data:'tender_time', title:'TGL TENDER',className: 'dt-td-center'},
                            { data:'status_doc', title:'STATUS DOKUMEN',className: 'dt-td-center'},
                            { data:'today', title:'PREPAYMENT DATE',className: 'dt-td-center'},
                            ],
                });

                var htmlButton = '<div class="row"><div class="col-lg-12 clearfix"><div class="dropdown" style="float:right;line-height:1.5;">'+
                '<input type="text" class="form-control" style="display: inline !important;width:200px !important;vertical-align:middle !important;height: 30px; " placeholder="Pencarian" id="searchDatatable"/>'+
                '<button type="button" class="btn btn-secondary" id="resetTable" style="background:transparent;border-color:transparent;" onClick="resetSearchDatatable()"><i class="fa fa-undo" style="color:#8d8ea4; margin-right:-10px;"></i></button>'+
                '</div></div></div>';

                $( ".dataTables_wrapper" ).prepend( htmlButton );

                $('#searchDatatable').keyup(function(e){
                    if(e.keyCode == 13)
                    {
                        table.fnFilter($(this).val());
                    }
                });
            }
            else if ($('#selectreport').val() == 'docterima'){ //Report dokumrn di terima


                $('#datatbl').empty();

                $('#datatbl').append('<table class="table nowrap tbl-report" id="docterima" style="width:100%"></table>');
                    var table;
                    table = $('#docterima').on( 'processing.dt', function ( e, settings, processing ) {
                    }).dataTable({

                        dom: 'rtiBp',
                    buttons: [
                        { extend:'excel',
                        text: 'Export &nbsp; <img src="../img/icon-go.png")">',
                        className:'btn btn-primary _btn_Msg',
                        filename: 'Laporan dokumen yang dikembalikan ke driver',
                        title: ' '
                        }
                        ],
                        "deferRender":    true,
                        "scrollX": true,
                        "ordering":false,
                        "searching": true,
                        "pageLength" : 10,
                        "bInfo":false,
                        "oLanguage": {
                            "oPaginate": {
                                "sPrevious": "<<",
                                "sNext" : ">>"
                            }
                        },
                ajax: {
                                    url: '/docTerimaData',
                                    type:"POST",
                                    dataSrc:'',
                                    data : {
                                date_from: $('#txt_date_valid_from').val(),
                                date_to: $('#txt_date_valid_to').val(),
                            }
                                },
                        columns: [

                            { data:'no', title:'No',className: 'dt-td-center',width:"30px"},
                            { data:'customer', title:'CUSTOMER',className: 'dt-td-left',width:"300px"},
                            { data:'order', title:'ORDER',className: 'dt-td-left',width:"300px"},
                            { data:'shipment', title:'SHIPMENT',className: 'dt-td-left',width:"250px"},
                            { data:'no_ccms', title:'CCMS',className: 'dt-td-left',width:"300px"},
                            { data:'tender_time', title:'TGL TENDER',className: 'dt-td-center',width:"300px"},
                            { data:'today', title:'PREPAYMENT DATE',className: 'dt-td-center',width:"300px"},
                        ],
                        });

                        var htmlButton = '<div class="row"><div class="col-lg-12 clearfix"><div class="dropdown" style="float:right;line-height:1.5;">'+
                        '<input type="text" class="form-control" style="display: inline !important;width:200px !important;vertical-align:middle !important;height: 30px; " placeholder="Pencarian" id="searchDatatable"/>'+
                        '<button type="button" class="btn btn-secondary" id="resetTable" style="background:transparent;border-color:transparent;" onClick="resetSearchDatatable()"><i class="fa fa-undo" style="color:#8d8ea4; margin-right:-10px;"></i></button>'+
                        '</div></div></div>';

                        $( ".dataTables_wrapper" ).prepend( htmlButton );
                        $('#searchDatatable').keyup(function(e){
                            if(e.keyCode == 13)
                            {
                                table.fnFilter($(this).val());
                            }
                        });
                    }
                    else if ($('#selectreport').val() == 'docfinance'){ //Report dokumrn finance

                      
                        $('#datatbl').empty();
                        $('#datatbl').append('<table class="table nowrap tbl-report" id="docfinance" style="width:100%"></table>');
                    var table;
                    table = $('#docfinance').on( 'processing.dt', function ( e, settings, processing ) {
                    }).dataTable({

                            dom: 'frtiBp',
                        buttons: [
                            { extend:'excel',
                            text: 'Export &nbsp; <img src="../img/icon-go.png")">',
                            className:'btn btn-primary _btn_Msg',
                            filename: 'Laporan dokumen sudah terima finance belum settle otm',
                            title: ' '
                            }
                            ],
                        "deferRender":    true,
                        "scrollX":      true,
                        "ordering":false,
                        "searching": false,
                        "pageLength" : 10,
                        "bInfo":false,
                        "oLanguage": {
                            "oPaginate": {
                                "sPrevious": "<<",
                                "sNext" : ">>"
                            }
                        },
                ajax: {
                                    url: '/docFinanceData',
                                    type:"POST",
                                    dataSrc:'',
                                    data : {
                                    date_from: $('#txt_date_valid_from').val(),
                                    date_to: $('#txt_date_valid_to').val(),
                                  }
                                },
                        columns: [

                            { data:'no', title:'No',className: 'dt-td-center',width:"30px"},
                            { data:'customer', title:'CUSTOMER',className: 'dt-td-left',width:"300px"},
                            { data:'order', title:'ORDER',className: 'dt-td-left',width:"300px"},
                            { data:'shipment', title:'SHIPMENT',className: 'dt-td-left',width:"250px"},
                            { data:'no_ccms', title:'CCMS',className: 'dt-td-left',width:"300px"},
                            { data:'tender_time', title:'TGL TENDER',className: 'dt-td-center',width:"300px"},
                            { data:'today', title:'PREPAYMENT DATE',className: 'dt-td-center',width:"300px"},
                        ],
                        });

                        var htmlButton = '<div class="row"><div class="col-lg-12 clearfix"><div class="dropdown" style="float:right;line-height:1.5;">'+
                        '<input type="text" class="form-control" style="display: inline !important;width:200px !important;vertical-align:middle !important;height: 30px; " placeholder="Pencarian" id="searchDatatable"/>'+
                        '<button type="button" class="btn btn-secondary" id="resetTable" style="background:transparent;border-color:transparent;" onClick="resetSearchDatatable()"><i class="fa fa-undo" style="color:#8d8ea4; margin-right:-10px;"></i></button>'+
                        '</div></div></div>';

                        $( ".dataTables_wrapper" ).prepend( htmlButton );

                        $('#searchDatatable').keyup(function(e){
                            if(e.keyCode == 13)
                            {
                                table.fnFilter($(this).val());
                            }
                        });
                    }
                    else if ($('#selectreport').val() == 'docoperation'){ //Report dokumrn operation

                        $('#datatbl').empty();

                        $('#datatbl').append('<table class="table nowrap tbl-report" id="docoperation" style="width:100%"></table>');
                        var table;
                        table = $('#docoperation').on( 'processing.dt', function ( e, settings, processing ) {
                        }).dataTable({

                            dom: 'rtiBp',
                    buttons: [
                        { extend:'excel',
                        text: 'Export &nbsp; <img src="../img/icon-go.png")">',
                        className:'btn btn-primary _btn_Msg',
                        filename: 'Laporan Dokumen sudah settle operation belum ke kurir',
                        title: ' '
                        }
                        ],
                        "deferRender":    true,
                        "scrollX":     true,
                        "ordering":false,
                        "searching": false,
                        "pageLength" : 10,
                        "bInfo":false,
                        "oLanguage": {
                            "oPaginate": {
                                "sPrevious": "<<",
                                "sNext" : ">>"
                            }
                        },
                ajax: {
                                        url: '/docOperationData',
                                        type:"POST",
                                        dataSrc:'',
                                        data : {
                                    date_from: $('#txt_date_valid_from').val(),
                                    date_to: $('#txt_date_valid_to').val(),
                                }
                                        },
                            columns: [

                                { data:'no', title:'No',className: 'dt-td-center',width:"30px"},
                                { data:'customer', title:'CUSTOMER',className: 'dt-td-left',width:"300px"},
                                { data:'order', title:'ORDER',className: 'dt-td-left',width:"300px"},
                                { data:'shipment', title:'SHIPMENT',className: 'dt-td-left',width:"250px"},
                                { data:'no_ccms', title:'CCMS',className: 'dt-td-left',width:"300px"},
                                { data:'tender_time', title:'TGL TENDER',className: 'dt-td-center',width:"300px"},
                                { data:'today', title:'PREPAYMENT DATE',className: 'dt-td-center',width:"300px"},
                                ],
                            });
                            var htmlButton = '<div class="row"><div class="col-lg-12 clearfix"><div class="dropdown" style="float:right;line-height:1.5;">'+
                            '<input type="text" class="form-control" style="display: inline !important;width:200px !important;vertical-align:middle !important;height: 30px; " placeholder="Pencarian" id="searchDatatable"/>'+
                            '<button type="button" class="btn btn-secondary" id="resetTable" style="background:transparent;border-color:transparent;" onClick="resetSearchDatatable()"><i class="fa fa-undo" style="color:#8d8ea4; margin-right:-10px;"></i></button>'+
                            '</div></div></div>';

                            $( ".dataTables_wrapper" ).prepend( htmlButton );

                            $('#searchDatatable').keyup(function(e){
                                if(e.keyCode == 13)
                                {
                                    table.fnFilter($(this).val());
                                }
                            });
                        }
                        else if ($('#selectreport').val() == 'docmessengger'){ //Report dokumrn operation

                            
                            $('#datatbl').empty();

                            $('#datatbl').append('<table class="table nowrap tbl-report" id="docmessengger" style="width:100%"></table>');
                        var table;
                        table = $('#docmessengger').on( 'processing.dt', function ( e, settings, processing ) {
                        }).dataTable({

                            dom: 'rtiBp',
                    buttons: [
                        { extend:'excel',
                        text: 'Export &nbsp; <img src="../img/icon-go.png")">',
                        className:'btn btn-primary _btn_Msg',
                        filename: 'Laporan dokumen sudah di kurir belum serah terima finance',
                        title: ' '
                        }
                        ],
                        "deferRender":    true,
                        "scrollX":      true,
                        "ordering":false,
                        "searching": false,
                        "pageLength" : 10,
                        "bInfo":false,
                        "oLanguage": {
                            "oPaginate": {
                                "sPrevious": "<<",
                                "sNext" : ">>"
                            }
                        },
                        ajax: {
                            url: '/docMessenggerData',
                            type:"POST",
                            dataSrc:'',
                            data : {
                            date_from: $('#txt_date_valid_from').val(),
                            date_to: $('#txt_date_valid_to').val(),
                                }
                        },
                        columns: [
                                { data:'no', title:'No',className: 'dt-td-center',width:"30px"},
                                { data:'customer', title:'CUSTOMER',className: 'dt-td-left',width:"300px"},
                                { data:'order', title:'ORDER',className: 'dt-td-left',width:"300px"},
                                { data:'shipment', title:'SHIPMENT',className: 'dt-td-left',width:"250px"},
                                { data:'no_ccms', title:'CCMS',className: 'dt-td-left',width:"200px"},
                                { data:'tender_time', title:'TGL TENDER',className: 'dt-td-center',width:"300px"},
                                { data:'today', title:'PREPAYMENT DATE',className: 'dt-td-center',width:"300px"},
                            ],
                        });
                            var htmlButton = '<div class="row"><div class="col-lg-12 clearfix"><div class="dropdown" style="float:right;line-height:1.5;">'+
                            '<input type="text" class="form-control" style="display: inline !important;width:200px !important;vertical-align:middle !important;height: 30px; " placeholder="Pencarian" id="searchDatatable"/>'+
                            '<button type="button" class="btn btn-secondary" id="resetTable" style="background:transparent;border-color:transparent;" onClick="resetSearchDatatable()"><i class="fa fa-undo" style="color:#8d8ea4; margin-right:-10px;"></i></button>'+
                            '</div></div></div>';

                            $( ".dataTables_wrapper" ).prepend( htmlButton );

                            $('#searchDatatable').keyup(function(e){
                                if(e.keyCode == 13)
                                {
                                    table.fnFilter($(this).val());
                                }
                            });
                        }

        })(jQuery);

}

function resetSearchDatatable() {
            (function($) {
                $('#searchDatatable').val('');
                table.search('').draw();
            })(jQuery);
        }






</script>
@endsection
