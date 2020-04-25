<?php

namespace App\Helpers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class APIRequestHelper
{
    public static function validate($data, array $rules): array
    {
        $validator = Validator::make($data, $rules);

        if($validator->fails()) {
            $errors = [];

            foreach($validator->errors()->messages() as $key => $e) {
                $errors[$key][] = __($e[0]);
            }

            $data = [
                'status' => Response::HTTP_CONFLICT,
                'errors' => $errors,
            ];
        }

        return $data;
    }
}
