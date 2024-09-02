import React from 'react';
import paginationFromHydraView from '../../services/transformers/paginationFromHydraView';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faAngleDoubleLeft, faAngleLeft, faAngleRight, faAngleDoubleRight } from '@fortawesome/free-solid-svg-icons';

function Pagination({pagination, fetchFournisseur}) {
    const pagine = paginationFromHydraView(pagination);
    if (pagine === undefined)
    {
        return (<div className="pagination justify-content-center">
            <button className="btn btn-success" disabled={true}><FontAwesomeIcon icon={faAngleDoubleLeft} /></button>
            <button className="btn btn-success mx-1" disabled={true}><FontAwesomeIcon icon={faAngleLeft} /></button>
            <button className="btn btn-outline-success mx-1" disabled>1</button>
            <button className="btn btn-success mx-1" disabled={true}><FontAwesomeIcon icon={faAngleRight} /></button>
            <button className="btn btn-success" disabled={true}><FontAwesomeIcon icon={faAngleDoubleRight} /></button>
        </div>);
    } else {
        return (
            <div className="pagination justify-content-center">
                <button className="btn btn-success" disabled={!pagine.first} onClick={() => fetchFournisseur(pagine.first)}>
                    <FontAwesomeIcon icon={faAngleDoubleLeft} />
                </button>
                <button className="btn btn-success mx-1" disabled={!pagine.previous} onClick={() => fetchFournisseur(pagine.previous)}>
                    <FontAwesomeIcon icon={faAngleLeft} />
                </button>
                <button className="btn btn-outline-success mx-1" disabled>
                    {pagine.current}
                </button>
                <button className="btn btn-success mx-1" disabled={!pagine.next} onClick={() => fetchFournisseur(pagine.next)}>
                    <FontAwesomeIcon icon={faAngleRight} />
                </button>
                <button className="btn btn-success" disabled={!pagine.last} onClick={() => fetchFournisseur(pagine.last)}>
                    <FontAwesomeIcon icon={faAngleDoubleRight} />
                </button>
            </div>
        );
    }
}

export default Pagination;