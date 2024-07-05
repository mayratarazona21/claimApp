@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')


@section('page-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/bs-stepper/bs-stepper.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />
@endsection

@section('page-script')
<script src="{{asset('assets/vendor/libs/bs-stepper/bs-stepper.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>

<script>
  var UserId = @json($user->encrypted_id);
</script>
<script src="{{asset('js/administration/user/user.js')}}"></script>
@php
    $bEdit = !empty($user->encrypted_id);
@endphp
@endsection


@section('title', 'User')

@section('content')
<div id="wizard-validation" class="bs-stepper">
  <div class="form-title mb-4" style="margin-left: 20px;">
    <br>
    <h3>{{ $title }}</h3>
  </div>
  <div class="bs-stepper-header">
    <div class="step" data-target="#account-details-validation">
      <button type="button" class="step-trigger flex-lg-wrap gap-lg-2 px-lg-0">
        <span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
        <span class="bs-stepper-label ms-lg-0">
          <span class="d-flex flex-column gap-1 text-lg-center">
            <span class="bs-stepper-title">{{ trans('accountDetails') }}</span>
            <span class="bs-stepper-subtitle">{{  trans('enterAccountDetails') }}</span>
          </span>
        </span>
      </button>
    </div>
    <div class="line mt-lg-n4 mb-lg-3"></div>
    <div class="step" data-target="#personal-info-validation">
      <button type="button" class="step-trigger flex-lg-wrap gap-lg-2 px-lg-0">
        <span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
        <span class="bs-stepper-label ms-lg-0">
          <span class="d-flex flex-column gap-1 text-lg-center">
            <span class="bs-stepper-title">{{ trans('personalInfo') }}</span>
            <span class="bs-stepper-subtitle">{{ trans('addPersonalInfo') }}</span>
          </span>
        </span>
      </button>
    </div>
    <div class="line mt-lg-n4 mb-lg-3"></div>
    <div class="step" data-target="#social-links-validation">
      <button type="button" class="step-trigger flex-lg-wrap gap-lg-2 px-lg-0">
        <span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
        <span class="bs-stepper-label ms-lg-0">
          <span class="d-flex flex-column gap-1 text-lg-center">
            <span class="bs-stepper-title">{{ trans('permissions') }}</span>
            <span class="bs-stepper-subtitle">{{ trans('permissionsSettings') }}</span>
          </span>
        </span>
      </button>
    </div>
  </div>
  <div class="bs-stepper-content">
    <form id="wizard-validation-form" onSubmit="return false">
      <!-- Account Details -->
      <div id="account-details-validation" class="content">
        <div class="row g-4">
          <div class="col-sm-6">
            <div class="form-floating form-floating-outline">
              <input type="email" name="email" id="email" class="form-control" placeholder="john.doe@email.com" value="{{ $user->email }}" />
              <label for="email">{{ trans('email') }}</label>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-floating form-floating-outline">
              <input type="email" name="confirmEmail" id="confirmEmail" class="form-control" placeholder="john.doe@email.com" value="{{ $user->email }}" />
              <label for="confirmEmail">{{ trans('confirmEmail') }}</label>
            </div>
          </div>
          @if ($bEdit)
          <div class="col-sm-12">
            <label class="switch">
              <input type="checkbox" class="switch-input" id="togglePasswordCheckbox"/>
              <span class="switch-toggle-slider">
                <span class="switch-on"></span>
                <span class="switch-off"></span>
              </span>
              <span class="switch-label">{{ trans('updatePassword') }}</span>
            </label>
          </div>
          @endif

          <div class="col-sm-6 form-password-toggle">
            <div class="input-group input-group-merge">
              <div class="form-floating form-floating-outline">
                <input type="password" id="password" name="password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" @if ($bEdit) disabled @endif  />
                <label for="password">{{  trans('password') }}</label>
              </div>
              <span class="input-group-text cursor-pointer" id="password"><i class="ri-eye-off-line"></i></span>
            </div>
          </div>
          <div class="col-sm-6 form-password-toggle">
            <div class="input-group input-group-merge">
              <div class="form-floating form-floating-outline">
                <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="confirmPassword" @if ($bEdit) disabled @endif />
                <label for="confirmPassword">{{ trans('confirmPassword') }}</label>
              </div>
              <span class="input-group-text cursor-pointer" id="confirmPassword"><i class="ri-eye-off-line"></i></span>
            </div>
          </div>
          <div class="col-12 d-flex justify-content-between">
            <button class="btn btn-outline-secondary btn-prev" disabled> <i class="ri-arrow-left-line me-sm-1 me-0"></i>
              <span class="align-middle d-sm-inline-block d-none">{{ trans('previous') }}</span>
            </button>
            <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">{{ trans('next') }}</span> <i class="ri-arrow-right-line"></i></button>
          </div>
        </div>
      </div>
      <!-- Personal Info -->
      <div id="personal-info-validation" class="content">
        <div class="row g-4">
          <div class="col-sm-6">
            <div class="form-floating form-floating-outline">
              <input type="text" id="firstName" name="firstName" class="form-control" placeholder="Claudia" value="{{ $user->first_name }}"/>
              <label for="firstName">{{ trans('firstName') }}</label>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-floating form-floating-outline">
              <input type="text" id="lastName" name="lastName" class="form-control" placeholder="Caicedo" value="{{ $user->last_name }}"/>
              <label for="lastName">{{ trans('lastName') }}</label>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-floating form-floating-outline">
              <input type="number" id="contact" name="contact" class="form-control" placeholder="0452265511" value="{{ $user->contact }}"/>
              <label for="contact">{{ trans('contact') }}</label>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-floating form-floating-outline">
              <input type="text" class="form-control" placeholder="YYYY-MM-DD" id="dateBirth" name="dateBirth" value="{{ $user->date_birth }}"/>
              <label for="dateBirth">{{ trans('dateBirth') }}</label>
            </div>
          </div>
          <div class="col-12 d-flex justify-content-between">
            <button class="btn btn-outline-secondary btn-prev"> <i class="ri-arrow-left-line me-sm-1 me-0"></i>
              <span class="align-middle d-sm-inline-block d-none">{{ trans('previous') }}</span>
            </button>
            <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">{{ trans('previous') }}</span> <i class="ri-arrow-right-line"></i></button>
          </div>
        </div>
      </div>
      <!-- Permissions -->
      <div id="social-links-validation" class="content">
        <div class="row g-4">
          <div class="col-sm-12">
            <div class="form-floating form-floating-outline">
              <div class="select2-primary">
                <select id="roles" name="roles" class="select2 form-select" multiple>
                  @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ in_array($role->id, $selectedRoles) ? 'selected' : '' }}>{{ $role->name }}</option>
                  @endforeach
                </select>
              </div>
              <label for="roles">{{ trans('roles') }}</label>
            </div>
          </div>
          <div class="col-12 d-flex justify-content-between">
            <button class="btn btn-outline-secondary btn-prev"> <i class="ri-arrow-left-line me-sm-1 me-0"></i>
              <span class="align-middle d-sm-inline-block d-none">{{ trans('previous') }}</span>
            </button>
            <button class="btn btn-primary btn-next btn-submit">Submit</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
