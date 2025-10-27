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
                <h2>Edit Profile</h2>
                <form action="{{ url('/editProfileSubmit') }}" method="post">
                    @csrf
                    <div class="input-field">
                        <input type="text" name="username" class="input" placeholder="Username" value="{{ $user->username ?? "" }}">
                        @error('username')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="input-field">
                        <input type="email" name="email" class="input" value="{{ $user->email ?? "" }}" placeholder="Email">
                        @error('email')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="input-submit">
                        <input type="submit" value="Submit">
                    </div>
                </form>
            </div>
            <div class="image-box">
                <img src="{{ asset('images/background/edit_profile.png') }}" alt="Simple Image" class="edit-password-image">
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection