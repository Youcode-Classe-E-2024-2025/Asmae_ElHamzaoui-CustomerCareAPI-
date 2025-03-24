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
     *     summary="Get all tickets with filtering and pagination",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filter by ticket status",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="Filter by user ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="agent_id",
     *         in="query",
     *         description="Filter by agent ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of tickets per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of tickets with pagination",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Ticket")),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Ticket::with(['user', 'agent']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('agent_id')) {
            $query->where('agent_id', $request->agent_id);
        }

        $tickets = $query->paginate($request->get('per_page', 10));

        return response()->json($tickets);
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
