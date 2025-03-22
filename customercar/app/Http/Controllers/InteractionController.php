<?php

namespace App\Http\Controllers;

use App\Models\Interaction;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Interactions",
 *     description="Operations related to ticket interactions"
 * )
 */

class InteractionController extends Controller
{

    /**
     * List all interactions for a ticket.
     *
     * @OA\Get(
     *     path="/api/tickets/{ticket_id}/interactions",
     *     summary="List interactions for a ticket",
     *     tags={"Interactions"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="ticket_id",
     *         in="path",
     *         description="ID of the ticket",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Interaction")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ticket not found"
     *     )
     * )
     */

    /**
     * Display a listing of the resource.
     */
    public function index(Ticket $ticket)
    {
        return response()->json($ticket->interactions()->with('user')->get());
    }


    /**
     * Create a new interaction for a ticket.
     *
     * @OA\Post(
     *     path="/api/tickets/{ticket_id}/interactions",
     *     summary="Create a new interaction",
     *     tags={"Interactions"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="ticket_id",
     *         in="path",
     *         description="ID of the ticket",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"message"},
     *             @OA\Property(property="message", type="string", example="This is a new interaction message.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Interaction created",
     *         @OA\JsonContent(ref="#/components/schemas/Interaction")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ticket not found"
     *     )
     * )
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Ticket $ticket)
    {
        $request->validate(['message' => 'required']);
        $interaction = $ticket->interactions()->create([
            'user_id' => Auth::id(),
            'message' => $request->message
        ]);
        return response()->json($interaction, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Interaction $interaction)
    {
        return response()->json($interaction->load('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Interaction $interaction)
    {
        $this->authorize('update', $interaction);
        $request->validate(['message' => 'required']);
        $interaction->update($request->only('message'));
        return response()->json($interaction);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Interaction $interaction)
    {
        $this->authorize('delete', $interaction);
        $interaction->delete();
        return response()->json(['message' => 'Interaction supprimée']);
    }
}
