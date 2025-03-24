<?php

namespace App\Http\Controllers;

use App\Services\InteractionService;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Interaction;

/**
 * @OA\Tag(
 *     name="Interactions",
 *     description="API for managing ticket interactions"
 * )
 */
class InteractionController extends Controller
{
    protected $interactionService;

    public function __construct(InteractionService $interactionService)
    {
        $this->interactionService = $interactionService;
    }

    /**
     * @OA\Get(
     *     path="/tickets/{ticket}/interactions",
     *     tags={"Interactions"},
     *     summary="Get all interactions for a specific ticket",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="ticket", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="List of interactions", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Interaction")))
     * )
     */
    public function index(Ticket $ticket)
    {
        return response()->json($this->interactionService->getAllInteractions($ticket->id));
    }

    /**
     * @OA\Post(
     *     path="/tickets/{ticket}/interactions",
     *     tags={"Interactions"},
     *     summary="Create a new interaction",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="ticket", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true, @OA\JsonContent(@OA\Property(property="message", type="string"))),
     *     @OA\Response(response=201, description="Interaction created", @OA\JsonContent(ref="#/components/schemas/Interaction"))
     * )
     */
    public function store(Request $request, Ticket $ticket)
    {
        $request->validate(['message' => 'required']);
        return response()->json($this->interactionService->createInteraction($ticket->id, $request->message), 201);
    }

    /**
     * @OA\Get(
     *     path="/interactions/{interaction}",
     *     tags={"Interactions"},
     *     summary="Get a specific interaction",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="interaction", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Interaction details", @OA\JsonContent(ref="#/components/schemas/Interaction"))
     * )
     */
    public function show(Interaction $interaction)
    {
        return response()->json($this->interactionService->getInteractionById($interaction->id));
    }

    /**
     * @OA\Put(
     *     path="/interactions/{interaction}",
     *     tags={"Interactions"},
     *     summary="Update a specific interaction",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="interaction", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true, @OA\JsonContent(@OA\Property(property="message", type="string"))),
     *     @OA\Response(response=200, description="Interaction updated", @OA\JsonContent(ref="#/components/schemas/Interaction"))
     * )
     */
    public function update(Request $request, Interaction $interaction)
    {
        $request->validate(['message' => 'required']);
        return response()->json($this->interactionService->updateInteraction($interaction->id, $request->message));
    }

    /**
     * @OA\Delete(
     *     path="/interactions/{interaction}",
     *     tags={"Interactions"},
     *     summary="Delete a specific interaction",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="interaction", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Interaction deleted", @OA\JsonContent(@OA\Property(property="message", type="string", example="Interaction supprimée")))
     * )
     */
    public function destroy(Interaction $interaction)
    {
        $this->interactionService->deleteInteraction($interaction->id);
        return response()->json(['message' => 'Interaction supprimée']);
    }
}
