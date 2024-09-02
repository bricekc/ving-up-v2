export const BASE_URL = "https://localhost:8000/api";

export function fetchAllQuestionnaires(urlSearchParams = null) {
  const searchParams = urlSearchParams ? `?page=${urlSearchParams.toString()}` : "";
  return fetch(`${BASE_URL}/questionnaires${searchParams}`)
    .then((response) => response.json())
    .then((data) => (Array.isArray(data["hydra:member"]) ? data["hydra:member"] : []));
}

export function fetchQuestionnaire(questionnaireId) {
  return fetch(`${BASE_URL}/questionnaires/${questionnaireId}`, {credentials:'include'})
    .then((response) => {
      if (response.ok) {
        return response.json();
      } else if (response.status === 401) {
        return Promise.resolve(null);
      }
    })
    .then((data) => {
      if (data) {
        data.questions = data.questions.map((question) => {
          question.choices = question.reponses || [];
          delete question.reponses;
          return question;
        });
      }
      return data;
    });
  }
  export async function submitResultatQuestionnaire(viticulteur, resultatQuestionnaireId, questionnaireId, userAnswers) { 
    if (!viticulteur || !questionnaireId || !userAnswers) {
      console.error("Erreur: données manquantes pour soumettre le résultat du questionnaire.");
      return;
    }
  
    const resultatQuestionnaire = {
      viticulteur: `/api/users/${viticulteur}`,
      questionnaire: `/api/questionnaires/${questionnaireId}`,
      reponses: userAnswers.map(answer => `/api/reponses/${answer.id}`),
      note: calculateNote(userAnswers)
    };
  
    const url = resultatQuestionnaireId ? `${BASE_URL}/resultat_questionnaires/${resultatQuestionnaireId}` : `${BASE_URL}/resultat_questionnaires`; 
    const method = resultatQuestionnaireId ? 'PUT' : 'POST'; 
    console.log('resultatQuestionnaire JSON:', JSON.stringify(resultatQuestionnaire));
    const response = await fetch(url, {
        method,
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(resultatQuestionnaire),
    });
  
    if (!response.ok) {
        console.error('Erreur lors de la soumission du ResultatQuestionnaire:', response);
        return;
    }
  
    console.log('ResultatQuestionnaire soumis avec succès');
  }

function calculateNote(userAnswers) {
    let note = 0;
    userAnswers.forEach(answer => {
        note += answer.note;
    });
    return note;
}

export async function getResultatQuestionnaire(viticulteurId) {
  const response = await fetch(`${BASE_URL}/resultat_questionnaires/user/${viticulteurId}`, {credentials:'include'});
  console.log(response.status)
  if (response.ok) {
    const data = await response.json();
    return data[0];
  } else if (response.status === 404) {
    console.warn('Aucun ResultatQuestionnaire trouvé');
    return [];
  } else {
    console.error('Erreur lors de la récupération des ResultatQuestionnaires:', response);
    return null;
  }
}