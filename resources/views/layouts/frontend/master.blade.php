<!DOCTYPE html>
<html lang="zxx">

<head>
    @include('layouts.frontend.head')
</head>

<body class="js">

    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- End Preloader -->

    @include('layouts.frontend.notification')
    <!-- Header -->
    @include('layouts.frontend.header')
    <!--/ End Header -->
    @yield('main-content')

    @include('layouts.frontend.footer')


    <!-- Jquery -->
    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery-migrate-3.0.0.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery-ui.min.js') }}"></script>
    <!-- Popper JS -->
    <script src="{{ asset('frontend/js/popper.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <!-- Color JS -->
    <script src="{{ asset('frontend/js/colors.js') }}"></script>
    <!-- Slicknav JS -->
    <script src="{{ asset('frontend/js/slicknav.min.js') }}"></script>
    <!-- Owl Carousel JS -->
    <script src="{{ asset('frontend/js/owl-carousel.js') }}"></script>
    <!-- Magnific Popup JS -->
    <script src="{{ asset('frontend/js/magnific-popup.js') }}"></script>
    <!-- Waypoints JS -->
    <script src="{{ asset('frontend/js/waypoints.min.js') }}"></script>
    <!-- Countdown JS -->
    <script src="{{ asset('frontend/js/finalcountdown.min.js') }}"></script>
    <!-- Nice Select JS -->
    <script src="{{ asset('frontend/js/nicesellect.js') }}"></script>
    <!-- Flex Slider JS -->
    <script src="{{ asset('frontend/js/flex-slider.js') }}"></script>
    <!-- ScrollUp JS -->
    <script src="{{ asset('frontend/js/scrollup.js') }}"></script>
    <!-- Onepage Nav JS -->
    <script src="{{ asset('frontend/js/onepage-nav.min.js') }}"></script>
    {{-- Isotope --}}
    <script src="{{ asset('frontend/js/isotope/isotope.pkgd.min.js') }}"></script>
    <!-- Easing JS -->
    <script src="{{ asset('frontend/js/easing.js') }}"></script>

    <!-- Active JS -->
    <script src="{{ asset('frontend/js/active.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function addToCart(id) {
            var url = "{{ route('cart.store') }}";
            var qty = $('.qty').val();
            if (qty == null) {
                qty = 1;
            }
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: id,
                    qty: qty,
                },
                success: function(response) {
                    if (response.success == true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            showConfirmButton: false,
                            timer: 1500
                        })
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


        function deleteCart(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this product from cart!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',

                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteProduct(id);
                }
            })
        }

        function deleteProduct(id) {
            var url = "{{ route('cart.delete') }}";
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    cart_id: id,
                },
                success: function(response) {
                    if (response.success == true) {
                        swal("Good job!", response.message, "success", {
                            button: "OK",
                        });
                        location.reload();
                    } else {
                        swal("Opps!", response.message, "error", {
                            button: "OK",
                        });
                    }

                }
            });
        }

        function addWishList(id) {
            var url = "{{ route('wishlist.store') }}";
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: id,
                },
                success: function(response) {
                    if (response.success == true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            showConfirmButton: false,
                            timer: 1500
                        })
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
    @stack('scripts')
    <script>
        setTimeout(function() {
            $('.alert').slideUp();
        }, 5000);
        $(function() {
            // ------------------------------------------------------- //
            // Multi Level dropdowns
            // ------------------------------------------------------ //
            $("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
                event.preventDefault();
                event.stopPropagation();

                $(this).siblings().toggleClass("show");


                if (!$(this).next().hasClass('show')) {
                    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
                }
                $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
                    $('.dropdown-submenu .show').removeClass("show");
                });

            });
        });
    </script>


</body>

</html>
