import React from "react";
import { Route, Switch, useRoute } from "wouter";
import InscriptionViti from "../components/inscription/InscriptionViti";
import InscriptionFourni from "../components/inscription/InscriptionFourni";

function Inscription() {
    const [match, params] = useRoute("/inscription/:userType?");

    return (
        <Switch>
            <Route path="/inscription/viticulteur">
                <InscriptionViti />
            </Route>
            <Route path="/inscription/fournisseur">
                <InscriptionFourni />
            </Route>
        </Switch>
    )
}

export default Inscription;