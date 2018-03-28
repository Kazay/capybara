<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Performance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\PerformanceResource;
use App\Http\Resources\PerformanceCollection;

class PerformancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new PerformanceCollection(Performance::paginate());
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

    /**
     * Attach a user to the specified performance. 
     * Request body can contain a user field to attach another
     * user than self.
     *
     * @param Illuminate\Http\Request $request
     * @param App\Models\Performance $performance
     * @return Illuminate\Http\Response
     */
    public function subscribe(Request $request, Performance $performance)
    {
        // set user to current user or anyone else if specified in request body
        $user = $this->setUserFromRequest($request);

        $performance->ticketing()->attach($user->id);

        return response()->json($performance->ticketing);
    }

    /**
     * Detach a user fro the specified performance.
     * Request body can contain a user field to detach another
     * user than self.
     * 
     * Checks if user owns the relationship
     * Only admin can unsubscribe another user.
     *
     * @param Illuminate\Http\Request $request
     * @param App\Models\Performance $performance
     * @return Illuminate\Http\Response
     */
    public function unsubscribe(Request $request, Performance $performance)
    {
        // set user to current user or anyone else if specified in request body
        $user = $this->setUserFromRequest($request);

        // check if the relashionship exists
        $exists = DB::table('performance_user')
            ->whereUserId($request->user()->id)
            ->wherePerformanceId($performance->id)
            ->count() > 0;

        if ($exists)
        {
            //          +--------------+
            //      no  | Relationship |
            //     +----+    exists    |
            //     |    +--------------+
            //     |           |yes
            //     |    +------v--------+    +------------+
            //     |    |Date has passed+---->  Owns the  |
            //     |    +---------------+ no |relationship|
            //     |          |yes           +------------+
            //     |    +-----v--+            no|   |yes
            //     |    |Is Admin<--------------+   |
            //     |    +--------+                  |
            //     |   no |     |yes                |
            //  +--v--+   |     |   +------+        |
            //  |Don't<---+     +--->Delete<--------+
            //  +-----+             +------+
            
            // Set the conditions before the test chart.
            $hasElapsed = ($performance->date < strToTime('now'));
            $isOwner = $request->user()->id == $user->id;
            $isAdmin = User::hasRole($request->user(), 'admin');
            
            if ($hasElapsed && ! $isAdmin)
                return response()->json(['message' => 'You can\'t unsubscribe an elapsed event'], 403);

            if (! $isOwner && ! $isAdmin)
                return response()->json(['message' => 'You can\'t unsubscribe someone else'], 403);

            $performance->ticketing()->detach($user->id);
            return response()->json(null, 204);
        }
        else
        {
            return response()->json(['message' => 'Relationship not found'], 404);
        }
    }

    /**
     * Return the user making the request or another one if specified in request body
     *
     * @param Request $request
     * @return User
     */
    private function setUserFromRequest($request)
    {
        $user = $request->user();

        if ($request->has('user'))
        {
            try 
            {
                $user = User::findOrFail($request->user);
            }
            catch(\Exception $e)
            {
                abort(404, 'User not found');
            }
        }

        return $user;
    }
}
