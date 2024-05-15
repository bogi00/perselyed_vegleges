<?php
require '../config.php';
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 9;
$start = ($page - 1) * $limit;

$category_filter = '';

if(isset($_POST['blogtitle'])) {
    $category_filter = $_POST['blogtitle'];
}

$query_count = "SELECT COUNT(*) as total FROM blog";

$query_blog = "SELECT * FROM blog";

if($category_filter != "összes" && !empty($category_filter)) {
    $query_count .= " WHERE category = '$category_filter'";
    $query_blog .= " WHERE category = '$category_filter'";
}

$result_count = $conn->query($query_count);
$row_count = $result_count->fetch_assoc();
$total_posts = $row_count['total'];
$total_pages = ceil($total_posts / $limit);

if($total_pages == 0) {
    $result_blog = [];
} else {
    if($page > $total_pages) {
        header("Location: ?page=$total_pages&blogtitle=$category_filter");
        exit;
    }

    $query_blog .= " LIMIT $start, $limit";
    $result_blog = $conn->query($query_blog);
}
?>

<!DOCTYPE html>
<html lang="hu">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="Pénzügyi blog, blog, könyvajánló, befektetés, tanécs, tippek">
	<link rel="icon" type="image/x-icon" href="../images/favicon.png">
    <meta name="author" content="Petőcz Boglárka, Gémes Lilla">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">
    <title>Pénzügyi Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
                <a class="nav-link" href="blog.html">Blog</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
		<section class="blog-posts grid-system">
		 <div class="container">
		   <div class="row">
				  <h3 class="mb-4">Pénzügyi blog</h3>
				  <hr>
				  <p class="lead">
				  
			<form method="POST" id="myForm" action="blog.php">
			<div class="col-xl-6 col-lg-12 col-md-12">
				Válassz kategóriát
				<select class="form-control col-xl-6" name="blogtitle" id="blogtitle">
    <option value="összes"<?php if ($category_filter == "összes") echo ' selected'; ?>>Összes kategória</option>
    <?php
    $query = "SELECT DISTINCT category FROM blog"; 
    if ($result = $conn->query($query)) { 
        while ($row = $result->fetch_assoc()) { 
            $category = $row["category"];
            echo '<option value="'.$category.'"';
            if ($category_filter == $category) echo ' selected';
            echo '>'.$category.'</option>';
        }
        $result->free();
    }
    ?>  
</select>

			</div>
		</form>
		  </p>
			  </div></div>
			<div class="container text-center mt-5 py-5">
			</div>
			  <div class="container">
				<div class="all-blog-posts">
				  <div class="row">

		   <div class="container">
				<div class="row">
					<?php            
					if ($result_blog->num_rows > 0) {
						while($row_blog = $result_blog->fetch_assoc()) {
							echo '<div class="col-md-4 col-sm-6">
									<div class="blog-post">
										<div class="blog-thumb">
											<a href="blog-post.php?id='.$row_blog["id"].'"><img src="assets/images/'.$row_blog["image"].'" alt=""></a>
										</div>
										<div class="down-content">
											<a href="blog-post.php?id='.$row_blog["id"].'"><h4>'.$row_blog["title"].'</h4></a>
											<p>'.$row_blog["title2"].'</p>
											<ul class="post-info">
												<li><a href="blog-post.php?id='.$row_blog["id"].'">'.$row_blog["admin"].'</a></li>
												<li><p>'.$row_blog["date"].'</p></li>
											</ul>
										</div>
									</div>
								</div>';
						}
					} else {
						echo "<p>Nincs találat.</p>";
					}
					?>
				</div>
			</div>
		  
				  </div>
				</div>
			  </div>
    </section>
  <div class="container">
        <div class="row">
            <div class="col-md-12 text-center din">
                <?php if ($total_pages > 1): ?>
				<div class="text-center" >
					<?php if ($page > 1): ?>
						<a href="?page=<?php echo $page - 1; ?>&blogtitle=<?php echo $category_filter; ?>" class="btn btn-primary">Előző</a>
					<?php endif; ?>
					
					<?php for ($i = 1; $i <= $total_pages; $i++): ?>
						<a href="?page=<?php echo $i; ?>&blogtitle=<?php echo $category_filter; ?>"class="btn btn-primary" <?php if ($i == $page)  ?>><?php echo $i; ?></a>
					<?php endfor; ?>
					
					<?php if ($page < $total_pages): ?>
						<a href="?page=<?php echo $page + 1; ?>&blogtitle=<?php echo $category_filter; ?>" class="btn btn-primary">Következő</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

				

            </div>
        </div>
    </div>
    
    <footer>
      <?php include("../footer.php") ?>
    </footer>
<script>
    document.getElementById("blogtitle").addEventListener("change", function() {
        document.getElementById("myForm").submit();
    });
</script>
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