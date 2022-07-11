@extends('auth.layouts.app')

@section('content')

    <div class="row flex-center min-vh-100 py-6">
        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4 position-relative">
            <a class="d-flex flex-center mb-4" href="{{ route("home") }}">
                <img class="me-2" src="{{ asset("images/logo.png") }}" alt="" width="100"/>
            </a>
            <img class="bg-auth-circle-shape" src="{{ asset('images/icons/spot-illustrations/bg-shape.png') }}" alt=""
                 width="250">
            <img class="bg-auth-circle-shape-2" src="{{ asset('images/icons/spot-illustrations/shape-1.png') }}" alt=""
                 width="150">
            <div class="card">
                <div class="card-body p-4 p-sm-5">
                    <div class="row flex-between-center mb-2">
                        <div class="col-auto">
                            <h5>Sign In</h5>
                        </div>
                    </div>
                    <form id="sign-in">
                        <div class="mb-3">
                            <input class="form-control" type="email" name="email" value="{{ old('email') }}"
                                   placeholder="Email address" aria-label required/>
                        </div>
                        <div class="mb-3">
                            <input class="form-control" type="password" name="password" placeholder="Password"
                                   aria-label required/>
                        </div>
                        <div class="row flex-between-center">
                            <div class="col-auto">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="checkbox" id="basic-checkbox"
                                           checked="checked"/>
                                    <label class="form-check-label mb-0" for="basic-checkbox">Remember me</label></div>
                            </div>
                            <div class="col-auto">
                                @if (Route::has('password.request'))
                                    <a class="fs--1" href="{{ route('password.request') }}">Forgot Password?</a>
                                @endif
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="col btn btn-sm btn-primary ld-ext-right">
                                Sign In <i class="fas fa-key"></i><span class="ld ld-ring ld-spin"></span>
                            </button>
                        </div>
                    </form>
                    <div class="position-relative mt-4">
                        <hr class="bg-300"/>
                        <div class="divider-content-center">🌟</div>
                    </div>
                    <div class="text-center">
                        <i>
                            <small class="opacity-75">{{ config('services.sidooh.tagline') }}</small>
                        </i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const form = $('#sign-in');

            form.on('submit', (e) => e.preventDefault());

            form.validate({
                rules: {
                    email: {
                        pattern: emailRegex,
                        required: true
                    },
                    password: 'required'
                },
                messages: {
                    email: {
                        required: 'Email address is required.',
                        pattern: 'Invalid email address.',
                    },
                    password: 'Password is required.',
                },
                submitHandler: async form => {
                    const submitButton = $(form).find($('button[type="submit"]'));
                    submitButton.prop('disabled', true).html(`Signing In...
										<span class="ld ld-ring ld-spin"></span>`).addClass('running');

                    const userData = {};
                    $(form).serializeArray().map(input => userData[input.name] = input.value);

                    try {
                        const API_URL = '{{ config('services.sidooh.services.accounts.api.url') }}/users/signin';
                        let {data} = await axios.post(API_URL, userData);

                        const auth = {
                            token: data.access_token,
                            user: JWT.decode(data.access_token),
                            credentials: userData
                        };

                        let {data: sessionIsSet} = await axios.post('/login', auth);

                        if (!sessionIsSet) {
                            return toast({
                                msg: "Unable to authenticate!",
                                type: 'danger',
                                duration: 10,
                                position: 'left'
                            });
                        }

                        location.href = '{{ route("admin.index") }}'
                    } catch (err) {
                        const message = err.response?.data?.errors?.message ||
                            (err.response && err.response.data && err.response.data.message) ||
                            err.message || err.toString();

                        toast({msg: message, type: 'warning', duration: 10, position: 'left'});

                        submitButton.prop('disabled', false).html(`Sign In
										<span class="ld ld-ring ld-spin"></span>`).removeClass('running');
                    }
                }
            });
        </script>
    @endpush
@endsection
