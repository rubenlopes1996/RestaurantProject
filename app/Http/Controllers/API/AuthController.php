<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;

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

    public function login()
    {
    // Check if a user with the specified email exists
        $user = User::whereEmail(request('username'))->first();
        
        if (!$user) {
            $user = User::where('username', request('username'))->first();
            if (!$user) {
                return response()->json([
                    'message' => 'Wrong credentials',
                    'status' => 422
                ], 422);
            }
        }
        $username = $user->email; 

    // If a user with the email was found - check if the specified password
    // belongs to this user
        if (!Hash::check(request('password'), $user->password)) {
            return response()->json([
                'message' => ' password',
                'status' => 422
            ], 422);
        }

    // Send an internal API request to get an access token
        $client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();


        if ($user->blocked == 1) {
            return response()->json([
                'message' => 'User have a block account please contact your manager.',
                'status' => 403
            ], 403);
        }
    // Make sure a Password Client exists in the DB
        if (!$client) {
            return response()->json([
                'message' => 'Laravel Passport is not setup properly.',
                'status' => 500
            ], 500);
        }

        $data = [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $username,
            'password' => request('password'),
        ];

        $request = Request::create('/oauth/token', 'POST', $data);

        $response = app()->handle($request);

    // Check if the request was successful
        if ($response->getStatusCode() != 200) {
            return response()->json([
                'message' => 'Wrong email or password',
                'status' => 422
            ], 422);
        }

    // Get the data from the response
        $data = json_decode($response->getContent());

    // Format the final response in a desirable format
        return response()->json([
            'token' => $data->access_token,
            'user' => $user,
            'status' => 200
        ]);
    }

    public function logout()
    {
        $accessToken = auth()->user()->token();

        $refreshToken = DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();

        return response()->json(['status' => 200]);
    }

    public function getUser()
    {
        return auth()->user();
    }
}
