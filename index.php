<html>
<head>
	<title>
	Auto-Play
	</title>
</head>

<body>
	<h1>Auto-Play</h1>
	
	<h2>Parameters</h2>
	<form method="GET" name="frm1" action="index.php">
		<table>
			<tr><td></td><td>Must Contain</td><td>Cannot Contain</td></tr>
			<tr><td>Title</td><td><input type="text" name="titleCan"></td><td><input type="text" name="titleCant"></td></tr>
			<tr><td>Description</td><td><input type="text" name="descCan"></td><td><input type="text" name="descCant"></td></tr>
			<tr><td>Creator</td><td><input type="text" name="authorCan"></td><td><input type="text" name="authorCant"></td></tr>
		</table>
		<input type="submit" value="Submit">
	</form>
	<?php
		$splitCode = '/';
		
		if ($_SERVER["REQUEST_METHOD"] == "GET") {
			$titleCan = $_GET["titleCan"];
			$titleCant = $_GET["titleCant"];
			$descCan = $_GET["descCan"];
			$descCant = $_GET["descCant"];
			$authorCan = $_GET["authorCan"];
			$authorCant = $_GET["authorCant"];
			$url = 'http://gdata.youtube.com/feeds/api/users/3dsfun/newsubscriptionvideos';
			$xml = simplexml_load_file($url);
			
			echo '<h2>Videos</h2><table>';
			foreach ($xml->entry as $entry) {
				$shouldDisplay = FALSE;
				$id = substr($entry->id, strrpos($entry->id, '/') + 1);
				$title = $entry->title;
				$desc = $entry->content;
				$author = $entry->author->name;
				
				// while ($titleCansp !== FALSE or $descCansp !== FALSE or $authorCansp !== FALSE or $titleCantsp !== FALSE or $descCantsp !== FALSE or $authorCantsp !== FALSE) {
					// if (((strlen($titleCansp) < 1 or strpos($title, $titleCansp) !== FALSE) and (strlen($titleCantsp) < 1 or strpos($title, $titleCantsp) === FALSE))
						// and ((strlen($descCansp) < 1 or strpos($desc, $descCansp) !== FALSE) and (strlen($descCantsp) < 1 or strpos($desc, $descCantsp) === FALSE))
						// and ((strlen($authorCansp) < 1 or strpos($author, $authorCansp) !== FALSE) and (strlen($authorCantsp) < 1 or strpos($author, $authorCantsp) === FALSE))){
						// $shouldDisplay = TRUE;
					// }
				// }
				$titleCansp = strtok($titleCan, $splitCode);
				while ($titleCansp !== FALSE) {
					if (strpos($title, $titleCansp) !== FALSE) {
						$shouldDisplay = TRUE;
					}
					$titleCansp = strtok($splitCode);
				}
				
				$titleCantsp = strtok($titleCant, $splitCode);
				while ($titleCantsp !== FALSE) {
					if (strpos($title, $titleCantsp) === FALSE) {
						$shouldDisplay = TRUE;
					}
					$titleCantsp = strtok($splitCode);
				}
				
				$descCansp = strtok($descCan, $splitCode);
				while ($descCansp !== FALSE) {
					if (strpos($desc, $descCansp) !== FALSE) {
						$shouldDisplay = TRUE;
					}
					$descCansp = strtok($splitCode);
				}
				
				$descCantsp = strtok($descCant, $splitCode);
				while ($descCantsp !== FALSE) {
					if (strpos($desc, $descCantsp) === FALSE) {
						$shouldDisplay = TRUE;
					}
					$descCantsp = strtok($splitCode);
				}
				
				$authorCansp = strtok($authorCan, $splitCode);
				while ($authorCansp !== FALSE) {
					if (strpos($author, $authorCansp) !== FALSE) {
						$shouldDisplay = TRUE;
					}
					$authorCansp = strtok($splitCode);
				}
				
				$authorCantsp = strtok($authorCant, $splitCode);
				while ($authorCantsp !== FALSE) {
					if (strpos($author, $authorCantsp) === FALSE) {
						$shouldDisplay = TRUE;
					}
					$authorCantsp = strtok($splitCode);
				}
				
				if ($shouldDisplay) {
					echo '<tr>';
					echo '<td><h3>' . $entry->title . '</h3></td><td><h4>'  . $entry->author->name . '</h4></td></tr><tr><td><iframe width="427" height="255" src="https://www.youtube.com/embed/' . $id . '" frameborder="0" allowfullscreen></iframe></td><td>' . $entry->content . '</td></tr>';
					echo '</tr>';	
				}
			}
			echo '</table>';
		}
	?>
</body>
</html>