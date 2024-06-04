@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Roles - Apps')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>

<script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
@endsection


@section('content')
<div class="row">
  <div class="col-md-6">
      <h4 class="mb-1">{{ trans('rolesList') }}</h4>
  </div>
  <div class="col-md-6 text-end">
      <a href="{{ url('/rol/create') }}"><button class="btn btn-primary">{{ trans('addNewRol') }}</button></a>
  </div>
</div>
<br>

<div class="row">
  <div class="col-12">
    <div class="card-datatable table-responsive pt-0">
      <table class="datatables-basic table table-bordered">
        <thead>
        </thead>
      </table>
    </div>
  </div>
</div>

@endsection

<script>
  var roles = @json($roles);
</script>
@section('page-script')
<script src="{{asset('js/administration/roles/app-access-roles.js')}}"></script>
@endsection
