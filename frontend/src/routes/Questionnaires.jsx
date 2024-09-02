import React, { useEffect, useState } from "react";
import { Route, Switch, useRoute } from "wouter";
import QuestionnaireList from "../components/questionnaire/QuestionnaireList";
import QuestionnaireForm from "../components/questionnaire/QuestionnaireForm";
import { useLocation } from "wouter";
import { fetchQuestionnaire } from "../services/api/questionnaire/questionnaires";
import NonPublicQuestionnaireResult from "../components/questionnaire/NonPublicQuestionnaireResult";

function Questionnaires() {
  const [match, params] = useRoute("/questionnaires/:questionnaireId?");
  const [questionnaire, setQuestionnaire] = useState(null);
  const [location, setLocation] = useLocation();

  useEffect(() => {
    setQuestionnaire(undefined);
    if (params?.questionnaireId && !isNaN(parseInt(params.questionnaireId))) {
      fetchQuestionnaire(params.questionnaireId).then((response) => {
        setQuestionnaire(response);
      });
    }
  }, [params?.questionnaireId]);

  const handleQuestionnaireClick = (questionnaireId) => {
    setLocation(`/questionnaires/${questionnaireId}`);
  };

  return (
    <Switch>
      <Route path="/questionnaires">
        <QuestionnaireList onQuestionnaireClick={handleQuestionnaireClick} />
      </Route>
      <Route path="/questionnaires/:questionnaireId">
        <QuestionnaireForm questionnaire={questionnaire}/>
      </Route>
      <Route path="/questionnaires/:questionnaireId/results/:userId">
        <NonPublicQuestionnaireResult />
      </Route>
      <Route>
        <QuestionnaireList onQuestionnaireClick={handleQuestionnaireClick} />
      </Route>
    </Switch>
  );
}

export default Questionnaires;