<?php

use App\Models\LawyerProfile;

$profiles = LawyerProfile::with('user')->latest()->take(5)->get();

echo "ID | Status | User ID | User Name | User Email\n";
echo "---|---|---|---|---\n";

foreach ($profiles as $p) {
    if ($p->user) {
        echo "{$p->id} | {$p->status} | {$p->user_id} | {$p->user->name} | {$p->user->email}\n";
    } else {
        echo "{$p->id} | {$p->status} | {$p->user_id} | NO USER | -\n";
    }
}
