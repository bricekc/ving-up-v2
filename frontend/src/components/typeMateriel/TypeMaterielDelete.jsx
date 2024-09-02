import React, {useContext, useEffect, useState} from "react";
import {Link} from "wouter";
import UserContext from "../../contexts/user";
import {deleteTypeMateriel} from "../../services/api/type_materiel/type_materiel.jsx";

function TypeMaterielDelete(materiel) {
    const dataUser = useContext(UserContext);
    const [typeMateriel, setTypeMateriel] = useState(null);

    useEffect(() => {
        if (materiel !== null && materiel !== undefined) {
            setTypeMateriel(materiel);
        }
    }, [materiel]);

    const submitFunction = () => {
        deleteTypeMateriel(typeMateriel["materiel"].id, dataUser['userData']['id']);
    }

    return (
        <div className="confirmationSuppression">
            <h1>Voulez-vous vraiment supprimer ce materiel ?</h1>
            {
                typeMateriel !== null && typeMateriel !== undefined && dataUser['userData'] !== null && dataUser['userData'] !== undefined ?
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

export default TypeMaterielDelete;