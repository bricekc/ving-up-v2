export const BASE_URL = "https://localhost:8000/api";

export function fetchAllRubriques(urlSearchParams=null)
{
    return fetch(`${BASE_URL}/rubriques?page=${urlSearchParams.toString()}`).then((response) => response.json());
}

export function fetchRubriqueFile(fileId)
{
    return fetch(`${BASE_URL}/rubriques/${fileId}/file`).then( response => {
        if (response.ok) {
            return response.blob();
          } else if (response.status === 401) {
            return Promise.resolve(null);
          }
        });
}

export function buttonDownload(fileId) {
    fetchRubriqueFile(fileId).then((blob) => {
      const url = window.URL.createObjectURL(blob);
      const link = document.createElement('a');
      link.href = url;
      link.setAttribute('download', 'rubrique_file');
      document.body.appendChild(link);
      link.click();
    });
  }

  export function deleteRubrique(rubriqueId) {
    return fetch(`${BASE_URL}/rubriques/${rubriqueId}`, {
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

export function postRubrique(data) {
    return fetch(`${BASE_URL}/rubriques`, {
      method: 'POST',
      body: data,
      credentials: 'include'
    }).then(response => {
      if (response.ok) {
          window.location.reload();
      }  else {
          return Promise.reject(response);
      }
  });
  }