import React, { useEffect, useState } from "react";
import { Route, Switch, useRoute } from "wouter";
import SujetsDetail from "../components/sujet/SujetsDetail";
import SujetList from "../components/sujet/SujetsList";
import { fetchSujet } from "../services/api/sujet/sujets";

function Sujets() {
    const [match, params] = useRoute("/sujets/:sujetId?");
    const [sujet, setSujet] = useState(null);

    useEffect(() => {
        setSujet(undefined);
        if (params.sujetId && Number.isInteger(parseInt(params.sujetId))) {
            fetchSujet(params.sujetId).then((response) => {
                setSujet(response);
            });
        }
    }, [params.sujetId]);
    return (
        <Switch>
            <Route path="/sujets">
                <SujetList/>
            </Route>
            <Route path="/sujets/create">
                <h1>Création</h1>
            </Route>
            <Route path="/sujets/:sujetId">
            <SujetsDetail data={sujet}/>
            </Route>
            <Route>
                <SujetList/>
            </Route>
        </Switch>
    )
}

export default Sujets;