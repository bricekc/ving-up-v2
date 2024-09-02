import React, { useState } from 'react';
import { postSujet } from '../../services/api/sujet/sujets';

function SujetForm() {
  const [intituleSujet, setIntituleSujet] = useState('');

  const submitForm = (event) => {
    event.preventDefault();

    const data = { intituleSujet };

    postSujet(data);
  }

  return (
    <form onSubmit={submitForm} >
      <label htmlFor="nom">Intitule du sujet :</label>
      <input type="text" id="intitule" name="intitule" value={intituleSujet} onChange={e => setIntituleSujet(e.target.value)} className='post_champs_texte'/>
      <button type="submit" className='user_button_submit'>Envoyer</button>
    </form>
  );
}

export default SujetForm;