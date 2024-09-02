import React, { useContext, useEffect, useState } from "react";
import UserContext from "../../contexts/user";
import Loading from "../sujet/Loading";
import { postViticulteur } from "../../services/api/user/user";
import { Link } from "wouter";

function InscriptionViti() {
    const [email, setEmail] = useState(null);
    const [lastname, setLastname] = useState(null);
    const [password, setPassword] = useState(null);
    const [firstname, setFirstname] = useState(null);
    const [ville, setVille] = useState(null);
    const [cp, setCp] = useState(null);
    const [adresse, setAdresse] = useState(null);
    const [num_siret, setNum_siret] = useState(null)

    const dataUserConnected = useContext(UserContext);


    const submitForm = (event) => {
        event.preventDefault();
        const data = {"email": email, "password": password, "lastname": lastname, "firstname": firstname, "ville": ville, "cp": cp, "adresse": adresse, 'num_siret': num_siret};
        postViticulteur(data);
    }

    return (
        <>
        <h1 className="class_user">Inscription Viticulteur</h1>
        <Link href="/inscription/fournisseur"><button className="user_button_submit">Vous êtes un Fournisseur ?</button></Link>
        <form onSubmit={submitForm} className="register_form">
            <div>
                <label htmlFor="email" className="required">Adresse mail :</label>
                <input type="text" id="email" className="register_champs" maxLength={180} onChange={e => setEmail(e.target.value)} required/>
            </div>
            <div>
                <label htmlFor="firstname" className="required">Prénom :</label>
                <input type="text" id="firstname" className="register_champs" maxLength={35} onChange={e => setFirstname(e.target.value)} required/>
            </div>
            <div>
                <label htmlFor="lastname" className="required">Nom de Famille :</label>
                <input type="text" id="lastname" className="register_champs" maxLength={35} onChange={e => setLastname(e.target.value)} required/>
            </div>
            <div>
                <label htmlFor="password" className="required">Mot de Passe :</label>
                <input type="password" id="password" className="register_champs" onChange={e => setPassword(e.target.value)} required/>
            </div>
            <div>
                <label htmlFor="adresse" className="required">Adresse :</label>
                <input type="text" id="adresse" className="register_champs" maxLength={255} onChange={e => setAdresse(e.target.value)} required/>
            </div>
            <div>
                <label htmlFor="cp" className="required">Code Postal :</label>
                <input type="text" id="cp" className="register_champs" maxLength={5} onChange={e => setCp(e.target.value)} required/>
            </div>
            <div>
                <label htmlFor="ville" className="required">Ville :</label>
                <input type="text" id="ville" className="register_champs" maxLength={35} onChange={e => setVille(e.target.value)} required/>
            </div>
            <div>
                <label htmlFor="num_siret" className="required">Numéro de Siret :</label>
                <input type="text" id="num_siret" className="register_champs" maxLength={14} onChange={e => setNum_siret(e.target.value)} required/>
            </div>
            <span className="register_container_button">
                <button type="submit" className="user_button_submit">S'inscrire !</button>
            </span>
        </form>
        </>
    )
}

export default InscriptionViti;