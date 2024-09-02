import React from 'react';
import paginationFromHydraView from '../../services/transformers/paginationFromHydraView';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faAngleDoubleLeft, faAngleLeft, faAngleRight, faAngleDoubleRight } from '@fortawesome/free-solid-svg-icons';

function Pagination({pagination, fetchAllRubriques}) {
  const pag = paginationFromHydraView(pagination);
  if (pag == undefined)
  {
    return (<div className="pagination justify-content-center">
        <button className="btn btn-success" disabled={true}><FontAwesomeIcon icon={faAngleDoubleLeft} /></button>
        <button className="btn btn-success mx-1" disabled={true}><FontAwesomeIcon icon={faAngleLeft} /></button>
        <button className="btn btn-outline-success mx-1" disabled>1</button>
        <button className="btn btn-success mx-1" disabled={true}><FontAwesomeIcon icon={faAngleRight} /></button>
        <button className="btn btn-success" disabled={true}><FontAwesomeIcon icon={faAngleDoubleRight} /></button>
      </div>);
  }
  else
  {
    return (
      <div className="pagination justify-content-center">
        <button className="btn btn-success" disabled={!pag.first} onClick={() => fetchAllRubriques(pag.first)}>
          <FontAwesomeIcon icon={faAngleDoubleLeft} />
        </button>
        <button className="btn btn-success mx-1" disabled={!pag.previous} onClick={() => fetchAllRubriques(pag.previous)}>
          <FontAwesomeIcon icon={faAngleLeft} />
        </button>
        <button className="btn btn-outline-success mx-1" disabled>
          {pag.current}
        </button>
        <button className="btn btn-success mx-1" disabled={!pag.next} onClick={() => fetchAllRubriques(pag.next)}>
          <FontAwesomeIcon icon={faAngleRight} />
        </button>
        <button className="btn btn-success" disabled={!pag.last} onClick={() => fetchAllRubriques(pag.last)}>
          <FontAwesomeIcon icon={faAngleDoubleRight} />
        </button>
      </div>
    );
  }
}

export default Pagination;