<?php

namespace App\Inspections;

use Exception;

class KeyHeldDown
{
    /**
     * Detect spam.
     *
     * @param  string $body
     * @throws Exception
     */
    public function detect($body)
    {
        if (preg_match('/[^\s\'\[\]{}=$\-\n](.)\1{6,}/', $body)) {
            throw new Exception('Your reply contains spam.');
        }
    }
}
