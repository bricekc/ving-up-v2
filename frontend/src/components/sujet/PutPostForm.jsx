import React, { useState } from "react";
import { putPost } from "../../services/api/sujet/sujets";
import Modal from "react-modal";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faPen } from "@fortawesome/free-solid-svg-icons";

Modal.setAppElement("#root");

function PutPostForm({ data }) {
  const [modalIsOpen, setModalIsOpen] = useState(false);
  const [texte, setTexte] = useState(data.texte);

  const openModal = () => {
    setModalIsOpen(true);
  };

  const closeModal = () => {
    setModalIsOpen(false);
  };

  const submitForm = (event) => {
    event.preventDefault();
    const newData = { texte };
    closeModal();
    putPost(data.id, newData);
  };

  return (
    <>
      <div onClick={() => openModal()}><FontAwesomeIcon icon={faPen}/></div>
      <Modal isOpen={modalIsOpen} onRequestClose={() => closeModal()} style={{content: {width: '500px', height: '200px'}}} className="register_form modals">
        <form onSubmit={submitForm}>
          <label htmlFor="texte">Texte du post :</label>
          <input type="text" id="texte" name="texte" value={texte} onChange={(e) => setTexte(e.target.value)} className="register_champs"
          />
          <button type="submit" className="user_button_submit">Envoyer</button>
          <button onClick={() => closeModal()} className="rubrique_button_delete">Annuler</button>
        </form>
      </Modal>
    </>
  );
}

export default PutPostForm;