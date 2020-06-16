<?php

//we retrieve the steamid64 (to get all the player's logs) and compute the steamid3 (to get his stats inside a log)
$steamid64 = htmlspecialchars($_POST['steamid64']);

if (strlen(strval($steamid64)) != 17) {
    header('Location: index.php?error=true');
    exit();
}

require "steamidconv.php";
$gamemode = intval(htmlspecialchars($_POST['gamemode']));

//API call to get all the player's logs
$url="http://logs.tf/api/v1/log?player=" . $steamid64 . "&limit=200";
$result = file_get_contents($url);
$vars = json_decode($result, true);

//on logs : dpm = "dapm" kdr = "kpd"

//gamecount is used to do the mean for dpm and kdr
$gamecount = 0;
$wins = 0;


$classcounter = array("scout" => 0, "soldier" => 0, "pyro" => 0, "demo" => 0, "heavy" => 0, "engie" => 0, "medic" => 0, "sniper" => 0, "spy" => 0);



for ($i = 0; $i < count($vars['logs']) - 1 ; $i++) { //the '-1' is here for the duplicate check
    $logid = $vars['logs'][$i]['id'];
    $playercount = $vars['logs'][$i]['players'];

    //we check if the next log has the same upload time as the current log, if so this means they are the same so we only analyze one of them
    //example of duplicates : serveme.tf and tf2center uploads

    if (!(($vars['logs'][$i+1]['date'] - 1 <= $vars['logs'][$i]['date']) && ($vars['logs'][$i+1]['date'] + 1 >= $vars['logs'][$i]['date']))) {

        //playercount is used to check if it is an HL or 6v6 match without getting the match logs. 
        if (($playercount >= $gamemode*2) && ($playercount <= $gamemode*2+5)) {

            $url="http://logs.tf/json/" . $logid;
            $result = file_get_contents($url);
            $vars2 = json_decode($result, true);

            //we exclude logs without tftrue by checking if dapm are null.


            if ($vars2['players'][$steamid3]['dapm'] != 0) {

                //we get the game winner
                $scoredif = $vars2['teams']['Red']['score'] - $vars2['teams']['Blue']['score'];

                if ($scoredif > 0) {
                    $winner = 'Red';
                } else if ($scoredif == 0) {
                    $winner = 'Tie';
                } else {
                    $winner = 'Blue';
                }

                if ($winner == $vars2['players'][$steamid3]['team']) {
                    $wins += 1 ;
                }

                $gamecount += 1 ;

                //class counter

                $class = $vars2['players'][$steamid3]['class_stats'][0]['type'];

                switch($class) {
                    case 'scout':
                        $classcounter["scout"] += 1;
                        break;
                    case 'soldier':
                        $classcounter["soldier"] += 1;
                        break;
                    case 'pyro':
                        $classcounter["pyro"] += 1;
                        break;
                    case 'demo':
                        $classcounter["demo"] += 1;
                        break;
                    case 'heavy':
                        $classcounter["heavy"] += 1;
                        break;
                    case 'engie':
                        $classcounter["engie"] += 1;
                        break;
                    case 'medic':
                        $classcounter["medic"] += 1;
                        break;
                    case 'sniper':
                        $classcounter["sniper"] += 1;
                        break;
                    case 'spy':
                        $classcounter["spy"] += 1;
                        break;
                }



                if (!(isset($hidpm))) {
                    $hidpm = $vars2['players'][$steamid3]['dapm'];
                    $hidpmid = $logid;

                    $mdpm = $vars2['players'][$steamid3]['dapm'];
                    $mkdr = $vars2['players'][$steamid3]['kpd'];

                } else {

                    if ($vars2['players'][$steamid3]['dapm'] > $hidpm) {
                        $hidpm = $vars2['players'][$steamid3]['dapm'];
                        $hidpmid = $logid;
                    }

                    $mdpm += $vars2['players'][$steamid3]['dapm'];
                    $mkdr += $vars2['players'][$steamid3]['kpd'];
                }

            }

        }

    }

}

if (!$gamecount== 0) {

    //most played class
    $mostplayed = array_keys($classcounter, max($classcounter));


    // we compute the averages

    $mdpm = $mdpm/$gamecount;
    $mkdr = $mkdr/$gamecount;

    // we format the numbers
    // stackoverflow.com/a/14531760/1431728 for the +0 trick

    $mdpm = round($mdpm,2);
    $mdpm = $mdpm +0;

    $mkdr = round($mkdr,2);
    $mkdr = $mkdr +0;

}

include("results.php");