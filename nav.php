<?php
    require 'config.php';
?>

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
								if(mysqli_num_rows($result) > 0) {
									$row = $result->fetch_assoc();
									$img = $row['profile_image'];
									echo '<a href="profil.php">';
									echo '<div style="width: 50px; height: 50px; overflow: hidden; border-radius: 50%; margin-right: 10px;">';
									echo '<img src="' . $img . '" style="width: 100%; height: 100%; object-fit: cover;">';
									echo '</div>';
									echo '</a>';
								} else {
									echo "Felhasználói adatok nem találhatók.";
								}
								$stmt->close();
								$conn->close();
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
<script>
	
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


