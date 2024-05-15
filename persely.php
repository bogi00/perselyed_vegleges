<?php
session_start();

require 'config.php';

$goals = [];
$amounts = [];
$selected_goal = '';
$selected_goal_amount = '';
$selected_current_amount = '';
if(isset($_COOKIE['user_id'])) {
		$user_id = $_COOKIE['user_id'];
	}
	else{
		header("Location: login.php");
	}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_COOKIE["user_id"])) {
        $id = $_COOKIE["user_id"];
        $goal_name = $_POST["goal_name"];
        $goal_amount = $_POST["goal_amount"];
        $current_amount = $_POST["current_amount"];

        if($_POST['save_type'] === '1'){
            $sql = "INSERT INTO expens (user_id, goal_name, goal_amount, current_amount) VALUES ('$id', '$goal_name', '$goal_amount', '$current_amount')";
        } else if($_POST['save_type'] === '2'){
            $sql = "UPDATE expens SET current_amount=$current_amount WHERE user_id='$id' AND goal_name='$goal_name'";
        }

        if ($conn->query($sql)) {
            $goals = [];
            $amounts = [];
            $id = $_SESSION["id"];
            $sql_select = "SELECT goal_name, goal_amount, current_amount FROM expens WHERE user_id = '$id'";
            $result = $conn->query($sql_select);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $goals[] = $row['goal_name'];
                    $amounts[] = [
                        'target' => $row['goal_amount'],
                        'current' => $row['current_amount'],
                    ];
                }
            }
            $sql_select = "SELECT goal_name, goal_amount, current_amount FROM expens WHERE user_id = '$id' AND goal_name='$goal_name'";
            $result = $conn->query($sql_select);
            $row = $result->fetch_assoc();
            $selected_goal = $goal_name;
            $selected_goal_amount = $row['goal_amount'];
            $selected_current_amount = $row['current_amount'];
        } else {
            echo json_encode(["success" => false, "message" => "Error saving goal: " . $conn->error]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "You are not logged in!"]);
    }
}
if (!empty($_COOKIE["user_id"])) {
    $goals = [];
    $amounts = [];
    $id = $_COOKIE["user_id"];
    $sql_select = "SELECT goal_name, goal_amount, current_amount FROM expens WHERE user_id = '$id'";
    $result = $conn->query($sql_select);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $goals[] = $row['goal_name'];
            $amounts[] = [
                'target' => $row['goal_amount'],
                'current' => $row['current_amount'],
            ];
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
	<meta name="keywords" content="persely, pénz, megtakaritás, sporólás, gyűjtés, nyaralás,utazás/>
	<meta name="description" content="Persely amivel megtakaritásaidat nyomon tudod követni.">
	<meta name="author" content="Petőcz Boglárka, Gémes Lilla">
    <title>A perselyed</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="Mycss/persely.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://code.jquery.com/jquery-latest.js"></script>
</head>
<body class="bg-info text-black">
	<div class="navok">
	
		<div id="mySidepanel" class="sidepanel">
			<?php include("sidenav.php"); ?>   
		</div>
		<header id="navbar">
			<?php include("nav.php");?>
		</header>
		
	</div><br><br>
	<h2 class="text-center mb-1">Persely</h2>

	
<div class="main-layout persely">
    <div class="container">
        
        <form id="goalForm" method="post">
            <label for="goalName">Cél neve:</label>
            <input type="text" id="goalName" name="goal_name" placeholder="Pl. Nyaralás" required>

            <label for="goalAmount">Cél összege:</label>
            <input type="number" name="goal_amount" id="goalAmount" placeholder="Pl. 3000" required>

            <button type="button" onclick="addOrUpdateGoal('1')">Cél mentése</button>

            <label for="selectGoal">Válassz cél:</label>
            <select id="selectGoal" onchange="updateSelectedGoal()">
                <option value="-1">-- Válassz cél --</option>
                <?php
                for ($i = 0; $i < count($goals); $i++) {
                    if($goals[$i] === $selected_goal){
                        echo '<option selected="selected" value="' . $i . '">' . $goals[$i] . '</option>';
                    } else {
                        echo '<option value="' . $i . '">' . $goals[$i] . '</option>';
                    }
                }
                ?>
            </select>

            <label for="addAmount">Hozzáadandó összeg:</label>
            <input type="number" id="addAmount" placeholder="Pl. 500">

            <button type="button" onclick="addOrUpdateGoal('2')">Hozzáadás</button>
        </form>
    </div>
    <div class="show">
        <p>Célösszeg: <span id="displayGoal"><?php if($selected_goal){echo $selected_goal_amount;}else{echo 0;}?></span> Ft</p>
        <p>Már összegyűjtött: <span id="displayCurrent"><?php if($selected_goal){echo $selected_current_amount;}else{echo 0;}?></span> Ft</p>
        <p>Hiányzó összeg: <span id="displayRemaining"><?php if($selected_goal){echo $selected_goal_amount - $selected_current_amount;}else{echo 0;}?></span> Ft</p>
        <p id="message"></p>
    </div>
	</div>
    <script>
        var goals = <?php echo json_encode($goals); ?>;
        var amounts = <?php echo json_encode($amounts); ?>;
        var selectedIndex = document.getElementById('selectGoal').value;
        var selectedGoal = '<?php echo $selected_goal; ?>';
        if(selectedGoal.length > 0){
            updateSelectedGoal();
        }

        function saveGoal() {
            var goal_name = document.getElementById('goalName').value;
            var goal_amount = parseInt(document.getElementById('goalAmount').value) || 0;

            if (goal_name.trim() === "" || isNaN(goal_amount) || goal_amount <= 0) {
                alert('Kérlek töltsd ki mindkét mezőt helyesen!');
                return;
            }

            if (goals.includes(goal_name)) {
                alert('Ez a cél már szerepel a listában!');
                return;
            }

            addGoalToDatabase(goal_name, goal_amount, 0, 1);

            goals.push(goal_name);
            amounts.push({
                target: goal_amount,
                current: 0
            });

            updateGoalSelector();

            document.getElementById('goalName').value = '';
            document.getElementById('goalAmount').value = '';
        }

        function addGoalToDatabase(goal_name, goal_amount, current_amount, save_type) {
            var xhr = new XMLHttpRequest();
            var data = 'save_type=' + encodeURIComponent(save_type) + '&current_amount=' + encodeURIComponent(current_amount) + '&goal_name=' + encodeURIComponent(goal_name) + '&goal_amount=' + encodeURIComponent(goal_amount);

            xhr.open('POST', 'persely.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.open();
                    document.write(xhr.responseText);
                    document.close();
                }
            };

            xhr.send(data);
        }

        function updateGoalSelector() {
            var selectGoal = document.getElementById('selectGoal');
            selectGoal.innerHTML = '<option value="-1">-- Válassz cél --</option>';
            for (var i = 0; i < goals.length; i++) {
                selectGoal.innerHTML += '<option value="' + i + '">' + goals[i] + '</option>';
            }
        }

        function updateSelectedGoal() {
            selectedIndex = document.getElementById('selectGoal').value;
            if (selectedIndex !== "-1") {
                var selectedGoalIndex = selectedIndex;

                var selectedGoal = goals[selectedGoalIndex];
                var selectedGoalAmount = amounts[selectedGoalIndex].target;
                var selectedGoalCurrent = amounts[selectedGoalIndex].current;

                document.getElementById('displayGoal').textContent = selectedGoalAmount.toLocaleString();
                document.getElementById('displayCurrent').textContent = selectedGoalCurrent.toLocaleString();
                document.getElementById('displayRemaining').textContent = (selectedGoalAmount - selectedGoalCurrent).toLocaleString();
            } else {
                resetDisplay();
            }
        }

        function addOrUpdateGoal(save_type){
            if(save_type === '1'){
                var goal_name = document.getElementById('goalName').value;
                var goal_amount = parseInt(document.getElementById('goalAmount').value) || 0;
                var current_amount = '0';
            } else if(save_type === '2'){
                var goal_name = goals[selectedIndex];
                var goal_amount = parseInt(document.getElementById('addAmount').value) || 0;
                var current_amount = Number(amounts[selectedIndex].current) + goal_amount;
            }
            addGoalToDatabase(goal_name, goal_amount, ''+current_amount, save_type);
            if(save_type === '1'){
                goals.push(goal_name);
                amounts.push({
                    target: goal_amount,
                    current: 0
                });

                updateGoalSelector();

                document.getElementById('goalName').value = '';
                document.getElementById('goalAmount').value = '';
            } else if (save_type === '2'){
                updateSelectedGoal();
            }
        }
	
        function addAmount() {
            var addAmount = parseInt(document.getElementById('addAmount').value) || 0;
                var selectedGoalIndex = selectedIndex;

            if (selectedIndex !== -1) {

                var selectedGoalAmount = amounts[selectedGoalIndex].target;
                var selectedGoalCurrent = amounts[selectedGoalIndex].current;

                if ((selectedGoalAmount - selectedGoalCurrent) >= addAmount) {
                    amounts[selectedGoalIndex].current += addAmount;
                    document.getElementById('message').textContent = 'Sikeresen hozzáadtad az összeget a célhoz!';
                } else {
                    document.getElementById('message').textContent = 'A hozzáadott összeg nem lehet nagyobb a még hiányzó összegnél!';
                }
            } else {
                document.getElementById('message').textContent = 'Válassz ki egy célt a listából!';
            }

            updateSelectedGoal();
            document.getElementById('addAmount').value = '';
        }


        function resetDisplay() {
            document.getElementById('displayGoal').textContent = '0';
            document.getElementById('displayCurrent').textContent = '0';
            document.getElementById('displayRemaining').textContent = '0';
            document.getElementById('message').textContent = '';
        }
    </script>
</div>
<style>

	</style>
</body>
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
   </body>
</html>
<script>
    document.getElementsByTagName('html')[0].addEventListener("click", closeNav);
</script>

