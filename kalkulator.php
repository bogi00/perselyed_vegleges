<?php 
session_start();
?><!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="kalkulátor, bérkalkulátor, anyák, 25 év alatti, kedvezmény, járulék, adó">
		<meta name="description" content="Bérkalkulátor segítségével kiszámolhatód a nettó béred.">
        <title>Bérkalkulátor</title>
        <link rel="stylesheet" href="Mycss/cal.css">
		<link rel="icon" type="image/x-icon" href="images/favicon.png">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link href="https://unpkg.com/ionicons@4.2.5/dist/css/ionicons.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/responsive.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400" rel="stylesheet" type="text/css">
    </head>
    <body class="bg-info text-black">
	<div id="mySidepanel" class="sidepanel">
		<?php include("sidenav.php"); ?>
    </div>
    <header id="navbar">
        <?php include("nav.php"); ?>
    </header>
		<div class="container mt-5">
        <h2 class="text-center mb-4">Bérkalkulátor</h1>
		</div>
        <div class="">
            <div class="row">
                <div class="col-md-7 mx-auto">
                    <div class="card card-body text-center mt-4">
                        <form id="form1" class="mb-4">
                            <div class="form-group" >
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="align-middle"></i></span>
                                    <input type="number" class="form-control"  id="bruttoBer-input" placeholder="Bruttó bér">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="align-middle"></i></span>
                                    <input type="number" class="form-control"  id="18AlattiGyerek-input"  placeholder="18 éves kor alatti gyermekek száma">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="align-middle"></i></span>
                                    <input type="number" class="form-control" id="egyetemistaGyerek-input" placeholder="Felsőfokú tanulmányokat folytató gyerekek száma">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class=" align-middle"></i></span>
                                    <input type="number" class="form-control" id="tartosanBetegGyerek-input"  placeholder="Tartósan beteg vagy fogyatékos gyerekek száma">
                                </div>
                            </div>
                            <div class="mb-4 mt-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input"  id="egyedul-input">
                                    <label class="form-check-label mb-1" for="egyedul-input">Gyermekét egyedül neveli?</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input"  id="frissHazas-input">
                                    <label class="form-check-label mb-1" for="frissHazas-input">Friss házas?</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input"  id="anya30_25alatt-input">
                                    <label class="form-check-label mb-1" for="anya30_25alatt-input">25 év alatti vagy 30 év alatti anyuka?</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="szemelyiAdokedvezmeny-input">
                                    <label class="form-check-label"for="szemelyiAdokedvezmeny-input">Rendelkezik-e súlyos fogyatékosság után járó adókedvezménnyel?</label>
                                </div>
                            </div>
                            <input type="submit" class="form-control"  value="Számol" id="kuldes">
                        </form>
                        <div id="errorSzoveg">
                            <h2 class="alert alert-danger">Nem adta meg a bruttó bért!</h2>
                        </div>
                        <div id="loading">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b1/Loading_icon.gif" alt="">
                        </div>
                        <div id="tabla" class="table-responsive">
                            <table style="width:100%" class="table">
                                <tr class="table-active">
                                    <th>Alapadatok</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Bruttó havi munkabér</th>
                                    <td id="brutto-tabla">0</td>
                                </tr>
                                <tr>
                                    <th>Éves bruttó jövedelem</th>
                                    <td id="bruttoEves-tabla">0</td>
                                </tr>
                                <tr>
                                    <th>Eltartottak száma</th>
                                    <td id="eltartottak-tabla">0</td>
                                </tr>
                                <tr>
                                    <th>Kedvezményezett eltartottak (gyermekek) száma</th>
                                    <td id="kedvEltartottak-tabla">0</td>
                                </tr>
                                <tr class="table-active">
                                    <th>Munkavállalót terhelő járulékok</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Személyi jövedelemadó</th>
                                    <td id="szjaAdo-tabla">0</td>
                                </tr>
                                <tr>
                                    <th>Munkaero-piaci járulék</th>
                                    <td id="munkaeroPiaciJarulek-tabla">0</td>
                                </tr>
                                <tr>
                                    <th>Egészségbiztosítási járulék</th>
                                    <td id="egszbiztJar-tabla">0</td>
                                </tr>
                                <tr>
                                    <th>Nyugdíjjárulék</th>
                                    <td id="nyugdijJarulek-tabla">0</td>
                                </tr>
                                <tr>
                                    <th>Összes adó</th>
                                    <td id="osszesAdo-tabla">0</td>
                                </tr>
                                <tr class="table-active">
                                    <th>Munkáltatót terhelő járulékok</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Szociális hozzájárulási adó</th>
                                    <td id="szocHo-tabla">0</td>
                                </tr>
                                <tr>
                                    <th>Szakképzési hozzájárulás</th>
                                    <td id="szakHozz-tabla">0</td>
                                </tr>
                                <tr>
                                    <th>Munkaadó összes havi költsége</th>
                                    <td id="munkaltatoOssz-tabla">0</td>
                                </tr>
                                <tr class="table-active">
                                    <th>Adókedvezmények</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Családi adókedvezmény</th>
                                    <td id="csaladiAdokedv-tabla">0</td>
                                </tr>
                                <tr>
                                    <th>Friss házasok adókedvezménye</th>
                                    <td id="frissHazasAdokedv-tabla">0</td>
                                </tr>
                                <tr>
                                    <th>Súlyos fogyatékosság adókedvezménye</th>
                                    <td id="fogyatekosAdokedv-tabla">0</td>
                                </tr>
                                <tr class="table-active">
                                    <th>Adókedvezményekkel csökkentett munkavállalói adóterhek</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Felhasznált adókedvezmények</th>
                                    <td id="felhasznaltAdokedv-tabla">0</td>
                                </tr>
                                <tr>
                                    <th >Felhasználatlan adókedvezmények</th>
                                    <td id="felhasznalatlanAdokedv-tabla">0</td>
                                </tr>
                                <tr>
                                    <th>Adókedvezménnyel csökkentés után visszamaradó adóteher</th>
                                    <td id="maradtAdo-tabla">0</td>
                                </tr>
                                <tr class="table-active">
                                    <th>Nettó jövedelem</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Nettó havi munkabér</th>
                                    <td id="nettoBer-tabla">0</td>
                                </tr>
                                <tr>
                                    <th>Családi pótlék</th>
                                    <td id="csaladiPotlek-tabla">0</td>
                                </tr>
                                <tr>
                                    <th>Nettó összes bevétel</th>
                                    <td id="nettoOssz-tabla">0</td>
                                </tr>


                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script src="cal.js"></script>
    <footer>
        <?php include("footer.php") ?>
    </footer>
      <script src="https://code.jquery.com/jquery-latest.js"></script>
<script src="js/jquery.min.js "></script>
<script src="js/bootstrap.bundle.min.js "></script>
<script src="js/jquery-3.0.0.min.js "></script>
<script src="js/custom.js "></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
<script src="https://code.jquery.com/jquery-latest.js"></script>
<script>
    document.getElementsByTagName('html')[0].addEventListener("click", closeNav);
</script>
   </body>
</html>
