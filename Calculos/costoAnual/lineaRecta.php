<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>Proyecto Ingenieria de Negocios</title>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../../estilos.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700&display=swap" rel="stylesheet">

  </head>
  <body>  
    <!-- Cabecera y barra de navegacion -->
    <?php include '../../estructura/cabecera.php'; ?>
    <?php include '../../estructura/navbarSubniveles.php'; ?>
    <div class="main-content container-fluid">

        <!-- Formulario para capturar variables iniciales B,N y VR -->
        <?php
        echo "
        <h1 class='mb-4 text-success'>Línea Recta</h1>
        <form action='' method='post' class='p-4 rounded shadow bg-light' style='max-width: 400px;'>
            <div class='mb-3'>
            <label for='B' class='form-label'>Costo base</label>
            <input type='number' class='form-control' id='B' name='B' required placeholder='Ej: 10000'>
            </div>
            <div class='mb-3'>
            <label for='VR' class='form-label'>Valor de Rescate</label>
            <input type='number' class='form-control' id='VR' name='VR' required placeholder='Ej: 2000'>
            </div>
            <div class='mb-3'>
            <label for='N' class='form-label'>Vida útil (años)</label>
            <input type='number' class='form-control' id='N' name='N' required placeholder='Ej: 5'>
            </div>
            <button type='submit' class='btn btn-success w-100'>Calcular</button>
        </form>
        ";


        //Captura de variables
        if (isset($_POST['B']) && isset($_POST['VR']) && isset($_POST['N'])) {
            $B = trim($_POST['B']);
            $VR = trim($_POST['VR']);
            $N = trim($_POST['N']);

            if (!empty($B) && !empty($VR) && !empty($N)) {
                $B = $B;
                $VR = $VR;
                $N = $N;

            } else {
                // Por si acaso
                echo "Por favor, complete todos los campos";
            }
        }
        //Resultado
        echo "<br>";
        $depreciacion = ($B - $VR) / $N;
        echo "
        <div class='alert alert-success mt-4' role='alert'>
            <h4 class='alert-heading'>Resultado</h4>
            <p>El costo anual es: <strong>" . number_format($depreciacion, 2) . "</strong></p>
        </div>
        <br>";
        
        ?>
        <!-- Botón para exportar -->
        <form id="exportarPDF" action="../../exportar_pdf.php" method="post" target="_blank">
            <input type="hidden" name="tabla_html" id="tabla_html">
            <button type="button" class="btn btn-danger" onclick="enviarTabla()">Exportar tabla a PDF</button>
        </form>
        <br>
        <div id="tablaDepreciacion">

        <?php

        //Generar tabla con resultados
        echo "<table class='table table-striped table-bordered'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Año</th>";
        echo "<th>Depreciacion anual</th>";
        echo "<th>Depreciacion acumulada</th>";
        echo "<th>Valor en libros a final de año</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        for ($i = 1; $i <= $N; $i++) {
            echo "<tr>";
            echo "<td>$i</td>";
            echo "<td>$depreciacion</td>";
            $acumulador=$acumulador+$depreciacion;
            echo "<td>$acumulador</td>";
            $libro=$B-$acumulador;
            echo "<td>$libro</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
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