export const BASE_URL = "https://localhost:8000/api";

export function fetchAllFournisseurs(urlSearchParams = null)
{
    return fetch(`${BASE_URL}/fournisseurs?page=${urlSearchParams.toString()}`).then((response) => response.json());
}

export function fetchFournisseurById(id) {
    return fetch(`${BASE_URL}/fournisseurs/${id}`).then((response) => {
        if (response.ok) {
            return response.json();
        } else if (response.status === 401) {
            return Promise.resolve(null);
        }
    });
}