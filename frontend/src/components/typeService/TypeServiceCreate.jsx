import React, {useContext, useEffect, useState} from "react";
import {fetchAllTags} from "../../services/api/tag/tag.jsx";
import {fetchPostTypeService} from "../../services/api/type_service/type_service.jsx";
import UserContext from "../../contexts/user";

function TypeServiceCreate() {
    const [intitule_service, setIntituleService] = useState('');
    const [description_service, setDescService] = useState('');
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
        const data = {intitule_service, description_service, tag, "fournisseurs" : [`/api/fournisseurs/${dataUser['userData']['id']}`]};
        fetchPostTypeService(data);
    }

    return (
        <form onSubmit={submitForm}>
            <h1>Création d'un nouveau service :</h1>
            <label htmlFor="intitule_service">intitule du service :</label>
            <input type="text" id="intitule" name="intitule" value={intitule_service} onChange={e => setIntituleService(e.target.value)} />
            <label htmlFor="tag">Tag :</label>
            <select name="tag" id="tag" value={tag} onChange={e => setTag(e.target.value)} >
                {
                    listeTag !== null ?
                        listeTag["hydra:member"].map((x) => (<option value={x["@id"]}>{x.nom}</option>))
                        :
                        ""
                }
            </select>
            <label htmlFor="description_service">description du service :</label>
            <input type="text" id="description" name="description" value={description_service} onChange={e => setDescService(e.target.value)} />
            <button type="submit">Créer</button>
            {dataUser['userData'] !== null && dataUser['userData'] !== undefined ? (<button type="button" onClick={() => window.location.replace("/fournisseurs/" + dataUser['userData']['id'])}>Retour</button>) : ""}
        </form>
    );
}

export default TypeServiceCreate;