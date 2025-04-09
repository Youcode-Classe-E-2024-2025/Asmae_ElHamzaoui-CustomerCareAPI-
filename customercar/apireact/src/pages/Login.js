import React, { useState, useContext } from "react";
import { useNavigate } from "react-router-dom";
import { AuthContext } from "../context/AuthContext";
import "../styles/Login.css";

const Login = () => {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [message, setMessage] = useState("");
  const navigate = useNavigate();
  const { login } = useContext(AuthContext);

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      const user = await login({ email, password }); // Connexion et récupération de l'utilisateur
      setMessage("Connexion réussie !");

      // Vérifier si l'utilisateur a un rôle et rediriger
      if (user?.role) {
        switch (user.role) {
          case "admin":
            navigate("/dashboardAdmin");
            break;
          case "agent":
            navigate("/dashboardAgent");
            break;
          case "client":
            navigate("/dashboardClient");
            break;
          default:
            navigate("/dashboard");
        }
      } else {
        navigate("/dashboard"); // Redirection par défaut
      }
    } catch (error) {
      setMessage(`Erreur de connexion : ${error.response?.data?.message || error.message}`);
    }
  };

  return (
    <div className="login-container">
      <div className="login-box">
        <h2>Connexion</h2>

        {message && (
          <p className={`message ${message.startsWith("Connexion réussie") ? "success" : "error"}`}>
            {message}
          </p>
        )}

        <form onSubmit={handleSubmit}>
          <div className="form-group">
            <label htmlFor="email">Email :</label>
            <input
              type="email"
              id="email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              required
            />
          </div>

          <div className="form-group">
            <label htmlFor="password">Mot de passe :</label>
            <input
              type="password"
              id="password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              required
            />
          </div>

          <button type="submit" className="login-button">Se connecter</button>
        </form>
      </div>
    </div>
  );
};

export default Login;
