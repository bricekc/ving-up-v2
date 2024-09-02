import React, { useState } from "react";
import { postPost } from "../../services/api/sujet/sujets";
import { Editor } from "@tinymce/tinymce-react";

function PostForm(sujets) {
  const [texte, setTexte] = useState("");

  const submitForm = (event) => {
    event.preventDefault();
    const sujet = "/api/sujets/" + sujets["sujets"].id;
    const data = { sujet, texte };

    postPost(data);
  };

  return (
    <form onSubmit={submitForm}>
      <label htmlFor="texte">Texte du post :</label>
      <Editor
        initialValue={texte}
        apiKey="jtxfklru3at4mdbze5qvy4yyls5y8ymbla5l28phaxish19j"
        init={{
          height: 150,
          menubar: false,
          toolbar: false,
          setup: (editor) => {
            editor.on("change", () => {
              setTexte(editor.getContent({ format: "text" }));
            });
          },
          forced_root_block: false,
          force_p_newlines: false,
        }}
      />
      <button type="submit" className="user_button_submit">Envoyer</button>
    </form>
  );
}

export default PostForm;