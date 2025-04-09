import React, { createContext, useState, useEffect } from "react";
import axios from "axios";

export const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [isLoggedIn, setIsLoggedIn] = useState(false);

  useEffect(() => {
    // Vérifie si l'utilisateur est déjà connecté (par exemple, vérification du token JWT dans le localStorage)
    const storedUser = JSON.parse(localStorage.getItem("user"));
    if (storedUser) {
      setUser(storedUser);
      setIsLoggedIn(true);
    }
  }, []);

  const login = async ({ email, password }) => {
    try {
      // Appel à l'API pour se connecter
      const response = await axios.post("http://localhost:8000/api/login", { email, password });

      // Sauvegarder le token et l'utilisateur dans le localStorage
      const userData = {
        access_token: response.data.access_token,
        role: response.data.user.role, // Récupère le rôle de l'utilisateur
      };
      localStorage.setItem("user", JSON.stringify(userData));

      setUser(userData);
      setIsLoggedIn(true);

      return userData; // Retourne l'utilisateur connecté
    } catch (error) {
      throw error; // Si une erreur se produit, elle sera capturée dans le composant Login
    }
  };

  const logout = () => {
    localStorage.removeItem("user");
    setUser(null);
    setIsLoggedIn(false);
  };

  return (
    <AuthContext.Provider value={{ user, isLoggedIn, login, logout }}>
      {children}
    </AuthContext.Provider>
  );
};
