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

        for ($row = 0; $row < $firstMatrix['rows']; $row++) {
            for ($column = 0; $column < $secondMatrix['columns']; $column++) {
                $resultingMatrix[$row][$column] = 0;
                for ($secondaryRow = 0; $secondaryRow < $secondMatrix['rows']; $secondaryRow++) {
                    $resultingMatrix[$row][$column] += $firstMatrix['matrix'][$row][$secondaryRow] * $secondMatrix['matrix'][$secondaryRow][$column];
                }
            }
        }

        return $resultingMatrix;
    }
}
