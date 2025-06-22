<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Proyecto Ingenieria de Negocios</title>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="./estilos.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  </head>
  <body>   
    <?php include './estructura/cabecera.php'; ?>

    <nav class="navbar navbar-expand-md" style="background-color: #c4a371; border-bottom: 1px solid #ccc;">
      <div class="container-fluid">
        <a class="navbar-brand" href="./index.php">
          <img src="./recursos/logo.svg" alt="Logo" style="width: 30px; height: 30px;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
          <span class="navbar-toggler-icon"></span>
        </button>
        &nbsp&nbsp&nbsp&nbsp&nbsp

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="./Calculos/costoAnual.php" style="color: #fff; font-size: 1.2rem;">Costo anual</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="video-container">
        <video autoplay loop muted playsinline id="video-fondo">
            <source src="./recursos/video1.mp4" type="video/mp4">
        </video>
    </div>
    <video autoplay loop muted playsinline id="video-fondo-movil" class="d-block d-md-none">
      <source src="./recursos/video2.mp4" type="video/mp4">
    </video>
    <div class="main-content container-fluid">
    </div>
  <?php include './estructura/footer.php'; ?>

  </body>
</html>
