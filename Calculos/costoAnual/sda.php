<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>Proyecto Ingenieria de Negocios</title>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../../estilosTablas.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700&display=swap" rel="stylesheet">

  </head>
  <body>  
    <!-- Cabecera y barra de navegacion -->
    <?php include '../../estructura/cabecera.php'; ?>
    <?php include '../../estructura/navbarSubniveles.php'; ?>
    <div class="main-content container py-5">
    <!-- Formulario para capturar variables iniciales B, VR y N -->
    <?php
    echo "
    <h1 class='mb-4 text-white'>Suma de los Dígitos de los Años (SDA)</h1>
    <form action='' method='post' class='p-4 rounded shadow bg-light' style='max-width: 400px;'>
        <div class='mb-3'>
            <label for='B' class='form-label'>Costo base</label>
            <input type='number' class='form-control' id='B' name='B' required placeholder='Ej: 10000'>
        </div>
        <div class='mb-3'>
            <label for='VR' class='form-label'>Valor de Rescate</label>
            <input type='number' class='form-control' id='VR' name='VR' required placeholder='Ej: 1000'>
        </div>
        <div class='mb-3'>
            <label for='N' class='form-label'>Vida útil (años)</label>
            <input type='number' class='form-control' id='N' name='N' required placeholder='Ej: 4'>
        </div>
        <button type='submit' class='btn btn-success w-100'>Calcular</button>
    </form>
    ";

    if (isset($_POST['B']) && isset($_POST['VR']) && isset($_POST['N'])) {
        $B = floatval(trim($_POST['B']));
        $VR = floatval(trim($_POST['VR']));
        $N = intval(trim($_POST['N']));

        // Suma de los dígitos de los años
        $sumaDigitos = $N * ($N + 1) / 2;
        // Inicializaciones
        $acumulada = 0;
        $VL_inicio = $B;
        ?>

        <!-- Botón para exportar -->
        <form id="exportarPDF" action="../../exportar_pdf.php" method="post" target="_blank">
            <input type="hidden" name="tabla_html" id="tabla_html">
            <button type="button" class="btn btn-danger" onclick="enviarTabla()">Exportar tabla a PDF</button>
        </form>
        <br>
        <div id="tablaDepreciacion">
        <?php

        // Generar tabla de resultados
        echo "<table class='table table-striped table-bordered mt-4'>";
        echo "<thead>
                <tr>
                    <th>Año</th>
                    <th>Depreciación anual</th>
                    <th>Depreciación acumulada</th>
                    <th>Valor en libros al final</th>
                </tr>
            </thead>
            <tbody>";

        for ($k = 1; $k <= $N; $k++) {
            // Fracción SDA
            $fraccion = ($N - $k + 1) / $sumaDigitos;
            // Depreciación anual
            $depreciacionAnual = ($B - $VR) * $fraccion;
            // Acumulada
            $acumulada += $depreciacionAnual;
            // Valor en libros al final
            $VL_final = $B - $acumulada;

            echo "<tr>
                    <td>$k</td>
                    <td>" . number_format($depreciacionAnual, 2) . "</td>
                    <td>" . number_format($acumulada, 2) . "</td>
                    <td>" . number_format($VL_final, 2) . "</td>
                </tr>";
        }
        echo "</tbody></table>";
         }
        ?>
        </div>
    </div>
    <script>
        function enviarTabla() {
            // Captura el HTML de la tabla y lo envía al formulario
            document.getElementById('tabla_html').value = document.getElementById('tablaDepreciacion').innerHTML;
            document.getElementById('exportarPDF').submit();
        }
    </script>        
    <?php include '../../estructura/footer.php'; ?>
    </body>
</html>