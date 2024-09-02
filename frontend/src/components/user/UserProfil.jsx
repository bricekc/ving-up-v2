import React, { useContext, useEffect, useState } from "react";
import UserContext from "../../contexts/user";
import Loading from "../sujet/Loading";
import moment from "moment";
import { getAvatar } from "../../services/api/user/user";
import { Link } from "wouter";


function UserProfil(user) {
    const dataUserConnected = useContext(UserContext);
    const userData = user.user;
    if (userData === null || userData === undefined) {
        return Loading();
      }
    return (
        <>
        <h1 className="class_user">Cet utilisateur est un {userData['@type']}</h1>
        <div className="user">
            <div className="user_image_and_name">
                <img className="user_image" src={getAvatar(userData.id)} alt="photo de profil user" height={150} width={150}/>
                <p className="user_name">{userData.firstname} {userData.lastname}</p>
            </div>
            <div className="info_user">
                <p className="info">Infos</p>
                <div className="info_user_content">
                    <p className="user_email">Mail : {userData.email}</p>
                    <p className="user_adresse">Adresse : {userData.adresse}, {userData.cp} {userData.ville}</p>
                    {userData["@type"] === "Viticulteur" ? <p className="user_siret">Numéro de Siret : {userData.num_siret}</p> : null}
                    <p>Inscrit depuis le : {moment(userData.dateCreation).format('DD/MM/YYYY')}</p>
                </div>
                <p className="info">Contribution au forum</p>
                    <div className="info_user_content">
                        <p className="user_message_envoye">Nombre de message envoyé dans le forum : {userData.nbPost}</p>
                    </div>
                <div className="user_buttons">
                    <div className="user_buttons_logout_update">
                        {dataUserConnected['userData'] !== null && dataUserConnected['userData'] !== undefined && dataUserConnected['userData']['id'] === userData.id ? <Link href={`/user/update/${userData.id}`}><button className="user_button_submit">Modifier le profil</button></Link> : null}
                        {dataUserConnected['userData'] !== null && dataUserConnected['userData'] !== undefined && dataUserConnected['userData']['id'] === userData.id ? <a href="https://localhost:8000/logout"><button className="user_button_cancel">Se Déconnecter</button></a> : null}
                    </div>
                    <div className="button_show">
                        {userData['@type'] === "Fournisseur" ? <Link href={`/fournisseurs/${userData.id}`}><button className="user_button_submit">Voir le materiel et les services proposé</button></Link> : null}
                    </div>
                </div>
            </div>
        </div>
        </>
    )
}

export default UserProfil;