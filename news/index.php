<html>
<head>
<title>Year4000 News</title>
<link  rel="stylesheet" href="http://update.year4000.net/news/style.css" />
</head>
<body>
<?php
if(strstr($_SERVER['HTTP_USER_AGENT'], "Y4KLauncher")){
include("resources/connect.php");
mysql_select_db($mysql_database);
$row = mysql_fetch_assoc(mysql_query('SELECT * FROM `updates` ORDER BY `id` DESC LIMIT 1'));
?>
<div id="h">
	<div id="l"><img src="http://update.year4000.net/news/img/logo.png"></div>
    <div id="v"><b>Latest Version: </b><i><?php echo $row["version"] ?></i></div>
</div>
<?php
}
?>


<?php
	include("resources/connect.php");
	mysql_select_db($mysql_database);
	$sql = 'SELECT * FROM `updates` ORDER BY `id` DESC LIMIT 5';
	$result = mysql_query($sql);
	if (mysql_num_rows($result) == 0) {
		exit;
	}

	while ($row = mysql_fetch_assoc($result)) {
	?>
	<div class="u" id="<?php echo $row["version"]; ?>">
		<div class="uh">
			<h3><?php echo $row["title"]; ?></h3>
			<h4>Posted on: <?php echo $row["date"]; ?></h4>
		</div>
		<p><?php echo $row["text"]; ?></p>
	</div>
	<?php
	}
			
?>

</body>
</html>
