<?php


namespace App\Service;


use ArithmeticError;
use GMP;

class MathService
{

    /**
     * @var array[]
     */
    private $tribonacciBasedArray;

    public function __construct()
    {
        $this->tribonacciBasedArray= [
            [gmp_init(1), gmp_init(1), gmp_init(1)],
            [gmp_init(1), gmp_init(0), gmp_init(0)],
            [gmp_init(0), gmp_init(1), gmp_init(0)],
        ];
    }


    public function tribonacci(int $number): GMP
    {
        if ($number < 0) {
            throw new ArithmeticError("Unsupported tribonacci operation");
        }
        if ($number == 0 || $number == 1) {
            return gmp_init(0);
        }
        if ($number == 2) {
            return gmp_init(1);
        }
        $tribonacciPowerArray = $this->recursivePower($this->tribonacciBasedArray, $number - 2);
        return $tribonacciPowerArray[0][0];
    }

    public function recursivePower(array $a, int $power): array
    {
        if ($power < 1) {
            throw new ArithmeticError("Unsupported power operation");
        }
        if ($power == 1)
            return $a;


        $return = $this->recursivePower($a, $power / 2);

        $return = $this->multiplyTow3x3Arrays($return, $return);

        if ($power % 2) {
            $return = $this->multiplyTow3x3Arrays($return, $a);
        }

        return $return;
    }

    /**
     * @param array $a
     * @param array $b
     * @return GMP[][]
     */
    public function multiplyTow3x3Arrays(array $a, array $b): array
    {

        if (count($a) != count($b)) {
            throw new ArithmeticError("The arrays are not equals");
        }
        if (count($a) != 3) {
            throw new ArithmeticError("The arrays are not 3*3");
        }
        foreach ($a as $key => $item) {
            if (count($item) != 3) {
                throw new ArithmeticError("The column $key of first array not 3");
            }
        }
        foreach ($b as $key => $item) {
            if (count($item) != 3) {
                throw new ArithmeticError("The column $key of second array not 3");
            }
        }
        $BRows = [
            [$b[0][0], $b[1][0], $b[2][0]],
            [$b[0][1], $b[1][1], $b[2][1]],
            [$b[0][2], $b[1][2], $b[2][2]],
        ];
        return [
            [
                $this->multipleCrossTow3x1vectors($a[0], $BRows[0]),
                $this->multipleCrossTow3x1vectors($a[0], $BRows[1]),
                $this->multipleCrossTow3x1vectors($a[0], $BRows[2]),
            ],
            [
                $this->multipleCrossTow3x1vectors($a[1], $BRows[0]),
                $this->multipleCrossTow3x1vectors($a[1], $BRows[1]),
                $this->multipleCrossTow3x1vectors($a[1], $BRows[2]),
            ],
            [
                $this->multipleCrossTow3x1vectors($a[2], $BRows[0]),
                $this->multipleCrossTow3x1vectors($a[2], $BRows[1]),
                $this->multipleCrossTow3x1vectors($a[2], $BRows[2]),
            ],
        ];
    }

    /**
     * @param array $a
     * @param array $b
     * @return GMP
     */
    public function multipleCrossTow3x1vectors(array $a, array $b): GMP
    {
        if (count($a) != count($b)) {
            throw new ArithmeticError("The arrays are not equals");
        }
        if (count($a) != 3) {
            throw new ArithmeticError("The arrays are not 3*1");
        }

        foreach ($a as $key => $item) {
            if (!is_object($item) || get_class($item) !== 'GMP') {
                throw new ArithmeticError("The column $key of first array is not number GMP");
            }
        }
        foreach ($b as $key => $item) {
            if (!is_object($item) || get_class($item) !== 'GMP') {
                throw new ArithmeticError("The column $key of second array is not number GMP");
            }
        }
        return gmp_add(gmp_mul($a[0],$b[0]),gmp_add(gmp_mul($a[1],$b[1]),gmp_mul($a[2],$b[2])));
    }
}
