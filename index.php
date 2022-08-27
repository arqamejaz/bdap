<?php
	require_once "pdo.php";
	session_start();
?>
<html>

	<head>
		<title>Muhammad Arqam Ejaz</title>
	</head>

	<body>
		<div class="container">
			<h1>Welcome to Autos Database</h1>
			<?php
		
				if(! isset ($_SESSION['name'])){
					echo '<p> <a href="login.php">Please log in</a> <br>
							Attempt to <a href="add.php">add data</a> without logging in .
							</p>';
				}
				else {
					if(isset ($_SESSION['error'])){
						echo "<p style='color: red'>".htmlentities($_SESSION['error'])."</p>";
						unset($_SESSION['error']);
					}
					if (isset($_SESSION['success'])) {
						echo "<p style='color: green'>".htmlentities($_SESSION['success'])."</p>";
						unset($_SESSION['success']);
					}
						
					$statement = $pdo->query("SELECT * from autos");
					$row = $statement->fetch(PDO::FETCH_ASSOC);

					
					if($row == false){
						echo "No Rows Found";
					}
					else {
						echo "<table border='1'>"; 
						echo "<tr>";
						echo "<td><p><b> Make </b></p></td>";
						echo "<td><p><b> Model </b></p></td>";
						echo "<td><p><b> Year </b></p></td>";
						echo "<td><p><b> Milage </b></p></td>";
						echo "<td><p><b> Action </b></p></td>";
						echo "</tr>";
					}
					while ( $row = $statement->fetch(PDO::FETCH_ASSOC) ) {
					echo "<tr>";
					echo "<td>".htmlentities($row['make'])."</td>";
					echo "<td>".htmlentities($row['model'])."</td>";
					echo "<td>".htmlentities($row['year'])."</td>";
					echo "<td>".htmlentities($row['mileage'])."</td>";
					echo '<td><a href="edit.php?autos_id='.htmlentities($row['autos_id']).'">Edit</a> / ';
					echo '<a href="delete.php?autos_id='.htmlentities($row['autos_id']).'">Delete</a></td>';
					echo "</tr>";
					}				
				echo "</table>";
				echo '<p> <a href="add.php">Add New Entry</a> </p>
				<p> <a href="logout.php">Logout</a> </p>';
				}
			?>
		</div>
	</body>
</html>