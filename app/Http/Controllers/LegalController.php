<?php

namespace App\Http\Controllers;

class LegalController extends Controller
{
    public function mentions()
    {
        return view('legal.mentions');
    }

    public function privacy()
    {
        return view('legal.privacy');
    }

    public function cgu()
    {
        return view('legal.cgu');
    }

    public function cookies()
    {
        return view('legal.cookies');
    }

    public function policies()
    {
        return view('legal.policies');
    }

    public function faq()
    {
        return view('legal.faq');
    }
}