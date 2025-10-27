@extends('masterview')

@section('styles')
  <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main')
  @if (count($sliders) > 0)
    <section class="hero-section">
      <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
          @foreach ($sliders as $slider)
              <div class="swiper-slide">
              <img src="{{ asset('images/slider_images/'.$slider->s_image) }}" alt="{{ $slider->s_title }}">
            </div>
          @endforeach
        </div>
        <div class="swiper-button">
          <div class="swiper-button-next"></div>
        </div>
        <div class="swiper-button">
          <div class="swiper-button-prev"></div>
        </div>
      </div>
    </section>
  @endif

  @if(isset($recentProducts) && count($recentProducts) > 0)
    <section class="feature-section">
      <div class="swiper recent-swiper">
        <h2>Recent products</h2>
        <div class="swiper-wrapper">
          @foreach ($recentProducts as $product)
            <div class="swiper-slide">
              <div class="product-box">
                <a href="{{ url('product/'.$product->id) }}">
                  <div class="product-img">
                    @if($product->p_offer > 0)
                      <p>Sale</p>
                    @endif
                    @php
                      $inWishlist = false;
                      $inWishlist = \App\Models\wishlist::where('u_id', session('user_id'))->where('p_id', $product->id)->exists();
                    @endphp
                    <img src="{{ asset('images/product_images/'.$product->p_image) }}" alt="Cloth's">

                    <button class="wishlist-btn" data-product-id="{{ $product->id }}">
                      @if($inWishlist)
                          <i class="fa-solid fa-heart" style="color: #ff0000;"></i>
                      @else
                          <i class="fa-regular fa-heart"></i>
                      @endif
                    </button>
                  </div>
                  <div class="product-main">
                    <div class="product-detail">
                      <p>{{ $product->p_name }}</p>
                      <div class="price">
                        @php
                          $discountedPrice = floor($product->p_price - ($product->p_price * $product->p_offer / 100));
                        @endphp
                        <span>₹{{ $discountedPrice }}</span>
                        @if($product->p_offer > 0)
                          <span>₹{{  $product->p_price }}</span>
                        @endif
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          @endforeach
        </div>
        <div class="swiper-button">
          <div class="swiper-button-next recent-button-next"></div>
        </div>
        <div class="swiper-button">
          <div class="swiper-button-prev recent-button-prev"></div>
        </div>
        <div class="swiper-scrollbar recent-scrollbar"></div>
      </div>
    </section>
  @endif

  @if (isset($featureProducts) && count($featureProducts) > 0)
    <section class="feature-banner">
      <h2>Featured Products</h2>
      <p>Check out our featured products!</p>
    </section>

    <section class="feature-section">
      <div class="swiper feature-swiper">
        <div class="swiper-wrapper">
          @foreach ($featureProducts as $product)
            <div class="swiper-slide">
              <div class="product-box">
                <a href="{{ url('product/'.$product->id) }}">
                  <div class="product-img">
                    @if($product->p_offer > 0)
                      <p>Sale</p>
                    @endif
                    @php
                      $inWishlist = false;
                      // use App\Models\wishlist;
                      $inWishlist = \App\Models\wishlist::where('u_id', session('user_id'))->where('p_id', $product->id)->exists();
                    @endphp
                    <img src="{{ asset('images/product_images/'.$product->p_image) }}" alt="Cloth's">
                    <button class="wishlist-btn" data-product-id="{{ $product->id }}">
                      @if($inWishlist)
                          <i class="fa-solid fa-heart" style="color: #ff0000;"></i>
                      @else
                          <i class="fa-regular fa-heart"></i>
                      @endif
                    </button>
                  </div>
                  <div class="product-main">
                    <div class="product-detail">
                      <p>{{ $product->p_name }}</p>
                      <div class="price">
                        @php
                          $discountedPrice = floor($product->p_price - ($product->p_price * $product->p_offer / 100));
                        @endphp
                        <span>₹{{ $discountedPrice }}</span>
                        @if($product->p_offer > 0)
                          <span>₹{{  $product->p_price }}</span>
                        @endif
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          @endforeach
        </div>
        <div class="swiper-button">
          <div class="swiper-button-next feature-button-next"></div>
        </div>
        <div class="swiper-button">
          <div class="swiper-button-prev feature-button-prev"></div>
        </div>
        <div class="swiper-scrollbar feature-scrollbar"></div>
      </div>
    </section>
  @endif

  @if(count($paragraphs) > 0)
    <section class="about-section">
      <h3>About Us</h3>
      <p>At <span>{{ $about->title }}</span>, {{ $paragraphs[0] }}</p>
      @for ($i = 1; $i < count($paragraphs); $i++)
        <br>
        <p>{{ $paragraphs[$i] }}</p>
      @endfor
    </section>
  @endif
@endsection

@section('scripts')
  <script src="{{ asset('js/index.js') }}"></script>
@endsection