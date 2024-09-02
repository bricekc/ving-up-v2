import React from "react";

function NonPublicQuestionnaireResult({ questionnaire, userAnswers }) {
  if (!questionnaire) {
    return <p>Chargement du résultat du questionnaire...</p>;
  }

  let answerIndex = 0;

  return (
    <div>
      <h1 className="titreQuestionnaireTous" >Résultats du questionnaire</h1>
      <h2 className="Score">
        Note globale : {userAnswers.reduce((sum, answer) => sum + answer.note, 0)}
      </h2>
      <div className="questionnaire">
      {questionnaire.thematiques.map((thematique) => {
        let thematiqueScore = 0;

        const questions = thematique.questions.map((question, questionIndex) => {
          const userAnswer = userAnswers[answerIndex + questionIndex];
          thematiqueScore += userAnswer.note;

          return (
            <div key={question.id}>
              <div className="Recap">
                <strong><h4>{question.intitule_question}</h4></strong>
                <p>Réponse de l'utilisateur : {userAnswer.reponse}</p>
              </div>
              <p className="Commentaire">
                {userAnswer.commentaire
                  ? `Commentaire : ${userAnswer.commentaire.commentaire}`
                  : ""}
              </p>
            </div>
          );
        });

        answerIndex += thematique.questions.length;

        return (
          <div key={thematique.id}>
            <h3 className="ThemeName">Thematique : {thematique.NomThematique}</h3>
            <h4 className="Score">Note Thematique : {thematiqueScore}</h4>
            {questions}
            <hr></hr>
          </div>
        );
      })}
      </div>
    </div>
  );
}

export default NonPublicQuestionnaireResult;
