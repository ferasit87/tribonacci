<?php

namespace App\Service;

use GMP;

interface MathServiceInterface
{
    /**
     * function to calculate tribonacci number
     * @param int $number
     * @return GMP
     */
    public function tribonacci(int $number): GMP;
}
