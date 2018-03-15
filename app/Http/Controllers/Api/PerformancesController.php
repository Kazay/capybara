<?php

namespace App\Http\Controllers\Api;

use App\Models\Performance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PerformanceResource;

class PerformancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PerformanceResource::collection(Performance::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'date|required',
            'play' => 'required|numeric|exists:plays,id',
        ]);

        $performance = new Performance();

        $performance->date = $request->date;
        $performance->play()->associate($request->play);

        $performance->save();

        return new PerformanceResource($performance);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Performance  $performance
     * @return \Illuminate\Http\Response
     */
    public function show(Performance $performance)
    {
        return new PerformanceResource($performance);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Performance  $performance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Performance $performance)
    {
        $this->validate($request, [
            'date' => 'date|required',
            'play' => 'required|numeric|exists:plays,id',
        ]);

        $performance->date = $request->date;
        $performance->play()->associate($request->play);

        $performance->save();

        return new PerformanceResource($performance);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Performance  $performance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Performance $performance)
    {
        $performance->delete();

        return response()->json(null, 204);
    }
}
