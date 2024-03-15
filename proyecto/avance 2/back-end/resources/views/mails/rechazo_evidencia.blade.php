<!DOCTYPE html>
<html>
<head>
    <title>Notificación de Rechazo de Evidencia</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <div style="text-align: left;">
    <img src='https://visionremota.com.mx/testAngel/visor/controlterrestretestangel/view/images/Logo_VR_Small.png' alt='Logo de la Empresa'>

        <h1 style="color: #333;">Notificación de Rechazo de Evidencia</h1>
        <p style="color: #555;">Buen día, Espero que se encuentre bien.</p>

        <div style="background-color: #f0f0f0; border-radius: 5px;">
            <p>Le escribimos para informarle que lamentablemente hemos tenido que rechazar la evidencia <b>{{ $nombreArchivo }}</b> el día <b>{{ $fechaFormateada }}</b> relacionada con la orden de trabajo <b>{{ $odt }}</b>. El motivo del rechazo es el siguiente:</p>
            {{ $comentario }}
            <p>Estamos comprometidos en garantizar que nuestras operaciones sigan siendo eficientes y que podamos cumplir con nuestros compromisos. Su colaboración en este proceso es fundamental para lograrlo.</p>
            <p>Si tiene alguna pregunta o necesita más información sobre los detalles del rechazo, no dude en ponerse en contacto con nosotros. Estamos aquí para ayudarle y brindarle el apoyo necesario.</p>
        </div>
        <p>Agradecemos de antemano su atención y compromiso con esta empresa</p>
        <div style="font-family: Arial, sans-serif;">
            <p style="color: #555; font-size: 14px; margin: 10px 0;"><b>Atentamente</b></p>
            <h3 style="color: #555; font-size: 18px; margin: 5px 0;"><b>Visión Remota</b></h3>
            <p style="color: #888; font-size: 14px; margin: 0;"><em>Una creación de <a href='www.controlterrestre.com' style="color: #ff6600; text-decoration: none;">Control Terrestre</a></em></p>
        </div>
    </div>
</body>
</html>
