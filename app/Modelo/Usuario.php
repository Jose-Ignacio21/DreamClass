<?php
namespace App\Modelo;

use PDO; 

class Usuario {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerPorId($id_usuario) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
        $stmt->execute([$id_usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Utilizo sentencias preparadas para buscar usuarios por email
    public function findByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuario WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    // Crear usuario
    public function create($nombre, $email, $contrasenia, $rol) {
        $stmt = $this->pdo->prepare("INSERT INTO usuario (nombre, email, contrasenia, rol) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$nombre, $email, $contrasenia, $rol])) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    // Insertar perfil especifico
    public function createPerfil($id_usuario, $rol) {
        if ($rol === 'docente') {
            $stmt = $this->pdo->prepare("INSERT INTO docente (id_docente) VALUES (?)");
        } else {
            $stmt = $this->pdo->prepare("INSERT INTO alumno (id_alumno) VALUES (?)");
        }
        return $stmt->execute([$id_usuario]);
    }

    public function actualizarUsuario($id_usuario, $nombre, $apellidos, $email, $foto = null, $password = null) {
        $sql = "UPDATE usuario SET nombre = ?, apellidos = ?, email = ?";
        $params = [$nombre, $apellidos, $email];

        if ($foto) {
            $sql .= ", foto_perfil = ?";
            $params[] = $foto;
        }

        if ($password) {
            $sql .= ", contrasenia = ?";
            $params[] = password_hash($password, PASSWORD_DEFAULT);
        }

        $sql .= " WHERE id_usuario = ?";
        $params[] = $id_usuario;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
}
?>