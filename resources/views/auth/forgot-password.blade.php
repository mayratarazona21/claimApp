@php
$configData = Helper::appClasses();
$customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Forgot Password')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/css/pages/page-auth.css')) }}">
@endsection

@section('content')
<div class="authentication-wrapper authentication-basic container-p-y">
  <div class="authentication-inner py-4">

    <!-- Forgot Password -->
    <div class="card p-2">

        <!-- Logo -->
        <div class="app-brand justify-content-center mt-5">
          <a href="{{url('/')}}" class="app-brand-link gap-2">
            <span class="app-brand-logo demo">@include('_partials.macros',["height"=>20])</span>
            <span class="app-brand-text demo text-heading fw-semibold">{{ config('variables.templateName') }}</span>
          </a>
        </div>
        <!-- /Logo -->

        <div class="card-body mt-2">
          <h4 class="mb-2">{{ trans('forgotPassword') }} 🔒</h4>
          <p class="mb-4">{{ trans('textForgorPassword') }}</p>

          @if (session('status'))
          <div class="mb-1 text-success">
            {{ session('status') }}
          </div>
          @endif

          <form id="formAuthentication" class="mb-3" action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">{{ trans('email') }}</label>
              <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="john@example.com" autofocus>
              @error('email')
              <span class="invalid-feedback" role="alert">
                <span class="fw-medium">{{ $message }}</span>
              </span>
              @enderror
            </div>
            <button type="submit" class="btn btn-primary d-grid w-100">{{ trans('sendResetLink') }}</button>
          </form>
          <div class="text-center">
            @if (Route::has('login'))
            <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
              <i class="bx bx-chevron-left scaleX-n1-rtl"></i>
              {{ trans('backToLogin') }}
            </a>
            @endif
          </div>

        </div>
    </div>
    <!-- /Forgot Password -->
  </div>
</div>
@endsection
