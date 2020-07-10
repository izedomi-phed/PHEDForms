<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppraisalRequest;
use App\Mail\Reminder;
use App\Employee;
use App\Supervisor;
use App\FinancialPerformance;
use App\CustomerPerformance;
use App\ProcessOperationPerformance;
use App\PerformanceCompletionForm;
use App\BehaviouralAttribute;
use App\Training;
use App\User;
use App\Recommendation;
use App\OverallSummary;
use App\Proof;
use App\Ibc;
use PDF;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class ItSageController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
}
