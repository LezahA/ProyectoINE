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
    <style>
          body {
          background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
          color: #fff;
        }
        .main-card {
          background: rgba(30, 41, 59, 0.97);
          border-radius: 1.5rem;
          box-shadow: 0 8px 32px rgba(0,0,0,0.28);
          padding: 2rem;
          max-width: 800px;
          margin: 40px auto;
          border: 1.5px solid #334155;
        }
    </style>      
  </head>

<body>
  <!-- Cabecera y barra de navegacion -->
  <?php include '../../estructura/cabecera.php'; ?>
  <?php include '../../estructura/navbarSubniveles.php'; ?>

  <div class="main-content container py-5" id='tirComparacion'>
    <h2 class="display-5 text-center mb-4 amarillo">Comparador de Proyectos - TIR y VAN</h2>

    <div class="main-card">

      <form method="POST">
        <div class="form-row">
          <div class="form-group col-md-4">
            <label>Inversión inicial (A)</label>
            <input type="number" name="inv_a" class="form-control" required value="<?= $_POST['inv_a'] ?? '' ?>">
          </div>
          <div class="form-group col-md-4">
            <label>Inversión inicial (B)</label>
            <input type="number" name="inv_b" class="form-control" required value="<?= $_POST['inv_b'] ?? '' ?>">
          </div>
          <div class="form-group col-md-4">
            <label>Número de años</label>
            <input type="number" name="anios" class="form-control" required value="<?= $_POST['anios'] ?? '' ?>">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Tasa mínima aceptable de retorno - Proyecto A (%)</label>
            <input type="number" name="tasa_a" class="form-control" required step="0.01" value="<?= $_POST['tasa_a'] ?? '' ?>">
          </div>
          <div class="form-group col-md-6">
            <label>Tasa mínima aceptable de retorno - Proyecto B (%)</label>
            <input type="number" name="tasa_b" class="form-control" required step="0.01" value="<?= $_POST['tasa_b'] ?? '' ?>">
          </div>
        </div>

        <?php
        $mostrarCampos = isset($_POST['solicitar']) || isset($_POST['calcular']);

        if ($mostrarCampos) {
          $anios = intval($_POST['anios']);
          echo "<hr><h5>Flujos de cada proyecto</h5><div class='row'>";
          for ($i = 1; $i <= $anios; $i++) {
            echo "
            <div class='col-md-3'>
              <label>Año $i - Ingreso A</label>
              <input type='number' name='ingresoA_$i' class='form-control' value='" . ($_POST["ingresoA_$i"] ?? '') . "' required>
            </div>
            <div class='col-md-3'>
              <label>Año $i - Egreso A</label>
              <input type='number' name='egresoA_$i' class='form-control' value='" . ($_POST["egresoA_$i"] ?? '') . "' required>
            </div>
            <div class='col-md-3'>
              <label>Año $i - Ingreso B</label>
              <input type='number' name='ingresoB_$i' class='form-control' value='" . ($_POST["ingresoB_$i"] ?? '') . "' required>
            </div>
            <div class='col-md-3'>
              <label>Año $i - Egreso B</label>
              <input type='number' name='egresoB_$i' class='form-control' value='" . ($_POST["egresoB_$i"] ?? '') . "' required>
            </div>";
          }
          echo "</div><br><button type='submit' name='calcular' class='btn btn-success btn-block'>Calcular Comparación</button>";
        } else {
          echo "<button type='submit' name='solicitar' class='btn btn-warning btn-block'>Solicitar flujos</button>";
        }
        ?>
      </form>

      <?php

      /**
       * Calcula el Valor Actual Neto (VAN) de un conjunto de flujos.
       * 
       * @param array $flujos Arreglo de flujos de efectivo (sin incluir la inversión inicial).
       * @param float $tasa Tasa de descuento (en decimal, ej. 0.1 para 10%, 0.2 para 20%, etc.).
       * @return float Retorna el VAN calculado.
       */
      function calcularVAN($flujos, $tasa)
      {
        $van = 0;
        foreach ($flujos as $indice => $flujo) {
          // Año 1 => exponente 1
          $periodo = $indice + 1;
          $van += $flujo / pow(1 + $tasa, $periodo);
        }
        return $van;
      }

      /**
       * Calcula la Tasa Interna de Retorno (TIR) usando búsqueda iterativa.
       * 
       * @param array $flujos Arreglo de flujos de efectivo, incluyendo la inversión inicial negativa.
       * @return float TIR estimada en porcentaje.
       */
      function calcularTIR($flujos)
      {
        $mejorTasa = null;
        $mejorVAN = INF;

        // Búsqueda de tasa desde -99% a 100% en incrementos de 0.01%
        for ($t = -0.99; $t <= 1; $t += 0.0001) {
          $van = 0;
          foreach ($flujos as $n => $f) {
            $van += $f / pow(1 + $t, $n);
          }

          // Selecciona la tasa cuyo VAN sea más cercano a cero
          if (abs($van) < abs($mejorVAN)) {
            $mejorVAN = $van;
            $mejorTasa = $t;
          }
        }
        return $mejorTasa * 100;
      }

      // Verifica si se ha enviado el formulario con el botón "calcular"
      if (isset($_POST['calcular'])) {
        // Captura y convierte los datos del formulario

        // Inversión inicial proyecto A
        $invA = floatval($_POST['inv_a']);
        // Inversión inicial proyecto B
        $invB = floatval($_POST['inv_b']);
        // Número de años del proyecto
        $anios = intval($_POST['anios']);

        // Tasa de descuento A en decimal
        $tasaA = floatval($_POST['tasa_a']) / 100;
        // Tasa de descuento B en decimal
        $tasaB = floatval($_POST['tasa_b']) / 100;

        // Inicializa los arreglos de flujos con la inversión inicial negativa
        $flujosA = [-$invA];
        $flujosB = [-$invB];

        // Muestra la tabla de resumen
        echo "<hr><h5 class='mb-3'>Resumen de flujos netos</h5>";
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered table-dark text-center'>
        <thead class='thead-light'>
          <tr>
            <th>Año</th>
            <th>Proyecto A (Ingreso - Egreso)</th>
            <th>Proyecto B (Ingreso - Egreso)</th>
          </tr>
        </thead>
        <tbody>";

         // Recorre los años para calcular ingresos netos y llenar los flujos
        for ($i = 1; $i <= $anios; $i++) {
          // Captura ingresos y egresos de cada proyecto
          $ingA = floatval($_POST["ingresoA_$i"]);
          $egrA = floatval($_POST["egresoA_$i"]);
          $netA = $ingA - $egrA;

          $ingB = floatval($_POST["ingresoB_$i"]);
          $egrB = floatval($_POST["egresoB_$i"]);
          $netB = $ingB - $egrB;
          
          // Añade los flujos netos al arreglo de cada proyecto
          $flujosA[] = $netA;
          $flujosB[] = $netB;

          // Muestra la fila en la tabla
          echo "<tr>
          <td>$i</td>
          <td>$" . number_format($netA, 2) . "</td>
          <td>$" . number_format($netB, 2) . "</td>
        </tr>";
        }
        echo "</tbody></table></div>";

        // Calcula VAN para ambos proyectos (se omite el flujo 0 en descuento y se suma al final)
        $vanA = calcularVAN(array_slice($flujosA, 1), $tasaA) + $flujosA[0];
        $vanB = calcularVAN(array_slice($flujosB, 1), $tasaB) + $flujosB[0];

        // Calcula la TIR de ambos proyectos
        $tirA = calcularTIR($flujosA);
        $tirB = calcularTIR($flujosB);

        // Muestra resultados
        echo "<div class='alert alert-info mt-4'><h4>Resultados</h4>
        <p><strong>Proyecto A - VAN (" . number_format($tasaA * 100, 2) . "%):</strong> $" . number_format($vanA, 2) . " | <strong>TIR:</strong> " . number_format($tirA, 2) . "%</p>
        <p><strong>Proyecto B - VAN (" . number_format($tasaB * 100, 2) . "%):</strong> $" . number_format($vanB, 2) . " | <strong>TIR:</strong> " . number_format($tirB, 2) . "%</p>";

        // Conclusión basada en la TIR
        if ($tirA > $tirB) {
          echo "<hr><p><strong>Conclusión:</strong> El <strong>Proyecto A</strong> ofrece un mejor retorno (TIR).</p>";
        } elseif ($tirB > $tirA) {
          echo "<hr><p><strong>Conclusión:</strong> El <strong>Proyecto B</strong> ofrece un mejor retorno (TIR).</p>";
        } else {
          echo "<hr><p><strong>Conclusión:</strong> Ambos proyectos tienen el mismo retorno estimado.</p>";
        }

        echo "</div>";

        // Botón para exportar
        echo '
        <form id="exportarPDF" action="../../exportar_pdf.php" method="post" target="_blank">
          <input type="hidden" name="tabla_html" id="tabla_html">
          <button type="button" class="btn btn-danger" onclick="enviarTabla()">Exportar a PDF</button>
        </form>
        <br>';
      }
      ?>
    </div>
  </div>
  <script>
      function enviarTabla() {
          // Captura el HTML de la tabla y lo envía al formulario
          document.getElementById('tabla_html').value = document.getElementById('tirComparacion').innerHTML;
          document.getElementById('exportarPDF').submit();
      }
  </script>
  <!-- Pie de pagina -->
  <?php include '../../estructura/footer.php'; ?>
</body>

</html>