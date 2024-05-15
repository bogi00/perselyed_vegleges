<?php
    require 'config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    if(isset($_POST['send'])){
        $email = $_POST['email'];
        $message = $_POST['message'];
        
        $query = mysqli_query($conn, "INSERT INTO messages (email, message) VALUES ('$email', '$message')");
        
        if($query) {
            $_SESSION['message'] = "Elmentve!";
            $_SESSION['msg_type'] = "primary";
        } else {
            $_SESSION['message'] = "Hiba történt az üzenet mentésekor!";
            $_SESSION['msg_type'] = "danger";
        }
    }
$sql = "update admin_func SET klikk_index=klikk_index+1 WHERE id = '1'"; 
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Perselyed</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <meta name="keywords" content="persely, tranzakciókezelő, pénzügyek, kiadások, bevétel, megtakaritás, tudatos">
    <meta name="description" content="A perselyed  segítségével könnyedén nyomon követheti megtakaritásait,kiadásait és bevételeit. Adja hozzá új tranzakcióit és tekintse meg az összes tranzakciót az oldalon.Hozd létre a virtuális perselyed és gyűjts. ">
    <meta name="author" content="Petőcz Boglárka, Gémes Lilla">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body class="main-layout">

    <div id="mySidepanel" class="sidepanel">
        <?php include("sidenav.php"); ?>
    </div>
	
    <header id="navbar">
        <?php include("nav.php"); ?>
    </header>
	
	<div class="asztali">
		<div class="wrapper container">
			<div class="panel">
				<div class="panel__content-col">
					<div class="panel__content">
						<div class="panel__text">
							<h1 class="panel__title">Perselyed</h1>
							<p class="panel__addr">Tanulj, tervezz és takarékoskodj</p>
						</div>
						<div class="panel__line"></div>
					</div>
				</div>
				<div class="panel__img-col">
					<img src="images/wrap.webp" alt="Perselyed" class="panel__img">
				</div>
			</div>
		</div>
	</div>
	
	<div class="mobil">
			<img src="images/wrap.webp" alt="Perselyed" class="img-fluid" >
	</div>
	
	<div class="wallet">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3 col-sm-6">
					<a href="szamla.php" id="btnx">
						<div id="wa_hover" class="wallet_box text_align_center">
							<img class="szamla" src="images/wa2.svg" alt="számla"/>
							<h3>Számlák</h3>
						</div>
					</a>
				</div>
				<div class="col-lg-3 col-sm-6">
					<a href="persely.php"> 
						<div id="wa_hover" class="wallet_box text_align_center">
                            <img src="images/wa1.svg" alt="tárca"/>
                            <h3>Persely</h3>
						</div>
					</a>
				</div>
				<div class="col-lg-3 col-sm-6">
					<a href="transaction.php">
						<div id="wa_hover" class="wallet_box text_align_center">
							<img src="images/wa3.svg" alt="telefon"/>
							<h3>Tranzakció kezelő</h3>
						</div>
					</a> 
				</div>
				<div class="col-lg-3 col-sm-6">
					<a href="megtakaritas.php">
						<div id="wa_hover" class="wallet_box text_align_center">
							<img src="images/wa4.svg" alt="diagramm"/>
							<h3>Megtakaritás</h3>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
    <div id="about" class="about mt-5 mb-5">
		<div class="container">
			<div class="row">
				<div class="col-md-10 offset-md-1 text-center">
					<div class="about_border">
						<h2 class="display-4">Rólunk</h2>
						<br>
						<p>
							Az oldalunk célja, hogy segítsünk neked tudatosabban kezelni pénzügyeidet és elérni azokat a pénzügyi célokat,
							amelyeket kitűztél magad elé. Tudjuk, hogy a pénzügyek világa gyakran bonyolult és kihívásokkal teli lehet,
							de mi itt vagyunk, hogy megkönnyítsük ezt az utat és válaszokat adjunk kérdéseidre.<br>Az oldalunkon található eszközök és
							információk segítségével segítünk a pénzügyi tudatosságba.
							Emellett pénzügyi tippeket és tanácsokat is kínálunk, hogy segítsünk neked bölcsebben gazdálkodni a pénzeddel.
							<br>Reméljük, hogy itt minden olyan információt és eszközt megtalálsz, amire szükséged van,
							hogy tudatosan kezeld pénzügyeidet és elérd pénzügyi céljaidat
							Köszönjük, hogy csatlakoztál hozzánk, és bízunk benne, hogy inspiráló és hasznos tartalmat találsz oldalunkon.
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="contact mb-5">
		<div class="container">
			<div class="row">
				<div class="col-md-8 offset-md-2">
					<div class="titlepage text-center">
						<h2>Küldjön nekünk üzenetet</h2>
					</div>
					<form  method="post">
						<fieldset> 
							<div class="row">
								<div class="col-md-12 mb-3">
									<label for="email" class="form-label">Email cím</label>
									<input type="email" class="form-control" id="email" name="email" aria-label="Email cím megadása" required>
								</div>
								<div class="col-md-12 mb-3">
									<label for="message" class="form-label">Üzenet</label>
									<textarea class="form-control" id="message" name="message" aria-label="Üzenet megírása" required></textarea>
								</div>
								<div class="col-md-12">
									<button type="submit" class="btn btn-primary" name="send" value="Küldés" aria-label="Küldés">Küldés</button>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
    <footer>
        <?php include("footer.php") ?>
    </footer>

	<script src="js/bootstrap.bundle.min.js "></script>
	<script src="js/custom.js "></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
	<script>
		$(document).ready(function() {
			var $wrapper = $('.wrapper'),
			$panel = $('.panel'),
			$pContent = $('.panel__content'),
			$img = $('.panel__img-col');

			function initTilt() {
				TweenMax.set([$pContent, $img], { transformStyle: "preserve-3d" 
			});

			$wrapper.mousemove(function(e) {
				var sxPos = e.pageX / $wrapper.width() * 100 - 50;
				var syPos = e.pageY / $wrapper.height() * 100 - 50;

				TweenMax.to($pContent, 2, {
				rotationY: 0.09 * sxPos,
				rotationX: -0.09 * syPos,
				transformPerspective: 500,
				transformOrigin: "center center -400",
				ease: Expo.easeOut
				});
				TweenMax.to($img, 2, {
					rotationY: 0.03 * sxPos,
					rotationX: -0.03 * syPos,
					transformPerspective: 500,
					transformOrigin: "center center -500",
					ease: Expo.easeOut
				});
			});
		}

		initTilt();
		});
		document.getElementsByTagName('html')[0].addEventListener("click", closeNav);
	</script>
	<script>
			const asztaliElem = document.querySelector('.asztali');
			const mobilElem = document.querySelector('.mobil');
			function checkMobileView() {
				if (window.innerWidth <= 768) {
					mobilElem.style.display = 'block';
					asztaliElem.style.display = 'none';
				} else {
					mobilElem.style.display = 'none';
					asztaliElem.style.display = 'block';
				}
			}
			window.addEventListener('DOMContentLoaded', checkMobileView);
			window.addEventListener('resize', checkMobileView);
	</script>
 </body>
</html>
