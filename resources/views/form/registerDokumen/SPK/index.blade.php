@extends('layout.master')

@section('title','Register Document - SPK')

@section('css')
    <link rel="stylesheet" href="{{ asset('ElaAdminAsset/assets/css/lib/datatable/Select-1.3.1/css/select.bootstrap.min.css') }}"/>
    <style type="text/css">
    .dataTables_filter {
       float: left !important;
    }

    .dropdown-menu.show {
        display: block;
        line-height: normal !important;
        top: 2.5em !important;
        padding-left: 1em;
    }
    .dropdown-toggle::after {
        content: none !important;
    }

    .dropdown-menu {
        left: auto !important;
        right: 0px !important;
    }

    #example_paginate ul.pagination {
        justify-content: flex-start !important;
    }

    #openDocTbl_paginate ul.pagination{
        justify-content: flex-end !important;
    }

    /* table.dataTable thead th, table.dataTable thead td {
        padding: .8em 2em !important;
        text-align: left !important;
    }
     */
    table.dataTable tbody td {
        padding: 0.75rem !important;
        font-size:12px !important;
    }

    .sorting_disabled {
        vertical-align:middle !important;
    }

    .modal-footer{
        text-align: right !important;
        justify-content: flex-end !important;
    }

    #openDocTbl .sorting_disabled{
        font-size:12px !important;
    }

    .table th, .table td {
        vertical-align: middle !important;
    }

    .modal-lg {
        max-width: 90% !important;
    }

    #example.table.dataTable thead th {
        text-align: center !important;
    }

    /* #openDocTbl.dataTable tbody td {
        font-size: 10px !important;
    } */

    /* .dataTables_scrollBody thead tr[role="row"]{
        visibility: collapse !important;
    } */

    /* td, th {
    white-space: nowrap;
} */

    </style>
    
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card" style="margin-bottom:0px !important">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body" style="min-height:90vh">
                        <div class="row">
                            <div class="col-lg-6">
                                <h4 class="box-title">REGISTRASI NOMOR SPK</h4>
                            </div>
                        </div>
                        @if(Session::get('role') != 'Admin Pooling Exim')
                        <form action="#" method="POST" id="formSearch">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <input type="text" class="form-control" name="type" id="type" style="display:none" value="1">
                                        <!-- <div class="col-lg-4"> -->
                                            <!-- <input type="text" class="form-control" placeholder="SHEXIM2020" id="domain" name="domain" required> -->
                                        <!-- </div> -->
                                        <!-- <div class="col-lg-4"> -->
                                            <!-- <select class="form-control js-data-example-ajax" name="numbering" id="numbering" placeholder="XXXX-XXXX" data-mask="0000-0000" required></select> -->
                                            <!-- <input type="text" class="form-control" name="numbering" id="numbering" placeholder="XXXX-XXXX" data-mask="0000-0000" required> -->
                                        <!-- </div> -->
                                        <div class="col-lg-4">
                                            <button class="btn btn-info" style="font-size: 14px;margin-top:16px" type="button" id="btnSearch" name="btnSearch"  data-toggle="modal" data-target="#terimaDocModal"> <i class="fa fa-plus"></i> &nbsp; TAMBAHKAN</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @endif
                        <div class="row">
                            <div class="col-lg-12">
                                <table id="example" class="table" style="width:100%">
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /.row -->
        </div>
    </div><!-- /# column -->
