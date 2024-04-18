import React from 'react';
import './registroIncidencia.css'
import { Link } from 'react-router-dom';




const registroIncidencia: React.FC = () => {
    return (
      <div className='container-main'>
        <div className='divText'>
        <h3>Seleccione la zona de la incidencia</h3>
        <div>
            <span>Ingresa los datos de donde se causo la incidencia</span>
        </div>
        </div>

        <div className='div-generarInci'>
            <input id="inp-zona" type="text" placeholder="ZONA" value=''  />
            <input id="inp-zona" type="text" placeholder="CUARTO" value=''  />
            <input id="inp-zona" type="text" placeholder="LUGAR" value=''  />
            <button id="btn-genInci" type="button">Generar Incidencia</button>
        </div>

        <div>
            <Link to="/registroIncidencia" className="App-link">
                Regresar
            </Link>
        </div>
      </div>
    );
  };
export default registroIncidencia;