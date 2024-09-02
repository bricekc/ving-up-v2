import React, { useCallback, useContext, useEffect, useState } from "react";
import { fetchAllRubriques, buttonDownload } from "../../services/api/rubrique/rubriques";
import RubriqueItem from "./RubriqueItem";
import UserContext from "../../contexts/user";
import Loading from "../sujet/Loading";
import RubriqueForm from "./RubriqueForm";
import Pagination from "./Pagination";

function RubriqueList()
{
    const [rubriquesData, setRubriquesData] = useState([]);
    const [rubriquesList, setRubriquesList] = useState([]);
    const [loading, setLoading] = useState(undefined);
    const dataUser = useContext(UserContext);
    const [isPopupOpen, setIsPopupOpen] = useState(true);
    const togglePopup = () => setIsPopupOpen(!isPopupOpen);
    const [rubriquesPagination, setRubriquesPagination] = useState({});

    const fetchRubriques = useCallback((page = 1) => {
        setLoading(true),
        setRubriquesList([]),
        fetchAllRubriques(page).then((response) => {
            setRubriquesData(response['hydra:member'],
            setRubriquesPagination(response["hydra:view"])
            );
            setLoading(false);
        })
    }, []);
    useEffect(() => {
        fetchRubriques();
    }, [fetchRubriques]);
    useEffect(() => {
        setRubriquesList(rubriquesData.map((rubrique) => {
            return RubriqueItem(rubrique, dataUser);
        }))
    }, [rubriquesData]);
    return (
        <>
        <h1 className="rubrique_titre">Espace Documentaire</h1>
        {dataUser['userData'] !== null && dataUser['userData'] !== undefined && dataUser['userData']['@type'] === 'Admin' ? <RubriqueForm onClose={() => togglePopup()}/> : ""}
        <div className="documentaire">
            <h2 className="rubrique_liste">Liste des Rubriques</h2>
            {loading ? Loading() : rubriquesList}
        </div>
        <Pagination pagination={rubriquesPagination} fetchAllRubriques={fetchAllRubriques} />
        </>
    );
}

export default RubriqueList;