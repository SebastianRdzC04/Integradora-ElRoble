document.addEventListener('DOMContentLoaded', function() {
    // Obtener todos los elementos collapse
    const collapses = document.querySelectorAll('.collapse');

    // Añadir listener para el evento show.bs.collapse
    collapses.forEach(collapse => {
        collapse.addEventListener('show.bs.collapse', function() {
            // Cerrar todos los demás collapses
            collapses.forEach(otherCollapse => {
                if (otherCollapse !== collapse && bootstrap.Collapse.getInstance(
                        otherCollapse)) {
                    bootstrap.Collapse.getInstance(otherCollapse).hide();
                }
            });
        });
    });
});