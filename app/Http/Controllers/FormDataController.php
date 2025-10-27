<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Support\Facades\Session;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Slider;
use App\Models\Contact;
use App\Models\About;
use App\Models\user_message;

class FormDataController extends BaseController
{


    // public function send_static_mail()
    // {
    //     // $to_name="";
    //     // $to_email="";
    //     $data = array("name"=>"NoeWear","body"=>"Test mail", "to_email" => "amasani449@rku.ac.in", "to_name" => "Amrut", "token"=>$token);
    //     Mail::Send(['html'=>"mail1"], $data, function($message) use ($data){

    //         $message->to($data['to_email'], $data['to_name'])->subject("Laravel Test Mail");
    //         $message->from("amrutmasani@gmail.com");

    //     });

    //     echo "Mail Send";
    // }

    public function add_product(Request $request)
    {
        $validated = $request->validate(
            [
                'pn' => 'required|string|min:3|max:50',
                'sizes.S' => 'nullable|integer|min:0',
                'sizes.M' => 'nullable|integer|min:0',
                'sizes.L' => 'nullable|integer|min:0',
                'sizes.XL' => 'nullable|integer|min:0',
                'price' => 'required|numeric|min:0',
                'p_offer' => 'nullable|numeric|min:0|max:100',
                'options' => 'required',
                'img_file' => 'required|image|mimes:jpg,jpeg,png,webp|max:1024',
                'other_images' => 'required',
                'other_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:1024',
                'product_dis' => 'required|string|min:3|max:120',
            ],
            [
                'pn.required' => 'Product Name is required.',
                'pn.min' => 'Product Name must be at least 3 characters long.',
                'pn.max' => 'Product Name must not exceed 50 characters.',
                // Remove pqty error messages
                'sizes.S.integer' => 'Size S quantity must be a whole number.',
                'sizes.M.integer' => 'Size M quantity must be a whole number.',
                'sizes.L.integer' => 'Size L quantity must be a whole number.',
                'sizes.XL.integer' => 'Size XL quantity must be a whole number.',
                'sizes.S.min' => 'Size S quantity must be at least 0.',
                'sizes.M.min' => 'Size M quantity must be at least 0.',
                'sizes.L.min' => 'Size L quantity must be at least 0.',
                'sizes.XL.min' => 'Size XL quantity must be at least 0.',
                'price.required' => 'Price is required.',
                'price.numeric' => 'Price must be a number.',
                'price.min' => 'Price cannot be negative.',
                'p_offer.numeric' => 'Offer must be a number.',
                'p_offer.min' => 'Offer cannot be negative.',
                'p_offer.max' => 'Offer cannot exceed 100.',
                'options.required' => 'Options are required.',
                'img_file.required' => 'Product Image is required.',
                'img_file.image' => 'Product Image must be an image file.',
                'img_file.mimes' => 'Product Image must be a JPG, JPEG, WEBP or PNG file.',
                'img_file.max' => 'Product Image must be less than 1MB.',
                'other_images.required' => 'Product other images is required.',
                'other_images.*.image' => 'Product other images must be an image file.',
                'other_images.*.mimes' => 'Product other images must be a JPG, JPEG, WEBP or PNG file.',
                'other_images.*.max' => 'Product other images must be less than 1MB.',
                'product_dis.required' => 'Product Description is required.',
                'product_dis.min' => 'Product Description must be at least 3 characters long.',
                'product_dis.max' => 'Product Description must not exceed 120 characters.'
            ]
        );

        $p = new Product();
        $p['p_name'] = $request->pn;
        // Remove pqty
        // Collect sizes and quantities
        $sizes = [
            'S' => $request->input('sizes.S', null),
            'M' => $request->input('sizes.M', null),
            'L' => $request->input('sizes.L', null),
            'XL' => $request->input('sizes.XL', null),
        ];
        // Remove nulls
        $sizes = array_filter($sizes, function ($v) {
            return $v !== null && $v !== '';
        });
        $p['p_size_quatity'] = json_encode($sizes);

        $p['p_price'] = $request->price;
        $p['p_offer'] = $request->p_offer;
        $p['p_category'] = $request->options;
        $img = $request->file('img_file');
        $p['p_image'] = $img->getClientOriginalName();
        $otherImages = $request->file('other_images');
        $p_images = '';
        if (is_array($otherImages)) {
            $filenames = [];
            foreach ($otherImages as $image) {
                $filenames[] = $image->getClientOriginalName();
            }
            $p_images = implode(',', $filenames);
        } else {
            $p_images = '';
        }
        $p['p_other_images'] = $p_images;
        $p['p_description'] = $request->product_dis;
        $p->save();

        $path = public_path('images/product_images');
        $img->move($path, $img->getClientOriginalName());

        if (is_array($otherImages)) {
            foreach ($otherImages as $img1) {
                $img1->move($path, $img1->getClientOriginalName());
            }
        }

        return redirect('admin_products')->with('success', 'Product added successfully!');
    }

