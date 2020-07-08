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

div.dataTables_wrapper div.dataTables_filter input {

background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PHN2ZyAgIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgICB4bWxuczpjYz0iaHR0cDovL2NyZWF0aXZlY29tbW9ucy5vcmcvbnMjIiAgIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyIgICB4bWxuczpzdmc9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiAgIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgICB2ZXJzaW9uPSIxLjEiICAgaWQ9InN2ZzQ0ODUiICAgdmlld0JveD0iMCAwIDIxLjk5OTk5OSAyMS45OTk5OTkiICAgaGVpZ2h0PSIyMiIgICB3aWR0aD0iMjIiPiAgPGRlZnMgICAgIGlkPSJkZWZzNDQ4NyIgLz4gIDxtZXRhZGF0YSAgICAgaWQ9Im1ldGFkYXRhNDQ5MCI+ICAgIDxyZGY6UkRGPiAgICAgIDxjYzpXb3JrICAgICAgICAgcmRmOmFib3V0PSIiPiAgICAgICAgPGRjOmZvcm1hdD5pbWFnZS9zdmcreG1sPC9kYzpmb3JtYXQ+ICAgICAgICA8ZGM6dHlwZSAgICAgICAgICAgcmRmOnJlc291cmNlPSJodHRwOi8vcHVybC5vcmcvZGMvZGNtaXR5cGUvU3RpbGxJbWFnZSIgLz4gICAgICAgIDxkYzp0aXRsZT48L2RjOnRpdGxlPiAgICAgIDwvY2M6V29yaz4gICAgPC9yZGY6UkRGPiAgPC9tZXRhZGF0YT4gIDxnICAgICB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLC0xMDMwLjM2MjIpIiAgICAgaWQ9ImxheWVyMSI+ICAgIDxnICAgICAgIHN0eWxlPSJvcGFjaXR5OjAuNSIgICAgICAgaWQ9ImcxNyIgICAgICAgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjAuNCw4NjYuMjQxMzQpIj4gICAgICA8cGF0aCAgICAgICAgIGlkPSJwYXRoMTkiICAgICAgICAgZD0ibSAtNTAuNSwxNzkuMSBjIC0yLjcsMCAtNC45LC0yLjIgLTQuOSwtNC45IDAsLTIuNyAyLjIsLTQuOSA0LjksLTQuOSAyLjcsMCA0LjksMi4yIDQuOSw0LjkgMCwyLjcgLTIuMiw0LjkgLTQuOSw0LjkgeiBtIDAsLTguOCBjIC0yLjIsMCAtMy45LDEuNyAtMy45LDMuOSAwLDIuMiAxLjcsMy45IDMuOSwzLjkgMi4yLDAgMy45LC0xLjcgMy45LC0zLjkgMCwtMi4yIC0xLjcsLTMuOSAtMy45LC0zLjkgeiIgICAgICAgICBjbGFzcz0ic3Q0IiAvPiAgICAgIDxyZWN0ICAgICAgICAgaWQ9InJlY3QyMSIgICAgICAgICBoZWlnaHQ9IjUiICAgICAgICAgd2lkdGg9IjAuODk5OTk5OTgiICAgICAgICAgY2xhc3M9InN0NCIgICAgICAgICB0cmFuc2Zvcm09Im1hdHJpeCgwLjY5NjQsLTAuNzE3NiwwLjcxNzYsMC42OTY0LC0xNDIuMzkzOCwyMS41MDE1KSIgICAgICAgICB5PSIxNzYuNjAwMDEiICAgICAgICAgeD0iLTQ2LjIwMDAwMSIgLz4gICAgPC9nPiAgPC9nPjwvc3ZnPg==);
background-repeat: no-repeat;
background-color: #fff;
background-position: right !important;

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
                                    <h4 class="box-title text-uppercase">kirim dokumen finance spk/CETAK LIST ARSIP<h4>
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
                                            <form id="formMsg" style="display: inline-flex;">
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
                                                <td id="customer">{{$item->customer}}</td>
                                                <td id="tender_time">{{$item->tender_time}}</td>
                                                <td id="user_pengarsip">{{$item->user_pengarsip}}</td>
                                                <td id="openget">{{$item->openget}}</td>
                                                <td id="catatan" style="text-align:right;">{{Str::limit($item->catatan, 15)}}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                            
                                        </tbody>
                                    </table>
                                    {{-- <div class="btn-group-mdl">
                                        <div class="button-items" style="display:inline-flex; float: right">
                                           <a href="/showSPK" type="button" class="btn btn-secondary waves-effect waves-light mr-4 btn_cancel">Cancel</a> 
                                           <button type="button" class="btn btn-info waves-effect btn_cetak" onclick="openMdl()">Cetak</button> 
                                        </div>
                                    </div> --}}
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
        <form action="/printSPK" method="post" id="messenger_form" target="_blank">
        @csrf
        <div class="table-responsive">
            <table class="display responsive" style="width:100%; border-style:none;">
            <tr class="tbl">
                <th style="width:150px;">Kode Pengarsipan</th>
                <th style="width:10px;">:</th>


                @if(count($arsip) > 0)
                <td id="kode_arsip">{{$arsip[0]->kode_arsip}}<input type="hidden" value="{{ $arsip[0]->kode_arsip }}"  name="kode_arsip"/></td>
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
                <td id="messengger_selected"></td>
            </tr>
            
            </table>
        <hr style="margin-top:4px;">
       
        </div>
        
        <div class="row mt-2" style="justify-content: center; ">
                    <div class="card" style="width:230px; min-height:100px; border: 1px solid #6666;">
                        <p style="justify-content: center; text-align:center; margin:auto;margin-top:12px;" class="mb-1">PILIH KOLOM</p>
                        <select name="from[]" id="lstview" class="form-control mt-2" size="12" multiple="multiple" style="width: 222px;margin: auto;border:unset;border-top:1px solid #6666;border-radius:unset; font-size: small;">
    
                            <option id="number" value="number">SPK</option>
                            <option id="customer" value="customer">Customer</option>
                            <option id="order_number"value="order_number">Order Number</option>
                            <option id="route_name"value="route_name">Route</option>
                            <option id="driver_name"value="driver_name">Driver Name</option>
                             <option id="secondary_driver_name"value="secondary_driver_name">Driver Name 2</option>
                            <option id="ccms_number"value="ccms_number">CCMS Number</option>
                            <option id="unit"value="unit">No Polisi</option>
                            <option id="tender_time"value="tender_time">Tender Time</option>
                            <option id="prepayment_status"value="prepayment_status">Prepayment Status OTM</option>
                            <option id="is_complete"value="is_complete">Status Dokument</option>
                            <option id="catatan"value="catatan">Remarks</option>
                            <option id="updated_by"value="updated_by">User</option>                    
    
                        </select>
                    </div>
                    
                    <div class="col-md-1" style="margin:auto; margin-right: 1px;margin-left: -17px;">
                        <button type="button" id="lstview_rightSelected" class="btn btn-link  btn-sm mb-1">>></button>
                        <button type="button" id="lstview_leftSelected" class="btn btn-link  btn-sm"><<</button>
                    </div>
                    
        <div class="card" style="width:230px; min-height:100px; border: 1px solid #6666; border-radius:none;">
             <p style="justify-content: center; text-align:center; margin:auto; margin-top:12px;" class="mb-1">CETAK KOLOM</p>
                        
            <select name="to[]" id="lstview_to" class="form-control mt-2" size="12" multiple="multiple" style="width: 222px;margin: auto;border:unset;border-top:1px solid #6666;border-radius:unset;font-size: small;">
                            <option value="number" style="display:none;">SPK</option>
                            <option value="number" disabled>SPK</option>
                            <option id="customer" value="customer">Customer</option>
                            <option id="prepayment_status" value="prepayment_status">Prepayment Status OTM</option>
                            <option id="is_complete" value="is_complete">Status Dokument</option>
                            <option id="catatan" value="catatan">Remarks</option>
                            <option id="updated_by" value="updated_by">User</option> 
                
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

                    $(window).keydown(function(event){
                    if(event.keyCode == 27) {

                        event.preventDefault();
                        return history.back();
                    }
                   
                });

                    $('#lstview').multiselect({
                        sort: false,
                    });
                    $('#cetakMdl').click(function(){
                    location.reload();
                        // $('#cetakListMDL').modal('hide');
                    });

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

                    dom:"<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-6 col-md-6 mt-3'p>>",

                    dom: 'rtBip',
                    buttons: [
                        {
                            text:'Batal',
                            className:'btn btn-secondary waves-effect waves-light btn_cancel',
                            action: function ( e, dt, button, config ) {
                            window.location.href = "/showSPK";
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
                // console.log($('#select_msg').val());
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
                    var data = $('#nama_msg').val();
                    
                    var hp = $('#msg_hp2').val();

                    $('#msg_hp2_').val(hp);
                    $('#nama_msg_').val(data);

                    $('#messengger_selected').append(data,' - ',hp);
                    $('#pengarsip').val($('#user_pengarsip').text());

                    }
     
                } else {
                    
                    toastr.error('Pilih messengger terlebih dulu !');

                }

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
                    listKolom.push($(this).val());
                    
                });
                // console.log(listKolom);
         
    
                var result;
               
                $.ajax({
                    
                    method: "POST",
                        
                    url: "/printSPK",
                        
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