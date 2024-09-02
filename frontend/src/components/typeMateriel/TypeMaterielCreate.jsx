import React, {useContext, useEffect, useState} from "react";
import {fetchAllTags} from "../../services/api/tag/tag.jsx";
import {fetchPostTypeMateriel} from "../../services/api/type_materiel/type_materiel.jsx";
import UserContext from "../../contexts/user";

function TypeMaterielCreate() {
    const [intitule_materiel, setIntituleMateriel] = useState('');
    const [description_materiel, setDescMateriel] = useState('');
    const [tag, setTag] = useState('/api/tags/1')
    const [listeTag, setListeTag] = useState(null);
    const [conditionFetch, setConditionFetch] = useState(true);
    const dataUser = useContext(UserContext);

    useEffect(() => {
        if (conditionFetch) {
            fetchAllTags().then((response) => {setListeTag(response)});
            setConditionFetch(false);
        }
    }, []);

    const submitForm = (event) => {
        event.preventDefault();
        const data = {intitule_materiel, description_materiel, tag, "fournisseurs" : [`/api/fournisseurs/${dataUser['userData']['id']}`]};
        fetchPostTypeMateriel(data);
    }

    return (
        <form onSubmit={submitForm}>
            <h1>Création d'un nouveau Materiel :</h1>
            <label htmlFor="intitule_materiel">intitule du materiel :</label>
            <input type="text" id="intitule" name="intitule" value={intitule_materiel} onChange={e => setIntituleMateriel(e.target.value)} />
            <label htmlFor="tag">Tag :</label>
            <select name="tag" id="tag" value={tag} onChange={e => setTag(e.target.value)} >
                {
                    listeTag !== null ?
                        listeTag["hydra:member"].map((x) => (<option value={x["@id"]}>{x.nom}</option>))
                        :
                        ""
                }
            </select>
            <label htmlFor="description_materiel">description du materiel :</label>
            <input type="text" id="description" name="description" value={description_materiel} onChange={e => setDescMateriel(e.target.value)} />
            <button type="submit">Créer</button>
            {dataUser['userData'] !== null && dataUser['userData'] !== undefined ? (<button type="button" onClick={() => window.location.replace("/fournisseurs/" + dataUser['userData']['id'])}>Retour</button>) : ""}
        </form>
    );
}

export default TypeMaterielCreate;