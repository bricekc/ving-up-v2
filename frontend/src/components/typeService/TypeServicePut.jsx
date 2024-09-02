import React, {useContext, useEffect, useState} from "react";
import {fetchAllTags} from "../../services/api/tag/tag.jsx";
import UserContext from "../../contexts/user";
import {fetchPutTypeService} from "../../services/api/type_service/type_service.jsx";

function TypeServicePut(service) {
    const [intitule_service, setIntituleService] = useState('');
    const [description_service, setDescService] = useState('');
    const [tag, setTag] = useState('/api/tags/1')
    const [listeTag, setListeTag] = useState(null);
    const [conditionFetchTag, setConditionFetchTag] = useState(true);
    const [stopActu, setStopActu] = useState(true);
    const dataUser = useContext(UserContext);

    useEffect(() => {
        if (conditionFetchTag) {
            fetchAllTags().then((response) => {setListeTag(response)});
            setConditionFetchTag(false);
        }
    }, []);

    useEffect(() => {
        if (service["service"] !== null && service["service"] !== undefined && stopActu) {
            setIntituleService(service["service"].intitule_service);
            setDescService(service["service"].description_service);
            setTag(service["service"].tag["@id"])
            setStopActu(false);
        }
    });

    const submitForm = (event) => {
        event.preventDefault();
        const data = {intitule_service, description_service, tag};
        fetchPutTypeService(data, service["service"].id, dataUser['userData']['id']);
    }

    return (
        <div>
            <form onSubmit={submitForm}>
                <h1>Modification d'un nouveau Service :</h1>
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
                <button type="submit">Modifier</button>
                {dataUser['userData'] !== null && dataUser['userData'] !== undefined ? (<button type="button" onClick={() => window.location.replace("/fournisseurs/" + dataUser['userData']['id'])}>Retour</button>) : ""}
            </form>
        </div>
    );
}

export default TypeServicePut;