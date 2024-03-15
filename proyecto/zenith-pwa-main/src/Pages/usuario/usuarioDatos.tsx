import React from 'react';
import Switch from '@mui/material/Switch';
import '../usuario/usuarioDatos.css'




const usuarioDatos: React.FC = () => {
    return (
      <div>
        <div id="title-usuario"><h3>Usuario</h3></div>
        <div className='div-informacionP'>
            <div id='text-informacion'>
                  <span>INFORMACION PERSONAL</span>
            </div>  
            <div className='subdiv-nombre'>
                <span>Nombre</span>
                <span> Christian Garcia</span>
            </div>
            <div className='subdiv-numEmergencia'>
                <span>Numero de emergencia</span>
                <span> 664 889 5651 </span>
            </div>
            <div className='subdiv-sangre'>
                <span>Tipo de sangre</span>
                <span> A+</span>
            </div>
            <div className='subdiv-alergia'>
                <span>Alergias</span>
                <span> N/A</span>
            </div>
            <div className='subdiv-correo'>
                <span>Correo electronico</span>
                <span> chris@gmail.com</span>
            </div>

        </div>

        <div className='informacionT'>
          <div id='text-trabajo'>
              <span>INFORMACION DE TRABAJO</span>
          </div>  
          <div className='subdiv-area'>
                <span>Area</span>
                <span> Oficina</span>
          </div>
          <div className='subdiv-puesto'>
              <span>Puesto</span>
              <span> Recursos humanos</span>
          </div>
          <div className='subdiv-supervisor'>
              <span>Supervisor</span>
              <span> Guillermo Salas</span>
          </div>
          <div className='subdiv-horario'>
              <span>Horario</span>
              <span> Matutino</span>
          </div>
        </div>


      </div>
    );
  };
export default usuarioDatos;