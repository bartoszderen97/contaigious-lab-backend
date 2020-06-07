<?php

namespace App\Http\Controllers\API;

use App\Helpers\APIRequestHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function getAllUsers()
    {
        $userRole = Auth::user()->role;
        if($userRole != "admin") {
            $response = [
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'You don\'t have permission to this page'
            ];
        }
        else {
            $users = User::get()->toArray();
            $response = [
                'status' => Response::HTTP_OK,
                'data' => $users
            ];
        }
        return response()->json($response, $response['status']);
    }

    public function getSingleUser($id_user)
    {
        $data = APIRequestHelper::validate(['id_user' => $id_user],
            ['id_user' => ['required','integer']]);
        if(isset($data['errors'])) {
            return response()->json($data, $data['status']);
        }

        $userRole = Auth::user()->role;
        if($userRole != "admin" || Auth::id() != $data['id_user']) {
            $data = [
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'You don\'t have permission to this page'
            ];
        }
        else {
            $user = User::find($id_user);
            if(empty($user)) {
                $data = [
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => __('User not found')
                ];
            }
            else {
                $user = $user->toArray();
                $data = [
                    'status' => Response::HTTP_OK,
                    'data' => $user
                ];
            }
        }

        return response()->json($data, $data['status']);
    }

    public function deleteUser($id_user)
    {
        $data = APIRequestHelper::validate(['id_user' => $id_user],
            ['id_user' => ['required','integer']]);
        if(isset($data['errors'])) {
            return response()->json($data, $data['status']);
        }

        $userRole = Auth::user()->role;
        if($userRole != "admin" || Auth::id() != $data['id_user']) {
            $data = [
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'You don\'t have permission to this page'
            ];
        }
        else {
            $user = User::find($id_user);
            if(empty($user)) {
                $data = [
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => __('User not found')
                ];
            }
            else {
                $user->delete();
                $data = [
                    'status' => Response::HTTP_OK,
                    'message' => __('User has been deleted')
                ];
            }
        }
        return response()->json($data, $data['status']);
    }

    public function updateUser(Request $request)
    {
        $data = APIRequestHelper::validate($request->all(), [
            'id_user' => ['required','integer'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'pesel' => ['required', 'integer'],
            'gender' => ['required', 'string', Rule::in(['M', 'F', 'O'])],
            'lang' => ['required', 'string']
        ]);
        if(isset($data['errors'])) {
            return response()->json($data, $data['status']);
        }
        $userRole = Auth::user()->role;
        if($userRole != "admin" || Auth::id() != $data['id_user']) {
            $data = [
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'You don\'t have permission to this page'
            ];
        }
        else {
            $user = User::find($data['id_user']);
            if(empty($user)) {
                $data = [
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => __('User not found')
                ];
            }
            else {
                $user->first_name = $data['first_name'];
                $user->last_name = $data['last_name'];
                $user->email = $data['email'];
                $user->pesel = $data['pesel'];
                $user->gender = $data['gender'];
                $user->lang = $data['lang'];
                $user->save();

                $data = [
                    'status' => Response::HTTP_OK,
                    'message' => __('User has been updated')
                ];
            }
        }
        return response()->json($data, $data['status']);
    }

    public function changePassword(Request $request)
    {
        //TODO
    }

    public function switchLanguage(Request $request)
    {
        //TODO
    }

}
