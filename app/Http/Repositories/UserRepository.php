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

    public function getUser($userId) {
        return $this->user->find($userId);
    }

    public function login($data) {
        $token = null;
        $credentials = $data->only('email', 'password');
        
        if(!$token = auth('api')->attempt($credentials)) {
            $response = ['type' => 'error', 'message' => 'Incorrect login details']; 
            return $response;
        }

        $user = $this->user->whereEmail($data->email)->first();
        
        if($user) {
            
            $auth_user = $this->getUser($user->id);
            $check_password = Hash::check($data->password, $auth_user->password);

            if($check_password ) {
                $profile = $this->getUser($user->id);
                $details = ['type' => 'success', 'user' => $profile, 'token' => $token];
                return $details;
            } else {
                $details = ['type' => 'error', 'message' => 'Incorrect login details']; 
                return $details;
            }

        } else {
            $details = ['type' => 'error', 'message' => 'Incorrect login details'];    
            return $details;
        }
    }

    public function register($data) {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'age' => 'required',
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
