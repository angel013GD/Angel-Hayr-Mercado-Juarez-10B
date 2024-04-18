import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import App from './App';
import * as serviceWorkerRegistration from './serviceWorkerRegistration';
import reportWebVitals from './reportWebVitals';

import Login from './Pages/login/login';
import Configuracion  from './Pages/configuracion/configuracion';
import UsuarioDatos from './Pages/usuario/usuarioDatos';
import RegistroIncidencia from './Pages/RegistrarIncidencia/registroIncidencia'


import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';

const root = ReactDOM.createRoot(
  document.getElementById('root') as HTMLElement
);

root.render(
  <React.StrictMode>
    <Router>
      <Routes>
        <Route path="/" element={<App />} />
        <Route path="/login" element={<Login />} />
        <Route path="/configuracion" element={<Configuracion />} />
        <Route path="/usuarioDatos" element={<UsuarioDatos />} />
        <Route path="/registroIncidencia" element={<RegistroIncidencia />} />

      </Routes>
    </Router>
  </React.StrictMode>
);

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://cra.link/PWA
serviceWorkerRegistration.unregister();

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
