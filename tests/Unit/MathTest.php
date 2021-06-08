<?php

namespace Tests\Unit;

use App\Service\MathService;
use ArithmeticError;
use PHPUnit\Framework\TestCase;

class MathTest extends TestCase
{
    /** @var MathService */
    protected $mathService;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->mathService = app(MathService::class);
        parent::__construct($name, $data, $dataName);
    }

    public function test_first_exception_multiple_cross_tow_3x1_vectors()
    {
        $a = [gmp_init(1), gmp_init(2), gmp_init(3)];
        $b = [gmp_init(1), gmp_init(2)];
        $this->expectException(ArithmeticError::class);
        $this->expectExceptionMessage("The arrays are not equals");
        $this->mathService->multipleCrossTow3x1vectors($a, $b);


    }

    public function test_second_exception_multiple_cross_tow_3x1_vectors()
    {
        $b = [gmp_init(1), gmp_init(2)];
        $this->expectException(ArithmeticError::class);
        $this->expectExceptionMessage("The arrays are not 3*1");
        $this->mathService->multipleCrossTow3x1vectors($b, $b);
    }

    public function test_third_exception_multiple_cross_tow_3x1_vectors()
    {
        $a = [
            [gmp_init(1), gmp_init(1), gmp_init(1)],
            gmp_init(2),
            gmp_init(3)
        ];
        $b = [gmp_init(1), gmp_init(2), gmp_init(3)];
        $this->expectException(ArithmeticError::class);
        $this->expectExceptionMessage("The column 0 of first array is not number GMP");
        $this->mathService->multipleCrossTow3x1vectors($a, $b);
    }

    public function test_fourth_exception_multiple_cross_tow_3x1_vectors()
    {
        $a = [
            [gmp_init(1), gmp_init(1), gmp_init(1)],
            gmp_init(2),
            gmp_init(3)
        ];
        $b = [gmp_init(1), gmp_init(2), gmp_init(3)];
        $this->expectException(ArithmeticError::class);
        $this->expectExceptionMessage("The column 0 of second array is not number GMP");
        $this->mathService->multipleCrossTow3x1vectors($b, $a);
    }

    public function test_multiple_cross_tow_3x1_vectors()
    {
        $a = [gmp_init(1), gmp_init(2), gmp_init(3)];
        $b = [gmp_init(1), gmp_init(2), gmp_init(3)];
        $this->assertEquals(14, gmp_intval($this->mathService->multipleCrossTow3x1vectors($a, $b)));
    }


    public function test_first_exception_two_array_3x3_multiply()
    {
        $a = [
            [gmp_init(1), gmp_init(1), gmp_init(1)],
            [gmp_init(1), gmp_init(1), gmp_init(3)],
            [gmp_init(1), gmp_init(3), gmp_init(2)]
        ];
        $b = [
            [gmp_init(1), gmp_init(1), gmp_init(1)],
            [gmp_init(1), gmp_init(3), gmp_init(2)]
        ];
        $this->expectException(ArithmeticError::class);
        $this->expectExceptionMessage("The arrays are not equals");
        $this->mathService->multiplyTow3x3Arrays($a, $b);


    }

    public function test_second_exception_two_array_3x3_multiply()
    {
        $b = [
            [gmp_init(1), gmp_init(1), gmp_init(1)],
            [gmp_init(1), gmp_init(3), gmp_init(2)]
        ];
        $this->expectException(ArithmeticError::class);
        $this->expectExceptionMessage("The arrays are not 3*3");
        $this->mathService->multiplyTow3x3Arrays($b, $b);
    }

    public function test_third_exception_two_array_3x3_multiply()
    {
        $a = [
            [gmp_init(1), gmp_init(1), gmp_init(1)],
            [gmp_init(1), gmp_init(1), gmp_init(3)],
            [gmp_init(1), gmp_init(3), gmp_init(2)]
        ];
        $c = [
            [gmp_init(1), gmp_init(1), gmp_init(1)],
            [gmp_init(1), gmp_init(1)],
            [gmp_init(1), gmp_init(3), gmp_init(2)],
        ];
        $this->expectException(ArithmeticError::class);
        $this->expectExceptionMessage("The column 1 of first array not 3");
        $this->mathService->multiplyTow3x3Arrays($c, $a);
    }

    public function test_fourth_exception_two_array_3x3_multiply()
    {
        $a = [
            [gmp_init(1), gmp_init(1), gmp_init(1)],
            [gmp_init(1), gmp_init(1), gmp_init(3)],
            [gmp_init(1), gmp_init(3), gmp_init(2)]
        ];
        $c = [
            [gmp_init(1), gmp_init(1), gmp_init(1)],
            [gmp_init(1), gmp_init(1)],
            [gmp_init(1), gmp_init(3), gmp_init(2)],
        ];
        $this->expectException(ArithmeticError::class);
        $this->expectExceptionMessage("The column 1 of second array not 3");
        $this->mathService->multiplyTow3x3Arrays($a, $c);

    }

    public function test_two_array_3x3_multiply()
    {
        $a = [
            [gmp_init(1), gmp_init(1), gmp_init(1)],
            [gmp_init(1), gmp_init(0), gmp_init(0)],
            [gmp_init(0), gmp_init(1), gmp_init(0)],
        ];
        $result = [
            [2, 2, 1],
            [1, 1, 1],
            [1, 0, 0]
        ];
        $gmpResult = $this->mathService->multiplyTow3x3Arrays($a, $a);
        foreach ($gmpResult as $col => $items) {
            foreach ($items as $row => $item) {
                $this->assertEquals($result[$col][$row], gmp_intval($item));
            }
        }
    }

    public function test_recursive_power()
    {
        $a = [
            [gmp_init(1), gmp_init(1), gmp_init(1)],
            [gmp_init(1), gmp_init(0), gmp_init(0)],
            [gmp_init(0), gmp_init(1), gmp_init(0)],
        ];
        $result = [
            [2, 2, 1],
            [1, 1, 1],
            [1, 0, 0]
        ];
        $gmpResult = $this->mathService->recursivePowerMatrix($a, 1);
        foreach ($gmpResult as $col => $items) {
            foreach ($items as $row => $item) {
                $this->assertEquals(gmp_intval($a[$col][$row]), gmp_intval($item));
            }
        }
        $gmpResult2 = $this->mathService->recursivePowerMatrix($a, 2);
        foreach ($gmpResult2 as $col => $items) {
            foreach ($items as $row => $item) {
                $this->assertEquals($result[$col][$row], gmp_intval($item));
            }
        }

    }

    public function test_exception_recursive_power()
    {
        $a = [
            [gmp_init(1), gmp_init(1), gmp_init(1)],
            [gmp_init(1), gmp_init(0), gmp_init(0)],
            [gmp_init(0), gmp_init(1), gmp_init(0)],
        ];
        $this->expectException(ArithmeticError::class);
        $this->expectExceptionMessage("Unsupported power operation");
        $this->mathService->recursivePowerMatrix($a, -1);
    }

    public function test_tribonacci()
    {
        $this->assertEquals(0, gmp_intval($this->mathService->tribonacci(0)));
        $this->assertEquals(0, gmp_intval($this->mathService->tribonacci(1)));
        $this->assertEquals(1, gmp_intval($this->mathService->tribonacci(2)));
        $this->assertEquals(1, gmp_intval($this->mathService->tribonacci(3)));
        $this->assertEquals(2, gmp_intval($this->mathService->tribonacci(4)));
        $this->assertEquals(4, gmp_intval($this->mathService->tribonacci(5)));
        $this->assertEquals(7, gmp_intval($this->mathService->tribonacci(6)));
        $this->assertEquals(13, gmp_intval($this->mathService->tribonacci(7)));
        $this->assertEquals(24, gmp_intval($this->mathService->tribonacci(8)));
        $this->assertEquals(44, gmp_intval($this->mathService->tribonacci(9)));
        $this->assertEquals(81, gmp_intval($this->mathService->tribonacci(10)));
    }

    public function test_exception_tribonacci()
    {
        $this->expectException(ArithmeticError::class);
        $this->expectExceptionMessage("Unsupported tribonacci operation");
        $this->mathService->tribonacci( -1);
    }
}
