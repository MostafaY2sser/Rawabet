@extends('provider.layouts.auth')
@section('title')
    التحقق من الرمز
@endsection

@section('content')
    <div class="auth_page">
        <div class="wrapper login">
            <div class="logo">
                <img src="{{ asset('assets/images/auth/logo_auth.png') }}" alt="">
            </div>

            <div class="form_box">
                <form action="{{ route('provider.password.verify') }}" method="POST">
                    @csrf
                    <h2>التحقق من الرمز</h2>
                    <p class="welcome_back">أدخل رمز التحقق المرسل إلى بريدك الإلكتروني.</p>

                    @if($errors->any())
                        <div class="input_error">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="input_error" style="background: #ecfdf3; color: #047857;">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <div class="input_group">
                        <label for="code">رمز التحقق</label>
                        <input type="text" name="code" id="code" maxlength="6" required>
                    </div>

                    <button type="submit">تأكيد الرمز</button>
                </form>

                <form action="{{ route('provider.password.resend') }}" method="POST" style="margin-top: 10px;">
                    @csrf
                    <button type="submit" id="providerResendCodeBtn" {{ ($remainingSeconds ?? 0) > 0 ? 'disabled' : '' }}>
                        إعادة إرسال الرمز
                    </button>
                </form>
                <p id="providerResendTimerText" style="margin-top: 8px; color: #6b7280; {{ ($remainingSeconds ?? 0) > 0 ? '' : 'display:none;' }}">
                    يمكنك إعادة الإرسال خلال <span id="providerResendCountdown">{{ $remainingSeconds ?? 0 }}</span> ثانية
                </p>
            </div>
        </div>
        <img src="{{ asset('assets/images/auth/bg_auth.png') }}" alt="" class="bg_auth d-none d-lg-block">
    </div>

    <script>
        (function() {
            let remaining = Number("{{ $remainingSeconds ?? 0 }}");
            const resendBtn = document.getElementById('providerResendCodeBtn');
            const timerText = document.getElementById('providerResendTimerText');
            const countdown = document.getElementById('providerResendCountdown');

            if (!resendBtn || !timerText || !countdown || remaining <= 0) return;

            const interval = setInterval(() => {
                remaining -= 1;
                countdown.textContent = remaining;

                if (remaining <= 0) {
                    clearInterval(interval);
                    resendBtn.removeAttribute('disabled');
                    timerText.style.display = 'none';
                }
            }, 1000);
        })();
    </script>
@endsection
