import React, { useState, useEffect } from 'react';
import axios from 'axios';
import '../usuario/usuarioDatos.css';
import apiConfig from '../../apiConfig';

interface UserData {
    nombre: string;
    numEmergencia: string;
    tipoSangre: string;
    alergias: string;
    correoElectronico: string;
    area: string;
    puesto: string;
    supervisor: string;
    horario: string;
    nss: string
}

const UsuarioDatos: React.FC = () => {
    const [userData, setUserData] = useState<UserData>({
        nombre: '',
        numEmergencia: '',
        tipoSangre: '',
        alergias: '',
        correoElectronico: '',
        area: '',
        puesto: '',
        supervisor: '',
        horario: '',
        nss:''
    });

    useEffect(() => {
        const fetchData = async () => {
          try {
            const storedToken = localStorage.getItem('accessToken');
            const idUser = localStorage.getItem('idUsuario');
      
            if (storedToken && idUser) {
              const response = await fetch(`${apiConfig.baseURL}/api/v1/empleado/${idUser}`, {
                headers: {
                  'Authorization': `Bearer ${storedToken}`,
                },
              });
      
              const responseData = await response.json();
      
              if (responseData.success) {
                const empleadoData = responseData.data;
                setUserData({
                  nombre: empleadoData.apellido_paterno + ' ' + empleadoData.apellido_materno + ' ' + empleadoData.nombre,
                  numEmergencia: empleadoData.datos_emergencia.telefono_emergencia,
                  tipoSangre: empleadoData.datos_emergencia.tipo_sangre,
                  alergias: empleadoData.datos_emergencia.alergias,
                  correoElectronico: empleadoData.correo,
                  area: empleadoData.nombreDepartamento,
                  puesto: empleadoData.nombrePuesto,
                  supervisor: empleadoData.jefe_directo ? empleadoData.jefe_directo.nombre : '',
                  horario: '',
                  nss: empleadoData.datos_seguro.numero_seguro
                });
              }
            }
          } catch (error) {
            console.error('Error al obtener datos:', error);
          }
        };
      
        fetchData();
      }, []);
      

    return (
        <div>
            <h3 className='h2Titles'>Usuarios</h3>

            <div className='div-informacionP'>
                <div id='text-informacion'>
                    <span>INFORMACION PERSONAL</span>
                </div>
                <div className='subdiv-nombre'>
                    <span>Nombre</span>
                    <span>{userData.nombre}</span>
                </div>
                <div className='subdiv-numEmergencia'>
                    <span>Numero de emergencia</span>
                    <span>{userData.numEmergencia}</span>
                </div>
                <div className='subdiv-sangre'>
                    <span>Tipo de sangre</span>
                    <span>{userData.tipoSangre}</span>
                </div>
                <div className='subdiv-alergia'>
                    <span>Alergias</span>
                    <span>{userData.alergias}</span>
                </div>
                <div className='subdiv-alergia'>
                    <span>NSS</span>
                    <span>{userData.nss}</span>
                </div>
                <div className='subdiv-correo'>
                    <span>Correo electronico</span>
                    <span>{userData.correoElectronico}</span>
                </div>
            </div>

            <div className='informacionT'>
                <div id='text-trabajo'>
                    <span>INFORMACION DE TRABAJO</span>
                </div>
                <div className='subdiv-area'>
                    <span>Area</span>
                    <span>{userData.area}</span>
                </div>
                <div className='subdiv-puesto'>
                    <span>Puesto</span>
                    <span>{userData.puesto}</span>
                </div>
                <div className='subdiv-horario'>
                    <span>Horario</span>
                    <span>{userData.horario}</span>
                </div>
            </div>
        </div>
    );
};

export default UsuarioDatos;
