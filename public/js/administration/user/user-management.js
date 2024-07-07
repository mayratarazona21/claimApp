/**
 * Page User List
 */

'use strict';

// Datatable (jquery)
$(function () {
  // Variable declaration for table
  var dt_user_table = $('.datatables-users'),
    select2 = $('.select2'),
    userView = baseUrl + 'app/user/view/account';

  if (select2.length) {
    var $this = select2;
    $this.wrap('<div class="position-relative"></div>').select2({
      placeholder: oLang.selectRol,
      dropdownParent: $this.parent()
    });
  }

  var dataTableUsers = {
    processing: false,
    serverSide: false,
    ajax: {
      url: baseUrl + 'user',
      dataSrc: function (json) {
        return json.data;
      }
    },
    columns: [
      // columns according to JSON
      { data: '' },
      {
        title: oLang.user,
        render: function (data, type, row, meta) {
          return row.first_name + ' ' + row.last_name;
        }
      },
      { data: 'email' },
      { data: 'contact' },
      { data: 'date_birth' },
      {
        title: oLang.roles,
        render: function (data, type, row, meta) {
          return row.roles.join(', ');
        }
      },
      { data: 'status' },
      { data: '' }
    ],
    columnDefs: [
      {
        // For Responsive
        className: 'control',
        searchable: false,
        orderable: false,
        responsivePriority: 1,
        targets: 0,
        render: function (data, type, full, meta) {
          return '';
        }
      },
      {
        // Status
        targets: -2,
        render: function (data, type, full, meta) {
          var $status_number = full['status'];
          var $status = {
            Active: { title: oLang.active, class: 'bg-label-success' },
            Inactive: { title: oLang.inactive, class: ' bg-label-danger' }
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
      },
      {
        // Actions
        targets: -1,
        title: oLang.actions,
        searchable: true,
        orderable: false,
        render: function (data, type, full, meta) {
          return full['id_status'] == 1
            ? '<div class="d-inline-block text-nowrap">' +
                `<button class="btn btn-sm btn-icon edit-user" data-id="${full['encrypted_id']}"><i class="mdi mdi-pencil-outline mdi-20px"></i></button>` +
                `<button class="btn btn-sm btn-icon delete-record" data-id="${full['encrypted_id']}"><i class="mdi mdi-delete-outline mdi-20px"></i></button>` +
                '</div>'
            : '';
        }
      }
    ],
    order: [[2, 'desc']],
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
      sLengthMenu: '_MENU_',
      search: ''
    },
    // Buttons with Dropdown
    buttons: [
      {
        extend: 'collection',
        className: 'btn btn-label-secondary dropdown-toggle ms-3 me-2 waves-effect waves-light',
        text:
          '<i class="mdi mdi-export-variant me-sm-1"></i> <span class="d-none d-sm-inline-block">' +
          oLang.export +
          '</span>',
        buttons: [
          {
            extend: 'print',
            title: oLang.users,
            text: '<i class="mdi mdi-printer-outline me-1" ></i>' + oLang.print,
            className: 'dropdown-item',
            exportOptions: {
              columns: [1, 2, 3, 4]
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
            title: oLang.users,
            text: '<i class="mdi mdi-file-document-outline me-1" ></i>Csv',
            className: 'dropdown-item',
            exportOptions: {
              columns: [1, 2, 3, 4],
              // prevent avatar to be print
              format: {
                body: function (inner, coldex, rowdex) {
                  if (inner.length <= 0) return inner;
                  var el = $.parseHTML(inner);
                  var result = '';
                  $.each(el, function (index, item) {
                    if (item.classList.contains('name')) {
                      result = result + item.lastChild.textContent;
                    } else result = result + item.innerText;
                  });
                  return result;
                }
              }
            }
          },
          {
            extend: 'excel',
            title: oLang.users,
            text: 'Excel',
            className: 'dropdown-item',
            exportOptions: {
              columns: [1, 2, 3, 4],
              // prevent avatar to be display
              format: {
                body: function (inner, coldex, rowdex) {
                  if (inner.length <= 0) return inner;
                  var el = $.parseHTML(inner);
                  var result = '';
                  $.each(el, function (index, item) {
                    if (item.classList.contains('name')) {
                      result = result + item.lastChild.textContent;
                    } else result = result + item.innerText;
                  });
                  return result;
                }
              }
            }
          },
          {
            extend: 'pdf',
            title: oLang.users,
            text: '<i class="mdi mdi-file-pdf-box me-1"></i>Pdf',
            className: 'dropdown-item',
            exportOptions: {
              columns: [1, 2, 3, 4],
              // prevent avatar to be display
              format: {
                body: function (inner, coldex, rowdex) {
                  if (inner.length <= 0) return inner;
                  var el = $.parseHTML(inner);
                  var result = '';
                  $.each(el, function (index, item) {
                    if (item.classList.contains('name')) {
                      result = result + item.lastChild.textContent;
                    } else result = result + item.innerText;
                  });
                  return result;
                }
              }
            }
          },
          {
            extend: 'copy',
            title: oLang.users,
            text: '<i class="mdi mdi-content-copy me-1" ></i>' + oLang.copy,
            className: 'dropdown-item',
            exportOptions: {
              columns: [1, 2, 3, 4],
              // prevent avatar to be copy
              format: {
                body: function (inner, coldex, rowdex) {
                  if (inner.length <= 0) return inner;
                  var el = $.parseHTML(inner);
                  var result = '';
                  $.each(el, function (index, item) {
                    if (item.classList.contains('name')) {
                      result = result + item.lastChild.textContent;
                    } else result = result + item.innerText;
                  });
                  return result;
                }
              }
            }
          }
        ]
      }
      /* {
        text:
          '<i class="mdi mdi-plus me-sm-1"></i><span class="d-none d-sm-inline-block">' + oLang.addNewUser + '</span>',
        className: 'add-new btn btn-primary waves-effect waves-light'
      } */
    ],
    // For responsive popup
    responsive: {
      details: {
        display: $.fn.dataTable.Responsive.display.modal({
          header: function (row) {
            var data = row.data();

            return 'Details of ' + data['first_name'] + data['last_name'];
          }
        }),
        type: 'column',
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
              ? '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  '<td>' +
                  col.title +
                  ':' +
                  '</td> ' +
                  '<td>' +
                  col.data +
                  '</td>' +
                  '</tr>'
              : '';
          }).join('');

          return data ? $('<table class="table"/><tbody />').append(data) : false;
        }
      }
    }
  };

  if (permissionCreate) {
    dataTableUsers.buttons.push({
      text:
        '<a class="add-user"><i class="mdi mdi-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">' +
        oLang.addNewUser +
        '</span></a>',
      className: 'add-new btn btn-primary waves-effect waves-light'
    });
  }

  // Users datatable
  if (dt_user_table.length) {
    var dt_user = dt_user_table.DataTable(dataTableUsers);
  }

  // Delete Record
  $(document).on('click', '.delete-record', function () {
    var user_id = $(this).data('id');
    // sweetalert for confirmation of delete
    Swal.fire({
      title: oLang.areYouSure,
      icon: 'warning',
      text: oLang.userWillBeDeactivated,
      showCancelButton: true,
      confirmButtonText: oLang.yes,
      customClass: {
        confirmButton: 'btn btn-warning me-3',
        cancelButton: 'btn btn-label-secondary'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.value) {
        // delete the data
        $.ajax({
          type: 'DELETE',
          url: `${baseUrl}user/${user_id}`,
          success: function (response) {
            Swal.fire({
              icon: response.state,
              title: response.title,
              text: response.message,
              customClass: {
                confirmButton: 'btn btn-' + response.state
              }
            });
            location.href = `${baseUrl}administration/users`;
          },
          error: function (error) {
            console.log(error);
          }
        });

        // success sweetalert
      }
    });
  });

  $(document).on('click', '.add-user', function () {
    location.href = baseUrl + 'user/create';
  });

  $(document).on('click', '.edit-user', function () {
    var user_id = $(this).data('id');
    location.href = baseUrl + 'user/' + user_id + '/edit';
  });

  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
});
