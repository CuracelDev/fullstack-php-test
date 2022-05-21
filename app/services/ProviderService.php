<?php
namespace app\Services;

use App\Models\User;

class ProviderService{

    public function create(Array $data)
    {
       return User::create($data);
    }

    public function all()
    {
        return User::all();
    }

    public function get($id)
    {
        return User::find($id);
    }

}