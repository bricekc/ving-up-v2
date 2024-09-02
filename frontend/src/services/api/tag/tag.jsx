export const BASE_URL = "https://localhost:8000";

export function fetchTagByLink(lien)
{
    return fetch(`${BASE_URL}${lien}`).then((response) => response.json());
}

export function fetchAllTags()
{
    return fetch(`${BASE_URL}/api/tags`).then((response) => response.json());
}