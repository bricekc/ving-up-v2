import React, { useEffect } from "react";

function Home() {
    useEffect(() => {
        // Charger le SDK Facebook
        (function (d, s, id) {
          var js,
            fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s);
          js.id = id;
          js.src = "https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v16.0";
          js.async = true;
          js.defer = true;
          fjs.parentNode.insertBefore(js, fjs);
        })(document, "script", "facebook-jssdk");
      }, []);
  return (
    <div className="home-page">
      <div className="home-page-content home_container_post">
        <h1>Bienvenue sur Vign'Up</h1>
        <div>
          <h2>Le contexte de Vign'Up</h2>
          <p>
            En 2021, un nouveau brevet a été déposé pour le champagne. Désormais, tout vigneron possédant des vignes semi-larges peut conserver l'appellation champagne pour la boisson qu'il produit. Cette décision a plusieurs conséquences, comme la réduction de 30% de l'empreinte carbone de la vigne, mais également une perte de rendement qui ne peut être négligée pour les vignerons.
          </p>
          <p>
            La transition d'une vigne classique à une vigne semi-large est donc une décision importante pour les viticulteurs, qui doivent effectuer des calculs rigoureux et réfléchir à l'impact que cela aura sur leur production. C'est dans ce contexte que l'association Vign'Up est née, dans le but d'aider les viticulteurs à s'adapter à cette nouvelle norme tout en leur fournissant les informations dont ils ont besoin pour prendre les meilleures décisions.
          </p>
          <br></br>
          <img src="img/VignePhoto.jpg" className="photoVigne"/>
        </div>
      </div>
      <div className="home-page-facebook">
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v16.0" nonce="GMNqQUWG"></script>
        <div class="fb-page" data-href="https://www.facebook.com/chambresagriculturevignoblechampenois/" data-tabs="timeline" data-width="500" data-height="800" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false">
          <blockquote cite="https://www.facebook.com/chambresagriculturevignoblechampenois/" class="fb-xfbml-parse-ignore">
            <a href="https://www.facebook.com/chambresagriculturevignoblechampenois/">Chambres d&#039;agriculture du vignoble champenois</a>
          </blockquote>
        </div>
      </div>
    </div>
  );
}

export default Home;