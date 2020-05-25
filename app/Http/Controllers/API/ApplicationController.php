<?php

namespace App\Http\Controllers\API;

use App\Helpers\APIRequestHelper;
use App\Http\Controllers\Controller;
use App\Models\ApplicationForExamination;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ApplicationController extends Controller
{
    public function getAllApplications()
    {
        $applications = ApplicationForExamination::get()->toArray();
        $response = [
            'status' => Response::HTTP_OK,
            'data' => $applications
        ];
        return response()->json($response, $response['status']);
    }

    public function getSingleApplication($id_application)
    {
        $data = APIRequestHelper::validate(['id_application' => $id_application],
            ['id_application' => ['required','integer']]);
        if(isset($data['errors'])) {
            return response()->json($data, $data['status']);
        }
        $application = ApplicationForExamination::find($id_application);
        if(empty($application)) {
            $data = [
                'status' => Response::HTTP_NOT_FOUND,
                'message' => __('Application not found')
            ];
        }
        else {
            $application = $application->toArray();
            $data = [
                'status' => Response::HTTP_OK,
                'data' => $application
            ];
        }
        return response()->json($data, $data['status']);
    }

    public function getAllApplicationsOfUser()
    {
        $id_user = Auth::id();
        $applications = ApplicationForExamination::where('id_user', '=', $id_user)->get()->toArray();
        if(empty($applications)) {
            $data = [
                'status' => Response::HTTP_NOT_FOUND,
                'message' => __('Applications not found')
            ];
        }
        $response = [
            'status' => Response::HTTP_OK,
            'data' => $applications
        ];
        return response()->json($response, $response['status']);
    }

    public function deleteApplication($id_application)
    {
        $data = APIRequestHelper::validate(['id_application' => $id_application],
            ['id_application' => ['required','integer']]);
        if(isset($data['errors'])) {
            return response()->json($data, $data['status']);
        }
        $id_application = ApplicationForExamination::find($id_application);
        if(empty($id_application)) {
            $data = [
                'status' => Response::HTTP_NOT_FOUND,
                'message' => __('Application not found')
            ];
        }
        else {
            $id_application->delete();
            $data = [
                'status' => Response::HTTP_OK,
                'message' => __('Application has been deleted')
            ];
        }
        return response()->json($data, $data['status']);
    }
    public function updateApplication(Request $request)
    {
        $data = APIRequestHelper::validate($request->all(), [
            'id_application' => ['required', 'integer'],
            'patient_id' => ['required', 'integer'],
            'examination_id' => ['required', 'integer'],
            'applied_by_id' => ['required', 'integer']
        ]);
        if(isset($data['errors'])) {
            return response()->json($data, $data['status']);
        }
        $application = ApplicationForExamination::find($data['id_application']);
        if(empty($application)) {
            $data = [
                'status' => Response::HTTP_NOT_FOUND,
                'message' => __('Application not found')
            ];
        }
        else {
            $application->patient_id = $data['patient_id'];
            $application->examination_id = $data['examination_id'];
            $application->applied_by_id = $data['applied_by_id'];
            $application->save();

            $data = [
                'status' => Response::HTTP_OK,
                'message' => __('Application has been updated')
            ];
        }
        return response()->json($data, $data['status']);
    }

    public function createApplication(Request $request)
    {
        $data = APIRequestHelper::validate($request->all(), [
            'patient_id' => ['required', 'integer'],
            'examination_id' => ['required', 'integer'],
            'applied_by_id' => ['required', 'integer']
        ]);
        if(isset($data['errors'])) {
            return response()->json($data, $data['status']);
        }
        else {
            $application = new ApplicationForExamination();
            $application->patient_id = $data['patient_id'];
            $application->examination_id = $data['examination_id'];
            $application->applied_by_id = $data['applied_by_id'];
            $application->save();

            $data = [
                'status' => Response::HTTP_OK,
                'message' => __('Application has been created')
            ];
        }
        return response()->json($data, $data['status']);
    }
}
