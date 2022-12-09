<?php

namespace App\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    public function render()
    {
        return response()->json([
            'status' => false,
            'error' => $this->getMessage()
        ], 404);
    }
}
