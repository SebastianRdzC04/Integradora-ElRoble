document.addEventListener('DOMContentLoaded', function() {
    const table = new DataTable('#tabla-paquetes', {
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        lengthMenu: true,
        ordering: true,
        pageLength: 50,
        rowGroup: {
            dataSrc: 'group'
        },
        lengthMenu: [15, 20, 30, 50, 100]

    });

    /*
    $(document).on('click', 'svg[data-bs-toggle="collapse"]', function() {
        const targetId = $(this).data('bs-target');
        const parentRow = $(this).closest('tr');
        const childRow = parentRow.next('tr');
        
        // Cerrar otras filas expandidas
        $('.collapse.show').not(targetId).collapse('hide');
        
        // Toggle la fila actual
        $(targetId).collapse('toggle');
        
        // Actualizar la tabla
        table.draw(false);
    });
    */
});