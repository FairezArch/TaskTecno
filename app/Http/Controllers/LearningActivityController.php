<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Method;
use Illuminate\Contracts\View\View;

class LearningActivityController extends Controller
{
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $periodMonth = Task::periodMonth;
        $allData = Method::AllData($periodMonth);
        return view('pages.learning-activity', compact('periodMonth', 'allData'));
    }
}