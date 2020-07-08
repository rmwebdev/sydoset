<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Session;

class ChangePswController extends Controller
{
    public function __construct(){
        $this->api_url  = config('info.api_url');
        $this->app_id   = config('info.app_id');
    }


    public function changepsw(){

        $token      = base64_decode(session()->get('token'));
        $user_id    = json_decode($token)->key_1;
        $data       = $this->getUserById($user_id)['data'][0];
        return view('form.Settings.changepsw.index', compact('data'));
    }

    protected function getUserById($id){
        $url = $this->api_url.'/request-data-table';
        $client = new \GuzzleHttp\Client([
            'headers'       => ['Content-type' => 'application/json', 'apptoken' => \Session::get('token'), 'appmenu' => 'menu-settle'],
            'http_errors'   => false
        ]);
        
        $response = $client->post($url,
            ['body' => json_encode(
                [
                    'type' => 'data_user_by_id',
                    'params'  => [
                        'user_id' => $id
                    ]
                    
                ]
            )]
        );
        
        $data_return = json_decode($response->getBody()->getContents(),1);

        return $data_return;
    }

    public function changePassword(Request $request){


// dd($request->all());

        $token      = base64_decode(session()->get('token'));
        $user_id    = json_decode($token)->key_1;

        $url = $this->api_url.'/request-transaction';
        $client = new \GuzzleHttp\Client([
            'headers'       => ['Content-type' => 'application/json', 'apptoken' => Session::get('token'), 'appmenu' => 'menu-settle'],
            'http_errors'   => false
        ]);
        
        $response = $client->post($url,
            ['body' => json_encode(
                [
                    'model_name' => 'user',
                    'transaction_type' => 'update',
                    'params'  => [
                        'user_id'           => $user_id,
                        'effective_from'    => $request->active_from,
                        'effective_to'      => $request->active_to,
                        'first_name'        => $request->fname,
                        'last_name'         => $request->lname,
                        'mobile_phone'      => $request->phone,
                        'blocked'           => '0',
                        'password'          => $request->password,
                    ]
                    
                ]
            )]
        );
        
        $data_return = json_decode($response->getBody()->getContents(),1);

        if(isset($data_return['error'])){
            Session::flash('message', 'Oppss ada yang salah hubungi admin it');
            Session::flash('alert-type', 'error');
            return Redirect::back();

        }elseif($data_return['stat'] == 1){

            // Session::flash('message', $request->fname . ' '. $request->lname .' berhasil di update');
            Session::flash('message','Password berhasil di update');
            Session::flash('alert-type', 'success');
            return redirect()->action('MainController@index');

        }else{
            Session::flash('message', 'Oppss ada yang salah hubungi admin it');
            Session::flash('alert-type', 'error');
            return Redirect::back();
        }



        // Return View

        
    }
}
