import React, {useCallback, useEffect, useState} from "react";
import {fetchAllFournisseurs} from "../../services/api/fournisseur/fournisseurs.jsx";
import LoadingFournisseur from "./LoadingFournisseur.jsx";
import Fournisseur from "./Fournisseur.jsx";
import Pagination from "./Pagination.jsx";


function FournisseursList() {
    const [fournisseurs, setFournisseurs] = useState(null);
    const [fournisseurPagination, setFournisseurPagination] = useState({});

    const fetchFournisseur = useCallback((page = 1) => {
        fetchAllFournisseurs(page).then((response) => {
            setFournisseurs(response["hydra:member"]);
            setFournisseurPagination(response["hydra:view"]);
        })
    });

    useEffect(() => {
        fetchFournisseur()
    }, [fetchFournisseur]);

    return (
        <div className="fournisseurs">
            <h1>Liste des fournisseurs et des prestataires</h1>

            {fournisseurs !== null ? fournisseurs.map((fournisseur) => {
                    return (
                        <a className="lienFournisseur" href={"/fournisseurs/" + fournisseur.id}>
                            <Fournisseur fournisseur={fournisseur} />
                        </a>
                    );
                })
                :
                <LoadingFournisseur />
            }
            <Pagination pagination={fournisseurPagination} fetchFournisseur={fetchFournisseur} />
        </div>
    );
}

export default FournisseursList;