<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\LawyerProfile;
use App\Models\Question;
use App\Models\QuestionReply;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $isViewQuestion = false;
    public $selectedQuestion;
    public $replies;
    public function render()
    {
        $totalUsers = User::count();
        $approvedLawyers = LawyerProfile::where('status', 'accepted')->count();
        $pendingRequests = LawyerProfile::where('status', 'pending')->count();
        $totalQuestions = Question::count();
        $totalAnswers = QuestionReply::count();
        $totalArticles = Article::count();
        $totalCategories = Category::count();

        $recentQuestions = Question::with('owner', 'category')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentLawyerRequests = LawyerProfile::where('status', 'pending')
            ->with('user.specializations')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 1. User Growth (Last 6 Months)
        $userGrowthData = User::select(
            DB::raw('COUNT(id) as count'),
            DB::raw("DATE_FORMAT(created_at, '%b') as month")
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('created_at', 'asc')
            ->get();

        // 2. Questions Distribution by Category
        $questionStats = Category::withCount('questions')
            ->where('status', 'active')
            ->orderBy('questions_count', 'desc')
            ->take(6)
            ->get();
            
        // 3. Category Logic (Insights)
        $categoriesInsights = Category::withCount(['questions', 'articles', 'lawyers'])
            ->orderBy('questions_count', 'desc')
            ->take(6)
            ->get();

        return view('livewire.admin.dashboard', [
            'totalUsers' => $totalUsers,
            'approvedLawyers' => $approvedLawyers,
            'pendingRequests' => $pendingRequests,
            'totalQuestions' => $totalQuestions,
            'totalAnswers' => $totalAnswers,
            'totalArticles' => $totalArticles,
            'totalCategories' => $totalCategories,
            'recentQuestions' => $recentQuestions,
            'recentLawyerRequests' => $recentLawyerRequests,
            'userGrowthLabels' => $userGrowthData->pluck('month'),
            'userGrowthValues' => $userGrowthData->pluck('count'),
            'categoryLabels' => $questionStats->pluck('name'),
            'categoryValues' => $questionStats->pluck('questions_count'),
            'categoriesInsights' => $categoriesInsights,
        ]);

    }
     public function approveRequest($lawyerId)
    {
        $lawyer = LawyerProfile::findOrFail($lawyerId);
        $lawyer->status = 'accepted';
        $lawyer->save();

        // Also update the user's status to active
        $lawyer->user->status = 'active';
        $lawyer->user->save();

        session()->flash('success', 'Request approved successfully!');
        $this->dispatch('action-completed');
    }

    public function rejectRequest($lawyerId)
    {
        $lawyer = LawyerProfile::findOrFail($lawyerId);
        $lawyer->status = 'rejected';
        $lawyer->save();

        session()->flash('success', 'Request rejected successfully!');
    }
    public function viewQuestion($QuestionId)
    { 
        $this->isViewQuestion = true;
        $this->selectedQuestion = Question::find($QuestionId);
        $this->replies=$this->selectedQuestion->replies;
    }
    public function closeViewQuestion()
    {
        $this->isViewQuestion = false;
    }
    public function deleteReply($replyId)
    {
        $reply = \App\Models\QuestionReply::findOrFail($replyId);
        $reply->delete();
        
        // Refresh the selected question's replies
        $this->selectedQuestion->refresh();
        $this->replies = $this->selectedQuestion->replies;

        session()->flash('success', 'Reply deleted successfully.');
    }
}
