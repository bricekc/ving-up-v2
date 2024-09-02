import React, { useContext } from "react"; 
import { Link } from "wouter";
import UserContext from "../../contexts/user";
import Loading from "../sujet/Loading";

function MobileNav({ navRef, toggleMenu  }) {
  const dataUser = useContext(UserContext);

  return (
    <nav ref={navRef} className="mobile-nav">
      <img className="logo" src="/img/logo.png" alt="Image du logo de Vign'up" />
      <Link className="navbar_lien" href="/" onClick={toggleMenu}>Fil d'actualité</Link>
      <Link className="navbar_lien" href="#" onClick={toggleMenu}>Carte</Link>
      <Link className="navbar_lien" href="/fournisseurs" onClick={toggleMenu}>Fournisseur & Préstataire</Link>
      <Link className="navbar_lien" href="/rubriques" onClick={toggleMenu}>Documentation</Link>
      <Link className="navbar_lien" href="/questionnaires" onClick={toggleMenu}>Auto-évaluation</Link>
      <Link className="navbar_lien" href="/sujets" onClick={toggleMenu}>Forum</Link>
      {
        dataUser['userData'] === undefined
          ? <Loading />
          : dataUser['userData'] === null
            ? <a className="navbar_lien" href="https://localhost:8000/login">Se connecter</a>
            : <a className="navbar_lien" href={`/user/${dataUser['userData']['id']}`}>{dataUser['userData']['firstname']}</a>
      }
    </nav>
  );
}

export default MobileNav;