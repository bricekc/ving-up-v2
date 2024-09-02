import React from "react";
import Spinner from 'react-bootstrap/Spinner';

function LoadingFournisseur()
{
    return (
        <div className="d-flex justify-content-center align-items-center">
            <Spinner animation="border" />
        </div>
    );
}

export default LoadingFournisseur;