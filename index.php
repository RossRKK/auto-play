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
				$id = substr($entry->id, strrpos($entry->id, '/') + 1);
				$title = $entry->title;
				$desc = $entry->content;
				$author = $entry->author->name;
				
				$shouldDisplay1 = strlen($titleCan) < 1;
				$titleCansp = strtok($titleCan, $splitCode);
				while ($titleCansp !== FALSE) {
					if (strpos($title, $titleCansp) !== FALSE) {
						$shouldDisplay1 = TRUE;
					}
					$titleCansp = strtok($splitCode);
				}
				
				$shouldDisplay2 = strlen($titleCant) < 1;
				$titleCantsp = strtok($titleCant, $splitCode);
				while ($titleCantsp !== FALSE) {
					if (strpos($title, $titleCantsp) === FALSE) {
						$shouldDisplay2 = TRUE;
					}
					$titleCantsp = strtok($splitCode);
				}
				
				$shouldDisplay3 = strlen($descCan) < 1;
				$descCansp = strtok($descCan, $splitCode);
				while ($descCansp !== FALSE) {
					if (strpos($desc, $descCansp) !== FALSE) {
						$shouldDisplay3 = TRUE;
					}
					$descCansp = strtok($splitCode);
				}
				
				$shouldDisplay4 = strlen($descCant) < 1;
				$descCantsp = strtok($descCant, $splitCode);
				while ($descCantsp !== FALSE) {
					if (strpos($desc, $descCantsp) === FALSE) {
						$shouldDisplay4 = TRUE;
					}
					$descCantsp = strtok($splitCode);
				}
				
				$shouldDisplay5 = strlen($authorCan) < 1;
				$authorCansp = strtok($authorCan, $splitCode);
				while ($authorCansp !== FALSE) {
					if (strpos($author, $authorCansp) !== FALSE) {
						$shouldDisplay5 = TRUE;
					}
					$authorCansp = strtok($splitCode);
				}
				
				$shouldDisplay6 = strlen($authorCant) < 1;
				$authorCantsp = strtok($authorCant, $splitCode);
				while ($authorCantsp !== FALSE) {
					if (strpos($author, $authorCantsp) === FALSE) {
						$shouldDisplay6 = TRUE;
					}
					$authorCantsp = strtok($splitCode);
				}
				
				if ($shouldDisplay1 and $shouldDisplay2 and $shouldDisplay3 and $shouldDisplay4 and $shouldDisplay5 and $shouldDisplay6) {
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