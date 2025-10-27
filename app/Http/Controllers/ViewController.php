<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Slider;
use App\Models\Contact;
use App\Models\About;
use App\Models\Order;
use App\Models\user_message;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;

class ViewController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function display_home()
    {
        $product_count = Product::count();
        $orders_count = Order::count();
        $users_count = User::count();
        $users_msg_count = user_message::count();
        $offers_count = Offer::count();
        $categories_count = Category::count();
        return view('admin.home', compact('product_count', 'orders_count', 'users_count', 'users_msg_count', 'offers_count', 'categories_count'));
    }

    public function display_products()
    {
        $products = Product::all();
        return view('admin.admin_products', compact('products'));
    }

    public function show_add_product_form()
    {
        $categories = Category::all();
        return view('admin.add_product', compact('categories'));
    }

    public function display_view_product($id)
    {
        $p = Product::find($id);
        return view('admin.view_product', compact('p'));
    }

    public function show_edit_product_form($id)
    {
        $p = Product::find($id);
        $categories = Category::all();
        return view('admin.edit_product', compact('p', 'categories'));
    }

    public function display_users()
    {

        $users_data = User::all();
        return view('admin.admin_users', compact('users_data'));
    }

    public function show_add_user_form()
    {
        return view('admin.add_user');
    }

    public function show_edit_user_form($uid)
    {
        $u  = User::find($uid);
        return view('admin.edit_user', compact('u'));
    }

    public function display_categories()
    {
        $categories = Category::all();
        return view('admin.admin_categories', compact('categories'));
    }

    public function display_offers()
    {
        $offers = Offer::all();
        return view('admin.admin_offers', compact('offers'));
    }

    public function display_orders()
    {
        $orders = \App\Models\Order::with(['orderItems', 'user'])->orderBy('created_at', 'desc')->get();
        return view('admin.admin_orders', compact('orders'));
    }

    public function display_inquires()
    {
        $u_messages = user_message::all();
        return view('admin.admin_inquires', compact('u_messages'));
    }

    public function display_profile()
    {
        $u = User::find(Session::get('user_id'));
        return view('admin.admin_profile', compact('u'));
    }

    public function show_add_category_form()
    {
        return view('admin.add_category');
    }
    public function show_edit_category_form($id)
    {
        $c = Category::find($id);
        return view('admin.edit_category', compact('c'));
    }

    public function show_add_offer_form()
    {
        return view('admin.add_offer');
    }
    public function show_edit_offer_form($id)
    {
        $offer = Offer::findOrFail($id);
        return view('admin.edit_offer', compact('offer'));
    }
    public function show_add_order_form()
    {
        return view('admin.add_order');
    }
    public function show_edit_order_form($id)
    {
        $order = \App\Models\Order::with('orderItems')->findOrFail($id);
        return view('admin.edit_order', compact('order'));
    }

    public function display_view_order($id)
    {
        $order = \App\Models\Order::with('orderItems')->findOrFail($id);
        return view('admin.view_order', compact('order'));
    }

    public function show_add_inquiry_form()
    {
        return view('admin.add_inquiry');
    }
    public function show_edit_inquiry_form()
    {
        return view('admin.edit_inquiry');
    }
    public function show_add_profile_form()
    {
        return view('admin.add_profile');
    }
    public function show_edit_profile_form()
    {
        $u = User::find(Session::get('user_id'));
        return view('admin.edit_profile', compact('u'));
    }

    public function show_change_password_form()
    {
        return view('admin.change_password');
    }

    public function display_view_inquiry($id)
    {
        $u_msg = user_message::find($id);
        return view('admin.view_inquiry', compact('u_msg'));
    }

    public function display_view_user($id)
    {
        $user = User::find($id);
        return view('admin.view_user', compact('user'));
    }

    public function display_reply_inquiry($id)
    {
        $u_msg = user_message::find($id);
        return view('admin.reply_inquiry', compact("u_msg"));
    }

    public function display_slider_settings()
    {
        $sliders = Slider::all();
        return view('admin.slider_settings', compact('sliders'));
    }

    public function display_about_settings()
    {
        $about = About::first();
        if (!$about) {
            $about = About::create([
                'title' => 'About NeoWear',
                'description' => 'NeoWear is a leading fashion brand offering the latest trends in wearable technology and style.'
            ]);
        }
        $about_links = \App\Models\AboutLink::all();
        return view('admin.about_settings', compact('about', 'about_links'));
    }

    public function display_contact_settings()
    {
        $contact = Contact::first();
        if (!$contact) {
            // Create default contact record if none exists
            $contact = Contact::create([
                'email' => 'contact@neowear.com',
                'consulting_phone' => '+91 8242 494 214',
                'report_phone' => '+91 8242 494 214',
                'address' => 'Rk University, Bhavnager Road, Rajkot - 360001'
            ]);
        }
        return view('admin.contact_settings', compact('contact'));
    }

    public function show_add_slider_form()
    {
        return view('admin.add_slider');
    }

    public function show_edit_slider_form($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.edit_slider', compact('slider'));
    }
}
