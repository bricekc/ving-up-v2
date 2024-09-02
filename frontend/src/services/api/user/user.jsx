import { useIsRTL } from "react-bootstrap/esm/ThemeProvider";

export const BASE_URL = "https://localhost:8000/api";

export function getMe()
{
    return fetch(`${BASE_URL}/me`, {credentials: "include"}).then((response) => {
        if (response.ok) {
        return response.json();
      } else if (response.status === 401) {
        return Promise.resolve(null);
      }});
}

export function getUser(userId)
{
  return fetch(`${BASE_URL}/users/${userId}`).then((response) => {
    if (response.ok) {
      return response.json();
    } else if (response.status === 401) {
      return Promise.resolve(null);
    }
  });
}

export function getAvatar(userId)
{
  return `${BASE_URL}/users/${userId}/avatar`;
}

export function putUser(userId, data) {
  return fetch(`${BASE_URL}/users/${userId}`, {
    method: 'PUT', 
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(data),
    credentials: 'include',
  }).then(response => {
    if (response.ok) {
        window.location.replace(`/user/profil/${userId}`);
        return response.json();
    } else {
        return Promise.reject(response);
    }
});
}

export function putViticulteur(userId, data) {
  return fetch(`${BASE_URL}/viticulteurs/${userId}`, {
    method: 'PUT', 
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(data),
    credentials: 'include',
  }).then(response => {
    if (response.ok) {
        window.location.replace(`/user/profil/${userId}`);
        return response.json();
    } else {
        return Promise.reject(response);
    }
});
}

export function postViticulteur(dataViti) {
  return fetch(`${BASE_URL}/viticulteurs`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(dataViti),
    credentials: 'include'
  }).then(response => {
    if (response.ok) {
        window.location.replace(`https://localhost:8000/login`);
        return response.json();
    } else {
        return Promise.reject(response);
    }
});
}

export function postFournisseur(dataFour) {
  return fetch(`${BASE_URL}/fournisseurs`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(dataFour),
    credentials: 'include'
  }).then(response => {
    if (response.ok) {
        window.location.replace(`https://localhost:8000/login`);
        return response.json();
    } else {
        return Promise.reject(response);
    }
});
}