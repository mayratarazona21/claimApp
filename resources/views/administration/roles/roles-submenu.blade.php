@foreach ($menus as $oMenu)

<tr>
  <td><b></b>
    <i class="ri-corner-down-right-line"></i>
    {{ trans($oMenu->name) }}
  </td>

  <td style="text-align: center;">
    @if ($permissions->contains('name', 'view '.$oMenu->permission))
      <input class="form-check-input check_permission" value="view {{$oMenu->permission}}" main-parent="permission-view-{{ $oMenu->permission }}" submenu="permission-view-{{$oMenu->permission}}" name="permission-view-{{$oMenu->permission}}" type="checkbox" {{(strpos($permissionsRole, 'view '.$oMenu->permission)) ? 'checked' : '' }} onchange="selectCheckSubMenu('permission-view-{{$oMenu->parent}}')" @disabled($viewOnly)/>
    @endif
  </td>
  <td style="text-align: center;">
    @if ($permissions->contains('name', 'create '.$oMenu->permission))
      <input class="form-check-input check_permission" value="create {{$oMenu->permission}}" name="permission-create-{{$oMenu->permission}}" type="checkbox" {{(strpos($permissionsRole, 'create '.$oMenu->permission)) ? 'checked' : '' }}  @disabled($viewOnly)/>
    @endif
  </td>
  <td style="text-align: center;">
    @if ($permissions->contains('name', 'update '.$oMenu->permission))
      <input class="form-check-input check_permission" value="update {{$oMenu->permission}}" name="permission-update-{{$oMenu->permission}}" type="checkbox" {{(strpos($permissionsRole, 'update '.$oMenu->permission)) ? 'checked' : '' }}  @disabled($viewOnly)/>
    @endif
  </td>
  <td style="text-align: center;">
    @if ($permissions->contains('name', 'delete '.$oMenu->permission))
      <input class="form-check-input check_permission" value="delete {{$oMenu->permission}}" name="permission-delete-{{$oMenu->permission}}" type="checkbox" {{(strpos($permissionsRole, 'delete '.$oMenu->permission)) ? 'checked' : '' }}  @disabled($viewOnly)/>
    @endif
  </td>

</tr>
@isset($oMenu->submenu)
@include('administration.roles.roles-submenu',['menu' => $oMenu->submenu])
@endisset
@endforeach
