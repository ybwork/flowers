@extends('layouts.app')

@section('content')
    <div class="uk-container uk-container-expand">
        <form class="uk-padding" action="{{ route('subcategory_create') }}" method="POST">
            @if(Session::has('message'))
                <div class="uk-alert-success" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p>{{ Session::get('message') }}</p>
                </div>
            @endif

            @foreach($errors->all() as $error)
                <div class="uk-alert-danger" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p>{{ $error }}</p>
                </div>
            @endforeach

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <fieldset class="uk-fieldset">
                <div class="uk-margin">
                    <input class="uk-input" type="text" name="name" value="{{ old('name') }}" placeholder="Name">
                </div>
                <div class="uk-margin">
                    <select name="categories[]" class="subcat-select js-example-basic-multiple" multiple="multiple">
                        @if(count($categories) > 0)
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </fieldset>
            <button class="uk-button uk-button-default uk-width-1-1 uk-margin-small-bottom">Add</button>
        </form>

        @if(count($subcategories) > 0)
            <table class="uk-table uk-table-hover uk-table-divider">
                <thead>
                    <tr>
                        <th>Subcategory</th>
                        <th>Parent categories</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subcategories as $subcats)
                        <tr>
                            <td>{{ $subcats->name }}</td>
                            <td>
                                {{ preg_replace('/[0-9]+/', '', $subcats->categories) }}
                            </td>
                            <td>
                            <a href="{{ route('subcategory_edit', ['id' => $subcats->id]) }}" uk-icon="icon: pencil"></a>

                            <form class="table-action-btn" action="{{ route('subcategory_delete') }}" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" value="{{ $subcats->id }}">
                                <button type="submit" uk-icon="icon: trash"></button>
                            </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection