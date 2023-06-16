<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper d-flex justify-content-center">
                <div class="login-content">
                    <div class="login-userset">
                        <div class="d-flex justify-content-center">
                            <div class="login-logo logo-normal">
                                <img src="assets/img/logo.png" alt="img">
                            </div>
                        </div>
                        <a href="index.html" class="login-logo logo-white">
                            <img src="assets/img/logo-white.png"  alt="">
                        </a>
                        <div class="login-userheading">
                            <h3 class="mb-0 fw-bold">Sign In</h3>
                            <h4>Please login to your account</h4>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-login">
                                <label>Email</label>
                                <div class="form-addons">
                                    <input type="text" placeholder="Enter your email address" name="email" required autofocus >
                                    <img src="assets/img/icons/mail.svg" alt="img">
                                </div>
                            </div>
                            <div class="form-login">
                                <label>Password</label>
                                <div class="pass-group">
                                    <input type="password" class="pass-input" placeholder="Enter your password" name="password">
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                            </div>
                            <div class="form-login">
                                <button type="submit" class="btn btn-login" href="index.html">Sign In</button>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- <div class="login-img">
                    <img src="assets/img/header-login.jpg" style="object-fit: cover; transform: scaleX(-1);"  alt="">
                </div> --}}
            </div>
        </div>
    </div>
</x-guest-layout>
