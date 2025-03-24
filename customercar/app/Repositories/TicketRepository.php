<?php

namespace App\Repositories;

use App\Models\Ticket;

class TicketRepository
{
    public function getAllTickets()
    {
        return Ticket::with(['user', 'agent'])->get();
    }

    public function createTicket(array $data)
    {
        return Ticket::create($data);
    }

    public function getTicketById($id)
    {
        return Ticket::findOrFail($id);
    }

    public function updateTicket($id, array $data)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->update($data);
        return $ticket;
    }

    public function deleteTicket($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();
        return ['message' => 'Ticket supprimé'];
    }
}
