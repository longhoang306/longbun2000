<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start(); 
class ProductController extends Controller
{
    function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('Dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    function add_product(){
        $this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')->OrderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->OrderBy('brand_id','desc')->get();
        return view('admin.add_product')->with('cate_product',$cate_product)->with('brand_product',$brand_product);
    }
    function all_brand_product(){
        $this->AuthLogin();
        $all_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->OrderBy('tbl_product.product_id','desc')->get();
        $manager_product=view('admin.all_product')->with('all_product',$all_product);
        return view('admin_layout')->with('admin.all_product',$manager_product);

    }
    function save_product(Request $request){
        $this->AuthLogin();
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_price'] = $request->product_price;
        $data['product_desc'] = $request->product_name;
        $data['product_content'] = $request->product_name;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;
        $data['product_image'] = $request->product_image;
        $get_image = $request->file('product_image');

        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product',$new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->insert($data);
            Session::put('message', 'Bạn đã thêm sản phẩm thành công');
            return Redirect::to('add-product');
        }

        DB::table('tbl_product')->insert($data);
        Session::put('message', 'Bạn đã thêm thương hiệu thành công');
        return Redirect::to('add-product');    
    }
    function unactive_product($product_id){
        $this->AuthLogin();
        // DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status' =>1]);
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status' =>1]);
        Session::put('message', 'kích hoạt ko thành công');
        return Redirect::to('all-product');    
    }
    function active_product($product_id){
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status' =>0]);
        Session::put('message', 'kích hoạt thành công');
        return Redirect::to('all-product');
    }
    function edit_product($product_id){
        $this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')->OrderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->OrderBy('brand_id','desc')->get();

        $edit_product = DB::table('tbl_product')->where('product_id',$product_id)->get();
        $manager_product= view('admin.edit_product')->with('edit_product',$edit_product)->with('cate_product',$cate_product)->with('brand_product',$brand_product);
        return view('admin_layout')->with('admin.edit_product',$manager_product);
    }
    function update_product(Request $request,$product_id){
        $this->AuthLogin();
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_price'] = $request->product_price;
        $data['product_desc'] = $request->product_name;
        $data['product_content'] = $request->product_name;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;
        $get_image = $request->file('product_image');

        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product',$new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->where('product_id',$product_id)->update($data);
            Session::put('message', 'Bạn đã cập nhập thành công');
            return Redirect::to('all-product');
        }

        DB::table('tbl_product')->where('product_id',$product_id)->update($data);
        Session::put('message', 'Bạn đã cập nhập thành công');
        return Redirect::to('all-product');
        

    }
    function delete_product($product_id){
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$product_id)->delete();
        Session::put('message', 'Bạn đã Xóa thành công');
        return Redirect::to('all-product');
    }
}
