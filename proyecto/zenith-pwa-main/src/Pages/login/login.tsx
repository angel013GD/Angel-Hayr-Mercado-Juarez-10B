import React from 'react';
import LogoTexto from '../../resources/images/zenithLogoPNG.svg'
import '../../Pages/login/login.css'
const Login: React.FC = () => {
  return (
    <div id="login">
            <div id="login-container">
                <div id="formLogo">
                    <img id="logoMain" src={LogoTexto} alt="logo"></img>
                </div>
                <form id="loginForm"> 
                    <h3>Iniciar Sesion</h3>
                    <hr></hr>
                    <input type="text" placeholder="Email*" value=''  />
                    <input type="password" placeholder="Password*" value='' />
                    <span ><b id="contactSupport" >¿Olvidates tu contraseña</b></span>
                    <button id="loginButton" type="button">Iniciar sesion</button>
                </form>
                
                
                
            </div>
        </div>
  );
};

export default Login;
