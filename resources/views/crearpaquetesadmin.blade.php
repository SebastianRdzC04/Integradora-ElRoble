<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Roble - Crear Paquete</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/stylescotizacionesclientes.css') }}">
    <style>
        .container {
            max-width: 80%;
        }
        #crearPaquete {
            background-color: rgba(34, 52, 34, 0.8);
            padding: 20px;
            border-radius: 8px;
            color: white;
        }
        #previstaPaquete {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgba(34, 52, 34, 0.8);
            padding: 20px;
            border-radius: 8px;
            color: #FFD700;
        }
        .prevista-imagen-container {
            position: relative;
            width: 80%; /* Reduce el ancho de la imagen a un 80% */
            max-width: 320px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }
        .prevista-imagen {
            width: 100%;
            border-radius: 3%;
            max-height: 250px;
            object-fit: cover;
        }
        .prevista-caption {
            position: absolute;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 85%;
            height: 80%;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 5px;
            color: white;
            text-align: center;
        }
        #crearBoton {
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="container mt-4">
        <div class="row">
            <!-- Formulario de Creación de Paquete -->
            <div class="col-md-6" id="crearPaquete">
                <h3>Crear Nuevo Paquete</h3>
                <form>
                    <div class="mb-3">
                        <label for="tituloPaquete" class="form-label">Título del Paquete:</label>
                        <input type="text" class="form-control" id="tituloPaquete" placeholder="Ej. Paquete Conmemorativo" oninput="actualizarPrevista()">
                    </div>
                    <div class="mb-3">
                        <label for="lugarPaquete" class="form-label">Lugar:</label>
                        <select class="form-select" id="lugarPaquete" oninput="actualizarPrevista()">
                            <option>Quinta</option>
                            <option>Salón</option>
                            <option>Quinta y Salón</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="maxPersonas" class="form-label">Cantidad Máxima de Personas:</label>
                        <input type="number" class="form-control" id="maxPersonas" placeholder="Ej. 100" oninput="actualizarPrevista()">
                    </div>
                    <div class="mb-3">
                        <label for="descripcionPaquete" class="form-label">Descripción:</label>
                        <textarea class="form-control" id="descripcionPaquete" rows="3" oninput="actualizarPrevista()" placeholder="Ej. Música en vivo, Comida preparada, Servicio de meseros"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="precioPaquete" class="form-label">Precio Estimado:</label>
                        <input type="number" class="form-control" id="precioPaquete" placeholder="Ej. 1500" oninput="actualizarPrevista()">
                    </div>
                    <div class="mb-3">
                        <label for="imagenPaquete" class="form-label">Subir Imagen del Paquete:</label>
                        <input type="file" class="form-control" id="imagenPaquete" onchange="actualizarImagen()" disabled>
                    </div>
                </form>
            </div>

            <!-- Prevista de Paquete -->
            <div class="col-md-6 d-flex justify-content-center align-items-center" id="previstaPaquete">
                <h2>Prevista del Paquete</h2>
                <div class="prevista-imagen-container">
                    <img src="/images/imagen3.jpg" id="previstaImagen" class="prevista-imagen" alt="Imagen del Paquete">
                    <div class="prevista-caption">
                        <h5 id="previstaTitulo">Título del Paquete</h5>
                        <p id="previstaDescripcion">Descripción del paquete.</p>
                        <ul id="previstaLugar">
                            <li>Lugar: </li>
                        </ul>
                        <p id="previstaMaxPersonas">Capacidad Máxima: </p>
                        <p id="previstaPrecio">Precio Estimado: </p>
                    </div>
                </div>
                <div id="crearBoton">
                    <button type="button" class="btn btn-warning">Crear Paquete</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function actualizarPrevista() {
            document.getElementById("previstaTitulo").innerText = document.getElementById("tituloPaquete").value || "Título del Paquete";
            document.getElementById("previstaLugar").innerHTML = "<li>Lugar: " + (document.getElementById("lugarPaquete").value || "Lugar del paquete") + "</li>";
            document.getElementById("previstaMaxPersonas").innerText = "Capacidad Máxima: " + (document.getElementById("maxPersonas").value || "Cantidad");
            document.getElementById("previstaDescripcion").innerText = document.getElementById("descripcionPaquete").value || "Descripción del paquete.";
            document.getElementById("previstaPrecio").innerText = "Precio Estimado: $" + (document.getElementById("precioPaquete").value || "Precio");
        }

        function actualizarImagen() {
            // Función para actualizar imagen en el futuro
        }
    </script>
</body>
</html>
