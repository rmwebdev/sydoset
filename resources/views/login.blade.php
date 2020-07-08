<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <link rel="stylesheet" href="ElaAdminAsset/assets/css/lib/ext/bootstrap.min.css">
    <link rel="stylesheet" href="ElaAdminAsset/assets/css/lib/ext/font-awesome.min.css">
    <link rel="stylesheet" href="ElaAdminAsset/assets/css/lib/ext/themify-icons.css">
    <link rel="stylesheet" href="{{ asset('ElaAdminAsset/assets/css/lib/ext/toastr.min.css') }}"/>

    <style type="text/css">

        @import url('https://fonts.googleapis.com/css?family=Rubik&display=swap');        

        body{
            background: #2f318b;
            font-family: "Rubik", sans-serif;
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
    <script src="{{ asset('ElaAdminAsset/assets/css/lib/datatable/jQuery-3.3.1/jquery-3.3.1.min.js') }}"></script>
    
    <script src="ElaAdminAsset/assets/js/lib/ext/bootstrap.min.js"></script>
    <script src="{{ asset('ElaAdminAsset/assets/js/lib/ext/toastr.min.js') }}"></script>
</head>
<body>
    <div class="container">
        <div class="title" style="order: 1;">
            <center><span>
                <img src="img/login_icon.png" width="447px" height="70px" style="margin-bottom: 15px;">
            </span></center>
        </div>
        <div class="wrap-login" style="order:2;"> 
            
            <form method="POST" action="{{ url('/loginPost') }}" id="form_login">
                @csrf
                
                <div class="card" style="height: 440px;">
                    <div class="form-group">
                        <label class="labelCard" for="userId">Username</label>
                        <input type="text" class="form-control" id="userId" name="userId"placeholder="Username" style="height:48px" required>
                    </div>

                    <div class="form-group">
                        <label class="labelCard" for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" style="height:48px" required>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck" name="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                Remember me
                            </label>
                        </div>
                    </div>

                    <input class="btn" style="margin-top:3em;background: #feab1f;color: #fff;font-weight: 600;margin-left:80px;margin-right:80px;margin-bottom: 8px;" type="submit" id="btnSubmit" name="btnSubmit" value="Login">
                    <a href="{{url('/resetPass')}}" style="text-align: center;font-size: 14px;"><i>Forgot Password</i></a>
                </div>
            </form>
        </div>
        
        <div class="imgFooter" style="order: 3;margin-top: 45px;">
            <img src="logopuninarwhite.png" width="166px" height="36px"/>
        </div>
        
    </div>
    
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