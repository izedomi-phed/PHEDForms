<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppraisalRequest;
use App\Mail\Reminder;
use App\Mail\Declined;
use App\User;
use App\DlEnhanceRequests;
use App\SageRequests;
use App\Email;
use PDF;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;


class AccessApprovalController extends Controller
{
    //
    public function dl_enhance_approval($request_type, $request_id, $staff_id){
        //return $request_id;
        if(isset($_GET['approval']) && trim($_GET['approval'])){
            $approval = trim($_GET['approval']);

            if($request_type == 'dl_enhance'){
                $request = DlEnhanceRequests::find($request_id);
            }
            else{
                $request = SageRequests::find($request_id);
            }

            $user = User::find($request->account_id);
            $name = explode(" ", $request->name);
            $lastname = $name[0];
            $firstname = "";
            $otherNames = null;
            $staffId = Auth::user()->staff_id;
            $email = $user->email;
            if(count($name) > 1){
                $firstname = $name[1];
            }
            if(count($name) > 2){
                $otherNames = $name[2];
            }


            $request->approval = $approval;
            $request->request_type = $request_type;
            $request->email = $email;
            $request->firstname = $firstname;
            $request->lastname = $lastname;
            $request->otherNames = $otherNames;
            return view('AccessApproval.dl_enhance')->with('request', $request);
        }

        return view("error");

    }

