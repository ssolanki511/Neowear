@if(session('error'))
    <div class="error-box error" id="errorBox">
        <p>{{ session('error') }}</p>
    </div>
    <script>
        setTimeout(function(){
            var errorBox = document.getElementById('errorBox');
            if(errorBox) errorBox.style.display = 'none';
        }, 3000);
    </script>
@endif
@if(session('success'))
    <div class="error-box success" id="successBox">
        <p>{{ session('success') }}</p>
    </div>
    <script>
        setTimeout(function(){
            var successBox = document.getElementById('successBox');
            if(successBox) successBox.style.display = 'none';
        }, 3000);
    </script>
@endif
