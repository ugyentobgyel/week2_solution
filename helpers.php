<?php

function full_name(string $first, string $last): string
{
    return trim($first) . ' ' . trim($last);
}

function status_label(string $status): string
{
    return match ($status) {
        'Submitted' => 'Waiting for officer',
        'Under review' => 'Officer is checking',
        'Approved' => 'Correction approved',
        'Rejected' => 'Correction rejected',
        default => 'Unknown status',
    };
}

function is_valid_cid(string $cid): bool
{
    return preg_match('/^\d{11}$/', $cid) === 1;
}

function count_by_status(array $requests): array
{
    $counts = [];

    foreach ($requests as $request) {
        $status = $request['status'];
        $counts[$status] = ($counts[$status] ?? 0) + 1;
    }

    return $counts;
}

function make_reference(int $id, string $dzongkhag, string $submitted): string
{
    // The reference format requires exactly 4 ID digits, so IDs above 9999 are rejected.
    if ($id < 1 || $id > 9999) {
        throw new InvalidArgumentException('ID must be between 1 and 9999.');
    }

    $name = trim($dzongkhag);
    $code = strtoupper(substr($name, 0, 3));
    $year = date('Y', strtotime($submitted));

    return sprintf('%s-%s-%04d', $code, $year, $id);
}

function wait_band(int $days): string
{
    if ($days < 0) {
        return 'Check date';
    }

    if ($days <= 7) {
        return 'On time';
    }

    if ($days <= 14) {
        return 'Follow up';
    }

    return 'Overdue';
}

$workflow_rules = [
    'Submitted' => ['Under review'],
    'Under review' => ['Approved', 'Rejected'],
    'Rejected' => ['Submitted'],
    'Approved' => [],
];

function can_move(string $from, string $to): bool
{
    global $workflow_rules;

    $allowed = $workflow_rules[$from] ?? [];
    return in_array($to, $allowed, true);
}

function can_move_as(string $role, string $from, string $to): bool
{
    $allowed = match ($role) {
        'officer' => $to === 'Under review',
        'approver' => in_array($to, ['Approved', 'Rejected'], true),
        'requester' => $to === 'Submitted',
        default => false,
    };

    return $allowed && can_move($from, $to);
}
