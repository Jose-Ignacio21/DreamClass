<?php
function enviarEmailBrevo($destinatario_email, $destinatario_nombre, $asunto, $contenidoHTML) {
    
    $apiKey = ''; 

    $senderEmail = 'soporte_dreamclass@outlook.es'; 
    $senderName = 'DreamClass';

    // Construimos este array que brevo exige
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
    
    curl_setopt($ch, CURLOPT_URL, 'https://api.brevo.com/v3/smtp/email');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'accept: application/json',
        'api-key: ' . $apiKey,
        'content-type: application/json'
    ]);
    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Evita que se me cuelgue a la hora de comprobar los emails
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Tiempo maximo de espero son unos 10 segundos
    
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