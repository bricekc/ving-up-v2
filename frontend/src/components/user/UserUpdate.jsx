import React, { useContext, useEffect, useState } from "react";
import UserContext from "../../contexts/user";
import Loading from "../sujet/Loading";
import moment from "moment";
import { getAvatar, putUser, putViticulteur } from "../../services/api/user/user";
import { Link } from "wouter";

function UserUpdate(user) {
    const dataUserConnected = useContext(UserContext);
    const userData = user.user;

    const [email, setEmail] = useState(userData.email);
    const [lastname, setLastname] = useState(userData.lastname);
    const [firstname, setFirstname] = useState(userData.firstname);
    const [ville, setVille] = useState(userData.ville);
    const [cp, setCp] = useState(userData.cp);
    const [adresse, setAdresse] = useState(userData.adresse);

    const [num_siret, setNum_siret] = useState( userData['@type'] === 'Viticulteur' ? userData.num_siret : null)

    if (userData === null || userData === undefined) {
        return Loading();
    }

    if (userData.id !== dataUserConnected['userData']['id'])
    {
        window.location.replace('/home')
    }

    const submitForm = (event) => {
        event.preventDefault();
        const data = userData['@type'] === 'Viticulteur' ? {"email": email, "lastname": lastname, "firstname": firstname, "ville": ville, "cp": cp, "adresse": adresse, 'num_siret': userData.num_siret} : {"email": email, "lastname": lastname, "firstname": firstname, "ville": ville, "cp": cp, "adresse": adresse};
        userData['@type'] === 'Viticulteur' ? putViticulteur( userData.id, data) : putUser(userData.id, data);
    }

    return (
        <>
        <h1 className="class_user">Modification du profil de {userData.firstname} {userData.lastname}</h1>
        <form onSubmit={submitForm}>
            <div className="user">
                <div className="user_image_and_name">
                    <img className="user_image" src={getAvatar(userData.id)} alt="photo de profil user" height={150} width={150}/>
                    <div className="user_name">
                        <label htmlFor="firstanem">Prénom : </label>
                        <input type="text" id="firstname" name="firstanme" value={firstname} onChange={e => setFirstname(e.target.value)} placeholder={`${firstname}`} />
                        <label htmlFor="lastname">Nom : </label>
                        <input type="text" id="lastname" name="lastname" value={lastname} onChange={e => setLastname(e.target.value)} placeholder={`${lastname}`}/>
                    </div>
                </div>
                <div className="info_user">
                    <p className="info">Infos</p>
                    <div className="info_user_content">
                        <label className="user_email" htmlFor="email">Mail : </label>
                        <input type="text" id="email" name="email" value={email} onChange={e => setEmail(e.target.value)} placeholder={`${email}`}/>
                        <div className="user_adresse">
                            <label htmlFor="adresse">Adresse : </label>
                            <input type="text" id="adresse" name="adresse" value={adresse} onChange={e => setAdresse(e.target.value)} placeholder={`${adresse}`}/>
                            <label htmlFor="cp">Code Postal : </label>
                            <input type="text" id="cp" name="cp" value={cp} onChange={e => setCp(e.target.value)} placeholder={`${cp}`}/>
                            <label htmlFor="ville">Ville : </label>
                            <input type="text" id="ville" name="ville" value={ville} onChange={e => setVille(e.target.value)} placeholder={`${ville}`}/>
                        </div>
                        {userData['@type'] === 'Viticulteur' ? <label htmlFor="num_siret">Numéro de Siret</label> : null}
                        {userData['@type'] === 'Viticulteur' ? <input type="text" name="num_siret" value={num_siret} onChange={e => setNum_siret(e.target.value)} placeholder={`${num_siret}`}/> : null}
                    </div>
                    <div className="user_buttons">
                        <button type="submit" className="user_button_submit">Modifier le profil</button>
                        <Link href={`/user/${userData.id}`}><button className="user_button_cancel">Annuler les modifications</button></Link>
                    </div>
                </div>
            </div>
        </form>
        </>
    )
}

export default UserUpdate;
