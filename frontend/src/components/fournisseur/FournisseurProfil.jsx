import React, {useContext, useEffect, useState} from "react";
import LoadingFournisseur from "./LoadingFournisseur.jsx";
import Fournisseur from "./Fournisseur.jsx";
import TypeMateriel from "../typeMateriel/TypeMateriel.jsx";
import TypeService from "../typeService/TypeService.jsx";
import UserContext from "../../contexts/user";
import { Link } from "wouter";

function FournisseurProfil(fournisseur) {
    const [fourni, setFourni] = useState(null);
    const dataUser = useContext(UserContext);

    useEffect(() => {
        if (fournisseur["fournisseur"] != null) {
            setFourni(fournisseur["fournisseur"]);
        }
    }, [fournisseur]);

    return (
        <div className="profilFournisseur">
            <h1>Materiels et Services proposés par {fourni !== null ? fourni.lastname + " " + fourni.firstname : <LoadingFournisseur />}</h1>
            <Fournisseur fournisseur={fourni !== null ? fourni : null} />
            <div className="materiel_service_show">
                <div className="materiels">
                    <h2 className="h2_mat_ser">liste materiels</h2>
                    {dataUser['userData'] !== null && dataUser['userData'] !== undefined && fourni !== null && fourni !== undefined ? dataUser['userData']['id'] === fourni.id ? <Link href="/typeMateriel/create">Ajouter un materiel</Link> : "" : ""}
                    <div className="liste_materiel">
                        {
                            fourni !== null ?
                                fournisseur["fournisseur"].type_materiel_propose.map((m) => (<TypeMateriel typeMateriel={m}/>))
                                :
                                (<LoadingFournisseur />)
                        }
                    </div>
                </div>
                <div className="services">
                    <h2 className="h2_mat_ser">liste services</h2>
                    <div className="liste_service">
                        {dataUser['userData'] !== null && dataUser['userData'] !== undefined && fourni !== null && fourni !== undefined ? dataUser['userData']['id'] === fourni.id ? <Link href="/typeService/create">Ajouter un service</Link> : "" : ""}
                        {
                            fourni !== null ?
                                fournisseur["fournisseur"].type_service_propose.map((s) => (<TypeService typeService={s} />))
                                :
                                (<LoadingFournisseur />)
                        }
                    </div>
                </div>
            </div>
        </div>
        )
}

export default FournisseurProfil;