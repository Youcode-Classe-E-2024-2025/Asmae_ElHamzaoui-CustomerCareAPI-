<?php

namespace App\Services;

use App\Repositories\TicketRepository;

class TicketService
{
    protected $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function getAllTickets()
    {
        return $this->ticketRepository->getAllTickets();
    }

    public function createTicket($userId, array $data)
    {
        $data['user_id'] = $userId;
        return $this->ticketRepository->createTicket($data);
    }

    public function getTicketById($id)
    {
        return $this->ticketRepository->getTicketById($id);
    }

    public function updateTicket($id, array $data)
    {
        return $this->ticketRepository->updateTicket($id, $data);
    }

    public function deleteTicket($id)
    {
        return $this->ticketRepository->deleteTicket($id);
    }
}
