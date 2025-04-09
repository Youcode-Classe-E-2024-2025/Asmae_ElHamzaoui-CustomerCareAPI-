import React from "react";
import { Link } from "react-router-dom";
import Header from "../components/Header";
import "../styles.css";

const Home = () => {
  return (
    <>
      <Header />
      <div className="home-hero">
        <div className="home-hero-content">
          <h1>Bienvenue sur CustomerCare</h1>
          <p>La meilleure solution pour gérer vos demandes et tickets de support.</p>
          <Link to="/tickets/create" className="btn-primary">Créer un Ticket</Link>
        </div>
      </div>

      <section className="about-section">
        <h2>À propos de nous</h2>
        <p>Notre plateforme vous aide à gérer vos demandes de support en toute simplicité.</p>
      </section>

      <section className="features-section">
        <h2>Pourquoi choisir CustomerCare ?</h2>
        <div className="features-container">
          <div className="feature-box">
            <h3>Support Rapide</h3>
            <p>Nos agents répondent rapidement à vos demandes.</p>
          </div>
          <div className="feature-box">
            <h3>Suivi des Tickets</h3>
            <p>Gardez un œil sur l'état de vos tickets en temps réel.</p>
          </div>
          <div className="feature-box">
            <h3>Interface Intuitive</h3>
            <p>Une plateforme simple et agréable à utiliser.</p>
          </div>
        </div>
      </section>

      <footer className="footer">
        <p>&copy; 2025 CustomerCare - Tous droits réservés</p>
      </footer>
    </>
  );
};

export default Home;
