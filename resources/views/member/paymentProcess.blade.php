@extends('masterview')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/paymentProcess.css') }}">
@endsection

@section('main')
    <div class="paymentProcess-container">
        <div class="payment-loader">
            <div class="pad">
                <div class="chip"></div>
                <div class="line line1"></div>
                <div class="line line2"></div>
            </div>
            <div class="loader-text">
                Please wait while payment is loading
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        window.onload = function() {
            setTimeout(() => {

                var options = {
                    "key": "{{ env('RAZORPAY_KEY_ID') }}", // Enter the Key ID generated from the Dashboard
                    "amount": "{{ $amountInPaise }}", // Amount is in currency subunits. 
                    "currency": "INR",
                    "name": "Neowear", //your business name
                    "description": "Luxery Fashion",
                    "callback_url": "{{ route('member.razorpayCallback') }}",
                    "order_id": "{{ $razorpayOrderId }}", // This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                    "prefill": { //We recommend using the prefill parameter to auto-fill customer's contact information especially their phone number
                        "name": "{{ $paymentData['name'] }}", //your customer's name
                        "email": "{{ $paymentData['email'] }}",
                        "contact": "+91{{ $paymentData['pnumber'] }}" //Provide the customer's phone number for better conversion rates
                    },
                    "notes": {
                        'address': 'Neowear Corporate Office',
                    },
                    "theme": {
                        "color": "#3399cc"
                    },
                    "modal": {
                        "ondismiss": function() {
                            alert("You closed the payment window. Payment was not completed.");
                            window.location.href = "{{ route('member.profile') }}";
                        }
                    }
                };
                var rzp1 = new Razorpay(options);

                rzp1.open();
            }, 3000);
        };
    </script>
@endsection