<?php

$x = ($steamid64 >> 56) & 0xFF;
if ($x == 1) $x = 0;

$y = $steamid64 & 1;

$z = ($steamid64 >> 1) & 0x7FFFFFF;

$steamid = "STEAM_" . $x . ":" . $y . ":" . $z;

$w= $z*2+$y;

$steamid3 = "[U:1:" . $w . "]";