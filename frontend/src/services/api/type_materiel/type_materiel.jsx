export const BASE_URL = "https://localhost:8000";

export function fetchTypeMaterielById(id)
{
    return fetch(`${BASE_URL}/api/type_materiels/${id}`).then((response) => response.json());
}

export function fetchPostTypeMateriel(materiel)
{
    return fetch(`${BASE_URL}/api/type_materiels`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(materiel),
        credentials: 'include'
    }).then(response => {
        if (response.ok) {
            window.location.replace(materiel.fournisseurs[0].substring(4));
            return response.json();
        }  else {
            return Promise.reject(response);
        }
    })
}

export function deleteTypeMateriel(typeMaterielId, fournisseurId) {
    return fetch(`${BASE_URL}/api/type_materiels/${typeMaterielId}`, {
        method: 'DELETE',
        credentials: 'include',
    }).then(response => {
        if (response.ok) {
            window.location.replace("/fournisseurs/" + fournisseurId);
            return response.json();
        }  else {
            return Promise.reject(response);
        }
    });
}

export function fetchPutTypeMateriel(materiel, materielId, fournisseurId) {
    return fetch(`${BASE_URL}/api/type_materiels/${materielId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(materiel),
        credentials: 'include',
    }).then(response => {
        if (response.ok) {
            window.location.replace("/fournisseurs/" + fournisseurId);
            return response.json();
        } else {
            return Promise.reject(response);
        }
    });
}