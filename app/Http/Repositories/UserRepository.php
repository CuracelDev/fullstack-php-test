<?php

namespace App\Http\Repositories;
use App\Http\CommonHelper;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;
use DB;
use Validator;

class UserRepository
{
    use CommonHelper;
    
    protected $user;

    public function __construct(
        User $user
    ) {
        $this->user = $user;
    }

    public function login($data) {
    
    }

    public function register($data) {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ];

        $validator = Validator::make($data->all(), $rules);
        $errors = $validator->errors();
        
        if($validator->fails()) {
            foreach($errors->all() as $error) {
                $error_details = ['type' => 'error', 'message' => $error];
                return $error_details;
            }
        } else {
            $email_exists = $this->user->whereEmail($data->email)->first();
            
            if($email_exists) {
                $details = ['type' => 'error','message' => 'Email address exists. Try again.'];
                return $details;
            } else {

                $user = $this->user->create([
                    'name' => $data->name,
                    'email' => $data->email,
                    'age' => $data->age,
                    'tax' => $data->tax,
                    'password' => bcrypt($data->password)
                ]);

                $details = [
                    'type' => 'success',
                    'user' => $user,
                ];

                return $details;
            }
        }
    }
}
