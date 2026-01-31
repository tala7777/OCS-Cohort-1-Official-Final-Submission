<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LawyerProfile;
use App\Models\User;
use App\Mail\LawyerApproved; // Make sure to import this
use Illuminate\Support\Facades\Mail; // Import Mail facade

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email-debug {lawyer_profile_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug email sending for lawyer approval';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lawyerProfileId = $this->argument('lawyer_profile_id');

        if ($lawyerProfileId) {
             $lawyer = LawyerProfile::find($lawyerProfileId);
             if (!$lawyer) {
                 $this->error("Lawyer Profile ID $lawyerProfileId not found.");
                 return;
             }
             $user = $lawyer->user;
             if (!$user) {
                 $this->error("No user associated with Lawyer Profile ID $lawyerProfileId.");
                 return;
             }
             $this->info("Found User: " . $user->name . " (ID: " . $user->id . ")");
        } else {
            // Default to creating a fake user if no ID provided
             $user = new User([
                'name' => 'Dr. Test Lawyer',
                'email' => 'naderghareeb2007@gmail.com', // Override with safe email
            ]);
            $this->info("Using Dummy User: " . $user->name);
        }

        $this->info("Sending email to: " . $user->email);

        try {
            Mail::to($user->email)->send(new LawyerApproved($user));
            $this->info("Email sent successfully!");
        } catch (\Exception $e) {
            $this->error("Failed to send email: " . $e->getMessage());
        }
    }
}
