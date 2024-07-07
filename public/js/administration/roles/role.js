/**
 * Add new role Modal JS
 */

('use strict');

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    // add role form validation
    FormValidation.formValidation(document.getElementById('roleForm'), {
      fields: {
        roleName: {
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
        data: { name: $('#roleName').val(), permissions: permissions },
        url: url,
        type: type,
        success: function (response) {
          Swal.fire({
            icon: response.state,
            title: response.name,
            text: response.message,
            customClass: {
              confirmButton: 'btn btn-' + response.state
            }
          });

          if (response.state == 'success') {
            location.href = `${baseUrl}administration/roles`;
          }
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
  checkboxesMainMenu = document.querySelectorAll('[mainparent^="' + mainparent + '"]');
  const anyCheckedMainMenu = Array.from(checkboxesMainMenu).some(cb => cb.checked);
  document.querySelector('#' + mainparent).checked = anyCheckedMainMenu;
}
