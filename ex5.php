<?php
declare(strict_types=1);
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

$test_moves = [
    ['from' => 'Submitted', 'to' => 'Under review'],
    ['from' => 'Submitted', 'to' => 'Approved'],
    ['from' => 'Under review', 'to' => 'Rejected'],
    ['from' => 'Approved', 'to' => 'Submitted'],
    ['from' => 'Rejected', 'to' => 'Submitted'],
    ['from' => 'Closed', 'to' => 'Submitted'],
];

foreach ($test_moves as $move) {
    $result = can_move($move['from'], $move['to']) ? 'Allowed' : 'Blocked';
    echo $move['from'] . ' → ' . $move['to'] . ': ' . $result . '<br>';
}

echo '<br>Role tests:<br>';
echo 'officer: ' . (can_move_as('officer', 'Under review', 'Approved') ? 'true' : 'false') . '<br>';
echo 'approver: ' . (can_move_as('approver', 'Under review', 'Approved') ? 'true' : 'false') . '<br>';
echo 'requester: ' . (can_move_as('requester', 'Rejected', 'Submitted') ? 'true' : 'false') . '<br>';

// Keeping rules in an array is easier to update and avoids a long if/elseif chain.
