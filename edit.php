<!DOCTYPE html>
<html>
	<head>
		<title> Kalender Bearbeiten </title>
	</head>
	<body>
		<form action="edit_kalender.php" method="POST" target="_self">
			<fieldset>
				<legend> Bearbeiten </legend>
				<label for="name">Name: </label>
				<input type="text" name="name" id="name"> <br />
				
				<label for="kalender">Kalender:</label>
				<!-- <select name="kalender" > -->
				<?php
					include "./connect.php";
					
					// Testzweck, Session benutzen und die ID holen vom user
					$ersteller_ID = 1;
					
					$sql = "SELECT name, kalender_ID 
							FROM kalender
							WHERE ersteller_ID = ?";
					
					$stmt = $db->prepare($sql);
					// Statment füllen
					$stmt->bind_param('i', $ersteller_ID);
					$stmt->execute();
					// Rückgabe holen
					$stmt->bind_results();
					$stmt->fetch();
					
					while ($row = $stmt->fetch()) {
						// echo '<option value="' . $row["kalender_ID"] . '">' . $row["name"] . '</option>';
						echo $row['name'];
					}
				?>
				<!-- </select> -->
			</fieldset>
		</form>
	</body>
</html>