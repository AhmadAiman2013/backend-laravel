<?php

namespace App\Http\Controllers;

use App\Http\Resources\BoardsResource;
use App\Models\Boards;
use Illuminate\Http\Request;

class BoardsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boards = Boards::latest()->get();

        return BoardsResource::collection($boards);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $board = Boards::create([
            ...$request->validate([
                'title' => 'required|string|max:50',
            ]),
            'user_id' => $request->user()->id,
        ]);

        return new BoardsResource($board);
    }

    /**
     * Display the specified resource.
     */
    public function show(Boards $board)
    {
        return new BoardsResource($board);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Boards $board)
    {
        $board->update(
            $request->validate([
                'title' => 'required|string|max:50',
            ])
            );

        return new BoardsResource($board);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Boards $board)
    {
        $board->delete();

        return response(status: 204);
    }
}