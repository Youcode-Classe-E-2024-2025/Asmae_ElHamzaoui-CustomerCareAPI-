<?php

namespace App\Http\Controllers;

use App\Models\Interaction;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Interactions",
 *     description="API Endpoints for interaction management"
 * )
 */
class InteractionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/tickets/{ticket}/interactions",
     *     tags={"Interactions"},
     *     summary="Get all interactions for a specific ticket",
     *     security={{"bearerAuth":{}}}, 
     *     description="Fetch all interactions related to a specific ticket, including user information",
     *     @OA\Parameter(
     *         name="ticket",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of interactions for the ticket",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Interaction")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ticket not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Ticket not found")
     *         )
     *     )
     * )
     */
    public function index(Ticket $ticket)
    {
        return response()->json($ticket->interactions()->with('user')->get());
    }

    /**
     * @OA\Post(
     *     path="/tickets/{ticket}/interactions",
     *     tags={"Interactions"},
     *     summary="Create a new interaction for a ticket",
     *     security={{"bearerAuth":{}}}, 
     *     description="Add a new interaction to a specific ticket by the authenticated user",
     *     @OA\Parameter(
     *         name="ticket",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"message"},
     *             @OA\Property(property="message", type="string", example="The issue has been addressed.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Interaction successfully created",
     *         @OA\JsonContent(ref="#/components/schemas/Interaction")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid.")
     *         )
     *     )
     * )
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
     * @OA\Get(
     *     path="/interactions/{interaction}",
     *     tags={"Interactions"},
     *     summary="Get a specific interaction",
     *     security={{"bearerAuth":{}}}, 
     *     description="Fetch a specific interaction by its ID, including the associated user information",
     *     @OA\Parameter(
     *         name="interaction",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Interaction details",
     *         @OA\JsonContent(ref="#/components/schemas/Interaction")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Interaction not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Interaction not found")
     *         )
     *     )
     * )
     */
    public function show(Interaction $interaction)
    {
        return response()->json($interaction->load('user'));
    }

    /**
     * @OA\Put(
     *     path="/interactions/{interaction}",
     *     tags={"Interactions"},
     *     summary="Update a specific interaction",
     *     security={{"bearerAuth":{}}}, 
     *     description="Update an existing interaction's message",
     *     @OA\Parameter(
     *         name="interaction",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"message"},
     *             @OA\Property(property="message", type="string", example="Updated message content.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Interaction successfully updated",
     *         @OA\JsonContent(ref="#/components/schemas/Interaction")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Interaction not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Interaction not found")
     *         )
     *     )
     * )
     */
    public function update(Request $request, Interaction $interaction)
    {
        $this->authorize('update', $interaction);
        $request->validate(['message' => 'required']);
        $interaction->update($request->only('message'));
        return response()->json($interaction);
    }

    /**
     * @OA\Delete(
     *     path="/interactions/{interaction}",
     *     tags={"Interactions"},
     *     summary="Delete a specific interaction",
     *     security={{"bearerAuth":{}}}, 
     *     description="Delete a specific interaction by its ID",
     *     @OA\Parameter(
     *         name="interaction",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Interaction successfully deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Interaction supprimée")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Interaction not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Interaction not found")
     *         )
     *     )
     * )
     */
    public function destroy(Interaction $interaction)
    {
        $this->authorize('delete', $interaction);
        $interaction->delete();
        return response()->json(['message' => 'Interaction supprimée']);
    }
}
