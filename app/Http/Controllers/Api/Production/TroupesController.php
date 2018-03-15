<?php

namespace App\Http\Controllers\Api\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Troupe;
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

    public function store(Request $req)
    {
        $troupe = new Troupe();

        $troupe->name = $req->name;

        $troupe->save();

        return new TroupeResource($troupe);
    }

    public function update(Request $req, Troupe $troupe)
    {
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
