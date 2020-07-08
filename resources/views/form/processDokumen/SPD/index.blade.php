@extends('layout.master')

@section('title','Proccess Document - SPD')

@section('css')
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

    .sorting_disabled {
        vertical-align:middle !important;
    }

    .modal-footer{
        text-align: right !important;
        justify-content: flex-end !important;
    }
    table.dataTable tbody td {
        padding: 0.75rem 0px !important;
        font-size:10px !important;
    }
    table.dataTable thead th {
        padding: 0.75rem 0px !important;
        text-align: center !important;
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

    #example_paginate ul.pagination {
        justify-content: flex-start !important;
    }

    #openDocTbl_paginate ul.pagination{
        justify-content: flex-end !important;
    }

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
                            <div class="col-lg-8 mr-sm-2" style="width:90%">
                                <h4 class="box-title" style="width:90%">REGISTRASI NOMOR SPD FINANCE</h4>
                            </div>
                            
                        </div>
                        
                        <button class="btn btn-info" style="font-size: 14px;margin-top:16px" type="button" onClick="openMdlReg();"><i class="fa fa-plus"></i> &nbsp; TAMBAHKAN</button>
                        <div class="row" style="margin-top:18px">
                            <div class="col-lg-12">
                                <table id="example" class="table" style="width:100%">
                                </table>
                            </div>
                        </div>
                
                        </div> 
                    </div>
                </div>
            </div> <!-- /.row -->
        </div>
    </div><!-- /# column -->
</div>
<!-- Modal -->

{{-- Proses registrasi dokumen --}}

