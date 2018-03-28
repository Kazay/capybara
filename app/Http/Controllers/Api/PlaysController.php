<?php

namespace App\Http\Controllers\Api;

use App\Models\Play;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlayResource;

class PlaysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PlayResource::collection(Play::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $this->validate($req, [
            'name' => 'required|string|max:512|unique:plays',
            'troupe' => 'required|numeric|exists:troupes,id',
            'director' => 'required|numeric|exists:directors,id',
            'author' => 'required|string|max:255',
        ]);

        $play = new Play();

        $play->name = $req->name;
        $play->author = $req->author;

        $play->troupe()->associate($req->troupe);
        $play->director()->associate($req->director);

        $play->save();

        return new PlayResource($play);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Play  $play
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Play $play)
    {
        $showDates = "current";
        if ($request->has('dates') && $request->dates == "all")
            $showDates = "all";

        return new PlayResource($play, $showDates);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Play  $play
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, Play $play)
    {
        $this->validate($req, [
            'name' => 'required|string|max:512|unique:plays',
            'troupe' => 'required|numeric|exists:troupes,id',
            'director' => 'required|numeric|exists:directors,id',
            'author' => 'required|string|max:255',
        ]);

        $play->name = $req->name;
        $play->author = $req->author;

        $play->troupe()->associate($req->troupe);
        $play->director()->associate($req->director);

        $play->save();

        return new PlayResource($play);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Play  $play
     * @return \Illuminate\Http\Response
     */
    public function destroy(Play $play)
    {
        $play->delete();

        return response()->json(null, 204);
    }
}
