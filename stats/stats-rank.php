<?php
$pdo = Database::conexao();

$proRows=$pdo->prepare("SELECT authid FROM kz_pro15 WHERE mapname='".$_GET['map']."'");
$proRows->execute();

$nubRows=$pdo->prepare("SELECT authid FROM kz_nub15 WHERE mapname='".$_GET['map']."'");
$nubRows->execute();

$rankRows=$pdo->prepare("SELECT authid FROM kz_pro15 UNION SELECT authid FROM kz_nub15 GROUP BY authid");
$rankRows->execute();

$mapname=$pdo->prepare("SELECT * FROM kz_pro15 WHERE mapname='".$_GET['map']."' ORDER BY time ASC LIMIT 1");
$mapname->execute();

$rank=$pdo->prepare("SELECT *, COUNT(authid) AS maps FROM kz_pro15 GROUP BY authid ORDER BY maps DESC LIMIT 9999");
$rank->execute();
?>

<div class="content">

    <!-- Title -->
    <h1 class="text-center fw-500"><a><?php echo empty($_GET['map']) ? "Unknown" : $_GET['map'] ?></a></h1>

    <!-- Menu -->
    <nav>
        <ul class="menu mt-3">
            <li><a href="?page=stats-pro&map=<?php echo $_GET['map']; ?>">Pro</a><span>(<?php echo $proRows->rowCount(); ?>)</span></li>
            <li><a href="?page=stats-nub&map=<?php echo $_GET['map']; ?>">Nub</a><span>(<?php echo $nubRows->rowCount(); ?>)</span></li>
            <li><a class="active" href="?page=stats-rank&map=<?php echo $_GET['map']; ?>">Rank</a><span>(<?php echo $rankRows->rowCount(); ?>)</span></li>
        </ul>
    </nav>

    <!-- Table -->
    <div class="box mt-5">
        <table>
            <thead>
                <tr class="text-uppercase">
                    <th width="6%" align="center"><a href="#">#</a></th>
                    <th width="45%" align="left"><a href="#">Player</a></th>
                    <th width="10%" align="center"><a href="#">Points</a></th>
                    <th width="10%" align="center"><a href="#">Pro</a></th>
                    <th width="10%" align="center"><a href="#">Nub</a></th>
                </tr>
            </thead>

            <?php 
            if($rank->rowcount() > 0){
            $i = 0;
            foreach($rank as $data) {
            $i++;

            $nub=$pdo->prepare("SELECT *, COUNT(authid) AS maps FROM kz_nub15 WHERE authid = '".$data['authid']."' LIMIT 0,10");
            $nub->execute();
            $nubData=$nub->fetch(PDO::FETCH_BOTH);
            ?>
            <tbody>
                <tr>
                    <td align="center"><?php echo Trophy($i);?></td>
                    <td align="left" class="ellipsis"><a href="?page=player-pro&authid=<?php echo $data['authid'];?>"><?php echo $data['name'];?></a></td>
                    <td align="center"><?php echo Points($data['maps']); ?></td>
                    <td align="center"><?php echo $data['maps']; ?></td>
                    <td align="center"><?php echo $nubData['maps']; ?></td>
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