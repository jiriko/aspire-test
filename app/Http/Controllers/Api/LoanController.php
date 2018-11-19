<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoanCreate;
use App\Http\Resources\LoanResource;
use App\Loan\Generator;

class LoanController extends Controller
{
    public function store(LoanCreate $request)
    {
        return new LoanResource(Generator::create($request));
    }
}
