<?php
//Stats Pro
if(isset($_GET['page']) && $_GET['page'] == 'stats-pro'){
	include_once("stats-pro.php");
}
//Stats Nub
elseif(isset($_GET['page']) && $_GET['page'] == 'stats-nub'){
	include_once("stats-nub.php");
}
//Stats Rank
elseif(isset($_GET['page']) && $_GET['page'] == 'stats-rank'){
	include_once("stats-rank.php");
}
//Player Pro
elseif(isset($_GET['page']) && $_GET['page'] == 'player-pro'){
	include_once("player-pro.php");
}
//Stats Nub
elseif(isset($_GET['page']) && $_GET['page'] == 'player-nub'){
	include_once("player-nub.php");
}
//Else
else{
	include_once("error.php");
}