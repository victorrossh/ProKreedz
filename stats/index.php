<?php
ini_set("display_errors", 1);

require_once("app/functions.php");

require_once("app/config.php");

spl_autoload_register(function ($class) {
    include_once("class/" . $class . ".class.php");
});

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
	
<body>
	<div id="interface">
	<?php			
	require_once("content.php");
	?>
	</div>
</body>
</html>