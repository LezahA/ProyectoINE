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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  </head>
  <body>   
    <?php include './estructura/cabecera.php'; ?>

    <nav class="navbar navbar-expand-lg" style="background-color: #c4a371; border-bottom: 1px solid #ccc;">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
          data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
          aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="./index.php" title="Inicio">
                <img src="./recursos/logo.svg" alt="Logo" style="width: 30px; height: 30px;">
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./Calculos/costoAnual.php" style="color: #fff; font-size: 1.2rem;">Costo anual</a>
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
