<?php

namespace App\Repositories;

use App\Models\Interaction;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class InteractionRepository
{
    public function getAllByTicket($ticketId)
    {
        return Interaction::where('ticket_id', $ticketId)->with('user')->get();
    }

    public function create($ticketId, $userId, $message)
    {
        return Interaction::create([
            'ticket_id' => $ticketId,
            'user_id' => $userId,
            'message' => $message,
        ]);
    }

    public function findById($id)
    {
        return Interaction::with('user')->findOrFail($id);
    }

    public function update($id, $message)
    {
        $interaction = Interaction::findOrFail($id);
        $interaction->update(['message' => $message]);
        return $interaction;
    }

    public function delete($id)
    {
        $interaction = Interaction::findOrFail($id);
        return $interaction->delete();
    }
}