<?php

namespace App\Controlador;

class PaginasControlador {
    public function privacidad(){
        $datos = ['titulo' => 'Politica de privacidad'];
        require_once __DIR__ . '/../View/paginas/privacidad.php';
    }

    public function terminos(){
        $datos = ['titulo' => 'Terminos y Condiciones'];
        require_once __DIR__ . '/../View/paginas/terminos.php';
    }


    public function contacto (){
        $datos = ['titulo' => 'Página de contacto'];
        require_once __DIR__ . '/../View/paginas/contacto.php';
    }
}
?>