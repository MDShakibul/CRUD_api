<?php

namespace App\Http\Controllers;

use App\Models\UserForm;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserFormController extends Controller
{
    public function userform($application_no)
    {
        if(!is_null($application_no)){
            $result = UserForm::where('application_no', $application_no)
            ->select('id','application_no','status','payment_date','name','address','mobile_no','mauser_name','contact_mobile_no','resolved_by_date','created_at')
            ->first();
            $payment_date = $result->payment_date;
            $modified_payment_date = Carbon::createFromFormat('d/m/Y', $payment_date)->format('Y-m-d');
            $validity_date = Carbon::createFromFormat('d/m/Y', $payment_date)->addYear(2)->format('Y-m-d');
            $current_date = Carbon::createFromFormat('Y-m-d h:i:s', Carbon::now())->format('Y-m-d');
            $is_valid = ($current_date < $validity_date) ? true : false;
            if($result){
                //return $result;
                return response([
                    'result' =>$result,
                    'modified_payment_date' => $modified_payment_date,
                    'validity_date' => $validity_date,
                    'is_valid' => $is_valid,
                ],200);
            }else{
                return response([
                    'message' =>'Invalid User Form ID.'
                ],404);
            }
        }else{
            return response([
                'message' =>'Application no. is required*'
            ],422);
        }
    }
}
