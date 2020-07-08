@extends('layout.master')

@section('title','Master Messenger')

@section('css')
    <style type="text/css">
    .dataTables_filter {
       float: right !important;
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
    .editbtn {
        text-align:right;
        color: #f4f800;
    }
    .deletebtn {
        text-align:right;
        color: #e93507;
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
    
.aksi_btn {
  display: inline-block;
}
.btn_cetak {

    height: 35px;
    border-radius:6px;
}
div.dataTables_wrapper div.dataTables_filter input {

background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PHN2ZyAgIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgICB4bWxuczpjYz0iaHR0cDovL2NyZWF0aXZlY29tbW9ucy5vcmcvbnMjIiAgIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyIgICB4bWxuczpzdmc9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiAgIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgICB2ZXJzaW9uPSIxLjEiICAgaWQ9InN2ZzQ0ODUiICAgdmlld0JveD0iMCAwIDIxLjk5OTk5OSAyMS45OTk5OTkiICAgaGVpZ2h0PSIyMiIgICB3aWR0aD0iMjIiPiAgPGRlZnMgICAgIGlkPSJkZWZzNDQ4NyIgLz4gIDxtZXRhZGF0YSAgICAgaWQ9Im1ldGFkYXRhNDQ5MCI+ICAgIDxyZGY6UkRGPiAgICAgIDxjYzpXb3JrICAgICAgICAgcmRmOmFib3V0PSIiPiAgICAgICAgPGRjOmZvcm1hdD5pbWFnZS9zdmcreG1sPC9kYzpmb3JtYXQ+ICAgICAgICA8ZGM6dHlwZSAgICAgICAgICAgcmRmOnJlc291cmNlPSJodHRwOi8vcHVybC5vcmcvZGMvZGNtaXR5cGUvU3RpbGxJbWFnZSIgLz4gICAgICAgIDxkYzp0aXRsZT48L2RjOnRpdGxlPiAgICAgIDwvY2M6V29yaz4gICAgPC9yZGY6UkRGPiAgPC9tZXRhZGF0YT4gIDxnICAgICB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLC0xMDMwLjM2MjIpIiAgICAgaWQ9ImxheWVyMSI+ICAgIDxnICAgICAgIHN0eWxlPSJvcGFjaXR5OjAuNSIgICAgICAgaWQ9ImcxNyIgICAgICAgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjAuNCw4NjYuMjQxMzQpIj4gICAgICA8cGF0aCAgICAgICAgIGlkPSJwYXRoMTkiICAgICAgICAgZD0ibSAtNTAuNSwxNzkuMSBjIC0yLjcsMCAtNC45LC0yLjIgLTQuOSwtNC45IDAsLTIuNyAyLjIsLTQuOSA0LjksLTQuOSAyLjcsMCA0LjksMi4yIDQuOSw0LjkgMCwyLjcgLTIuMiw0LjkgLTQuOSw0LjkgeiBtIDAsLTguOCBjIC0yLjIsMCAtMy45LDEuNyAtMy45LDMuOSAwLDIuMiAxLjcsMy45IDMuOSwzLjkgMi4yLDAgMy45LC0xLjcgMy45LC0zLjkgMCwtMi4yIC0xLjcsLTMuOSAtMy45LC0zLjkgeiIgICAgICAgICBjbGFzcz0ic3Q0IiAvPiAgICAgIDxyZWN0ICAgICAgICAgaWQ9InJlY3QyMSIgICAgICAgICBoZWlnaHQ9IjUiICAgICAgICAgd2lkdGg9IjAuODk5OTk5OTgiICAgICAgICAgY2xhc3M9InN0NCIgICAgICAgICB0cmFuc2Zvcm09Im1hdHJpeCgwLjY5NjQsLTAuNzE3NiwwLjcxNzYsMC42OTY0LC0xNDIuMzkzOCwyMS41MDE1KSIgICAgICAgICB5PSIxNzYuNjAwMDEiICAgICAgICAgeD0iLTQ2LjIwMDAwMSIgLz4gICAgPC9nPiAgPC9nPjwvc3ZnPg==);
background-repeat: no-repeat;
background-color: #fff;
background-position: right !important;
margin-bottom: 5px;

}

.searchbtn {
  border: none;
    background: none;
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
                            <div class="col-lg-6 mb-4">
                                <h4 class="box-title text-uppercase">Messengers</h4>
                            </div>
                        </div>
                         <table id="tbl_msg" class="table responsive nowrap" style="width:100%"></table>
                            <!-- </div> -->
                        <!-- </div> -->
                    </div>
                </div>
            </div> <!-- /.row -->
        </div>
    </div><!-- /# column -->


    {{-- Modal Add --}}
    <div class="modal" tabindex="-1" role="dialog" id="addMdl">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-uppercase">Tambahkan Messenger</h5>
              
            </div>
            <div class="modal-body">
                <form id="formAddMsg">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">NPK</label>
                        <input type="text" class="form-control noNpk"  name="noNpk" id="noNpk">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Nama Lengkap</label>
                        <input type="text" class="form-control namaMsg"  name="namaMsg" id="namaMsg">
                      </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Nomor Ponsel</label>
                      <input class="form-control nohpMsg"  name="nohpMsg" id="nohpMsg">
                    </div>
                    <div class="form-group" >

                        <label for="status">Status</label><br/>
                        <select class="form-control" name="status" id="status">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                          </select>
                    </div> 
                    
                    <div class="modal-footer mt-5">
                        <button type="button" class="btn btn-secondary col-md-6" data-dismiss="modal" style="width:50%">BATAL</button>
                        <button type="submit" class="btn btn-primary col-md-6" style="width:50%; padding:none">SIMPAN</button>
                    </div>
                  </form>
            </div>
          </div>
        </div>
      </div>


    {{-- Modal Edit --}}

    <div class="modal" tabindex="-1" role="dialog" id="editMdl">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-uppercase">Edit Messenger </h5>
              
            </div>
            <div class="modal-body">
               
                    <form id="formEdit">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                      <label for="exampleInputEmail1">NPK</label>
                      <input type="text" class="form-control noNpk" id="noNpk_" name="noNpk">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Lengkap</label>
                        <input type="text" class="form-control namaMsg_" id="namaMsg_" name="namaMsg">
                      </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">No Ponsel</label>
                      <input class="form-control nohpMsg" id="nohpMsg_" name="nohpMsg">
                    </div>
                    <div class="form-group" >

                        <label for="status">Status</label><br/>
                        <select class="form-control" name="status" id="status">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                          </select>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary col-md-6" data-dismiss="modal">BATAL</button>
                        <button type="submit" class="btn btn-primary col-md-6">SUBMIT</button>
                    </div>
                    
                  </form>
            </div>
          </div>
        </div>
      </div>


      <div class="modal fade" id="deleteMdl" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <label class="modal-title" id="confirmModalLabel">Perhatian!</label>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="formDelete">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}

                    <input type="hidden" name="id" id="id">
                    <p> Anda akan menghapus messenger <span id="namaMsg1"></span></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary col-md-6" id="btnTidak" data-dismiss="modal">TIDAK</button>
              <button type="submit" class="btn btn-primary col-md-6" id="btnYa">YA</button>
            </div>
        </form>
          </div>
        </div>
      </div>
</div>
{{-- <button class="btn btn-info btn-xs" type="button" data-toggle="modal" data-target="#addMdl" style="width:300px; float:right;"><i style="margin-right:10px" class="fa fa-plus"></i>&nbsp;Add New</button> --}}
@endsection

@section('js')

<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>

    <script type="text/javascript">
        var table;
        (function($) {
            $(document).ready(function() {
                
                table = $('#tbl_msg').DataTable({

                  
                  dom: 'Brtip',
                    buttons: [ 
                        {
                            text:'<i class="fa fa-plus"></i> &nbsp; TAMBAHKAN',
                            className:'btn btn-xm btn-primary waves-effect waves-light btn_cetak',
                            action: function ( e, dt, button, config ) {
                              openModal();
                            }
                        },
                        {
                            // text:'<i class="fa fa-plus"></i> &nbsp; TAMBAHKAN',
                            text: '<div class="row" style="border:none;"><div class="col-lg-12 clearfix">'+
                              '<input type="text" class="form-control" style="display: inline !important;width:200px !important;vertical-align:middle !important;height: 30px; " placeholder="Pencarian" id="searchDatatable"/>'+
                              '<button type="button" class="btn btn-secondary" id="resetTable" style="background:transparent;border-color:transparent;" onClick="resetSearchDatatable()"><i class="fa fa-undo" style="color:#8d8ea4; margin-right:-10px;"></i></button>'+
                              '</div></div>',
                            className:'float-right searchbtn',
                            action: function ( e, dt, button, config ) {
                              
                             

                            }
                        }
                    ], 
                    ajax: {
                        url: '/loadDataMsg',
                        type:"POST",
                        dataSrc:'',
                        data : {
                       type:1
                        }
                    },
                    
                    'responsive': true,
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
                    // language: {
                    //  search: "_INPUT_",
                    //     searchPlaceholder: 'Pencarian'
                    // },
                                
                      
                    columns: [ 

                        { data:'no', title: 'NO', className: 'dt-td-center',width:"15px"},
                        { data:'noNpk', title: 'NPK', width:"150px", className: 'dt-td-center'},
                        { data:'nama', title: 'NAMA', width:"300px", className: 'dt-td-center'},
                        { data:'no_hp', title: 'NOMOR PONSEL', width:"200px", className: 'dt-td-center'},
                        { data:'status', title: 'STATUS', width:"150px", className: 'dt-td-center'},
                        // { data:'status', title: 'STATUS', width:"150px", className: 'dt-td-center',
                      
                        //     render: function ( data, type, row ) {
                        //     var text = "";
                        //     var label = "";
                        //     if (data == "Active"){
                        //     text = "Active";
                        //     label = "success";
                        //     } else 
                        //     if (data == "Inactive"){
                        //     text = "Inactive";
                        //     label = "warning";
                        //     }
                        //     return "<span class='badge badge-" + label + "'>"+ text + "</span>";
                        //   }
                        // },
                        {
                            orderable: false,
                            title: "AKSI",
                            render: function(data, type, full, meta)
                            {
                                return '<div class="float-right" style=""><a href="#" class="btn btn-link editbtn"><img src="{{ asset("icon/edit.png") }}"></a><a href="#" class="btn btn-link deletebtn"><img src="{{ asset("icon/trash.png") }}"></a></div>';
                                
                                
                            }
                        },

                    ],
                
                });

                $('#searchDatatable').keyup(function(e){
                    if(e.keyCode == 13)
                    {
                      table.search( this.value ).draw();
                    }
                });

                table.on('click', '.editbtn',function(){
                    $tr = $(this).closest('tr');
                    if($($tr).hasClass('child')){
                        $tr = $tr.prev('.parent');
                    }

                    var data = table.row($tr).data();
                    // console.log(data['nama']);
                    $('#id').val(data['id']);
                    $('#noNpk_').val(data['noNpk']);
                    $('#namaMsg_').val(data['nama']);
                    $('#nohpMsg_').val(data['no_hp']);

                    if(data['status']=='Active'){
                        $("#status option[value=Active]").attr('selected', 'selected');
                    } else {
                        $("#status option[value=Inactive]").attr('selected', 'selected'); 
                   
                    }
                    
                    $('#editMdl').modal('show');
                });

               
                // submit prosses edit messenger

                $('#formEdit').on('submit', function(e){
                    e.preventDefault();
                    var id = $('#id').val();
                    $.ajax({
                        type: 'PUT',
                        url: '/editDataMsg/'+id,
                        data: $('#formEdit').serialize(),
                        success: function(response){
                            console.log(response);
                            $('#editMdl').modal('hide');                           
                            location.reload();
                            toastr.success('Messenger successfully updated!');

                        }, 
                        error: function(error){
                            console.log(error);
                            toastr.error('Oops something went wrong!');
                        }
                    });

                    $("[name='namaMsg']").prop("required", true);
                    $("[name='noNpk']").prop("minLength", 5);
                    $("[name='noNpk']").prop("maxLength", 8);
                    $("[name='namaMsg']").prop("minLength", 3);
                    $("[name='namaMsg']").prop("maxLength", 50);
                    $("[name='nohpMsg']").attr("required", true);
                    $("[name='nohpMsg']").prop("minLength", 10);
                    $("[name='nohpMsg']").prop("maxLength", 15);

                    var htmlString = $('#formEdit').html();
                    $('.output').text(htmlString);

                });


                table.on('click', '.deletebtn',function(){
                    $tr = $(this).closest('tr');
                    if($($tr).hasClass('child')){
                        $tr = $tr.prev('.parent');
                    }

                    var data = table.row($tr).data();
                    // console.log(data['nama']);
                    $('#id').val(data['id']);
                    $('#namaMsg1').text(data['nama']);
                    $('#deleteMdl').modal('show');
                });

                // submit prosses delete messenger

                $('#formDelete').on('submit', function(e){
                    e.preventDefault();
                    var id = $('#id').val();

                    $.ajax({
                        type: 'DELETE',
                        url: '/deleteDataMsg/'+id,
                        data: $('#formDelete').serialize(),
                        success: function(response){
                            console.log(response);
                            $('#deleteMdl').modal('hide');                           
                            location.reload();
                            toastr.success('Messenger successfully deleted!');

                        }, 
                        error: function(error){
                            console.log(error);
                            toastr.error('Oops something went wrong!');
                        }
                    });

                });

                    // submit prosses add messenger

                $('#formAddMsg').on('submit', function(e){
                    e.preventDefault();

                    $.ajax({
                        type: 'POST',
                        url: '/addDataMsg',
                        data: $('#formAddMsg').serialize(),
                        success: function(response){
                            console.log(response)
                            $('#addMdl').modal('hide');
                            location.reload();
                            toastr.success('Messenger successfully added!');
                            location.reload();
                        },
                        error: function(error){
                            console.log(error)
                            toastr.error('Oops something went wrong!');
                        }
                    });
                    
                });
        $("#nohpMsg").inputFilter(function(value) {
        return /^-?\d*$/.test(value); });


        $("[name='namaMsg']").prop("required", true);
        $("[name='noNpk']").prop("minLength", 5);
        $("[name='noNpk']").prop("maxLength", 8);
        $("[name='namaMsg']").prop("minLength", 3);
        $("[name='namaMsg']").prop("maxLength", 50);
        $("[name='nohpMsg']").attr("required", true);
        $("[name='nohpMsg']").prop("minLength", 10);
        $("[name='nohpMsg']").prop("maxLength", 15);
     

        var htmlString = $('#formAddMsg').html();
        $('.output').text(htmlString);

        });
   })(jQuery);


   function resetSearchDatatable() {
            (function($) {
                $('#searchDatatable').val('');
                table.search('').draw();
            })(jQuery);
        }

function openModal(){
  (function($) {
  
    $('#addMdl').modal('show');
  }(jQuery));
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
}(jQuery));  

</script>
@endsection
