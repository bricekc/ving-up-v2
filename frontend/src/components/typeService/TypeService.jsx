import React, {useEffect, useState} from "react";
import LoadingFournisseur from "../fournisseur/LoadingFournisseur.jsx";
import {Link} from "wouter";

function TypeService(typeService) {
    const [service, setService] = useState(null);

    useEffect(() => {
        if (typeService != null) {
            setService(typeService);
        }
    }, [typeService]);

    return (
        <div className="service">
            <div className="desc_mat_ser">
                {service !== null ? (<p className="desc__intitule">{service["typeService"].intitule_service}</p>) : LoadingFournisseur()}
                {service !== null ? (<p className="desc_service_description">{service["typeService"].description_service}</p>) : LoadingFournisseur()}
            </div>
            <div className="liensType">
                {service !== null ? (<Link href={`/typeService/delete/${service["typeService"].id}`}><button className="user_button_submit">Supprimer le service</button></Link>) : ""}
                {service !== null ? (<Link href={`/typeService/update/${service["typeService"].id}`}><button className="user_button_cancel">Modifier le service</button></Link>) : ""}
            </div>
        </div>
    );
}

export default TypeService;