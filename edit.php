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
					// Statment f�llen
					$stmt->bind_param('i', $ersteller_ID);
					$stmt->execute();
					// R�ckgabe holen
					$stmt->bind_result($kalender_ID, $name);
										
					while ( $stmt->fetch() ) {
						// echo '<option value="' .$kalender_ID. '">' .$name. '</option>';
						echo $name;
					}
				?>
				<!-- </select> -->
			</fieldset>
		</form>
	</body>
</html>