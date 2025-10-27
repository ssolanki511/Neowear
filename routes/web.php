<?php

use App\Http\Controllers\FormDataController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\GuestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('guest.index');
// });
Route::get('/',[GuestController::class,'indexView']);
Route::get('/index',[GuestController::class, 'indexView'])->name('guest.home');
Route::get('/signup', [GuestController::class, 'signUpView'])->name('guest.signup');
Route::get('/signin', [GuestController::class, 'signInView'])->name('guest.signin');
Route::get('/forgot_password', [GuestController::class, 'forgotPasswordView'])->name('guest.forgot_password');
Route::get('/otp', [GuestController::class, 'OTPView'])->name('guest.otp');
Route::get('/reset_password', [GuestController::class, 'resetPasswordView'])->name('guest.reset_password');
Route::get('/product/{p_id}', [GuestController::class, 'productView'])->name('guest.product');
Route::get('/search', [GuestController::class, 'searchView'])->name('guest.search');
Route::get('/contact', [GuestController::class, 'contactView'])->name('guest.contact');

Route::post('/signUpSubmit', [GuestController::class, 'signUpSubmit'])->name('guest.signUpSubmit');
Route::post('/signInSubmit', [GuestController::class, 'signInSubmit'])->name('guest.signInSubmit');
Route::post('/fogotPasswordSubmit', [GuestController::class, 'fogotPasswordSubmit'])->name('guest.fogotPasswordSubmit');
Route::post('/OTPSubmit', [GuestController::class, 'OTPSubmit'])->name('OTPSubmit');
Route::post('/resetPasswordSubmit', [GuestController::class, 'resetPasswordSubmit'])->name('resetPasswordSubmit');
Route::post('/contactSubmit', [GuestController::class, 'ContactSubmit'])->name('guest.ContactSubmit');

Route::get('/logout', [GuestController::class, 'logout'])->name('logout');
Route::get('/send_dynamic_mail/{token}/{email}', [GuestController::class, 'send_dynamic_mail']);

Route::get('/search-products', [GuestController::class, 'productSearch'])->name('member.productSearch');

