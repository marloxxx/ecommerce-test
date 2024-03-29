@extends('layouts.frontend.master')
@section('title', 'Cart Page')
@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ 'home' }}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="">Cart</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Shopping Cart -->
    <div class="shopping-cart section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Shopping Summery -->
                    <table class="table shopping-summery">
                        <thead>
                            <tr class="main-hading">
                                <th>PRODUCT</th>
                                <th>NAME</th>
                                <th class="text-center">UNIT PRICE</th>
                                <th class="text-center">QUANTITY</th>
                                <th class="text-center">TOTAL</th>
                                <th class="text-center"><i class="ti-trash remove-icon"></i></th>
                            </tr>
                        </thead>
                        <tbody id="cart_item_list">

                            @if (count($carts) > 0)
                                @foreach ($carts as $key => $cart)
                                    <tr>
                                        @php
                                            $photo = explode(',', $cart->product['photo']);
                                        @endphp
                                        <td class="image" data-title="No"><img src="{{ $photo[0] }}"
                                                alt="{{ $photo[0] }}"></td>
                                        <td class="product-des" data-title="Description">
                                            <p class="product-name"><a
                                                    href="{{ route('product.detail', $cart->product['slug']) }}"
                                                    target="_blank">{{ $cart->product['title'] }}</a></p>
                                            <p class="product-des">{!! $cart['summary'] !!}</p>
                                        </td>
                                        <td class="price" data-title="Price">
                                            <span>Rp. {{ number_format($cart->product->price, 2) }}</span>
                                        </td>
                                        <td class="qty" data-title="Qty"><!-- Input Order -->
                                            <div class="input-group">
                                                <div class="button minus">
                                                    <button type="button" class="btn btn-primary btn-number"
                                                        data-type="minus" data-field="quant[{{ $key }}]"
                                                        onclick="decreaseQuantity({{ $cart->id }})">
                                                        <i class="ti-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="text" name="quant[{{ $key }}]" class="input-number"
                                                    data-min="1" data-max="100" value="{{ $cart->quantity }}">
                                                <input type="hidden" name="qty_id[]" value="{{ $cart->id }}">
                                                <div class="button plus">
                                                    <button type="button" class="btn btn-primary btn-number"
                                                        data-type="plus" data-field="quant[{{ $key }}]"
                                                        onclick="increaseQuantity({{ $cart->id }})">
                                                        <i class="ti-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <!--/ End Input Order -->
                                        </td>
                                        <td class="total-amount cart_single_price" data-title="Total">
                                            <span class="money">Rp.
                                                {{ number_format($cart->quantity * $cart->product->price - ($cart->quantity * $cart->product->price * $cart->product->discount) / 100, 2) }}</span>
                                        </td>

                                        <td class="action" data-title="Remove"><a href="javascript:void(0);"
                                                onclick="deleteCart({{ $cart->id }})"><i
                                                    class="ti-trash remove-icon"></i></a></td>
                                    </tr>
                                @endforeach
                                <track>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            @else
                                <tr>
                                    <td class="text-center">
                                        There are no any carts available. <a href="{{ route('product-grids') }}"
                                            style="color:blue;">Continue shopping</a>

                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                    <!--/ End Shopping Summery -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <!-- Total Amount -->
                    <div class="total-amount">
                        <div class="row">
                            <div class="col-lg-8 col-md-5 col-12">
                                <div class="left">
                                    <div class="coupon">
                                        <form action="{{ route('coupon.check') }}" method="POST">
                                            @csrf
                                            <input name="code" placeholder="Enter Your Coupon">
                                            <button class="btn">Apply</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-7 col-12">
                                <div class="right">
                                    <ul>
                                        <li class="order_subtotal" data-price="{{ totalCartPrice() }}">Cart
                                            Subtotal<span>Rp. {{ number_format(totalCartPrice(), 2) }}</span></li>

                                        @if (session()->has('coupon'))
                                            <li class="coupon_price" data-price="{{ Session::get('coupon')['value'] }}">You
                                                Save<span>${{ number_format(Session::get('coupon')['value'], 2) }}</span>
                                            </li>
                                        @endif
                                        @php
                                            $total_amount = totalCartPrice();
                                            if (session()->has('coupon')) {
                                                $total_amount = $total_amount - Session::get('coupon')['value'];
                                            }
                                        @endphp
                                        @if (session()->has('coupon'))
                                            <li class="last" id="order_total_price">You
                                                Pay<span>Rp. {{ number_format($total_amount, 2) }}</span></li>
                                        @else
                                            <li class="last" id="order_total_price">You
                                                Pay<span>Rp. {{ number_format($total_amount, 2) }}</span></li>
                                        @endif
                                    </ul>
                                    <div class="button5">
                                        <a href="{{ route('checkout') }}" class="btn">Checkout</a>
                                        <a href="{{ route('product-grids') }}" class="btn">Continue shopping</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ End Total Amount -->
                </div>
            </div>
        </div>
    </div>
    <!--/ End Shopping Cart -->

    <!-- Start Shop Services Area  -->
    <section class="shop-services section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-rocket"></i>
                        <h4>Free shiping</h4>
                        <p>Orders over $100</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-reload"></i>
                        <h4>Free Return</h4>
                        <p>Within 30 days returns</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-lock"></i>
                        <h4>Sucure Payment</h4>
                        <p>100% secure payment</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-tag"></i>
                        <h4>Best Peice</h4>
                        <p>Guaranteed price</p>
                    </div>
                    <!-- End Single Service -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Newsletter -->

@endsection
@push('styles')
    <style>
        li.shipping {
            display: inline-flex;
            width: 100%;
            font-size: 14px;
        }

        li.shipping .input-group-icon {
            width: 100%;
            margin-left: 10px;
        }

        .input-group-icon .icon {
            position: absolute;
            left: 20px;
            top: 0;
            line-height: 40px;
            z-index: 3;
        }

        .form-select {
            height: 30px;
            width: 100%;
        }

        .form-select .nice-select {
            border: none;
            border-radius: 0px;
            height: 40px;
            background: #f6f6f6 !important;
            padding-left: 45px;
            padding-right: 40px;
            width: 100%;
        }

        .list li {
            margin-bottom: 0 !important;
        }

        .list li:hover {
            background: #F7941D !important;
            color: white !important;
        }

        .form-select .nice-select::after {
            top: 14px;
        }
    </style>
@endpush
@push('scripts')
    <script src="{{ asset('frontend/js/nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("select.select2").select2();
        });
        $('select.nice-select').niceSelect();
    </script>
    <script>
        $(document).ready(function() {
            $('.shipping select[name=shipping]').change(function() {
                let cost = parseFloat($(this).find('option:selected').data('price')) || 0;
                let subtotal = parseFloat($('.order_subtotal').data('price'));
                let coupon = parseFloat($('.coupon_price').data('price')) || 0;
                // alert(coupon);
                $('#order_total_price span').text('$' + (subtotal + cost - coupon).toFixed(2));
            });
        });

        function decreaseQuantity(id) {
            var url = "{{ route('cart.decrease') }}";
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    cart_id: id
                },
                success: function(response) {
                    if (response.success == true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Opps!',
                            text: response.message,
                        })
                    }
                }
            });
        }

        function increaseQuantity(id) {
            var url = "{{ route('cart.increase') }}";
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    cart_id: id,
                },
                success: function(response) {
                    if (response.success == true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Opps!',
                            text: response.message,
                        })
                    }

                }
            });
        }
    </script>
@endpush
