@extends('layout.master')

@section('title','Detail Arsip SPK')

@section('css')

<style type="text/css">
       
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

.select_msg {
        width: 200px;
        font-size:smaller;
    }

    .other_msg {
    width: 230px;
    font-size:smaller;
    margin-left: 10px;
    /* display: inline-flex; */
    /* margin-top: 10px; */
    height: 28px;
}

.dataTables_paginate{
    float: left !important;
    margin-top:1%
}

.dt-buttons{
    float: right !important;
    margin-top: 2px !important;
    
    /* widows: 300px !important; */
}
.btn_cancel{
    width: 150px !important;
    margin-right: 20px !important;
    height: 35px;
    
}

.btn_cetak{
    width: 150px !important;
    height: 35px;
    
}



</style>



@endsection


@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card" style="margin-bottom:0px !important">
            <div class="row">
                <div class="col-lg-12" style="margin-top:-20px;">
                    <div class="card-body" style="min-height:90vh">
                        <div class="card-body" style="margin-top:-20px;">
                           
                                <div class="col-lg-12 mt-4" style="margin-left:-19px; margin-bottom:40px;">
                                    <h4 class="box-title text-uppercase">kirim dokumen finance/CETAK LIST ARSIP<h4>
                                </div>
                            
                                           
                                <table class="table responsive" style="width:100%; border-style:none; margin-bottom:-20px;margin-left:-20px;">
                                    <tr class="tbl">
                                        <th style="width:200px;">Kode Pengarsipan</th>
                                        <th style="width:10px;">:</th>
                                        @if(count($arsip) > 0)
                                        <td>{{$arsip[0]->kode_arsip}}</td>
                                        @else
                                        <td></td>
                                        @endif
                                    </tr>
                                        <tr class="tbl">
                                        <th style="width:200px;">Tanggal Pengarsipan</th>
                                        <th>:</th>
                                        @if(count($arsip) > 0)
                                        <td>{{$arsip[0]->tgl_arsip}}</td>
                                        @else
                                        <td></td>
                                        @endif
                                    </tr>
                                        <tr class="tbl">
                                        <th style="width:200px;">Nama Messenger</th>
                                        <th>:</th>
                                        <td class="form-group">
                                            <select class=" form-control input-sm select_msg"" id="select_msg" data-select2-id="0"style="font-size: inherit; text-align: right; " onchange="select_Msg()" >
                                                <option selected>PILIH MESSENGER</option>
                                                <option id="others">OTHERS</option>  
                                                @if($msg_all->count() > 0)
                                                @foreach($msg_all as $ms)
                                                <option value="{{$ms->nama}}">{{$ms->nama}}</option>
                                                @endforeach
                                                @endif  
                                                            
                                            </select>
                                            <span class="invisible" id="visible_msg">
                                                <form id="" style="display: inline-flex;">
                                                <input class="form-control other_msg" name="nama_msg" id="nama_msg" min="3" placeholder="NAMA MESSENGER">
                                                <input class="form-control other_msg" name="msg_hp2" id="msg_hp2"  min="11" placeholder="NO TELEPON">
                                                </form>
                                            </span>
                                        </td>
                                        </tr>  
                                </table>
                                <br/>
                            <div class="row" style="width:100%;">
                                <!-- <div class="col-lg-12"> -->
                                    <table style="font-size: small; border-bottom: solid #6666;" id="tblDetail" class="table tbl_list  responsive" style="width:100%" >
                                        
                                       <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>SPK</th>
                                                <th>CUSTOMER</th>
                                                <th>TENDER</th>
                                                <th>USER</th>
                                                <th>STATUS</th>   
                                                <th>REMARK</th>   

                                            </tr>
                                       </thead>
                                        
                                        <tbody style="text-align: center;">
                                            @if(count($arsip) > 0)
                                            
                                            @foreach ($arsip as $item)
                                            <tr style="text-align:left;">
                                                <td id="num">{{$loop->iteration}}</td>
                                                <td id="number">{{$item->number}}</td>
                                                <td id="customer_name">{{$item->customer_name}}</td>
                                                <td id="created_at">{{$item->created_at}}</td>
                                                <td id="user_pengarsip">{{$item->user_pengarsip}}</td>
                                                <td id="openget">{{$item->openget}}</td>
                                                <td id="catatan" style="text-align:right;">{{Str::limit($item->catatan, 15)}}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                            
                                        </tbody>
                                    </table>
                                <!-- </div> -->
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div> <!-- /.row -->
        </div>
    </div><!-- /# column -->
