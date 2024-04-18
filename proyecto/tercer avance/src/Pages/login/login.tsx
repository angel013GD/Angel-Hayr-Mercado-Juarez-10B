import React, { useState } from 'react';
import './login.css'
import LogoTexto from '../../resources/images/zenithLogoPNG.svg';
import { useNavigate } from 'react-router-dom';
import apiConfig from '../../apiConfig';

const Registro: React.FC = () => {

    
    const [nombre_usuario, setName] = useState('');
    const [email, setEmail] = useState('');
    const [contrasenia, setPassword] = useState('');
    const [showError, setShowError] = useState(false);
    const [errorMessage, setErrorMessage] = useState("");
    const navigate = useNavigate();

    const handleRegistro = async (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        try {
            const response = await fetch(`${apiConfig.baseURL}/api/v1/auth/login/`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ nombre_usuario, contrasenia }),
            });
            const data = await response.json();
            if(data.success == true){
                const idUsuario  = data.data.id;
                const accessToken  = data.data.token;
                const nombreUsuario = data.data.nombre;
                const idUEmpleado = data.data.empleado_id;
                localStorage.setItem('accessToken', accessToken);
                localStorage.setItem('idEmpleado', idUEmpleado);
                localStorage.setItem('idUsuario', idUsuario);
                localStorage.setItem('nombreUsuario', nombreUsuario);
                navigate('/UserQR');
            }else{
                setErrorMessage(data.message);
                setShowError(true); 
                setTimeout(() => {

                    setShowError(false); 
                }, 2000); 
            }


        } catch (error) {
            console.error('Error:', error);
        
        }
    };

    return (
        <div id="login">
            <div id="login-container">
            <div id="formLogo">
                <img id="logoMain" src={LogoTexto} alt="logo"></img>
            </div>
            <h3>Iniciar Sesion</h3>
            <form onSubmit={handleRegistro}>
                <input type="text" placeholder="Email*" value={nombre_usuario} onChange={(e) => setName(e.target.value)} required /><br /><br />
                <input type="password" placeholder="Password*" value={contrasenia} onChange={(e) => setPassword(e.target.value)} required /><br /><br />
                {showError && <h3 className='mensageError'>{errorMessage}</h3>}
                <button type="submit">Iniciar sesion</button>
            </form>
            </div>
        </div>
    );
};

export default Registro;
