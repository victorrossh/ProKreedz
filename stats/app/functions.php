<?php
function Points($point){
	$pontos = floor($point * 2);
	
	return $pontos;
}

function Trophy($num) {
	if($num == 1){
		return "<i class='fa fa-trophy' style='color:#FFCD00;'>";
	}elseif($num == 2){
		return "<i class='fa fa-trophy' style='color:#C0C0C0;'>";
	}elseif($num == 3){
		return "<i class='fa fa-trophy' style='color:#CD7F32;'>";
	}else{
		return $num;
	}
} 

function TimeConvert($it)
{
	$iMinC = floor(floor($it)/60);
	$iSecC = $it - (60*$iMinC);
	$text = sprintf("%02d:%s%.2f", $iMinC, $iSecC < 10 ? "0": "", $iSecC);
	$pieces = explode(".", $text);
	$value = $pieces[0].'.'.'<span class="mili">'.$pieces[1].'</span>';
	
	return $value;
}

function CalculateSteamid64($steam_id) {
	if (preg_match('/^STEAM_[0-9]:[0-9]:[0-9]{1,}/i', $steam_id)){
		$steam_id = str_replace("_", ":", $steam_id);
		list($part_one, $part_two, $part_three, $part_four) = explode(':', $steam_id);
		$result = bcadd('76561197960265728', $part_four * 2);
		$result = bcadd($result, $part_two);
		return bcadd($result, $part_three);
	} else{
		return false;
	}
}

function SteamImg($link){
	$string = explode(":", $link);
	$url = "http:".$string[1];
	$size = explode(".", $url);
	$size = $size[0].".".$size[1].".".$size[2].".".$size[3];

	return $size;
}