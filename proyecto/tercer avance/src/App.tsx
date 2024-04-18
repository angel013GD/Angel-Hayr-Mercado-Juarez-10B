import React from 'react';
import { Link } from 'react-router-dom';
import logo from './resources/images/zenithLogo.svg';

function App() {
  return (
    <div className="App">
      <header className="App-header">
        <img src={logo} className="App-logo" alt="logo" />
        <p>
          <code>ZENITH!</code>
        </p>
        <Link to="/login" className="App-link">
          Vamos a login!
        </Link>
      </header>
    </div>
  );
}

export default App;