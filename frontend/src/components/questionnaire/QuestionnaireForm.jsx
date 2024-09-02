import React, { useState, useEffect } from "react";
import { getResultatQuestionnaire, submitResultatQuestionnaire } from "../../services/api/questionnaire/questionnaires";
import { getMe } from "../../services/api/user/user";
import QuestionnaireResult from "./QuestionnaireResult";
import NonPublicQuestionnaireResult from "./NonPublicQuestionnaireResult";


function QuestionnaireForm({ questionnaire, onSubmit = () => {}}) {
  if (!questionnaire) {
    return <p>Chargement du questionnaire...</p>;
  }
  const [totalScore, setTotalScore] = useState(null);
  const [matchingComment, setMatchingComment] = useState(null);
  const [selectedAnswers, setSelectedAnswers] = React.useState({});
  const handleOptionChange = (questionId, choice) => {
    setSelectedAnswers((prevSelectedAnswers) => ({
      ...prevSelectedAnswers,
      [questionId]: choice,
    }));
  };
  const [showResults, setShowResults] = useState(false);
  const [viticulteurId, setViticulteurId] = useState(null);

  useEffect(() => {
    async function fetchViticulteurId() {
      const viticulteur = await getMe();
      setViticulteurId(viticulteur.id);
    }
  
    fetchViticulteurId();
  }, []);

const handleResults = (totalScore, matchingComment) => {
  setShowResults(true);
  if (questionnaire.public) {
    setTotalScore(totalScore);
    setMatchingComment(matchingComment);
  }
};
const handleSubmit = async (e) => {
  e.preventDefault();

  const totalScore = Object.values(selectedAnswers).reduce(
    (sum, answer) => sum + answer.note,
    0
  );

  const matchingComment = questionnaire.commentaires.find((comment) => {
    const minNote = Math.min(...comment.notes);
    const maxNote = Math.max(...comment.notes);
    return totalScore >= minNote && totalScore <= maxNote;
  });

  if (!questionnaire.public) {
    const extractedQuestionnaireId = questionnaire['@id'].split('/').pop();
    console.log(viticulteurId)
    const existingResultats = await getResultatQuestionnaire(viticulteurId);
    console.log(existingResultats)
    const existingResultat = existingResultats.questionnaire === questionnaire['@id'] ?
    existingResultats :
    null;
    const resultatQuestionnaireId = existingResultats.id
    console.log(resultatQuestionnaireId)
    await submitResultatQuestionnaire(viticulteurId, resultatQuestionnaireId, extractedQuestionnaireId, Object.values(selectedAnswers));
  } else {
    onSubmit(Object.values(selectedAnswers));
  }

  handleResults(totalScore, matchingComment);
};

  return (
      <div>
        {showResults && questionnaire.public ? (
          <QuestionnaireResult
            questionnaireId={questionnaire.id}
            totalScore={totalScore}
            matchingComment={matchingComment}
          />
        ) : showResults && !questionnaire.public ? (
          <NonPublicQuestionnaireResult
            questionnaire={questionnaire}
            userAnswers={Object.values(selectedAnswers)}
          />
        ) : (
    <div>
      <h1 className="titreQuestionnaireTous">{questionnaire.intitule_questionnaire}</h1>
      <div className="QuestionnaireFormulaire">
      <form name="questionnaire" method="post" onSubmit={handleSubmit}>
        {questionnaire.public
          ? questionnaire.questions.map((question) => (
              // Affichage pour les questionnaires publics
              <div className="QuestionTous" key={question.id}>
                <div>
                  <label className="QuestionQuestionnaire required">
                    {question.intitule_question}
                  </label>
                  <div id={`questionnaire_question_${question.id}`}>
                    {question.choices.map((choice) => (
                      <React.Fragment key={choice.id}><br></br>
                        <input
                          type="radio"
                          id={`questionnaire_question_${question.id}_${choice.id}`}
                          name={`questionnaire[question_${question.id}]`}
                          required
                          value={choice.id}
                          onChange={() => handleOptionChange(question.id, choice)}
                        />
                        <label
                          htmlFor={`questionnaire_question_${question.id}_${choice.id}`}
                          className="required"
                        >
                          {choice.reponse}
                        </label>
                      </React.Fragment>
                    ))}
                  </div>
                </div>
              </div>
            ))
          : questionnaire.thematiques.map((thematique) => (
              // Affichage pour les questionnaires non publics
              <div key={thematique.id}>
                <h3>Theme : {thematique.NomThematique}</h3>
                <br></br>
                {thematique.questions.map((question) => (
                  <div className="QuestionTous" key={question.id}>
                    <div>
                      <label className="QuestionQuestionnaire required">
                        {question.intitule_question}
                      </label>
                      <div id={`questionnaire_question_${question.id}`}>
                        {question.reponses.map((reponse) => (
                          <React.Fragment key={reponse.id}><br></br>
                            <input
                              type="radio"
                              id={`questionnaire_question_${question.id}_${reponse.id}`}
                              name={`questionnaire[question_${question.id}]`}
                              required
                              value={reponse.id}
                              onChange={() => handleOptionChange(question.id, reponse)}
                            />
                            <label
                              htmlFor={`questionnaire_question_${question.id}_${reponse.id}`}
                              className="required"
                            >
                              {reponse.reponse}
                            </label>
                          </React.Fragment>
                        ))}
                      </div>
                    </div>
                  </div>
                ))}
                <hr></hr>
              </div>
            ))}
        <button type="submit" className="btn btn-primary btn-submit-questionnaire">
          Envoyer
        </button>
      </form>
      </div>
    </div>
  )}
  </div>
);
                        }

export default QuestionnaireForm;