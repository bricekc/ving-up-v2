import React from 'react'
import { Redirect, Route, Switch } from 'wouter'
import './App.css'
import SujetList from './components/sujet/SujetsList'
import 'bootstrap/dist/css/bootstrap.min.css';
import Sujets from './routes/Sujets';
import Questionnaires from './routes/Questionnaires';
import Header from './components/Home/Header';
import Footer from './components/Home/Footer';
import UserProvider from './contexts/user/Provider';
import User from './routes/User';
import RubriqueList from './components/rubrique/RubriqueList';
import Fournisseurs from "./routes/Fournisseurs.jsx";
import TypeMateriel from "./routes/TypeMateriel.jsx";
import TypeService from "./routes/TypeService.jsx";
import Carte from "./components/carte/carte";
import Erreur404 from './components/404/Erreur404';
import Home from './components/Home/Home';
import Inscription from './routes/Inscription';


function App() {
  return (
    <React.Fragment>
    <UserProvider>
      <Header/>
      <Switch>
        <Route path="/home">
          <Home/>
        </Route>
        <Route path="/fournisseurs/:fournisseurId*">
          <Fournisseurs />
        </Route>
        <Route path="/typeMateriel/:sub*">
          <TypeMateriel />
        </Route>
        <Route path="/typeService/:sub*">
          <TypeService />
        </Route>
        <Route path="/questionnaires/:questionnaireId*">
          <Questionnaires/>
        </Route>
        <Route path="/">
          <Redirect to="/home"/>
        </Route>
        <Route path="/sujets/:sub*">
          <Sujets/>
        </Route>
        <Route path='/user/:sub*'>
          <User />
        </Route>
        <Route path="/rubriques">
          <RubriqueList/>
        </Route>
        <Route path="/cartes">
          <Carte/>
        </Route>
        <Route path="/inscription/:userType*">
          <Inscription />
        </Route>
        <Route>
          <Erreur404 />
        </Route>
      </Switch>
      <Footer/>
    </UserProvider>
    </React.Fragment>
  )
}

export default App
