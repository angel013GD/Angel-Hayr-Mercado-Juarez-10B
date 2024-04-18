import React, { useState, useEffect } from 'react';
import Switch from '@mui/material/Switch';
import '../configuracion/configuracion.css';
import { Link, useNavigate } from 'react-router-dom';

const Configuracion: React.FC = () => {
    const [camaraPermitida, setCamaraPermitida] = useState<boolean>(false);
    const [notificacionesPermitidas, setNotificacionesPermitidas] = useState<boolean>(false);
    const [error, setError] = useState<string>('');
    const navigate = useNavigate();

    const checkPermissionsFromCache = () => {
      const cachedCameraPermission = localStorage.getItem('cameraPermission');
      const cachedNotificationPermission = localStorage.getItem('notificationPermission');
      if (cachedCameraPermission === 'granted') {
          setCamaraPermitida(true);
      }
      if (cachedNotificationPermission === 'granted') {
          setNotificacionesPermitidas(true);
      }
  };  
  useEffect(() => {
    checkPermissionsFromCache();
}, []);
    
    const handleCamaraChange = async (event: React.ChangeEvent<HTMLInputElement>) => {
      try {
          setCamaraPermitida(event.target.checked);
          if (!event.target.checked) {
              setError('');
          } else {
              await navigator.mediaDevices.getUserMedia({ video: true });
              localStorage.setItem('cameraPermission', 'granted');
              setError('');
          }
      } catch (err: any) {
          alert('Error al acceder a la cámara: ' + err.message);
      }
  };
  
  const handleNotificacionesChange = async (event: React.ChangeEvent<HTMLInputElement>) => {
    try {
        setNotificacionesPermitidas(event.target.checked);
        if (!event.target.checked) {
            setError('');
        } else {
            const permission = await Notification.requestPermission();
            if (permission === 'granted') {
                console.log('Permisos de notificaciones concedidos');
                localStorage.setItem('notificationPermission', 'granted');
            }
            setError('');
        }
    } catch (err: any) {
        alert('Error al acceder a las notificaciones: ' + err.message);
    }
};

const cerrarSesion = () => {

    localStorage.clear();
    navigate('/login');
};
    return (
        <div>
            <h3 className='h2Titles'>Usuarios</h3>
            {error && <div>Error: {error}</div>}
            <div className='div-permisos'>
                <div id='text-permisos'>
                    <span>Permisos</span>
                </div>
                <div className='subdiv-Permisos'>
                    <span>Permitir Cámara</span>
                    <Switch id="switch" checked={camaraPermitida} onChange={handleCamaraChange} />
                </div>
                <div className='subdiv-notificaciones'>
                    <span>Permitir Notificaciones</span>
                    <Switch id="switch" checked={notificacionesPermitidas} onChange={handleNotificacionesChange} />
                </div>
            </div>
            <div className='ayuda'>
                <div id='text-permisos'>
                    <span>AYUDA</span>
                </div>
                <Link to="/acerca" >
                <div id='text-acerca'><span>Acerca de la aplicación</span></div>
                </Link>
                <div id='text-Enviar'>
                <a href="https://wa.me/526646756583">
                    <span>Enviar sugerencia</span>
                </a>
                </div>
                <div id='text-soporte'>
                <a href="https://wa.me/526646756583">
                    <span>Soporte</span>
                </a>
                </div>
                <div id='text-cerrar' onClick={cerrarSesion}><span>Cerrar sesion</span></div>
            </div>
        </div>
    );
};

export default Configuracion;
