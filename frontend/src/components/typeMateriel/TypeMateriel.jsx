import React, {useEffect, useState} from "react";
import LoadingFournisseur from "../fournisseur/LoadingFournisseur.jsx";
import {Link} from "wouter";

function TypeMateriel(typeMateriel) {
    const [materiel, setMateriel] = useState(null);

    useEffect(() => {
        if (typeMateriel != null) {
            setMateriel(typeMateriel);
        }
    }, [typeMateriel]);

    return (
        <>
            <div className="desc_mat_ser">
                {materiel !== null ? (<p className="desc_intitule">{materiel["typeMateriel"].intitule_materiel}</p>) : LoadingFournisseur()}
                {materiel !== null ? (<p className="desc_materiel_description">{materiel["typeMateriel"].description_materiel}</p>) : LoadingFournisseur()}
            </div>
            <div className="liensType">
                {materiel !== null ? (<Link href={`/typeMateriel/delete/${materiel["typeMateriel"].id}`}><button className="user_button_submit">Supprimer le materiel</button></Link>) : ""}
                {materiel !== null ? (<Link href={`/typeMateriel/update/${materiel["typeMateriel"].id}`}><button className="user_button_cancel">Modifier le materiel</button></Link>) : ""}
            </div>
        </>
    );
}

export default TypeMateriel;