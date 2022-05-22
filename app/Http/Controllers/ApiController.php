<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\Traits\ApiQuery;
use Illuminate\Http\Request;


class ApiController extends Controller
{
    use ApiResponser;
    use ApiQuery;

    public function __construct()
    {

    }


}
