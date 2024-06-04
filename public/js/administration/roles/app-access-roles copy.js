$(function () {
  'use strict';

  var dt_basic_table = $('.datatables-basic');

  var datos = roles;
  if (dt_basic_table.length) {
    var dt_basic = dt_basic_table.DataTable({
      data: roles,
      columns: [
        { title: 'Role', data: 'role' },
        { title: 'Creaton', data: 'creation_date' },
        { title: 'startus',
          data: 'status',
          render: function (data, type, row, meta) {
            var status_number = row['status'];
            var status = {
              'Active': { title: 'Active', class: 'bg-label-success' },
              'Inactive': { title: 'Inactive', class: ' bg-label-danger' }
            };
            return (
              '<span class="badge rounded-pill ' +
              status[status_number].class +
              '">' +
              status[status_number].title +
              '</span>'
            );
          }
        },
        { title: 'Actions',
          render: function(data, type, row, meta) {
            return '<a href="javascript:;" class="btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit" data-toggle="tooltip" title="Editar"><i class="mdi mdi-pencil-outline"></i></a>';
          }
      }
      ],
      order: [[2, 'desc']],
      dom: '<"card-header"<"head-label text-center"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      displayLength: 7,
      lengthMenu: [7, 10, 25, 50, 75, 100],
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-label-primary dropdown-toggle me-2',
          text: '<i class="ri-external-link-line me-1"></i>Export',
          buttons: [
            {
              extend: 'print',
              text: '<i class="ri-printer-line me-1" ></i>Print',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            },
            {
              extend: 'csv',
              text: '<i class="ri-file-text-line me-1" ></i>Csv',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            },
            {
              extend: 'excel',
              text: '<i class="ri-file-excel-line me-1"></i>Excel',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            },
            {
              extend: 'pdf',
              text: '<i class="ri-file-pdf-line me-1"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            },
            {
              extend: 'copy',
              text: '<i class="ri-file-copy-line me-1" ></i>Copy',
              className: 'dropdown-item',
              exportOptions: { columns: [3, 4, 5, 6, 7] }
            }
          ]
        },
        {
          text: '<i class="ri-add-line me-1"></i> <span class="d-none d-lg-inline-block">Add New Record</span>',
          className: 'create-new btn btn-primary'
        }
      ],
      columnDefs: [
        {
          // Actions
          targets: -1,
          title: 'Actions',
          orderable: false,
          searchable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-inline-block">' +
              '<a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-more-2-line"></i></a>' +
              '<ul class="dropdown-menu dropdown-menu-end">' +
              '<li><a href="javascript:;" class="dropdown-item">Details</a></li>' +
              '<li><a href="javascript:;" class="dropdown-item">Archive</a></li>' +
              '<div class="dropdown-divider"></div>' +
              '<li><a href="javascript:;" class="dropdown-item text-danger delete-record">Delete</a></li>' +
              '</ul>' +
              '</div>' +
              '<a href="javascript:;" class="btn btn-sm btn-icon item-edit"><i class="ri-edit-box-line"></i></a>'
            );
          }
        }
      ]
    });
  }
});
/*
$(document).on("click", ".add-role", function () {
  location.href = baseUrl +'rol/create';
}); */
