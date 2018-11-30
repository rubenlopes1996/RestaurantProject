<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;

define('YOUR_SERVER_URL', 'http://restaurantproject.dad');
// Check "oauth_clients" table for next 2 values:
define('CLIENT_ID', '2');
define('CLIENT_SECRET', '0Xm4ZQvOhjrYU2yRSrZfGmjdakadQyLCytoF7NOa');

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $data = $request->validate([
            'email' => 'required|email|unique:users,email',
            'type' => 'required',
            'name' => 'required',
        ]);

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->type = $data['type'];
        $username = strstr($data['email'], '@', true);
        $user->username = $username;
        $user->password = Hash::make(123); //Se se conseguir que user nao tenha password tirar esta linha
        $user->blocked = 1;

        //Send email
        $title = $request->input('Confirmation account');
        $content = $request->input('Ola tiago link');

        Mail::send('master', ['title' => $title, 'content' => $content, 'user' => $user], function ($message) use ($user) {

            $message->from('mailgun@sandbox8ca773b433d0429bb6d345de1ed27764.mailgun.org', 'Admin Restaurant DAD');

            $message->to($user->email);



        });
        $user->save();

        return response()->json(new UserResource($user), 201);

    }

    public function login(Request $request)
    {
        $user = User::where('username', $request->email)->first();
        if (!$user) {
            $username = $request->email;
        } else {
            $username = $user->email;
        }

        $http = new \GuzzleHttp\Client;
        $response = $http->post(YOUR_SERVER_URL . '/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => CLIENT_ID,
                'client_secret' => CLIENT_SECRET,
                'username' => $username,
                'password' => $request->password,
                'scope' => ''
            ],
            'exceptions' => false,
        ]);
        $errorCode = $response->getStatusCode();
        if ($errorCode == '200') {
            return json_decode((string)$response->getBody(), true);
        } else {
            return response()->json(['msg' => 'User credentials are invalid'], $errorCode);
        }
    }

    public function logout()
    {
        \Auth::guard('api')->user()->token()->revoke();
        \Auth::guard('api')->user()->token()->delete();
        return response()->json(['msg' => 'Token revoked'], 200);
    }

    public function getUser(Request $request)
    {
        return new UserResource($request->user());
    }
}
