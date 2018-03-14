<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Holds common function for a RESTful api.
 */
class ApiController extends Controller
{
    /**
     * Make a 404 default response
     *
     * @param string $message
     * @return void
     */
    protected function notFoundResponse($message = 'Query response is empty.')
    {
        return response()->json([ 'error' => $message, 'code' => '404'], 404);
    }

    /**
     * Make a 403 default response
     *
     * @param string $message Optional Message
     * @return void
     */
    protected function unauthorizedResponse($message = 'Forbidden.')
    {
        return response()->json([ 'error' => $message, 'code' => '403'], 403);
    }
}