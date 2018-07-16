<?php
    ob_start();
	include("resources/connect.php");
	mysql_select_db($mysql_database);
    $query = substr($_SERVER["REQUEST_URI"],1);

    // Load the news panel
    if($query == "news/" || $query == "news"){
        include("news/index.php");
        die;
    }

    // What mod pack to run.
	if(strstr($_SERVER['HTTP_USER_AGENT'], "Y4KLauncher") && true){
        if($query == "mclauncher/"){
		$handle = opendir("mclauncher");
		$folderarray = array();
		while ($entry = readdir($handle)) {
			if($entry == "." || $entry == ".." || $entry == "index.php"){
			} else{
				array_push($folderarray, $entry);
			}
		}
		closedir($handle);
		sort($folderarray);
		$version = substr($folderarray[count($folderarray)-1],1);
		echo($version);
        exit;
        }
		if($_GET["p"] != null){
			if($_GET["l"] != null || $_GET["pu"] != null){
				header('Content-Type: application/xml; charset=utf-8');
				echo("<update>");
				echo("<latest>".$_GET["l"]."</latest>");
				echo("<packageurl>".$_GET["pu"]."</packageurl>");
				echo("</update>");
				exit;
			} else{
				header('Location: //update.year4000.net/mc/'. $_GET["p"] .'.xml');
			}
		} else{
			//$row = mysql_fetch_assoc(mysql_query('SELECT * FROM `updates` ORDER BY `id` DESC LIMIT 1'));
			header('Content-Type: application/xml; charset=utf-8');
			echo("<update>");
			//echo("<latest>".$row["version"]."</latest>");
			echo("<latest>alpha12a</latest>");
			//echo("<packageurl>".$row["versionurl"]."</packageurl>");
			echo("<packageurl>https://update.year4000.net/mc/y4k/valpha12a/modpack.xml</packageurl>");
			echo("</update>");
			exit;
		}
	}

    // Loads and set the vars for the server status.
    require("MinecraftQuery.class.php");
    $mcquery = new MinecraftQuery();
    $maxPlayers;
    $numPlayers;
    $online;
    $status;

    try {
        $mcquery -> Connect('mc.year4000.net');
        $online = true;
        $status = "Online";
        $info = $mcquery -> GetInfo(); 
        $maxPlayers = $info["MaxPlayers"];
        $numPlayers = $info["Players"];
    }
    catch(MinecraftQueryException $e) {
        $online = false;
        $status = "Offline";
    }
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Year4000 Update<?php  if($query && substr($query,-1) == "/") echo " - ".ucwords(substr($query,0,-1))?></title>
<link href="//update.year4000.net/resources/style.css" rel="stylesheet" type="text/css" />
<script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<link rel="shortcut icon" href="//update.year4000.net/favicon.ico" />
<meta name="description" content="Download the latest version of the launcher, the texture pack, and the worlds. You can download later versions but its recommended that you recive the latest and the greatest." />
<meta name="keywords" content="Y4K, Year4000, Minecraft, Mods, Mojang, MCLauncher, Texture Pack, World Download, Map Download, Download, ewized" />
</head>

<body>

<header id="vcw">
	<div id="vcbg"></div>
	<div id="vc">
        <img src="//update.year4000.net/resources/img/logo.png" alt="Year4000"/><br  />
        Sorry you do not have a compatible browser to view this page.<br />
        Upgrade to a recommended browser Chrome, Firefox, or Safari.
    </div>
