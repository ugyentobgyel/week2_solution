<?php
declare(strict_types=1);
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

function count_pending(array $requests): int
{
    $total = 0;

    // Bug 1 fixed: start at index 0 so the first record is included.
    for ($i = 0; $i < count($requests); $i++) {
        // Bug 2 fixed: array key is lowercase 'status'.
        $status = $requests[$i]['status'];

        // Bug 3 fixed: use comparison ===, not assignment =.
        if ($status === 'Submitted' || $status === 'Under review') {
            // Bug 4 fixed: actually add 1 to total.
            $total++;
        }
    }

    // Bug 5 fixed: return the result.
    return $total;
}

echo count_pending($requests);

/* Bug log:
1. Started loop at 1 -> request 1 was skipped -> start at 0.
2. Used ['Status'] -> wrong array key -> use ['status'].
3. Used = in the if condition -> assigned instead of compared -> use ===.
4. Used $total + 1 -> result was not saved -> use $total++.
5. No return statement -> function returned null -> return $total.
*/
