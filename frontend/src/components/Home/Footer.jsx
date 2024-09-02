import React from 'react';
import './footer.css'
import { faFacebookSquare, faTwitterSquare, faYoutubeSquare, } from '@fortawesome/free-brands-svg-icons';
import { faGlobe } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

function Footer() {
  return (
    <footer>
      <div className="footer-content">
        <h3>Vign'Up</h3>
        <p></p>
        <div className="social-media">
          <a href="https://www.facebook.com/chambresagriculturevignoblechampenois/"><FontAwesomeIcon icon={faFacebookSquare} /></a>
          <a href="https://twitter.com/ChambreAgri51"><FontAwesomeIcon icon={faTwitterSquare} /></a>
          <a href="https://www.youtube.com/@chambresdagricultureduvign4044/featured"><FontAwesomeIcon icon={faYoutubeSquare} /></a>
          <a href="https://vignoble-champenois.chambres-agriculture.fr/"><FontAwesomeIcon icon={faGlobe} /></a>
        </div>
      </div>
    </footer>
  );
}

export default Footer;