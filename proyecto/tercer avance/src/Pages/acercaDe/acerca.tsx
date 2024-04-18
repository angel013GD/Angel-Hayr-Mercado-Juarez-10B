import React, { useEffect } from 'react';
import zenithLogo from '../../../src/resources/images/AiLogo.svg';
import logoUTT from '../../../src/resources/images/logoUTT.png';
import zenithTexto from '../../../src/resources/images/zenithTextoPNG.svg';
import zenithLogoPNGnegro from '../../../src/resources/images/zenithLogoPNG.svg';
import "./acerca.css";

const Acerca: React.FC = () => {
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
    <div className='acercaDe'>
      <img src={zenithTexto} alt="User Avatar" className="avatar" />
      <hr className='hrQRScanner'></hr>
      <h3 className='h2Acerca'>Acerca de la aplicación</h3>
      <div className='textAcerca'>
        <p className='pAcerca'>Este proyecto aborda la necesidad de mejorar la seguridad en entornos industriales mediante una plataforma web. La página permitirá el registro eficiente de incidentes, proporcionando análisis detallados para una gestión más efectiva de empleados.</p>
      </div>
      <hr className='hrQRScanner'></hr>
      <img src={zenithLogo} alt="User Avatar" className="avatar" />
      <hr className='hrQRScanner'></hr>
      
      <h3 className='h2Acerca'>Objetivo</h3>
      <div className='textAcerca'>
        <p className='pAcerca'>Establecer una herramienta que, además de registrar incidentes, ofrezca análisis para identificar patrones. Esto ayudará a mejorar la seguridad en zonas específicas y proporcionará un historial para evaluaciones continuas.</p>
      </div>
      <hr className='hrQRScanner'></hr>
      <img src={zenithTexto} alt="User Avatar" className="avatar" />
      <hr className='hrQRScanner'></hr>
      
      <h3 className='h2Acerca'>Metodología</h3>
      <div className='textAcerca'>
        <p className='pAcerca'>En nuestro proyecto, aplicamos Scrum dividiendo el trabajo en sprints cortos. Al inicio de cada sprint, definimos metas y prioridades. Durante el sprint, el equipo se centró en tareas específicas, manteniendo comunicación diaria en reuniones Scrum. Al final de cada sprint, presentamos un producto funcional.</p>
      </div>
      <hr className='hrQRScanner'></hr>
      <img src={logoUTT} alt="User Avatar2" className="avatar2" />
      <hr className='hrQRScanner'></hr>
      
      <h3 className='h2Acerca'>Conclusiones</h3>
      <div className='textAcerca'>
        <p className='pAcerca'>La implementación exitosa de la plataforma destaca su valor en la toma de decisiones informadas para la prevención de incidentes. Además, sienta las bases para una gestión proactiva de la seguridad, contribuyendo a la salud de los trabajadores y fortaleciendo la eficiencia operativa en entornos industriales.</p>
      </div>
      <hr className='hrQRScanner'></hr>
      
    </div>
  );
};

export default Acerca;
