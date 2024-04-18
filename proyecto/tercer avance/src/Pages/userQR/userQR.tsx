import React, { useState } from 'react';
import './userQR.css'; // Ruta relativa al archivo CSS
import { Link } from 'react-router-dom';

const UserQR: React.FC = () => {
  const [texto, setTexto] = useState("");
  const [employeeNumber, setEmployeeNumber] = useState("");

  const handleSubmit = (employeeNumber: string) => {
    console.log(employeeNumber);
    // Aquí puedes realizar cualquier otra acción que necesites con el número de empleado
  };

  return (
    <div>
      <h3 className='h2Titles'>QR Scanner</h3>
      <div className='textEmployee'>
        <h3>Numero de empleado</h3>
        <p className='p1QRUser'>Busca el codigo QR en el </p>
        <p className='p1QRUser'>uniforme de tu compañero </p>
      </div>
      <hr></hr>
      <img src="./img/qrExample.png" alt="User Avatar" className="avatar" />
      <div className='options'>
        <input
          className='input inputUserQR'
          placeholder='Número de empleado'
          onChange={(e) => setTexto(e.target.value)}
          value={texto}
        />
        <Link to={`/registroIncidencia/${texto}`}>
          <button className='button1' onClick={() => handleSubmit(texto)}>Siguiente</button>
        </Link>
        <hr></hr>
        <Link to="/registroIncidenciaSinNum">
          <button className='button1 blueButton'>Seguir sin codigo</button>
        </Link>
      </div>
      <hr></hr>
      <div className='divButtonScan'>
        <Link to="/QRScanner">
          <button className='buttonScan'>Scanear codigo QR</button>
        </Link>
      </div>
    </div>
  );
};

export default UserQR;
