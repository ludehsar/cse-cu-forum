<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use App\Models\User;
use App\Models\Report;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\UniversityProfile;
use App\Http\Controllers\Controller;

class DashboardAPIController extends Controller
{
    public function getAllTotals()
    {
        $totalUser = User::count();

        $totalPosts = Post::count();

        $totalComments = Comment::count();

        $totalReports = Report::count();

        $admins = User::where('is_admin', true)->count();

        $teachers = UniversityProfile::where('is_teacher', true)->count();

        $verifiedUsers = User::where('is_verified', true)->count();

        $blockedUsers = User::where('is_blocked', true)->count();

        $array = array(
            'totalUser' => $totalUser,
            'totalPost' => $totalPosts,
            'totalComment' => $totalComments,
            'totalReport' => $totalReports,
            'admins' => $admins,
            'teachers' => $teachers,
            'verifiedUsers' => $verifiedUsers,
            'blockedUsers' => $blockedUsers,
        );

        return response($array, 200);
    }

    public function getUserDataset()
    {
        $users = User::orderBy('created_at', 'ASC')->get();

        $userDatasetDates = array();
        $userDatasetData = array();
        $lastInsertedData = 0;
        
        foreach($users as $user) {
            array_push($userDatasetDates, $user->created_at);
            array_push($userDatasetData, $lastInsertedData + 1);
            $lastInsertedData++;
        }
        
        $userDatasetMax = ((int) ($lastInsertedData / 10) + 1) * 10;
        
        $userDataset = array(
            'dates' => $userDatasetDates,
            'user_count_data' => $userDatasetData,
            'max' => $userDatasetMax,
        );

        return response($userDataset, 200);
    }

    public function getPostDataset()
    {
        $posts = Post::orderBy('created_at', 'ASC')->get();

        $postDatasetDates = array();
        $postDatasetData = array();
        $lastInsertedData = 0;
        
        foreach($posts as $post) {
            array_push($postDatasetDates, $post->created_at);
            array_push($postDatasetData, $lastInsertedData + 1);
            $lastInsertedData++;
        }
        
        $postDatasetMax = ((int) ($lastInsertedData / 10) + 1) * 10;
        
        $postDataset = array(
            'dates' => $postDatasetDates,
            'post_count_data' => $postDatasetData,
            'max' => $postDatasetMax,
        );

        return response($postDataset, 200);
    }
}
