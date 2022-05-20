<?php
namespace app\Services;

use App\Models\Hmo;

class HmoService{

    public function create(Array $data)
    {
       return Hmo::create($data);
    }

}