import React from "react";

function QuestionnaireResult({ questionnaireId, totalScore, matchingComment }) {
  return (
    <div>
      <h1 className="titreQuestionnaireTous">Résultats du questionnaire {questionnaireId}</h1>
      <div className="QuestionnaireFormulaire">
      <h2 className="Score">Score total: {totalScore}</h2>
      <div className="Commentaire">
      <p>Commentaire correspondant: {matchingComment?.commentaire}</p>
      </div>
      </div>
    </div>
  );
}

export default QuestionnaireResult;