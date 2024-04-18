import React, { useEffect } from 'react';
import zenithLogo from '../../../src/resources/images/zenithLogoPNG.svg';

const IncidenciaGenerada: React.FC = () => {
  useEffect(() => {
    const image = new Image();
    image.src = zenithLogo;
    image.onload = () => {
      // Almacena la imagen en la caché del navegador
      const canvas = document.createElement('canvas');
      const context = canvas.getContext('2d');
      context?.drawImage(image, 0, 0);
    };
    // En caso de error en la carga de la imagen
    image.onerror = () => console.error("Error al cargar la imagen");
  }, []);

  return (
    <div>
      <h3 className='h2Titles'>QR Scanner</h3>
      <div className='textScanner'>
        <h3>La incidencia fue generada</h3>
        <p className='p1'>Por favor manténgase en la</p>
        <p className='p1'>zona y espere la ayuda.</p>
        <p className='p1'>Esté atento del comportamiento de su compañero accidentado.</p>
      </div>
      <hr className='hrQRScanner'></hr>
      <img src={zenithLogo} alt="User Avatar" className="avatar" />
      <hr className='hrQRScanner'></hr>
    </div>
  );
};

export default IncidenciaGenerada;
