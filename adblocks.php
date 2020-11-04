<?php

error_reporting(E_ALL);

// detect if sent by AJAX
if ($_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") {
    $blocked = $_GET['b'] == 1 ? 1 : 0;

    if (file_exists('adblocks.txt') && $file = explode('-', file_get_contents('adblocks.txt'))) {
        $impressions = $file[0];
        $blocks = $file[1];

        $impressions++;
        $blocks += $blocked;
        $percentage = round((($blocks / $impressions) * 100), 2);
        $reset = trim($file[3]);

        file_put_contents('adblocks.txt', $impressions . '-' . $blocks . ' - ('  . $percentage . '%) - ' . $reset);
    } else {
        $reset = sprintf('started: %s', date('Y/m/d G:i'));
        $percentage = round((($blocked / 1) * 100), 2);
        file_put_contents('adblocks.txt', 1 . '-' . $blocked . ' - (' . $percentage . '%) - ' . $reset);
    }
}