import React from 'react';
import Carte from './carte.jsx';
import UserProfil from "../user/UserProfil.jsx";
import CarteUser from "./carteUser.jsx";

function carteList() {
    return (
        <React.Fragment>
            <div>
                <Carte/>
            </div>
        </React.Fragment>

    );
}

export default carteList;
