<?php

namespace App\Http\Controllers\API;

use App\Helpers\APIRequestHelper;
use App\Http\Controllers\Controller;
use App\Models\Examination;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExaminationsController extends Controller
{
    public function getExamination(Request $request)
    {
        $data = APIRequestHelper::validate($request->all(), [
            'id_examination' => ['required', 'integer']
        ]);

        if(!isset($data['errors'])) {
            $examination = Examination::find($data['id_examination']);

            if(empty($examination)) {
                $data = [
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => __('Examination not found')
                ];
                return response()->json($data, $data['status']);
            }

            $data = [
                'status' => Response::HTTP_OK,
                'examination' => [
                    'id' => $examination->id,
                    'name' => $examination->name,
                    'pricePLN' => $examination->pricePLN,
                    'details' => $examination->details
                ]
            ];
        }

        return response()->json($data, $data['status']);
    }

    public function getExaminationByName($name)
    {
        $examinations = Examination::where('name', 'like', $name);
        if(empty($examinations)) {
            $data = [
                'status' => Response::HTTP_NOT_FOUND,
                'message' => __('Examination not found')
            ];
        }
        else {
            $data = [
                'status' => Response::HTTP_OK,
                'data' => $examinations->toArray()
            ];
        }
        return response()->json($data, $data['status']);
    }

    public function addExamination(Request $request)
    {
        $data = APIRequestHelper::validate($request->all(), [
            'name' => ['required', 'string', 'max:15'],
            'pricePLN' => ['required|numeric|0.00,9999.99'],
            'details' => ['required', 'string']
        ]);

        if(!isset($data['errors'])) {
            $examination = new Examination();
            $examination->name = $data['name'];
            $examination->pricePLN = $data['pricePLN'];
            $examination->details = $data['details'];
            //TODO validation of role - only administrators can add examination
            $examination->save();
            $data = [
                'status' => Response::HTTP_CREATED,
                'message' => __('Examination successfully added')
            ];
        }

        return response()->json($data, $data['status']);
    }

    public function editExamination(Request $request)
    {
        $data = APIRequestHelper::validate($request->all(), [
            'id_examination' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:15'],
            'pricePLN' => ['required|numeric|0.00,9999.99'],
            'details' => ['required', 'string']
        ]);

        if(!isset($data['errors'])) {
            $examination = Examination::find($data['id_examination']);

            if(empty($examination)) {
                $data = [
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => __('Examination not found')
                ];
                return response()->json($data, $data['status']);
            }

            $examination->name = $data['name'];
            $examination->pricePLN = $data['pricePLN'];
            $examination->details = $data['details'];
            //TODO validation of role - only administrators can update examination
            $examination->save();
            $data = [
                'status' => Response::HTTP_ACCEPTED,
                'message' => __('Examination successfully updated')
            ];
        }

        return response()->json($data, $data['status']);
    }

    public function deleteExamination(Request $request)
    {
        $data = APIRequestHelper::validate($request->all(), [
            'id_examination' => ['required', 'integer']
        ]);

        if(!isset($data['errors'])) {
            $examination = Examination::find($data['id_examination']);

            if(empty($examination)) {
                $data = [
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => __('Examination not found')
                ];
                return response()->json($data, $data['status']);
            }

            //TODO validation of role - only administrators can delete examination
            $examination->delete();
            $data = [
                'status' => Response::HTTP_ACCEPTED,
                'message' => __('Examination successfully deleted')
            ];

        }

        return response()->json($data, $data['status']);
    }
}
