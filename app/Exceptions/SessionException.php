<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class SessionException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): RedirectResponse
    {
        return back()->with('danger', $this->getMessage());
    }
}
