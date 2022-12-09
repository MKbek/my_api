<?php

namespace App\Exceptions;

use Exception;

class AuthException extends Exception
{
    public function render()
    {
        return response()->json([
            'status' => false,
            'errors' => $this->getMessage()
        ], 401);
    }
}
