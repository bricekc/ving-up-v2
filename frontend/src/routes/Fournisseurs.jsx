import React, {useEffect, useState} from "react";
import {Route, Switch, useRoute} from "wouter";
import FournisseursList from "../components/fournisseur/FournisseursList.jsx";
import {fetchFournisseurById} from "../services/api/fournisseur/fournisseurs.jsx";
import FournisseurProfil from "../components/fournisseur/FournisseurProfil.jsx";

function Fournisseurs() {
    const [match, params] = useRoute("/fournisseurs/:fournisseurId?");
    const [fournisseur, setFournisseur] = useState(null);

    useEffect(() => {
        setFournisseur(undefined);
        if (params.fournisseurId && Number.isInteger(parseInt(params.fournisseurId))) {
            fetchFournisseurById(params.fournisseurId).then((response) => {
                setFournisseur(response);
            })
        }
    }, [params.fournisseurId]);

    return (
        <Switch>
            <Route path="/fournisseurs">
                <FournisseursList />
            </Route>
            <Route path="/fournisseurs/:fournisseurId?">
                <FournisseurProfil fournisseur={fournisseur} />
            </Route>
            <Route>
                <FournisseursList />
            </Route>
        </Switch>
    );
}

export default Fournisseurs;