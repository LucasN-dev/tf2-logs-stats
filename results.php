<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>TF2 Logs Stats</title>
    <link rel="stylesheet" href="public/style/style.css">
    <link rel="icon" type="image/png" href="public/images/icon.png">
</head>

<body>
<?php include __DIR__.'/views/header.php'; ?>

<div class="resultsdiv">

    <?php if (!$gamecount== 0) { ?>

        <h3> Your stats from <?= $gamecount ?> unique matches </h3>

        <p> Games won: <?= $wins ?> </p>

        <p> Most played class: <?=$mostplayed[0]?> (<?=$classcounter[$mostplayed[0]]?> games)</p>

        <a class="dpmlink" href="http://logs.tf/<?=$hidpmid?>#<?=$steamid64?>" target="_blank"> Best dpm: <?= $hidpm ?> <div class="linkimage"></div> </a>

        <p> Average dpm: <?= $mdpm ?> </p>
        <p> Average kdr: <?= $mkdr ?></p>
        
    <?php } else { ?>

        <h3> Not enough data </h3>

    <?php }  ?>

<div>

<?php include __DIR__.'/views/footer.php'; ?>

</body>