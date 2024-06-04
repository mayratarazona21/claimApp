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
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
@endsection

<script>
  var roles = @json($roles);
  var permissionCreate = {{ auth()->user()->can('create roles') ? 'true' : 'false' }}
  var permissionEdit = {{ auth()->user()->can('update roles') ? 'true' : 'false' }}
  var permissionDelete = {{ auth()->user()->can('delete roles') ? 'true' : 'false' }}

</script>
@section('page-script')
{{-- <script src="{{asset('js/administration/roles/app-access-roles.js')}}"></script> --}}
@endsection

@section('content')

<!-- DataTable with Buttons -->
<div class="card">
  <div class="card-header">
    <h5 class="card-title mb-0">Roles</h5>
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
@section('scripts')
<script>

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    // add role form validation
    FormValidation.formValidation(document.getElementById('roleForm'), {
      fields: {
        modalRoleName: {
          validators: {
            notEmpty: {
              message: 'Please enter role name'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          // eleInvalidClass: '',
          eleValidClass: '',
          rowSelector: '.col-12'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        // Submit the form when all fields are valid
        // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function () {
      // adding or updating user when form successfully validate

      var permissions = [];

      $('.check_permission').each(function () {
        if ($(this).is(':checked')) {
          permissions.push($(this).val());
        }
      });

      if (flag == 'create') {
        url = `${baseUrl}rol`;
        type = 'POST';
      } else {
        url = `${baseUrl}rol/` + idRole;
        type = 'PUT';
      }

      $.ajax({
        data: { name: $('#modalRoleName').val(), permissions: permissions },
        url: url,
        type: type,
        success: function (reponse) {
          Swal.fire({
            icon: 'success',
            title: `Successfully!`,
            text: reponse.message,
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });

          location.href = `${baseUrl}administration/roles`;
        },
        error: function (err) {}
      });
    });

    // Select All checkbox click
    const selectAll = document.querySelector('#selectAll'),
      checkboxList = document.querySelectorAll('[type="checkbox"]');
    selectAll.addEventListener('change', t => {
      checkboxList.forEach(e => {
        e.checked = t.target.checked;
      });
    });

    $('[name^="permission"]').change(function () {
      // Si se desmarca un checkbox de permiso, desmarcar el checkbox de administrador si corresponde
      if (!this.checked) {
        $('#selectAll').prop('checked', false);
      }
    });
  })();
});

function selectCheckMenu(id, nameCheck) {
  const selectAll = document.querySelector('#' + id),
    checkboxes = document.querySelectorAll('[name^="' + nameCheck + '"]');

  checkboxes.forEach(checkbox => {
    checkbox.checked = selectAll.checked;
  });

  checkMainMenu(selectAll.getAttribute('mainparent'));
}

function selectCheckSubMenu(idParent) {
  const checkParent = document.querySelector('#' + idParent);

  checkboxes = document.querySelectorAll('[submenu^="' + checkParent.name + '"]');
  const anyChecked = Array.from(checkboxes).some(cb => cb.checked);

  checkParent.checked = anyChecked;
  checkMainMenu(checkParent.getAttribute('mainparent'));
}

function checkMainMenu(mainparent) {
  console.log(mainparent);
  checkboxesMainMenu = document.querySelectorAll('[mainparent^="' + mainparent + '"]');
  const anyCheckedMainMenu = Array.from(checkboxesMainMenu).some(cb => cb.checked);
  document.querySelector('#' + mainparent).checked = anyCheckedMainMenu;
}

</script>
@endsection
