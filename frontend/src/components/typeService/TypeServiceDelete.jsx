import React, {useContext, useEffect, useState} from "react";
import {Link} from "wouter";
import UserContext from "../../contexts/user";
import {deleteTypeService} from "../../services/api/type_service/type_service.jsx";

function TypeServiceDelete(service) {
    const dataUser = useContext(UserContext);
    const [typeService, setTypeService] = useState(null);

    useEffect(() => {
        if (service !== null && service !== undefined) {
            setTypeService(service);
        }
    }, [service]);

    const submitFunction = () => {
        deleteTypeService(typeService["service"].id, dataUser['userData']['id']);
    }

    return (
        <div className="confirmationSuppression">
            <h1>Voulez-vous vraiment supprimer ce service ?</h1>
            {
                typeService !== null && typeService !== undefined && dataUser['userData'] !== null && dataUser['userData'] !== undefined ?
                    (<button type="button" onClick={submitFunction}>Supprimer</button>)
                    :
                    ""
            }
            {
                dataUser['userData'] !== null && dataUser['userData'] !== undefined ?
                    (<Link href={`/fournisseurs/${dataUser['userData']['id']}`}>Retour</Link>)
                    :
                    ""
            }
        </div>
    );
}

export default TypeServiceDelete;