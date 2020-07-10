<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveRequestMail;
use App\User;
use App\Staff;
use App\LeaveRequest;
use App\UnusedLeaveRequest;
use App\SignatoryLeaveRequest;
use App\Email;
use PDF;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class LeaveRequestController extends Controller
{
    //

    public function submit_leave_request(Request $request){
        //return $request;
      //  return $request->leave_categories
      //  return json_encode($request->leave_categories);
      //  return json_encode($request->hand_over_materials);

        try{

              $staff = new LeaveRequest();
              $staff->name = $request->first_name ." ". $request->last_name ." ". $request->other_name;
              $staff->staff_id = $request->staff_id;
              $staff->email = $request->official_email;
              $staff->reason_for_absence = $request->reason_for_absence;
              $staff->no_of_days_of_absence = $request->days_of_absence;
              $staff->start_date = $request->start_date;
              $staff->last_date = $request->end_date;
              $staff->resumption_date = $request->resumption_date;
              $staff->department = $request->department;
              $staff->location = $request->location;
              $staff->designation = $request->designation;
              $staff->residential_address = $request->residential_address;
              $staff->personal_email = $request->personal_email;
              $staff->personal_phone = $request->telephone;
              $staff->relief_officer_email = $request->relief_officer_email;
              $staff->supervisor_email = $request->supervisor_email;
              $staff->overall_supervisor_email = $request->overall_supervisor_email;
              $staff->leave_categories = json_encode($request->leave_categories);
              $staff->hand_over_materials = json_encode($request->hand_over_materials);
              $staff->status = "RELIEF_OFFICER";
              $staff->level = 1;
              $staff->save();

              $ulRequests = new UnusedLeaveRequest();
              $ulRequests->lr_id = $staff->id;
              $ulRequests->staff_id = $request->staff_id;
              $ulRequests->staff_email = $request->official_email;
              $ulRequests->year = $request->unused_year;
              $ulRequests->no_of_days = $request->unused_days;
              $ulRequests->save();

              $signatories = array(
                $request->relief_officer_email,
                $request->supervisor_email,
                $request->overall_supervisor_email
              );

              $roles = array("RELIEF_OFFICER", "SUPERVISOR", "OVERALL SUPERVISOR");

              for($x=0; $x<count($signatories); $x++){
                  $slRequests = new SignatoryLeaveRequest();
                  $slRequests->lr_id = $staff->id;
                  $slRequests->email = $signatories[$x];
                  $slRequests->role = $roles[$x];
                  $slRequests->level = $x + 1;
                  $slRequests->save();
              }

              $msg = new LeaveRequestMail($staff->id, $request->staff_id, $request->official_email, $staff->name, $staff->status);
              $msg->subject("PHED LEAVE FORM");
              Mail::to($request->relief_officer_email)->send($msg);

              return "success";
        }
        catch(Exception $e){
            return response()->json([
               'errors' => [$e->getMessage(), "Temporarily unable to connect to the server. Please refresh or try again later"]
            ], 500);
        }

    }

    public function leave_request_approval_list(){
      $data = $this->get_access();
      return view('staff.leave_request_approval_list', $data);
    }

    public  function get_access($request_type = 'dl_enhance'){

        $isAppraiser = false;
        $isReviewer = false;

        $access = explode("|", Auth::user()->access);
        $accessStatus = $access[0];
        $accessLevel = $access[1];

        $name = explode(" ", trim(Auth::user()->name));
        $lastname = $name[0];
        $firstname = "";
        $other_name = "";
        if(count($name) > 1){
            $firstname = $name[1];
        }
        if(count($name) > 2){
            $other_name = $name[2];
        }

        //get count of leave request yet to be attended to
        $slr_count = SignatoryLeaveRequest::where('email', Auth::user()->email)->where('completed', "FALSE")->count();


        return array(
            'email' => Auth::user()->email,
            'lastname' => $lastname,
            'firstname' => $firstname,
            'otherName' => $other_name,
            'isAppraiser' => $isAppraiser,
            'isReviewer' => $isReviewer,
            'staffId' => Auth::user()->staff_id,
            'accessLevel' => $accessLevel,
            'requestType' => $request_type,
            'leave_request_count' => $slr_count

        );
    }
}
