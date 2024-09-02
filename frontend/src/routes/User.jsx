import { parse } from "@fortawesome/fontawesome-svg-core";
import React, {useEffect, useState} from "react";
import { Route, Switch, useRoute } from "wouter";
import { getUser } from "../services/api/user/user";
import UserProfil from "../components/user/UserProfil";
import UserUpdate from "../components/user/UserUpdate";

function User() {
    const [match, params] = useRoute('/user/:action/:userId?');
    const [user, setUser] = useState(null);

    useEffect(() => {
        setUser(undefined);
        if (params.userId && Number.isInteger(parseInt(params.userId))) {
            getUser(params.userId).then((response) => {
                setUser(response);
            })
        }
    }, [params.userId]);
    return (
        <Switch>
            <Route path="/user/profil/:userId">
                <UserProfil user={user}/>
            </Route>
            <Route path="/user/update/:userId">
                <UserUpdate user={user}/>
            </Route>
        </Switch>
    )
}

export default User;