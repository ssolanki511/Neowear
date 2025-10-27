<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Hash;
use \App\Models\Wishlist;
use \App\Models\add_to_cart;
use \App\Models\Product;
use \App\Models\user_address;
use \App\Models\review;
use \App\Models\Order;
use \App\Models\Order_Items;
use \App\Models\apply_coupen;
use App\Models\Offer;
use Illuminate\Support\Facades\Log;
use Exception;

class MemberController extends BaseController
{
    // view
    
    public function profileView(){
        $userId = session('user_id');
        $user = User::find($userId);
        $addresses = user_address::all()->where('u_id', $userId);

        $order_history = Order::with('orderItems')->where('u_id', $userId)->orderBy('created_at', 'desc')->get();
        return view('member.profile', compact('user', 'addresses', 'order_history'));
    }
    public function cartView(){
        $userId = session('user_id');
        $cartItems = add_to_cart::with('product')->where('u_id', $userId)->get();

        $user_addresses = user_address::where('u_id', $userId)->get();
        return view('member.cart', compact('cartItems', 'user_addresses'));
    }
    public function wishlistView(){
        $userId = session('user_id');
        $wishlists = Wishlist::where('u_id', $userId)->get();
        $productIds = $wishlists->pluck('p_id')->toArray();
        $products = Product::whereIn('id', $productIds)->get();

        return view('member.wishlist', compact('products'));
    }
    public function saveAddressView(){
        return view('member.savedAddress');
    }
    public function reviewFormView($p_id){
        $hasBought = DB::table('orders')
        ->join('order__items', 'orders.id', '=', 'order__items.order_id')
        ->where('orders.u_id', Session::get('user_id'))
        ->where('order__items.product_id', $p_id)
        ->where('orders.o_status', 'Completed')
        ->exists();

        if (!$hasBought) {
        return redirect()->route('guest.product', ['p_id' => $p_id])->with('error', 'You must buy and order must be completed to review it.');
        }

        $exist_review = review::where('p_id', $p_id)->where('u_id', session('user_id'))->first();
        if($exist_review){
            return redirect()->route('guest.product', ['p_id' => $p_id])->with('error', 'You already give review of this product.');
        }

        $product = Product::where('id', $p_id)->first();
        if(!$product){
            return redirect()->route('guest.home')->with('error', 'Product not found!');
        }
        return view('member.reviewForm', compact('product'));
    }
    public function changePasswordView(){
        return view('member.changePassword');
    }
    public function paymentView(){
        return view('member.payment');
    }
    public function editProfile(){
        $userID = session('user_id');
        $user = User::where('id', $userID)->first();
        return view('member.editProfile', compact('user'));
    }
    public function purchaseView(){
        return view('member.payment');
    }

