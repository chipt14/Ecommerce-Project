@extends('frontend.main_master')
@section('content')

@section('title')
My Cart Page
@endsection

<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="home.html">Home</a></li>
                <li class='active'>MyCart</li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
    <div class="container">
        <div class="row ">
            <div class="shopping-cart">
                <div class="shopping-cart-table ">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="cart-image item">Image</th>
                                    <th class="cart-product-name item">Product Name</th>
                                    <th class="cart-color item">Color</th>
                                    <th class="cart-size item">Size</th>
                                    <th class="cart-qty item item">Quantity</th>
                                    <th class="cart-sub-total">Grandtotal</th>
                                    <th class="cart-romove item">Remove</th>
                                </tr>
                            </thead><!-- /thead -->
                            <tbody id="cartPage" class="text-center">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- /.row -->
        </div><!-- /.sigin-in-->
        @include('frontend.body.brands')
    </div><!-- /.container -->
</div><!-- /.body-content -->
<br>

@endsection