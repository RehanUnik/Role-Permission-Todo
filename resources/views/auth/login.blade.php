@include('csslink')
<link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                        <div class="brand-logo">
                            <img src="{{ asset('images/logo.svg') }}" alt="logo">
                        </div>
                        <!-- <x-auth-session-status class="mb-4" :status="session('status')" /> -->

                        <h4>Hello! let's get started</h4>
                        <h6 class="font-weight-light">Sign in to continue.</h6>
                        <form method="POST" action="{{ route('login') }}" class="pt-3">
                            @csrf

                            <!-- Email Address -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="exampleInputEmail1" class="form-control form-control-lg" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                            </div>

                            <!-- Password -->
                            <div class="mt-4">
                                <x-input-label for="password" :value="__('Password')" />

                                <x-text-input id="exampleInputPassword1" class="form-control form-control-lg" type="password" name="password" required autocomplete="current-password" />

                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                            </div>

                            <div class="flex items-center justify-end mt-4">

                                <x-primary-button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                                    {{ __('Log in') }}
                                </x-primary-button>
                            </div>

                        </form>
                        <div class="text-center mt-4 font-weight-light">
                            Don't have an account? <a href="{{route('register')}}" class="text-primary">Create</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('jslinks')