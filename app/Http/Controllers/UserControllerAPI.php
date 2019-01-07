<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvoicesResource;
use App\Http\Resources\MealsResource;
use App\Http\Resources\MealsWithOrdersResource;
use App\Invoices;
use App\Meals;
use Illuminate\Contracts\Support\Jsonable;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\DB;
use App\User;
use App\StoreUserRequest;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;


class UserControllerAPI extends Controller
{
    public function index(Request $request)
    {
        return UserResource::collection(User::withTrashed()->get()); 
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
        $data = $request->validate([
            'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
            'username' => 'required|unique:users,username,' . $id,
        ]);

        $user = User::findOrFail($id);
        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->save();
        return new UserResource($user);
    }
    
    public function uploadPhoto(Request $request, $id)
    {
        $user = User::find($id);

        if ($user->photo_url) {
            Storage::disk('public')->delete('profile/' . $user->photo_url);
        }

        $file = Input::file('file');
        $filename = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $uploadedFile = str_random(10) . '.' . $ext;

        if (!Storage::disk('public')->put('profiles/' . $uploadedFile, File::get($file))) {
            return response()->json([
                'message' => 'Problem uploading item photo.',
                'status' => 422
            ], 422);
        }
        $user->photo_url = $uploadedFile;
        $user->save();

        return response()->json(
            [
                'status' => 201,
                'success' => 'item photo updated.',
                'photo' => $uploadedFile
            ]
        );
    }

    public function updateProfile(Request $request, $id)
    {
        $dados = $request->validate([
            'name' => 'required|string|max:255|regex:/^[\pL\s]+$/u',
            'username' => 'required|string',
        ]);
        $user = User::findOrFail($id);
        $user->name = $dados['name'];
        $user->username = $dados['username'];

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
        $user->shift_active = 1;
        $user->save();

        return new UserResource($user);
    }

    public function endShift($id)
    {
        $user = User::findOrFail($id);
        $user->last_shift_end = date("Y-m-d H:i:s");
        $user->shift_active = 0;
        $user->save();

        return new UserResource($user);
    }

    public function unblock($id){
        $user = User::findOrFail($id);
        $user->blocked = 0;
        $user->save();

        return new UserResource($user);
    }

    public function block($id){
        $user = User::findOrFail($id);
        $user->blocked = 1;
        $user->save();

        return new UserResource($user);
    }

    public function showUserByType($type)
    {

        return UserResource::collection(User::where('type',$type)->get());
    }

    public function showUsersWaiterCook()
    {

        return UserResource::collection(User::where('type','waiter')->orWhere('type','cook')->orderBY('name')->get());
    }

    public function getInvoicesByWaiter($id)
    {
        $invoices = Invoices::join('meals', 'invoices.meal_id', '=', 'meals.id')
            ->join('users', 'users.id', '=', 'meals.responsible_waiter_id')
            ->where('meals.responsible_waiter_id','=',$id)->where('invoices.state', '!=', 'empty')->paginate(10);
        return InvoicesResource::collection($invoices,200);
    }

}
