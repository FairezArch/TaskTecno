<?php

namespace App\Http\Controllers;

use App\Models\Method;
use App\Models\Task;
use Illuminate\Contracts\View\View;

class LearningActivityController extends Controller
{
    /**
     * Summary of index
     */
    public function index(): View
    {
        $periodMonth = Task::periodMonth;
        $allData = Method::AllData($periodMonth);

        return view('pages.learning-activity', compact('periodMonth', 'allData'));
    }
}
