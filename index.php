<html>
<head>
	<title>
	Auto-Play
	</title>
	<link rel="stylesheet" href="style.css">
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<link rel="shortcut icon" href="/favicon.ico">
	<link rel="icon" sizes="16x16 32x32 64x64" href="/favicon.ico">
	<link rel="icon" type="image/png" sizes="196x196" href="/favicon-192.png">
	<link rel="icon" type="image/png" sizes="160x160" href="/favicon-160.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96.png">
	<link rel="icon" type="image/png" sizes="64x64" href="/favicon-64.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16.png">
	<link rel="apple-touch-icon" href="/favicon-57.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/favicon-114.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/favicon-72.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/favicon-144.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/favicon-60.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/favicon-120.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/favicon-76.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/favicon-152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/favicon-180.png">
	<meta name="msapplication-TileColor" content="#FFFFFF">
	<meta name="msapplication-TileImage" content="/favicon-144.png">
	<meta name="msapplication-config" content="/browserconfig.xml">
</head>

<body>

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
	<h1>Auto<image src="logo.png"></image></h1>
	
	
	<h2>Settings</h2>
	<p>Use a "/" as an "OR" e.g. Creator: vlogbrothers/veritassium will return videos by vlog brothers or veritassium.</p>
	<p>You can save your settings by creating a favourite after you have entered the settings.</p>
	<form method="GET" name="frm1" action="index.php">
		<p>User: <input type="text" name="user" value="<?php print $user ?>"> </p>
		<p>Your user is what is says in the address bar after "youtube.com/user/" when you go to youtube and click "My Channel" and then "View as public"</p>
		<table>
			<tr><td></td><td>Must Contain</td><td>Cannot Contain</td></tr>
			<tr><td>Title</td><td><input class="table" type="text" name="titleCan" value="<?php print $titleCan ?>"></td><td><input type="text" class="table" name="titleCant" value="<?php print $titleCant ?>"></td></tr>
			<tr><td>Description</td><td><input class="table" type="text" name="descCan" value="<?php print $descCan ?>"></td><td><input type="text" class="table" name="descCant" value="<?php print $descCant ?>"></td></tr>
			<tr><td>Creator</td><td><input class="table" type="text" name="authorCan" value="<?php print $authorCan ?>"></td><td><input type="text" class="table" name="authorCant" value="<?php print $authorCant ?>"></td></tr>
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
					echo '<h3>' . htmlentities($entry->title) . '</h3><div id="video"><iframe  src="https://www.youtube.com/embed/' . $id . '" frameborder="0" allowfullscreen></iframe></div><div id="desc"><h4>'  . $entry->author->name . '</h4>' . htmlentities($entry->content) . '</div>';
					echo '</tr>';	
					//width="854" height="510"
				}
			}
		}
	?>
</body>
</html>