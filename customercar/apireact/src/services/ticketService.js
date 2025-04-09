import axios from 'axios';

const API_URL = 'http://localhost:8000/api/tickets';

// Récupérer le token JWT depuis le localStorage
const getAuthHeader = () => {
    const user = JSON.parse(localStorage.getItem('user'));
    console.log("Token récupéré : ", user?.access_token); // Vérifie si le token est bien récupéré
    if (user && user.access_token) {
        return { 'Authorization': 'Bearer ' + user.access_token };
    } else {
        return {};
    }
};


const getAllTickets = async () => {
    try {
        const response = await axios.get(API_URL, { headers: getAuthHeader() });
        return response.data;
    } catch (error) {
        throw error;
    }
};

const getTicketById = async (id) => {
    try {
        const response = await axios.get(`${API_URL}/${id}`, { headers: getAuthHeader() });
        return response.data;
    } catch (error) {
        throw error;
    }
};

const createTicket = async (ticketData) => {
    try {
        const response = await axios.post(API_URL, ticketData, { headers: getAuthHeader() });
        return response.data;
    } catch (error) {
        throw error;
    }
};

const updateTicket = async (id, ticketData) => {
    try {
        const response = await axios.put(`${API_URL}/${id}`, ticketData, { headers: getAuthHeader() });
        return response.data;
    } catch (error) {
        throw error;
    }
};

const deleteTicket = async (id) => {
    try {
        const response = await axios.delete(`${API_URL}/${id}`, { headers: getAuthHeader() });
        return response.data;
    } catch (error) {
        throw error;
    }
};

const ticketService = {
    getAllTickets,
    getTicketById,
    createTicket,
    updateTicket,
    deleteTicket,
};

export default ticketService;