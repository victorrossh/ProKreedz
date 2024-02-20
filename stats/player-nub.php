<?php
$pdo = Database::conexao();

$proRows=$pdo->prepare("SELECT mapname FROM kz_pro15 WHERE authid='".$_GET['authid']."' ORDER BY mapname ASC");
$proRows->execute();

$nubRows=$pdo->prepare("SELECT mapname FROM kz_nub15 WHERE authid='".$_GET['authid']."' ORDER BY mapname ASC");
$nubRows->execute();

$player=$pdo->prepare("SELECT * FROM kz_nub15 WHERE authid='".$_GET['authid']."' ORDER BY mapname ASC LIMIT 1");
$player->execute();

$records = $pdo->prepare("SELECT *, ROUND(time, 6) AS formatted_time FROM kz_nub15 WHERE authid='" . $_GET['authid'] . "' GROUP BY mapname ORDER BY mapname ASC");
$records->execute();

$steamid64 = CalculateSteamid64($_GET['authid']);
$profile = json_decode(file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=EA8285ECAEAF01B8E16F8AB6A28C6B2E&steamids={$steamid64}"));

$steamImg = $profile->response->players[0]->avatarmedium;

function climbtimeToString($time)
{
    $time = explode(".", $time); 
    $seconds = $time[0];
    $milliseconds = isset($time[1]) ? str_pad($time[1], 6, '0', STR_PAD_RIGHT) : '000000'; // Preencher com zeros à direita se tiver menos de 6 casas decimais
    
    $minutes = $seconds / 60;
    $seconds = $seconds % 60;
    
    return sprintf("%02d:%02d<font id=\"milliseconds\">.%06d</font>", $minutes, $seconds, $milliseconds);
}
?>

<div class="content">

    <!-- Image -->
    <div class="user-img">
        <img src="<?php echo SteamImg($steamImg); ?>">
    </div>

    <!-- Name -->
    <?php foreach($player as $data) { ?>
    <h1 class="text-center fw-500 mt-2"><a><?php echo $data['name'];?></a></h1>
    <?php } ?>

    <!-- Menu -->
    <nav>
        <ul class="menu mt-3">
            <li><a href="?page=player-pro&authid=<?php echo $_GET['authid']; ?>">Pro</a><span>(<?php echo $proRows->rowCount(); ?>)</span></li>
            <li><a class="active" href="?page=player-nub&authid=<?php echo $_GET['authid']; ?>">Nub</a><span>(<?php echo $nubRows->rowCount(); ?>)</span></li>
        </ul>
    </nav>

    <!-- Table -->
    <div class="box mt-5">
        <table>
            <thead>
                <tr class="text-uppercase">
                    <th width="6%" align="center"><a href="#">#</a></th>
                    <th width="45%" align="left"><a href="#">Map</a></th>
                    <th width="10%" align="center"><a href="#">Time</a></th>
                    <th width="10%" align="center"><a href="#">Date</a></th>
                </tr>
            </thead>
            
            <?php 
            if($records->rowCount() > 0){
            foreach($records as $data) {

            $position=$pdo->prepare("SELECT * FROM kz_nub15 WHERE mapname='".$data['mapname']."' AND time <= '".$data['time']."' ORDER BY time, name");
			$position->execute();
            ?>
            <tbody>
                <tr>
                    <td align="center"><?php echo Trophy($position->rowCount());?></td>
                    <td align="left" class="ellipsis"><a href="?page=stats-nub&map=<?php echo $data['mapname']?>"><?php echo $data['mapname']?></a></td>
                    <td align="center"><?php echo climbtimeToString($data['formatted_time']); ?></td>
                    <td align="center"><?php echo date("d.m.Y", strtotime($data['date']));?></td>
                </tr>
            </tbody>
            <?php } } else { ?>
            <tbody>
                <tr>
                    <td colspan="4" class="text-center">No Records</td>
                </tr>
            </tbody>
            <?php } ?>
        </table>
    </div>
</div>
