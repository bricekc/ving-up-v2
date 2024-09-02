import React, {useEffect, useState, useCallback, useContext} from "react";
import { fetchAllSujets } from "../../services/api/sujet/sujets";
import SujetItem from "./SujetItem";
import Pagination from "./Pagination";
import Loading from "./Loading";
import SujetForm from "./SujetForm";
import UserContext from "../../contexts/user";

function SujetList()
{
    const [sujetsData, setSujetsData] = useState([]);
    const [sujetsList, setSujetsList] = useState([]);
    const [sujetsPagination, setSujetsPagination] = useState({});
    const [loading, setLoading] = useState(undefined);
    const dataUser = useContext(UserContext);

    const fetchSujets = useCallback((page = 1) => {
        setLoading(true),
        setSujetsList([]),
        fetchAllSujets(page).then((response) => {
            setSujetsData(response['hydra:member'],
            setSujetsPagination(response["hydra:view"])
            );
            setLoading(false);
        })
    }, []);
    useEffect(() => {
        fetchSujets();
    }, [fetchSujets]);
    useEffect(() => {
        setSujetsList(sujetsData.map((sujet) => {
            return SujetItem(sujet, dataUser);
        }))
    }, [sujetsData]);
    return (
        <div>
        <div className="sujets_on_top">
            <h1 className="titreSujet">
                Forum
            </h1>
        </div>
        <hr/>
        <br/>
        <div className="liste_sujet">
            <div className="sujet">
                <h2>
                    Sujet
                </h2>
            </div>
            {loading ? Loading() : sujetsList}
        </div>
        <Pagination pagination={sujetsPagination} fetchSujets={fetchSujets} />
        {dataUser['userData'] === null || dataUser['userData'] === undefined ? "" : <SujetForm />}
        </div>
    );
}

export default SujetList;