</header>
<div id="c" class="center">
    <header id="header">
        <div id="logo">
			<a href="//www.year4000.net/"><img src="//www.year4000.net/resources/img/logo.png" alt="Year4000" /></a>
		</div>
		<div id="topmenu">
			<a href="//www.year4000.net/account/login/">Login</a> / <a href="//www.year4000.net/account/register/">Register</a>
		</div>
    </header>
    
    <section id="s">
        <nav id="m">
            <ul>
                <li><a href="/" title="View the launcher's newspanel">News</a></li>
                <li><a href="/mclauncher/" title="Download the latest version">Y4KLauncher</a></li>
                <li><a href="/mc/" title="Download any version you want">Modpack Files</a></li>
                <li><a href="/resourcepack/" title="Download the latest version">Resource Pack</a></li>
                <li><a href="/map/" title="Download the latest version">Map</a></li>
            </ul>
        </nav>
        <aside id="sb">
        	<div>
            	<h3>Downloads / Updates</h3>
                <p> Download the latest version of the launcher, the texture pack, and the worlds. You can download later versions but its recommended that you receive the latest and the greatest.</p>
            </div>
			<div>
			<h3>Mod List / Permissions</h3>
			<p> Want to know what mods that we have installed, or just here to check if all is legal view this spreadsheet for all the info. <a href="http://goo.gl/tmK2T">http://goo.gl/tmK2T</a></p>
            </div>
            <div>
            	<h3>Server Status</h3>
                <p>
                <?php
                    if ($online) {
                        echo("Year4000: <span style=\"color:#3a3\">" . $status . "</span>");
                        echo(" Players: " . $numPlayers . "/" . $maxPlayers);
                    }
                    else {
                        echo("Year4000: <span style=\"color:#a33\">Server can not open query.</span>");
                    }
                ?>
				</p>
            </div>
        </aside>
        <article id="cm">
			<?php
			$query = substr($_SERVER["REQUEST_URI"],1);
				if($query==""){
					$page = "news/";
				} else{
					$page = strtolower($query);
				}
			?>
			<h3><?php 
                if( substr($page,-1) == "/"){
                    echo substr($page,0,-1);
                } else{
                    echo $page;
                }
            ?></h3>
            
            <div id="ad">
                <!-- year4000 update -->
                <ins class="adsbygoogle"
                     style="display:inline-block;width:468px;height:60px"
                     data-ad-client="ca-pub-8765959378419181"
                     data-ad-slot="3182440553"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>

			<?php
				if($page == "news/"){
			?>
         
            <div id="mcn" class="sc">
<?php
			$sql = 'SELECT * FROM `updates` ORDER BY `id` DESC';
			$result = mysql_query($sql);
			if (mysql_num_rows($result) == 0) {
				echo "No new found.";
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

            </div>
<?php
		} elseif(is_dir($page)) {
			$handle = opendir($page);
			$folderarray = array();
			$filearray = array();
			while ($entry = readdir($handle)) {
			if($entry == "." || $entry == ".." || $entry == "index.php"){
			} elseif(strstr($entry, ".") == false){
				array_push($folderarray, $entry);
			} elseif(strstr($entry, ".") == true && $entry != ".."){
				array_push($filearray, $entry);
			}
			}
			closedir($handle);
			sort($folderarray);
			sort($filearray);
?>
<ol class="sc">
<?php
			foreach($folderarray as $folder){
				?><li><a href="/<?php echo $page.$folder?>/"><?php echo $folder ;
				
				if($folderarray[count($folderarray)-1] == $folder){
					if($page=="mclauncher" || $page=="mclauncher/"){
						echo(" <span style='color:#FF0000;'>(Latest)</span>");
					}
				}
				
				?></a></li><?php
			}
			foreach($filearray as $file){
				?><li><a href="/download.php?file=<?php echo $page.$file?>"><?php echo $file ;
				
				if($filearray[count($filearray)-1] == $file){
					if($page=="texturepack" || $page=="resourcepack/" || $page=="map/world" || $page=="map/world/" || $page=="map/world_nether" || $page=="map/world_nether/" || $page=="map/world_the_end" || $page=="map/world_the_end/"){
						echo(" <span style='color:#FF0000;'>(Latest)</span>");
					}
				}
				
				?></a></li><?php 
			}
?>
			</ol>
<?php
		} else{
			header("HTTP/1.0 404 Not Found");
?>
				<b>Sorry this is not a valid directory that you can open.</b>
<?php
		}	
?>
        </article>
    </section>
    
    <footer id="f">
	Copyright &copy <?php echo date("Y"); ?> Year4000 - Created by ewized
    </footer>
</div>

</body>
</html>