    // cart and wishlist
    public function submitAddToCart(Request $formData){
        $userId = session('user_id');
        $productId = $formData->p_id;
        $productSize = $formData->size;
        $productQuantity = $formData->quantity;
        $existingCartItem = add_to_cart::where('u_id', $userId)->where('p_id', $productId)->where('p_size', $productSize)->first();

        if ($existingCartItem) {
            return redirect()->back()->with('error', 'Product already in cart.');
        } else {
            // If the product is not in the cart, create a new cart item
            $cartItem = new add_to_cart();
            $cartItem->u_id = $userId;
            $cartItem->p_id = $productId;
            $cartItem->p_size = $productSize;
            $cartItem->p_quantity = $productQuantity;
            $cartItem->save();
        }

        return redirect()->route('member.cart')->with('success', 'Product added to cart successfully.');
    }
    public function addToCartFromWishlist($p_id){
        $userId = Session::get('user_id');
        $product = Product::find($p_id);

        if (!$product) {
            return back()->with('error', 'Product not found');
        }
        $sizeQuantities = json_decode($product->p_size_quatity, true);

        $size = null;
        foreach ($sizeQuantities as $availableSize => $availableQuantity) {
            if ($availableQuantity > 0) {
                $size = $availableSize; // Select the first size with available stock
                $quantity = 1; // Default to 1 quantity for the selected size
                break; // Exit loop after finding the first available size
            }
        }

        if (!$size) {
            return back()->with('error', 'No available sizes in stock');
        }

        // 5. Check if the product already exists in the cart for the user
        $existingCartItem = add_to_cart::where('u_id', $userId)
                                    ->where('p_id', $p_id)
                                    ->where('p_size', $size) // Add size condition as well
                                    ->first();

        if ($existingCartItem) {
            return back()->with('error', 'Item is already is cart.');
        }

        // 6. Add the product to the cart
        $cartItem = new add_to_cart();
        $cartItem->u_id = $userId; // Logged-in user ID
        $cartItem->p_id = $p_id;   // Product ID
        $cartItem->p_size = $size;   // Product size
        $cartItem->p_quantity = $quantity; // Quantity is 1 for the first available size

        // Save the new cart item
        $cartItem->save();

        $wishlistItem = Wishlist::where('u_id', $userId)->where('p_id', $p_id)->first();
        if ($wishlistItem) {
            $wishlistItem->delete(); // Remove the item from the wishlist
        }

        return redirect()->route('member.cart')->with('success', 'Item added to cart');
    }
    public function removeFromCart($p_id){
        $userId = session('user_id');
        $cartItem = add_to_cart::where('u_id', $userId)->where('id', $p_id)->first();

        if ($cartItem) {
            $cartItem->delete();
            return redirect()->back()->with('success', 'Product removed from cart.');
        } else {
            return redirect()->back()->with('error', 'Product not found in cart.');
        }
    }
    public function removeFromWishlist($p_id){
        $userId = session('user_id');
        $wishlistItem = Wishlist::where('u_id', $userId)->where('p_id', $p_id)->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            return redirect()->back()->with('success', 'Product removed from wishlist.');
        } else {
            return redirect()->back()->with('error', 'Product not found in wishlist.');
        }
    }
    public function addToWishlist($p_id){
        $userId = session('user_id');
        $existingWishlistItem = Wishlist::where('u_id', $userId)->where('p_id', $p_id)->first();

        if ($existingWishlistItem) {
            // Remove from wishlist (toggle off)
            $existingWishlistItem->delete();
            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist',
                'product_id' => $p_id,
                'toggled' => false
            ]);
        } else {
            // Add to wishlist (toggle on)
            $wishlistItem = new Wishlist();
            $wishlistItem->u_id = $userId;
            $wishlistItem->p_id = $p_id;
            $wishlistItem->save();

            return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist',
            'product_id' => $p_id,
            'toggled' => true
            ]);
        }
    }
    public function getSizeQuantity(Request $request){
        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json(['max_quantity' => 0]);
        }

        $sizes = json_decode($product->p_size_quatity, true);
        $size = $request->size;
        $maxQuantity = isset($sizes[$size]) ? (int) $sizes[$size] : 0;

        return response()->json(['max_quantity' => $maxQuantity]);
    }
    public function updateQuantity(Request $request)
    {
        $cartItem = add_to_cart::find($request->cart_item_id);

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'Cart item not found.'], 404);
        }

        $product = $cartItem->product;

        // Decode JSON like: { "M": 3, "L": 2 }
        $sizeQuantities = json_decode($product->p_size_quatity, true);

        // Get selected size from cart item
        $selectedSize = $cartItem->p_size;

        // Check if the requested quantity exceeds available stock
        if (!isset($sizeQuantities[$selectedSize])) {
            return response()->json(['success' => false, 'message' => 'Invalid size selected.'], 400);
        }

        $availableQuantity = $sizeQuantities[$selectedSize];

        if ($request->quantity > $availableQuantity) {
            return response()->json([
                'success' => false,
                'message' => "Only {$availableQuantity} item(s) available for size {$selectedSize}."
            ]);
        }

        // Save new quantity
        $cartItem->p_quantity = $request->quantity;
        $cartItem->save();

        // Recalculate totals
        $discountedPrice = floor($product->p_price - ($product->p_price * $product->p_offer / 100));
        $itemSubtotal = $discountedPrice * $cartItem->p_quantity;

        $cartItems = add_to_cart::where('u_id', Session::get('user_id'))->get();
        $subtotal = 0;

        foreach ($cartItems as $item) {
            $price = floor($item->product->p_price - ($item->product->p_price * $item->product->p_offer / 100));
            $subtotal += $price * $item->p_quantity;
        }

        $shipping = 0;
        $tax = floor($subtotal * 0.18);
        $total = $subtotal + $shipping + $tax;

        return response()->json([
            'success' => true,
            'item_subtotal' => $itemSubtotal,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total
        ]);
    }

    // payment gateway
    public function purchaseSubmit(Request $formData){
        $formData->validate([
            'address' => 'required',
        ],[
            'address.required' => 'Please choose your delivery address.',
        ]);
        $total_bill = $formData->total_price;
        $userId = session('user_id');
        $cartProducts = add_to_cart::with('product')->where('u_id', $userId)->get();

        if(Session::has('apply_coupen') and Session::has('apply_coupen_id')){
            Session::forget('apply_coupen');
            Session::forget('apply_coupen_id');
        }
        
        Session::put('total_bill', $total_bill);
        Session::put('cartProducts', $cartProducts);
        Session::put('addressID', $formData->address);
        return redirect()->route('member.paymentView');
    }
    public function paymentSubmit(Request $formData){
        $formData->validate([
            'name' => 'required|string|min:2|max:30',
            'email' => 'required|email',
            'pnumber' => 'required|size:10',
            'paymode' => 'required',
        ],[
            'name.required' => 'Full name is required.',
            'name.string' => 'Full name must be a valid string.',
            'name.min' => 'Full name must be at least 2 characters.',
            'name.max' => 'Full name cannot exceed 30 characters.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'pnumber.required' => 'Phone number is required.',
            'pnumber.size' => 'Phone number must be exactly 10 digits.',
            'paymode.required' => 'Please select a payment mode.'
        ]);

        $prefix = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3));
        $lastOrder = Order::latest('id')->first();
        $nextNumber = $lastOrder ? $lastOrder->id + 1 : 1;
        $uniqueOrderId = $prefix . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // order from cod
        if($formData->paymode === 'cod') {
            $order = new Order();
            $order['o_id'] = $uniqueOrderId;
            $order['u_id'] = session('user_id');

            $userAddress = user_address::where('id', session('addressID'))->first();
            $customeAddress = $userAddress->street . ', ' . $userAddress->city . ', ' . $userAddress->state . ' - ' . $userAddress->pin;

            $order['o_address'] = $customeAddress;
            $order['u_name'] = $formData->name;
            $order['o_status'] = 'Pending';
            $order['total_amount'] = Session::get('total_bill');
            $order['o_phone_number'] = $formData->pnumber;
            $order['o_payment_method'] = $formData->paymode;

            $cartProducts = session('cartProducts');
            $allItemsSaved = true;

            // Save order first to get $order->id
            $order->save();

            foreach($cartProducts as $item){
                $order_items = new Order_Items();
                $order_items['order_id'] = $order->id;
                $order_items['product_id'] = $item->product->id;
                $order_items['quantity'] = $item->p_quantity;
                $order_items['size'] = $item->p_size;
                $order_items['product_name'] = $item->product->p_name;
                $order_items['product_image'] = $item->product->p_image;
                $order_items['price'] = $item->product->p_price;

                $product = $item->product;
                $sizeQuantities = json_decode($product->p_size_quatity, true); // Decode JSON into an array

                if(isset($sizeQuantities[$item->p_size])) {
                    // Reduce the quantity for the specific size
                    $sizeQuantities[$item->p_size] -= $item->p_quantity;

                    // If the quantity goes negative, set it to 0 to avoid invalid values
                    if ($sizeQuantities[$item->p_size] < 0) {
                        $sizeQuantities[$item->p_size] = 0;
                    }

                    // Update the product's size quantity in the database
                    $product->p_size_quatity = json_encode($sizeQuantities); // Encode array back to JSON
                    $product->save();
                }

                if (!$order_items->save()) {
                    $allItemsSaved = false;
                    break;
                }
            }

            if (!$allItemsSaved) {
                // If any order item fails, delete the order and show error
                $order->delete();
                return back()->with('error', 'Order failed. Please try again.');
            }

            if(Session::has('apply_coupen') and Session::has('apply_coupen_id')){
                $coupenUser = new apply_coupen();
                $coupenUser['u_id'] = Session::get('user_id');
                $coupenUser['coupen_id'] = Session::get('apply_coupen_id');
                $coupenUser->save();
            }

            add_to_cart::where('u_id', Session::get('user_id'))->delete();

            session()->forget(['total_bill', 'cartProducts', 'addressID', 'apply_coupen', 'apply_coupen_id']);
            return redirect()->route('member.profile')->with('success', 'Order placed successfully!');
        }else{
            // Convert total bill to paise (smallest currency unit)
            $amountInPaise = Session::get('total_bill') * 100;
            $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
            $orderData = [
                'receipt'         => "order_". rand(1000,9999),
                'amount'          => $amountInPaise, // amount in the smallest currency unit
                'currency'        => 'INR',
                'payment_capture' => 1,
            ];
            $order = $api->order->create($orderData); // <-- Razorpay-generated order
            $razorpayOrderId = $order['id'];

            $paymentData = [
                'name' => $formData->name,
                'email' => $formData->email,
                'pnumber' => $formData->pnumber,
                'paymode' => $formData->paymode,
            ];
            Session::put('paymentFormData', $paymentData);
            Session::put('uniqueOrderId', $uniqueOrderId);
            return view('member.paymentProcess', compact('uniqueOrderId', 'razorpayOrderId', 'paymentData', 'amountInPaise'));
        }
    }
    public function razorpayCallback(Request $request){

        $payID = $request->input('razorpay_payment_id');
        $orderID = $request->input('razorpay_order_id');
        $signature = $request->input('razorpay_signature');

        if (!$payID || !$orderID || !$signature) {
            return redirect()->route('member.profile')->with('error', 'Invalid payment data received.');
        }

        $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));

        try {
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $orderID,
                'razorpay_payment_id' => $payID,
                'razorpay_signature' => $signature
            ]);
        } catch (Exception $e) {
            return redirect()->route('member.profile')->with('error', 'Payment verification failed. Please try again.');
        }

        // order for razorpay
        $paymentData = Session::get('paymentFormData');
        $userAddress = user_address::where('id', session('addressID'))->first();

        if (!$userAddress || !$paymentData || !session('cartProducts')) {
            return redirect()->route('member.profile')->with('error', 'Session expired or invalid data.');
        }

        $customeAddress = $userAddress->street . ', ' . $userAddress->city . ', ' . $userAddress->state . ' - ' . $userAddress->pin;

        $order = new Order();
        $order['o_id'] = Session::get('uniqueOrderId');
        $order['u_id'] = Session::get('user_id');
        $order['o_address'] = $customeAddress;
        $order['u_name'] = $paymentData['name'];
        $order['o_status'] = 'Pending';
        $order['total_amount'] = Session::get('total_bill');
        $order['o_phone_number'] = $paymentData['pnumber'];
        $order['o_payment_method'] = $paymentData['paymode'];

        $cartProducts = Session::get('cartProducts');
        $allItemsSaved = true;

        $order->save();

        foreach ($cartProducts as $item) {
            $order_items = new Order_Items();
            $order_items['order_id'] = $order->id;
            $order_items['product_id'] = $item->product->id;
            $order_items['size'] = $item->p_size;
            $order_items['quantity'] = $item->p_quantity;
            $order_items['product_name'] = $item->product->p_name;
            $order_items['product_image'] = $item->product->p_image;
            $order_items['price'] = $item->product->p_price;

            $product = $item->product;
            $sizeQuantities = json_decode($product->p_size_quatity, true); // Decode JSON into an array

            if(isset($sizeQuantities[$item->p_size])) {
                // Reduce the quantity for the specific size
                $sizeQuantities[$item->p_size] -= $item->p_quantity;

                // If the quantity goes negative, set it to 0 to avoid invalid values
                if ($sizeQuantities[$item->p_size] < 0) {
                    $sizeQuantities[$item->p_size] = 0;
                }

                // Update the product's size quantity in the database
                $product->p_size_quatity = json_encode($sizeQuantities); // Encode array back to JSON
                $product->save();
            }

            if (!$order_items->save()) {
                $allItemsSaved = false;
                break;
            }
        }

        if (!$allItemsSaved) {
            $order->delete();
            return redirect()->route('member.profile')->with('error', 'Order failed. Please try again.');
        }

        if(Session::has('apply_coupen') and Session::has('apply_coupen_id')){
            $coupenUser = new apply_coupen();
            $coupenUser['u_id'] = Session::get('user_id');
            $coupenUser['coupen_id'] = Session::get('apply_coupen_id');
            $coupenUser->save();
        }

        Session::forget('total_bill');
        Session::forget('cartProducts');
        Session::forget('addressID');
        Session::forget('paymentFormData');
        Session::forget('uniqueOrderId');
        Session::forget('apply_coupen');
        Session::forget('apply_coupen_id');

        add_to_cart::where('u_id', Session::get('user_id'))->delete();

        return redirect()->route('member.profile')->with('success', 'Order placed successfully!');
    }
    public function cancelOrder($o_id){
        $userOrder = Order::where('id', $o_id)->first();

        if($userOrder['o_status'] == "Cancelled"){
            return back()->with('error', 'Order already cancelled!');
        }

        $userOrder['o_status'] = "Cancelled";
        $userOrder->save();

        return back()->with('success', 'Order cancelled successfully!');
    }

    //apply coupen
    public function submitApplyCoupon(Request $formData){
        $userId = session('user_id');
        $couponCode = $formData->coupen;

        if (Session::has('apply_coupen')) {
            return redirect()->route('member.paymentView')->with('error', 'You have already applied a coupon.');
        }

        // 2. Check if coupon exists and is active
        $coupon = Offer::where('o_code', $couponCode)
                        ->where('o_status', 'active')
                        ->first();

        if (!$coupon) {
            return redirect()->route('member.paymentView')->with('error', 'Coupon code is invalid or expired.');
        }

        // 3. Check if user has already used this coupon
        $alreadyUsed = apply_coupen::where('u_id', $userId)
                        ->where('coupen_id', $coupon->id)
                        ->exists();

        if ($alreadyUsed) {
            return redirect()->route('member.paymentView')->with('error', 'You have already used this coupon.');
        }

        // 4. Check if total_bill is in range
        $totalBill = Session::get('total_bill');

        if ($totalBill >= $coupon->min_price && $totalBill <= $coupon->max_price) {
            // 5. Store offer percentage in session
            Session::put('apply_coupen', $coupon->o_offer);
            Session::put('apply_coupen_id', $coupon->id);

            if(Session::has('apply_coupen')){
                $discountPercent = Session::get('apply_coupen');
                $discountAmount = ($totalBill * $discountPercent) / 100;
                $discountedTotal = floor($totalBill - $discountAmount);

                Session::put('total_bill', $discountedTotal);
            }

            return redirect()->route('member.paymentView')->with('success', 'Coupon applied successfully.');
        } else {
            return redirect()->route('member.paymentView')->with('error', 'Coupon is not valid for your current bill.');
        }
    }

    //review
    public function reviewSubmit(Request $formData){
        $formData->validate([
            'rate' => 'required|integer|between:1,5',
            'comment' => 'required|string|min:5|max:500',
        ], [
            'rate.required' => 'Please provide a rating.',
            'rate.integer' => 'Rating must be a number.',
            'rate.between' => 'Rating must be between 1 and 5 stars.',
    
            'comment.required' => 'Please enter a comment.',
            'comment.string' => 'Comment must be a valid text.',
            'comment.min' => 'Comment must be at least 5 characters long.',
            'comment.max' => 'Comment cannot exceed 500 characters.',
        ]);
        $review = new review();
        $review['u_id'] = session('user_id');
        $review['p_id'] = $formData->p_id;
        $review['star'] = $formData->rate;
        $review['description'] = $formData->comment;
        $review->save();

        return redirect()->route('guest.product', ['p_id' => $formData->p_id])->with('success', 'Review submitted successfully!');
    }


    //profile management
    public function addressSubmit(Request $formData){
        
        $formData->validate([
            'name' => 'required|string|min:2|max:50',
            'pnumber' => 'required|size:10',
            'pin' => 'required|digits:6',
            'street' => 'required|string|min:5|max:300',
            'city' => 'required|string|min:2|max:100',
            'state' => 'required|string|min:2|max:100',
        ], [
            'name.required' => 'Full name is required.',
            'name.string' => 'Name must be a valid text.',
            'name.min' => 'Name must be at least 2 characters.',
            'name.max' => 'Name must not exceed 50 characters.',
            'pnumber.required' => 'Phone number is required.',
            'pnumber.size' => 'Phone number must be exactly 10 digits.',
            'pin.required' => 'PIN code is required.',
            'pin.digits' => 'PIN code must be exactly 6 digits.',
            'street.required' => 'Street is required.',
            'street.string' => 'Street must be valid text.',
            'street.min' => 'Street must be at least 5 characters.',
            'street.max' => 'Street must not exceed 300 characters.',
            'city.required' => 'City/District/Town is required.',
            'city.string' => 'City must be valid text.',
            'city.min' => 'City must be at least 2 characters.',
            'city.max' => 'City cannot exceed 100 characters.',
            'state.required' => 'State is required.',
            'state.string' => 'State must be valid text.',
            'state.min' => 'State must be at least 2 characters.',
            'state.max' => 'State cannot exceed 100 characters.',
        ]);

        if($formData->editAddressID){
            $address = user_address::where('id', $formData->editAddressID)->first();
            $address['name'] = $formData->name; 
            $address['phone_number'] = $formData->pnumber;
            $address['street'] = $formData->street;
            $address['city'] = $formData->city;
            $address['state'] = $formData->state;
            $address['pin'] = $formData->pin;
            $address->save();

            return redirect()->route('member.profile')->with('success', 'Address successfully updated.');
        }else{
            $address = new user_address();
            $address['u_id'] = session('user_id');
            $address['name'] = $formData->name; 
            $address['phone_number'] = $formData->pnumber;
            $address['street'] = $formData->street;
            $address['city'] = $formData->city;
            $address['state'] = $formData->state;
            $address['pin'] = $formData->pin;
            $address->save();

            return redirect()->route('member.profile')->with('success', 'Address successfully saved.');
        }
        
    }
    public function changePasswordSubmit(Request $formData){
        
        $formData->validate([
            'oldpass' => 'required|string',
            'newpass' => 'required|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[#$%@]).+$/|min:6|max:12',
            'cpass' => 'required|same:newpass',
        ], [
            'oldpass.required' => 'Please enter your current password.',
            'oldpass.string' => 'Old password must be a valid string.',
            'newpass.required' => 'Please enter a new password.',
            'newpass.regex' => 'New password must include uppercase, lowercase, number, and special character.',
            'newpass.min' => 'New password must be at least 6 characters.',
            'newpass.max' => 'New password cannot be more than 12 characters.',
            'cpass.required' => 'Please confirm your new password.',
            'cpass.same' => 'Confirm password must match the new password.',
        ]);

        $userId = session('user_id');
        $user = User::find($userId);

        // Check if old password matches
        if (!Hash::check($formData->oldpass, $user->password)) {
            return back()->with('error', 'Current password is incorrect.')->withInput();
        }

        // Update password
        $user->password = Hash::make($formData->newpass);
        $user->save();

        // return redirect()->route('member.profile')->with('success', 'Password changed successfully.');
        return redirect()->route('guest.signin')->with('success', 'Password changed successfully. Please log in again.');
    }
    public function editProfileSubmit(Request $formData){

        $formData->validate([
            'username' => 'required|string|min:2|max:50',
            'email' => 'required|email',
        ], [
            'username.required' => 'Username is required.',
            'username.string' => 'Username must be valid text.',
            'username.min' => 'Username must be at least 2 characters.',
            'username.max' => 'Username cannot exceed 50 characters.',
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',
        ]);
        
        $userId = session('user_id');
        $user = User::find($userId);

        $user->username = $formData->username;
        $user->email = $formData->email;
        $user->save();

        return redirect()->route('member.profile')->with('success', 'Profile updated successfully.');
    }
    public function ImageUpdateSumbit(Request $formData){
        $formData->validate([
            'userImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'userImage.required' => 'Please upload an image.',
            'userImage.image' => 'The file must be an image.',
            'userImage.mimes' => 'Only jpeg, png, jpg, gif, svg images are allowed.',
            'userImage.max' => 'Image size should not exceed 2MB.',
        ]);

        $userId = session('user_id');
        $user = User::find($userId);

        if ($formData->hasFile('userImage')) {
            $file = $formData->file('userImage');
            $uniqueName = uniqid('user_') . '.' . $file->getClientOriginalExtension();

            // Delete previous image if exists
            if ($user->profile_image) {
                $oldImagePath = public_path('images/users/' . $user->profile_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $file->move(public_path('images/users'), $uniqueName);

            // Save new filename to user record
            $user->profile_image = $uniqueName;
            $user->save();

            return redirect()->route('member.profile')->with('success', 'Profile image updated successfully.');
        } else {
            return back()->with('error', 'No file uploaded.');
        }
    }
    public function deleteAddress($a_id){
        $address = user_address::find($a_id);
        $address->delete();
        
        return redirect()->back()->with('success', 'Address removed successfully.');
    }
    public function saveAddressEditView($a_id){
        $address = user_address::find($a_id);
        if (!$address) {
            return redirect()->back()->with('error', 'Address not found.');
        }

        return view('member.savedAddress', compact('address'));
    }

    // filter and search
    public function orderSearch(Request $request){
        $q = $request->query('q');
        $orders = Order::with(['orderItems'])
            ->where('o_id', 'like', "%$q%")
            ->orWhereHas('orderItems', function ($query) use ($q) {
                $query->where('product_name', 'like', "%$q%");
            })
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($orders);
    }
}

// coupen: active upcoming expired
// order: pending processing completed cancelled