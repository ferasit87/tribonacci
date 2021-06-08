<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\TribonacciRequest;
use App\Service\MathService;
use Illuminate\Http\JsonResponse;

class MathSequenceController extends Controller
{

    /**
     * @param TribonacciRequest $request
     * @param MathService $service
     * @return JsonResponse
     */
    public function tribonacci(TribonacciRequest $request, MathService $service): JsonResponse
    {
        return response()->json([
            'Number' => $request->n,
            'tribonacci' => gmp_strval($service->tribonacci($request->n)),
        ]);
    }
}
