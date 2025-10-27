<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Contact;
use App\Models\Slider;
use App\Models\Product;
use App\Models\user_message;
use App\Models\About;
use App\Models\review;
use App\Models\size;
use App\Models\Category;
use App\Models\sort_by;
use App\Models\Order_Items;
use Illuminate\Support\Facades\Log;
use Exception;

class GuestController extends BaseController
{
    //views

    public function indexView()
    {
        $sliders = Slider::all();
        $recentProducts = Product::orderBy('updated_at', 'desc')->take(8)->get();

        $orderedProductCounts = Order_Items::select('product_id')
            ->groupBy('product_id')
            ->selectRaw('product_id, COUNT(*) as order_count')
            ->pluck('order_count', 'product_id')
            ->toArray();

        // Get all products
        $allProducts = Product::all();

        // Add order_count to each product (default 0 if not ordered)
        $featureProducts = $allProducts->map(function ($product) use ($orderedProductCounts) {
            $product->order_count = $orderedProductCounts[$product->id] ?? 0;
            return $product;
        })->sortBy('order_count')->values();
        //SortByDesc

        // return $featureProducts;

        $about = About::first();
        if($about){
            $paragraphs = preg_split("/\r\n|\n|\r/", $about->description, -1, PREG_SPLIT_NO_EMPTY);
        }else{
            $paragraphs = [];
        }
        
        return view('guest.index', compact('sliders', 'recentProducts', 'about', 'paragraphs', 'featureProducts'));
    }
    
    public function signUpView()
    {
        return view('guest.signup');
    }
    public function signInView()
    {
        return view('guest.login');
    }
    public function OTPView()
    {
        return view('guest.otp');
    }
    public function forgotPasswordView()
    {
        return view('guest.forgot_password');
    }
    public function resetPasswordView()
    {
        return view('guest.reset_password');
    }
    
    public function productView($p_id)
    {
        $product = Product::where('id', $p_id)->first();
        if (!$product) {
            return redirect()->route('guest.home')->with('error', 'Product not found!');
        }
        $reviews = Review::where('p_id', $p_id)->with('user')->get();
        // each star percentage
        $stars = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
        $totalRatings = $reviews->count();
        $totalScore = 0;

        foreach ($reviews as $review) {
            $star = (int)$review->star;
            if (isset($stars[$star])) {
                $stars[$star]++;
                $totalScore += $star;
            }
        }

        $average = $totalRatings > 0 ? round($totalScore / $totalRatings, 2) : 0;

        $breakdown = [];
        foreach (array_reverse($stars, true) as $star => $count) {
            $percent = $totalRatings > 0 ? round(($count / $totalRatings) * 100) : 0;
            $breakdown[] = [
                'star' => $star,
                'count' => $count,
                'percent' => $percent
            ];
        }

        return view('guest.product', compact('product', 'reviews', 'breakdown', 'average'));
    }
    public function searchView(Request $request)
    {
        $productName = $request->input('productName');
        $selectedCategories = $request->input('categories', []);
        $selectedSizes = $request->input('sizes', []);
        $minPrice = (int) $request->input('minPrice', 0);
        $rawMaxPrice = $request->input('maxPrice', 10000);

        // 🔍 Handle "unlimited" max price
        if ($rawMaxPrice === '10000+' || (int)$rawMaxPrice >= 10000) {
            $maxPrice = PHP_INT_MAX; // Effectively no max limit
        } else {
            $maxPrice = (int)$rawMaxPrice;
        }

        $products = Product::query();

        if (!empty($productName)) {
            $products->where('p_name', 'LIKE', "%{$productName}%");
        }

        if (!empty($selectedCategories)) {
            $products->whereIn('p_category', $selectedCategories);
        }

        if (!empty($selectedSizes)) {
            $products->where(function ($query) use ($selectedSizes) {
                foreach ($selectedSizes as $size) {
                    $query->orWhereRaw("CAST(JSON_UNQUOTE(JSON_EXTRACT(p_size_quatity, '$.\"$size\"')) AS UNSIGNED) > 0");
                }
            });
        }

        $products->whereBetween('p_price', [$minPrice, $maxPrice]);

        $products = $products->get();

        $sizes = size::all();
        $categories = Category::all();

        return view('guest.search', compact('products', 'sizes', 'categories'));
    }
    public function contactView()
    {
        $contact = Contact::first();
        return view('guest.contact', compact('contact'));
    }


    //validation and logic
    public function signUpSubmit(Request $signUpData)
    {
        $signUpData->validate([
            'username' => 'required|regex:/^\S*$/|min:5|max:12',
            'email' => 'required|email',
            'password' => 'required|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[#$%@]).+$/|min:6|max:12',
            'c_password' => 'required|same:password'
        ], [
            'username.required' => 'Username is required.',
            'username.regex' => 'Username must not contain spaces.',
            'username.min' => 'Username must be at least 5 characters.',
            'username.max' => 'Username must not exceed 12 characters.',
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',
            'password.required' => 'Password is required.',
            'password.regex' => 'Password must include uppercase, lowercase, number, and special character.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.max' => 'Password must not exceed 12 characters.',
            'c_password.required' => 'Confirm password is required.',
            'C_password.same' => 'Confirm password is not match.',
        ]);


        $u = new User();
        $u['username'] = $signUpData->username;
        $u['email'] = $signUpData->email;
        $u['password'] = Hash::make($signUpData->password);
        $u['token'] = csrf_token();
        try {
            $u->save();
        } catch (Exception $e) {
            return redirect()->route('guest.signup')->with('error', 'Sign up failed. Email or username already exists.');
        }
        
        $token = csrf_token();
        $to_email = $signUpData->email;

        $data = array("name" => "NoeWear", "body" => "Test mail", "to_email" => "$to_email", "to_name" => "Amrut", "token" =>$token);
        
        try{
            Mail::send('mail1', ['token' => $token, 'email' => $to_email], function ($message) use ($data) {
                $message->to($data['to_email'], $data['to_name'])->subject("Laravel Test Mail");
                $message->from("amrutmasani@gmail.com");
            });
        }catch(Exception $e){
            $userId = $u->id;
            User::destroy($userId);
            return redirect()->route('guest.signup')->with('error', 'Mail is not sent. Please try again.');
        }

        return redirect()->route('guest.signin')->with('success', 'Registration successful! Please sign in.');
    }

