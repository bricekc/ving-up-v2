import React, {useEffect, useState} from "react";
import LoadingFournisseur from "./LoadingFournisseur.jsx";
import Tag from "../tag/Tag.jsx";
import {getAvatar} from "../../services/api/user/user.jsx";

function Fournisseur(fournisseur) {
    const [fourni, setFourni] = useState(null);

    useEffect(() => {
        if (fournisseur["fournisseur"] != null) {
            setFourni(fournisseur["fournisseur"]);
        }
    }, [fournisseur]);

    return (
        <div className="fournisseur">
            <div className="fournisseur_image_and_name">
                <div className="image">
                    <img className="image_Fournisseur" src={fourni !== null && fourni !== undefined ? getAvatar(fourni.id) : ""} alt="photo de profil fournisseur" height={150} width={150}/>
                </div>
                <div className="name_fourn">
                    {fourni !== null ? (<p>{fourni.lastname} {fourni.firstname}</p>) : <LoadingFournisseur />}
                </div>
            </div>
            <div className="materiel_service">
                <p className="propose">Materiels Proposés : </p>
                <div className="materiel_tags">
                    {
                        fourni !== null ?
                            fournisseur["fournisseur"].type_materiel_propose.map((m) => (<Tag tag={m.tag} />))
                            :
                            (<LoadingFournisseur />)
                    }
                </div>
                <p className="propose">Services Poposés : </p>
                <div className="service_tags">
                    {
                        fourni !== null ?
                            fournisseur["fournisseur"].type_service_propose.map((m) => (<Tag tag={m.tag} />))
                            :
                            (<LoadingFournisseur />)
                    }
                </div>
            </div>
        </div>
    );
}

export default Fournisseur;