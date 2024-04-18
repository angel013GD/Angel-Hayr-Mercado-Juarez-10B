import React, { useState } from 'react';
import './Menu.css';
import { AiOutlineQrcode, AiOutlineUser, AiOutlineSetting } from "react-icons/ai";
import { Link } from 'react-router-dom';

function Menu() {
  const [showUserOptions, setShowUserOptions] = useState(false);
  const [selectedOption, setSelectedOption] = useState<string | null>(null);
  const [keyboardActive, setKeyboardActive] = useState(false);

  const handleFocusIn = () => {
    setKeyboardActive(true);
  };

  const handleFocusOut = () => {
    setKeyboardActive(false);
  };

  const handleOptionClick = (option: string) => {
    setSelectedOption(option);
    setShowUserOptions(false);
  };

  return (
    <div className={`menu ${keyboardActive ? 'keyboard-active' : ''}`}>
    <div className="menu-container">
    <div className="menu">
      {showUserOptions && (
        <div className="selected-option">{selectedOption}</div>
      )}
      <Link to="/QRScanner">
        <div className="option" onClick={() => handleOptionClick('qr')}>
          <AiOutlineQrcode className='AiIconsMenu'></AiOutlineQrcode>
        </div>
      </Link>
      <Link to="/usuarioDatos">
        <div className="option" onClick={() => handleOptionClick('user')}>
          <AiOutlineUser className='AiIconsMenu'></AiOutlineUser>
        </div>
      </Link>
      <Link to="/configuracion">
        <div className="option" onClick={() => handleOptionClick('setting')}>
          <AiOutlineSetting className='AiIconsMenu'></AiOutlineSetting>
        </div>
      </Link>
    </div>
  </div>
</div>
  );
}

export default Menu;
