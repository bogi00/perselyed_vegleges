<div class="sidebar pe-4 pb-3">
     <nav class="navbar bg-secondary navbar-dark">
        <a href="index.html" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class=""></i>Admin</h3>
        </a>
        <div class="navbar-nav w-100"><br><br>
            <a href="index.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Statisztika</a>
            <a href="poszt.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Bejegyzések</a>
            <a href="message.php" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Üzenetek</a>
        </div>
    </nav>
</div>
<div class="content">
    <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
        <a href="#" class="navbar-brand d-flex d-lg-none me-4">
            <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
        </a>
        <a href="#" class="sidebar-toggler flex-shrink-0">
            <i class="fa fa-bars"></i>
        </a>
        <div class="navbar-nav align-items-center ms-auto">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-envelope me-lg-2"></i>
                    <span class="d-none d-lg-inline-flex">Üzenetek</span>
                 </a>
                <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                    <?php while($row = $message->fetch_assoc()) { ?>
                        <a href="message.php" class="dropdown-item">
                            <div class="d-flex align-items-center">
                                 <div class="ms-2">
                                    <h6 class="fw-normal mb-0"><?= substr($row['message'], 0, 12) ?>..</h6>
                                        <small><?= $row['date'] ?></small>
                                </div>
                            </div>
                         </a>
                    <?php } ?>  
                    <hr class="dropdown-divider">
                    <a href="message.php" class="dropdown-item text-center">Összes üzenet</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                 <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
					<span class="d-none d-lg-inline-flex"><?php echo $un;?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                    <a href="logout.php" valclass="dropdown-item">Kijelentkezés</a>
                </div>
            </div>
         </div>
    </nav>
