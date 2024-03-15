import React from 'react';
import Switch from '@mui/material/Switch';
import '../configuracion/configuracion.css'




const configuracion: React.FC = () => {
    // Lógica del componente Login
    return (
      <div>
        <div id="title-configuracion"><h3>Configuracion</h3></div>
        <div className='div-permisos'>
            <div id='text-permisos'>
                  <span>Permisos</span>
            </div>  
            <div className='subdiv-Permisos'>
                <span>Permitir Camara</span>
                <Switch id="switch" defaultChecked />
            </div>
            <div className='subdiv-notificaciones'>
                <span>Permitir Notificaciones</span>
                <Switch id="switch" defaultChecked/> 
            </div>

        </div>

        <div className='ayuda'>
          <div id='text-permisos'>
              <span>ayuda</span>
          </div>  
          <div id='text-acerca'><span>Acerca de la aplicacion</span></div>
          <div id='text-Enviar'><span>Enviar sugerencia</span></div>
          <div id='text-soporte'><span>Soporte</span></div>

        </div>


      </div>
    );
  };
export default configuracion;