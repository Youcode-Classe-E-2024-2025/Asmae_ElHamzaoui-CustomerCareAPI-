import React, { useState, useEffect } from 'react';
import ticketService from '../services/ticketService';

const TicketList = () => {
  const [tickets, setTickets] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    const fetchTickets = async () => {
      setLoading(true);
      try {
        const data = await ticketService.getAllTickets();
        setTickets(data);
      } catch (error) {
        setError(`Erreur lors de la récupération des tickets : ${error.message}`);
      } finally {
        setLoading(false);
      }
    };

    fetchTickets();
  }, []);

  if (loading) {
    return <p>Chargement des tickets...</p>;
  }

  if (error) {
    return <p>Erreur : {error}</p>;
  }

  return (
    <div>
      <h2>Liste des Tickets</h2>
      <ul>
        {tickets.map((ticket) => (
          <li key={ticket.id}>
            {ticket.title} - {ticket.description}
          </li>
        ))}
      </ul>
    </div>
  );
};

export default TicketList;