    public function send_dynamic_mail($token, $email)
    {
        $user = User::where('email', $email)->where('token', $token)->first();
        if ($user) {
            $user->status = 'active';
            $user->save();
            return redirect()->route('guest.signin')->with('success', 'Email verified successfully! Please login.');
        } else {
            User::where('email', $email)->delete();
            return redirect()->route('guest.signup')->with('error', 'Verification failed. Please sign up again.');
        }
    }

    public function signInSubmit(Request $signInData){
        $signInData->validate([
            'username' => 'required|regex:/^\S*$/|min:3|max:12',
            'password' => 'required|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[#$%@]).+$/|min:6|max:12'
        ], [
            'username.required' => 'Username is required.',
            'username.regex' => 'Username must not contain spaces.',
            'username.min' => 'Username must be at least 3 characters.',
            'username.max' => 'Username must not exceed 12 characters.',
            'password.required' => 'Password is required.',
            'password.regex' => 'Password must include uppercase, lowercase, number, and special character.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.max' => 'Password must not exceed 12 characters.',
        ]);

        $user = User::where('username', $signInData->username)->first();
        if ($user && Hash::check($signInData->password, $user->password)) {
            if ($user->status === 'inactive') {
                return redirect()->route('guest.signin')->with('error', 'Your account is inactive. Please verfiy your email.');
            }
            session(['user_id' => $user->id, 'user_type' => $user->role]);
            if ($user->role === 'Normal') {
                return redirect()->route('guest.home')->with('success', 'Login successful!');
            } else {
                return redirect()->route('home')->with('success', 'Admin login successful!');
            }
        } else {
            return redirect()->route('guest.signin')->with('error', 'Invalid username or password.');
        }
    }

    public function fogotPasswordSubmit(Request $forgotData)
    {
        $forgotData->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',
        ]);

        $user = User::where('email', $forgotData->email)->first();
        if (!$user) {
            return redirect()->route('guest.forgot_password')->with('error', 'Email not found.');
        }
        $otp = rand(1000, 9999);
        $user->otp = $otp;
        $user->save();
        $to_email = $forgotData->email;

        try {
            Mail::send('otpMail', ['otp' => $otp, 'email' => $to_email], function ($message) use ($to_email) {
                $message->to($to_email)->subject('Your OTP Code');
                $message->from('amrutmasani@gmail.com');
            });
        } catch (Exception $e) {
            return redirect()->route('guest.forgot_password')->with('error', 'OTP mail not sent. Please try again.');
        }
        return redirect()->route('guest.otp')->with(['success' => 'OTP successfully sent to your email.', 'email' => $to_email]);
    }

    public function OTPSubmit(Request $OTPData)
    {
        $OTPData->validate([
            'otp.*' => 'required',
        ], [
            'otp.*.required' => 'Each OTP digit is required.'
        ]);

        $user = User::where('email', $OTPData->email)->first();
        $enteredOtp = implode('', $OTPData->otp);

        if ($user->otp == $enteredOtp) {
            return redirect()->route('guest.reset_password')->with(['success' => 'OTP verified! You can reset your password now.', 'email' => $OTPData->email]);
        } else {
            return redirect()->route('guest.otp')->with(['error' => 'Invalid OTP. Please try again.', 'email' => $OTPData->email]);
        }
    }

    public function resetPasswordSubmit(Request $resetPasswordData)
    {
        $resetPasswordData->validate([
            'password' => 'required|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[#$%@]).+$/|min:6|max:12',
            'c_password' => 'required|same:password'
        ], [
            'password.required' => 'Password is required.',
            'password.regex' => 'Password must include uppercase, lowercase, number, and special character.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.max' => 'Password must not exceed 12 characters.',
        ]);

        $email = $resetPasswordData->email;
        $user = User::where('email', $email)->first();

        $user->password = Hash::make($resetPasswordData->password);
        $user->save();
        return redirect()->route('guest.signin')->with('success', 'Password reset successfully! Please login.');
        
    }

    public function ContactSubmit(Request $contactData)
    {
        $contactData->validate([
            'email' => 'required|email|exists:users,email',
            'message' => 'required|min:20|max:1000'
        ], [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.exists' => 'Please enter registed email address.',
            'message.required' => 'The message field is required.',
            'message.min' => 'The message must be at least 20 characters.',
            'message.max' => 'The message cannot be more than 1000 characters.',
        ]);

        $contact = Contact::first();
        
        $user_message = new user_message;
        $user_message['u_email'] = $contactData->email; 
        $user_message['u_message'] = $contactData->message; 
        $user_message->save();
        return redirect()->route('guest.contact')->with('success', 'Message successfully send.');
    }

    public function logout(){
        session()->forget('user_id');
        return redirect()->route('guest.signin')->with('success', 'Logout successfully.');
    }

    // search
    public function productSearch(Request $request){
        $keyword = $request->get('keyword');

        if (!$keyword) {
            return response()->json([]);
        }

        $products = Product::where('p_name', 'LIKE', "%{$keyword}%")
            ->limit(6)
            ->get(['id', 'p_name'])
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->p_name,
                ];
            });

        return response()->json($products);
    }
}
