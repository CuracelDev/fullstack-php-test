<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\Traits\ApiQuery;
use App\Traits\ApiOperations;
use Illuminate\Http\Request;


class ApiController extends Controller
{
    use ApiResponser;
    use ApiQuery;
    use ApiOperations;

    public function __construct()
    {

    }


}
