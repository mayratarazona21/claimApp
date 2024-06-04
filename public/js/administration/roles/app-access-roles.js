'use strict';

$(function () {
  var dt_roles = $('.datatables-roles');
  var buttonsTable = [
    {
      extend: 'collection',
      className: 'btn btn-label-secondary dropdown-toggle ms-3 me-2 waves-effect waves-light',
      text: '<i class="mdi mdi-export-variant me-sm-1"></i> <span class="d-none d-sm-inline-block">Export</span>',
      buttons: [
        {
          extend: 'print',
          title: 'Roles',
          text: '<i class="mdi mdi-printer-outline me-1" ></i>Print',
          className: 'dropdown-item',
          exportOptions: {
            columns: [0, 1, 2]
          },
          customize: function (win) {
            //customize print view for dark
            $(win.document.body)
              .css('color', config.colors.headingColor)
              .css('border-color', config.colors.borderColor)
              .css('background-color', config.colors.body);
            $(win.document.body)
              .find('table')
              .addClass('compact')
              .css('color', 'inherit')
              .css('border-color', 'inherit')
              .css('background-color', 'inherit');
          }
        },
        {
          extend: 'csv',
          title: 'Roles',
          text: '<i class="mdi mdi-file-document-outline me-1" ></i>Csv',
          className: 'dropdown-item',
          exportOptions: {
            columns: [0, 1, 2]
          }
        },
        {
          extend: 'excel',
          title: 'Roles',
          text: 'Excel',
          className: 'dropdown-item',
          exportOptions: {
            columns: [0, 1, 2]
          }
        },
        {
          extend: 'pdf',
          title: 'Roles',
          text: '<i class="mdi mdi-file-pdf-box me-1"></i>Pdf',
          className: 'dropdown-item',
          exportOptions: {
            columns: [0, 1, 2]
          }
        },
        {
          extend: 'copy',
          title: 'Roles',
          text: '<i class="mdi mdi-content-copy me-1" ></i>Copy',
          className: 'dropdown-item',
          exportOptions: {
            columns: [0, 1, 2]
          }
        }
      ]
    }
  ];

  if (permissionCreate) {
    buttonsTable.push({
      text: '<a class="add-role"><i class="mdi mdi-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New Role</span></a>',
      className: 'add-new btn btn-primary waves-effect waves-light'
    });
  }

  if (dt_roles.length) {
    var dt_user = dt_roles.DataTable({
      data: roles,
      columns: [
        // columns according to JSON
        { data: 'role' },
        { data: 'status' },
        { data: 'creation_date' },
        {
          title: 'Actions',
          render: function (data, type, row, meta) {
            var buttosActions =
              '<a href="javascript:;" class="btn btn-sm btn-text-secondary rounded-pill btn-icon view-role" attr-id-role="' +
              row.encrypted_id +
              '" data-toggle="tooltip" title="View"><i class="ri-eye-line"></i></a>';

            buttosActions +=
              permissionEdit && row.id_status != 2
                ? '<a href="javascript:;" class="btn btn-sm btn-text-secondary rounded-pill btn-icon edit-role" attr-id-role="' +
                  row.encrypted_id +
                  '" data-toggle="tooltip" title="Edit"><i class="mdi mdi-pencil-outline"></i></a>'
                : '';

            buttosActions +=
              permissionDelete && row.id_status != 2
                ? '<a href="javascript:;" class="btn btn-sm btn-text-secondary rounded-pill btn-icon delete-role" attr-id-role="' +
                  row.encrypted_id +
                  '" data-toggle="tooltip" title="Delete"><i class="ri-delete-bin-line"></i></a>'
                : '';
            return buttosActions;
          }
        }
      ],
      columnDefs: [
        {
          // Label
          targets: -2,
          render: function (data, type, full, meta) {
            var $status_number = full['status'];
            var $status = {
              Active: { title: 'Active', class: 'bg-label-success' },
              Inactive: { title: 'Inactive', class: ' bg-label-danger' }
            };
            if (typeof $status[$status_number] === 'undefined') {
              return data;
            }
            return (
              '<span class="badge rounded-pill ' +
              $status[$status_number].class +
              '">' +
              $status[$status_number].title +
              '</span>'
            );
          }
        }
      ],
      order: [[1, 'desc']],
      dom:
        '<"row mx-2"' +
        '<"col-md-2"<"me-3"l>>' +
        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
        '>t' +
        '<"row mx-2"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      language: {
        sLengthMenu: '_MENU_'
      },
      // Buttons with Dropdown
      buttons: buttonsTable
    });

    $(document).on('click', '.add-role', function () {
      location.href = baseUrl + 'rol/create';
    });

    $(document).on('click', '.view-role', function () {
      var idRole = $(this).attr('attr-id-role');
      location.href = baseUrl + 'rol/' + idRole;
    });

    $(document).on('click', '.edit-role', function () {
      var idRole = $(this).attr('attr-id-role');
      location.href = baseUrl + 'rol/' + idRole + '/edit';
    });

    $(document).on('click', '.delete-role', function () {
      var idRole = $(this).attr('attr-id-role');

      Swal.fire({
        title: 'Are you sure?',
        text: 'The role will be deleted',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        customClass: {
          confirmButton: 'btn btn-primary me-1 waves-effect waves-light',
          cancelButton: 'btn btn-outline-secondary waves-effect'
        },
        buttonsStyling: false
      }).then(function (result) {
        if (result.value) {
          $.ajax({
            url: `${baseUrl}rol/` + idRole,
            type: 'DELETE',
            success: function (reponse) {
              Swal.fire({
                icon: reponse.state,
                title: reponse.name,
                text: reponse.message,
                customClass: {
                  confirmButton: 'btn btn-success'
                }
              });

              location.href = `${baseUrl}administration/roles`;
            },
            error: function (err) {}
          });
        }
      });
    });
  }
});
