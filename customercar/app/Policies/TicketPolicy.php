<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    /**
     * Determine if the given user can update the ticket.
     */
    public function update(User $user, Ticket $ticket): bool
    {
        // Autoriser uniquement le propriétaire du ticket ou un admin
        return $user->id === $ticket->user_id || $user->is_admin;
    }

    /**
     * Determine if the given user can delete the ticket.
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id || $user->is_admin;
    }
}

