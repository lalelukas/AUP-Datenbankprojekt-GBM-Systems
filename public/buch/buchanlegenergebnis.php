<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <link rel="icon" type="image" href="../gbm_systems.png">

  <title>GBM Bücherei - Buch angelegt</title>

  <!-- Custom fonts for this template-->
  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="../../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../../css/sb-admin.css" rel="stylesheet">
  <link href="../../css/nav.css" rel="stylesheet">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
    <img id="gbm_logo" src="../gbm_systems.png" alt="gbm_logo">  

    <a class="navbar-brand mr-1" href="../../index.php">GBM Bücherei</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Nach Buchtitel suchen..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> -->

    <!-- Navbar -->
    

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="../../index.php">
        <i class="fas fa-fw fa-chart-line"></i>
        <span>Dashboard</span>
      </a>
    </li>    
    <li class="nav-item dropdown show">
        <a class="nav-link dropdown-toggle" href="../../public/buch/buechersuche.php" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
          <i class="fas fa-fw fa-book"></i>
          <span>Bücher</span>
        </a>
        <div class="dropdown-menu show" aria-labelledby="pagesDropdown" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(5px, 56px, 0px);">
          <h6 class="dropdown-header">Übersicht:</h6>
          <a class="dropdown-item" href="../../public/buch/buechersuche.php">Buch suchen</a>
          <a class="dropdown-item" href="../../public/buch/buecherausgeliehen.php">Ausgeliehene Bücher</a>
          <div class="dropdown-divider"></div>
          <h6 class="dropdown-header">Buchverleih:</h6>
          <a class="dropdown-item" href="../../public/buch/buecherausleihen.php">Ausleihen</a>
          <a class="dropdown-item" href="../../public/buch/buecherzurueckgeben.php">Zurückgeben</a>
          <div class="dropdown-divider"></div>
          <h6 class="dropdown-header">Buchbestand:</h6>
          <a class="dropdown-item active" href="../../public/buch/buchanlegen.php">Anlegen</a>
          <a class="dropdown-item" href="../../public/buch/buecherloeschen.php">Löschen</a>
        </div>
      </li>  
      <li class="nav-item dropdown show">
        <a class="nav-link dropdown-toggle" href="../../public/kunde/kundensuche.php" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        <i class="fas fa-address-book"></i>
          <span>Kunden</span>
        </a>
        <div class="dropdown-menu show" aria-labelledby="pagesDropdown" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(5px, 56px, 0px);">
          <h6 class="dropdown-header">Übersicht:</h6>
          <a class="dropdown-item" href="../../public/kunde/kundensuche.php">Kunde suchen</a>
          <div class="dropdown-divider"></div>
          <h6 class="dropdown-header">Kundenbestand:</h6>
          <a class="dropdown-item" href="../../public/kunde/kundeanlegen.php">Anlegen</a>
          <a class="dropdown-item" href="../../public/kunde/kundeloeschen.php">Löschen</a>
        </div>
      </li> 
  </ul>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="../../index.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Buch angelegt</li>
        </ol>

        <!-- Page Content -->
        <h1>Ergebnis</h1>
        <hr>
                        
          <?php
          
          $Titel = $_POST["Titel"];
          $ISBN = $_POST["ISBN"];
          $Autor = $_POST["Autor"];
          $Regal = $_POST["Regal"];
          
          $conn = mysqli_connect("localhost", "d030833d", "DanielLukasStephan", "d030833d");
          // Check connection
          if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
          }
          $sql = "INSERT INTO `buecher`(`Titel`, `ISBN`, `Autor`, `Regal`) VALUES ('$Titel','$ISBN','$Autor','$Regal')";
          
          if ($conn->query($sql) === TRUE) {
              echo "<p id=\"plaintext\"> Buch wurde erfolgreich hinzugefügt </p>";
          } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
          }
          $conn->close();
          ?>
          
          </table>

      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © GBM SYSTEMS</span>
          </div>
        </div>
      </footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../../vendor/jquery/jquery.min.js"></script>
  <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../../js/sb-admin.min.js"></script>

</body>

</html>