    public function edit_product_submit(Request $request)
    {
        $validated = $request->validate(
            [
                'id' => 'required|integer|exists:products,id',
                'pn' => 'required|string|min:3|max:50',
                // Add validation for sizes
                'sizes.S' => 'nullable|integer|min:0',
                'sizes.M' => 'nullable|integer|min:0',
                'sizes.L' => 'nullable|integer|min:0',
                'sizes.XL' => 'nullable|integer|min:0',
                'price' => 'required|numeric|min:0',
                'p_offer' => 'nullable|numeric|min:0|max:100',
                'options' => 'required',
                'img_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:250',
                'other_images' => 'nullable',
                'other_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:1250',
                'product_dis' => 'required|string|min:3|max:120',
            ],
            [
                'pn.required' => 'Product Name is required.',
                'pn.min' => 'Product Name must be at least 3 characters long.',
                'pn.max' => 'Product Name must not exceed 50 characters.',
                'sizes.S.integer' => 'Size S quantity must be a whole number.',
                'sizes.M.integer' => 'Size M quantity must be a whole number.',
                'sizes.L.integer' => 'Size L quantity must be a whole number.',
                'sizes.XL.integer' => 'Size XL quantity must be a whole number.',
                'sizes.S.min' => 'Size S quantity must be at least 0.',
                'sizes.M.min' => 'Size M quantity must be at least 0.',
                'sizes.L.min' => 'Size L quantity must be at least 0.',
                'sizes.XL.min' => 'Size XL quantity must be at least 0.',
                'price.required' => 'Price is required.',
                'price.numeric' => 'Price must be a number.',
                'price.min' => 'Price cannot be negative.',
                'p_offer.numeric' => 'Offer must be a number.',
                'p_offer.min' => 'Offer cannot be negative.',
                'p_offer.max' => 'Offer cannot exceed 100.',
                'options.required' => 'Options are required.',
                'img_file.required' => 'Product Image is required.',
                'img_file.image' => 'Product Image must be an image file.',
                'img_file.mimes' => 'Product Image must be a JPG, JPEG, WEBP or PNG file.',
                'img_file.max' => 'Product Image must be less than 250KB.',
                'other_images.required' => 'Product other images is required.',
                'other_images.*.image' => 'Product other images must be an image file.',
                'other_images.*.mimes' => 'Product other images must be a JPG, JPEG, WEBP or PNG file.',
                'other_images.*.max' => 'Product other images must be less than 1250KB.',
                'product_dis.required' => 'Product Description is required.',
                'product_dis.min' => 'Product Description must be at least 3 characters long.',
                'product_dis.max' => 'Product Description must not exceed 120 characters.'
            ]
        );

        $p = Product::find($request->id);
        $p->p_name = $request->pn;
        // Collect sizes and quantities
        $sizes = [
            'S' => $request->input('sizes.S', null),
            'M' => $request->input('sizes.M', null),
            'L' => $request->input('sizes.L', null),
            'XL' => $request->input('sizes.XL', null),
        ];
        $sizes = array_filter($sizes, function ($v) {
            return $v !== null && $v !== '';
        });
        $p->p_size_quatity = json_encode($sizes);

        $p->p_price = $request->price;
        $p->p_offer = $request->p_offer;
        $p->p_category = $request->options;
        if ($request->hasFile('img_file')) {
            $img = $request->file('img_file');
            $p->p_image = $img->getClientOriginalName();
            $img->move(public_path('images/product_images'), $img->getClientOriginalName());
        }
        $otherImages = $request->file('other_images');
        $p_images = '';
        if (is_array($otherImages)) {
            $filenames = [];
            foreach ($otherImages as $image) {
                $filenames[] = $image->getClientOriginalName();
                $image->move(public_path('images/product_images'), $image->getClientOriginalName());
            }
            $p_images = implode(',', $filenames);
            $p->p_other_images = $p_images;
        }
        $p->p_description = $request->product_dis;
        $p->save();

        return redirect('admin_products')->with('success', 'Product updated successfully!');
    }

