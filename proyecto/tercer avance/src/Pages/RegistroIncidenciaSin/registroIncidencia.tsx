import React, { useState, useEffect } from 'react';
import { Link, useNavigate, useParams } from 'react-router-dom';
import axios from 'axios';
import apiConfig from '../../apiConfig';
import '../RegistrarIncidencia/registroIncidencia.css';

const RegistroIncidenciaSin: React.FC = () => {
  const { employeeNumber } = useParams<{ employeeNumber: string }>();
  const [departamentoOptions, setDepartamentoOptions] = useState<{ id: number; nombre: string }[]>([]);
  const [departamento, setDepartamento] = useState<number | undefined>();
  const [empleados, setEmpleados] = useState([]);
  const [fecha, setFecha] = useState('');
  const [departamentos, setDepartamentos] = useState([]);
  const [selectedEmpleado, setSelectedEmpleado] = useState('');
  const [selectedDepartamento, setSelectedDepartamento] = useState('');
  const [trabajoTrayecto, settrabajoTrayecto] = useState('');
  const [observaciones, setObservaciones] = useState('');
  const navigate = useNavigate();

  useEffect(() => {
    const fetchEmpleados = async () => {
      try {
        const storedToken = localStorage.getItem('accessToken');
        const response = await axios.get(`${apiConfig.baseURL}/api/v1/empleado/`, {
          headers: {
              'Authorization': `Bearer ${storedToken}`,
          },
        });
        setEmpleados(response.data.data);
      } catch (error) {
        console.error('Error al obtener empleados:', error);
      }
    };

    const fetchDepartamentos = async () => {
      try {
        const storedToken = localStorage.getItem('accessToken');
        const response = await axios.get(`${apiConfig.baseURL}/api/v1/departamento/`, {
          headers: {
              'Authorization': `Bearer ${storedToken}`,
          },
        });
        setDepartamentos(response.data.data);
      } catch (error) {
        console.error('Error al obtener departamentos:', error);
      }
    };

    fetchEmpleados();
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
      empleado_id: Number(selectedEmpleado),
      departamento_id: selectedDepartamento,
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
    } //cometario je
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
        <select  className="select-field" id="inp-employeeNumber" value={selectedEmpleado} onChange={(e) => setSelectedEmpleado(e.target.value)}>
          <option className="opcionSelect" value="">Seleccionar empleado</option>
          {empleados.map((empleado: any) => (
            <option className="select-field" key={empleado.id} value={empleado.id}>
              {empleado.apellido_materno} {empleado.apellido_paterno} {empleado.nombre}
            </option>
          ))}
        </select>
        <select  className="select-field" id="inp-departamento" value={selectedDepartamento} onChange={(e) => setSelectedDepartamento(e.target.value)}>
          <option className="opcionSelect" value="">Seleccionar departamento</option>
          {departamentos.map((departamento: any) => (
            <option className="select-field" key={departamento.id} value={departamento.id}>
              {departamento.nombre}
            </option>
          ))}
        </select>
        <input id="inp-fecha" type="date" placeholder="Fecha" value={fecha} onChange={(e) => setFecha(e.target.value)} />
        <input id="inp-trabajoTrayecto" type="text" placeholder="Trabajo o Trayecto" value={trabajoTrayecto} onChange={(e) => settrabajoTrayecto(e.target.value)}/>
        <input id="inp-observaciones" type="text" placeholder="Observaciones" value={observaciones} onChange={(e) => setObservaciones(e.target.value)}/>
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

export default RegistroIncidenciaSin;
