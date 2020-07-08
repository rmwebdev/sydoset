<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>

    <link rel="stylesheet" href="ElaAdminAsset/assets/css/lib/ext/bootstrap.min.css">
    <link rel="stylesheet" href="ElaAdminAsset/assets/css/lib/ext/font-awesome.min.css">
    <link rel="stylesheet" href="ElaAdminAsset/assets/css/lib/ext/themify-icons.css">
    <link rel="stylesheet" href="{{ asset('ElaAdminAsset/assets/css/lib/ext/toastr.min.css') }}"/>

    <style type="text/css">

        @import url('https://fonts.googleapis.com/css?family=Rubik&display=swap');        

        body{
            background-color: #2f318b !important;
            font-family: "Rubik", sans-serif !important;
        }
        .container{
            min-height: 100vh;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            background-color:#2f318b;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            position: relative;
            z-index: 1;
        }
        .wrap-login{
            width: 440px;
            height: 440px;
            border-radius: 8px;
        }

        .wrap-login h5{
            color: white;
        }

        .labelCard{
            font-weight: 700;
            font-size:18px;
        }

        .card{
            padding: 32px 24px;
        }

        
    </style>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ asset('ElaAdminAsset/assets/css/lib/bootstrap/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('ElaAdminAsset/assets/css/modal.css') }}"/>
    <script src="{{ asset('ElaAdminAsset/assets/css/lib/datatable/jQuery-3.3.1/jquery-3.3.1.min.js') }}"></script>
    <script src="ElaAdminAsset/assets/js/lib/ext/bootstrap.min.js"></script>
    <script src="{{ asset('ElaAdminAsset/assets/js/lib/ext/toastr.min.js') }}"></script>
</head>
<body>
    <div class="container">
        <div class="title" style="order: 1;">
            <center><span><label style="font-size:32px;font-weight:700;color:#fff;margin-bottom:16px;margin-top:32px;">FORGOT PASSWORD</label></span></center>
        </div>
        <div class="wrap-login" style="order: 2;"> 
            <form method="POST" action="{{ url('/forgotPass') }}" id="form_reset_pass">
                @csrf
                <div class="card" style="height: 440px;">
                    <div class="form-group">
                        <label class="labelCard" for="userId">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" style="font-size:16px;height:48px;">
                        <p style="font-size:14px;margin-top:8px;color:#1d1e4b">Silakan masukkan email Anda untuk link forgot password</p>
                    </div>

                    <input class="btn" style="margin-top:12em;background: #feab1f;color: #fff;font-weight: 600;margin-left:80px;margin-right:80px;margin-bottom: 8px;" type="submit" id="btnSubmit" name="btnSubmit" value="Submit">
                    <a href="{{url('/login')}}" style="text-align: center;font-size: 14px;">Cancel</a>
                </div>
            </form>
        </div>
        <div class="imgFooter" style="order: 3;margin-top: 45px;">
            <img src="logopuninarwhite.png" width="166px" height="36px"/>
        </div>
        
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title" style="float:left;margin-right:auto">Berhasil</label>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
            </div>
            <div class="modal-body">
                <p>Email forgot password berhasil dikirim, silakan cek email Anda.</p>
            </div>
            <div class="modal-footer" style="flex-direction: column;">
                <button type="button" class="btn btn-info">YA</button>
            </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function openModal() {
                $('#myModal').modal("show");
        }
    </script>
    
    <script type="text/javascript">
        @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch(type){
                case 'info':
                    toastr.info("{{ Session::get('message') }}");
                    break;

                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                    break;

                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;

                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
        @endif
    </script>
</body>
</html>