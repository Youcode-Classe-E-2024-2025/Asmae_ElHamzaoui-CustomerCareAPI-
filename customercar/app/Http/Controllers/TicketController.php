<?php

namespace App\Http\Controllers;

use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Tickets",
 *     description="API Endpoints for ticket management"
 * )
 */
class TicketController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * @OA\Get(
     *     path="/tickets",
     *     tags={"Tickets"},
     *     summary="Get all tickets",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="List of all tickets")
     * )
     */
    public function index()
    {
        return response()->json($this->ticketService->getAllTickets());
    }

    /**
     * @OA\Post(
     *     path="/tickets",
     *     tags={"Tickets"},
     *     summary="Create a new ticket",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "description"},
     *             @OA\Property(property="title", type="string", example="Technical Issue"),
     *             @OA\Property(property="description", type="string", example="The system is down.")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Ticket successfully created")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        return response()->json($this->ticketService->createTicket(Auth::id(), $data), 201);
    }

    /**
     * @OA\Get(
     *     path="/tickets/{ticket}",
     *     tags={"Tickets"},
     *     summary="Get a specific ticket",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="ticket",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Ticket details")
     * )
     */
    public function show($id)
    {
        return response()->json($this->ticketService->getTicketById($id));
    }

    /**
 * @OA\Put(
 *     path="/tickets/{ticket}",
 *     tags={"Tickets"},
 *     summary="Update a specific ticket",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="ticket",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"title", "description"},
 *             @OA\Property(property="title", type="string", example="Updated Issue Title"),
 *             @OA\Property(property="description", type="string", example="Updated description"),
 *             @OA\Property(property="status", type="string", example="resolved"),
 *             @OA\Property(property="agent_id", type="integer", example=2)
 *         )
 *     ),
 *     @OA\Response(response=200, description="Ticket successfully updated")
 * )
 */
    public function update(Request $request, $id)
    {
        $data = $request->only(['title', 'description', 'status', 'agent_id']);
        return response()->json($this->ticketService->updateTicket($id, $data));
    }

    /**
     * @OA\Delete(
     *     path="/tickets/{ticket}",
     *     tags={"Tickets"},
     *     summary="Delete a specific ticket",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="ticket",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Ticket successfully deleted")
     * )
     */
    public function destroy($id)
    {
        return response()->json($this->ticketService->deleteTicket($id));
    }
}
