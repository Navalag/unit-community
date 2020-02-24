<?php

namespace App\Inspections;

use Exception;
use Illuminate\Support\Facades\Config;

class InvalidKeywords
{
    /**
     * All registered invalid keywords.
     *
     * @var array
     */
    protected $keywords;

    public function __construct()
    {
        $this->keywords = Config::get('bannedwords.list');
    }

    /**
     * Detect spam.
     *
     * @param  string $body
     * @throws Exception
     */
    public function detect($body)
    {
        foreach ($this->keywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new Exception('Your reply contains spam.');
            }
        }
    }
}
