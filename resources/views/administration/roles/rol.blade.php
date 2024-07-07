@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Add New Rol')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('js/administration/roles/role.js')}}"></script>
@endsection

@section('content')

@php
    $viewOnly = $flag == 'view';
@endphp


  <div class="row">
    <div class="col-12">
      <div class="mb-4">
        <h3 class="role-title mb-2 pb-0">{{ $title }}</h3>

      </div>
      <!-- Add role form -->
      <form id="roleForm" class="row g-3" >

        <div class="col-12 mb-4">
          <div class="form-floating form-floating-outline">
            <input type="text" id="roleName" name="roleName" class="form-control" placeholder="Enter a role name" tabindex="-1" value="{{ $rol->name }}" @disabled($viewOnly)/>
            <label for="roleName">{{ trans('roleName') }}</label>
          </div>
        </div>
        <div class="col-12">
          <h5>{{ trans('rolePermissions') }}</h5>
          <div class="form-check form-check-primary mt-4">
            <input class="form-check-input" type="checkbox" value="" id="selectAll" {{ $bAdministratorAccess ? 'checked' : '' }} @disabled($viewOnly)/>
            <label class="form-check-label" for="selectAll">{{ trans('administratorAccess') }}<i class="mdi mdi-information-outline" data-bs-toggle="tooltip" data-bs-placement="top" title="Allows a full access to the system" ></i></label>
          </div>

          <!-- Permission table -->
          <div class="row">
            <div class="col-md-4 col-12 mb-4 mb-md-0">
              <div class="list-group">
                @foreach ($menuList as $key => $oMenu)
                  <a class="list-group-item list-group-item-action {{ $oMenu->id == 1 ? 'active': '' }}" id="list-{{$oMenu->name}}-list" data-bs-toggle="list" href="#list-{{$oMenu->name}}">{{ trans($oMenu->name) }}</a>
                @endforeach
              </div>
            </div>
            <div class="col-md-8 col-12">
              <div class="tab-content" style="padding: 0">
                @foreach ($menuList as $key => $oMenu)
                <div class="tab-pane fade {{ $oMenu->id == 1 ? 'show active': '' }}" id="list-{{$oMenu->name}}">
                  <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>{{ trans('module') }}</th>
                          <th>{{ trans('view') }}</th>
                          <th>{{ trans('create') }}</th>
                          <th>{{ trans('update') }}</th>
                          <th>{{ trans('delete') }}</th>
                        </tr>
                      </thead>

                        <tbody>

                          @if(isset($oMenu->submenu) && !empty($oMenu->submenu))
                            @foreach ($oMenu->submenu as $oSubmenu)

                              <tr>
                                <td><b></b>
                                  {{ trans($oSubmenu->name) }}
                                </td>

                                <td style="text-align: center;">
                                  @if ($permissions->contains('name', 'view '.$oSubmenu->permission))
                                    <input class="check_permission" id="permission-view-{{$oMenu->permission}}" value="view {{$oMenu->permission}}" type="checkbox" style="display: none" {{(strpos($permissionsRole, 'view '.$oSubmenu->permission)) ? 'checked' : '' }} @disabled($viewOnly)/>
                                    <input class="form-check-input check_permission" value="view {{$oSubmenu->permission}}" id="permission-view-{{$oSubmenu->id}}" name="permission-view-{{$oSubmenu->permission}}" mainparent="permission-view-{{ $oMenu->permission }}" type="checkbox" {{(strpos($permissionsRole, 'view '.$oSubmenu->permission)) ? 'checked' : '' }} onchange="selectCheckMenu(this.id,'permission-view-{{$oSubmenu->permission}}')"  @disabled($viewOnly)/>
                                  @endif
                                </td>
                                <td style="text-align: center;">
                                  @if ($permissions->contains('name', 'create '.$oSubmenu->permission))
                                    <input class="form-check-input check_permission" value="create {{$oSubmenu->permission}}" name="permission-create-{{$oSubmenu->permission}}" type="checkbox" {{(strpos($permissionsRole, 'create '.$oSubmenu->permission)) ? 'checked' : '' }}  @disabled($viewOnly)/>
                                  @else
                                  <input class="form-check-input" name="create-{{$oSubmenu->permission}}" type="checkbox"  @disabled($viewOnly) />
                                  @endif
                                </td>
                                <td style="text-align: center;">
                                  @if ($permissions->contains('name', 'update '.$oSubmenu->permission))
                                    <input class="form-check-input check_permission" value="update {{$oSubmenu->permission}}" name="permission-update-{{$oSubmenu->permission}}" type="checkbox" {{(strpos($permissionsRole, 'update '.$oSubmenu->permission)) ? 'checked' : '' }} @disabled($viewOnly) />
                                  @else
                                  <input class="form-check-input" name="update-{{$oSubmenu->permission}}" type="checkbox"  @disabled($viewOnly) />
                                  @endif
                                </td>
                                <td style="text-align: center;">
                                  @if ($permissions->contains('name', 'delete '.$oSubmenu->permission))
                                    <input class="form-check-input check_permission" value="delete {{$oSubmenu->permission}}" name="permission-delete-{{$oSubmenu->permission}}" type="checkbox" {{(strpos($permissionsRole, 'delete '.$oSubmenu->permission)) ? 'checked' : '' }} @disabled($viewOnly) />
                                  @else
                                  <input class="form-check-input" name="delete-{{$oSubmenu->permission}}" type="checkbox"   @disabled($viewOnly)/>
                                  @endif
                                </td>

                              </tr>
                              @isset($oSubmenu->submenu)
                              @include('administration.roles.roles-submenu',['menus' => $oSubmenu->submenu])
                              @endisset
                            @endforeach
                          @else

                            <tr>
                              <td>{{ trans($oMenu->name) }}</td>
                              <td style="text-align: center;">
                                @if ($permissions->contains('name', 'view '.$oMenu->permission))
                                <input class="form-check-input check_permission" value="view {{$oMenu->permission}}" name="permission-view-{{$oMenu->permission}}" type="checkbox" {{(strpos($permissionsRole, 'view '.$oMenu->slug)) ? 'checked' : '' }}  @disabled($viewOnly)/>
                                @endif
                              </td>
                              <td style="text-align: center;">
                                @if ($permissions->contains('name', 'create '.$oMenu->permission))
                                <input class="form-check-input check_permission" value="create {{$oMenu->permission}}" name="permission-create-{{$oMenu->permission}}" type="checkbox" {{(strpos($permissionsRole, 'create '.$oMenu->slug)) ? 'checked' : '' }} @disabled($viewOnly) />
                                @endif
                              </td>
                              <td style="text-align: center;">
                                @if ($permissions->contains('name', 'update '.$oMenu->permission))
                                <input class="form-check-input check_permission" value="update {{$oMenu->permission}}" name="permission-update-{{$oMenu->permission}}" type="checkbox" {{(strpos($permissionsRole, 'update '.$oMenu->slug)) ? 'checked' : '' }}  @disabled($viewOnly)/>
                                @endif
                              </td>
                              <td style="text-align: center;">
                                @if ($permissions->contains('name', 'delete '.$oMenu->permission))
                                <input class="form-check-input check_permission" value="delete {{$oMenu->permission}}" name="permission-delete-{{$oMenu->permission}}" type="checkbox" {{(strpos($permissionsRole, 'delete '.$oMenu->slug)) ? 'checked' : '' }}  @disabled($viewOnly)/>
                                @endif
                              </td>
                            </tr>
                          @endif


                        </tbody>

                    </table>
                  </div>

                </div>
                @endforeach

              </div>
            </div>
          </div>

          <!-- Permission table -->

        </div>
        <div class="col-12 text-center">
          @if((auth()->user()->can('create roles') || auth()->user()->can('edit roles')) && !$viewOnly)
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
          @endif
          <a href="{{ url('/administration/roles') }}" type="button" class="btn btn-outline-secondary" aria-label="Close">{{ $viewOnly ? trans('back') : trans('cancel') }}</a>
        </div>
      </form>
      <!--/ Add role form -->
    </div>
  </div>
@endsection
<script>
  var flag = @json($flag);
  var idRole = @json($rol->encrypted_id);

</script>
