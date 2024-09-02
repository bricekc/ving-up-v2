import { buttonDownload, deleteRubrique } from "../../services/api/rubrique/rubriques";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faTrash } from '@fortawesome/free-solid-svg-icons';

function RubriqueItem(data, dataUser)
{
    return (
        <div key={data.id} className="rubrique">
          <div>
            <h2>{data.titre}</h2>
            <p>{data.description}</p>
          </div>
          <div className="rubrique_button">
            <div>
              <button className="rubrique_button_download">
                <a href="#" onClick={() => buttonDownload(data.id)}>
                  Télécharger
                </a>
              </button>
            </div>
            <div>
              {dataUser['userData'] !== null && dataUser['userData'] !== undefined && dataUser['userData']['@type'] === 'Admin' ? <button className="rubrique_button_delete" onClick={() => deleteRubrique(data.id)}>Supprimer</button> : ""}
            </div>
          </div>
        </div>
    )
}

export default RubriqueItem;