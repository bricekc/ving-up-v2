export const BASE_URL = "https://localhost:8000/api";

export function fetchAllSujets(urlSearchParams=null)
{
    return fetch(`${BASE_URL}/sujets?page=${urlSearchParams.toString()}`).then((response) => response.json());
}

export function fetchSujet(sujetId)
{
    return fetch(`${BASE_URL}/sujets/${sujetId}`).then((response) => {
        if (response.ok) {
            return response.json();
        } else if (response.status === 401) {
            return Promise.resolve(null);
        }
    });
}

export function postSujet(sujet) {
    return fetch(`${BASE_URL}/sujets`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(sujet),
        credentials: 'include'
    }).then(response => {
        if (response.ok) {
            window.location.reload();
            return response.json();
        }  else {
            return Promise.reject(response);
        }
    });
}

export function deleteSujet(sujetId) {
    return fetch(`${BASE_URL}/sujets/${sujetId}`, {
        method: 'DELETE',
        credentials: 'include',
    }).then(response => {
        if (response.ok) {
            window.location.reload();
            return response.json();
        }  else {
            return Promise.reject(response);
        }
    });
}

export function postPost(post) {
    return fetch(`${BASE_URL}/posts`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(post),
        credentials: 'include',
    }).then(response => {
        if (response.ok) {
            window.location.reload();
            return response.json();
        }  else {
            return Promise.reject(response);
        }
    });
}

export function deletePost(postId) {
    return fetch(`${BASE_URL}/posts/${postId}`, {
        method: 'DELETE',
        credentials: 'include',
    }).then(response => {
        if (response.ok) {
            window.location.reload();
            return response.json();
        }  else {
            return Promise.reject(response);
        }
    });
}

export function putPost(postId, data) {
    return fetch(`${BASE_URL}/posts/${postId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data),
        credentials: 'include',
    }).then(response => {
        if (response.ok) {
            window.location.reload();
            return response.json();
        } else {
            return Promise.reject(response);
        }
    });
}