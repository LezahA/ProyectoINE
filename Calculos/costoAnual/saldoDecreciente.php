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
        <!-- Formulario para capturar variables iniciales B,N y VR -->
        <?php
        echo "
        <h1 class='mb-4 text-white'>Saldo Decreciente</h1>
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

            <div class='mb-3'>
                <label for='metodo' class='form-label'>Tasa de depreciación</label>
                <div class='form-check'>
                <input class='form-check-input' type='radio' name='metodo' id='doble_dec' value='doble_dec' checked>
                <label class='form-check-label' for='doble_dec'>Doble Saldo Decreciente</label>
                </div>
                <div class='form-check'>
                <input class='form-check-input' type='radio' name='metodo' id='simple_dec' value='simple_dec'>
                <label class='form-check-label' for='simple_dec'>Simple Decreciente</label>
                </div>
            </div>
            <button type='submit' class='btn btn-success w-100'>Calcular</button>
        </form>
        ";

        //Captura de variables
        if (isset($_POST['B']) && isset($_POST['VR']) && isset($_POST['N']) && isset($_POST['metodo'])) {
            $B = floatval(trim($_POST['B']));
            $VR = floatval(trim($_POST['VR']));
            $N = intval(trim($_POST['N']));
            $metodo = $_POST['metodo'];

            if (!empty($B) && !empty($VR) && !empty($N) && !empty($metodo)) {
                $B = $B;
                $VR = $VR;
                $N = $N;
                $metodo = $metodo;

                if ($metodo == 'doble_dec') {
                    $r = 2 / $N;
                } else {
                    $r = 1 / $N;
                }
                ?>

                <!-- Botón para exportar -->
                <form id="exportarPDF" action="../../exportar_pdf.php" method="post" target="_blank">
                    <input type="hidden" name="tabla_html" id="tabla_html">
                    <button type="button" class="btn btn-danger" onclick="enviarTabla()">Exportar tabla a PDF</button>
                </form>
                <br>
                <div id="tablaDepreciacion">

                <?php
                
                // Inicializaciones
                $acumulador = 0;
                $VL_inicio = $B;
                
                echo "<table class='table table-striped table-bordered'>";
                echo "<thead>
                        <tr>
                            <th>Año</th>
                            <th>Valor en libros al inicio</th>
                            <th>Depreciación anual</th>
                            <th>Depreciación acumulada</th>
                            <th>Valor en libros al final</th>
                        </tr>
                    </thead><tbody>";

                for ($i = 1; $i <= $N; $i++) {
                    // Calcular depreciación anual
                    $depreciacionAnual = $VL_inicio * $r;

                    // Ajuste para el último año (no bajar del valor de rescate)
                    if ($i == $N && ($VL_inicio - $depreciacionAnual) < $VR) {
                        $depreciacionAnual = $VL_inicio - $VR;
                    }

                    $acumulador += $depreciacionAnual;
                    $VL_final = $VL_inicio - $depreciacionAnual;

                    echo "<tr>
                            <td>$i</td>
                            <td>" . number_format($VL_inicio, 2) . "</td>
                            <td>" . number_format($depreciacionAnual, 2) . "</td>
                            <td>" . number_format($acumulador, 2) . "</td>
                            <td>" . number_format($VL_final, 2) . "</td>
                        </tr>";

                    $VL_inicio = $VL_final;
                }
                echo "</tbody></table>";
            
            }else {
            // Por si acaso
            echo "Por favor, complete todos los campos";
            } 
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