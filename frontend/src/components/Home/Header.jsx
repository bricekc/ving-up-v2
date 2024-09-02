import React, {useContext, useEffect, useRef} from "react";
import { Link } from "wouter";
import UserContext from "../../contexts/user";
import Loading from "../sujet/Loading";
import MobileNav from "./MobileNav";

function Header() {
  const dataUser = useContext(UserContext);
  const menuBtn = useRef(null);
  const mobileMenu = useRef(null);
  const toggleMenu = () => {
    menuBtn.current.classList.toggle("is-active");
    mobileMenu.current.classList.toggle("is-active");
  };
  useEffect(() => {
        menuBtn.current.addEventListener("click", toggleMenu);
    return () => menuBtn.current.removeEventListener("click", toggleMenu);
  }, []);

  return (
    <>
    <nav className="navigation">
    <button ref={menuBtn} className="hamburger" type="button">
        <span className="bar"></span>
        <span className="bar"></span>
        <span className="bar"></span>
      </button>
      <ul>
        <li className="navbar_lien">
          <Link className="navbar_lien" href="/">
            <img className="logo" src="/img/logo.png" alt="Image du logo de Vign'up" />
          </Link>
        </li>
        <li>
          <Link className="navbar_lien" href="#">Carte</Link>
        </li>
        <li>
          <Link className="navbar_lien" href="/fournisseurs">Fournisseur & Préstataire</Link>
        </li>
        <li>
          <Link className="navbar_lien" href="/rubriques">Documentation</Link>
        </li>
        <li>
          <Link className="navbar_lien" href="/questionnaires">Auto-évaluation</Link>
        </li>
        <li>
          <Link className="navbar_lien" href="/sujets">Forum</Link>
        </li>
        <li>
          {
            dataUser['userData'] === undefined ? <Loading/> : dataUser['userData'] === null ? <a className="navbar_lien" href="https://localhost:8000/login">Se connecter</a> : <a className="navbar_lien" href={`/user/profil/${dataUser['userData']['id']}`}>{dataUser['userData']['firstname']}</a>
          }
        </li>
          {
            dataUser['userData'] === undefined ? <Loading/> : dataUser['userData'] === null ? <li><Link className="navbar_lien" href="/inscription/viticulteur">S'inscrire</Link></li> : null
          }
      </ul>
    </nav>
    <MobileNav navRef={mobileMenu} toggleMenu={toggleMenu}   />
    </>
  );
}

export default Header;