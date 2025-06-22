<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>Proyecto Ingenieria de Negocios</title>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="./estilos.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700&display=swap" rel="stylesheet">

  </head>
  <body>   
    <?php include './estructura/cabecera.php'; ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
              <a class="nav-link" href="./index.php">Inicio</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="./Calculos/costoAnual.php">Costo anual</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="./Calculos/tasaRendimiento.php">Tasa de rendimiento</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="./Calculos/valorPresente.php">Valor presente</a>
              </li>
          </ul>
        </div>
      </div>
    </nav>
    <video autoplay loop muted playsinline id="video-fondo">
      <source src="./recursos/video1.mp4" type="video/mp4">
    </video>
    <div class="main-content container-fluid">
    </div>
  <?php include './estructura/footer.php'; ?>

  </body>
</html>
