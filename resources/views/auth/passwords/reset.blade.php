@extends('layouts.app')

@section('content')

<div class="uk-container uk-container-expand">
    @if (session('status'))
        <div class="uk-alert-success" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p>{{ session('status') }}</p>
        </div>
    @endif

    <form class="uk-form-stacked" action="{{ route('password.request') }}" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">Email</label>
            <div class="uk-form-controls">
                <input class="uk-input" id="form-stacked-text" type="text" name="email" value="{{ $email or old('email') }}">
                @if ($errors->has('email'))
                    <div class="uk-alert-danger" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p>{{ $errors->first('email') }}</p>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">Password</label>
            <div class="uk-form-controls">
                <input class="uk-input" id="form-stacked-text" type="password" name="password" value="{{ old('password') }}">
                @if ($errors->has('password'))
                    <div class="uk-alert-danger" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p>{{ $errors->first('password') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">Confirm password</label>
            <div class="uk-form-controls">
                <input class="uk-input" id="form-stacked-text" type="password" name="password_confirmation" value="{{ old('password_confirmation') }}">
                @if ($errors->has('password_confirmation'))
                    <div class="uk-alert-danger" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p>{{ $errors->first('password_confirmation') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <button class="uk-button uk-button-default uk-width-1-1 uk-margin-small-bottom">Reset Password</button>
    </form>
</div>

@endsection
