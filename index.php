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
			$url = 'http://gdata.youtube.com/feeds/api/users/3dsfun/newsubscriptionvideos';
			$xml = simplexml_load_file($url);
			foreach ($xml->entry as $entry) {
				$title = $entry->title;
				if (strpos($title, $titleCan) !== FALSE and strpos($title, $titleCant) === FALSE){
					echo $entry->title . '<br>';
				}
			}
		}
	?>
</body>
</html>