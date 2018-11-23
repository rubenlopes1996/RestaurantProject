<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\DB;
use App\User;
use App\StoreUserRequest;
use Hash;


class UserControllerAPI extends Controller
{
    public function index(Request $request)
    {
        /*if ($request->has('page')) {
            return UserResource::collection(User::paginate(5));
        } else {*/
        return UserResource::collection(User::all());
        //}
    }

    public function show($id)
    {
        return new UserResource(User::find($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'min:3',
            'type' => 'required'
        ]);
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($user->password);
        $user->save();
        return response()->json(new UserResource($user), 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);
        $user = User::findOrFail($id);
        $user->update($request->all());
        return new UserResource($user);
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $dados = $request->validate([
            'name' => 'required|string|max:255|regex:/^[\pL\s]+$/u',
            'username' => 'required',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'photo_url' => 'required',
        ]);

        $user->name = $dados['name'];
        $user->email = $dados['email'];
        $user->username = $dados['username'];
        $file = $dados['photo_url'] ?? null;
        if ($file != null) {
            $file_name = basename($file->store('profiles', 'public'));
            $user->update(['photo_url' => $file_name]);
        }

        $user->save();
        return new UserResource($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user = $user->delete();
        return response()->json(null, 204);
    }

    public function startShift($id)
    {
        $user = User::findOrFail($id);
        $user->last_shift_start = date("Y-m-d H:i:s");
        $user->shift_active =1;
        $user->save();

        return response()->json(null, 200);
    }

    public function endShift($id)
    {
        $user = User::findOrFail($id);
        $user->last_shift_end = date("Y-m-d H:i:s");
        $user->shift_active =0;
        $user->save();

        return response()->json(null, 200);
    }

}
