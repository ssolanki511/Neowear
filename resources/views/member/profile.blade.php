@extends('masterview')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('main')
    <div class="profile-main-container">
        <div class="profile-top">
            <div class="profile-head">
                <div class="profile-bg">
                    <div class="profile-img">
                        <img src="{{ asset($user->profile_image ? 'images/users/'.$user->profile_image : 'images/users/main_user_image.webp') }}" alt="Background Image">
                        <form action="{{ url('/imageUpdate') }}" method="post" enctype="multipart/form-data" id="uploadForm">
                          @csrf
                            <input type="file" name="userImage" id="image-file" class="img-file">
                            <label for="image-file">
                                <svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                    <g id="SVGRepo_iconCarrier"> <path d="M14.3601 4.07866L15.2869 3.15178C16.8226 1.61607 19.3125 1.61607 20.8482 3.15178C22.3839 4.68748 22.3839 7.17735 20.8482 8.71306L19.9213 9.63993M14.3601 4.07866C14.3601 4.07866 14.4759 6.04828 16.2138 7.78618C17.9517 9.52407 19.9213 9.63993 19.9213 9.63993M14.3601 4.07866L5.83882 12.5999C5.26166 13.1771 4.97308 13.4656 4.7249 13.7838C4.43213 14.1592 4.18114 14.5653 3.97634 14.995C3.80273 15.3593 3.67368 15.7465 3.41556 16.5208L2.32181 19.8021M19.9213 9.63993L11.4001 18.1612C10.8229 18.7383 10.5344 19.0269 10.2162 19.2751C9.84082 19.5679 9.43469 19.8189 9.00498 20.0237C8.6407 20.1973 8.25352 20.3263 7.47918 20.5844L4.19792 21.6782M4.19792 21.6782L3.39584 21.9456C3.01478 22.0726 2.59466 21.9734 2.31063 21.6894C2.0266 21.4053 1.92743 20.9852 2.05445 20.6042L2.32181 19.8021M4.19792 21.6782L2.32181 19.8021" stroke="#000" stroke-width="1.5"/> </g>    
                                </svg>
                            </label>
                        </form>
                    </div>
                </div>
            </div>
            <div class="user-name-edits">
                <h2>{{ $user->username }}</h2>
                <div class="edits-container">
                    <button class="menu-button">
                        <svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" transform="rotate(90)">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                            <g id="SVGRepo_iconCarrier"> <path d="M7 12C7 13.1046 6.10457 14 5 14C3.89543 14 3 13.1046 3 12C3 10.8954 3.89543 10 5 10C6.10457 10 7 10.8954 7 12Z" fill="#1C274C"/> <path d="M14 12C14 13.1046 13.1046 14 12 14C10.8954 14 10 13.1046 10 12C10 10.8954 10.8954 10 12 10C13.1046 10 14 10.8954 14 12Z" fill="#1C274C"/> <path d="M21 12C21 13.1046 20.1046 14 19 14C17.8954 14 17 13.1046 17 12C17 10.8954 17.8954 10 19 10C20.1046 10 21 10.8954 21 12Z" fill="#000000"/> </g>
                        </svg>
                    </button>
                    <div class="edit-box">
                        <a href="{{ url('editProfile') }}">
                            <span>
                                <svg width="64px" height="64px" viewBox="0 -0.05 20.109 20.109" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                    <g id="SVGRepo_iconCarrier"> <g id="edit-user" transform="translate(-2 -2)"> <path id="primary" d="M20.71,16.09,15.8,21H13V18.2l4.91-4.91a1,1,0,0,1,1.4,0l1.4,1.4A1,1,0,0,1,20.71,16.09ZM11,3a4,4,0,1,0,4,4A4,4,0,0,0,11,3Z" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/> <path id="primary-2" data-name="primary" d="M11,15H8a5,5,0,0,0-5,5,1,1,0,0,0,1,1H9" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/> </g> </g>
                                </svg>
                            </span>
                            <p>Edit profile</p>
                        </a>
                        <a href="{{ url('changePassword') }}">
                            <span>
                                <svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                    <g id="SVGRepo_iconCarrier"> <path d="M15 9H15.01M15 15C18.3137 15 21 12.3137 21 9C21 5.68629 18.3137 3 15 3C11.6863 3 9 5.68629 9 9C9 9.27368 9.01832 9.54308 9.05381 9.80704C9.11218 10.2412 9.14136 10.4583 9.12172 10.5956C9.10125 10.7387 9.0752 10.8157 9.00469 10.9419C8.937 11.063 8.81771 11.1823 8.57913 11.4209L3.46863 16.5314C3.29568 16.7043 3.2092 16.7908 3.14736 16.8917C3.09253 16.9812 3.05213 17.0787 3.02763 17.1808C3 17.2959 3 17.4182 3 17.6627V19.4C3 19.9601 3 20.2401 3.10899 20.454C3.20487 20.6422 3.35785 20.7951 3.54601 20.891C3.75992 21 4.03995 21 4.6 21H6.33726C6.58185 21 6.70414 21 6.81923 20.9724C6.92127 20.9479 7.01881 20.9075 7.10828 20.8526C7.2092 20.7908 7.29568 20.7043 7.46863 20.5314L12.5791 15.4209C12.8177 15.1823 12.937 15.063 13.0581 14.9953C13.1843 14.9248 13.2613 14.8987 13.4044 14.8783C13.5417 14.8586 13.7588 14.8878 14.193 14.9462C14.4569 14.9817 14.7263 15 15 15Z" stroke="#fff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/> </g>
                                </svg>
                            </span>
                            <p>Edit password</p>
                        </a>
                    </div>
                </div>
            </div>
            <span class="user-detail">
                <span>
                    <svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                        <g id="SVGRepo_iconCarrier"> <path d="M3 8L8.44992 11.6333C9.73295 12.4886 10.3745 12.9163 11.0678 13.0825C11.6806 13.2293 12.3194 13.2293 12.9322 13.0825C13.6255 12.9163 14.2671 12.4886 15.5501 11.6333L21 8M6.2 19H17.8C18.9201 19 19.4802 19 19.908 18.782C20.2843 18.5903 20.5903 18.2843 20.782 17.908C21 17.4802 21 16.9201 21 15.8V8.2C21 7.0799 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V15.8C3 16.9201 3 17.4802 3.21799 17.908C3.40973 18.2843 3.71569 18.5903 4.09202 18.782C4.51984 19 5.07989 19 6.2 19Z" stroke="#5F6368" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/> </g>
                    </svg>
                </span>
                <p>{{ $user->email }}</p>
            </span>
        </div>
        <div class="profile-bottom">
            <div class="tabs-nav">
                <button class="tab-btn active" data-slide="0">Order history</button>
                <button class="tab-btn" data-slide="1">Manage address</button>
            </div>
            <div class="swiper-container">
              <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                  {{-- order history --}}
                  <div class="swiper-slide">
                    <h2>Order history</h2>
                    <p>Here you can manage your order</p>
                    <div class="search-box">
                      <form action="#">
                        <label for="input-search">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                          </svg>
                        </label>
                        <input type="text" id="input-search" placeholder="Search for Order ID or Product Name">
                      </form>
                    </div>
                    @if(count($order_history) > 0)
                      <div class="product-table">
                        <table class="order-table main-table">
                          <thead>
                            <tr>
                                <th></th>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Total amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($order_history as $order)
                              <tr>
                                <td>
                                  <div class="expanded-container">
                                    <button class="expand-btn">
                                      <svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                        <g id="SVGRepo_iconCarrier"> <path d="M16.1795 3.26875C15.7889 2.87823 15.1558 2.87823 14.7652 3.26875L8.12078 9.91322C6.94952 11.0845 6.94916 12.9833 8.11996 14.155L14.6903 20.7304C15.0808 21.121 15.714 21.121 16.1045 20.7304C16.495 20.3399 16.495 19.7067 16.1045 19.3162L9.53246 12.7442C9.14194 12.3536 9.14194 11.7205 9.53246 11.33L16.1795 4.68297C16.57 4.29244 16.57 3.65928 16.1795 3.26875Z" fill="#0F0F0F"/> </g>    
                                      </svg>
                                    </button>
                                  </div>
                                </td>
                                <td>{{ $order->o_id }}</td>
                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                <td>{{ $order->orderItems->count() }}</td>
                                <td>₹{{ $order->total_amount }}</td>
                                <td>
                                  <span class="status
                                  @if($order->o_status == 'Pending') status-pending 
                                  @elseif($order->o_status == 'Processing') status-processing 
                                  @elseif($order->o_status == 'Completed') status-completed 
                                  @elseif($order->o_status == 'Cancelled') status-cancelled 
                                  @endif">{{ $order->o_status }}</span>
                                </td>
                                <td><a href="{{ url('cancelOrder/'.$order->id) }}" class="btn btn-cancel">Cancel</a></td>
                              </tr>
                              <!-- Expanded details -->
                              <tr class="details-row">
                                <td colspan="7">
                                  <div class="order-details-box">
                                    <!-- Shipping / billing info -->
                                    <table class="order-table inner">
                                      <tr>
                                        <th>Shipping address</th>
                                        <th>Name</th>
                                        <th>Phone number</th>
                                        <th>Payment method</th>
                                      </tr>
                                      <tr>
                                        <td>{{ $order->o_address }}</td>
                                        <td>{{ $order->u_name }}</td>
                                        <td>+91 {{ $order->o_phone_number }}</td>
                                        <td>{{ $order->o_payment_method }}</td>
                                      </tr>
                                    </table>
                              
                                    <!-- Product list scrollable -->
                                    <div class="product-table-wrapper">
                                      <table class="order-table product-inner-table">
                                        <thead>
                                          <tr>
                                            <th>Product</th>
                                            <th>Size</th>
                                            <th>Qty.</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          @foreach ($order->orderItems as $item)
                                            <tr>
                                              <td class="product-link-box">
                                                <div class="img-box">
                                                  @if($item->product_image)
                                                    <img src="{{ asset('images/product_images/' . $item->product_image) }}" alt="Product Image">
                                                  @else
                                                    <i class="fa-solid fa-gift order-gift"></i>
                                                  @endif
                                                </div>
                                                <p><a class="product-item-ancher" href=" {{ url('product/'.$item->product_id) }}">{{ $item->product_name }}</a></p>
                                              </td>
                                              <td>S</td>
                                              <td>{{ $item->quantity }}</td>
                                              <td>₹{{ $item->price }}</td>
                                              <td>₹{{ $item->price * $item->quantity }}</td>
                                            </tr>
                                          @endforeach
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                </td>
                              </tr> 
                            @endforeach                               
                          </tbody>
                        </table>
                      </div>
                    @else
                      <hr class="no-order-line">
                      <p class="empty-order">No product found.</p>
                    @endif
                  </div>
                  {{-- address --}}
                  <div class="swiper-slide">
                    <div class="address-head">
                      <div class="address-heading">
                        <h2>Manage address</h2>
                        <p>Here you can manage your address</p>
                      </div>
                      <a href="{{ url('/saveAddress') }}" class="add-address">Add address</a>
                    </div>
                    @if(count($addresses) > 0)
                      <div class="product-table">
                        <table class="order-table main-table">
                          <thead>
                            <tr>
                                <th>No.</th>
                                <td>Name</td>
                                <th>Mobile No.</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($addresses as $address)
                              <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $address->name }}</td>
                                <td>{{ $address->phone_number }}</td>
                                <td>{{ $address->street.', '.$address->city.', '.$address->state.' - '.$address->pin }}</td>
                                <td class="address-action">
                                  <a href="{{ url('saveAddress/'.$address->id) }}" class="btn btn-cancel">Cancel</a>
                                  <a href="{{ url('saveAddress/'.$address->id.'/edit')}}" class="btn btn-edit">Edit</a>
                                </td>
                              </tr>   
                            @endforeach                           
                          </tbody>
                        </table>
                      </div>
                    @else
                      <hr class="no-address-line">
                      <p class="no-address">No addresses found. Please add a new address.</p>
                    @endif
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/profile.js') }}"></script>
@endsection