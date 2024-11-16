const table = new DataTable('#servicios-table', {
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
        },
        lengthMenu: [10, 20, 30, 50, 100],
        pageLength: 10,
        rowGroup: {
            dataSrc: 'group'
        }});



