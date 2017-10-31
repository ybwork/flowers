@extends('layouts.app')

@section('content')

<div class="uk-container uk-container-expand">
    <form class="uk-form-stacked" action="{{ route('register') }}" method="POST">
    {{ csrf_field() }}
        <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">Name</label>
            <div class="uk-form-controls">
                <input class="uk-input" id="form-stacked-text" type="text" name="name" value="{{ old('name') }}">
                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">Phone</label>
            <div class="uk-form-controls">
                <input class="uk-input" id="form-stacked-text" type="text" name="phone" value="{{ old('phone') }}">
                @if ($errors->has('phone'))
                    <span class="help-block">
                        <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">Email</label>
            <div class="uk-form-controls">
                <input class="uk-input" id="form-stacked-text" type="text" name="email" value="{{ old('email') }}">
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">Password</label>
            <div class="uk-form-controls">
                <input class="uk-input" id="form-stacked-text" type="password" name="password" value="{{ old('password') }}">
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">Confirm password</label>
            <div class="uk-form-controls">
                <input class="uk-input" id="form-stacked-text" type="password" name="password_confirmation" value="{{ old('password_confirmation') }}">
                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <button class="uk-button uk-button-default uk-width-1-1 uk-margin-small-bottom">SING UP</button>
    </form>
</div>

@endsection
