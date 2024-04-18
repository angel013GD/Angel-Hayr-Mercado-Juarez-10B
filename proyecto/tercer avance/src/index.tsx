import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import App from './App';
import * as serviceWorkerRegistration from './serviceWorkerRegistration';
import reportWebVitals from './reportWebVitals';

import Login from './Pages/login/login';
import Configuracion  from './Pages/configuracion/configuracion';
import UsuarioDatos from './Pages/usuario/usuarioDatos';
import RegistroIncidencia from './Pages/RegistrarIncidencia/registroIncidencia';

import { BrowserRouter as Router, Routes, Route, useLocation } from 'react-router-dom';
import QRScanner from './Pages/QRScanner/QRScanner';
import Menu from './Components/Menu/Menu';
import IncidenciaGenerada from './Pages/incidenciaGenerada/incidenciaGenerada';
import UserQR from './Pages/userQR/userQR';
import Acerca from './Pages/acercaDe/acerca';
import RegistroIncidenciaSin from './Pages/RegistroIncidenciaSin/registroIncidencia';


const AppWithMenu = () => {
  const location = useLocation();
  const hideMenu = ['/', '/login'].includes(location.pathname);

  return (
    <React.StrictMode>
      {!hideMenu && <Menu />}
      <Routes>
        <Route path="/" element={<App />} />
        <Route path="/login" element={<Login />} />
        <Route path="/configuracion" element={<Configuracion />} />
        <Route path="/acerca" element={<Acerca />} />
        <Route path="/usuarioDatos" element={<UsuarioDatos />} />
        <Route path="/registroIncidencia/:employeeNumber" element={<RegistroIncidencia />}/>
        <Route path="/QRScanner" element={<QRScanner />} />
        <Route path="/UserQR" element={<UserQR />} />
        <Route path="/incidenciaGenerada" element={<IncidenciaGenerada />} />
        <Route path="/registroIncidenciaSinNum" element={<RegistroIncidenciaSin />}/>
      </Routes>
    </React.StrictMode>
  );
};

const root = ReactDOM.createRoot(
  document.getElementById('root') as HTMLElement
);

root.render(
  <Router>
    <AppWithMenu />
  </Router>
);

serviceWorkerRegistration.register();

reportWebVitals();