// Admin routes
Route::middleware(['admin'])->group(function () {
    Route::get('/home', [ViewController::class, 'display_home'])->name('home');
    Route::get('/admin_categories', [ViewController::class, 'display_categories'])->name('categories');
    Route::get('/admin_orders', [ViewController::class, 'display_orders'])->name('orders');
    Route::get('/admin_inquires', [ViewController::class, 'display_inquires'])->name('inquires');
    Route::get('/admin_profile', [ViewController::class, 'display_profile'])->name('profile');
    Route::get('/admin_offers', [ViewController::class, 'display_offers'])->name('offers');
    Route::get('/admin_users', [ViewController::class, 'display_users'])->name('users');
    Route::get('/admin_products', [ViewController::class, 'display_products'])->name('products');

    // Route::get('send_static_mail',[GuestController::class,'send_static_mail'])->name('send_static_mail');
    
    Route::get('/add_user', [ViewController::class, 'show_add_user_form'])->name('add_user_form');
    Route::get('/edit_user/{id}', [ViewController::class, 'show_edit_user_form'])->name('edit_user_form');
    Route::get('/remove_user/{id}', [FormDataController::class, 'remove_user'])->name('remove_user');
    Route::get('/add_product', [ViewController::class, 'show_add_product_form'])->name('add_product_form');
    Route::get('/edit_product/{id}', [ViewController::class, 'show_edit_product_form'])->name('edit_product_form');
    Route::get('/add_category', [ViewController::class, 'show_add_category_form'])->name('add_category_form');
    Route::get('/edit_category/{id}', [ViewController::class, 'show_edit_category_form'])->name('edit_category_form');
    Route::get('/remove_category/{id}', [FormDataController::class, 'remove_category'])->name('remove_category');
    Route::get('/add_offer', [ViewController::class, 'show_add_offer_form'])->name('add_offer_form');
    Route::get('/edit_offer/{id}', [ViewController::class, 'show_edit_offer_form'])->name('edit_offer_form');
    Route::get('/add_order', [ViewController::class, 'show_add_order_form'])->name('add_order_form');
    Route::get('/edit_order/{id}', [ViewController::class, 'show_edit_order_form'])->name('edit_order_form');
    Route::get('/view_order/{id}', [ViewController::class, 'display_view_order'])->name('view_order');
    Route::get('/add_profile', [ViewController::class, 'show_add_profile_form'])->name('add_profile_form');
    Route::get('/edit_profile', [ViewController::class, 'show_edit_profile_form'])->name('edit_profile_form');
    Route::get('/change_password', [ViewController::class, 'show_change_password_form'])->name('change_password_form');
    Route::get('/add_inquiry', [ViewController::class, 'show_add_inquiry_form'])->name('add_inquiry_form');
    Route::get('/edit_inquiry', [ViewController::class, 'show_edit_inquiry_form'])->name('edit_inquiry_form');
    Route::get('/view_inquiry/{id}', [ViewController::class, 'display_view_inquiry'])->name('view_inquiry');
    Route::get('/reply_inquiry/{id}', [ViewController::class, 'display_reply_inquiry'])->name('reply_inquiry');
    Route::get('/remove_inquiry/{id}', [FormDataController::class, 'remove_inquiry'])->name('remove_inquiry');
    Route::post('/change_password', [FormDataController::class, 'change_password'])->name('change_password');


    Route::get('/view_product/{id}', [ViewController::class, 'display_view_product'])->name('view_product');
    Route::post('/add_product', [FormDataController::class, 'add_product'])->name('add_product');
    Route::post('/edit_product', [FormDataController::class, 'edit_product_submit'])->name('edit_product');
    Route::post('/add_user', [FormDataController::class, 'add_user'])->name('add_user');
    Route::post('/edit_user', [FormDataController::class, 'edit_user'])->name('edit_user');
    Route::post('/add_category', [FormDataController::class, 'add_category'])->name('add_category');
    Route::post('/edit_category', [FormDataController::class, 'edit_category'])->name('edit_category');
    Route::post('/add_offer', [FormDataController::class, 'add_offer'])->name('add_offer');
    Route::get('/edit_offer/{id}', [ViewController::class, 'show_edit_offer_form'])->name('edit_offer_form');
    Route::post('/edit_offer', [FormDataController::class, 'edit_offer'])->name('edit_offer');
    Route::post('/add_order', [FormDataController::class, 'add_order'])->name('add_order');
    Route::post('/edit_order', [FormDataController::class, 'edit_order'])->name('edit_order');
    Route::post('/add_inquiry', [FormDataController::class, 'add_inquiry'])->name('add_inquiry');
    Route::post('/edit_inquiry', [FormDataController::class, 'edit_inquiry'])->name('edit_inquiry');
    Route::post('/add_profile', [FormDataController::class, 'add_profile'])->name('add_profile');
    Route::post('/edit_profile', [FormDataController::class, 'edit_profile'])->name('edit_profile');
    Route::post('/reply_inquiry', [FormDataController::class, 'reply_inquiry'])->name('reply_inquiry');
    Route::get('/admin/sliders', [ViewController::class, 'display_slider_settings'])->name('admin.sliders');
    Route::post('/admin/sliders', [FormDataController::class, 'add_slider'])->name('admin.sliders.store');
    Route::delete('/admin/sliders/{id}/delete', [FormDataController::class, 'delete_slider'])->name('admin.sliders.delete');
    Route::get('/admin/about', [ViewController::class, 'display_about_settings'])->name('admin.about');
    Route::post('/admin/about', [FormDataController::class, 'update_about_settings'])->name('admin.about.update');
    Route::get('/admin/contact', [ViewController::class, 'display_contact_settings'])->name('admin.contact');
    Route::post('/admin/contact', [FormDataController::class, 'update_contact_settings'])->name('admin.contact.update');
    Route::get('/add_slider', [ViewController::class, 'show_add_slider_form'])->name('add_slider_form');
    Route::post('/add_slider', [FormDataController::class, 'add_slider'])->name('add_slider');
    Route::get('/edit_slider/{id}', [ViewController::class, 'show_edit_slider_form'])->name('edit_slider_form');
    Route::put('/edit_slider/{id}', [FormDataController::class, 'edit_slider'])->name('edit_slider');

    Route::delete('/delete_product/{id}', [FormDataController::class, 'delete_product'])->name('delete_product');
    Route::delete('/delete_offer/{id}', [FormDataController::class, 'delete_offer'])->name('delete_offer');
    Route::get('/view_user/{id}', [ViewController::class, 'display_view_user'])->name('view_user');
});

