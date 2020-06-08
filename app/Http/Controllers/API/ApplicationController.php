<?php

namespace App\Http\Controllers\API;

use App\Helpers\APIRequestHelper;
use App\Http\Controllers\Controller;
use App\Models\ApplicationForExamination;
use App\Models\Examination;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ApplicationController extends Controller
{
    public function getAllApplications()
    {
        $userRole = Auth::user()->role;
        if($userRole == "client") {
            $response = [
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'You don\'t have permission to this page'
            ];
        }
        else {
            $applications = ApplicationForExamination::orderBy('created_at','desc')->orderBy('id')->get()->toArray();
            $data=[];
            foreach ($applications as $item){
                $patient = User::find($item['patient_id'])->toArray();
                $examination = Examination::find($item['examination_id'])->toArray();
                $applier = User::find($item['applied_by_id'])->toArray();
                $data[] = [
                    'id' => $item['id'],
                    'created_at' => $item['created_at'],
                    'patient' => $patient,
                    'examination' => $examination,
                    'applier' => $applier
                ];
            }
            $response = [
                'status' => Response::HTTP_OK,
                'data' => $data
            ];
        }
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
            $userRole = Auth::user()->role;
            if($userRole == "client" && Auth::id() != $application->patient_id) {
                $data = [
                    'status' => Response::HTTP_FORBIDDEN,
                    'message' => 'You don\'t have permission to this page'
                ];
            }
            else {
                $application = $application->toArray();
                if (empty($application)) {
                    $data = [
                        'status' => Response::HTTP_NOT_FOUND,
                        'message' => 'Application not found'
                    ];
                }
                else {
                    $patient = User::find($application['patient_id'])->toArray();
                    $examination = Examination::find($application['examination_id'])->toArray();
                    $applier = User::find($application['applied_by_id'])->toArray();
                    $responseData[] = [
                        'id' => $application['id'],
                        'created_at' => $application['created_at'],
                        'patient' => $patient,
                        'examination' => $examination,
                        'applier' => $applier
                    ];
                    $data = [
                        'status' => Response::HTTP_OK,
                        'data' => $responseData
                    ];
                }
            }
        }
        return response()->json($data, $data['status']);
    }

    public function getAllApplicationsOfUser()
    {
        $id_user = Auth::id();
        $applications = ApplicationForExamination::where('patient_id', '=', $id_user)
            ->orderBy('created_at','desc')->orderBy('id')->get()->toArray();
        if(empty($applications)) {
            $response = [
                'status' => Response::HTTP_NOT_FOUND,
                'message' => __('Applications not found')
            ];
        }
        else {
            $data=[];
            foreach ($applications as $item){
                $patient = User::find($item['patient_id'])->toArray();
                $examination = Examination::find($item['examination_id'])->toArray();
                $applier = User::find($item['applied_by_id'])->toArray();
                $data[] = [
                    'id' => $item['id'],
                    'created_at' => $item['created_at'],
                    'patient' => $patient,
                    'examination' => $examination,
                    'applier' => $applier
                ];
            }
            $response = [
                'status' => Response::HTTP_OK,
                'data' => $data
            ];
        }

        return response()->json($response, $response['status']);
    }

    public function deleteApplication($id_application)
    {
        $data = APIRequestHelper::validate(['id_application' => $id_application],
            ['id_application' => ['required','integer']]);
        if(isset($data['errors'])) {
            return response()->json($data, $data['status']);
        }
        $userRole = Auth::user()->role;
        if($userRole == "client" && Auth::id() != $data['patient_id']) {
            $data = [
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'You don\'t have permission to this page'
            ];
        }
        else {
            $id_application = ApplicationForExamination::find($id_application);
            if (empty($id_application)) {
                $data = [
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => __('Application not found')
                ];
            } else {
                $id_application->delete();
                $data = [
                    'status' => Response::HTTP_OK,
                    'message' => __('Application has been deleted')
                ];
            }
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
        $userRole = Auth::user()->role;
        if($userRole == "client" && Auth::id() != $data['patient_id']) {
            $data = [
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'You don\'t have permission to this page'
            ];
        }
        else {
            $application = ApplicationForExamination::find($data['id_application']);
            if (empty($application)) {
                $data = [
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => __('Application not found')
                ];
            } else {
                $application->patient_id = $data['patient_id'];
                $application->examination_id = $data['examination_id'];
                $application->applied_by_id = $data['applied_by_id'];
                $application->save();

                $data = [
                    'status' => Response::HTTP_OK,
                    'message' => __('Application has been updated')
                ];
            }
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
        $userRole = Auth::user()->role;
        if($userRole == "client" && Auth::id() != $data['patient_id']) {
            $data = [
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'You don\'t have permission to this page'
            ];
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
