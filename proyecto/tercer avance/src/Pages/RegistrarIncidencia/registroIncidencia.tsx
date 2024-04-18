import React, { useState, useEffect } from 'react';
import { Link, useNavigate, useParams } from 'react-router-dom';
import axios from 'axios';
import apiConfig from '../../apiConfig';
import '../RegistrarIncidencia/registroIncidencia.css'

const RegistroIncidencia: React.FC = () => {
  const { employeeNumber } = useParams<{ employeeNumber: string }>();
  const [departamentoOptions, setDepartamentoOptions] = useState<{ id: number; nombre: string }[]>([]);
  const [departamento, setDepartamento] = useState<number | undefined>();
  const [fecha, setFecha] = useState('');
  const [trabajoTrayecto, settrabajoTrayecto] = useState('');
  const [observaciones, setObservaciones] = useState('');
  const navigate = useNavigate();

  useEffect(() => {
    const fetchDepartamentos = async () => {
      try {
        const token = localStorage.getItem('accessToken');
        console.log(token)
        const response = await axios.get(`${apiConfig.baseURL}/api/v1/departamento`, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });
        setDepartamentoOptions(response.data.data);
        console.log(response.data)
      } catch (error) {
        console.error('Error al obtener los departamentos:', error);
      }
    };

    fetchDepartamentos();
  }, []);

  const handleGenerateIncident = async () => {
    const token = localStorage.getItem('accessToken');
    const config = {
      headers: {
        Authorization: `Bearer ${token}`
      }
    };

    const incidentData = {
      empleado_id: Number(employeeNumber),
      departamento_id: departamento,
      fecha_incidente: fecha,
      trabajo_trayecto: trabajoTrayecto,
      observaciones: observaciones
    };

    try {
      await axios.post(`${apiConfig.baseURL}/api/v1/incidente`, incidentData, config);
      alert('Incidencia registrada exitosamente');
      navigate('/incidenciaGenerada');
    } catch (error) {
      console.error('Error al registrar la incidencia:', error);
    }
  };

  return (
    <div className='container-main'>
      <div className='divText'>
        <h3>Seleccione la zona de la incidencia</h3>
        <div>
          <span>Ingresa los datos de donde se causó la incidencia</span>
        </div>
      </div>

      <div className='div-generarInci'>
        <input id="inp-employeeNumber" type="text" value={employeeNumber} readOnly />
        
        <select className="select-field" id="inp-departamento" value={departamento} onChange={(e) => setDepartamento(Number(e.target.value))}>
          <option className='opcionSelect' value="">Selecciona un departamento</option>
          {departamentoOptions && departamentoOptions.map((data) => (
            <option className='select-field' key={data.id} value={data.id}>{data.nombre}</option>
          ))}
        </select>
        
        <input id="inp-fecha" type="date" placeholder="Fecha" value={fecha} onChange={(e) => setFecha(e.target.value)} />
          <select className="select-field" id="inp-trabajoTrayecto" value={trabajoTrayecto} onChange={(e) => settrabajoTrayecto(e.target.value)}>
            <option value="">Lugar de incidencia</option>
            <option value="Trabajo">Trabajo</option>
            <option value="Trayecto">Trayecto</option>
          </select>        
        <input id="inp-observaciones" type="text" placeholder="Observaciones" value={observaciones} onChange={(e) => setObservaciones(e.target.value)} />
        <button id="btn-genInci" type="button" onClick={handleGenerateIncident}>Generar Incidencia</button>
      </div>
      <div>
        <Link to="/UserQR" className="App-link">
          Regresar
        </Link>
      </div>
    </div>
  );
};

export default RegistroIncidencia;