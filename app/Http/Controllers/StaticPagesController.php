<?php

namespace App\Http\Controllers;

class StaticPagesController
{
    public function index()
    {
        return view('static.index');
    }
}
