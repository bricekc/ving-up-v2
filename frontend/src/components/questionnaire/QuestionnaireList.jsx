import React, { useEffect, useState } from "react";
import { useLocation } from "wouter";
import { fetchAllQuestionnaires } from "../../services/api/questionnaire/questionnaires";

function QuestionnaireList({onQuestionnaireClick}) {
    const [questionnaires, setQuestionnaires] = useState([]);
  
    useEffect(() => {
      fetchAllQuestionnaires().then((data) => {
        setQuestionnaires(data);
      });
    }, []);
  
    return (
        <div>
            <ul>
          {questionnaires.map((questionnaire) => {
            const id = questionnaire["@id"].split("/").pop();
            return (
              <a
                key={id}
                className="BoxQuestionnaire"
                href={`/questionnaires/${id}`}
                onClick={(e) => {
                  e.preventDefault();
                  onQuestionnaireClick(id);
                }}
              >
                <div>
                  <h2>{questionnaire.intitule_questionnaire}</h2>
                </div>
              </a>
            );
          })}
          </ul>
        </div>
      );
    }
  
  export default QuestionnaireList;