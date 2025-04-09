import React from "react";
import { Link } from "react-router-dom";

const Header = () => {
  return (
    <header className="header">
      <nav className="nav">
        <h2 className="logo">CustomerCare</h2>
        <ul className="nav-links">
          <li><Link to="/">Accueil</Link></li>
          <li><Link to="/tickets">Mes Tickets</Link></li>
          <li><Link to="/login">Connexion</Link></li>
          <li><Link to="/register">Inscription</Link></li>
        </ul>
      </nav>
    </header>
  );
};

export default Header;
