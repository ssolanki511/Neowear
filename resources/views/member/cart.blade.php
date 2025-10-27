@extends('masterview')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endsection

@section('main')
    <div class="cart-main-container">
        <div class="cart-left-side">
            <div class="heading">
                <h2>Your <span>Cart</span></h2>
                <p>{{ count($cartItems) ?: 0 }} Items</p>
            </div>
            @if(count($cartItems) > 0)
              <div class="table-container">
                  <div class="table-wrpper">
                      <table>
                          <thead>
                            <tr>
                              <th>Product Details</th>
                              <th>Price</th>
                              <th>Size</th>
                              <th>Quantity</th>
                              <th>Subtotal</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($cartItems as $item)
                              <tr>
                                <td>
                                  <a href="{{ url('product/'.$item->product->id) }}"><img src="{{ asset('images/product_images/'.$item->product->p_image) }}" alt="Product Image" /></a>
                                  <div>
                                    <a href="{{ url('product/'.$item->product->id) }}"><strong>{{ $item->product->p_name }}</strong></a>
                                    <a href="{{ url('removeFromCart/'.$item->id) }}" class="remove">Remove</a>
                                  </div>
                                </td>
                                @php
                                  $discountedPrice = floor($item->product->p_price - ($item->product->p_price * $item->product->p_offer / 100));
                                @endphp
                                <td>₹{{ $discountedPrice }}</td>
                                <td>{{ $item->p_size }}</td>
                                <td>
                                    <input type="number" value="{{ $item->p_quantity }}" min="1" max="{{ json_decode($item->product->p_size_quatity, true)[$item->p_size] ?? 1 }}" class="quantity-input" data-cart-id="{{ $item->id }}" data-price="{{ $discountedPrice }}" />
                                </td>
                                <td id="subtotal-{{ $item->id }}">₹{{ $discountedPrice * $item->p_quantity }}</td>
                              </tr>
                            @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
            @else
              <p class="cart-empty">Your cart is empty.</p>
            @endif
            <a href="{{ url('/search') }}" class="continue-shopping"><span><i class="fa-solid fa-arrow-left"></i></span> Continue Shopping</a>
        </div>
        <div class="cart-right-side">
          <form action="{{ url('/purchaseSubmit') }}" method="post">
            @csrf
            <h3>Order Summary</h3>
            <label for="address">SELECT ADDRESS</label>
            <select id="address" name="address">
                <option selected disabled hidden>Select Address</option>
                @foreach ($user_addresses as $user_address)
                    @php
                      $address = $user_address->street . ', ' . $user_address->city . ', ' . $user_address->state . ' - ' . $user_address->pin
                    @endphp
                    <option value="{{ $user_address->id }}">{{ $address }}</option>
                @endforeach
            </select>
            @error('address')
              <p class="error-msg">{{ $message }}</p>
            @enderror
            @php
              $subtotal = 0;
              foreach ($cartItems as $item) {
                  $discountedPrice = floor($item->product->p_price - ($item->product->p_price * $item->product->p_offer / 100));
                  $subtotal += $discountedPrice * $item->p_quantity;
              }
              $shipping = 0;
              $tax = floor($subtotal * 0.18);
              $total = $subtotal + $shipping + $tax;
            @endphp
            <div class="summary-details">
                <p><strong>ITEMS {{ count($cartItems) ?: 0 }}</strong>
                  <span class="summary-subtotal">₹{{ $subtotal }}</span>
                </p>
                <p>Shipping Fee <span class="summary-shipping">{{ $shipping ? "₹".$shipping : "Free" }}</span></p>
                <p>Tax (18%) <span class="summary-tax">₹{{ $tax }}</span></p>
                <hr>
                <p class="total"><strong>Total</strong>
                  <span class="summary-total">₹{{ $total }}</span>
                </p>
            </div>

            <input type="hidden" name="total_price" value="{{ $total }}" class="summary-total-hidden">
            <input type="submit" value="Place Order" class="place-order">
          </form>
        </div>
    </div>
@endsection

@section('scripts')
  <script>
    var updateCarURL = '{{ route("cart.updateQuantity") }}';
    var CSRFToken= '{{ csrf_token() }}';
  </script>
  <script src="{{ asset('js/cart.js') }}"></script>
@endsection