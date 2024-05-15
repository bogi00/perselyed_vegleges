<?php
	require 'config.php';
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	if(isset($_COOKIE['user_id'])) {
		$user_id = $_COOKIE['user_id'];
	}
	else{
		$user_id='1';
	}

?>
<!DOCTYPE html>
<html lang="hu">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" type="image/x-icon" href="images/favicon.png">
	<link rel="icon" type="image/x-icon" href="images/favicon.png">
	<link rel="stylesheet" href="Mycss/transaction.css">
	<link rel="stylesheet" href="css/style.css" >
	<link rel="stylesheet" href="css/responsive.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="keywords" content="tranzakció, tranzakció kezelő,kiadás, bevétel"/>
	<script src="https://code.jquery.com/jquery-latest.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
   
  <title>Tranzakció kezelő</title>
</head>
<body>

<div class="navbb">
	<div id="mySidepanel" class="sidepanel">
			<?php include("sidenav.php"); ?>   
		</div>
				<header id="navbar">
					<div class="head-top">
						<div class="container-fluid">
							<div class="row d_flex">
								<div class="col-sm-3">
									<li>
										<div class="nav-toggle" onclick="toggleNav()">
											<button class="openbtn" name="navbar" onclick="toggleNav()">
												<img src="images/menu_btn.png" alt="kinyit">
											</button>
										</div>
									</li>
								</div>
								<div class="col-sm-9">
									<ul class="email text_align_right">
										<nav>
											<?php
												if(isset($_COOKIE['user_id'])) {
													$user_id = $_COOKIE['user_id'];
													$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
													$stmt->bind_param("i", $user_id);
													$stmt->execute();
													$result = $stmt->get_result();
													$row = $result->fetch_assoc();
													$img = $row['profile_image'];
													echo '<a href="profil.php">';
													echo '<div style="width: 50px; height: 50px; overflow: hidden; border-radius: 50%; margin-right: 10px;">';
													echo '<img src="' . $img . '" style="width: 100%; height: 100%; object-fit: cover;">';
													echo '</div>';
													echo '</a>';
												}
											?>

										</nav>
										<div class="cim" style="padding-left: 3%;">
											<h2><a href="index.php" style="text-decoration: none; color: inherit;">Perselyed</a></h2>
										</div>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</header>
			</div>
				<?php
					if(!isset($_COOKIE['user_id'])) {	
					 echo"
					 <script>
						var modal = document.getElementById('myModal');
						$(document).ready(function(){
							$('#myModal').modal('show');
						});
					</script>";    
					 }
				?>
			<div class="container tran">
				<main>
					<header class="tran secondary">
						<div>
							 <h5>Teljes összeg</h5>
							<span id="balance">
								<?php
								$result = mysqli_query($conn, "SELECT SUM(amount) AS totalSum FROM tranzakcio WHERE user_id=$user_id");
								$row = $result->fetch_assoc();
								$totalSum = $row['totalSum'];
								echo  $totalSum.' Ft';
								?>
							</span>
						</div>
						<div>
							<h5>Jövedelem</h5>
							<span id="jov">
							 <?php
								$result0 = mysqli_query($conn, "SELECT SUM(amount) AS totalSum FROM tranzakcio WHERE user_id=$user_id and type='bevetel'");
								$row0 = $result0->fetch_assoc();
								$totalSum0 = $row0['totalSum'];
								echo  $totalSum0.' Ft';
								?>
							</span>
						</div>
						<div>
						  <h5>Kiadás</h5>
						  <span id="kiad">
							<?php
								$result0 = mysqli_query($conn, "SELECT SUM(amount) AS totalSum FROM tranzakcio WHERE user_id=$user_id and type='kiadas'");
								$row0 = $result0->fetch_assoc();
								$totalSum0 = $row0['totalSum'];
								echo  $totalSum0.' Ft';
							?>
						  </span>
						</div>
					</header>
					<section>
						<h3>Tranzakció</h3>
						<ul id="transactionList">
						<?php
						$result = mysqli_query($conn, "SELECT * FROM tranzakcio WHERE user_id=$user_id ORDER BY id DESC ");

						while ($row = $result->fetch_assoc()) {
							$id = $row['id'];
							$amount = $row['amount'];
							 $dates = $row['dates'];
							  $name = $row['name'];
							$type = $row['type'];
							if($type=="kiadas")
							{
								$szin="style='color:red;'";
								
							}
								
							else 
							{
								$szin="style='color:green;'";
								
							}
							
							
							echo '<li>
								<div class="data1" '.$szin.'>'.$amount.'Ft</div>
								
								<div class="data3">'.$name.'</div>
								<div class="data2">'.$dates.'</div>
								<div class="data4"><button class="delete-button" value="'.$id.'">Törlés</button></div>
							  </li>';
						}
						?>
						</ul>
						<div id="status"></div>
					</section>
					<section>
						<h3>Tranzakció hozzáadása</h3>
						<form  id="transactionForm">
							<div>
							   <label for="type">
									<input type="checkbox" id="type" value="kiadas" checked />
									<div class="optionee"> <span>Bevétel</span>
										<span>Kiadás</span>
									</div>
								</label>
							</div>
							<div>
								<label for="name">Tranzakció neve</label>
								<input type="text" name="names" id="names" required />
							</div>
						   <div class="row">
								<div class="col">
									<div class="row">
										<div class="col">
											<label for="amount" class="form-label">Összeg</label>
										</div>
										<div class="col">
											<input
												type="number"
												class="form-control"
												name="amount"
												id="amount"
												value="0"
												min="1"
												step="1"
												required
											/>
										</div>
									</div>
								</div>
								<div class="col">
									<div class="row">
										<div class="col">
											<label for="dates" class="form-label">Dátum</label>
										</div>
										<div class="col">
											<input
												type="date"
												class="form-control"
												name="dates"
												id="dates"
												required
											/>
										</div>
									</div>
								</div>
							</div>
							<input type="hidden" name="selected_type" id="selectedType" value="" />
							<button type="button" id="submitFormBtn">Küldés</button>
						</form>
					</section>
				</main>
			</div>
			<div class="modal fade modp" id="myModal" role="dialog" data-backdrop="static">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header" style="padding:35px 50px;">
							
							<h4><span class="glyphicon glyphicon-lock"></span> Bejelentkezés szükséges</h4>
							<a href="index.php"><button type="button"  class="close" >&times;</button></a>
						</div>
						<div class="modal-body" style="padding:40px 50px;">
							<form action="szamla.php" method="post">
								<div class="registration-form  text-dark">
									<div class="form-group">
										 <label>Email</label>
										  <input type="text" class="form-control mt-1" name="email" placeholder="email" required> 
									</div>
									 
									<div class="form-group">
										 <label class="mt-3">Jelszó</label>
										  <input type="text" class="form-control mt-1" name="password" placeholder="Jelszó"required> 
									</div>
									
									<div class="col-lg-12 col-md-12 mt-4">
										<input type="submit" class="btn btn-primary btnw" value="Bejelentkezés" name="login-btn">      
									</div>
								</div> 
							</form> 
						</div>
						<div class="modal-footer">
							<p class="btnbal ft-g"><a href="registration.php" >Regisztráció</a></p>
							<p class="btnjobb ft-g" ><a href="forgot_pass.php" >Elfelejtett jelszó</a></p>
						</div>
					</div>
				</div>
			</div>
	</div>
	<script>
	
		 $(document).ready(function(){
			$('#submitFormBtn').click(function(e){
			  e.preventDefault();
	  var selectedType = $('#type').is(':checked') ? $('#type').val() : 'bevetel';
	  $('#selectedType').val(selectedType);

				var formData = $('#transactionForm').serialize();
				
				$.ajax({
					type: 'POST',
					url: 'transaction2.php',
					data: formData,
					
		  success: function(response){
		window.location.reload();
	   

	},
					error: function(xhr, status, error){
						console.error(xhr.responseText);
					}
				});
			});
	   });		
		 $(document).ready(function(){	
			 $('.delete-button').click(function() {
			var id = $(this).val();
			$.ajax({
				type: 'POST',
				url: 'delete_transaction.php',
				data: { id: id },
				success: function(response){
					window.location.reload();
				},
				error: function(xhr, status, error){
					console.error(xhr.responseText);
				}
			});
		});
			
			
		});
		function toggleNav() {
						const width = $("#mySidepanel").width();
						if (width !== 0) {
							closeNav();
						} else {
							openNav();
						}
						event.stopPropagation();
					}
	</script>
	<footer>
        <?php include("footer.php") ?>
  </footer>
	
		<script src="js/popper.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
      <script src="js/bootstrap.bundle.min.js "></script>
 
	<script src="js/custom.js "></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>

</body>
</html>