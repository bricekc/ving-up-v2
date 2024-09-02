import React, { useEffect, useState, useContext } from "react";
import Loading from "./Loading";
import moment from "moment";
import { Link } from "wouter";
import PostForm from "./PostForm";
import UserContext from "../../contexts/user";
import { deletePost } from "../../services/api/sujet/sujets";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faTrash, faPen } from '@fortawesome/free-solid-svg-icons';
import PutPostForm from "./PutPostForm";
import { getAvatar } from "../../services/api/user/user";

function SujetsDetail(data) {
  const [sujetData, setSujetData] = useState([]);
  const dataUser = useContext(UserContext);

  useEffect(() => {
    if (data["data"] == null) {
      setSujetData(Loading());
    } else {
      setSujetData(
        data["data"].posts.sort((a, b) => moment(a.date) - moment(b.date)).map((sujet) => (
          <div className="post" key={sujet.id}>
            <div className="post_on_top">
              <div className="update_delete">
                {dataUser['userData'] !== null && dataUser['userData'] !== undefined && (dataUser['userData']['@type'] === 'Admin' || (dataUser['userData']['id'] === sujet["user"].id)) ? <div onClick={() => deletePost(sujet.id)}><FontAwesomeIcon icon={faTrash} /></div> : ""}
      {dataUser['userData'] !== null && dataUser['userData'] !== undefined && dataUser['userData']['id'] === sujet["user"].id && isPopupOpen ? <PutPostForm data={sujet} onClose={() => togglePopup()}/> : ""}
      {dataUser['userData'] !== null && dataUser['userData'] !== undefined && dataUser['userData']['id'] === sujet["user"].id && !isPopupOpen ? <div onClick={() => togglePopup()}>  <FontAwesomeIcon icon={faPen}/></div>: ""}
              </div>
              <div className="forum_name_avatar">
                <img src={getAvatar(sujet["user"].id)} className="image_forum"/>
                <p className="forum_name">{`${sujet["user"].lastname} ${sujet["user"].firstname}`}</p>
              </div>
              <div className="right_on_forum">
                <p className="date_forum">{moment(sujet.date).format('DD/MM/YYYY HH:mm:ss')}</p>
              </div>
            </div>
            <div className="text_forum">
                <hr/>
                {sujet.texte}
                </div>
          </div>
        ))
      );
    }
  }, [data]);

  const [isPopupOpen, setIsPopupOpen] = useState(true);
  const togglePopup = () => setIsPopupOpen(!isPopupOpen);

  return (
    <div>
      <div className="post_button">
        <Link href="/sujets">
          <button className="post_button_repondre">
            Retour à la liste des sujets
          </button>
        </Link>
      </div>
      <h1 className="titreSujet">{data["data"] != null ? `Sujet : ${data["data"].intitule_sujet}` : ""}</h1>
      {sujetData}
      {dataUser['userData'] === null || dataUser['userData'] === undefined ? "" : <PostForm sujets = {data["data"]} />}
    </div>
  );
}

export default SujetsDetail;