</div>


<!--Modal Cetak Arsip-->

<div class="modal fade bs-example-modal-center" id="cetakListMDL" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="min-width:550px; min-height:300px; padding: 15px; font-size: smaller;">
    
        
    <h5 class="modal-title mt-4" id="cetakListMDL" style="text-align:center;font-weight:bold;color:#1d1e4b;">CETAK LIST ARSIP</h5>
    
    
    <div class="modal-body" style="margin:unset; padding:unset; margin:15px;">
        <form action="/printSPD" method="post" id="messenger_form" target="_blank">
        @csrf
        <div class="table-responsive">
            <table class="display responsive" style="width:100%; border-style:none;">
            <tr class="tbl">
                <th style="width:150px;">Kode Pengarsipan</th>
                <th style="width:10px;">:</th>
                @if(count($arsip) > 0)
                <td id="kode_arsip">{{$arsip[0]->kode_arsip}}<input type="hidden" value="{{$arsip[0]->kode_arsip}}"  name="kode_arsip"/></td>
                @else
                <td></td>
                @endif
            </tr>
                <tr class="tbl">
                <th style="width:150px;">Tanggal Pengarsipan</th>
                <th>:</th>
                @if(count($arsip) > 0)
                <td id="tgl_arsip" >{{$arsip[0]->tgl_arsip}}<input type="hidden" value="{{$arsip[0]->tgl_arsip}}" name="tgl_arsip"/></td>
                @else
                <td></td>
                @endif
            </tr>
                <tr class="tbl">
                <th style="width:150px;">Nama Messenger</th>
                <th style="">:</th>
                <td id="messengger_selected"</td>
                
            </tr>
            
            </table>
        <hr style="margin-top:4px;">
       
        </div>
        
        <div class="row mt-2" style="justify-content: center; ">
                    <div class="card" style="width:230px; min-height:100px; border: 1px solid #6666;">
                        <p style="justify-content: center; text-align:center; margin:auto;margin-top:12px;" class="mb-1">PILIH KOLOM</p>
                        <select name="from[]" id="lstview" class="form-control mt-2" size="12" multiple="multiple" style="width: 222px;margin: auto;border:unset;border-top:1px solid #6666;border-radius:unset; font-size: small;">
    
                            <option value="number">SPD</option>
                            <option value="customer_name">Customer</option>
                            <option value="order_number">Order Number</option>
                            <option value="driver_name">Driver Name</option>
                            <option value="status_erp">Status ERP</option>
                            <option value="status_spd">Status SPD</option>
                            <option value="depo_name">Depo</option>
                            <option value="openget">Status Dokument</option>
                            <option value="approve_spd_date">Tender Time</option>
                            <option value="amount">Amount</option>
                            <option value="user_pengarsip">User</option> 
                            <option value="catatan">Remarks</option>                   
    
                        </select>
                    </div>
                    
                    <div class="col-md-1" style="margin:auto; margin-right: 1px;margin-left: -17px;">
                        <button type="button" id="lstview_rightSelected" class="btn btn-link  btn-sm mb-1">>></button>
                        <button type="button" id="lstview_leftSelected" class="btn btn-link  btn-sm"><<</button>
                    </div>
                    
        <div class="card" style="width:230px; min-height:100px; border: 1px solid #6666; border-radius:none;">
             <p style="justify-content: center; text-align:center; margin:auto; margin-top:12px;" class="mb-1">CETAK KOLOM</p>
                        
            <select name="to_spd[]" id="lstview_to" class="form-control mt-2" size="12" multiple="multiple" style="width: 222px;margin: auto;border:unset;border-top:1px solid #6666;border-radius:unset;font-size: small;">
                            <option value="number" style="display:none;">SPD</option>
                            <option value="number" disabled>SPD</option>
                            <option value="customer_name" >Customer</option>
                            <option value="order_number">Order Number</option>
                            <option value="driver_name">Driver Name</option>
                            <option value="openget">Status Dokument</option>
            </select>
        </div>
        
        </div>
        <input type="hidden"  name="pengarsip" id="pengarsip"/>
        <input type="hidden" name="msg_hp1" id="msg_hp1">
        <input type="hidden" name="idmsg" id="idmsg">
        <input type="hidden" name="nama_msg_" id="nama_msg_">  
        <input type="hidden" name="msg_hp2_" id="msg_hp2_">
    <hr style="margin-top:-5px;">
    </div>
         <div class="d-inline mx-auto mb-4 mt-3">
            <a type="button" data-dismiss="modal" onclick="closeMdl()" class="btn btn-secondary close_mdl waves-effect waves-light text-center  mr-4" style="width:150px;color: white;">BATAL</a>
            <button id="cetakMdl" type="submit" class="btn btn-info waves-effect waves-light text-center " style="width:150px;">CETAK</a>
        </div>
        </form>
    </div><!-- /.modal-body -->
    </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    
    
    
    
    <!--Modal Cetak Arsip End-->
    
    
    
    
    @endsection
    
    @section('js')
    <script src="{{ asset('js/multiselect.js')}}"></script> 
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>  
    <script>    
    var table;
            (function($) {
                $(document).ready(function() {

                    $(window).keydown(function(event){
                    if(event.keyCode == 27) {

                        event.preventDefault();
                        return history.back();
                    }
                   
                });
                    
                    $(".select_msg").select2({});

                    $('#select_msg').change(function() {
                        console.log($(this).val());
                        if($(this).val()!='PILIH MESSENGER' && $(this).val()!='OTHERS'){
                            var array = <?php echo $msg_all; ?>;
                            search = $(this).val();
                            filter = array.filter(function (person) { return person.nama == search });
                            $("#msg_hp1").val(filter[0]['NoHP']);
                            $("#idmsg").val(filter[0]['id']);
                            
                        }
                    });


                    $('#cetakMdl').click(function(){
                    location.reload();
                        // $('#cetakListMDL').modal('hide');
                    });
      
                    $('#lstview').multiselect({sort : false,});
                    
                    
                    $("#btnLeft").click(function () {
                        var selectedItem = $("#rightValues option:selected");
                        $("#leftValues").append(selectedItem);
                    });
                    
                    $("#btnRight").click(function () {
                        var selectedItem = $("#leftValues option:selected");
                        $("#rightValues").append(selectedItem);
                        
                    });
                    
                    $("#rightValues").change(function () {
                        var selectedItem = $("#rightValues option:selected");
                        $("#txtRight").val(selectedItem.text());
                    });

                    $("#msg_hp2").inputFilter(function(value) {
                    return /^-?\d*$/.test(value); });
                    
                    table = $('#tblDetail').DataTable({
                        
                        dom:"<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'>><'row'<'col-sm-12'trB>><'row'<'col-sm-6 col-md-6 mt-3'p>>",

                        dom: 'rtBip',
                        buttons: [
                            {
                                text:'Batal',
                                className:'btn btn-secondary waves-effect waves-light btn_cancel',
                                action: function ( e, dt, button, config ) {
                                window.location.href = "/showSPD";
                                }
                            }, 
                            {
                                text:'Cetak',
                                className:'btn btn-primary waves-effect waves-light btn_cetak',
                                action: function ( e, dt, button, config ) {
                                // window.onclick='openMdl();';
                                    openMdl();
                                }
                            }
                        ],

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

                        initComplete: function() {
                     $('.dataTables_filter input').unbind();
                     $('.dataTables_filter input').bind('keyup', function(e){
                         var code = e.keyCode || e.which;
                         if (code == 13) { 
                             table.search(this.value).draw();
                         }
                     });

                    
                 },
                        language: {
                     search: "_INPUT_",
                        searchPlaceholder: 'Search'
                    }, 
                       columnDefs: [ { 
                       // data:'id',
                       className: 'dt-td-center',
                       targets: [0,1,2,3,4,5,6]  
                       } ],
                       
                    });
                    
    
                    
                $( table.table().container() ).removeClass( 'form-inline' );
                $( table.table().container() ).removeClass( 'no-footer' );

                var htmlButton = '<div class="row"><div class="col-lg-12 clearfix"><div class="dropdown" style="float:right;line-height:1.5;">'+
                '<input type="text" class="form-control" style="display: inline !important;width:200px !important;vertical-align:middle !important;height: 30px; " placeholder="Pencarian" id="searchDatatable"/>'+
                '<button type="button" class="btn btn-secondary" id="resetTable" style="background:transparent;border-color:transparent;" onClick="resetSearchDatatable()"><i class="fa fa-undo" style="color:#8d8ea4; margin-right:-10px;"></i></button>'+
                

                
                '</div></div></div>';

                $( ".dataTables_wrapper" ).prepend( htmlButton );

                $('#searchDatatable').keyup(function(e){
                    if(e.keyCode == 13)
                    {
                        table.search( this.value ).draw();
                    }
                });

            });

        })(jQuery);


        function resetSearchDatatable() {
            (function($) {
                $('#searchDatatable').val('');
                table.search('').draw();
            })(jQuery);
        }

    
        
        function openMdl()
        {
        (function($) {

            var data =[];
        if($('#select_msg').val()!='PILIH MESSENGER' && $('#select_msg').val()!='OTHERS'){

            $('#cetakListMDL').modal('show');
            var data = $('#select_msg').select2('data');
            var hp = $('#msg_hp1').val();
            console.log(data); 
            $('#pengarsip').val($('#user_pengarsip').text());



            $('#messengger_selected').append(data[0].text+'<input type="hidden" name="msg_select" value="'+data[0].id+'"/>',' - ',hp);
            var msg = '';
                $('#nama_msg_').val(msg);
                $('#msg_hp2_').val(msg);

                } else if($('#select_msg').val()=='OTHERS'){

                    if($('#nama_msg').val()==''){

                        toastr.error('Nama messengger di isi dulu !');

                    } if($('#msg_hp2').val()==''){
                        toastr.error('No telepon messengger di isi dulu !');
                    }else {

                    $('#cetakListMDL').modal('show');

                    }


                var data = $('#nama_msg').val();
                
                var hp = $('#msg_hp2').val();

                $('#msg_hp2_').val(hp);
                $('#nama_msg_').val(data);

                $('#messengger_selected').append(data,' - ',hp);
                
                

    
            } else {
                
                 toastr.error('Pilih messengger terlebih dulu !');
       
            }

            $(window).keydown(function(event){
                    if(event.keyCode == 13) {
                        event.preventDefault();
                        return false;
                    }
                });
    
        })(jQuery);
    }
    
    function closeMdl(){
        (function($){
            var msg =[];
             $("#messengger_selected").text(msg);
             $('#nama_msg').val(msg);
             $('#msg_hp2').val(msg);

             $('#nama_msg_').val(msg);
             $('#msg_hp2_').val(msg);

             $('#msg_hp1').val(msg);
             $('#idmsg').val(msg);
             $("#visible_msg").addClass("invisible"); 

        })(jQuery);
    }
    
    
    function select_Msg() {
        (function($){
            if($('#select_msg').val()=='OTHERS'){
            $("#visible_msg").removeClass("invisible");
            } else {
            $("#visible_msg").addClass("invisible"); 

            }
            
            
    
        })(jQuery);
    }
      
    
    function submitDocument()
        {
            (function($) {    
    
                var listKolom = [];
                $('#lstview_to>option').map(function(){
                    listKolom.push($(this).text());
                    
                });
                
    
                var result;
               
                $.ajax({
                    
                    method: "POST",
                        
                    url: "/printSPD",
                        
                    data:  { 
                        tgl_arsip: $('#tgl_arsip').text(), 
                        kode_arsip:  $('#kode_arsip').text(), 
                        messengger_selected: $('#messengger_selected').text(), 
                        msg_id: $('#idmsg').val(),
                        msg_other_name: $('#nama_msg').val(), 
                        msg_other_hp: $('#msg_hp2').val(),
                        tgl_serah:  $('#tgl_serah').text(),
                        user_arsip:  $('#user_pengarsip').text(),
                        kolom_data: listKolom,
                    },

                    success: function (data) {    
                        alert(data);
                        $('#cetakListMDL').modal('hide');
                        result = data;
                    },
                        
                    error: function (jqXHR, textStatus, errorThrown) { 
                        toastr.error(errorThrown,textStatus);
                    },
                    
                }).done(function() {
                    alert('done');
    //                $('#cetakListMDL').modal('hide');
                    // debugBase64("data:application/pdf;base64," + result);
                    var file = new Blob(["data:application/pdf;base64," +result], {type: 'application/pdf'});
                    var fileURL = URL.createObjectURL(file);
                    window.open(fileURL);
                });
                   
            })(jQuery);
        }
        
        function debugBase64(base64URL){
            var win = window.open();
            win.document.write('<iframe src="' + base64URL  + '" frameborder="0" style="border:0; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%;" allowfullscreen></iframe>');
        }
    
        (function($) {
  $.fn.inputFilter = function(inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        this.value = "";
      }
    });
  };

  // Install input filters.

}(jQuery));
    </script>
    @endsection
