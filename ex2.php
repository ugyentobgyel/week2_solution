<?php
declare(strict_types=1);
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

$counts = [];

// Count only pending requests and tidy Paro/paro into the same name.
foreach ($requests as $r) {
    if ($r['status'] === 'Submitted' || $r['status'] === 'Under review') {
        $dzongkhag = ucfirst(strtolower(trim($r['dzongkhag'])));
        $counts[$dzongkhag] = ($counts[$dzongkhag] ?? 0) + 1;
    }
}

$highest = 0;
foreach ($counts as $count) {
    if ($count > $highest) {
        $highest = $count;
    }
}

$winners = [];
foreach ($counts as $dzongkhag => $count) {
    if ($count === $highest) {
        $winners[] = $dzongkhag;
    }
}

echo 'Busiest: ' . implode(', ', $winners) . ' (' . $highest . ' pending)';
