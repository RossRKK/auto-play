<html>
<head>
	<title>
	Auto-Play
	</title>
</head>

<body>
	<h1>Auto-Play</h1>
	
	<h2>Parameters</h2>
	<form method="POST" name="frm1" action="index.php">
		<table>
			<tr><td></td><td>Must Contain</td><td>Cannot Contain</td></tr>
			<tr><td>Title</td><td><input type="text" name="titleCan"></td><td><input type="text" name="titleCant"></td></tr>
			<tr><td>Description</td><td><input type="text" name="descCan"></td><td><input type="text" name="descCant"></td></tr>
			<tr><td>Creator</td><td><input type="text" name="authorCan"></td><td><input type="text" name="authorCant"></td></tr>
		</table>
		<input type="submit" value="Submit">
	</form>
	<?php
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$titleCan = $_POST["titleCan"];
			$titleCant = $_POST["titleCant"];
			$descCan = $_POST["descCan"];
			$descCant = $_POST["descCant"];
			$authorCan = $_POST["authorCan"];
			$authorCant = $_POST["authorCant"];
			$url = 'http://gdata.youtube.com/feeds/api/users/3dsfun/newsubscriptionvideos';
			$xml = simplexml_load_file($url);
			
			echo '<table>';
			foreach ($xml->entry as $entry) {
				$title = $entry->title;
				$desc = $entry->description;
				$author = $entry->author->name;
				if ((strpos($title, $titleCan) !== FALSE or strpos($title, $titleCant) === FALSE)
					and (strpos($desc, $descCan) !== FALSE or strpos($desc, $descCant) === FALSE)
					and (strpos($author, $authorCan) !== FALSE or strpos($author, $authorCant) === FALSE)){
					echo '<tr>';
					echo '<td>' . $entry->title . '</td>' . '<td>' . $entry->author->name . '</td>';
					echo '</tr>';
				}
			}
			echo '</table>';
		}
	?>
</body>
</html>