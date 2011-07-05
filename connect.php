<?php
	if(isset($_POST['aufgabe']))
	{
		//Datenbankverbindung holen:
		include "./verbindung.php";
		
		//Switch operator wir übergeben
		$var = $_POST['aufgabe'];
		//Begin des Switch Blocks zu auswahl der funktion
		switch ($var) 
		{
			case 'erstellen':
				erstellen($_POST['vn'],$_POST['nn'],$_POST['email'],$_POST['password']);
				break;
			case 'bearbeiten':
				bearbeiten($_POST['vn'],$_POST['nn'],$_POST['email'],$_POST['password'],$_POST['id']);
				break;
			case 'loeschen':
				loeschen();
				break;
			case 'ausgeben':
				ausgeben($_POST['id']);
				break;
			default:
				echo "Fehler";
				break;
		}
	}else
		{
			echo "Aufgabe wurde nicht gesetzt";
		}
	//Benutzer erstellen
	function erstellen($vn,$nn,$email,$password)
	{
		//Daten in die Datenbank schreiben
		//Vorbereiten des Statments
		$sql= "INSERT INTO benutzer (vn,nn,email,password) VALUES ( ?,?,?,?)";
		$stmt =$db->prepare($sql);
		//Statement füllen:
		$stmt->bind_param('ssss',$vn,$nn,$email,$password);
		//Überprüfen ob die sql anweisung erfolgreich war
		if(!$stmt ->execute())
		{
			die ("Der Benutzer konnte nicht erstellt werden".$db->error);
		}else{	
				echo "Der Benutzer wurde erstellt";
			}
		 // Aufräumen 
		$stmt->close();
	}
	
	//Benutzer  bearbeitet
	function bearbeiten($vn,$nn,$email,$password,$id)
	{
		//Datenbank Bearbeiten(ein update befehl zum bearbeiten von vorhandenen daten,der in ein statement eingefügt wird):
		$sql = 'UPDATE benutzer SET vn = ?,nn = ?,email = ?,password = ? WHERE benutzer.ID = ? ';
		$stmt = $db->prepare($sql);
		//Statement füllen:
		$stmt->bind_param('ssssi', $vn, $nn, $email, $password, $id);
		if (!$stmt->execute()) 
			{
				die ("Benutzerdaten wurden nicht erfolgreich bearbeitet".$db->error);
			}else 
				{
					echo "Benutzerdaten wurden erfolgreich bearbeitet.";
				}
			$stmt->close();
	}
	
	//Benutzer löschen
	function loeschen($id)
	{
		 // löscht die daten 
		 //Prepart Statments werden vorbereitet
	 $sql='DELETE  from benutzer WHERE benutzer.ID = ?  ';
	 $stmt=$db->prepare($sql);
	 //Statmens werden gefüllt
	 $stmt->bind_param('i', $id );
	if(!$stmt->execute())
		{
			die ("Benutzer konnte nicht gelöscht werden".$db->error);
		}else 
			{
				echo "Benutzerdaten wurden erfolgreich gelöscht.";
			}	
		
	}
	
	//Benutzer ausgeben
	function ausgeben($id)
	{
		//Daten aus der Datenbank holen
		$sql = 'SELECT vn,nn,email FROM
					benutzer WHERE 	
					benutzer.ID = ? ';
					
		$stmt = $db->prepare($sql);
		
		//Statement füllen
		$stmt->bind_param('i', $id);
		//Prüfen ob anweisung ausgeführt
		if (!$stmt->execute()) 
			{
				die ('Etwas stimmte mit dem Query nicht: '.$db->error);
			}else
				{
					//Rückgabe holen
					$stmt->bind_results($vn, $nn, $email);
					$stmt->fetch();
				}
		//Objekt erzeugen
		$obj = new benutzer($vn, $nn, $email);
		
		//JSON erstellen
		echo json_decode($obj);
		
		//entsorgen
		$stmt->close();
		unset($obj);
	}
	
	/** 
	* Klasse für den JSON-Output
	*/
	public class Benutzer
	{
		public $vn;
		public $nn;
		public $email;
		
		public __construct($vn, $nn, $email,)
		{
			// Felder befüllen:
			$this->vn = $vn;
			$this->nn = $nn;
			$this->email = $email;

		}
	
	}
?>