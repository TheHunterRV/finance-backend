<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{

    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

       public function login()
    {
        $data = $this->request->getJSON(true);

        $user = $this->userModel
            ->where('email', $data['email'])
            ->first();

        if (!$user || !password_verify($data['password'], $user['password'])) {
            return $this->response->setJSON([
                'error' => 'Invalid credentials'
            ])->setStatusCode(401);
        }


        $token = generateJWT($user);

        return $this->response->setJSON([
            'message' => 'Login successful',
            'token' => $token
        ])->setStatusCode(200);
       
    }

}
