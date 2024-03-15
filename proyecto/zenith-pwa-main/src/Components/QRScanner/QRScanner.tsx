import React, { useRef, useEffect, useState } from 'react';
import jsQR from 'jsqr'; // Importa jsQR desde la librería jsqr
import './QRScanner.css'; // Importa el archivo CSS para los estilos

const QRScanner: React.FC = () => {
  const videoRef = useRef<HTMLVideoElement | null>(null);
  const [isCameraActive, setIsCameraActive] = useState(false);

  const toggleCamera = () => {
    if (isCameraActive) {
      stopCamera();
    } else {
      startCamera();
    }
  };

  const startCamera = () => {
    navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
      .then(stream => {
        const video = videoRef.current;
        if (video) {
          video.srcObject = stream;
          video.play();
          setIsCameraActive(true);
        }
      })
      .catch(error => {
        console.error('Error al acceder a la cámara:', error);
      });
  };

  const stopCamera = () => {
    const video = videoRef.current;
    if (video && video.srcObject instanceof MediaStream) {
      video.srcObject.getTracks().forEach(track => track.stop());
      setIsCameraActive(false);
    }
  };

  useEffect(() => {
    const canvas = document.createElement('canvas');
    const context = canvas.getContext('2d');
    const video = videoRef.current;

    if (!context || !video || !navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
      console.error('La API navigator.mediaDevices no está disponible en este navegador.');
      return;
    }
    const scan = () => {
      if (video.videoWidth === 0 || video.videoHeight === 0) {
        requestAnimationFrame(scan);
        return;
      }

      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      context.drawImage(video, 0, 0, canvas.width, canvas.height);
  
      const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
      const code = jsQR(imageData.data, imageData.width, imageData.height);
  
      if (code && code.data) {
        console.log('Código QR escaneado:', code.data);
        // Aquí puedes manejar el resultado del escaneo como desees
        window.location.href = code.data; // Redirige a la URL escaneada
      }
  
      requestAnimationFrame(scan);
    };
  
    const handleLoadedMetadata = () => {
      video.play();
      requestAnimationFrame(scan);
    };
  
    video.addEventListener('loadedmetadata', handleLoadedMetadata);

    return () => {
      video.removeEventListener('loadedmetadata', handleLoadedMetadata);
      if (video.srcObject instanceof MediaStream) {
        video.srcObject.getTracks().forEach(track => track.stop());
      }
    };
  }, []);

  const [texto, setTexto] = useState("Introduce el código de empleado");

  const handleClick = () => {
    setTexto("");
  };
  return (
    <div>
       <div className='textScanner'>
        <h3>Escanea el codigo QR</h3>
          <p className='p1'>Busca el codigo QR en el </p>
          <p className='p1'>uniforme de tu compañero </p>
        </div>
          <hr></hr>
            <div className='divQR' >
              <video ref={videoRef} className='videoRef'></video>
              <button className={`qr-scanner ${isCameraActive ? 'inactive' : 'active'}`} onClick={toggleCamera}>{isCameraActive ? 'Detener Cámara' : 'Activar Cámara'}</button>
            </div>
            <div className='options'>
            <input className='input inputScannerQR' onClick={handleClick} ></input>
            <button className='button'>Siguiente</button>
            <button className='button blueButton'>Seguir sin codigo</button>
            </div>
          <hr></hr>
              <button className='buttonNoScan' >No puedo scanear</button>
    </div>
  );
};

export default QRScanner;
export {};
