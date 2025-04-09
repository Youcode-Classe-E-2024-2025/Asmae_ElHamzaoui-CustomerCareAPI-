// src/api.js
import axios from 'axios';

const API_URL = 'http://127.0.0.1:8000/api';  // Remplace par l'URL de ton API

export const getTickets = async () => {
    try {
        const response = await axios.get(`${API_URL}/tickets`, {
            headers: {
                Authorization: `Bearer YOUR_TOKEN_HERE`, // Remplace par ton token d'authentification
            }
        });
        return response.data;
    } catch (error) {
        console.error("Error fetching tickets", error);
        throw error;
    }
};

export const createTicket = async (ticketData) => {
    try {
        const response = await axios.post(`${API_URL}/tickets`, ticketData, {
            headers: {
                Authorization: `Bearer YOUR_TOKEN_HERE`, // Remplace par ton token d'authentification
            }
        });
        return response.data;
    } catch (error) {
        console.error("Error creating ticket", error);
        throw error;
    }
};
