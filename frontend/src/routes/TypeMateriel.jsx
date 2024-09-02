import React, {useEffect, useState} from "react";
import {Route, Switch, useRoute} from "wouter";
import FournisseursList from "../components/fournisseur/FournisseursList.jsx";
import TypeMaterielCreate from "../components/typeMateriel/TypeMaterielCreate.jsx";
import {fetchTypeMaterielById} from "../services/api/type_materiel/type_materiel.jsx";
import TypeMaterielDelete from "../components/typeMateriel/TypeMaterielDelete.jsx";
import TypeMaterielPut from "../components/typeMateriel/TypeMaterielPut.jsx";

function TypeMateriel() {
    const [match, params] = useRoute("/typeMateriel/:action/:typeMateriel?");
    const [typeMateriel, setTypeMateriel] = useState(null);

    useEffect(() => {
        setTypeMateriel(undefined);
        if (params.typeMateriel && Number.isInteger(parseInt(params.typeMateriel))) {
            fetchTypeMaterielById(params.typeMateriel).then((response) => {
                setTypeMateriel(response);
            });
        }
    }, [params.typeMateriel]);

    return (
        <Switch>
            <Route path="/typeMateriel/create">
                <TypeMaterielCreate />
            </Route>
            <Route path="/typeMateriel/delete/:typeMateriel?">
                <TypeMaterielDelete materiel={typeMateriel} />
            </Route>
            <Route path="/typeMateriel/update/:typeMateriel?">
                <TypeMaterielPut materiel={typeMateriel} />
            </Route>
            <Route>
                <FournisseursList />
            </Route>
        </Switch>
    );
}

export default TypeMateriel;