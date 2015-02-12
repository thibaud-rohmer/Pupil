<?php


/// Autoload classes
function my_autoload($class){
	if(file_exists(dirname(__FILE__)."/src/php/$class.php")){
		require(dirname(__FILE__)."/src/php/$class.php");
	}else{
		return FALSE;
	}
}

spl_autoload_register("my_autoload");

$conf 		= parse_ini_file("conf.ini");
$all_files 	= new Folder($conf["path"]);

// List TV Shows
Parser::getShows($conf["path"],true);
if(isset($_GET['s'])){
	$show = Parser::getShow($_GET['s']);
}else{

}

usort(Parser::$shows, function($a, $b)
{
    return $a->date < $b->date;
});

?>

<!DOCTYPE html>


<header>
		<link rel="stylesheet" href="src/stylesheets/grids-responsive-min.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<link rel="stylesheet" href="src/stylesheets/pure-min.css" type="text/css" media="screen" title="no title" charset="utf-8">	
		<link rel="stylesheet" href="src/stylesheets/layout.css" type="text/css" media="screen" title="no title" charset="utf-8">	
                <link rel="stylesheet" href="src/stylesheets/style.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">	
		<title><?php echo $conf["website-name"]; ?></title>
</header>


<body id="index" onload="">
	<div id='layout' class='content pure-g'>
		<div id='nav' class='pure-u'>
<a href="#" class="nav-menu-button">Menu</a>
			<div class='nav-inner'>
				<div class='pure-menu pure-menu-open'>
					<ul>
						<li class='pure-menu-heading'><?php echo $conf["website-name"]; ?></li>
						<li><a href='?s=""'>Series</a></li>
						<li><a href='?v=1'>Files</a></li>
					<ul>
				</div>
			</div>
		</div>
		<?php
		if(isset($_GET['v']) && $_GET['v'] == 1){
			echo "<div id='data' class='pure-u-1-1' style='margin: 20px 20px 20px -300px;'>";
			echo $all_files;
			echo "</div>";
			echo "</div>";
			exit(0);
		}
		?>
		<div id='list' class='pure-u-1'>
				<?php
				foreach(Parser::$shows as $s){
					$s->small_print();
				}
				?>
		</div>
		<div id='data' class='pure-u-1-1'>
			<?php 
			echo $show->toHTML();
			?>
		</div>
	
	</div>
</body>



