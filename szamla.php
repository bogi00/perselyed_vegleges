<?php
require 'config.php';
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$total = 0;
$update = false;
$id = 0;
$name = '';
$amount = '';
    if(isset($_COOKIE['user_id'])) {
        $user_id = $_COOKIE['user_id'];
    } 
	else
	{
		$user_id='1';
		$sql = "DELETE FROM budget WHERE user_id = $user_id";
	}

if (isset($_POST['save'])) {
    $budget = $_POST['budget'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];

    $query = mysqli_query($conn, "INSERT INTO budget (name, amount, date, user_id)
	VALUES ('$budget', $amount,'$date', $user_id)");

    $_SESSION['message'] = "Elmentve!";
    $_SESSION['msg_type'] = "primary";

}

$result = mysqli_query($conn, "SELECT * FROM budget WHERE user_id=$user_id");
while ($row = $result->fetch_assoc()) {
    $total = $total + $row['amount'];
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $query = mysqli_query($conn, "DELETE FROM budget WHERE id=$id");
    $_SESSION['message'] = "A törlés megtörtént!";
    $_SESSION['msg_type'] = "danger";

    header("location: szamla.php");
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;

    $result = mysqli_query($conn, "SELECT * FROM budget WHERE id=$id
	AND user_id=$user_id");
    if (mysqli_num_rows($result) == 1) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $amount = $row['amount'];
		$date = $row['date'];
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $budget = $_POST['budget'];
    $amount = $_POST['amount'];
	$date = $_POST['date'];
    $query = mysqli_query($conn, "UPDATE budget SET name='$budget', amount='$amount',date='$date' WHERE id='$id' AND user_id=$user_id");
    $_SESSION['message'] = "A frissítés megtörtént!";
    $_SESSION['msg_type'] = "success";
    header("location: szamla.php");
}

if(isset($_POST['login-btn'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $lekerdezes = "SELECT * FROM users WHERE email='$email'";
        $talalt_fh = $conn->query($lekerdezes);

        
        if(mysqli_num_rows($talalt_fh) == 1){

            $felhasznalo = $talalt_fh->fetch_assoc();
            $hashpass = $felhasznalo['hashpass']; 
            if(password_verify($password, $hashpass)){

                if(mysqli_num_rows($talalt_fh) == 1){
					setcookie('user_id',$felhasznalo['user_id'],time()+360000,'/');
                    header("Location: szamla.php");
                    
                }
                else{
                    echo "<script>alert('Nem jó a felhasználó, vagy a jelszó!')</script>";
                }
            }
            else{
                echo "<script>alert('Nem jó az email cím, vagy a jelszó!')</script>";
            }
        }else{
            echo "<script>alert('Nincs ilyen felhasználó!')</script>";
        }
    }   

 
 ?>

<!DOCTYPE html>
<html lang="hu">
<head>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Perselyed</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <meta name="keywords" content="persely, tranzakciókezelő, pénzügyek, kiadások, bevétel, megtakaritás, tudatos">
    <meta name="description" content="A perselyed  segítségével könnyedén nyomon követheti megtakaritásait,kiadásait és bevételeit. Adja hozzá új tranzakcióit és tekintse meg az összes tranzakciót az oldalon.Hozd létre a virtuális perselyed és gyűjts. ">
    <meta name="author" content="Petőcz Boglárka, Gémes Lilla">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"  crossorigin="anonymous">

</head>
<body class="main-layout">
     <div id="mySidepanel" class="sidepanel">

        
        
    </div>
    <header id="navbar">

    </header>
	<br><br>
	<h2 class="text-center mb-1">Számla</h2>
    <div class="container szamla">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center">Kiadás hozzáadása</h2>
                <br>
                <form action="szamla.php" method="POST">
                    <div class="form-group">
                        <label for="budgetTitle">Kiadás neve</label>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="text" name="budget" class="form-control" id="budgetTitle" placeholder="Add meg milyen kiadásod van" required autocomplete="off"  value="<?php echo $name; ?>">
                    </div>
                    <div class="form-group">
                        <label for="amount">Összeg</label>
                        <input type="text" name="amount" class="form-control" id="amount" placeholder="Add meg a kiadás összegét" required  value="<?php echo $amount; ?>">
                    </div>
                    <div class="form-group">
                        <label for="date">Befizetési határidő</label>
                        <input type="date" name="date" class="form-control" id="date" placeholder="Add meg a határidejét" required  value="<?php echo $date; ?>">
                    </div>
                    <?php if($update == true){ ?>
                    <button type="submit" name="update" class="btn btn-success btn-block">Szerkesztés</button>
                    <?php }else{ ?>
                    <button type="submit" name="save" class="btn btn-primary btn-block mt-4">Mentés</button>
                    <?php } ?>
                </form>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-8 offset-md-2">
                <h2 class="text-center">Teljes befizetni való összege:  <?php echo $total;?>Ft</h2>
                <hr>
                <br><br>
                <h2 class="text-center">Számlák</h2> 
                <?php 
                    $result = $conn->query("SELECT * FROM budget WHERE user_id = $user_id");
                ?>
                <div class="conatiner">
					<div class="row justify-content-center">
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Kiadás neve</th>
										<th>Összege</th>
										<th>Befizetés időpontja</th>
										<th>Műveletek</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										while($row = $result->fetch_assoc()){ ?>
										<tr>
											<td><?php echo $row['name']; ?></td>
											<td><?php echo $row['amount']; ?>Ft</td>
											<td><?php echo date('Y-m-d', strtotime($row['date'])); ?></td>
											<td>
												<a href="szamla.php?edit=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Szerkesztés</a>
												<a href="szamla.php?delete=<?php echo $row['id']; ?>"  class="btn btn-danger btn-sm">Törlés</a>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>	
					</div>
				</div>
			</div>
		</div>
        <?php if(!isset($_COOKIE['user_id'])){ ?>
		<div class="modal fade" id="myModal" role="dialog" data-backdrop="static">
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
									<input type="password" class="form-control mt-1" name="password" placeholder="Jelszó"required> 
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
        <?php } ?>
	</div>
	<?php
		if(!isset($_COOKIE['user_id'])) {	
			echo" 
			<script>
				var modal = document.getElementById('myModal');
				$(document).ready(function(){
					$('#myModal').modal('show');
				});
			</script>  ";    
			}
	?>
	<script src="js/jquery-3.2.1.slim.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.min.js "></script>
	<script src="js/bootstrap.bundle.min.js "></script>
    <script src="js/jquery-3.0.0.min.js "></script>
    <script src="js/custom.js "></script>
	<script>
		$('#mySidepanel').load('sidenav.php');
		$('#navbar').load('nav.php');
		$('#footer').load('footer.php');
		document.getElementsByTagName('html')[0].addEventListener("click", close);
	</script> 
	<footer>
        <?php include("footer.php") ?>
	</footer>	  
</body>
</html>


