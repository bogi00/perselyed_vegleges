<?php
session_start();
include '../config.php';

$post = [];

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM blog WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    }
}

?>

<!DOCTYPE html>
<html lang="hu">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Fedezze fel a legfrissebb pénzügyi tippeket és tanácsokat a Pézügyi blogon! Ismerje meg a legújabb befektetési lehetőségeket, pénzügyi tervezési stratégiákat és gazdasági híreket. Legyen naprakész a pénzügyi világban, hogy hatékonyan kezelhesse pénzügyeit és növelhesse vagyonát.">
	<link rel="icon" type="image/x-icon" href="../images/favicon.png">
    <meta name="author" content="Petőcz Boglárka,Gémes Lilla">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">
    <title>Blog</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/owl.css">
  </head>

  <body>

    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <header class="">
		<nav class="navbar navbar-expand-lg">
			<div class="container">
				<a class="navbar-brand" href="index.php"><h2> Perselyed Blog<em>.</em></h2></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarResponsive">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item">
							<a class="nav-link" href="../index.php">Perselyed
								<span class="sr-only">(current)</span>
							</a>
						</li> 
						<li class="nav-item">
							<a class="nav-link" href="index.php">Kezdőlap</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link" href="blog.php">Blog</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
    </header>
    <div class="heading-page header-text">
      <section class="page-heading">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="text-content">
                <h2></h2>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="post-container">
                    <h2 class="text-center"><?php echo $post['title']; ?></h2><br><br>
                    <p><?php echo $post['text']	; ?></p>
                </div>
            </div>
        </div>
    </div>
    <footer>
      <?php include("../footer.php") ?>
    </footer>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/owl.js"></script>
    <script src="assets/js/slick.js"></script>
    <script src="assets/js/isotope.js"></script>
    <script src="assets/js/accordions.js"></script>
    <script language = "text/Javascript"> 
      cleared[0] = cleared[1] = cleared[2] = 0;
      function clearField(t){ 
      if(! cleared[t.id]){                      
          cleared[t.id] = 1; 
          t.value='';        
          t.style.color='#fff';
          }
      }
    </script>


  </body>

</html>
