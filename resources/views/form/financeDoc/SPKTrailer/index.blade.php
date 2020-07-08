@extends('layout.master')

@section('title','Send To Messenger - SPK Trailer')

@section('css')
    <style type="text/css">
    .dataTables_filter {
       float: left !important;
    }
    .btn_Msg {
        
  width: 70px;
  height: 32px;
  border-radius: 6px;
  background-color: #0d66fa;

}
    .td_1 {
        width: 200px;
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
    #sendToMsgSPK_wrapper {
        margin-top: 60px;
}
    
    table.dataTable tbody th, table.dataTable tbody td {
        padding: .8em 2em !important;
    }

    .dataTables_scrollBody thead tr[role="row"]{
        visibility: collapse !important;
    }

    /* table.dataTable {
        width: 100% !important;
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
                            <div class="col-lg-12 mb-4">
                                <h4 class="box-title text-uppercase">kirim dokumen finance SPK Trailer</h4>
                            </div>
                        </div>
                        
                       
                        <!-- <div class="row" style="margin-top:18px"> -->
                            <!-- <div class="col-lg-12"> -->
                                <table id="sendToMsgSPKTrailer" class="table responsive">
                                </table>
                            <!-- </div> -->
                        <!-- </div> -->
                    </div>
                </div>
            </div> <!-- /.row -->
        </div>
    </div><!-- /# column -->
</div>
@endsection

@section('js')

    <script type="text/javascript">
        var table;
        (function($) {
            $(document).ready(function() {
                
                table = $('#sendToMsgSPKTrailer').DataTable({
                    ajax: {
                        url: '/loadDataSPKTrailer',
                        type:"POST",
                        dataSrc:'',
                        data : {
                       type:1
                        }
                    },
                    "scrollY": false,
                    "scrollX": false,
                    "ordering":false,
                    "autoWidth": false,
                    "bLengthChange" : false, //thought this line could hide the LengthMenu\
                    "bInfo":false,
                    "searching": false,
                    pageLength : 10,
                    "oLanguage": {
                        "oPaginate": {
                            "sPrevious": "<<",
                            "sNext" : ">>"
                        }
                    },
                    
                    "columnDefs": [
                        { width: "200px", "targets": [1,2,3,4,5]}
                    ],
                    columns: [ 
                        { data:'no', title:'No',className: 'dt-td-center',width:"30px"},
                        { data:'kode_arsip', title:'ARSIP',className: 'dt-td-center',width:"300px"},
                        { data:'tgl_arsip', title:'TANGGAL ARSIP',className: 'dt-td-center',width:"300px"},
                        { data:'user_pengarsip', title:'USER ARSIP',className: 'dt-td-center',width:"300px"},
                        { data:'tgl_serah_terima', title:'TANGGAL SERAH TERIMA',className: 'dt-td-center',width:"300px"},
                        {
                            orderable: false, 
                            className: 'dt-td-center',
                            render: function(data, type, full, meta)
                            {
                                return '<a href="/detailSPKTrailer/'+full.kode_arsip+'" class="btn btn-info btn-sm btn_Msg">Detail</a>';
                                
                            }
                        },
                      
                    ],
                    "columnDefs": [
                        // {"className": "dt-center", "targets": 5}
                    ],
                    // "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull )
                    // {

                    //     var index = iDisplayIndex +1;
                    //     $('td:eq(0)',nRow).html(index);
                    //     return nRow;
                    // },
                });

                $( table.table().container() ).removeClass( 'form-inline' );
                $( table.table().container() ).removeClass( 'no-footer' );
                // $("#example_wrapper").css("width", "100%");

           

        });
        })(jQuery);
     
    </script>
@endsection