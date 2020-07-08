@extends('layout.master')

@section('title','Ganti Password User')

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
    

    </style>
    
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card" style="margin-bottom:0px !important">
            <div class="row">
                <div class="col-lg-12">
                  <div class="row">
                    
                    
                    <div class="col-lg-12" style="margin:1.5%;">
                      <h4 class="box-title text-uppercase">Ubah Kata Sandi</h4>
                    </div>
                    <div style="display: none;">
                     <div class="col-lg-6">
                      
                        <div class="card-body card-block">
                        <form id="contactForm" action="/changePassword" method="post">
                          {{ csrf_field() }}
                          <div class="form-group">
                            <input type="hidden" id="user_id" value="{{$data['user_id'] }}">
                            <label for="username" class=" form-control-label">Username</label>
                            <input type="text" class="form-control" id="username" value="{{ $data['user_name'] }}" name="username" disabled>
                          </div>
                          <div class="form-group">
                            <label for="email" class=" form-control-label">Email</label>
                            <input type="email" class="form-control" value="{{ $data['email'] }}" id="email" name="email" disabled>
                          </div>
                          
                          <div class="form-group">
                            <input type="hidden" name="active_from" value="{{ $data['effective_from'] }}">
                            <label for="active_to" class=" form-control-label">Efective To</label>
                            
                            <input type="text" class="form-control" id="" value="{{ $data['effective_to'] }}" name="" disabled>
                            <input type="hidden" class="form-control" id="active_to" value="{{ $data['effective_to'] }}" name="active_to" >
                          </div>
                          </div>
                        </div>

                        
                        <div class="col-lg-6">
                         
                          <div class="card-body card-block">
                          <div class="form-group">
                            <label for="fname" class=" form-control-label">First Name</label>
                            <input type="text" class="form-control" id="fname" value="{{ $data['first_name'] }}" name="fname" required>
                          </div>
                          <div class="form-group">
                            <label for="lname" class=" form-control-label">Last Name</label>
                            <input type="text" class="form-control" id="lname" value="{{ $data['last_name'] }}" name="lname" required>
                          </div>
                          <div class="form-group">
                            <label for="phone" class=" form-control-label">Mobile Phone</label>
                          <input type="text" class="form-control" value="{{ $data['mobile_phone'] }}" id="phone" name="phone" required>
                          </div>
                          
                          </div>
                        </div>
                    </div>
                        

                      
                          
                          <div class="col-lg-6">
                            <div class="card-body card-block">
                            <div class="form-group">
                              <label for="password" class=" form-control-label">Kata Sandi Baru</label>
                              <input type="password" class="form-control" name="password" id="password" name="password">
                              
                            </div>
                            </div>
                            <h4 class="ml-3" style="float:left; margin-top:-3%"><small style="font-style:italic;">Kosongkan jika tidak ada perubahan</small></h4>
                          </div>

                          <div class="col-lg-6">
                            <div class="card-body card-block">
                            <div class="form-group">
                              <label for="confirm_psw" class=" form-control-label">Konfirmasi Kata Sandi</label>
                              <input type="password" class="form-control" name="confirm_psw" id="confirm_psw" name="confirm_psw">
                            </div>
                          </div>
                          
                          <div class="button-items float-right m-3">
                            <a href="/" type="button" class="btn btn-secondary waves-effect waves-light mr-4 text-uppercase" style="width:150px;">Batal</a>
                            <button id="btnSubmit" type="submit" class="btn btn-info waves-effect text-uppercase"style="width:150px;">Ubah  sandi</button>
                         </div>
                        </form>
                          
                      </div> 
                    </div>
                </div> 
            </div> <!-- /.row -->
        </div>
    </div><!-- /# column -->


    


@endsection

@section('js')

    <script type="text/javascript">
 (function($) {
$(document).ready(function() {

  $("#btnSubmit").click(function () {
            var password = $("#password").val();
            var confirmPassword = $("#confirm_psw").val();
            if (password != confirmPassword) {
              toastr.error('Password dan Confirm password tidak sama!');
                return false;
              } else if(password.length < 6){
                toastr.error('Password minimal 6 characters!');
                return false;
              }else {
                return true;
              }
            
            
        });
       
});
 })(jQuery);  


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
