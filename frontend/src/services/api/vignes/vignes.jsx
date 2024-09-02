export const BASE_URL = "https://localhost:8000/api";



    export function getvigne(vigneid)
    {
        return fetch(`${BASE_URL}/vignes/${vigneid}`).then(response => response.json());
    }

    export function getAllVignes()
    {
        return fetch(`${BASE_URL}/vignes`).then(response => response.json())
    }