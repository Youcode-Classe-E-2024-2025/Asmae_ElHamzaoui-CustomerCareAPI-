import React, { useState } from "react";
import authService from "../services/authService";
import "../styles/Register.css"; // Import du fichier CSS

const Register = () => {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [passwordConfirmation, setPasswordConfirmation] = useState("");
  const [role, setRole] = useState("client"); // Valeur par défaut
  const [message, setMessage] = useState("");

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      const data = {
        name,
        email,
        password,
        password_confirmation: passwordConfirmation,
        role,
      };

      await authService.register(data);
      setMessage("✅ Inscription réussie !");
    } catch (error) {
      setMessage(`❌ Erreur lors de l'inscription : ${error.message}`);
    }
  };

  return (
    <div className="register-container">
      <div className="register-box">
        <h2>Inscription</h2>

        {message && (
          <p className={`message ${message.startsWith("✅") ? "success" : "error"}`}>
            {message}
          </p>
        )}

        <form onSubmit={handleSubmit}>
          <div className="form-group">
            <label htmlFor="name">Nom :</label>
            <input
              type="text"
              id="name"
              value={name}
              onChange={(e) => setName(e.target.value)}
              required
            />
          </div>

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

          <div className="form-group">
            <label htmlFor="password_confirmation">Confirmation du mot de passe :</label>
            <input
              type="password"
              id="password_confirmation"
              value={passwordConfirmation}
              onChange={(e) => setPasswordConfirmation(e.target.value)}
              required
            />
          </div>

          <div className="form-group">
            <label htmlFor="role">Rôle :</label>
            <select id="role" value={role} onChange={(e) => setRole(e.target.value)}>
              <option value="client">Client</option>
              <option value="agent">Agent</option>
              <option value="admin">Admin</option>
            </select>
          </div>

          <button type="submit" className="register-button">S'inscrire</button>
        </form>
      </div>
    </div>
  );
};

export default Register;
