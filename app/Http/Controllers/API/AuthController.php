<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

define('YOUR_SERVER_URL', 'http://restaurantproject.dad');
// Check "oauth_clients" table for next 2 values:
define('CLIENT_ID', '2');
define('CLIENT_SECRET', 'ji5EfceQ6j71hjqUXDOdGHTWseunEwlnf19pnZrv');

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
        $title = 'Confirmation account';
        $url = "http://restaurantproject.dad/activateAccount/".$user->email;
    


        Mail::send('emails.send', ['title' => $title, 'user' => $user, 'url'=>$url], function ($message) use ($user) {
            $message->from('postmaster@restaurantedad.tk', 'Admin Restaurant DAD');
            $message->sender('postmaster@restaurantedad.tk', 'Admin Restaurant DAD');

            $message->to($user->email, $user->username);

            $message->subject('Account activation RestaurantDAD');

        });

        $user->save();

        return response()->json(new UserResource($user), 201);

    }

    public function login(Request $request)
    {
        $user = User::where('username', $request->email)->first();
        if($user){
            $username = $user->email;
        }else{
            $user = User::where('email', $request->email)->first();
            $username = $request->email;
        }
        if ($user->blocked == 0) {
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
        } else {
            return response()->json(['msg' => 'User blocked contact your manager'], 401);
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

    public function activateAccount($email){
        return view('employee.activateAccount')->with('email',$email);
    }
    public function confirmActivation(Request $request, $email){
        $request->validate([
            'password' => 'required|min:3',
            'passwordConfirmation' => 'required|same:password',
        ]);

        $userId = User::where('email', $email)->first();
        $user = User::findOrFail($userId->id);
        
        if($user->email_verified_at == null){
        $user->password = Hash::make($request->input('password'));
        $user->email_verified_at = Carbon::now();
        $user->blocked = 0;
       $user->save();

        return new UserResource($user);
        }
        return response()->json(['msg' => 'Account already has been activated.'], 403);
    

    }
}
