<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NeoWear - Sign Up</title>
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <style>
        .container .signup-heading h1{
            width: 80%;
            color: white;
            font-family: "Helvetica Mow Text",sans-serif;
            font-size: 4.5vw;
        }
        .container .form-container{
            max-width: 400px;
            width: 100%;
            background-color: white;
            border-radius: 10px;
            padding: 20px 30px;
        }
        .form-container h3{
            font-family: 'Helvetica Mow Text',sans-serif;
            font-weight: 800;
            font-size: 4vw;
            margin-bottom: 20px;
        }
        .account-check{
            font-family: 'Helvetica Mow Text';
            font-size: 11px;
            font-weight: 650;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            justify-content: start;
            gap: 0px 4px;
            margin-top: 15px;
        }
        .account-check a{
            text-decoration: none;
            color: rgb(10, 128, 61);
        }
        .account-check a:hover{
            text-decoration: underline;
        }
        @media (max-width: 740px) {
            .form-container h3{
                font-size: 35px;
            }
            .signup-heading{
                display: none;
            }
            .container .box{
                justify-content: center;
                align-content: center;
            }
        }
        @media (max-width: 460px) {
            .container .logo-box{
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
            }
            .container .box{
                padding: 0px;
            }
        }
    </style>
</head>
<body>
    @include('alert')
    <div class="container">
        <div class="logo-box">
            <a href="{{ url('/index') }}">
                <div class="logo-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"> <path d="M415.4 512h-95.1L212.1 357.5v91.1L125.7 512H28V29.8L68.5 0h108.1l123.7 176.1V63.5L386.7 0h97.7v461.5zM38.8 35.3V496l72-52.9V194l215.5 307.6h84.8l52.4-38.2h-78.3L69 13zm82.5 466.6l80-58.8v-101l-79.8-114.4v220.9L49 501.9h72.3zM80.6 10.8l310.6 442.6h82.4V10.8h-79.8v317.6L170.9 10.8zM311 191.7l72 102.8V15.9l-72 53v122.7z"/></svg>
                    <div class="logo-name">
                        <p>neowear</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="box">
            <div class="signup-heading">
                <h1>Where luxury meets your lifestyle.</h1>
            </div>
            <div class="form-container">
                <form action="{{ Route('guest.signUpSubmit') }}" method="post">
                    @csrf
                    <h3>Sign up</h3>
                    <div class="input-field">
                        <input type="text" name="username" id="uname" value="{{ old('username') }}" class="input">
                        <label for="uname">Username</label>
                        @error('username')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="input-field">
                        <input type="text" name="email" id="email" value="{{ old('email') }}" class="input">
                        <label for="email">Email</label>
                        @error('email')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="input-field">
                        <input type="password" name="password" id="pass" value="{{ old('password') }}" class="input">
                        <label for="pass">Password</label>
                        @error('password')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="input-field">
                        <input type="password" name="c_password" id="c-pass" value="{{ old('c_password') }}" class="input">
                        <label for="c-pass">Confirm Password</label>
                        @error('c_password')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="input-submit">
                        <input type="submit" value="Continue">
                    </div>
                    <div class="account-check">
                        <p>Already Have An Account?</p>
                        <a href="{{ url('/signin') }}">Sign In</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/form.js') }}"></script>
</body>
</html>