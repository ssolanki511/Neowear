<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NeoWear - Reset Password</title>
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <style>
        .container .box{
            height: 80%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0px 60px;
            margin-top: 30px;
        }
        .container .form-container{
            max-width: 420px;
            width: 100%;
            background-color: white;
            border-radius: 10px;
            padding: 20px 30px;
            text-align: center;
            font-family: 'Helvetica Mow Text',sans-serif;
        }
        .form-container h3{
            font-weight: 800;
            font-size: 34px;
        }
        .input-box .input-field{
            width: 95%;
            margin-top: 40px;
            position: relative;
        }
        .form-container .input-submit input{
            margin-top: 7px;
        }
        @media (max-width: 740px) {
            .form-container h3{
                font-size: 30px;
            }
        }
        @media (max-width: 460px) {
            .form-container h3{
                font-size: 27px;
            }
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
            <div class="form-container">
                <form action="{{ url('resetPasswordSubmit') }}" method="post">
                    @csrf
                    <h3>Reset Password</h3>
                    <div class="input-field">
                        <input type="text" name="password" id="pass" value="{{ old('password') }}" class="input">
                        <label for="pass">Password</label>
                        @error('password')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="input-field">
                        <input type="text" name="c_password" id="c-pass" value="{{ old('c_password') }}" class="input">
                        <label for="c-pass">Confirm Password</label>
                        @error('c_password')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>
                    <input type="hidden" name="email" value="{{ session('email') }}">
                    <div class="input-submit">
                        <input type="submit" value="Continue">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/form.js') }}"></script>
</body>
</html>