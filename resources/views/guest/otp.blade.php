<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NeoWear - Email Verification</title>
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('css/otp.css') }}">
    <style>
        .error-msg{
            font-family: "Helvetica Mow Text",sans-serif;
            color: red;
            font-size: 14px;
            margin-top: 1px;
            text-align: start;
        }
        .error-box{
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: white;
            font-family: "Neue Montreal", sans-serif;
            font-weight: bold;
            border-radius: 8px;
            padding: 4px 12px;
        }
        .success{
            color: green;
        }
        .error{
            color: red;
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
                <form action="{{ url('/OTPSubmit') }}" method="post">
                    @csrf
                    <h3>Verify Your Email</h3>
                    <p>Enter code we've send to your email <br> {{ session('email') }}</p>
                    <div class="otp-field">
                        <input type="number" name="otp[]" class="otp-input" class="input">
                        <input type="number" name="otp[]" class="otp-input" class="input">
                        <input type="number" name="otp[]" class="otp-input" class="input">
                        <input type="number" name="otp[]" class="otp-input" class="input">
                    </div>
                    <input type="hidden" name="email" value="{{ session('email') }}">
                    @error('otp.*')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                    <div class="input-submit">
                        <input type="submit" value="Continue">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const otp = document.querySelectorAll('.otp-field .otp-input');
        if(otp.length > 0){
            otp[0].focus();
            otp.forEach((field, index) => {
                field.addEventListener('keydown',(e) => {
                    if(e.key >= 0 && e.key <= 9){
                        otp[index].value = "";
                        setTimeout(() => {
                            otp[index+1].focus();
                        }, 4)
                    }
                    else if(e.key === 'Backspace'){
                        setTimeout(() => {
                            otp[index-1].focus();
                        }, 4)
                    }
                });
            });
        }

        document.querySelectorAll('.input').forEach(input => {

        function activate() {
            input.classList.add('edit');
        }
        function deactivate() {
            if (!input.value) {
            input.classList.remove('edit');
            }
        }

        // On page load, check if input has value (for autofill)
        if (input.value) activate();

        input.addEventListener('focus', activate);
        input.addEventListener('blur', deactivate);
        input.addEventListener('input', () => {
            if (input.value) {
            activate();
            } else {
            deactivate();
            }
        });
        });
    </script>
</body>
</html>