    public function add_user(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|min:2|max:50',
                'email' => 'required|email',
                'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                'confirm_password' => 'required|same:password',
                'type' => 'required',
                'img_file' => 'required|image|mimes:jpg,jpeg,png|max:250',
            ],
            [
                'name.required' => 'Name is required.',
                'name.min' => 'Name must be at least 2 characters long.',
                'name.max' => 'Name must not exceed 50 characters.',
                'email.required' => 'Email is required.',
                'email.email' => 'Email must be a valid email address.',
                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 8 characters long.',
                'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
                'confirm_password.required' => 'Confirm Password is required.',
                'confirm_password.min' => 'Confirm Password must be at least 8 characters long.',
                'confirm_password.same' => 'Confirm Password must match Password.',
                'type.required' => 'Type is required.',
                'img_file.required' => 'Profile Image is required.',
                'img_file.image' => 'Profile Image must be an image file.',
                'img_file.mimes' => 'Profile Image must be a JPG, JPEG, or PNG file.',
                'img_file.max' => 'Profile Image must be less than 250KB.',
            ]
        );


        $u = new User();
        $u['username'] = $request->name;
        $u['email'] = $request->email;
        $u['password'] = Hash::make($request->password);
        $u['profile_image'] = $request->img_file->getClientOriginalName();

        $path = public_path('images/users/');
        $filename = $request->file('img_file');
        $filename->move($path, $filename->getClientOriginalName());

        $u['role'] = $request->type;
        $u['token'] = csrf_token();

        $u->save();

        $token = csrf_token();
        $to_email = $request->email;

        $data = array("name" => "NoeWear", "body" => "Test mail", "to_email" => "$to_email", "to_name" => "Amrut", "token" => $token);

        try {
            Mail::send('mail1', ['token' => $token, 'email' => $to_email], function ($message) use ($data) {
                $message->to($data['to_email'], $data['to_name'])->subject("Laravel Test Mail");
                $message->from("amrutmasani@gmail.com");
            });
        } catch (Exception $e) {
            $userId = $u->id;
            User::destroy($userId);
            return redirect()->route('guest.signup')->with('error', 'Mail is not sent. Please try again.');
        }

        return redirect('admin_users')->with('success', 'User added successfully!');
    }

    public function edit_user(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|min:2|max:50',
                'email' => 'required|email',
                'img_file' => 'nullable|image|mimes:jpg,jpeg,png|max:250'
            ],
            [
                'name.required' => 'Name is required.',
                'name.min' => 'Name must be at least 2 characters long.',
                'name.max' => 'Name must not exceed 50 characters.',
                'email.required' => 'Email is required.',
                'email.email' => 'Email must be a valid email address.',
                'img_file.required' => 'Profile Image is required.',
                'img_file.image' => 'Profile Image must be an image file.',
                'img_file.mimes' => 'Profile Image must be a JPG, JPEG, or PNG file.',
                'img_file.max' => 'Profile Image must be less than 250KB.',
            ]
        );

        $u = User::find($request->id);
        $u->username = $request->name;
        $u->email = $request->email;

        if ($request->hasFile('img_file')) {
            if ($u->profile_image) {
                $oldimage = $u->profile_image;
                $path = public_path('images/users/');
                unlink($path . $oldimage);
            }
            $oldimage = $u->profile_image;

            $u->profile_image = $request->img_file->getClientOriginalName();

            $path = public_path('images/users/');
            $filename = $request->file('img_file');
            $filename->move($path, $filename->getClientOriginalName());
        }
        $u->role = $request->type;
        $u->save();
        return redirect('admin_users')->with('success', 'User edited successfully!');
    }

    public function remove_user($id){
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect('admin_users')->with('success', 'User removed successfully!');
        }
        return redirect('admin_users')->with('error', 'User not found!');
    }

    public function add_category(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:50',
            'description' => 'required|string|min:3|max:120',
        ], [
            'name.required' => 'Category Name is required.',
            'name.min' => 'Category Name must be at least 3 characters long.',
            'name.max' => 'Category Name must not exceed 50 characters.',
            'description.required' => 'Category Description is required.',
            'description.min' => 'Category Description must be at least 3 characters long.',
            'description.max' => 'Category Description must not exceed 120 characters.'
        ]);

        $c = new Category();
        $c['c_name'] = $request->name;
        $c['c_description'] = $request->description;
        $c->save();

        return redirect('admin_categories')->with('success', 'Category added successfully!');
    }
    public function edit_category(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:50',
            'description' => 'required|string|min:3|max:120',
        ], [
            'name.required' => 'Category Name is required.',
            'name.min' => 'Category Name must be at least 3 characters long.',
            'name.max' => 'Category Name must not exceed 50 characters.',
            'description.required' => 'Category Description is required.',
            'description.min' => 'Category Description must be at least 3 characters long.',
            'description.max' => 'Category Description must not exceed 120 characters.'
        ]);

        $c = Category::find($request->id);
        $c->c_name = $request->name;
        $c->c_description = $request->description;
        $c->save();

        return redirect('admin_categories')->with('success', 'Category edited successfully!');
    }

    public function remove_category($id){
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return redirect('admin_categories')->with('success', 'Category removed successfully!');
        }
        return redirect('admin_categories')->with('error', 'Category not found!');
    }

    public function remove_order($id){
        $order = \App\Models\Order::find($id);
        if ($order) {
            $order->delete();
            return redirect('admin_orders')->with('success', 'Order removed successfully!');
        }
        return redirect('admin_orders')->with('error', 'Order not found!');
    }

    public function add_offer(Request $request)
    {
        $validated = $request->validate([
            'offer_name' => 'required|string|min:3|max:50',
            'offer' => 'required|numeric|min:1|max:100',
            'offer_code' => 'required|string|size:8|regex:/^\S*$/',
            'min_price' => 'required|numeric|min:0',
            'max_price' => 'required|numeric|gt:min_price',
            'offer_status' => 'required|in:active,upcoming,expired',
        ], [
            'offer_name.required' => 'Offer Name is required.',
            'offer_name.min' => 'Offer Name must be at least 3 characters long.',
            'offer_name.max' => 'Offer Name must not exceed 50 characters.',
            'offer.required' => 'Discount is required.',
            'offer.numeric' => 'Discount must be a number.',
            'offer.min' => 'Discount must be at least 1%.',
            'offer.max' => 'Discount cannot exceed 100%.',
            'offer_code.required' => 'Offer Code is required.',
            'offer_code.string' => 'Offer code must be a string.',
            'offer_code.size' => 'Offer code must be 8 characters.',
            'offer_code.regex' => 'Offer Code must not contain spaces.',
            'min_price.required' => 'Min Price is required.',
            'min_price.numeric' => 'Min Price must be a number.',
            'min_price.min' => 'Min Price cannot be negative.',
            'max_price.required' => 'Max Price is required.',
            'max_price.numeric' => 'Max Price must be a number.',
            'max_price.gt' => 'Max Price must be greater than Min Price.',
            'offer_status.required' => 'Status is required.',
            'offer_status.in' => 'Status must be Active, Upcoming, or Expired.',
        ]);

        $o = new Offer();
        $o['o_name'] = $request->offer_name;
        $o['o_code'] = $request->offer_code;
        $o['o_offer'] = $request->offer;
        $o['max_price'] = $request->max_price;
        $o['min_price'] = $request->min_price;
        $o['o_status'] = $request->offer_status;
        $o->save();
        return redirect('admin_offers')->with('success', 'Offer added successfully!');
    }
    public function edit_offer(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:offers,id',
            'offer_name' => 'required|string|min:3|max:50',
            'offer_code' => 'required|string|size:8|regex:/^\S*$/',
            'offer' => 'required|numeric|min:1|max:100',
            'min_price' => 'required|numeric|min:0',
            'max_price' => 'required|numeric|gt:min_price',
            'offer_status' => 'required|in:active,upcoming,expired',
        ], [
            'id.required' => 'Offer ID is required.',
            'id.integer' => 'Offer ID must be a valid number.',
            'id.exists' => 'Offer not found.',
            'offer_name.required' => 'Offer Name is required.',
            'offer_name.min' => 'Offer Name must be at least 3 characters long.',
            'offer_name.max' => 'Offer Name must not exceed 50 characters.',
            'offer_code.required' => 'Offer Code is required.',
            'offer_code.string' => 'Offer code must be a string.',
            'offer_code.size' => 'Offer code must be 8 characters.',
            'offer_code.regex' => 'Offer Code must not contain spaces.',
            'offer.required' => 'Discount is required.',
            'offer.numeric' => 'Discount must be a number.',
            'offer.min' => 'Discount must be at least 1%.',
            'offer.max' => 'Discount cannot exceed 100%.',
            'min_price.required' => 'Min Price is required.',
            'min_price.numeric' => 'Min Price must be a number.',
            'min_price.min' => 'Min Price cannot be negative.',
            'max_price.required' => 'Max Price is required.',
            'max_price.numeric' => 'Max Price must be a number.',
            'max_price.gt' => 'Max Price must be greater than Min Price.',
            'offer_status.required' => 'Status is required.',
            'offer_status.in' => 'Status must be Active, Upcoming, or Expired.',
        ]);

        $o = Offer::findOrFail($request->id);
        $o->o_name = $request->offer_name;
        $o->o_code = $request->offer_code;
        $o->o_offer = $request->offer;
        $o->max_price = $request->max_price;
        $o->min_price = $request->min_price;
        $o->o_status = $request->offer_status;
        $o->save();

        return redirect('admin_offers')->with('success', 'Offer updated successfully!');
    }
    public function add_order(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|string|min:3|max:50',
            'user' => 'required|string|min:2|max:50',
            'product' => 'required|string|min:2|max:50',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,processing,completed,cancelled',
        ], [
            'order_id.required' => 'Order ID is required.',
            'order_id.min' => 'Order ID must be at least 3 characters long.',
            'order_id.max' => 'Order ID must not exceed 50 characters.',
            'user.required' => 'User is required.',
            'user.min' => 'User must be at least 2 characters long.',
            'user.max' => 'User must not exceed 50 characters.',
            'product.required' => 'Product is required.',
            'product.min' => 'Product must be at least 2 characters long.',
            'product.max' => 'Product must not exceed 50 characters.',
            'quantity.required' => 'Quantity is required.',
            'quantity.integer' => 'Quantity must be a whole number.',
            'quantity.min' => 'Quantity must be at least 1.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a number.',
            'price.min' => 'Price cannot be negative.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be Pending, Processing, Completed, or Cancelled.'
        ]);
        return redirect('admin.admin_orders')->with('success', 'Order added successfully!');
    }
    public function edit_order(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:orders,id',
            'order_id' => 'required|string|max:50',
            'user' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'payment_method' => 'required|string|max:50',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|string|in:Pending,Processing,Completed,Cancelled',
        ], [
            'order_id.required' => 'Order ID is required.',
            'user.required' => 'User name is required.',
            'address.required' => 'Address is required.',
            'phone.required' => 'Phone number is required.',
            'payment_method.required' => 'Payment method is required.',
            'total_amount.required' => 'Total amount is required.',
            'status.required' => 'Order status is required.',
            'status.in' => 'Invalid status selected.',
        ]);

        $order = \App\Models\Order::findOrFail($request->id);
        $order->o_id = $request->order_id;
        $order->u_name = $request->user;
        $order->o_address = $request->address;
        $order->o_phone_number = $request->phone;
        $order->o_payment_method = $request->payment_method;
        $order->total_amount = $request->total_amount;
        $order->o_status = $request->status;
        $order->save();

        return redirect()->route('orders')->with('success', 'Order updated successfully.');
    }

    public function edit_inquiry(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:50',
            'email' => 'required|email',
            'subject' => 'required|string|min:3|max:100',
            'message' => 'required|string|min:5|max:500',
        ], [
            'name.required' => 'Name is required.',
            'name.min' => 'Name must be at least 2 characters long.',
            'name.max' => 'Name must not exceed 50 characters.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'subject.required' => 'Subject is required.',
            'subject.min' => 'Subject must be at least 3 characters long.',
            'subject.max' => 'Subject must not exceed 100 characters.',
            'message.required' => 'Message is required.',
            'message.min' => 'Message must be at least 5 characters long.',
            'message.max' => 'Message must not exceed 500 characters.'
        ]);
        return redirect('admin.admin_inquires')->with('success', 'Inquiry edited successfully!');
    }
    public function edit_profile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:50',
            'img_file' => 'nullable|image|mimes:jpg,jpeg,png|max:250',
        ], [
            'name.required' => 'Name is required.',
            'name.min' => 'Name must be at least 2 characters long.',
            'name.max' => 'Name must not exceed 50 characters.',
            'img_file.image' => 'Profile Image must be an image file.',
            'img_file.mimes' => 'Profile Image must be a JPG, JPEG, or PNG file.',
            'img_file.max' => 'Profile Image must be less than 250KB.'
        ]);

        $u = User::find(Session::get('user_id'));
        $u->username = $request->name;

        if ($request->hasFile('img_file')) {
            if ($u->profile_image) {
                $oldimage = $u->profile_image;
                $path = public_path('images/users/');
                unlink($path . $oldimage);
            }
            $u->profile_image = $request->img_file->getClientOriginalName();

            $path = public_path('images/users/');
            $filename = $request->file('img_file');
            $filename->move($path, $filename->getClientOriginalName());
        }
        $u->save();

        return redirect('admin_profile')->with('success', 'Profile edited successfully!');
    }

    public function change_password(Request $request)
    {
        $u = User::find(Session::get('user_id'));

        if (!Hash::check($request->old_password, $u->password)) {
            return redirect('/change_password')->with('error', 'Old Password is incorrect.');
        }

        $validated = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            'confirm_password' => 'required|same:new_password',
        ], [
            'old_password.required' => 'Old Password is required.',
            'new_password.required' => 'New Password is required.',
            'new_password.min' => 'New Password must be at least 8 characters long.',
            'new_password.regex' => 'New Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'confirm_password.required' => 'Confirm Password is required.',
            'confirm_password.same' => 'Confirm Password must match New Password.'
        ]);


        $u->password = Hash::make($request->new_password);
        $u->save();
        return redirect('admin_profile')->with('success', 'Password changed successfully!');
    }
    public function reply_inquiry(Request $request)
    {
        $validated = $request->validate([
            'reply' => 'required|string|min:5|max:500'
        ], [
            'reply.required' => 'Reply message is required.',
            'reply.string' => 'Reply must be valid text.',
            'reply.min' => 'Reply must be at least 5 characters.',
            'reply.max' => 'Reply cannot exceed 500 characters.'
        ]);
        $about = Contact::first();
        $support_email = $about->email;

        try {
            $data = [
                'name' => 'Demo',
                'email' => $request->user_email,
                'reply' => $request->reply,
                'support_email' => $support_email,
            ];
            Mail::send('replyMain', $data, function ($message) use ($data) {
                $message->subject('Inquiry Reply');
                $message->from('amrutmasani@gmail.com', 'NeoWear');
                $message->to($data['email'], $data['name']);
            });
            $u_message = user_message::where('u_email', $request->user_email)->first();
            $u_message->status = 'Replied';
            $u_message->save();

            return redirect('admin_inquires')->with('success', 'Reply sent successfully!');
        } catch (Exception $th) {
            return redirect('admin_inquires')->with('error', 'Error to sent Reply!');
        }
    }


    public function remove_inquiry($id){

        $u_msg = user_message::find($id);
        $u_msg->delete();

        return redirect('admin_inquires')->with('success', 'Reply removed successfully!');
    }


    public function add_slider(Request $request)
    {
        $validated = $request->validate(
            [
                'title' => 'required|string|min:3|max:100',
                'image' => 'required|mimes:png,jpg,jpeg|max:250'
            ],
            [
                'title.required' => 'Slider image title is required.',
                'title.string' => 'Slider image title must be string.',
                'title.min' => 'Slider image title must be atleast 3 characters.',
                'title.max' => 'Slider image title must be less than 100 characters.',

                'image.required' => 'Slider Image file required.',
                'image.mimes' => 'Images must be in jpg, png and jpeg format.',
                'image.max' => 'Image file size must be less than 250kb.'
            ]
        );

        $s = new Slider();
        $s['s_image'] = $request->image->getClientOriginalName();
        $s['s_title'] = $request->title;

        $filename = $request->file('image');
        $path = public_path('/images/slider_images');
        $filename->move($path, $filename->getClientOriginalName());
        $s->save();

        return redirect()->route('admin.sliders')->with('success', 'Slider added.');
    }

    public function edit_slider(Request $request, $id)
    {
        $validated = $request->validate(
            [
                'title' => 'required|string|min:3|max:100',
                'image' => 'nullable|mimes:png,jpg,jpeg|max:250'
            ],
            [
                'title.required' => 'Slider title is required.',
                'title.string' => 'Slider title must be string.',
                'title.min' => 'Slider title must be atleast 3 characters.',
                'title.max' => 'Slider title must be less than 100 characters.',
                'image.mimes' => 'Images must be in jpg, png and jpeg format.',
                'image.max' => 'Image file size must be less than 250kb.'
            ]
        );

        $slider = Slider::findOrFail($id);
        $slider->s_title = $request->title;

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($slider->s_image) {
                $oldImagePath = public_path('images/slider_images/' . $slider->s_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Upload new image
            $image = $request->file('image');
            $slider->s_image = $image->getClientOriginalName();
            $image->move(public_path('images/slider_images'), $image->getClientOriginalName());
        }

        $slider->save();

        return redirect()->route('admin.sliders')->with('success', 'Slider updated successfully!');
    }

    public function delete_slider($id)
    {
        $slider = Slider::findOrFail($id);

        // Delete image file if exists
        if ($slider->s_image) {
            $imagePath = public_path('images/slider_images/' . $slider->s_image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $slider->delete();

        return redirect()->route('admin.sliders')->with('success', 'Slider deleted successfully!');
    }

    public function update_about_settings(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:100',
            'description' => 'required|string|min:10|max:1000',
            'links' => 'array|max:3',
            'links.*.link_name' => 'nullable|string|max:100',
            'links.*.link_url' => 'nullable|url|max:255'
        ], [
            'title.required' => 'About title is required.',
            'title.min' => 'About title must be at least 3 characters.',
            'title.max' => 'About title must not exceed 100 characters.',
            'description.required' => 'About description is required.',
            'description.min' => 'About description must be at least 10 characters.',
            'description.max' => 'About description must not exceed 1000 characters.',
            'links.*.link_url.url' => 'Please enter a valid URL for each link.',
            'links.*.link_url.max' => 'URL must not exceed 255 characters.',
            'links.*.link_name.max' => 'Link title must not exceed 100 characters.',
        ]);

        $about = \App\Models\About::first();
        if (!$about) {
            $about = new \App\Models\About();
        }
        $about->title = $request->title;
        $about->description = $request->description;
        $about->save();

        // Handle About Links (up to 3)
        $links = $request->input('links', []);
        $existingLinks = \App\Models\AboutLink::all();
        for ($i = 0; $i < 3; $i++) {
            $linkData = $links[$i] ?? [];
            $link_name = $linkData['link_name'] ?? '';
            $link_url = $linkData['link_url'] ?? '';
            if ($link_name || $link_url) {
                $aboutLink = $existingLinks[$i] ?? new \App\Models\AboutLink();
                $aboutLink->link_name = $link_name;
                $aboutLink->link_url = $link_url;
                $aboutLink->save();
            } elseif (isset($existingLinks[$i])) {
                $existingLinks[$i]->delete();
            }
        }

        return redirect()->route('admin.about')->with('success', 'About information updated successfully!');
    }

    public function update_contact_settings(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:100',
            'consulting_phone' => 'required|string|size:10',
            'report_phone' => 'required|string|size:10',
            'address' => 'required|string|min:10|max:500'
        ], [
            'email.required' => 'Contact email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email must not exceed 100 characters.',
            'consulting_phone.required' => 'Consulting phone number is required.',
            'consulting_phone.size' => 'Consulting phone must 10 numbers.',
            'report_phone.required' => 'Report phone number is required.',
            'report_phone.size' => 'Report phone must 10 numbers',
            'address.required' => 'Address is required.',
            'address.min' => 'Address must be at least 10 characters.',
            'address.max' => 'Address must not exceed 500 characters.'
        ]);

        $contact = Contact::first();
        if (!$contact) {
            $contact = new Contact();
        }

        $contact->email = $request->email;
        $contact->consulting_phone = $request->consulting_phone;
        $contact->report_phone = $request->report_phone;
        $contact->address = $request->address;
        $contact->save();

        return redirect()->route('admin.contact')->with('success', 'Contact information updated successfully!');
    }

    public function delete_product($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return redirect('admin_products')->with('success', 'Product deleted successfully!');
        }
        return redirect('admin_products')->with('error', 'Product not found!');
    }
    public function delete_offer($id)
    {
        $offer = Offer::find($id);
        if ($offer) {
            $offer->delete();
            return redirect('admin_offers')->with('success', 'Offer deleted successfully!');
        }
        return redirect('admin_offers')->with('error', 'Offer not found!');
    }
}
