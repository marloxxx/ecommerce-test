<?php

use App\Models\Cart;
use App\Models\Order;
use App\Models\Message;
use App\Models\Category;
use App\Models\Shipping;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

if (!function_exists('getAllCategory')) {
    function getAllCategory()
    {
        $category = new Category();
        $menu = $category->getAllParentWithChild();
        return $menu;
    }
}

if (!function_exists('getHeaderCategory')) {
    function getHeaderCategory()
    {
        $category = new Category();
        $menu = $category->getAllParentWithChild();

        if ($menu) {
?>

            <li>
                <a href="javascript:void(0);">Category<i class="ti-angle-down"></i></a>
                <ul class="dropdown border-0 shadow">
                    <?php
                    foreach ($menu as $cat_info) {
                        if ($cat_info->child_cat->count() > 0) {
                    ?>
                            <li><a href="<?php echo route('product-cat', $cat_info->slug); ?>"><?php echo $cat_info->title; ?></a>
                                <ul class="dropdown sub-dropdown border-0 shadow">
                                    <?php
                                    foreach ($cat_info->child_cat as $sub_menu) {
                                    ?>
                                        <li><a href="<?php echo route('product-sub-cat', [$cat_info->slug, $sub_menu->slug]); ?>"><?php echo $sub_menu->title; ?></a></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                        <?php
                        } else {
                        ?>
                            <li><a href="<?php echo route('product-cat', $cat_info->slug); ?>"><?php echo $cat_info->title; ?></a></li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </li>
<?php
        }
    }
}


if (!function_exists('productCategoryList')) {
    function productCategoryList($option = 'all')
    {
        if ($option = 'all') {
            return Category::latest()->get();
        }
        return Category::has('products')->latest()->get();
    }
}

if (!function_exists('cartCount')) {
    function cartCount()
    {
        if (Auth::check()) {
            $user_id = auth()->user()->id;
            return Cart::where('user_id', $user_id)->where('order_id', null)->sum('quantity');
        } else {
            return 0;
        }
    }
}

if (!function_exists('getAllProductFromCart')) {
    function getAllProductFromCart($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Cart::with('product')->where('user_id', $user_id)->get();
        } else {
            return 0;
        }
    }
}

if (!function_exists('totalCartPrice')) {
    function totalCartPrice($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Cart::totalCarts();
        } else {
            return 0;
        }
    }
}

if (!function_exists('wishlistCount')) {
    function wishlistCount($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Wishlist::where('user_id', $user_id)->sum('quantity');
        } else {
            return 0;
        }
    }
}

if (!function_exists('getAllProductFromWishlist')) {
    function getAllProductFromWishlist($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Wishlist::with('product')->where('user_id', $user_id)->get();
        } else {
            return 0;
        }
    }
}

if (!function_exists('totalWishlistPrice')) {
    function totalWishlistPrice($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Wishlist::totalWishlist();
        } else {
            return 0;
        }
    }
}

if (!function_exists('earningPerMonth')) {
    function earningPerMonth()
    {
        $month_data = Order::where('status', 'delivered')->get();
        // return $month_data;
        $price = 0;
        foreach ($month_data as $data) {
            $price = $data->cart_info->sum('price');
        }
        return number_format((float)($price), 2, '.', '');
    }
}

?>