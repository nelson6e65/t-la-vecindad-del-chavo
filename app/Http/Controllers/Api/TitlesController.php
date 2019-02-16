<?php

namespace App\Http\Controllers\Api;

use App\Entities\Title;
use App\Http\Controllers\Controller;

class TitlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titles = Title::paginate(100, ['*'], 'page', 1);

        return response()->json($titles);
    }


    /**
     * Display the specified resource.
     *
     * @param Title $title
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Title $title)
    {
        return response()->json($title);
    }
}
