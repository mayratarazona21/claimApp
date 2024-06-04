@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Page 2')

@section('content')
  <!-- Add role form -->
  <form id="addRoleForm" class="row g-3" onsubmit="return false">
    <div class="col-12 mb-4">
      <div class="form-floating form-floating-outline">
        <input type="text" id="modalRoleName" name="modalRoleName" class="form-control" placeholder="Enter a role name" tabindex="-1" />
        <label for="modalRoleName">Role Name</label>
      </div>
    </div>
    <div class="col-12">
      <h5>Role Permissions</h5>
      <!-- Permission table -->
      <div class="table-responsive">
        <table class="table table-flush-spacing">
          <tbody>
            <tr>
              <td class="text-nowrap fw-medium">Administrator Access <i class="mdi mdi-information-outline" data-bs-toggle="tooltip" data-bs-placement="top" title="Allows a full access to the system"></i></td>
              <td>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="selectAll" />
                  <label class="form-check-label" for="selectAll">
                    Select All
                  </label>
                </div>
              </td>
            </tr>
            <tr>
              <td class="text-nowrap fw-medium">User Management</td>
              <td>
                <div class="d-flex">
                  <div class="form-check me-3 me-lg-5">
                    <input class="form-check-input" type="checkbox" id="userManagementRead" />
                    <label class="form-check-label" for="userManagementRead">
                      Read
                    </label>
                  </div>
                  <div class="form-check me-3 me-lg-5">
                    <input class="form-check-input" type="checkbox" id="userManagementWrite" />
                    <label class="form-check-label" for="userManagementWrite">
                      Write
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="userManagementCreate" />
                    <label class="form-check-label" for="userManagementCreate">
                      Create
                    </label>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- Permission table -->
    </div>
    <div class="col-12 text-center">
      <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
      <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
    </div>
  </form>
  <!--/ Add role form -->
@endsection
