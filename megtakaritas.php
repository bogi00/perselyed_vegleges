<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <meta name="keywords" content="megtakaritás, befektetés, kalkulátor,számol, jövedelem">
    <meta name="description" content="Ez a megtakarítás kalkulátor segít meghatározni, hogy mennyit tudsz megtakarítani a rendszeres befizetésekkel és kamatozással. Adja meg a kezdeti befektetett összeget, a havi befizetéseket, a futamidőt és a kamatlábat, majd kalkulálja ki a megtakarított összeget.">
    <meta name="author" content="Petőcz Boglárka, Gémes Lilla">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <title>Megtakaritás</title>
    
</head>
<body  class="main-layout">
<style>
        #megtak {
            max-width: 600px;
            margin: 0 auto;
            padding: 30px 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
			color: black;
            margin-bottom: 50px;
        }
        .form-label {
            font-weight: bold;
        }
        #amnt {
            margin-top: 20px;
            padding: 15px;
            background-color: #f0f0f0;
            border-radius: 5px;
            font-size: 18px;
        }
    </style>
	<div class="navok">
		<div id="mySidepanel" class="sidepanel">
		</div>
    <!-- header -->
		<header id="navbar">
		</header>
		
	</div>
    <div class="container mt-5">
    <h2 class="text-center mb-4">Megtakaritás</h2>
</div>
    <div class="container mt-5" id="megtak">
        <form>
            <div class="mb-3">
                <label for="init" class="form-label">Eddigi megtakarítás</label>
                <div class="input-group">
                    <input id="init" type="text" class="form-control" value="0" maxlength="8">
                    <span class="input-group-text">Ft</span>
                </div>
            </div>
            <div class="mb-3">
                <label for="annual" class="form-label">Havi megtakarítás mértéke:</label>
                <div class="input-group">
                    <input id="annual" type="text" class="form-control" value="10000" maxlength="6">
                    <span class="input-group-text">Ft</span>
                </div>
            </div>
            <div class="mb-3">
                <label for="rate" class="form-label">Éves hozam:</label>
                <div class="input-group">
                    <input id="rate" type="text" class="form-control" value="6" maxlength="2">
                    <span class="input-group-text">%</span>
                </div>
            </div>
            <div class="mb-3">
                <label for="slider" class="form-label">Megtakarítási időszak (1-35 év):</label>
                <input type="range" class="form-range" id="slider" min="1" max="35" value="1" oninput="evalSlider()">
                <output id="sliderVal" class="mt-2">5</output>
            </div>
            <button type="submit" class="btn btn-primary" onclick="savings();return false;">Számol</button>
        </form>
        <div id="amnt" class="mt-3"></div>
    </div>
    <footer>
        <?php include("footer.php") ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.min.js "></script>
      <script src="js/bootstrap.bundle.min.js "></script>
      <script src="js/jquery-3.0.0.min.js "></script>
      <script src="js/custom.js "></script>
    <script>
        function evalSlider() {
            var rangeNum = document.getElementById('slider').value;
            document.getElementById('sliderVal').innerHTML = rangeNum;
        }

       function savings() {
    var init = parseFloat(document.getElementById('init').value);
    var amount = parseFloat(document.getElementById('annual').value) * 12;
    var wholeRate = parseFloat(document.getElementById('rate').value);
    var rate = wholeRate / 100;
    var years = document.getElementById('sliderVal').innerHTML;
    var total = init * (1 + rate) + amount;
    for (var i = years; i > 1; i--) {
        total = total * (1 + rate) + amount;
        total = Math.round(total * 100) / 100;
    }
    var formattedTotal = formatMoney(total);
    document.getElementById('amnt').innerHTML = "Összes megtakarítás: " + formattedTotal ;
}

function formatMoney(amount) {
    var formattedAmount = new Intl.NumberFormat('hu-HU', { style: 'currency', currency: 'HUF' }).format(amount);
    return formattedAmount;
}

        $('#mySidepanel').load('sidenav.php');
		$('#navbar').load('nav.php');
		$('#footer').load('footer.php');
    </script>
</body>
</html>