// Normal user routes
Route::middleware(['normal'])->group(function () {
    Route::get('/profile', [MemberController::class, 'profileView'])->name('member.profile');
    Route::get('/cart', [MemberController::class, 'cartView'])->name('member.cart');
    Route::get('/wishlist', [MemberController::class, 'wishlistView'])->name('member.wishlist');
    Route::get('/saveAddress', [MemberController::class, 'saveAddressView'])->name('member.saveAddress');
    Route::get('/product/review/{p_id}', [MemberController::class, 'reviewFormView'])->name('member.reviewFormView');
    Route::get('/changePassword', [MemberController::class, 'changePasswordView'])->name('member.changePassword');
    
    Route::get('/payment', [MemberController::class, 'paymentView'])->name('member.paymentView');
    Route::get('/submitCoupen', [MemberController::class, 'submitCoupen'])->name('member.submitCoupen');
    Route::get('/purchase', [MemberController::class, 'purchaseView']);
    Route::get('/editProfile',[MemberController::class, 'editProfile'])->name('member.editProfile');

    Route::post('/updateCartQuantity', [MemberController::class, 'updateQuantity'])->name('cart.updateQuantity');
    Route::post('/addToCart', [MemberController::class, 'submitAddToCart'])->name('member.submitAddToCart');
    Route::get('/addToCartFromWishlist/{p_id}', [MemberController::class, 'addToCartFromWishlist'])->name('member.addToCartFromWishlist');
    Route::get('/removeFromWishlist/{p_id}', [MemberController::class, 'removeFromWishlist'])->name('member.removeFromWishlist');
    Route::get('/removeFromCart/{p_id}', [MemberController::class, 'removeFromCart'])->name('member.removeFromCart');
    Route::get('/addToWishlist/{p_id}', [MemberController::class, 'addToWishlist'])->name('member.addToWishlist');
    Route::get('/cancelOrder/{o_id}', [MemberController::class, 'cancelOrder'])->name('member.addToWishlist');
    

    // Route::post('/profile', [MemberController::class, 'editProfile']);
    Route::post('/purchase', [MemberController::class, 'paymentSubmit'])->name('member.paymentSubmit');
    Route::post('/reviewSubmit', [MemberController::class, 'reviewSubmit'])->name('member.reviewSubmit');
    Route::post('/savedAddressProfile', [MemberController::class, 'addressSubmit'])->name('member.addressSubmit');
    Route::post('/imageUpdate', [MemberController::class, 'ImageUpdateSumbit'])->name('member.ImageUpdateSumbit');
    Route::post('/changePasswordProfile', [MemberController::class, 'changePasswordSubmit'])->name('member.changePasswordSubmit');
    Route::post('/editProfileSubmit', [MemberController::class, 'editProfileSubmit'])->name('member.editProfileSubmit');

    Route::post('/purchaseSubmit', [MemberController::class, 'purchaseSubmit'])->name('member.purchaseSubmit');

    Route::get('/saveAddress/{id}', [MemberController::class, 'deleteAddress'])->name('member.deleteAddress');
    Route::get('/saveAddress/{id}/edit', [MemberController::class, 'saveAddressEditView'])->name('member.saveAddressEditView');

    Route::post('/applyCoupon', [MemberController::class, 'submitApplyCoupon'])->name('member.submitApplyCoupon');
    Route::get('razorpay', [MemberController::class, 'razorpay'])->name('member.razorpay');
    Route::post('razorpay/callback', [MemberController::class, 'razorpayCallback'])->name('member.razorpayCallback');

    Route::get('/search-orders', [MemberController::class, 'orderSearch'])->name('member.searchOrders');
    Route::post('/get-size-quantity', [MemberController::class, 'getSizeQuantity']);
});