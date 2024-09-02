import React from "react";
import moment from "moment";
import { Link } from "wouter";
import { useState } from "react";
import { useContext } from "react";
import UserContext from "../../contexts/user";
import { deleteSujet } from "../../services/api/sujet/sujets";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faTrash } from '@fortawesome/free-solid-svg-icons';

function SujetItem(data, dataUser)
{
    return (
        <div key={data.id} className="sujet">
        {dataUser['userData'] !== null && dataUser['userData'] !== undefined && dataUser['userData']['@type'] === 'Admin' ? <div onClick={() => deleteSujet(data.id)}><FontAwesomeIcon icon={faTrash}/></div> : ""}
        <Link href={`/sujets/${data.id}`}>{data.intitule_sujet}</Link>
        <div className="sujet_info">
            {data.date_last_update ? moment(data.date_last_update).format('DD/MM/YYYY HH:mm:ss') : "Pas de post"}
        </div>
    </div>
    )
}

export default SujetItem;