<?php
echo '
    <a href="javascript:void(0)" class="closebtn" name="bezár" onclick="closeNav()">×</a>
    <a class="hover" href="index.php" accesskey="i">Kezdőoldal</a>
    <a class="hover" href="blog/index.php" accesskey="b">Pénzügyi blog</a>
	<a class="hover" href="transaction.php" accesskey="t">Tranzakció kezelő</a>
	<a class="hover" href="megtakaritas.php" accesskey="g">Megtakarítás</a>
	<a class="hover" href="kalkulator.php" accesskey="k">Bérkalkulátor</a>
	<a class="hover" href="persely.php" accesskey="p">Persely</a>
	<a class="hover" href="szamla.php" accesskey="s">Számla</a>
	<a class="hover" style="padding-top:60%;"href="app/perselyed.apk" accesskey="a">Androidra letölthető</a>';
    if(!isset($_COOKIE['user_id'])){
        echo '<form action="login.php" method="post" >
			<a><input type="submit" name="logout" class="active btn btn-secondary" value="Bejelentkezés"></a>
            </form>';
	}
     else{
            echo '<form action="logout.php" method="post" >
                <a><input type="submit" class="btn btn-primary bottombutton" name="logout" class="active" value="Kijelentkezés"></a>
             </form>';
            }
         ?>

<script>function closeNav() {
  document.getElementById("mySidepanel").style.width = "0";
}
</script>