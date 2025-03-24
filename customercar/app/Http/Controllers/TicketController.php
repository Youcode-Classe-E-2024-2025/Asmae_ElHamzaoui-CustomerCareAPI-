<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Tickets",
 *     description="API Endpoints for ticket management"
 * )
 */
class TicketController extends Controller
{
    /**
 * @OA\Get(
 *     path="/tickets",
 *     tags={"Tickets"},
 *     summary="Get all tickets",
 *     security={{"bearerAuth":{}}}, 
 *     @OA\Response(
 *         response=200,
 *         description="List of all tickets",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Ticket")
 *         )
 *     )
 * )
 */

    public function index()
    {
        return response()->json(Ticket::with(['user', 'agent'])->get());
    }

    /**
     * @OA\Post(
     *     path="/tickets",
     *     tags={"Tickets"},
     *     summary="Create a new ticket",
     *     security={{"bearerAuth":{}}}, 
     *     description="Create a new ticket for the authenticated user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "description"},
     *             @OA\Property(property="title", type="string", example="Technical Issue"),
     *             @OA\Property(property="description", type="string", example="The system is down.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Ticket successfully created",
     *         @OA\JsonContent(ref="#/components/schemas/Ticket")
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
     * @OA\Get(
     *     path="/tickets/{ticket}",
     *     tags={"Tickets"},
     *     summary="Get a specific ticket",
     *      security={{"bearerAuth":{}}}, 
     *     description="Fetch a specific ticket by its ID",
     *     @OA\Parameter(
     *         name="ticket",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ticket details",
     *         @OA\JsonContent(ref="#/components/schemas/Ticket")
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
    public function show(Ticket $ticket)
    {
        return response()->json($ticket);
    }

    /**
     * @OA\Put(
     *     path="/tickets/{ticket}",
     *     tags={"Tickets"},
     *     summary="Update a specific ticket",
     *     security={{"bearerAuth":{}}}, 
     *     description="Update an existing ticket's details",
     *     @OA\Parameter(
     *         name="ticket",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Updated Issue Title"),
     *             @OA\Property(property="description", type="string", example="Updated description"),
     *             @OA\Property(property="status", type="string", example="resolved")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ticket successfully updated",
     *         @OA\JsonContent(ref="#/components/schemas/Ticket")
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
    public function update(Request $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);
        $ticket->update($request->only('title', 'description', 'status', 'agent_id'));
        return response()->json($ticket);
    }

    /**
     * @OA\Delete(
     *     path="/tickets/{ticket}",
     *     tags={"Tickets"},
     *     summary="Delete a specific ticket", 
     *     security={{"bearerAuth":{}}}, 
     *     description="Delete a specific ticket by its ID",
     *     @OA\Parameter(
     *         name="ticket",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ticket successfully deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Ticket supprimé")
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
    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);
        $ticket->delete();
        return response()->json(['message' => 'Ticket supprimé']);
    }
}
