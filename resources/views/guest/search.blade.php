@extends('masterview')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
@endsection

@section('main')
    <div class="search-main-container">
        <div class="search-wrapper">
            <div class="filter-container">
                <form action="" id="filter-form">
                    <input type="hidden" name="productName" value="{{ request('productName') }}">
                    @if(count($categories) > 0)
                        <div class="filter-box">
                            <div class="menu">
                                <div class="item">
                                    <div class="heading-item">
                                        <input type="checkbox" name="" cl id="category" class="heading-checkbox">
                                        <label for="category" class="heading-label">
                                            <span class="heading-name">Category</span>
                                            <svg viewBox="0 0 360 360" xml:space="preserve">
                                                <g id="SVGRepo_iconCarrier">
                                                    <path
                                                        id="XMLID_225_"
                                                        d="M325.607,79.393c-5.857-5.857-15.355-5.858-21.213,0.001l-139.39,139.393L25.607,79.393 c-5.857-5.857-15.355-5.858-21.213,0.001c-5.858,5.858-5.858,15.355,0,21.213l150.004,150c2.813,2.813,6.628,4.393,10.606,4.393 s7.794-1.581,10.606-4.394l149.996-150C331.465,94.749,331.465,85.251,325.607,79.393z"
                                                    ></path>
                                                </g>
                                            </svg>
                                        </label>
                                        <div class="submenu">
                                            @foreach ($categories as $category)
                                                <div class="submenu-item">
                                                    <label for="c_{{ $category->id }}">
                                                        <p>
                                                            <input type="checkbox" id="c_{{ $category->id }}" class="input-cbx"name="categories[]" value="{{ $category->c_name }}" {{ in_array($category->c_name, request('categories', [])) ? 'checked' : '' }}/>
                                                            <span>{{ $category->c_name }}</span>
                                                        </p>
                                                    </label>                                        
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(count($sizes) > 0)
                        <div class="filter-box">
                            <div class="menu">
                                <div class="item">
                                    <div class="heading-item">
                                        <input type="checkbox" name="" cl id="size" class="heading-checkbox">
                                        <label for="size" class="heading-label">
                                            <span class="heading-name">Size</span>
                                            <svg viewBox="0 0 360 360" xml:space="preserve">
                                                <g id="SVGRepo_iconCarrier">
                                                    <path
                                                        id="XMLID_225_"
                                                        d="M325.607,79.393c-5.857-5.857-15.355-5.858-21.213,0.001l-139.39,139.393L25.607,79.393 c-5.857-5.857-15.355-5.858-21.213,0.001c-5.858,5.858-5.858,15.355,0,21.213l150.004,150c2.813,2.813,6.628,4.393,10.606,4.393 s7.794-1.581,10.606-4.394l149.996-150C331.465,94.749,331.465,85.251,325.607,79.393z"
                                                    ></path>
                                                </g>
                                            </svg>
                                        </label>
                                        <div class="submenu">
                                            @foreach ($sizes as $size)
                                                <div class="submenu-item">
                                                    <label for="s_{{ $size->id }}">
                                                        <p>
                                                            <input type="checkbox" id="s_{{ $size->id }}" class="input-cbx"name="sizes[]" value="{{ $size->size_name }}" {{ in_array($size->size_name, request('sizes', [])) ? 'checked' : '' }}/>
                                                            <span>{{ $size->size_name }}</span>
                                                        </p>
                                                    </label>                                        
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="filter-box">
                        <p class="heading-price">Price</p>
                        <div class="range_container">
                            <div class="sliders_control">
                                <input id="fromSlider" type="range" value="{{ request('minPrice', 0) }}" min="0" max="10000"/>
                                <input id="toSlider" type="range" value="{{ min(request('maxPrice', 10000), 10000) }}" min="0" max="10000"/>
                            </div>
                            <div class="form_control">
                                <div class="form_control_container">
                                    <div class="form_control_container__time">Min</div>
                                    <input class="form_control_container__time__input" type="tel" name="minPrice"  id="fromInput" value="{{ request('minPrice', 0) }}" min="0" max="10000"/>
                                </div>
                                <div class="form_control_container">
                                    <div class="form_control_container__time">Max</div>
                                    <input class="form_control_container__time__input" type="tel" name="maxPrice"  id="toInput" value="{{ request('maxPrice', 10000) }}" min="0" max="10000"/>
                                </div>
                            </div>
                            <input type="submit" value="Apply" class="range-apply">
                        </div>
                    </div>
                </form>
            </div>
            <div class="product-container">
                <div class="searched-product-container">
                    <div class="searched-product">
                        <p>Showing <span>{{ count($products) }}</span> results</p>
                    </div>
                </div>
                @if(count($products) > 0)
                    <div class="product-wrapper-container">
                        @foreach ($products as $product)
                            <div class="product-box">
                                <a href="{{ url('product/'.$product->id) }}">
                                    <div class="product-img">
                                        @if($product->p_offer > 0)
                                            <p>Sale</p>
                                        @endif
                                        <img src="{{ asset('images/product_images/'.$product->p_image) }}" alt="Cloth's">
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
                                    </div>
                                    <div class="product-main">
                                        <div class="product-detail">
                                        <p>{{ $product->p_name }}</p>
                                        <div class="price">
                                            <span>₹{{ $product->p_price }}</span>
                                            @if($product->p_offer > 0)
                                                @php
                                                    $discountedPrice = floor($product->p_price - ($product->p_price * $product->p_offer / 100));
                                                @endphp
                                                <span>₹{{ $discountedPrice }}</span>
                                            @endif
                                        </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="product-empty">No products available right now.</p>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/search.js') }}"></script>
    <script src="{{ asset('js/index.js') }}"></script>
@endsection