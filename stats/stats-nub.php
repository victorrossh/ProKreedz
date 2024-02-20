<?php
function climbtimeToString($time)
{
    $time = explode(".", $time); 
    $seconds = $time[0];
    $milliseconds = isset($time[1]) ? str_pad($time[1], 6, '0', STR_PAD_RIGHT) : '000000'; // Preencher com zeros à direita se tiver menos de 6 casas decimais
    
    $minutes = $seconds / 60;
    $seconds = $seconds % 60;
    
    return sprintf("%02d:%02d<font id=\"milliseconds\">.%06d</font>", $minutes, $seconds, $milliseconds);
}

$pdo = Database::conexao();

$proRows=$pdo->prepare("SELECT authid FROM kz_pro15 WHERE mapname='".$_GET['map']."'");
$proRows->execute();

$nubRows=$pdo->prepare("SELECT authid FROM kz_nub15 WHERE mapname='".$_GET['map']."'");
$nubRows->execute();

$rankRows=$pdo->prepare("SELECT authid FROM kz_pro15 UNION SELECT authid FROM kz_nub15 GROUP BY authid");
$rankRows->execute();

$mapname=$pdo->prepare("SELECT * FROM kz_nub15 WHERE mapname='".$_GET['map']."' ORDER BY time ASC LIMIT 1");
$mapname->execute();

$records = $pdo->prepare("SELECT *, ROUND(time, 6) AS formatted_time FROM kz_nub15 WHERE mapname='" . $_GET['map'] . "' GROUP BY authid ORDER BY time ASC");
$records->execute();
?>

<div class="content">

    <!-- Title -->
    <h1 class="text-center fw-500"><a><?php echo empty($_GET['map']) ? "Unknown" : $_GET['map'] ?></a></h1>

    <!-- Menu -->
    <nav>
        <ul class="menu mt-3">
            <li><a href="?page=stats-pro&map=<?php echo $_GET['map']; ?>">Pro</a><span>(<?php echo $proRows->rowCount(); ?>)</span></li>
            <li><a class="active" href="?page=stats-nub&map=<?php echo $_GET['map']; ?>">Nub</a><span>(<?php echo $nubRows->rowCount(); ?>)</span></li>
            <li><a href="?page=stats-rank&map=<?php echo $_GET['map']; ?>">Rank</a><span>(<?php echo $rankRows->rowCount(); ?>)</span></li>
        </ul>
    </nav>

    <!-- Table -->
    <div class="box mt-5">
        <table>
            <thead>
                <tr class="text-uppercase">
                    <th width="6%" align="center"><a href="#">#</a></th>
                    <th width="45%" align="left"><a href="#">Player</a></th>
                    <th width="10%" align="center"><a href="#">Time</a></th>
                    <th width="15%" align="center"><a href="#">CP / GC</a></th>
                    <th width="10%" align="center"><a href="#">Date</a></th>
                </tr>
            </thead>

            <?php 
            if($records->rowCount() > 0){
            $i = 0;
            foreach($records as $data) {
            $i++;
            ?>
            <tbody>
                <tr>
                    <td align="center"><?php echo Trophy($i);?></td>
                    <td align="left" class="ellipsis"><a href="?page=player-pro&authid=<?php echo $data['authid'];?>"><?php echo $data['name'];?></a></td>
                    <td align="center"><?php echo climbtimeToString($data['formatted_time']); ?></td>
                    <td align="center"><?php echo $data['checkpoints']."/".$data['gocheck'] ;?></td>
                    <td align="center"><?php echo date("d.m.Y", strtotime($data['date']));?></td>
                </tr>
            </tbody>
            <?php } } else { ?>
            <tbody>
                <tr>
                    <td colspan="5" class="text-center">No Records</td>
                </tr>
            </tbody>
            <?php } ?>
        </table>
    </div>
</div>