</div>
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="modal_openDoc"  tabindex="-1" role="dialog" aria-labelledby="modal_openDoc" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="form-group" style="line-height: normal;margin-bottom: 0px;display: inline-grid;">
            <label for="inputBarcode" style="font-weight: 700;font-size: 14px;">SCAN BARCODE</label>
                <div class="form-row">
                    <div class="col-12">
                        <input type="text" class="form-control" id="inputBarcode" name="inputBarcode" autofocus>
                        <input type="text" class="form-control" id="typeDoc" name="typeDoc" style="display:none" value="1">
                    </div>
                </div>
            <i><p style="font-size: 12px;margin-bottom: 0px;">Silakan Scan Dokumen Yang Akan Dikirimkan Pada Batch Ini.</p></i>
        </div>
      </div>
      <div class="modal-body">
        <!-- <div class="row" style="margin-top:18px"> -->
            <!-- <div class="col-lg-12"> -->
                <table id="openDocTbl" class="table nowrap" style="width:100%;overflow-x:auto;">
                </table>
            <!-- </div> -->
        <!-- </div> -->
        <br/>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" style="background: transparent;border-color:transparent;color:#0d66fa" data-dismiss="modal">BATAL</button>
        <button type="button" class="btn btn-primary" id="btnYes" onClick="submitDoc()">SUBMIT</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <label class="modal-title" id="confirmModalLabel">Perhatian!</label>
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

