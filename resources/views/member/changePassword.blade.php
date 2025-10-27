@extends('masterview')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/changePassword.css') }}">
@endsection

@section('main')
    <div class="change-password-main-container">
        <p class="profile-back">
            <a href="{{ url('/profile') }}"><span><i class="fa-solid fa-arrow-left"></i></span> Profile</a>
        </p>
        <div class="change-password-inner">
            <div class="form-container">
                <h2>Change Password</h2>
                <form action="{{ url('/changePasswordProfile') }}" method="post">
                    @csrf
                    <div class="input-field">
                        <input type="text" name="oldpass" id="oldpass" class="input" value="{{ old('oldpass') }}" placeholder="Old Password">
                        @error('oldpass')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="input-field">
                        <input type="password" name="newpass" id="newpass" class="input" value="{{ old('newpass') }}" placeholder="New Password">
                        @error('newpass')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="input-field">
                        <input type="password" name="cpass" id="cpass" class="input" value="{{ old('cpass') }}" placeholder="Confirm Password">
                        @error('cpass')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="input-submit">
                        <input type="submit" value="Submit">
                    </div>
                </form>
            </div>
            <div class="image-box">
                <img src="{{ asset('images/background/changePassword.jpg') }}" alt="Simple Image" class="change-password-image">
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection