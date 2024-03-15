import React from 'react';
import QRCode from 'qrcode.react';
import './userQR.css'; // Ruta relativa al archivo CSS

interface User {
  name: string;
  surname: string;
  id: string;
}

interface UserQRProps {
  user: User;
}

const UserQR: React.FC<UserQRProps> = ({ user }) => {
  return (
    <div>
      <div className="avatar-container"> {/* Contenedor para la imagen */}
        <img src="./logo192.png" alt="User Avatar" className="avatar" />
      </div>
      <h1>User Information</h1>
      <p>Name: {user.name}</p>
      <p>Surname: {user.surname}</p>
      <p>ID: {user.id}</p>
      <QRCode value={user.id} />
    </div>
  );
};

export default UserQR;
