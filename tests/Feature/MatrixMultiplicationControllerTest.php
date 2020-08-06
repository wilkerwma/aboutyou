<?php

namespace Tests\Feature;

use Tests\TestCase;

class MatrixMultiplicationControllerTest extends TestCase
{
    private function generateDefaultMatrix(string $id = 'first'): array
    {
        return [
            'id' => $id,
            'rows' => 2,
            'columns' => 2,
            'matrix' => [
                [2, 2],
                [2, 2],
            ]
        ];
    }

    public function testToolAccess()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testIfTheRowsOfFirstMatrixAreRequired()
    {
        $firstMatrix = $this->generateDefaultMatrix();
        $secondMatrix = $this->generateDefaultMatrix('second');

        $firstMatrix['rows'] = null;

        $data = [
            $firstMatrix, $secondMatrix
        ];

        $response = $this->json('POST', '/matrix', $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                '0.rows' => 'The row amount is required.'
            ]);
    }

    public function testIfTheColumnsOfFirstMatrixMatchTheRowsOfSecondMAtrix()
    {
        $firstMatrix  = $this->generateDefaultMatrix();
        $secondMatrix = $this->generateDefaultMatrix('second');

        $firstMatrix['columns'] = 7;

        $data = [
            $firstMatrix, $secondMatrix
        ];

        $response = $this->json('POST', '/matrix', $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                '0.columns' => 'The column count in the first matrix should be equal to the row count of the second matrix.'
            ]);
    }

    public function testIfTheRowsOfSecondMatrixAreRequired()
    {
        $firstMatrix = $this->generateDefaultMatrix();
        $secondMatrix = $this->generateDefaultMatrix('second');

        $secondMatrix['rows'] = null;

        $data = [
            $firstMatrix, $secondMatrix
        ];

        $response = $this->json('POST', '/matrix', $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                '1.rows' => 'The row amount is required.'
            ]);
    }

    public function testIfTheColumnsOfSecondMatrixAreRequired()
    {
        $firstMatrix = $this->generateDefaultMatrix();
        $secondMatrix = $this->generateDefaultMatrix('second');

        $secondMatrix['columns'] = null;

        $data = [
            $firstMatrix, $secondMatrix
        ];

        $response = $this->json('POST', '/matrix', $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                '1.columns' => 'The column amount is required.'
            ]);
    }

    public function testSimpleSquareMatrixMultiplication()
    {
        $firstMatrix = $this->generateDefaultMatrix();
        $secondMatrix = $this->generateDefaultMatrix('second');

        $data = [
            $firstMatrix, $secondMatrix
        ];

        $resultMatrix = [
            [8, 8],
            [8, 8],
        ];

        $response = $this->json('POST', '/matrix', $data);
        $response
            ->assertStatus(200)
            ->assertJson($resultMatrix);
    }

    public function testZeroSquareMatrixMultiplication()
    {
        $firstMatrix = $this->generateDefaultMatrix();
        $secondMatrix = $this->generateDefaultMatrix('second');

        $firstMatrix['matrix'] = [
            [0, 0],
            [0, 0],
        ];


        $secondMatrix['matrix'] = [
            [0, 0],
            [0, 0],
        ];

        $data = [
            $firstMatrix, $secondMatrix
        ];

        $resultMatrix = [
            [0, 0],
            [0, 0],
        ];

        $response = $this->json('POST', '/matrix', $data);
        $response
            ->assertStatus(200)
            ->assertJson($resultMatrix);
    }

    public function testNullMatrixMultiplication()
    {
        $firstMatrix = $this->generateDefaultMatrix();
        $secondMatrix = $this->generateDefaultMatrix('second');

        $firstMatrix['matrix'] = [
            [0, 0],
            [0, 0],
        ];


        $secondMatrix['matrix'] = [
            [1, 1],
            [1, 1],
        ];

        $data = [
            $firstMatrix, $secondMatrix
        ];

        $resultMatrix = [
            [0, 0],
            [0, 0],
        ];

        $response = $this->json('POST', '/matrix', $data);
        $response
            ->assertStatus(200)
            ->assertJson($resultMatrix);
    }

    public function testRowMatrixByColumMatrixMultiplication()
    {
        $firstMatrix = $this->generateDefaultMatrix();
        $secondMatrix = $this->generateDefaultMatrix('second');
        $firstMatrix['rows']    = 4;
        $firstMatrix['columns'] = 1;
        $firstMatrix['matrix']  = [
            [2],
            [2],
            [2],
            [2],
        ];

        $secondMatrix['rows']    = 1;
        $secondMatrix['columns'] = 4;
        $secondMatrix['matrix'] = [
            [2, 2, 2, 2],
        ];

        $data = [
            $firstMatrix, $secondMatrix
        ];

        $resultMatrix = [
            [4, 4, 4, 4],
            [4, 4, 4, 4],
            [4, 4, 4, 4],
            [4, 4, 4, 4],
        ];

        $response = $this->json('POST', '/matrix', $data);
        $response
            ->assertStatus(200)
            ->assertJson($resultMatrix);
    }

    public function testDecimalNumbersMatrixMultiplication()
    {
        $firstMatrix = $this->generateDefaultMatrix();
        $secondMatrix = $this->generateDefaultMatrix('second');
        $firstMatrix['rows']    = 4;
        $firstMatrix['columns'] = 1;
        $firstMatrix['matrix']  = [
            [0.5],
            [0.5],
            [0.5],
            [0.5],
        ];

        $secondMatrix['rows']    = 1;
        $secondMatrix['columns'] = 4;
        $secondMatrix['matrix'] = [
            [2, 2, 2, 2],
        ];

        $data = [
            $firstMatrix, $secondMatrix
        ];

        $resultMatrix = [
            [1, 1, 1, 1],
            [1, 1, 1, 1],
            [1, 1, 1, 1],
            [1, 1, 1, 1],
        ];

        $response = $this->json('POST', '/matrix', $data);
        $response
            ->assertStatus(200)
            ->assertJson($resultMatrix);
    }

    public function testNegativeNumbersMatrixMultiplication()
    {
        $firstMatrix = $this->generateDefaultMatrix();
        $secondMatrix = $this->generateDefaultMatrix('second');

        $firstMatrix['matrix']  = [
            [-1, -1],
            [-1, -1],
        ];

        $secondMatrix['matrix'] = [
            [2, 2],
            [2, 2],
        ];

        $data = [
            $firstMatrix, $secondMatrix
        ];

        $resultMatrix = [
            [-4, -4],
            [-4, -4]
        ];

        $response = $this->json('POST', '/matrix', $data);
        $response
            ->assertStatus(200)
            ->assertJson($resultMatrix);
    }
}
