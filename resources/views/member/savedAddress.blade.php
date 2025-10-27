@extends('masterview')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/savedAddress.css') }}">
@endsection

@section('main')
    <div class="address-main-container">
        <div class="form-container">
            <form action="{{ url('/savedAddressProfile') }}" method="post">
                @csrf
                <h3>{{ isset($address->id) ? 'Edit' : 'Add' }} Shipping Address</h3>
                <div class="input-field">
                    <input type="text" name="name" id="name" class="input" value="{{ $address->name ?? '' }}" placeholder="Full Name">
                    @error('name')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
                <div class="input-field">
                    <input type="tel" name="pnumber" id="pnumber" class="input" value="{{ $address->phone_number ?? '' }}" placeholder="Phone Number">
                    @error('pnumber')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
                <div class="input-field">
                    <input type="tel" name="pin" id="pin" class="input" value="{{ $address->pin ?? '' }}" placeholder="Pin Code">
                    @error('pin')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
                <div class="input-field">
                    <textarea name="street" id="street" cols="30" rows="5" class="input" placeholder="Address(Area and Street)">{{ $address->street ?? '' }}</textarea>
                    @error('street')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
                <div class="input-field">
                    <div>
                        <input type="text" name="city" placeholder="City/District/Town" value="{{ $address->city ?? '' }}">
                        @error('city')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <input type="text" name="state" placeholder="State" value="{{ $address->state ?? '' }}">
                        @error('state')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                @if(isset($address->id))
                    <input type="hidden" name="editAddressID" value="{{ $address->id ?? '' }}">
                @endif
                <div class="input-submit">
                    <input type="submit" value="Submit">
                </div>
            </form>
        </div>
        <div class="image-box">
            <img src="{{ asset('images/background/address.jpg') }}" alt="Simple Image">
        </div>
    </div>
@endsection

@section('scripts')
@endsection