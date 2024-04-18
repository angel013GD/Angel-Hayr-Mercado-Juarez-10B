import React, { useState } from 'react';
import './Menu.css';
import { AiOutlineQrcode, AiOutlineUser, AiOutlineSetting } from "react-icons/ai";

function Menu() {
  const [showUserOptions, setShowUserOptions] = useState(false);
  const [selectedOption, setSelectedOption] = useState<string | null>(null);

  const handleUserOptionClick = () => {
    setShowUserOptions(!showUserOptions);
    setSelectedOption('user');
  };

  const handleOptionClick = (option: string) => {
    setSelectedOption(option);
    setShowUserOptions(false);
  };

  return (
    
    <div className="menu">
      {showUserOptions && selectedOption === 'user' && (
        <div className="user-options">
          <div className="sub-option" onClick={() => handleOptionClick('opcion1')}>Opcion 1</div>
          <div className="sub-option" onClick={() => handleOptionClick('opcion2')}>Opción 2</div>
          <div className="sub-option" onClick={() => handleOptionClick('opcion3')}>Opción 3</div>
        </div>
      )}
      
      <div className="option" onClick={() => handleOptionClick('qr')}>
        <AiOutlineQrcode className='AiIconsMenu'></AiOutlineQrcode>
      </div>
      <div className="option" onClick={handleUserOptionClick}>
        <div className="user-option">
          <AiOutlineUser className='AiIconsMenu'></AiOutlineUser>
        </div>
      </div>
      <div className="option" onClick={() => handleOptionClick('setting')}>
        <AiOutlineSetting className='AiIconsMenu'></AiOutlineSetting>
      </div>
    </div>
  );
}

export default Menu;
