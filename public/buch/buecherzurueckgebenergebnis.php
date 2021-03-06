<!DOCTYPE html>
<html lang="de">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image" href="../gbm_systems.png">

  <title>GBM Bücherei - Buch zurückgeben</title>

  <!-- Custom fonts for this template-->
  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="../../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../../css/sb-admin.css" rel="stylesheet">
  <link href="../../css/buecherausleihenergebnis.css" rel="stylesheet">
  <link href="../../css/nav.css" rel="stylesheet">
</head>

<body id="page-top">

<nav class="navbar navbar-expand navbar-dark bg-dark static-top">
  <img id="gbm_logo" src="../gbm_systems.png" alt="gbm_logo">  

  <a class="navbar-brand mr-1" href="index.php">GBM Bücherei</a>

  <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
    <i class="fas fa-bars"></i>
  </button>

  <!-- Navbar Search -->
  <!-- <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" action="buecherergebnis.php" method="post">
    <div class="input-group">

      <input type="text" class="form-control" placeholder="Nach Buchtitel suchen..." aria-label="Search" aria-describedby="basic-addon2" name="Titel" /><br />
      <div class="input-group-append">
        <button class="btn btn-primary" type="Submit">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </div> -->

  <!-- Navbar Profilbild -->
  <!-- <ul class="navbar-nav ml-auto ml-md-0">    
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-user-circle fa-fw"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="#">Settings</a>         
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
      </div>
    </li>
  </ul> -->

<!-- PHP Script -->
        <?php
        
        $conn = mysqli_connect("localhost", "d030833d", "DanielLukasStephan", "d030833d");
        // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM Buecher";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          $Anzahlbuecher = strval($result->num_rows);
        
        
        $conn->close();}
        ?>

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
          <a class="dropdown-item active" href="../../public/buch/buecherzurueckgeben.php">Zurückgeben</a>
          <div class="dropdown-divider"></div>
          <h6 class="dropdown-header">Buchbestand:</h6>
          <a class="dropdown-item" href="../../public/buch/buchanlegen.php">Anlegen</a>
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
        <li class="breadcrumb-item active">Buch zurückgeben</li>
      </ol>


        <!-- Page Content -->
        <h1>Buch zurückgeben</h1>
        <hr>
        
        <!-- <style>
          table {
          border-collapse: collapse;
          width: 100%;
          color: #588c7e;
          font-family: monospace;
          font-size: 25px;
          text-align: left;
          }
          th {
          background-color: #588c7e;
          color: white;
          }
          tr:nth-child(even) {background-color: #f2f2f2}
          </style>
          </head>
          <body>
          <table>
          <tr>
          <th>ID</th>
          <th>Titel</th>
          <th>ISBN</th>
          <th>Autor</th>
          <th>Regal</th>
          </tr> -->
          
          <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-book"></i>
            Buch zurückgeben</div>
          <div class="card-body">
          <?php
          
          $ID = $_POST["ID"];
          $ISBN = $_POST["ISBN"];
          
          $conn = mysqli_connect("localhost", "d030833d", "DanielLukasStephan", "d030833d");
          // Check connection
          if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
          }
          $sql = "SELECT * FROM Buecher LEFT JOIN kunden ON buecher.Kunde = kunden.Kundennummer WHERE ID LIKE '$ID' OR  ISBN LIKE '$ISBN'";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) { 
          // output data of each row
          while($row = $result->fetch_assoc()) {
            if ($row["Vorname"] == NULL){
          echo "
          <h4>Folgendes Buch ist nicht ausgeliehen: " . $row["Titel"] . "</h4>
          <p> <span class=\"fett\">ID:       </span>" . $row["ID"] . "</p>
          <p> <span class=\"fett\">ISBN:     </span>" . $row["ISBN"] . "</p>
          <p> <span class=\"fett\">Autor:    </span>" . $row["Autor"] . "</p>
          <p> <span class=\"fett\">Regal:    </span>" . $row["Regal"] . "</p>
          ";
            }
            else {
              echo 
              "<h4>Folgendes Buch ist ausgeliehen: " . $row["Titel"] . "</h4>
              <p> <span class=\"fett\">ID:     </span>" . $row["ID"] . "</p>
              <p> <span class=\"fett\">ISBN:   </span> " . $row["ISBN"] . "</p>
              <p> <span class=\"fett\">Autor:  </span> " . $row["Autor"] . "</p>
              <p> <span class=\"fett\">Regal:  </span> " . $row["Regal"] . "</p>
              <p> <span class=\"fett\">Vorname:  </span> " . $row["Vorname"] . "</p>
              <p> <span class=\"fett\">Nachanem:  </span> " . $row["Nachname"] . "</p>
              <p> <span class=\"fett\">Kunde-ID:  </span> " . $row["Kundennummer"] . "</p>
              <br />";
              echo 
              '<form action="buecherzurueckgebenbest.php" method="post">
              <label class=labelID>Buch-ID: </label> <input type="text" name="ID" value=' . $row["ID"] . ' readonly /> 
              <p class=sameLine> ist von: </p> <br />
              <label class=labelID>Kunden-ID: </label> <input type="text" name="Kunde" value=' . $row["Kundennummer"] . ' readonly /> 
              <p class=sameLine> ausgeliehen worden. </p> <br />
              <input id="submit-btn" type="Submit" value="Zurückgabe bestätigen" />
              </form>';
            }
          }
        } else { $message = "Kein Buch gefunden";
              echo "<script type='text/javascript'>alert('$message');</script>";
              sleep(2);
              // header("Location:index.php");
              exit();
          }
          $conn->close();
          ?>
          
          </table>


      </div>
      </div>
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
