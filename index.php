<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>TF2 Logs Stats</title>
    <link rel="stylesheet" href="public/style/style.css">
    <link rel="icon" type="image/png" href="public/images/icon.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <?php include __DIR__.'/views/header.php'; ?>
    <div class="desc">
        <p> Get the statistics from your last 200 logs from <a href="http://logs.tf" target="_blank">logs.tf</a>!</p>
    </div>

    <div class="formdiv" id="formcontainer">
        <form action="stats.php" method="post" id="stats_form" style="display:">
            <label for="steamid64">STEAMID64 </label>
            <input type="number" id="steamid64" name="steamid64" data-lpignore="true" required required <?php if (isset($_GET[ 'error'])) { ?> placeholder="Please enter a valid STEAMID"
            <?php } ?>><br>

            <label for="gamemode" required>Game Mode </label>
            <select name="gamemode" id="gamemode">
            <option value="6">6v6</option>
            <option value="9">Highlander</option>
        </select>

            <input type="submit" value="Submit">
        </form>
        <div class="loader" id="loader" style="display:none">Loading...</div>
    </div>

    <?php include __DIR__.'/views/footer.php'; ?>

    <script type="text/javascript">
        $("#stats_form").submit(function(e) {
            $("#stats_form").hide();
            $("#formcontainer").css("background-color", "white");
            $("#loader").show();
        });
    </script>

</body>

</html>