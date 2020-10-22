@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.commit.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.commits.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.commit.fields.id') }}
                        </th>
                        <td>
                            {{ $commit->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.commit.fields.repository') }}
                        </th>
                        <td>
                            {{ $commit->repository }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.commit.fields.avatar') }}
                        </th>
                        <td>
                            {{ $commit->avatar }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.commit.fields.login') }}
                        </th>
                        <td>
                            {{ $commit->login }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.commit.fields.message') }}
                        </th>
                        <td>
                            {{ $commit->message }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.commit.fields.commit_date') }}
                        </th>
                        <td>
                            {{ $commit->commit_date }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.commits.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection