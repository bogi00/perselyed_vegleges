<?php
    require 'config.php';
    session_start();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <title>A perselyed</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- awesome fontfamily -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
      <script src="http://code.jquery.com/jquery-latest.js"></script>
      <title>Nettó-Bruttó Kalkulátor</title>
    <script>
        function calculate() {
            var haviBrutto = parseFloat(document.getElementById("haviBrutto").value);
            var frissHazasokKedvezmenye = document.getElementById("frissHazasok").checked;
            var szjaMentessege = document.getElementById("szjaMentes").checked;
            var kedvezményezettEltartottak = parseInt(document.getElementById("kedvezményezettEltartottak").value);
            var nemKedvezményezettEltartottak = parseInt(document.getElementById("nemKedvezményezettEltartottak").value);
            
            var szjaKulcs = 0.15; // Alap szja kulcs
            var szja = 0;
            var nyugdij = 0;
            var egeszseg = 0;
            var munkaero = 0;
            var szocialisHozzajarulas = 0;
            var szakkepzesiHozzajarulas = 0;
            
            if (frissHazasokKedvezmenye) {
                szjaKulcs -= 0.1; // Friss házasok kedvezménye
            }
            
            if (szjaMentessege && haviBrutto < 150000) {
                szjaKulcs = 0; // 25 év alattiak szja-mentessége
            }
            
            // Számítások
            szja = haviBrutto * szjaKulcs;
            nyugdij = haviBrutto * 0.10; // Nyugdíjjárulék (10%)
            egeszseg = haviBrutto * 0.07; // Egészségbiztosítási járulék (7%)
            munkaero = haviBrutto * 0.015; // Munkaerőpiaci járulék (1.5%)
            szocialisHozzajarulas = haviBrutto * 0.13; // Szociális hozzájárulási adó (13%)
            
            // Kedvezmények
            var kedvezmeny = kedvezményezettEltartottak * 4500; // Kedvezményezett eltartottak száma * 4500 Ft
            
            // Nettó számítás
            var nettobolLevonando = szja + nyugdij + egeszseg + munkaero + szocialisHozzajarulas + szakkepzesiHozzajarulas;
            var nettó = haviBrutto - nettobolLevonando + kedvezmeny;
            
            // Eredmények megjelenítése
            document.getElementById("szja").innerHTML = "Jövedelemadó (SZJA 15%): " + szja.toFixed(2) + " Ft";
            document.getElementById("nyugdij").innerHTML = "Nyugdíjjárulék (10%): " + nyugdij.toFixed(2) + " Ft";
            document.getElementById("egeszseg").innerHTML = "Egészségbiztosítási járulék (7%): " + egeszseg.toFixed(2) + " Ft";
            document.getElementById("munkaero").innerHTML = "Munkaerőpiaci járulék (1.5%): " + munkaero.toFixed(2) + " Ft";
            document.getElementById("szocialisHozzajarulas").innerHTML = "Szociális hozzájárulási adó (13%): " + szocialisHozzajarulas.toFixed(2) + " Ft";
            document.getElementById("szakkepzesiHozzajarulas").innerHTML = "Szakképzési hozzájárulás (0%): 0 Ft";
            document.getElementById("nettó").innerHTML = "Nettó bér: " + nettó.toFixed(2) + " Ft";
            
            // Teljes bérköltség
            var teljesBerkoltseg = haviBrutto + szja + nyugdij + egeszseg + munkaero + szocialisHozzajarulas + szakkepzesiHozzajarulas;
            document.getElementById("teljesBerkoltseg").innerHTML = "Teljes bérköltség: " + teljesBerkoltseg.toFixed(2) + " Ft";
            
            // SZJA 1%
            var szja1 = haviBrutto * 0.01;
            document.getElementById("szja1").innerHTML = "SZJA 1%: " + szja1.toFixed(2) + " Ft";
        }
    </script>
</head>
<!-- body -->
<body class="main-layout">
    
    <!-- loader  -->
    <div class="loader_bg">
        <div class="loader"><img src="images/loading.gif" alt="" /></div>
    </div>
    <!-- end loader -->
    <div id="mySidepanel" class="sidepanel">

    </div>
    <!-- header -->
    <header id="navbar">
        <!-- header inner -->
    </header>
    <!-- end header -->
    <div class="container mt-5">
        <h1 class="text-center">Nettó-Bruttó Kalkulátor</h1>
        <form>
            <div class="form-group">
                <label for="haviBrutto">Havi bruttó bér (Ft):</label>
                <input type="number" class="form-control" id="haviBrutto" required>
            </div>

            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="frissHazasok">
                <label class="form-check-label" for="frissHazasok">Friss házasok kedvezménye</label>
            </div>

            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="szjaMentes">
                <label class="form-check-label" for="szjaMentes">25 év alattiak SZJA-mentessége</label>
            </div>

            <div class="form-group">
                <label for="kedvezményezettEltartottak">Kedvezményezett eltartottak száma:</label>
                <input type="number" class="form-control" id="kedvezményezettEltartottak">
            </div>

            <div class="form-group">
                <label for="nemKedvezményezettEltartottak">Nem kedvezményezett eltartottak száma:</label>
                <input type="number" class="form-control" id="nemKedvezményezettEltartottak">
            </div>

            <button type="button" class="btn btn-primary" onclick="calculate()">Számol</button>
        </form>

        <!-- Eredmények -->
        <div class="mt-4">
            <div id="szja"></div>
            <div id="nyugdij"></div>
            <div id="egeszseg"></div>
            <div id="munkaero"></div>
            <div id="szocialisHozzajarulas"></div>
            <div id="szakkepzesiHozzajarulas"></div>
            <div id="nettó"></div>
            <div id="teljesBerkoltseg"></div>
            <div id="szja1"></div>
        </div>
        <!-- End Eredmények -->
    </div>
    <!-- End Content -->

    
    <!-- footer -->
    <footer id="footer">
      </footer>
      <!-- end footer -->
      <!-- Javascript files-->
      <script src="js/jquery.min.js "></script>
      <script src="js/bootstrap.bundle.min.js "></script>
      <script src="js/jquery-3.0.0.min.js "></script>
      <script src="js/custom.js "></script>
   </body>
</html>
<script>
    $('#navbar').load('nav.php');
    $('#mySidepanel').load('sidenav.php');
    $('#footer').load('footer.php');
</script>