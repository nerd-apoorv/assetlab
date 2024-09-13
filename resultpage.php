<?php
session_start();

if (!isset($_SESSION['user_authenticated'])) {
    header("Location: error404.php");
    exit();
}

if (!isset($_GET['file']) || !isset($_GET['desc'])) {
    die("Missing file or description parameters.");
}

$filename = $_GET['file'];
$description = $_GET['desc'];
$username = $_SESSION['username'];
$image_url = "serve_image.php?file=" . urlencode($username . '/' . $filename);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($description); ?> - Generated Image</title>
    	<style>
		body {
			background-color: #000000;
			color: #ffffff;
			font-family: Arial, sans-serif;
			font-size: 16px;
			line-height: 1.5;
			margin: 0;
			padding: 0;
			overflow-y: hidden;
		}
		header {
			background-color: #000000;
			display: flex;
			justify-content: flex-start;
			align-items: center;
			padding: 20px;
		}
		.back-icon {
			font-size: 24px;
			font-weight: bold;
			margin-right: 20px;
			cursor: pointer;
		}
		.container {
			display: flex;
			flex-direction: column;
			align-items: center;
			margin-top: 50px;
		}
		.card {
			width: calc(100% - 50px);
			max-width: 500px;
			height: 400px;
			border: 2px solid #ffffff;
			border-radius: 5px;
			overflow: hidden;
			margin: 20px;
		}
		button {
			display: flex;
			flex-direction: column;
			align-items: center;
			position: relative;
			left: -100px;
			margin-top: 10px;
			margin-bottom: 10px;
			background-color: white;
			color: black;
			font-size: 20px;
			font-weight: bold;
			border: 2px solid #ffffff;
			border-radius: 15px;
			padding: 10px;
			cursor: pointer;
			width: 250%;
			height: 80px;
			border-radius: 15px;
		}
		button:hover {
			background-color: black;
			color: white;
		}
		.card img {
			width: 100%;
			height: 100%;
			object-fit: fill;
		}
		@media (max-width: 600px) {
			button {
				width: 191% !important;
				left: -69px;
				margin-bottom: 10px;
			}
		}
	</style>
</head>

<body>
	<header>
		<span></span>
		<h1><?php echo htmlspecialchars($description); ?></h1>
	</header>
	<div class="container">
		<div class="card">
			<img src="<?php echo $image_url; ?>" alt="Card">
		</div>
		<a href="<?php echo $image_url; ?>" download="<?php echo htmlspecialchars($description); ?>.png"><button><h3>Download</h3></button></a><br>
	</div>
</body>
</html>
