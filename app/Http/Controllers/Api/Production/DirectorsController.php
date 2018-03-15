<?php

namespace App\Http\Controllers\Api\Production;

use App\Models\Director;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\DirectorResource;

class DirectorsController extends Controller
{
    public function index()
    {
        $directors = Director::paginate();

        return DirectorResource::collection($directors);
    }

    public function show(Director $director)
    {
        return new DirectorResource($director);
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
        ]);

        $director = new Director();

        $director->firstname = $req->firstname;
        $director->lastname = $req->lastname;

        $director->save();

        return new DirectorResource($director);
    }

    public function update(Request $req, Director $director)
    {
        $this->validate($req, [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
        ]);

        $director->firstname = $req->firstname;
        $director->lastname = $req->lastname;

        $director->save();

        return new DirectorResource($director);
    }

    public function destroy(Director $director)
    {
        $director->delete();

        return response()->json(null, 204);
    }
}
