<?php

namespace App\Http\Controllers\Api\Production;

use App\Models\Play;
use App\Models\Troupe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlayResource;
use App\Http\Resources\TroupeResource;


class TroupesController extends Controller
{
    public function index()
    {
        $troupes = Troupe::paginate();

        return TroupeResource::collection($troupes);
    }

    public function show(Troupe $troupe)
    {
        return new TroupeResource($troupe);
    }

    public function showPlays($troupe)
    {
        $plays = Play::where('troupe_id', '=', $troupe)->paginate();

        return PlayResource::collection($plays);
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            "name" => "required|string|max:255"
        ]);

        $troupe = new Troupe();

        $troupe->name = $req->name;

        $troupe->save();

        return new TroupeResource($troupe);
    }

    protected function storeMany(Request $req)
    {

    }

    public function update(Request $req, Troupe $troupe)
    {
        $this->validate($req, [
            "name" => "required|string|max:255"
        ]);

        $troupe->name = $req->name;

        $troupe->save();

        return new TroupeResource($troupe);
    }

    public function destroy(Troupe $troupe)
    {
        $troupe->delete();

        return response()->json(null, 204);
    }
}
