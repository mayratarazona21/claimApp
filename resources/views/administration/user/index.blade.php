@extends('layouts/layoutMaster')

@section('title', 'User Management - Crud App')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">

<link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />

@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>

<script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>

@endsection
<script>

  var permissionCreate = {{ auth()->user()->can('create users') ? 'true' : 'false' }}
  var permissionEdit = {{ auth()->user()->can('update users') ? 'true' : 'false' }}
  var permissionDelete = {{ auth()->user()->can('delete users') ? 'true' : 'false' }}

</script>
@section('page-script')
<script src="{{asset('js/administration/user/user-management.js')}}"></script>
@endsection

@section('content')

<!-- Users List Table -->
<div class="card">
  <div class="card-header">
    <h5 class="card-title mb-0">Users</h5>
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables-users table table-bordered">
      <thead class="table-light">
        <tr>
          <th></th>
          <th>{{ trans('user') }}</th>
          <th>{{ trans('email') }}</th>
          <th>{{ trans('contact') }}</th>
          <th>{{ trans('dateBirth') }}</th>
          <th>{{ trans('roles') }}</th>
          <th>{{ trans('status') }}</th>
          <th>{{ trans('actions') }}</th>
        </tr>
      </thead>
    </table>
  </div>

</div>
@endsection
