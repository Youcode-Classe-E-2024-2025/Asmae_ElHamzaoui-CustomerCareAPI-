import React, { useEffect, useState } from "react";
import ticketService from "../services/ticketService";
import { Button, Modal, Input, Table } from "antd";
import { EditOutlined, DeleteOutlined, PlusOutlined } from "@ant-design/icons";

const ClientDashboard = () => {
  const [tickets, setTickets] = useState([]);
  const [isModalVisible, setIsModalVisible] = useState(false);
  const [currentTicket, setCurrentTicket] = useState(null);
  const [title, setTitle] = useState("");
  const [description, setDescription] = useState("");
  const [token, setToken] = useState("");

  useEffect(() => {
    // Récupérer le token depuis le localStorage
    const user = JSON.parse(localStorage.getItem("user"));
    if (user && user.access_token) {
      setToken(user.access_token); // Sauvegarder le token dans l'état
    }

    fetchTickets();
  }, []);

  const fetchTickets = async () => {
    try {
      const data = await ticketService.getAllTickets();
      setTickets(data); // Ici, vérifier si 'data' contient bien les tickets attendus
    } catch (error) {
      console.error("Erreur lors du chargement des tickets", error);
    }
  };

  const handleCreateOrUpdate = async () => {
    try {
      if (currentTicket) {
        // Mise à jour du ticket existant
        await ticketService.updateTicket(currentTicket.id, { title, description });
      } else {
        // Création d'un nouveau ticket
        await ticketService.createTicket({ title, description });
      }
      setIsModalVisible(false);
      setCurrentTicket(null);
      fetchTickets(); // Rechargement des tickets après modification ou création
    } catch (error) {
      console.error("Erreur lors de la sauvegarde du ticket", error);
    }
  };

  const handleEdit = (ticket) => {
    setCurrentTicket(ticket);
    setTitle(ticket.title);
    setDescription(ticket.description);
    setIsModalVisible(true);
  };

  const handleDelete = async (id) => {
    try {
      await ticketService.deleteTicket(id);
      fetchTickets(); // Mise à jour de la liste après suppression
    } catch (error) {
      console.error("Erreur lors de la suppression du ticket", error);
    }
  };

  const columns = [
    { title: "Titre", dataIndex: "title", key: "title" },
    { title: "Description", dataIndex: "description", key: "description" },
    {
      title: "Actions",
      render: (record) => (
        <>
          <Button icon={<EditOutlined />} onClick={() => handleEdit(record)} />
          <Button icon={<DeleteOutlined />} danger onClick={() => handleDelete(record.id)} />
        </>
      ),
    },
  ];

  return (
    <div className="p-6 bg-gray-900 min-h-screen text-white">
      <h1 className="text-2xl font-bold mb-4">Dashboard Client</h1>
      
      {/* Affichage du token pour vérifier l'authentification */}
      <div className="mb-4">
        <p><strong>Token JWT :</strong> {token}</p>
      </div>

      <Button icon={<PlusOutlined />} type="primary" onClick={() => setIsModalVisible(true)}>
        Nouveau Ticket
      </Button>
      <Table columns={columns} dataSource={tickets} rowKey="id" className="mt-4" />

      <Modal
        title={currentTicket ? "Modifier Ticket" : "Créer un Ticket"}
        open={isModalVisible}
        onOk={handleCreateOrUpdate}
        onCancel={() => setIsModalVisible(false)}
      >
        <Input
          placeholder="Titre"
          value={title}
          onChange={(e) => setTitle(e.target.value)}
          className="mb-2"
        />
        <Input.TextArea
          placeholder="Description"
          value={description}
          onChange={(e) => setDescription(e.target.value)}
        />
      </Modal>
    </div>
  );
};

export default ClientDashboard;
