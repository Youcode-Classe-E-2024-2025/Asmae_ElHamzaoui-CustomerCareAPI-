import axios from 'axios';

const API_URL = 'http://localhost:8000/api'; // Remplace par l'URL de ton API Laravel

// Récupère le token de l'utilisateur connecté
const authHeader = () => {
  const user = JSON.parse(localStorage.getItem('user'));
  return user && user.access_token ? { Authorization: `Bearer ${user.access_token}` } : {};
};

// Inscription
const register = async (userData) => {
  try {
    const response = await axios.post(`${API_URL}/register`, userData);
    return response.data;
  } catch (error) {
    throw error;
  }
};

// Connexion
const login = async (userData) => {
  try {
    const response = await axios.post(`${API_URL}/login`, userData);
    if (response.data.access_token) {
      localStorage.setItem('user', JSON.stringify(response.data)); // Stocke les infos utilisateur
    }
    return response.data;
  } catch (error) {
    throw error;
  }
};

// Déconnexion
const logout = async () => {
  try {
    await axios.post(`${API_URL}/logout`, {}, { headers: authHeader() });
    localStorage.removeItem('user');
  } catch (error) {
    console.error('Erreur lors de la déconnexion:', error);
  }
};

// Récupérer l'utilisateur actuel
const getCurrentUser = () => {
  return JSON.parse(localStorage.getItem('user'));
};

// Récupérer tous les tickets
const getTickets = async () => {
  try {
    const response = await axios.get(`${API_URL}/tickets`, { headers: authHeader() });
    return response.data;
  } catch (error) {
    throw error;
  }
};

// Créer un ticket
const createTicket = async (ticketData) => {
  try {
    const response = await axios.post(`${API_URL}/tickets`, ticketData, { headers: authHeader() });
    return response.data;
  } catch (error) {
    throw error;
  }
};

// Supprimer un ticket
const deleteTicket = async (ticketId) => {
  try {
    await axios.delete(`${API_URL}/tickets/${ticketId}`, { headers: authHeader() });
  } catch (error) {
    throw error;
  }
};

const authService = {
  register,
  login,
  logout,
  getCurrentUser,
  getTickets,
  createTicket,
  deleteTicket,
};

export default authService;
