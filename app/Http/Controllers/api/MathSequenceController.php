<?php


namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use App\Http\Requests\TribonacciRequest;
use App\Service\MathService;

class MathSequenceController extends Controller
{

    /**
     * @param TribonacciRequest $request
     * @param MathService $service
     * @return string
     */
    public function tribonacci(TribonacciRequest $request, MathService $service): string
    {
        return gmp_strval($service->tribonacci($request->n));
    }
}
