@extends('layouts/layoutMaster')

@section('title', 'DataTables - Tables')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<!-- Row Group CSS -->
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css')}}">
<!-- Form Validation -->
<link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<!-- Flat Picker -->
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
@endsection

<script>
  var roles = @json($roles);
  var permissionCreate = {{ auth()->user()->can('create roles') ? 'true' : 'false' }}
  var permissionEdit = {{ auth()->user()->can('update roles') ? 'true' : 'false' }}
  var permissionDelete = {{ auth()->user()->can('delete roles') ? 'true' : 'false' }}

</script>
@section('page-script')
<script src="{{asset('js/administration/roles/app-access-roles.js')}}"></script>
@endsection

@section('content')

<!-- DataTable with Buttons -->
<div class="card">
  <div class="card-header">
    <h5 class="card-title mb-0">{{ trans('roles') }}</h5>
  </div>
  <div class="card-datatable table-responsive text-nowrap">
    <table class="datatables-roles table table-bordered">
      <thead class="table-light">
        <tr class="text-nowrap">
          <th>{{ trans('role') }}</th>
          <th>{{ trans('creationDate') }}</th>
          <th>{{ trans('status') }}</th>
          <th>{{ trans('actions') }}</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

@endsection
