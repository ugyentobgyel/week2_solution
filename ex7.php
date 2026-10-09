<?php
declare(strict_types=1);
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

$by_cid = [];

foreach ($requests as $r) {
    $cid = $r['cid'];

    if (!isset($by_cid[$cid])) {
        $by_cid[$cid] = [];
    }

    $by_cid[$cid][] = $r['id'];
}

foreach ($by_cid as $cid => $ids) {
    if (count($ids) > 1) {
        echo 'Duplicate ' . $cid . ': requests ' . implode(', ', $ids) . '<br>';
    }
}

foreach ($requests as $r) {
    if (!is_valid_cid($r['cid'])) {
        echo 'Invalid CID in request ' . $r['id'] . ': ' . $r['cid'] . '<br>';
    }
}

// A duplicate CID is not automatically proof of an error. Karma should verify
// the identity and supporting documents before deciding what action to take.
