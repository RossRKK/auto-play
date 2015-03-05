<html>
<head>
	<title>
	Auto-Play
	</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
<!-- Start of SimpleHitCounter Code -->
<div id="counter" align="center"><img src="http://simplehitcounter.com/hit.php?uid=1868894&f=16777215&b=0" border="0" height="0" width="0"></div>
<!-- End of SimpleHitCounter Code -->

	<?php
		if ($_SERVER["REQUEST_METHOD"] == "GET") {
				$titleCan = $_GET["titleCan"];
				$titleCant = $_GET["titleCant"];
				$descCan = $_GET["descCan"];
				$descCant = $_GET["descCant"];
				$authorCan = $_GET["authorCan"];
				$authorCant = $_GET["authorCant"];
				$user = $_GET["user"];
				if ($user) {
					$url = 'http://gdata.youtube.com/feeds/api/users/' . $user . '/newsubscriptionvideos';
					$xml = simplexml_load_file($url);
				}
		}
	?>
	<h1>Auto-Play</h1>
	
	<h2>Parameters</h2>
	<p>Use a "/" as an "OR" e.g. Creator: vlogbrothers/veritassium will return videos by vlog brothers or veritassium.</p>
	<p>You can save your parameters by creating a favourite after you have entered the parameters.</p>
	<form method="GET" name="frm1" action="index.php">
		<p>User: <input type="text" name="user" value="<?php print $user ?>"> Your user is what is says in the address bar after "youtube.com/user/" when you go to youtube and click "My Channel" and then "View as public"</p>
		<table>
			<tr><td></td><td>Must Contain</td><td>Cannot Contain</td></tr>
			<tr><td>Title</td><td><input type="text" name="titleCan" value="<?php print $titleCan ?>"></td><td><input type="text" name="titleCant" value="<?php print $titleCant ?>"></td></tr>
			<tr><td>Description</td><td><input type="text" name="descCan" value="<?php print $descCan ?>"></td><td><input type="text" name="descCant" value="<?php print $descCant ?>"></td></tr>
			<tr><td>Creator</td><td><input type="text" name="authorCan" value="<?php print $authorCan ?>"></td><td><input type="text" name="authorCant" value="<?php print $authorCant ?>"></td></tr>
		</table>
		<input type="submit" value="Submit">
	</form>
	<?php
		$splitCode = '/';
		
		if ($_SERVER["REQUEST_METHOD"] == "GET" and $user) {
			
			echo '<h2>Videos</h2>';
			foreach ($xml->entry as $entry) {
				$id = substr($entry->id, strrpos($entry->id, '/') + 1);
				$title = $entry->title;
				$desc = $entry->content;
				$author = $entry->author->name;
				
				$shouldDisplay1 = strlen($titleCan) < 1;
				$titleCansp = strtok($titleCan, $splitCode);
				while ($titleCansp !== FALSE) {
					if (strpos(strtolower($title), strtolower($titleCansp)) !== FALSE) {
						$shouldDisplay1 = TRUE;
					}
					$titleCansp = strtok($splitCode);
				}
				
				$shouldDisplay2 = TRUE;
				$titleCantsp = strtok($titleCant, $splitCode);
				while ($titleCantsp !== FALSE) {
					if (strpos(strtolower($title), strtolower($titleCantsp)) !== FALSE) {
						$shouldDisplay2 = FALSE;
					}
					$titleCantsp = strtok($splitCode);
				}
				
				$shouldDisplay3 = strlen($descCan) < 1;
				$descCansp = strtok($descCan, $splitCode);
				while ($descCansp !== FALSE) {
					if (strpos(strtolower($desc), strtolower($descCansp)) !== FALSE) {
						$shouldDisplay3 = TRUE;
					}
					$descCansp = strtok($splitCode);
				}
				
				$shouldDisplay4 = TRUE;
				$descCantsp = strtok($descCant, $splitCode);
				while ($descCantsp !== FALSE) {
					if (strpos(strtolower($desc), strtolower($descCantsp)) !== FALSE) {
						$shouldDisplay4 = FALSE;
					}
					$descCantsp = strtok($splitCode);
				}
				
				$shouldDisplay5 = strlen($authorCan) < 1;
				$authorCansp = strtok($authorCan, $splitCode);
				while ($authorCansp !== FALSE) {
					if (strpos(strtolower($author), strtolower($authorCansp)) !== FALSE) {
						$shouldDisplay5 = TRUE;
					}
					$authorCansp = strtok($splitCode);
				}
				
				$shouldDisplay6 = TRUE;
				$authorCantsp = strtok($authorCant, $splitCode);
				while ($authorCantsp !== FALSE) {
					if (strpos(strtolower($author), strtolower($authorCantsp)) !== FALSE) {
						$shouldDisplay6 = FALSE;
					}
					$authorCantsp = strtok($splitCode);
				}
				
				if ($shouldDisplay1 and $shouldDisplay2 and $shouldDisplay3 and $shouldDisplay4 and $shouldDisplay5 and $shouldDisplay6) {
					echo '<tr>';
					echo '<div id="video"><h3>' . htmlentities($entry->title) . '</h3><iframe  src="https://www.youtube.com/embed/' . $id . '" frameborder="0" allowfullscreen></iframe></div><div id="desc"><h4>'  . $entry->author->name . '</h4>' . htmlentities($entry->content) . '</div>';
					echo '</tr>';	
					//width="854" height="510"
				}
			}
		}
	?>
</body>
</html>