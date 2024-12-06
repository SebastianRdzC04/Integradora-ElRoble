new DataTable('#quote-table', {
    order: [0, 'desc'],
    language: {
    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
  },
  dom: '<"d-flex justify-content-between align-items-center mb-3"<"d-flex justify-content-start align-items-center"B<"ms-3"l>>f>rtip',
  buttons: [
    {
      extend: 'excel',
      text: '<i class="bi bi-file-earmark-excel"></i> Excel',
      className: 'btn btn-success me-2',
      exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6, 7]
      }
    },
    {
      extend: 'pdf',
      text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
      className: 'btn btn-danger',
      exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6, 7]
      }
    }
  ],
  lengthMenu: [15, 20, 30, 50, 100]
});