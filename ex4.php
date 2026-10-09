<?php
declare(strict_types=1);
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

$today = '2026-10-07';
$overdue = 0;
$follow_up = 0;
$on_time = 0;

foreach ($requests as $r) {
    if ($r['status'] !== 'Submitted' && $r['status'] !== 'Under review') {
        continue;
    }

    $days = intdiv(strtotime($today) - strtotime($r['submitted']), 86400);
    $band = wait_band($days);

    echo '#' . $r['id'] . ' ' . full_name($r['first'], $r['last'])
        . ' — ' . $days . ' days — ' . $band . '<br>';

    if ($band === 'Overdue') {
        $overdue++;
    } elseif ($band === 'Follow up') {
        $follow_up++;
    } elseif ($band === 'On time') {
        $on_time++;
    }
}

echo $overdue . ' overdue · ' . $follow_up . ' follow up · ' . $on_time . ' on time';
