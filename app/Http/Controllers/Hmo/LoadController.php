<?php

namespace App\Http\Controllers\Hmo;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Hmo;


class LoadController extends ApiController
{

    public function index()
    {
        $hmos = $this->getListByColumnPaginate( 'deleted_at', null, "*", new Hmo());
        return $this->showAll($hmos);
    }
}