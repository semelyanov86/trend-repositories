@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.commit.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.commits.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="repository">{{ trans('cruds.commit.fields.repository') }}</label>
                <input class="form-control {{ $errors->has('repository') ? 'is-invalid' : '' }}" type="text" name="repository" id="repository" value="{{ old('repository', '') }}">
                @if($errors->has('repository'))
                    <div class="invalid-feedback">
                        {{ $errors->first('repository') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.commit.fields.repository_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="avatar">{{ trans('cruds.commit.fields.avatar') }}</label>
                <input class="form-control {{ $errors->has('avatar') ? 'is-invalid' : '' }}" type="text" name="avatar" id="avatar" value="{{ old('avatar', '') }}">
                @if($errors->has('avatar'))
                    <div class="invalid-feedback">
                        {{ $errors->first('avatar') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.commit.fields.avatar_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="login">{{ trans('cruds.commit.fields.login') }}</label>
                <input class="form-control {{ $errors->has('login') ? 'is-invalid' : '' }}" type="text" name="login" id="login" value="{{ old('login', '') }}">
                @if($errors->has('login'))
                    <div class="invalid-feedback">
                        {{ $errors->first('login') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.commit.fields.login_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="message">{{ trans('cruds.commit.fields.message') }}</label>
                <input class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" type="text" name="message" id="message" value="{{ old('message', '') }}">
                @if($errors->has('message'))
                    <div class="invalid-feedback">
                        {{ $errors->first('message') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.commit.fields.message_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="commit_date">{{ trans('cruds.commit.fields.commit_date') }}</label>
                <input class="form-control datetime {{ $errors->has('commit_date') ? 'is-invalid' : '' }}" type="text" name="commit_date" id="commit_date" value="{{ old('commit_date') }}">
                @if($errors->has('commit_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('commit_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.commit.fields.commit_date_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection