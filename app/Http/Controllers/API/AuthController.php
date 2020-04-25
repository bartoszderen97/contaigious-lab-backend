<?php

namespace App\Http\Controllers\API;


use App\Helpers\APIRequestHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    use SendsPasswordResetEmails;

    public function register(Request $request)
    {
        $data = APIRequestHelper::validate($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'pesel' => ['required', 'integer'],
            'gender' => ['required', 'string', Rule::in(['M', 'F', 'O'])],
            'lang' => ['required', 'string']
        ]);

        if(!isset($data['errors'])) {
            $user = new User();

            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->pesel = $data['pesel'];
            $user->gender = $data['gender'];
            $user->lang = $data['lang'];

            $user->save();

            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                $data = [
                    'status' => Response::HTTP_OK,
                    'token' => $user->createToken('contaigious-lab')->accessToken,
                    'user_id' => $user->id
                ];
            }
            else {
                $data = [
                    'status' => Response::HTTP_CONFLICT,
                    'errors' => [
                        'token' => __('Wrong credentials')
                    ]
                ];
            }
        }

        return response()->json($data, $data['status']);
    }

    public function login(Request $request)
    {
        $data = APIRequestHelper::validate($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if(!isset($data['errors'])) {
            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {

                $user = Auth::user();
                $data = [
                    'status' => Response::HTTP_OK,
                    'token' => $user->createToken('contaigious-lab')->accessToken,
                    'user_id' => $user->id
                ];
            }
            else {
                $data = [
                    'status' => Response::HTTP_NOT_FOUND,
                    'errors' => [
                        'token' => __('Wrong email, password or user doesn\'t exists')
                    ]
                ];
            }
        }

        return response()->json($data, $data['status']);
    }

    public function resetPassword(Request $request)
    {
        $data = APIRequestHelper::validate($request->all(), [
            'email' => ['string', 'email'],
            'lang' => ['required', 'string']
        ]);

        if(!isset($data['errors'])) {
            $response = $this->broker()->sendResetLink(
                $this->credentials($request)
            );

            if ($response == Password::RESET_LINK_SENT) {
                $data = [
                    'status' => Response::HTTP_OK,
                    'info' => __($response)
                ];
            }
            else {
                $data = [
                    'status' => Response::HTTP_CONFLICT,
                    'error' => [
                        'email' => __($response)
                    ]
                ];
            }
        }

        return response()->json($data, $data['status']);
    }


}
