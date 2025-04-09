import React, { useState } from 'react';
import ticketService from '../services/ticketService';
import { useNavigate } from 'react-router-dom';

const CreateTicket = () => {
  const [title, setTitle] = useState('');
  const [description, setDescription] = useState('');
  const [message, setMessage] = useState('');
  const navigate = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      await ticketService.createTicket({ title, description });
      setMessage('Ticket créé avec succès !');
      navigate('/tickets'); // Redirect to the ticket list after creation
    } catch (error) {
      setMessage(`Erreur lors de la création du ticket : ${error.message}`);
    }
  };

  return (
    <div>
      <h2>Créer un Ticket</h2>
      {message && <p>{message}</p>}
      <form onSubmit={handleSubmit}>
        <div>
          <label htmlFor="title">Titre :</label>
          <input type="text" id="title" value={title} onChange={(e) => setTitle(e.target.value)} />
        </div>
        <div>
          <label htmlFor="description">Description :</label>
          <textarea id="description" value={description} onChange={(e) => setDescription(e.target.value)} />
        </div>
        <button type="submit">Créer</button>
      </form>
    </div>
  );
};

export default CreateTicket;