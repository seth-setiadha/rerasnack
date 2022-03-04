@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">            
        
            <div class="d-flex align-items-center p-3 mb-3 bg-light p-2 text-dark bg-opacity-25 rounded shadow-sm">
                <div class="me-auto">
                    <h3 class="mb-0 lh-1">{{ __('Reset Password') }}</h3>
                </div>
                <div class="ms-auto">                    
                </div>
            </div>
            
            <x-alert-component />
                
                <div class="p-3 my-3 bg-white p-2 text-dark bg-opacity-50 rounded shadow-sm">
                    
                    <form method="POST" action="{{ route('users.reset') }}">
                        @csrf


                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-secondary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            
            
        </div>
    </div>
</div>
@endsection
