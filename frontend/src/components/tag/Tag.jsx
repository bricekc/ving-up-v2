import React from "react";

function Tag(tag) {

    return (
        <span className="materiel_item"> - {tag !== null ? tag['tag'].nom : ""}</span>
    );
}

export default Tag;