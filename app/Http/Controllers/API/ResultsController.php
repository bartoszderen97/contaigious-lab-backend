<?php

namespace App\Http\Controllers\API;

use App\Helpers\APIRequestHelper;
use App\Http\Controllers\Controller;
use App\Models\ApplicationForExamination;
use App\Models\ExaminationResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ResultsController extends Controller
{
    public function getAllResults() {
        $userRole = Auth::user()->role;
        if($userRole == "client") {
            $response = [
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'You don\'t have permission to this page'
            ];
        }
        else {
            $results = ExaminationResult::orderBy('created_at','desc')->orderBy('id')->get()->toArray();
            $i=0;
            foreach ($results as $item){
                $applier = User::find($item['added_by'])->toArray();
                $results[$i]['applier'] = $applier;
                $i++;
            }
            $response = [
                'status' => Response::HTTP_OK,
                'data' => $results
            ];
        }
        return response()->json($response, $response['status']);
    }

    public function getAllResultsOfUser() {
        $id_user = Auth::id();
        $applications = ApplicationForExamination::where('patient_id', '=', $id_user)
            ->orderBy('created_at','desc')->orderBy('id')->get();
        if(empty($applications)) {
            $response = [
                'status' => Response::HTTP_NOT_FOUND,
                'message' => __('Results not found')
            ];
        }
        else {
            $data=[];
            $i=0;
            foreach ($applications as $item){
                $result = ExaminationResult::where('application_id', '=', $item->id)->get()->toArray();
                if(!empty($result)) {
                    $data[] = $result[0];
                    $data[$i]['applier'] = User::find($result[0]['added_by'])->toArray();
                    $i++;
                }
            }
            $response = [
                'status' => Response::HTTP_OK,
                'data' => $data
            ];
        }
        return response()->json($response, $response['status']);
    }

    public function getSingleResult($id_application) {
        $data = APIRequestHelper::validate(['id_application' => $id_application],
            ['id_application' => ['required','integer']]);
        if(isset($data['errors'])) {
            return response()->json($data, $data['status']);
        }
        $result = ExaminationResult::where('application_id', '=', $id_application)
            ->orderBy('created_at','desc')->orderBy('id')->get()->toArray();
        $application = ApplicationForExamination::find($id_application);
        if(empty($result)) {
            $response = [
                'status' => Response::HTTP_NOT_FOUND,
                'message' => __('Result not found')
            ];
        }
        else {
            $userRole = Auth::user()->role;
            if($userRole == "client" && Auth::id() != $application->patient_id) {
                $response = [
                    'status' => Response::HTTP_FORBIDDEN,
                    'message' => 'You don\'t have permission to this page'
                ];
            }
            else {
                $applier = User::find($result[0]['added_by'])->toArray();
                $result[0]['applier'] = $applier;
                $response = [
                    'status' => Response::HTTP_OK,
                    'data' => $result
                ];
            }

        }
        return response()->json($response, $response['status']);
    }

    public function deleteResult($id_result) {
        $data = APIRequestHelper::validate(['id_application' => $id_result],
            ['id_application' => ['required','integer']]);
        if(isset($data['errors'])) {
            return response()->json($data, $data['status']);
        }

        $result = ExaminationResult::find($id_result);
        $application = ApplicationForExamination::find($result->application_id);
        if (empty($result) || empty($application)) {
            $response = [
                'status' => Response::HTTP_NOT_FOUND,
                'message' => __('Result not found')
            ];
        } else {
            $userRole = Auth::user()->role;
            if($userRole == "client" && Auth::id() != $application->patient_id) {
                $response = [
                    'status' => Response::HTTP_FORBIDDEN,
                    'message' => 'You don\'t have permission to this page'
                ];
            }
            else {
                $result->delete();
                $response = [
                    'status' => Response::HTTP_OK,
                    'message' => __('Result has been deleted')
                ];
            }
        }

        return response()->json($response, $response['status']);
    }

    public function updateResult(Request $request) {
        $data = APIRequestHelper::validate($request->all(), [
            'id_result' => ['required', 'integer', 'exists:examination_results,id'],
            'illness_presence' => ['required', Rule::in([0,1])],
            'unit_name' => ['nullable', Rule::in(['g/mol', 'mm/Hg', '%'])],
            'result_value' => ['nullable', 'numeric'],
            'result_lowest_norm' => ['nullable', 'numeric'],
            'result_highest_norm' => ['nullable', 'numeric'],
            'added_by' => ['required', 'integer', 'exists:users,id'],
            'application_id' => ['required', 'integer', 'exists:application_for_examinations,id'],
        ]);
        if(isset($data['errors'])) {
            return response()->json($data, $data['status']);
        }
        $userRole = Auth::user()->role;
        if($userRole == "client") {
            $response = [
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'You don\'t have permission to this page'
            ];
        }
        else {
            $result = ExaminationResult::find($data['id_result']);
            $result->illness_presence = $data['illness_presence'];
            $result->unit_name = isset($data['unit_name']) ? $data['unit_name'] : null;
            $result->result_value = isset($data['result_value']) ? $data['result_value'] : null;
            $result->result_lowest_norm = isset($data['result_lowest_norm']) ? $data['result_lowest_norm'] : null;
            $result->result_highest_norm = isset($data['result_highest_norm']) ? $data['result_highest_norm'] : null;
            $result->application_id = $data['application_id'];
            $result->added_by = $data['added_by'];
            $result->save();

            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('Application has been created')
            ];
        }
        return response()->json($response, $response['status']);
    }

    public function createResult(Request $request) {
        $data = APIRequestHelper::validate($request->all(), [
            'illness_presence' => ['required', Rule::in([0,1])],
            'unit_name' => ['nullable', Rule::in(['g/mol', 'mm/Hg', '%'])],
            'result_value' => ['nullable', 'numeric'],
            'result_lowest_norm' => ['nullable', 'numeric'],
            'result_highest_norm' => ['nullable', 'numeric'],
            'added_by' => ['required', 'integer', 'exists:users,id'],
            'application_id' => ['required', 'integer', 'exists:application_for_examinations,id'],
        ]);
        if(isset($data['errors'])) {
            return response()->json($data, $data['status']);
        }
        $userRole = Auth::user()->role;
        if($userRole == "client") {
            $response = [
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'You don\'t have permission to this page'
            ];
        }
        else {
            $result = new ExaminationResult();
            $result->illness_presence = $data['illness_presence'];
            $result->unit_name = isset($data['unit_name']) ? $data['unit_name'] : null;
            $result->result_value = isset($data['result_value']) ? $data['result_value'] : null;
            $result->result_lowest_norm = isset($data['result_lowest_norm']) ? $data['result_lowest_norm'] : null;
            $result->result_highest_norm = isset($data['result_highest_norm']) ? $data['result_highest_norm'] : null;
            $result->application_id = $data['application_id'];
            $result->added_by = $data['added_by'];
            $result->save();

            $response = [
                'status' => Response::HTTP_OK,
                'message' => __('Application has been created')
            ];
        }
        return response()->json($response, $response['status']);
    }
}
