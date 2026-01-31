<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Category;
use App\Models\LawyerProfile;
use App\Models\Question;
use App\Models\QuestionReply;
use App\Models\Article;
use App\Models\Like;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Cleaning DB...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Like::truncate();
        QuestionReply::truncate();
        Article::truncate();
        Question::truncate();
        DB::table('category_lawyer')->truncate();
        LawyerProfile::truncate();
        Category::truncate();
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker::create();

        // 2. Categories (10 Real)
        $this->command->info('Seeding Categories...');
        $categoriesData = [
            ['name' => 'Family Law', 'slug' => 'family-law'],
            ['name' => 'Criminal Defense', 'slug' => 'criminal-defense'],
            ['name' => 'Corporate Law', 'slug' => 'corporate-law'],
            ['name' => 'Intellectual Property', 'slug' => 'intellectual-property'],
            ['name' => 'Labor & Employment', 'slug' => 'labor-employment'],
            ['name' => 'Real Estate', 'slug' => 'real-estate'],
            ['name' => 'Personal Injury', 'slug' => 'personal-injury'],
            ['name' => 'Immigration', 'slug' => 'immigration'],
            ['name' => 'Tax Law', 'slug' => 'tax-law'],
            ['name' => 'Bankruptcy', 'slug' => 'bankruptcy'],
        ];

        foreach ($categoriesData as $cat) {
            Category::create($cat);
        }
        $categoryIds = Category::pluck('id')->toArray();

        // 3. Fixed Users
        $this->command->info('Seeding Fixed Users...');
        // Admin
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Test Lawyer
        $testLawyer = User::create([
            'name' => 'Sarah The Lawyer',
            'email' => 'lawyer@example.com',
            'password' => Hash::make('password'),
            'role' => 'lawyer',
        ]);
        LawyerProfile::create([
            'user_id' => $testLawyer->id,
            'bio' => 'Senior attorney with 15 years of experience in Corporate Law and M&A.',
            'license_number' => 'SARAH-LAW-001',
            'status' => 'accepted',
            'location' => 'New York, USA',
            'profile_photo_path' => 'https://ui-avatars.com/api/?name=Sarah+The+Lawyer&background=random&size=200',
        ]);
        // Pivot
        DB::table('category_lawyer')->insert([
            ['lawyer_id' => $testLawyer->id, 'category_id' => $categoryIds[2], 'created_at' => now(), 'updated_at' => now()], // Corporate
            ['lawyer_id' => $testLawyer->id, 'category_id' => $categoryIds[8], 'created_at' => now(), 'updated_at' => now()], // Tax
        ]);

        // Test User
        $testUser = User::create([
            'name' => 'John Doe',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // 4. Create 10 Real Lawyers
        $this->command->info('Seeding 10 Real Lawyers (Arabic)...');
        $lawyerIds = [$testLawyer->id];
        
        $lawyerNames = [
            'Ahmed Al-Mansour', 
            'Fatima Al-Zahra', 
            'Mohammed Al-Saud', 
            'Layla Al-Khalid', 
            'Omar Al-Fayed', 
            'Noura Al-Jaber', 
            'Khalid Al-Rashid', 
            'Amira Al-Hassan', 
            'Youssef Al-Nasser', 
            'Sara Al-Otaibi'
        ];
        
        foreach($lawyerNames as $idx => $name) {
            // Create email from name (e.g. ahmed.al-mansour@example.com)
            $emailName = strtolower(str_replace([' ', '-'], '.', $name));
            
            $lUser = User::create([
                'name' => $name,
                'email' => $emailName . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'lawyer',
            ]);

            LawyerProfile::create([
                'user_id' => $lUser->id,
                'bio' => "Professional attorney specializing in complex legal matters. Committed to providing excellent representation and sound advice. " . $faker->paragraph,
                'license_number' => 'LAW-' . strtoupper($faker->bothify('??###')),
                'status' => 'accepted',
                'location' => 'Riyadh, Saudi Arabia',
                'phone' => '+966 ' . $faker->numerify('5########'),
                'profile_photo_path' => 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=random&size=200',
            ]);

            // Assign 2 categories
            $cats = $faker->randomElements($categoryIds, 2);
            foreach($cats as $cid) {
                DB::table('category_lawyer')->insert([
                    'lawyer_id' => $lUser->id,
                    'category_id' => $cid,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $lawyerIds[] = $lUser->id;
        }

        // 5. Create 20 Users
        $this->command->info('Seeding 20 Users...');
        $userIds = [$testUser->id];
        for ($i = 0; $i < 20; $i++) {
            $u = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);
            $userIds[] = $u->id;
        }

        // 6. Create 20 Real Questions
        $this->command->info('Seeding 20 Questions...');
        $questionTitles = [
            "What are the legal requirements for starting a small business?",
            "How does custody work in a divorce case?",
            "Can I sue my landlord for unsafe living conditions?",
            "Understanding intellectual property rights for software.",
            "What should I do if I'm involved in a car accident?",
            "How to file for bankruptcy and what are the consequences?",
            "Is a verbal contract legally binding?",
            "What are my rights as an employee regarding overtime pay?",
            "How to handle a breach of contract dispute?",
            "Immigration process for spousal visa explanation needed.",
            "Tax implications of selling detailed property.",
            "Can I trademark my logo without a lawyer?",
            "What constitutes wrongful termination?",
            "Tenant rights during eviction process.",
            "How to create a valid will?",
            "Legal age for signing contracts.",
            "Difference between copyright and trademark.",
            "What is a non-compete agreement?",
            "How to fight a traffic ticket effectively?",
            "consumer protection laws regarding refunds."
        ];

        $questionIds = [];
        foreach($questionTitles as $idx => $title) {
            $desc = "I am looking for legal advice regarding the following situation... " . $faker->paragraph(3) . " Any help is appreciated.";
            
            $q = Question::create([
                'user_id' => $faker->randomElement($userIds),
                'category_id' => $faker->randomElement($categoryIds),
                'title' => $title,
                'description' => $desc,
                'status' => 'open',
            ]);
            $questionIds[] = $q->id;
        }

        // 7. Create 40 Replies (2 per question approx)
        $this->command->info('Seeding 40 Replies...');
        $replyIds = [];
        foreach($questionIds as $qid) {
            // Add 2 replies to each question
            for($re = 0; $re < 2; $re++) {
                $r = QuestionReply::create([
                    'question_id' => $qid,
                    'lawyer_id' => $faker->randomElement($lawyerIds),
                    'body' => "Based on the details provided, here is a general perspective: " . $faker->paragraph(2) . " However, I recommend consulting with a lawyer formally.",
                ]);
                $replyIds[] = $r->id;
            }
        }

        // 8. Create 50 Likes
        $this->command->info('Seeding 50 Likes...');
        $likesCount = 0;
        $attempts = 0;
        while($likesCount < 50 && $attempts < 200) {
            $uid = $faker->randomElement($userIds);
            $rid = $faker->randomElement($replyIds);
            
            $exists = DB::table('likes')->where('user_id', $uid)->where('reply_id', $rid)->exists();
            if(! $exists) {
                DB::table('likes')->insert([
                    'user_id' => $uid,
                    'reply_id' => $rid,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $likesCount++;
            }
            $attempts++;
        }

        // 9. Create 10 Articles with Real Pictures
        $this->command->info('Seeding 10 Articles...');
        $articleTitles = [
            "Understanding Family Law Basics in 2026",
            "5 Steps to Protect Your Intellectual Property",
            "Tenants Rights: What You Need to Know",
            "The Guide to Corporate Taxation",
            "Criminal Defense Strategies Explained",
            "How to Negotiate Your Employment Contract",
            "Real Estate Closing Process De-mystified",
            "Immigration Law Updates for the New Year",
            "Personal Injury: When to Hire a Lawyer",
            "Bankruptcy: A Fresh Start?"
        ];

        foreach($articleTitles as $idx => $title) {
            Article::create([
                'author_id' => $faker->randomElement($lawyerIds),
                'category_id' => $faker->randomElement($categoryIds),
                'title' => $title,
                'slug' => Str::slug($title . '-' . uniqid()),
                'content' => $faker->realText(3000), 
                'status' => 'published',
                'published_at' => now()->subDays(rand(1, 100)),
                // Using unsplash random image
                'image_path' => 'https://picsum.photos/seed/' . ($idx+1) . '/800/600', 
            ]);
        }
        
        $this->command->info('Realistic Seeding Complete!');
    }
}
