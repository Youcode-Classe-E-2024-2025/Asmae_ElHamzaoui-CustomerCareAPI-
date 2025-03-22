<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
/**
 * @OA\Tag(
 *     name="Tickets",
 *     description="Operations related to support tickets"
 * )
 */
class TicketController extends Controller
{


     /**
     * List all tickets.
     *
     * @OA\Get(
     *     path="/api/tickets",
     *     summary="List all tickets",
     *     tags={"Tickets"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Ticket")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Ticket::with(['user', 'agent'])->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required', 
            'description' => 'required'
        ]);
        $ticket = Ticket::create([ 
            'user_id' => Auth::id(), 
            'title' => $request->title, 
            'description' => $request->description 
        ]);

        return response()->json($ticket, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return response()->json($ticket);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);
        $ticket->update($request->only('title', 'description', 'status', 'agent_id'));
        return response()->json($ticket);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);
        $ticket->delete();
        return response()->json(['message' => 'Ticket supprimé']);
    }
}
