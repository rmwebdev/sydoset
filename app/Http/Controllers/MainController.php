<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\log_session;
use Log;

class MainController extends Controller
{
    public function __construct(){
        $this->api_url  = config('info.api_url');
        $this->app_id   = config('info.app_id');
    }

    //index
    public function index()
    {
        # code...
        $ambil_token = Session::get('token');
        // $ambil_token = \Request->session()->get('token');
        Log::info($ambil_token);
        if($ambil_token==''){
            return redirect()->route('login');
        } else {
            return view('welcome', ['token' => $ambil_token]);
        }
    }

    public function login()
    {
        # code...
        return view('login');
    }

    public function loginPost(Request $request)
    {
        # code...
        
        $url = $this->api_url.'/login-app';
        $client = new \GuzzleHttp\Client([
            'headers'       => ['Content-type' => 'application/json', 'apptoken' => Session::get('token'), 'appmenu' => 'menu-settle'],
            'http_errors'   => false
        ]);
        
        $response = $client->post($url,
            ['body' => json_encode(
                [
                    'user_name' => $request->userId,
                    'password'  => $request->password,
                    'app_id'    => $this->app_id
                ]
            )]
        );
        
        $data_return = json_decode($response->getBody()->getContents(),1);
        // var_dump($data_return);exit();die();
        if (isset($data_return['error'])) {
            $request->session()->flash('statusErr', $data_return['error']);
            $notification = array(
                'message' => $data_return['error'],
                'alert-type' => 'error'
            );
            Redirect::to('/login')->with($notification);
        }

        if (isset($data_return['stat'])) {
            if ($data_return['stat']==1) {
                $user               = $data_return['app_token']; 
                $menu1              = json_encode($data_return['app_menu']);
                $nama1              = $data_return['user'];
                $nama_first_user    = $data_return['user'][0]['first_name'];
                $nama_last_user     = $data_return['user'][0]['last_name'];
                $email              = $data_return['user'][0]['email'];
                $effective_from     = $data_return['user'][0]['effective_from'];
                $effective_to       = $data_return['user'][0]['effective_to'];
                $nama_default_cust  = $data_return['user'][0]['default_customer_name'];
                $list               = $data_return['user'][0]['list_customer'];
                $list_code          = $data_return['user'][0]['list_customer'];
                $logo               = $data_return['user'][0]['default_company_logo'];
                $grading            = $data_return['user'][0]['grade_name'];
                $role               = $data_return['role'][0]['role'];
                
                
                $test = [];
                foreach($list_code as $cd){
                    array_push($test, $cd['code']);
                }

                // print_r($menu1); exit;


                $admin      = $data_return['user'][0]['is_admin'];
                $default    = sprintf('%.0f', $data_return['user'][0]['default_customer']);
                $ip = $_SERVER['REMOTE_ADDR'];
                $localIP = getHostByName(getHostName());

                $checkSessions = log_session::where('ip','!=',$localIP)->where('user_id', $this->getUserId($user))->where('is_logout', 0)->count();
                if ($checkSessions == 0 ) {
                    $logSession = new log_session;

                    $logSession->is_logout = 0;
                    $logSession->token = $user;
                    $logSession->ip = $localIP;
                    $logSession->user_id = $this->getUserId($user);

                    $logSession->save();
                } else if ($checkSessions > 0) {
                    $request->session()->flash('statusMsg', 'User anda sedang login di komputer lain');
                    $notification = array(
                        'message' => 'User anda sedang login di komputer lain',
                        'alert-type' => 'warning'
                    );
                    return Redirect::to('/login')->with($notification);
                }
                
                Session::put('token', $user);
                Session::put('menu', $menu1);
                // session->put(['menu' => $menu1]);
                // $request->session()->put(['menu' => $menu1]);
                Session::put('nama', $nama1);
                Session::put('nama_user', $nama_first_user);
                Session::put('nama_user_last', $nama_last_user);
                Session::put('email', $email);
                Session::put('effective_from', $effective_from);
                Session::put('effective_to', $effective_to);
                Session::put('nama_default_cust', $nama_default_cust);
                Session::put('list', $list);
                Session::put('list_code', $list_code);
                Session::put('admin', $admin);
                Session::put('default', $default);
                Session::put('logo', $logo);
                Session::put('grad', $grading);
                Session::put('role', $role);

                $cetak                      = Session::get('token');
                $cetak_menu                 = Session::get('menu');
                $cetak_nama                 = Session::get('nama');
                $cetak_nama_user            = Session::get('nama_user');
                $cetak_nama_user_last       = Session::get('nama_user_last');
                $cetak_nama_default_cust    = Session::get('nama_default_cust');
                $cetak_list                 = Session::get('list');
                $cetak_list_code            = Session::get('list_code');
                $cetak_admin                = Session::get('admin');
                $cetak_default              = Session::get('default');
                $logo_cust                  = Session::get('logo');
                $grad_menu                  = Session::get('grad');
                $from                       = Session::get('effective_from');
                $to                         = Session::get('effective_to');
                $email                      = Session::get('email');    

                
                // var_dump('$ip');
                // var_dump($localIP);exit();die();

                

                return redirect()->route('index');
                
            } else {
                $request->session()->flash('statusMsg', $data_return['msg']);
                $notification = array(
                    'message' => $data_return['msg'],
                    'alert-type' => 'warning'
                );
                return Redirect::to('/login')->with($notification);
            }
        }
    }

    public function logout(Request $request){        
        $localIP = getHostByName(getHostName());
        $logSession = log_session::where('user_id',$this->getUserId(Session::get('token')))
                        ->where('ip',$localIP)
                        ->where('token', Session::get('token'))
                        ->update(['is_logout'=>1]);
        $request->session()->flush();
        return redirect()->route('login');
    }

    public function resetPass()
    {
        # code...
        return view('resetPassword');
    }

    public function forgotPass(Request $request){

        // Log::info($request->email/);
        $url = $this->api_url.'/request-transaction-ns';

        $email = $request->email;

        $client = new \GuzzleHttp\Client([
            'headers'   => ['Content-type' => 'application/json'],
            'http_errors' => false
        ]);

        $response = $client->post($url,
            ['body' => json_encode(
                [
                    'transaction_type'  => 'password_update',
                    'params' => [
                        'user_name'     => $email,
                        'app_id'        => $this->app_id
                    ]
                ]
            )]
        );  

        $data_return = json_decode($response->getBody()->getContents(),1);
        Log::info($data_return);

        if ($data_return['stat']==1) {
            $request->session()->flash('stat', $data_return['stat']);
            $notification = array(
                'message' => $data_return['msg'],
                'alert-type' => 'success'
            );
            return redirect()->route('login')->with($notification);
        } elseif($data_return['stat']==8){
            $request->session()->flash('stat', $data_return['stat']);
            $notification = array(
                'message' => $data_return['msg'],
                'alert-type' => 'warning'
            );
            return redirect()->route('resetPass')->with($notification);    
        } else {
            $request->session()->flash('stat', $data_return['stat']);
            $notification = array(
                'message' => $data_return['msg'],
                'alert-type' => 'warning'
            );
            return redirect()->route('resetPass')->with($notification);  
        }

        //$cek = preg_match("/'|;|:|\//", $request->user_name);

        // if ($cek == 1) {
        //     return view('error');
        // }else{

        // }
    }

    private function getUserId($token){
        $user       = base64_decode($token);
        $user_id    = json_decode($user);

        return $user_id->key_1;
    }

}
