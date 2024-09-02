import { useState } from "react";
import Modal from "react-modal";
import { postRubrique } from "../../services/api/rubrique/rubriques";

Modal.setAppElement("#root");

function RubriqueForm() {
    const [modalIsOpen, setModalIsOpen] = useState(false);
    const [description, setDescription] = useState(undefined);
    const [titre, setTitre] = useState(undefined);
    const [file, setFile] = useState(undefined);

    const openModal = () => {
        setModalIsOpen(true);
    }

    const closeModal = () => {
        setModalIsOpen(false);
    }

    const submitForm = (event) => {
        event.preventDefault();
        const data = new FormData();
        data.append('description', description);
        data.append('file', file);
        data.append('titre', titre)
        closeModal();
        postRubrique(data);
    }

    return (
        <>
            <button className="rubrique_button_add" onClick={() => openModal()}>Ajouter une rubrique</button>
            <Modal isOpen={modalIsOpen} onRequestClose={() => closeModal()} style={{content: {width: '500px', height: '300px'}}} className="modals register_form">
                <form onSubmit={submitForm}>
                    <label htmlFor="titre">Titre de la rubrique :</label>
                    <input type="text" id="titre" name="titre" value={titre} onChange={(e) => setTitre(e.target.value)} className="register_champs"
                    />
                    <label htmlFor="description">Description de la rubrique :</label>
                    <input type="text" id="description" name="description" value={description} onChange={(e) => setDescription(e.target.value)} className="register_champs"
                    />
                    <label htmlFor="file">Fichier :</label>
                    <input type="file" id="file" name="file" onChange={(e) => setFile(e.target.files[0])} className="register_champs"/>
                    <button type="submit" className="user_button_submit">Envoyer</button>
                    <button onClick={() => closeModal()} className="rubrique_button_delete">Annuler</button>
                </form>
            </Modal>
        </>
    );
}

export default RubriqueForm;