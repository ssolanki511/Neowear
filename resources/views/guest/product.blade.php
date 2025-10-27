@extends('masterview')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endsection

@section('main')
    <div class="product-main-container">
        <div class="product-wrapper">
            <div class="product-container-1">
                <div class="swiper mySwiper2">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="{{ asset('images/product_images/'.$product->p_image) }}" alt="Cloth's image"/>
                        </div>
                        @foreach (explode(',', $product->p_other_images) as $image)
                            <div class="swiper-slide">
                                <img src="{{ asset('images/product_images/'.$image) }}" alt="Cloth's image"/>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
                <div thumbsSlider="" class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="{{ asset('images/product_images/'.$product->p_image) }}" alt="Cloth's image"/>
                        </div>
                        @foreach (explode(',', $product->p_other_images) as $image)
                            <div class="swiper-slide">
                                <img src="{{ asset('images/product_images/'.$image) }}" alt="Cloth's image"/>
                            </div>
                        @endforeach
                    </div>
                </div>
                @php
                  $inWishlist = false;
                  $inWishlist = \App\Models\wishlist::where('u_id', session('user_id'))->where('p_id', $product->id)->exists();
                @endphp
                <button class="wishlist-btn" data-product-id="{{ $product->id }}">
                  @if($inWishlist)
                      <i class="fa-solid fa-heart" style="color: #ff0000;"></i>
                  @else
                      <i class="fa-regular fa-heart"></i>
                  @endif
                </button>
                <div class="zoom-box">
                    <div class="product-zoom"></div>
                </div>
            </div>
            @php
                $rating = round($reviews->avg('star'));
            @endphp
            <div class="product-container-2">
                <h2>{{ $product->p_name }}</h2>
                <div class="product-rating">
                    <div class="rating-box">
                        <div class="rating">
                            @for ($i = 5; $i >= 1; $i--)
                                <input type="radio" id="pstar{{ $i }}" name="pstar" value="{{ $i }}" {{ $rating == $i ? 'checked' : '' }} />
                                <label for="pstar{{ $i }}" title="{{ $i }} star">
                                    <svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid">
                                        <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                    </svg>
                                </label>
                            @endfor
                        </div>
                    </div>
                    <p class="rating-value">{{ number_format($reviews->avg('star'), 1) }}</p>
                </div>
                <div class="price">
                    <p>₹{{ $product->p_price }}</p>
                    @if($product->p_offer > 0)
                        @php
                            $discountedPrice = floor($product->p_price - ($product->p_price * $product->p_offer / 100));
                        @endphp
                        <p>₹{{ $discountedPrice }}</p>
                    @endif
                </div>
                <form action="{{ route('member.submitAddToCart') }}" method="post">
                    @csrf
                    <input type="hidden" value="{{ $product->id }}" name="p_id">
                    <div class="filter-box">
                        <div class="filter-1">
                            <p>Available Size</p>
                            @php
                                $sizes = json_decode($product->p_size_quatity, true);
                            @endphp
                            <div class="size-box">
                                @foreach ($sizes as $key => $qty)
                                    @if($qty > 0)
                                        <span>
                                            <input type="radio" name="size" id="size_{{ $key }}" value="{{ $key }}" {{ $loop->first ? 'checked' : '' }}>
                                            <label for="size_{{ $key }}">{{ $key }}</label>
                                        </span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="filter-2">
                            <p>Quantity</p>
                            <div class="number-control">
                                <button type="button" class="number-left">
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                                <input type="number" name="quantity" class="number-quantity" value="1" readonly>
                                <button type="button" class="number-right">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="Add to cart" class="cart-btn">
                </form>
                <p class="desc-heading">Description</p>
                <span class="description-box">
                    <p>{{ $product->p_description }}</p>
                    <button class="more-btn">more</button>
                    <button class="less-btn">less</button>
                </span>
            </div>
        </div>
        <div class="product-review-wrapper">
            <div class="review-container-1">
                <h3>Customer Reviews</h3>
                <div class="overall-rating">
                    <div class="rating">
                        @for ($i = 5; $i >= 1; $i--)
                            <input type="radio" id="rstar{{ $i }}" name="rate" value="{{ $i }}" {{ $rating == $i ? 'checked' : '' }} />
                                <label for="pstar{{ $i }}" title="{{ $i }} star">
                                <svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid">
                                    <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                </svg>
                            </label>
                        @endfor
                    </div>
                    <span class="all-reviews">Based on {{ count($reviews) }} reviews</span>
                </div>
                <div class="ratings-breakdown">
                    @foreach ($breakdown as $item)
                        <div class="rating-row">
                            <span>
                                <span>{{ $item['star'] }}</span>
                                <svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid" style="fill: #ffa723"><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg>
                            </span>
                            <div class="bar"><div style="width: {{ $item['percent'] }}%"></div></div>
                            <span>{{ $item['percent'] }}%</span>
                        </div>
                    @endforeach
                </div>
                <div class="share-thoughts">
                    <h4>Share your thoughts</h4>
                    <p>If you've used this product, share your thoughts with other customers</p>
                    <a href="{{ url('/product/review/'.$product->id) }}" class="review-btn">Write a review</a>
                </div>
            </div>
            <div class="review-container-2">
                <div class="user-review-wrapper">
                    @foreach ($reviews as $review)
                    <div class="user-review-box">
                        <div class="user-details">
                            <div class="user-img">
                                <img src="{{ asset('images/users/' . ($review->user?->profile_image ?? 'main_user_image.webp')) }}" alt="User Image">
                            </div>
                            <div class="user-name-rating">
                                @php
                                    $date = explode(" ", $review->created_at, 2);
                                @endphp
                                <div class="user-main-detail">
                                    <p class="user-name">{{ $review->user->username }}</p>
                                    <p class="user-date">{{ $date[0] }}</p>
                                </div>
                                <div class="review-rating-box">
                                    <div class="rating">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <input type="radio" id="star{{ $i }}-review-{{ $review->id }}" name="rate{{ $review->id }}" value="{{ $i }}" {{ $review->star == $i ? 'checked' : '' }} disabled/>
                                            <label for="star{{ $i }}-review-{{ $review->id }}" title="{{ $i }} stars"><svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid">
                                            <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg></label>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="user-message">{{ $review->description }}</p>
                    </div>
                    <hr class="user-review-line">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const productId = @json($product->id);
        const csrfToken = @json(csrf_token());
    </script>
    <script src="{{ asset('js/product.js') }}"></script>
    <script src="{{ asset('js/index.js') }}"></script>
@endsection