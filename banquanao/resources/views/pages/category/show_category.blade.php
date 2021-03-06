@extends('layout')
@section('content')   
<div class="features_items">
    <!--features_items-->
    @foreach ($category_name as $key =>$name)
        <h2 class="title text-center">{{$name->category_name}}</h2>
    @endforeach
    @foreach ($category_by_id as $key =>$product)
    <div class="col-sm-4">
        <div class="product-image-wrapper">
            <div class="single-products">
                    <div class="productinfo text-center">
                        <img src="{{url('public/uploads/product/'.$product->product_image)}}" alt="" width="400" height="300">
                    <h2>{{number_format($product->product_price).'  '.'VNĐ'}}</h2>
                    <p>{{$product->product_name}}</p>
                        <a href="#" class="btn btn-default add-to-cart">
                            <i class="fa fa-shopping-cart"></i>Add to cart
                        </a>
                    </div>

            </div>
            <div class="choose">
                <ul class="nav nav-pills nav-justified">
                    <li><a href="#"><i class="fa fa-heart"></i>Thả tym</a></li>
                    <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
                </ul>
            </div>
        </div>
    </div>
    @endforeach
    
<!--/category-tab-->

<!--recommended_items-->
<!--/recommended_items-->
@endsection