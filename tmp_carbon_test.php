<?php
require __DIR__ . '/vendor/autoload.php';
use Carbon\Carbon;
$date = '2026-05-14';
$dayName = Carbon::parse($date)->locale('fr')->dayName;
$dayNameUpper = Carbon::parse($date)->locale('fr')->dayName;
$dayNameLower = mb_strtolower($dayName);
echo "dayName=$dayName\n";
echo "dayNameLower=$dayNameLower\n";
