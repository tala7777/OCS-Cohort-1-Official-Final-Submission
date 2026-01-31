use Illuminate\Support\Facades\DB;


// Check all lawyers
$lawyers = DB::table('users')
    ->where('role', 'lawyer')
    ->get(['id', 'email', 'status']);

foreach ($lawyers as $lawyer) {
    echo "Lawyer ID: {$lawyer->id} | Email: {$lawyer->email} | Status: {$lawyer->status}\n";
    
    // Get profile status
    $profile = DB::table('lawyer_profiles')
        ->where('user_id', $lawyer->id)
        ->first(['status']);
    
    if ($profile) {
        echo "  Profile Status: {$profile->status}\n";
        
        // If profile is accepted but user is pending, fix it
        if ($profile->status === 'accepted' && $lawyer->status === 'pending') {
            DB::table('users')
                ->where('id', $lawyer->id)
                ->update(['status' => 'active']);
            echo "  ✓ Fixed! User status updated to 'active'\n";
        }
    }
    echo "\n";
}
