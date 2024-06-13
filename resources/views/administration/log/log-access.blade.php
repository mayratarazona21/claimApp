@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')


@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
@endsection
@section('vendor-script')
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
@endsection

@section('content')
<div class="container">
  <h3>{{ trans('log-access') }}</h3>
  <div class="card-datatable table-responsive text-nowrap">
    <table class="datatable-log table table-bordered">
      <thead class="table-light">
        <tr class="text-nowrap">
          <th>{{ trans('user') }}</th>
          <th>{{ trans('details') }}</th>
          <th>{{ trans('actions') }}</th>
        </tr>
      </thead>
    </table>
  </div>

</div>
@endsection
@section('page-script')
<script>

$(function () {

  var dt_roles = $('.datatable-log');
  var logs = @json($logs);

  var dt_user = dt_roles.DataTable({
      data: logs,
      columns: [
        { data: 'user' },
        { data: 'details',
          render: function (row) {
            return row.substring(1, 70)+'...';
          }
        },
        { title: oLang.actions,
          render: function (data, type, row, meta) {

            return '<a href="javascript:;" class="btn btn-sm btn-text-secondary rounded-pill btn-icon view-log" attr-id="' +
              row.id +
              '" data-toggle="tooltip" title="' +
              oLang.view +
              '"><i class="ri-eye-line"></i></a>';
          }
        }
      ],
      order: [[1, 'desc']]
    });

})

$(document).on('click', '.view-log', function () {
    var id = $(this).attr('attr-id');
    location.href = baseUrl + 'administration/log-details/' + id;
});
</script>
@endsection
