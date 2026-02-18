<?php
// Usamos la API de Brevo con el metodo que trae instalado PHp que es curl
function enviarEmailBrevo($destinatario_email, $destinatario_nombre, $asunto, $contenidoHTML) {
    
    $apiKey = 'contraseña';

    $senderEmail = 'soporte_dreamclass@outlook.es'; 
    $senderName = 'DreamClass';

    // Construimos este array que Brevo exige 
    $data = [
        'sender' => [
            'name' => $senderName,
            'email' => $senderEmail
        ],
        'to' => [
            [
                'email' => $destinatario_email,
                'name' => $destinatario_nombre
            ]
        ],
        'subject' => $asunto,
        'htmlContent' => $contenidoHTML
    ];

    $ch = curl_init();
    
    // Configurar opciones de cURL
    // Donde tiene que ir a llamar para entregar correos: La direccion de la API
    curl_setopt($ch, CURLOPT_URL, 'https://api.brevo.com/v3/smtp/email');
    // Recibe la respuesta anterior y la guarda
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Tipo de envio
    curl_setopt($ch, CURLOPT_POST, true);
    // Cogemos el array $data y lo pasamos a JSON
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    // Aqui le dices que te respondan en JSON, la clave para entrar y que lo que le enviamos esta en JSON
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'accept: application/json',
        'api-key: ' . $apiKey,
        'content-type: application/json'
    ]);
    
    // Enviamos mensaje, buscamos el error y cerramos conexion 
    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        error_log("Error al enviar email con Brevo (cURL): " . $err);
        return false;
    }
    
    return true;
}
?>