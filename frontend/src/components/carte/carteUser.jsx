import React from "@types/react";
import {getAvatar} from "../../services/api/user/user.jsx";
import user from "../../routes/User.jsx";



function CarteUser()
{
    return (
        <>
            <div className="user">
                <div className="user_image_and_name">
                    <img className="user_image" src={getAvatar(user.user.id)} alt="photo de profil user" height={150} width={150}/>
                    <p className="user-name">{user.user.firstname} {user.user.lastname}</p>
                </div>
            </div>
        </>
            );
}
export default CarteUser
