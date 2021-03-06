@extends('layouts.app')

@section('content')

<div class="uk-container uk-container-expand">
    <form class="uk-form-stacked" action="{{ route('login') }}" method="POST">
        {{ csrf_field() }}

        <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">Email</label>
            <div class="uk-form-controls">
                <input class="uk-input" id="form-stacked-text" type="text" name="email" value="{{ old('email') }}">
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
            <a href="{{ route('password.request') }}">
            Forgot Your Password?
            </a>
        </div>

        <button class="uk-button uk-button-default uk-width-1-1 uk-margin-small-bottom">LOG IN</button>
    </form>
</div>

@endsection
