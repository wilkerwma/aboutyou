<?php

namespace App\Http\Controllers;

class MatrixMultiplicationController extends Controller
{
    public function __invoke()
    {
        $validatedData = request()->validate(
            [
                '*.rows'    => 'required|integer|min:1',
                '*.columns' => 'required|integer|min:1',
                '0.columns' => 'same:1.rows',
                '*.matrix'  => 'required'
            ],
            [
                '0.columns.same'     => 'The column count in the first matrix should be equal to the row count of the second matrix.',
                '*.columns.required' => 'The column amount is required.',
                '*.rows.required'    => 'The row amount is required.',
                '*.columns.min' => 'The column amount must be greater than 0.',
                '*.rows.min'    => 'The row amount must be greater than 0.'
            ]
        );

        $firstMatrix  = $validatedData[0];
        $secondMatrix = $validatedData[1];

        return $this->multiplyMatrices($firstMatrix, $secondMatrix);
    }

    private function multiplyMatrices(array $firstMatrix, array $secondMatrix): array
    {
        $resultingMatrix = array();
        
        for ($i = 0; $i < $firstMatrix['rows']; $i++) {
            for ($j = 0; $j < $secondMatrix['columns']; $j++) {
                $resultingMatrix[$i][$j] = 0;
                for ($k = 0; $k < $secondMatrix['rows']; $k++) {
                    $resultingMatrix[$i][$j] += $firstMatrix['matrix'][$i][$k] * $secondMatrix['matrix'][$k][$j];
                }
            }
        }

        return $resultingMatrix;
    }
}
