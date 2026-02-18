<?php
namespace App\Modelo;

use PDO;

class Chat {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Esta funcion muestra los alumno a los que el profesor da clases
    public function getContactosDocente($id_docente) {
        $stmt = $this->pdo->prepare("
            SELECT DISTINCT u.id_usuario, u.nombre
            FROM clase c
            JOIN usuario u ON c.id_alumno = u.id_usuario
            WHERE c.id_docente = ?
            ORDER BY u.nombre
        ");
        $stmt->execute([$id_docente]);
        return $stmt->fetchAll();
    }

    public function getContactosAlumno($id_alumno) {
        $stmt = $this->pdo->prepare("
            SELECT DISTINCT u.id_usuario, u.nombre
            FROM clase c
            JOIN usuario u ON c.id_docente = u.id_usuario
            WHERE c.id_alumno = ?
            ORDER BY u.nombre
        ");
        $stmt->execute([$id_alumno]);
        return $stmt->fetchAll();
    }

    // Recogemos los mensajes enviados desde el mas viejo al mas nuevo
    public function getMensajes($id_usuario, $contacto_id) {
        $stmt = $this->pdo->prepare("
            SELECT m.*, u.nombre AS remitente_nombre
            FROM mensaje m
            JOIN usuario u ON m.id_remitente = u.id_usuario
            WHERE (m.id_remitente = ? AND m.id_destinatario = ?)
               OR (m.id_remitente = ? AND m.id_destinatario = ?)
            ORDER BY m.fecha_hora ASC
        ");
        $stmt->execute([$id_usuario, $contacto_id, $contacto_id, $id_usuario]);
        return $stmt->fetchAll();
    }

    // Guarda un mensaje nuevo
    public function createMensaje($remitente, $destinatario, $contenido) {
        $stmt = $this->pdo->prepare("
            INSERT INTO mensaje (id_remitente, id_destinatario, contenido)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$remitente, $destinatario, $contenido]);
    }

    // Esta funcion actualiza los mensajes a leidos
    public function marcarLeidos($remitente, $destinatario) {
        $stmt = $this->pdo->prepare("
            UPDATE mensaje SET leido = 1
            WHERE id_remitente = ? AND id_destinatario = ?
        ");
        return $stmt->execute([$remitente, $destinatario]);
    }
}
?>