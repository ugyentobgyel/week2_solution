<?php
declare(strict_types=1);
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

foreach ($requests as $r) {
    echo make_reference($r['id'], $r['dzongkhag'], $r['submitted']) . '<br>';
}

// An ID such as 12345 is rejected because the required format has exactly 4 ID digits.
