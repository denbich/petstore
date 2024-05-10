<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    /**
     * Display a search view of pets.
     * Or if searched, display found pet.
     */
    public function index()
    {
        if(!empty($_GET['id']) || session('petId') !== null)
        {
            $id = (session('petId') !== null) ? session('petId') : $_GET['id'];
            $url = env('PETSTORE_API_URL').'/pet/'.$id;
            $http = Http::get($url);
            $data = $http->collect();

            return view('pet.index', ['data' => $data]);
        } else {
            return view('pet.index');
        }
    }

    /**
     * Store a newly created pet using API.
     */
    public function store(PetRequest $request)
    {
        $data = $request->validated();
        $url = env('PETSTORE_API_URL').'/pet';

        foreach(explode('|', $data['tags']) as $tag)
        {
            $tags[] = ['name' => $tag];
        }

        $fileName = time().(str($request->file('image')->getClientOriginalName())->squish());
        $imagePath = Storage::putFileAs(
            'pets', $data['image'], $fileName
        );

        $http = Http::post($url, [
            'name' => $data['name'],
            'category' => [
                'name' => $data['category'],
            ],
            'tags' => $tags,
            'photoUrls' => [url($imagePath)],
            'status' => $data['status'],
        ]);

        $res = $http->collect();

        if($http->ok())
        {
            return redirect()->route('pet.index', 'id='.$res['id'])
            ->with([
                'created_pet' => true,
                'petId' => $res['id']
            ]);

        } else {
            return back()->with(['error_creating_pet' => true]);
        }
    }

    /**
     * Display an edit form of a pet
     */
    public function edit(string $id)
    {
        $url = env('PETSTORE_API_URL').'/pet/'.$id;
        $http = Http::get($url);
        if($http->ok())
        {
            $data = $http->collect();
            $tags = collect($data['tags'])->map(function ($tags) {
                return collect($tags)->only(['name']);
              })->flatten()->implode('|');

            return view('pet.edit', ['data' => $data, 'tags' => $tags]);
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified pet using API.
     */
    public function update(PetRequest $request, string $id)
    {
        $data = $request->validated();
        $url = env('PETSTORE_API_URL').'/pet';

        $http = Http::get(env('PETSTORE_API_URL').'/pet/'.$id);

        if($http->ok())
        {
            $old = $http->collect();
            foreach(explode('|', $data['tags']) as $tag)
            {
                $tags[] = ['name' => $tag];
            }

            if(empty($data['image']))
            {
                $imagePath = $old['photoUrls'][0];
            } else {
                Storage::delete(str_replace(url(), '', $old['photoUrls'][0]));
                $fileName = time().(str($request->file('image')->getClientOriginalName())->squish());
                $imagePath = Storage::putFileAs(
                    'pets', $data['image'], $fileName
                );
            }

            $http = Http::put($url, [
                'id' => $id,
                'name' => $data['name'],
                'category' => [
                    'name' => $data['category'],
                ],
                'tags' => $tags,
                'photoUrls' => [url($imagePath)],
                'status' => $data['status'],
            ]);

            return redirect()->route('pet.edit', $id)->with(['edited_pet' => true]);
        } else {
            abort(404);
        }
    }

    /**
     * Remove the specified pet using API.
     */
    public function destroy(string $id)
    {
        $url = env('PETSTORE_API_URL').'/pet/'.$id;
        $http = Http::delete($url);

        if($http->ok())
        {
            return redirect()->route('pet.index')->with(['deleted_pet' => true]);
        } else {
            return back()->with(['error_deleting_pet' => true]);
        }
    }
}
