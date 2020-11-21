<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();    
class AdminController extends Controller
{
    function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('Dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    function index(){
        return view('admin_login');
    }

    function show_dashboard(){
        $this->AuthLogin();
        return view('admin.dashboard');
    }
    function dashboard(Request $request){
       $admin_email = $request->admin_email;
       $admin_password = md5($request->admin_password);

       $result = DB::table('tbl_admin')->where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
       if($result){
           Session::put('admin_name', $result->admin_name);
           Session::put('admin_id', $result->admin_id);
           return Redirect::to('/dashboard');
       }else{
           Session::put('message','Mật khẩu hoặc tài khoản không tồn tại.Làm ơn nhập lại');
           return Redirect::to('/admin');
       }    
    }
    function logout(){
        $this->AuthLogin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/admin');
    }
    
}
