<?php
namespace App\Services;

use App\Repositories\InteractionRepository;
use Illuminate\Support\Facades\Auth;

class InteractionService
{
    protected $interactionRepository;

    public function __construct(InteractionRepository $interactionRepository)
    {
        $this->interactionRepository = $interactionRepository;
    }

    public function getAllInteractions($ticketId)
    {
        return $this->interactionRepository->getAllByTicket($ticketId);
    }

    public function createInteraction($ticketId, $message)
    {
        return $this->interactionRepository->create($ticketId, Auth::id(), $message);
    }

    public function getInteractionById($id)
    {
        return $this->interactionRepository->findById($id);
    }

    public function updateInteraction($id, $message)
    {
        return $this->interactionRepository->update($id, $message);
    }

    public function deleteInteraction($id)
    {
        return $this->interactionRepository->delete($id);
    }
}