<!-- Modal -->
<div class="modal fade" id="terimaDocModal" tabindex="-1" role="dialog" aria-labelledby="terimaDocModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <label class="modal-title" id="terimaDocModalLabel" style="font-size:18px;">TAMBAHKAN DOKUMEN BARU</label>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
            <div class="row" style="display:flex !important;justify-content:center !important;">
                <div class="col-md-5">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="searchTerimaDok" autofocus>
                        <div class="input-group-append">
                            <a class="input-group-text btn-info" style="color:white" id="basic-addon2"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="display:flex !important;justify-content:center !important;">
                <div class="col-md-12">
                    <table class="table" id="tableTerimaDok" width="100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>SPK</th>
                                <th>ORDER NUMBER</th>
                                
                                <th>TENDER TIME</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
      </div>
      <div class="modal-footer" style="justify-content:center !important;">
        <button type="button" class="btn btn-primary col-md-3" style="background: transparent;color: #0d66fa;border: 0px; margin-right: 16px;font-weight:500;" data-dismiss="modal"  id="btnCloseModal">TUTUP</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="{{asset('ElaAdminAsset/assets/css/lib/datatable/Select-1.3.1/js/dataTables.select.min.js')}}"></script>

    <script type="text/javascript">
        var table;
        var tableOpenDoc;
        var terimaDok;
        var currentPage = 0;
        (function($) {
            $(document).ready(function() {

                $('.mask').mask('0000-0000');
                // $(window).keydown(function(event){
                //     if(event.keyCode == 13) {
                //         event.preventDefault();
                //         return false;
                //     }
                // });
                var groupColumn = 10;
                table = $('#example').DataTable({
                    ajax: {
                        url: '/getDatatableSPK',
                        type:"POST",
                        dataSrc:'',
                        data : {
                            type:1
                        }
                    },
                    dom:"<'row'<'col-sm-12 col-md-6'l>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-7'p><'col-sm-12 col-md-5'i>>",
                    // "ordering":false,
                    "bLengthChange" : false, //thought this line could hide the LengthMenu\
                    "bInfo":false,
                    "searching": true,
                    pageLength : 10,
                    "oLanguage": {
                        "oPaginate": {
                            "sPrevious": "<<",
                            "sNext" : ">>"
                        }
                    },
                    "initComplete": function(settings, json) {
                        console.log('complete');
                        
                        // var buttonOpenDoc = '<div class="clearfix"><button class="btn" style="display:none;background:transparent !important;color:#0d66fa;margin-right:8px" onClick="hideCheck()">Cancel</button><button class="btn btn-info" style="margin-top:1em;margin-bottom:4em;margin-right:8px" onClick="openModal(\'kembalikan\')">Kembalikan Dokumen</button><button class="btn btn-info" style="margin-top:1em;margin-bottom:4em;" data-toggle="modal" data-target="#modal_openDoc" onClick="clearData()">Open Document</button></div>';
                        // $("#example_paginate").prepend(buttonOpenDoc);
                    },
                    columns: [ 
                        { 
                            data:'id',
                            orderable: false,
                            title:'<label class="containerCheck" style="width:18px !important;float:left"><input type="checkbox" onClick="checkAll(this);"><span class="checkmark"></span></label>',
                            render: function(data, type, full, meta)
                            {
                                return '<label class="containerCheck" style="width:18px !important;"><input type="checkbox" name="check_'+meta["row"]+'"><span class="checkmark"></span></label>';
                                
                            }
                        },
                        { data:'no', title:'No.', className: 'dt-td-center', },
                        {   
                            orderable: false, 
                            // className: 'dt-td-center',
                            title: 'SPK',
                            render: function(data, type, full, meta)
                            {
                                $encoded = btoa(JSON.stringify({number:full.number, type:"1"}));

                                return '<a href="insertDocSPK/'+$encoded+'" style="text-decoration: underline;">'+full.number+'</a>';
                                
                            }
                        },
                        { data:'order_number', title:'ORDER NUMBER',orderable: false,},
                        { data:'driver_name', title:'DRIVER NAME',orderable: false,},
                        { data:'unit', title:'VEHICLE NUMBER',orderable: false,},
                        { data:'tender_time', title:'TENDER TIME', className: 'dt-td-center', orderable: false,
                            render: function(data, type, full, meta){
                                return moment(data).format('DD-MM-YYYY');
                            }
                        },
                        { data:'updated_by', title:'LAST USER',orderable: false,},
                        { data:'last_status', title:'STATUS', className: 'dt-td-center',orderable: false,},
                        { data: 'catatan', title:'REMARKS', className: 'dt-td-center',orderable: false,
                            render: function(data, type, full, meta)
                            {
                                if (data != null) {
                                    return data.substring(0, 30) + '...';    
                                }
                                return data;
                            }
                        },
                        { data: 'status_date', title:'status_date', className: 'dt-td-center', "visible": false},
                    ],
                    "order": [[ groupColumn, 'desc' ]],
                    "drawCallback": function ( settings ) {
                        var api = this.api();
                        var rows = api.rows( {page:'all'} ).nodes();
                        
                        
                        var last=null;
                        var nomor = 1;
                        api.column(groupColumn, {page:'all'} ).data().each( function ( group, i ) {
                            if ( last !== group ) {
                                $(rows).eq( i ).before(
                                    '<tr class="group"><td colspan="'+groupColumn+'" style="background-color:#fff5e4">'+moment(group).format('DD-MM-YYYY')+'</td></tr>'
                                );
            
                                last = group;
                                nomor = 1;
                                
                            }
                            console.log();
                            // $(rows).eq( i ) = nomor+1;
                            $(rows).eq( i ).find('td:eq(1)').html(nomor);
                            nomor++;
                        } );
                    }

                    // "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull )
                    // {
                    //     var index = iDisplayIndex +1;
                    //     $('td:eq(1)',nRow).html(index);
                    //     return nRow;
                    // }
                });
                
                table.on( 'draw', function () {
                    if (table.page.info()['pages'] < 2 ) {
                        $( "#eexample_wrapper .dataTables_paginate" ).hide();    
                    } else {
                        $( "#eexample_wrapper .dataTables_paginate" ).show();    
                    }
                    // table.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    //     cell.innerHTML = i+1;
                    // } );
                    console.log("{{Session::get('role')}}");
                    btnOpenDoc = '';
                    if ("{{Session::get('role')}}" != 'Admin Operation Exim') {
                        btnOpenDoc = '<button class="btn btn-info" style="" data-toggle="modal" data-target="#modal_openDoc" onClick="clearData()">Proses Dokumen</button>';
                    }
                    
                    var buttonOpenDoc = '<div class="clearfix" style="float:right"><button class="btn" style="display:none;background:transparent !important;color:#0d66fa;margin-right:8px" onClick="hideCheck()">Cancel</button><button class="btn btn-info" style="margin-right:8px" onClick="openModal(\'kembalikan\')">Kembalikan Dokumen</button>'+btnOpenDoc+'</div>';
                    $('#example_wrapper div:eq(10)').html(buttonOpenDoc);

                    var countCheck = 0;
                    var jmlRow = 0;
                    $('#example tbody tr td label input[type="checkbox"]').each(function() {
                        
                        if ($(this).prop('checked')) {
                            countCheck++;
                        }
                        jmlRow++;
                    }); 
                    if (jmlRow > 0) {
                        if (jmlRow == countCheck) {
                            $('.containerCheck input[type="checkbox"]').prop('checked',true);
                        } else {
                            $('.containerCheck input[type="checkbox"]').prop('checked',false);
                        }
                    }
                } );
                $( table.table().container() ).removeClass( 'form-inline' );
                $( table.table().container() ).removeClass( 'no-footer' );
                $("#example_wrapper").css("width", "100%");

                var htmlButton = '<div class="row"><div class="col-lg-12 clearfix"><div class="dropdown" style="float:right;line-height:1.5;">'+
                '<input type="text" class="form-control" style="display: inline !important;width:200px !important;vertical-align:middle !important;height: 30px; " placeholder="Pencarian" id="searchDatatable"/>'+
                '<button type="button" class="btn btn-secondary" id="resetTable" style="background:transparent;border-color:transparent;" onClick="resetSearchDatatable()"><i class="fa fa-undo" style="color:#8d8ea4"></i></button>'+
                '<button type="button" class="btn btn-secondary dropdown-toggle" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20" style="background:transparent;border-color:transparent;"><i class="fa fa-list" style="color:#8d8ea4"></i></button>'+
                
                '<ul class="dropdown-menu" id="itemDropdown" style="padding: .5em;">'+
                '</ul>'+
                '</div></div></div>';

                $( ".dataTables_wrapper" ).prepend( htmlButton );
                $('#searchDatatable').keyup(function(e){
                    if(e.keyCode == 13)
                    {
                        table.search( this.value ).draw();
                    }
                });

                $('#dropdownMenuOffset').on( 'click', function (e) {
                    e.preventDefault();
            
                    // Get the column API object
                    var columnHeader = [];
                    var visCol = '';
                    var i = 0;
                    $( "#itemDropdown" ).empty();
                    var column = table.columns().every(function() {
                        columnHeader.push(this.header().textContent);
                        if (this.header().textContent == '' || this.header().textContent == 'No.') {
                            
                        } else {
                            if (table.column( i ).visible() === true) {
                                visCol += '<li><input class="checkbox" id="checkVis'+i+'" name="checkVis" onChange="checkVis(this)" type="checkbox" checked value="'+i+'" style="margin-right:8px">'+this.header().textContent+'</input></a></li>';    
                            } else {
                                visCol += '<li><input class="checkbox" id="checkVis'+i+'" name="checkVis" onChange="checkVis(this)" type="checkbox" value="'+i+'" style="margin-right:8px">'+this.header().textContent+'</input></a></li>';
                            }
                        }
                        
                        i++;
                    });
                    console.log(columnHeader);

                    $( "#itemDropdown" ).append( visCol );
                    
            
                    // Toggle the visibility
                    // column.visible( ! column.visible() );
                });

                tableOpenDoc = $('#openDocTbl').DataTable({
                    "ordering":false,
                    "bLengthChange" : false, //thought this line could hide the LengthMenu\
                    "bInfo":false,
                    "searching": false,
                    "autoWidth":true,
                    pageLength : 10,
                    paging:true,
                    "language": {
                      "emptyTable": "No data available in table"
                    },
                    columns: [ 
                        { title:'No.'},
                        {   
                            orderable: false, 
                            className: 'dt-td-center',
                            title: 'SPK'
                        },
                        {   
                            orderable: false, 
                            className: 'dt-td-center',
                            title: 'CUSTOMER'
                        },
                        {  className: 'dt-td-center',title:'TENDER TIME'},
                        {  className: 'dt-td-center',title:'LAST USER'},
                        {  className: 'dt-td-center',title:'STATUS'},
                        { className: 'dt-td-center',title:'REMARKS'}
                    ],
                    "columnDefs": [
                        { "width": "10em", "targets": 0 }
                    ],
                    // "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull )
                    // {
                    //     var index = iDisplayIndex +1;
                    //     $('td:eq(0)',nRow).html(index);
                    //     return nRow;
                    // },
                });

                tableOpenDoc.on( 'draw', function () {
                    console.log(tableOpenDoc.page.info()['pages']);
                    tableOpenDoc.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                        cell.innerHTML = i+1;
                    } );
                    buttonOpenDoc = '<div class="form-group form-inline">'+
                        '<label class="col-form-label" style="font-size: 12pt;padding-right: 1em;">METODE KIRIM</label>'+
                        '<select class="form-control col-lg-4" name="metode_doc" id="metode_doc">'+
                            '<option value="-1">PILIH</option>'+
                                '<option value="1">DIRECT</option>'+
                                '<option value="2">MESSENGER</option>'+
                        '</select>'+
                    '</div>';
                    $('#openDocTbl_wrapper div:eq(6)').html(buttonOpenDoc);
                    if (tableOpenDoc.page.info()['pages'] < 2 ) {
                        console.log(this);
                        
                        $( "#openDocTbl_paginate" ).hide();    
                    } else {
                        $( "#openDocTbl_paginate" ).show();    
                    }
                });
                
            });

            $('#inputBarcode').keyup(function(e){
                if(e.keyCode == 13)
                {
                    $.ajax({
                        method: "POST",
                        url: "{{route('addOpenDoc')}}",
                        data: { 
                            barcode : $('#inputBarcode').val(),
                            type : 1
                        },
                        success: function (data) { 
                            if(data.stat == 1){
                                $('#inputBarcode').val('');
                                var dataParse = data.data[0];
                                var dataCheck = tableOpenDoc.rows().data();
                                if (dataCheck != undefined && dataCheck != '') {
                                    for (let index = 0; index < dataCheck.length; index++) {
                                        if (dataCheck[index][1] == dataParse['number']) {
                                            toastr.warning('Data sudah ada di list');
                                            return false;
                                        }    
                                    }    
                                }
                                tableOpenDoc.row.add([
                                    dataParse['id'],
                                    dataParse['number'],
                                    dataParse['customer'],
                                    dataParse['tender_time'],
                                    dataParse['updated_by'],
                                    dataParse['last_status'],
                                    dataParse['catatan']
                                ]).draw();

                            } else {
                                toastr.warning(data.msg);
                            }
                            
                        },
                        error: function (jqXHR, textStatus, errorThrown) { 
                            toastr.error(errorThrown,textStatus);
                        }
                    });  
                }
            });
            
            $('#searchTerimaDok').keyup(function(e){
                if(e.keyCode == 13)
                {
                    $('#basic-addon2').click();
                }
            });

            $('#basic-addon2').on('click',function(params) {
                terimaDok.ajax.reload();
            });
            
            $('#terimaDocModal').on('show.bs.modal', function() {
                $('#searchTerimaDok').val('');
                terimaDok = $('#tableTerimaDok').DataTable({
                    ajax: {
                        url: '/getTerimaDok',
                        type:"POST",
                        dataSrc:'',
                        data : {
                            type : 1,
                            search:function() { return $('#searchTerimaDok').val() }
                        }
                    },
                    "destroy":true,
                    "searching": false,
                    "lengthChange": false,
                    "autoWidth": false,
                    "columnDefs": [
                        { "orderable": false,  "width":"5%", "targets": [0] },
                        { "width":"25%", "targets": [1] }, 
                        { "width":"20%", "targets": [2,3,4] },
                    ],
                    "columns":[
                        {
                            data:null,
                            name:"no"
                        },
                        {
                            data:"number",
                            name:"number"
                        },
                        {
                            data:"order_number",
                            name:"order_number"
                        },
                        
                        {
                            data:"tender_time",
                            name:"tender_time", 
                            render: function(data, type, full, meta){
                                if (!data) {
                                    return '-';    
                                }
                                return moment(data).format('DD-MM-YYYY');
                            }
                        },
                        {
                            data:"number",
                            name:"action", 
                            render: function(data, type, full, meta){
                                console.log(data);
                                
                                return '<button type="button" class="btn btn-info" style="width:100%;" onClick="terimaDokumen(\''+data+'\')">+ TAMBAHKAN</button>';
                            }
                        },
                    ],
                    "order": [[4,'desc']]
                });

                terimaDok.on( 'draw', function () {
                    terimaDok.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                        cell.innerHTML = i+1;
                    } );
                    
                } );
            });



                $('#terimaDocModal').on('shown.bs.modal', function() {
                $('input_element_id').focus();
                $(this).find('[autofocus]').focus();
                });
                $('#modal_openDoc').on('shown.bs.modal', function() {
                $('input_element_id').focus();
                $(this).find('[autofocus]').focus();
                });

        })(jQuery);

        function resetSearchDatatable() {
            (function($) {
                $('#searchDatatable').val('');
                table.search('').draw();
            })(jQuery);
        }

        function terimaDokumen(number) {
            
            (function($) {
                
                $.ajax({
                    url: "{{route('searchSPK')}}",
                    method: "POST",
                    data: { 
                        numbering:number,
                        type:1
                    },
                    success: function (data) { 
                        if(data.stat == 'success'){
                            toastr.success(data.message,'Success');
                            $('#terimaDocModal').modal('hide');
                            table.ajax.reload();
                        } else if(data.stat == 'warning') {
                            $('#terimaDocModal').modal('hide');
                            toastr.warning(data.message,'Warning');
                        } else {
                            $('#terimaDocModal').modal('hide');
                            toastr.error(data.message,'Error');
                        }
                        
                    },
                    error: function (jqXHR, textStatus, errorThrown) { 
                        toastr.error(errorThrown,textStatus);
                    }
                }); 
            })(jQuery);
        }

        function checkVis(param) {
            (function($) {
                if ($(param).prop('checked') == true) {
                    table.column($(param).val()).visible(true);
                    table.columns.adjust().draw();
                    // var buttonOpenDoc = '<div class="clearfix"><button class="btn" style="display:none;background:transparent !important;color:#0d66fa;margin-right:8px" onClick="hideCheck()">Cancel</button><button class="btn btn-info" style="margin-right:8px" onClick="openModal(\'kembalikan\')">Kembalikan Dokumen</button><button class="btn btn-info" style="" data-toggle="modal" data-target="#modal_openDoc" onClick="clearData()">Open Document</button></div>';
                    // $("#example_paginate").prepend(buttonOpenDoc);
                } else {
                    table.column($(param).val()).visible(false);
                    table.columns.adjust().draw();
                    // var buttonOpenDoc = '<div class="clearfix"><button class="btn" style="display:none;background:transparent !important;color:#0d66fa;margin-right:8px" onClick="hideCheck()">Cancel</button><button class="btn btn-info" style="margin-right:8px" onClick="openModal(\'kembalikan\')">Kembalikan Dokumen</button><button class="btn btn-info" style=" data-toggle="modal" data-target="#modal_openDoc" onClick="clearData()">Open Document</button></div>';
                    // $("#example_paginate").prepend(buttonOpenDoc);
                }
            })(jQuery);
        }
        var dataChecked = [];
        function openModal(params) {
            (function($) {
                dataChecked = [];
                table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                    var node = this.node();
                    var valueCheck = $(node).eq(0).children().children().find('input[type="checkbox"]:checked').val();
                    var valueDocNum = this.data();
                    if (valueCheck != undefined) {
                        dataChecked.push({isChecked:1, doc_number:valueDocNum.number});
                    }
                } );
                if (dataChecked.length> 0) {
                    console.log(params);
                    

                    let html = '';
                    $('#confirmModal .modal-body').empty();
                    if (params == 'kembalikan') {
                        html = 
                        // '<label class="control-label" style="color: #1d1e4b;">Anda akan mengembalikan SPK</label>';
                        '<label class="control-label" style="color: #1d1e4b;margin-bottom:2em;">Anda akan mengembalikan SPK</label>'+
                        '<textarea class="form-control" id="textAlasan" rows="5" style="resize:none;" placeholder="isi catatan" required></textarea>';    
                        $('#btnTidak').text("TIDAK");
                        $('#btnYa').text("YA");
                        $('#btnYa').attr('onclick', 'showCheck()');
                    }

                    $('#confirmModal .modal-body').append(html);
                    $('#confirmModal').modal('show');
                } else {
                    toastr.warning('Please choose minimum 1 number!');
                }
            })(jQuery);
        }

        function showCheck() {
            
            (function($) {
                if (dataChecked.length> 0) {
                    
                    $.ajax({
                        method: "POST",
                        url: "{{route('actionKembalikan')}}",
                        data: { 
                            dataParam: JSON.stringify(dataChecked),
                            catatan:$('#textAlasan').val(),
                            type:1
                        },
                        success: function (data) { 
                            if(data.stat == 1){
                                toastr.success(data.msg);
                                location.reload(true);
                            }
                            
                        },
                        error: function (jqXHR, textStatus, errorThrown) { 
                            toastr.error(errorThrown,textStatus);
                        }
                    });   
                } else {
                    toastr.warning('Please choose minimum 1 number!');
                }

            })(jQuery);
        }

        function checkAll(params) {
            (function($) {
                if ($(params).prop('checked') == true) {
                    $('#example tbody tr td label input[type="checkbox"]').each(function() {
                        $(this).prop('checked', true);
                    });           
                } else {
                    $('#example tbody tr td label input[type="checkbox"]').each(function() {
                        $(this).prop('checked', false);
                    });
                }
            })(jQuery);
        }

        function hideCheck() {
            (function($) {
                if (table.column(1).visible()) {
                    table.column(1).visible(false);
                    table.column(0).visible(true);
                    table.columns.adjust().draw();    
                    var buttonOpenDoc = '<div class="clearfix"><button class="btn" style="display:none;background:transparent !important;color:#0d66fa;margin-right:8px" onClick="hideCheck()">Cancel</button><button class="btn btn-info" style="margin-right:8px" onClick="openModal(\'kembalikan\')">Kembalikan Dokumen</button><button class="btn btn-info" style="" data-toggle="modal" data-target="#modal_openDoc" onClick="clearData()">Open Document</button></div>';
                    $("#example_paginate").prepend(buttonOpenDoc);
                }
                
            })(jQuery);
        }

        function submitDoc() {
            
            var dataChecked = [];
            tableOpenDoc.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                var node = this.node();
                var valueDocNum = this.data();
                console.log(valueDocNum);
                
                dataChecked.push({id:valueDocNum[0], doc_number:valueDocNum[1]});
            } );

            if (dataChecked.length == 0) {
                toastr.warning("Please scan document barcode first");
                return false;   
            }
            (function($) {
                if ($('#metode_doc').val() == '-1') {
                    toastr.warning("silahkan pilih metode terlebih dahulu");
                    return false;   
                }
                $.ajax({
                    method: "POST",
                    url: "{{route('submitOpenDocument')}}",
                    data: { 
                        metode : $('#metode_doc').val(),
                        data : dataChecked,
                        type : 1
                    },
                    success: function (data) { 
                        if(data.stat == 1){
                            location.reload();
                        } else {
                            toastr.warning(data.msg);
                        }
                        
                    },
                    error: function (jqXHR, textStatus, errorThrown) { 
                        toastr.error(errorThrown,textStatus);
                    }
                }); 
            })(jQuery);
        }

        function clearData() {
            (function($) {
                document.getElementById("inputBarcode").focus();
                $('#inputBarcode').val('');
                tableOpenDoc.clear().draw();
                $('#metode_doc').val('-1');
            })(jQuery);
        }


    </script>
@endsection