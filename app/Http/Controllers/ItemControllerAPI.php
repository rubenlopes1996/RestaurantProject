<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ItemsResource;
use App\Items;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;

class ItemControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return ItemsResource::collection(Items::paginate(9));
        } else {
            return ItemsResource::collection(Items::all());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'type' => 'required',
            'price' => 'required|numeric|between:0.01,1000000.00',
            'photo' => 'required'
        ]);

        $item = new Items();

        $file = Input::file('photo');
        $filename = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $uploadedFile = str_random(10) . '.' . $ext;
        Storage::disk('public')->put('items/' . $uploadedFile, File::get($file));

        $item->photo_url = $uploadedFile;
        $item->name = $data['name'];
        $item->description = $data['description'];
        $item->type = $data['type'];
        $item->price = $data['price'];
        $item->save();
        return new ItemsResource($item);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required',
            'type' => 'required',
            'price' => 'required'
        ]);

        $item = Items::findOrFail($id);

        $item->name = $data['name'];
        $item->description = $data['description'];
        $item->type = $data['type'];
        $item->price = $data['price'];

        $item->save();

        return new ItemsResource($item);
    }

    public function uploadPhoto(Request $request, $id)
    {
        $item = Items::find($id);

        if ($item->photo_url) {
            Storage::disk('public')->delete('items/' . $item->photo_url);
        }

        $file = Input::file('file');
        $filename = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $uploadedFile = str_random(10) . '.' . $ext;

        if (!Storage::disk('public')->put('items/' . $uploadedFile, File::get($file))) {
            return response()->json([
                'message' => 'Problem uploading item photo.',
                'status' => 422
            ], 422);
        }
        $item->photo_url = $uploadedFile;
        $item->save();

        return response()->json(
            [
                'status' => 201,
                'success' => 'item photo updated.',
                'photo' => $uploadedFile
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Items::findOrFail($id);
        $item = $item->delete();
        return response()->json(null, 204);
    }
}
