@extends('masterview')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('main')
    <div class="contact-main-container">
        <div class="form-container">
            <h2>Get In Touch</h2>
            @if(isset($contact))
                <div class="contact-info">
                    <div class="numbers">
                        <p>+91 {{ $contact->consulting_phone ?? "" }} - Consulting</p>
                        <p>+91 {{ $contact->report_phone ?? "" }} - Report</p>
                    </div>
                    <div class="address">
                        <p>{{ $contact->address ?? "" }}</p>
                    </div>
                </div>
            @endif
            <form action="{{ url('/contactSubmit') }}" method="post">
                @csrf
                <div class="input-field">
                    <input type="email" name="email" id="email" class="input" value="{{ old('email') }}" placeholder="Email">
                    @error('email')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
                <div class="input-field">
                    <textarea name="message" id="message" cols="30" rows="5" class="input" value="{{ old('message') }}" placeholder="Message..."></textarea>
                    @error('message')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>
                <div class="input-submit">
                    <input type="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/contact.js') }}"></script>
@endsection