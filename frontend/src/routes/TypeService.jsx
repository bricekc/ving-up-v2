import React, {useEffect, useState} from "react";
import {Route, Switch, useRoute} from "wouter";
import FournisseursList from "../components/fournisseur/FournisseursList.jsx";
import TypeServiceCreate from "../components/typeService/TypeServiceCreate.jsx";
import {fetchTypeServiceById} from "../services/api/type_service/type_service.jsx";
import TypeServiceDelete from "../components/typeService/TypeServiceDelete.jsx";
import TypeServicePut from "../components/typeService/TypeServicePut.jsx";

function TypeService() {
    const [match, params] = useRoute("/typeService/:action/:typeService?");
    const [typeService, setTypeService] = useState(null);

    useEffect(() => {
        setTypeService(undefined);
        if (params.typeService && Number.isInteger(parseInt(params.typeService))) {
            fetchTypeServiceById(params.typeService).then((response) => {
                setTypeService(response);
            });
        }
    }, [params.typeService]);

    return (
        <Switch>
            <Route path="/typeService/create">
                <TypeServiceCreate />
            </Route>
            <Route path="/typeService/delete/:typeService?">
                <TypeServiceDelete service={typeService} />
            </Route>
            <Route path="/typeService/update/:typeService?">
                <TypeServicePut service={typeService} />
            </Route>
            <Route>
                <FournisseursList />
            </Route>
        </Switch>
    );
}

export default TypeService;