<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResultsController extends Controller
{
    public function getAllResults() {

        return response()->json($response, $response['status']);
    }

    public function getAllResultsOfUser() {

        return response()->json($response, $response['status']);
    }

    public function getSingleResult($id_application) {

        return response()->json($response, $response['status']);
    }

    public function deleteResult($id_result) {

        return response()->json($response, $response['status']);
    }

    public function updateResult(Request $request) {

        return response()->json($response, $response['status']);
    }

    public function createResult(Request $request) {

        return response()->json($response, $response['status']);
    }
}
