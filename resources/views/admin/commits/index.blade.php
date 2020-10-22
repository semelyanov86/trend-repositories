@extends('layouts.admin')
@section('content')
@can('commit_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.commits.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.commit.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.commit.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Commit">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.commit.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.commit.fields.repository') }}
                        </th>
                        <th>
                            {{ trans('cruds.commit.fields.avatar') }}
                        </th>
                        <th>
                            {{ trans('cruds.commit.fields.login') }}
                        </th>
                        <th>
                            {{ trans('cruds.commit.fields.message') }}
                        </th>
                        <th>
                            {{ trans('cruds.commit.fields.commit_date') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($commits as $key => $commit)
                        <tr data-entry-id="{{ $commit->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $commit->id ?? '' }}
                            </td>
                            <td>
                                {{ $commit->repository ?? '' }}
                            </td>
                            <td>
                                {{ $commit->avatar ?? '' }}
                            </td>
                            <td>
                                {{ $commit->login ?? '' }}
                            </td>
                            <td>
                                {{ $commit->message ?? '' }}
                            </td>
                            <td>
                                {{ $commit->commit_date ?? '' }}
                            </td>
                            <td>
                                @can('commit_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.commits.show', $commit->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('commit_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.commits.edit', $commit->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('commit_delete')
                                    <form action="{{ route('admin.commits.destroy', $commit->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('commit_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.commits.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Commit:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection