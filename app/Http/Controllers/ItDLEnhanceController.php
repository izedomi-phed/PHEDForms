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
use App\DlEnhanceRequests;
use App\SageRequests;
use PDF;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class ItDLEnhanceController extends Controller
{
    //

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /*
    * show DLEnhance page
    */

    public function index($request_type){

        $data = $this->get_access($request_type);
        return view('it.dl_enhance')->with($data);
    }

    public function get_all_requests($request_type, $query){
      
        if($query != "ALL"){

            if($request_type == 'dl_enhance'){
                return DlEnhanceRequests::where('status', $query)->orderBy('created_at', 'DESC')->get();
            }
            else{
                return SageRequests::where('status', $query)->orderBy('created_at', 'DESC')->get();
            }
        }
        
        if($query == "ALL"){
            if($request_type == 'dl_enhance'){
                return DlEnhanceRequests::orderBy('created_at', 'DESC')->get();
            }
            else{
                return SageRequests::orderBy('created_at', 'DESC')->get();
            }
        }
       
    }


    /*
    * Helper method to get user access level and status
    */
    public function get_access($request_type){

        $access = explode("|", Auth::user()->access);
        $accessStatus = $access[0];
        $accessLevel = $access[1];

        return $data = array(
            "admin_name" => Auth::user()->name,
            "accessLevel" => $accessLevel,
            'request_type' => $request_type
        );


    }
}