<div class="modal fade" id="regMdl" tabindex="-1" role="dialog" aria-labelledby="regMdl" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content ">
        <div class="modal-header">
          <label class="modal-title" id="regMdl" style="font-size:18px; width:80%">TAMBAHKAN DOKUMEN BARU SPD FINANCE</label>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
    <div class="modal-body">
          <div class="col-md-12">
            {{-- <form> --}}
              <div class="row" style="display:flex !important;justify-content:center !important;">
                  <div class="col-md-5">
                      
                      <div class="input-group mb-3">
                          <input type="text" class="form-control" id="searchRegDoc" name="searchRegDoc" autofocus>
                          <div class="input-group-append">
                              <a href="#" class="input-group-text btn-info" style="color:white" id="btnRegDoc" ><i class="fa fa-plus"></i></a>
                          </div>
                      </div>
                  </div>
              </div>
                  <table id="tabelRegDoc" class="table nowrap" style="width:100%;overflow-x:auto;">
                  </table>

        </div>
    </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" style="background: transparent;border-color:transparent;color:#0d66fa" data-dismiss="modal">BATAL</button>
          <button type="button" class="btn btn-primary" id="btnYes" onClick="submitRegDoc()">SUBMIT</button>
        </div>
    {{-- </form> --}}
      </div>
    </div>
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
                  <table id="openDocTbl" class="table nowrap" style="width:100%;overflow-x:auto;">
                  </table>
              
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
@endsection

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script type="text/javascript">
    var table;
    (function($) {
        $(document).ready(function() {
            $('.mask').mask('0000-0000');

            var groupColumn = 9;
            table = $('#example').DataTable({
                        ajax: {
                            url: '/getDatatableProccessDocSPD',
                            type:"POST",
                            dataSrc:'',
                        data : {
                            type:1
                        }
                    },
                    dom:"<'row'<'col-sm-12 col-md-6'l>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-7'p><'col-sm-12 col-md-5'i>>",
                    "ordering":false,
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
                        
                        
                    },
                        columns: [ 
                        { 
                            data:'id', 
                            title:'<label class="containerCheck" style="width:18px !important;"><input type="checkbox" onClick="checkAll(this);"><span class="checkmark"></span></label>',
                            orderable: false, 
                            render: function(data, type, full, meta)
                            {
                                return '<label class="containerCheck" style="width:18px !important;"><input type="checkbox" name="check_'+meta["row"]+'"><span class="checkmark"></span></label>';
                                
                            }
                        },
                        { data:'no', title:'No.',className: 'dt-td-center',orderable: false, },
                        {   
                                orderable: false, 
                                className: 'dt-td-center',
                                title: 'SPD',
                                render: function(data, type, full, meta)
                                {
                                    $encoded = btoa(JSON.stringify({number:full.number, type:"1"}));

                                    return '<a href="insertProcessDocSPD/'+$encoded+'" style="text-decoration: underline;">'+full.number+'</a>';
                                    
                                }
                            },
                            { data:'kode_arsip', title:'ARSIP',className: 'dt-td-center',},
                            { data:'customer_name', title:'CUSTOMER',className: 'dt-td-center',},
                            { data:'status_erp', title:'STATUS ERP',className: 'dt-td-center',},
                            { data:'last_status', title:'LAST STATUS',className: 'dt-td-center',
                        
                                render: function(data, type, full, meta){
                                    if(data == 'registration_doc'){
                                        return 'Diterima Admin Finance';
                                    }
                                    else {
                                         return 'Dokumen Pending';
                                    
                                    }
                                }
                            },
                            { data:'last_status', title:'DOKUMEN',className: 'dt-td-center',
                                render: function(data, type, full, meta)
                                {
                                    if (full.is_complete) {
                                        return 'LENGKAP';    
                                    }

                                    return 'TIDAK LENGKAP';
                                    
                                }},
                        { data:'catatan', title:'REMARKS', orderable: false, className: 'dt-td-center',
                            render: function(data, type, full, meta)
                            {
                                if (data != null) {
                                    return data.substring(0, 30) + '...';    
                                }
                                return data;
                            }},
                        { data: 'status_date', title:'status_date', className: 'dt-td-center', "visible": false},
                    ],

                    "order": [[ groupColumn, 'asc' ]],
                    "drawCallback": function ( settings ) {
                        var api = this.api();
                        var rows = api.rows( {page:'all'} ).nodes();
                        
                        
                        var last=null;
                        var nomor = 1;
                        api.column(9, {page:'all'} ).data().each( function ( group, i ) {
                            if ( last !== group ) {
                                $(rows).eq( i ).before(
                                    '<tr class="group"><td colspan="9" style="background-color:#fff5e4">'+moment(group).format('DD MMM YYYY')+'</td></tr>'
                                );
            
                                last = group;
                                nomor = 1;
                                
                            }
                            console.log();
                            // $(rows).eq( i ) = nomor+1;
                            $(rows).eq( i ).find('td:eq(1)').html(nomor);
                            nomor++;
                        } );
                    },

                        "columnDefs": [
                            {"className": "dt-center", "targets": 6}
                        ]
                    });


                    table.on( 'draw', function () {
                        if (table.page.info()['pages'] < 2 ) {
                            $( "#example_wrapper .dataTables_paginate" ).hide(); 
                        }else {
                            $( "#example_wrapper .dataTables_paginate" ).show();    
                        }
                        table.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                            cell.innerHTML = i+1;
                        } );
                        
                        var buttonOpenDoc = '<div class="clearfix" style="float:right"><button class="btn" style="display:none;background:transparent !important;color:#0d66fa;margin-right:8px" onClick="hideCheck()">BATAL</button><button class="btn btn-info" style="margin-right:0px" onClick="openModal(\'kembalikan\')">Kembalikan Dokumen</button><button class="btn btn-info" style=" display:none;" data-toggle="modal" data-target="#modal_openDoc" onClick="clearData()">Open Document</button></div>';
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

                    $( "#itemDropdown" ).append( visCol );
                });

                    //Register dokumen masukkan
                    

                tabelRegDoc = $('#tabelRegDoc').DataTable({
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
                            title: 'SPD'
                        },
                        {   
                            orderable: false, 
                            className: 'dt-td-center',
                            title: 'CUSTOMER'
                        },
                        { className: 'dt-td-center',title:'APPROVE DATE'},
                        { className: 'dt-td-center',title:'LAST USER'},
                        { className: 'dt-td-center',title:'STATUS'},
                        { className: 'dt-td-center',title:'DOKUMEN'},
                        { className: 'dt-td-center',title:'REMARKS'}
                    ],
                    "columnDefs": [
                        {"className": "dt-center", "targets": 6}
                    ],
                });
                tabelRegDoc.on( 'draw', function () {
                    console.log(tabelRegDoc.page.info()['pages']);
                    tabelRegDoc.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                        cell.innerHTML = i+1;
                    } );
                    if (tabelRegDoc.page.info()['pages'] < 2 ) {
                        console.log(this);
                        
                        $( "#tabelRegDoc_paginate" ).hide();    
                    } else {
                        $( "#tabelRegDoc_paginate" ).show();    
                    }
                });


                

                $('#searchRegDoc').keyup(function(e){
                    if(e.keyCode == 13)
                    {
                        $.ajax({
                            method: "POST",
                            url: "{{route('regProcessSPD')}}",
                            data: { 
                                barcode : $('#searchRegDoc').val(),
                                type : 2
                            },
                            success: function (data) { 
                                if(data.stat == 1){
                                    $('#searchRegDoc').val('');
                                    dataDetail = data.data;
                                    for (let index = 0; index < dataDetail.length; index++) {
                                        var dataParse = dataDetail[index];
                                        var dataCheck = tabelRegDoc.rows().data();
                                        if (dataCheck != undefined && dataCheck != '') {
                                            for (let index = 0; index < dataCheck.length; index++) {
                                                if (dataCheck[index][1] == dataParse['number']) {
                                                    toastr.warning('Data sudah ada di list');
                                                    return false;
                                                }    
                                            }    
                                        }
                                        if (dataParse['is_complete']) {
                                    $doc = 'Complete';
                                } else {
                                    $doc = 'Not Complete';
                                }
                                if(dataParse['direct']){
                                    $last_status = "Proses Direct";
                                } else {
                                    $last_status = "Proses Messenger";
                                }
                                tabelRegDoc.row.add([
                                    dataParse['id'],
                                    dataParse['number'],
                                    dataParse['customer_name'],
                                    dataParse['created_at'],
                                    dataParse['updated_by'],
                                    $last_status,
                                    // dataParse['is_complete'],
                                    $doc,
                                    dataParse['catatan']
                                ]).draw();
                                    }
                                    

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
                            title: 'SPD'
                        },
                        {   
                            orderable: false, 
                            className: 'dt-td-center',
                            title: 'CUSTOMER'
                        },
                        { className: 'dt-td-center',title:'APPROVE DATE'},
                        { className: 'dt-td-center',title:'LAST USER'},
                        { className: 'dt-td-center',title:'STATUS'},
                        { className: 'dt-td-center',title:'DOKUMEN'},
                        { className: 'dt-td-center',title:'REMARKS'}
                    ],
                    "columnDefs": [
                        {"className": "dt-center", "targets": 6}
                    ],
                });

                tableOpenDoc.on( 'draw', function () {
                    tableOpenDoc.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                        cell.innerHTML = i+1;
                    } );
                    if (tableOpenDoc.page.info()['pages'] < 2 ) {
                        
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
                        url: "{{route('addOpenDocProcess')}}",
                        data: { 
                            barcode : $('#inputBarcode').val(),
                            type : 3
                        },
                        success: function (data) { 
                            if(data.stat == 1){
                                $('#inputBarcode').val('');
                                var dataParse = data.data[0];
                                console.log(dataParse);
                                var dataCheck = tableOpenDoc.rows().data();
                                if (dataCheck != undefined && dataCheck != '') {
                                    for (let index = 0; index < dataCheck.length; index++) {
                                        if (dataCheck[index][1] == dataParse['number']) {
                                            toastr.warning('Data sudah ada di list');
                                            return false;
                                        }    
                                    }    
                                }
                                if (dataParse['is_complete']) {
                                    $doc = 'Complete';
                                } else {
                                    $doc = 'Not Complete';
                                }
                                tableOpenDoc.row.add([
                                    dataParse['id'],
                                    dataParse['number'],
                                    dataParse['customer_name'],
                                    dataParse['created_at'],
                                    dataParse['updated_by'],
                                    dataParse['last_status'],
                                    $doc,
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
        


                $('#regMdl').on('shown.bs.modal', function() {
                $('input_element_id').focus();
                $(this).find('[autofocus]').focus();
                });
                $('#modal_openDoc').on('shown.bs.modal', function() {
                $('input_element_id').focus();
                $(this).find('[autofocus]').focus();
                });

        });
    })(jQuery);

    

    function openMdlReg() {
            (function($) {
                
                $('#regMdl').modal('show');

               
                

            })(jQuery);
        }

       
    
    function resetSearchDatatable() {
            (function($) {
                $('#searchDatatable').val('');
                table.search('').draw();
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
            $.ajax({
                method: "POST",
                url: "{{route('submitOpenDocumentFinance')}}",
                data: { 
                    data : dataChecked,
                    type : 2
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

    function clearData() {
        (function($) {
            document.getElementById("inputBarcode").focus();
            $('#inputBarcode').val('');
            tableOpenDoc.clear().draw();
            $('#metode_doc').val('-1');
        })(jQuery);
    }

    function showCheck() {
            
        (function($) {
            if (dataChecked.length> 0) {
                
                $.ajax({
                    method: "POST",
                    url: "{{route('actionKembalikanProcessDoc')}}",
                    data: { 
                        dataParam: JSON.stringify(dataChecked),
                        catatan:$('#textAlasan').val(),
                        type:2
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
                // var buttonOpenDoc = '<div class="clearfix"><button class="btn" style="display:none;background:transparent !important;color:#0d66fa;margin-right:8px" onClick="hideCheck()">Cancel</button><button class="btn btn-info" style="margin-right:8px" onClick="openModal(\'kembalikan\')">Kembalikan Dokumen</button><button class="btn btn-info" style="" data-toggle="modal" data-target="#modal_openDoc" onClick="clearData()">Open Document</button></div>';
                // $("#example_paginate").prepend(buttonOpenDoc);
            }
            
        })(jQuery);
    }

    function checkVis(param) {
        (function($) {
            if ($(param).prop('checked') == true) {
                table.column($(param).val()).visible(true);
                table.columns.adjust().draw();
                var buttonOpenDoc = '<div class="clearfix"><button class="btn" style="display:none;background:transparent !important;color:#0d66fa;margin-top:1em;margin-bottom:4em;margin-right:8px" onClick="hideCheck()">BATAL</button><button class="btn btn-info" style="margin-top:1em;margin-bottom:4em;margin-right:8px" onClick="openModal(\'kembalikan\')">Kembalikan Dokumen</button><button class="btn btn-info" style="margin-top:1em;margin-bottom:4em;" data-toggle="modal" data-target="#modal_openDoc">Open Document</button></div>';
                $("#example_paginate").prepend(buttonOpenDoc);
            } else {
                table.column($(param).val()).visible(false);
                table.columns.adjust().draw();
                var buttonOpenDoc = '<div class="clearfix"><button class="btn" style="display:none;background:transparent !important;color:#0d66fa;margin-top:1em;margin-bottom:4em;margin-right:8px" onClick="hideCheck()">BATAL</button><button class="btn btn-info" style="margin-top:1em;margin-bottom:4em;margin-right:8px" onClick="openModal(\'kembalikan\')">Kembalikan Dokumen</button><button class="btn btn-info" style="margin-top:1em;margin-bottom:4em; data-toggle="modal" data-target="#modal_openDoc"">Open Document</button></div>';
                $("#example_paginate").prepend(buttonOpenDoc);
            }
        })(jQuery);
    }

    function submitRegDoc() {
        
        var dataAll = [];
        tabelRegDoc.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
            var node = this.node();
            var valueDocNum = this.data();
            

            console.log(valueDocNum);
            
            
            dataAll.push({id:valueDocNum[0], doc_number:valueDocNum[1]});
        } );
        if (dataAll.length == 0) {
            toastr.warning("Silakan Scan Barcode dulu atau tulis no spk lengkap!");
            return false;   
        }

        
        (function($) {
            $.ajax({
                method: "POST",
                url: "{{route('submitRegDocFinance')}}",
                data: { 
                    data : dataAll,
                    type : 2
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

</script>
@endsection