    public function requests_approval_action(Request $request){

        //return $request;
        $request_id = $request->request_id;
        $approved_by = $request->approved_by;
        $request_status = $request->approval_status;
        $comment = $request->decline_comment;
        $request_type = $request->request_type;
        $emails = Email::find(1);

        //return $approved_by;
        if($request_type == 'dl_enhance'){
            $request = DlEnhanceRequests::find($request_id);
        }
        if($request_type == 'sage'){
            $request = SageRequests::find($request_id);
        }

        /*
        * set comment
        */
        if($approved_by == 'hod'){
             $request->hod_comment = $comment;
        }
        if($approved_by == 'hr'){
            $request->hr_comment = $comment;
        }
        if($approved_by == 'finance'){
            $request->finance_comment = $comment;
        }
        if($approved_by == 'audit'){
            $request->audit_comment = $comment;
        }
        if($approved_by == 'it'){
            $request->it_comment = $comment;
        }

        /*
        *  set the time of approval
        */
        if($approved_by == "hod"){
            $request->hod_action_date = date("D, j M Y");
        }
        if($approved_by == 'audit'){
            $request->audit_action_date = date("D, j M Y");
        }
        if($approved_by == 'finance'){
            $request->finance_action_date = date("D, j M Y");
        }
        if($approved_by == 'hr'){
            $request->hr_action_date = date("D, j M Y");
        }
        if($approved_by == 'it'){
            $request->it_action_date = date("D, j M Y");
        }
        if($approved_by == 'creator'){
            $request->creator_action_date = date("D, j M Y");
        }


        $subject = "Access Request";
        if($request_type == "sage"){

            $subject = "Sage X3 ERP Access Request";
            if($approved_by == "hod" && $request_status == "ACCEPTED"){

                if($request->hr_module != null){
                    $request->status = "TO_HR";
                    $receiver_email = $emails->hr; // hr email goes here
                }
                else{
                    $request->status = "TO_FINANCE";
                    $receiver_email = $emails->finance; // finance email goes here
                }
            }
            if($approved_by == "hr" && $request_status == "ACCEPTED"){
                if($request->finance_module != null){
                    $request->status = "TO_FINANCE";
                    $receiver_email = $emails->finance; // finance email goes here
                }
                else{
                    $request->status = "TO_AUDIT";
                    $receiver_email = $emails->audit; // audit email goes here
                }
            }
            if($approved_by == "finance" && $request_status == "ACCEPTED"){

                $request->status = "TO_AUDIT";
                $receiver_email = $emails->audit; // audit email goes here

            }
            if($approved_by == "audit" && $request_status == "ACCEPTED"){
                $request->status = "TO_IT";
                $receiver_email = $emails->it; // i.t email goes here
            }
            if($approved_by == "it" && $request_status == "ACCEPTED"){
                $request->status = "TO_CREATE";
                $receiver_email = $emails->sage_creator;
            }

            if($request_status == "DECLINED"){
                $request->status = strtoupper($approved_by)."_".$request_status;

                if($approved_by == 'hod'){
                    $emailArr = [Auth::user()->email];
                }
                if($approved_by == "finance" || $approved_by == "hr"){
                    $emailArr = [Auth::user()->email, $request->hod_email];
                }
                if($approved_by == "audit"){

                    $emailArr = [Auth::user()->email, $request->hod_email];

                    if($request->hr_module != null){
                       array_push($emailArr, $emails->hr);
                    }
                    if($request->finance_module != null){
                        array_push($emailArr, $emails->finance);
                    }
                }
                if($approved_by == "it"){
                    $emailArr = [Auth::user()->email, $request->hod_email, $emails->audit];

                    if($request->hr_module != null){
                        array_push($emailArr, $emails->hr);
                    }
                    if($request->finance_module != null){
                         array_push($emailArr, $emails->finance);
                    }

                }
            }
        }
        if($request_type == "dl_enhance"){
            $subject = "DLEnhance Access Request";
            if($request_status == "ACCEPTED" && $approved_by == "hod"){
                $request->status = "TO_AUDIT";
                $receiver_email = $emails->audit; // audit email
            }

            if($request_status == "ACCEPTED" && $approved_by == "audit"){
                $request->status = "TO_IT";
                $receiver_email = $emails->it; // it email
            }

            if($request_status == "ACCEPTED" && $approved_by == "it"){
                $request->status = "TO_CREATE";
                $receiver_email = $emails->dl_enhance_creator; //ussip email goes here
            }

            if($request_status == "DECLINED"){
                $request->status = strtoupper($approved_by)."_".$request_status;

                if($approved_by == 'hod'){
                    $emailArr = [Auth::user()->email];
                }

                if($approved_by == "audit"){

                    $emailArr = [Auth::user()->email, $request->hod_email];
                }

                if($approved_by == "it"){

                    $emailArr = [Auth::user()->email, $request->hod_email, $emails->audit];
                }
            }
        }
        if($approved_by == "creator" && $request_status == "ACCEPTED"){
            $request->status = "CREATED";
        }


        if($request_status == "DECLINED"){
            $send_to = "DECLINED";
        }
        else{
            $send_to = $request->status;
        }

        $request->save();

        if($request_status == "DECLINED"){
            foreach($emailArr as $e){
                $msg = new Declined($request_type, $approved_by, $comment, $request->staff_id, $request->name);
                $msg->subject($subject);
                Mail::to($e)->send($msg);
            }
            $request->delete();
        }
        elseif($approved_by == 'creator'){

            $request->status = "CREATED";
            if($request_type == "sage"){
                $emailArr = [Auth::user()->email, $request->hod_email, $emails->audit];

                if($request->hr_module != null){
                    array_push($emailArr, $emails->hr);
                }
                if($request->finance_module != null){
                    array_push($emailArr, $emails->finance);
                }

            }else{
                $emailArr = [Auth::user()->email, $request->hod_email, $emails->audit];
            }

            foreach($emailArr as $e){
                $msg = new Declined($request_type, $approved_by, $comment, $request->staff_id, $request->name);
                $msg->subject($subject);
                Mail::to($e)->send($msg);
            }
        }
        else{

            $msg = new Reminder($request_type, $request->id, $request->staff_id, $send_to);
            $msg->subject($subject);
            Mail::to($receiver_email)->send($msg);
        }
        return "yes";
    }

    public function current_request($request_type){

        if($request_type == 'sage'){
            return SageRequests::where("account_id", Auth::user()->id)->orderBy("created_at", "DESC")->take(1)->first();
        }
        else{
            return DlEnhanceRequests::where("account_id", Auth::user()->id)->orderBy("created_at", "DESC")->take(1)->first();
        }

    }


}
