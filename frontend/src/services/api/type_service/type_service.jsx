export const BASE_URL = "https://localhost:8000";

export function fetchTypeServiceById(id)
{
    return fetch(`${BASE_URL}/api/type_services/${id}`).then((response) => response.json());
}

export function fetchPostTypeService(service)
{
    return fetch(`${BASE_URL}/api/type_services`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(service),
        credentials: 'include'
    }).then(response => {
        if (response.ok) {
            window.location.replace(service.fournisseurs[0].substring(4));
            return response.json();
        }  else {
            return Promise.reject(response);
        }
    })
}

export function deleteTypeService(typeServiceId, fournisseurId) {
    return fetch(`${BASE_URL}/api/type_services/${typeServiceId}`, {
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

export function fetchPutTypeService(service, serviceId, fournisseurId) {
    return fetch(`${BASE_URL}/api/type_services/${serviceId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(service),
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