import axios from 'axios';

const API_URL = 'http://localhost:8000/api/tickets';

const getAuthHeader = () => {
    const user = JSON.parse(localStorage.getItem('user'));
    if (user && user.access_token) {
        return { 'Authorization': 'Bearer ' + user.access_token };
    } else {
        return {};
    }
};

const getAllInteractions = async (ticketId) => {
  try {
    const response = await axios.get(`${API_URL}/${ticketId}/interactions`,{ headers: getAuthHeader() });
    return response.data;
  } catch (error) {
    throw error;
  }
};

const createInteraction = async (ticketId, interactionData) => {
  try {
    const response = await axios.post(`${API_URL}/${ticketId}/interactions`, interactionData, { headers: getAuthHeader() });
    return response.data;
  } catch (error) {
    throw error;
  }
};

const getInteractionById = async (interactionId) => {
  try {
    const response = await axios.get(`/interactions/${interactionId}`, { headers: getAuthHeader() });
    return response.data;
  } catch (error) {
    throw error;
  }
};

const updateInteraction = async (interactionId, interactionData) => {
  try {
    const response = await axios.put(`/interactions/${interactionId}`, interactionData, { headers: getAuthHeader() });
    return response.data;
  } catch (error) {
    throw error;
  }
};

const deleteInteraction = async (interactionId) => {
  try {
    const response = await axios.delete(`/interactions/${interactionId}`, { headers: getAuthHeader() });
    return response.data;
  } catch (error) {
    throw error;
  }
};

const interactionService = {
  getAllInteractions,
  createInteraction,
  getInteractionById,
  updateInteraction,
  deleteInteraction,
};

export default interactionService;