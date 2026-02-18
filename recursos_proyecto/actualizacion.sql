-- 1. AÑADIR APELLIDOS AL USUARIO
-- Como quieres separar "Nombre" y "Apellidos" en el menú, añadimos la columna.
ALTER TABLE `usuario` 
ADD COLUMN `apellidos` VARCHAR(100) DEFAULT NULL AFTER `nombre`;

-- 2. PREPARAR LA VALIDACIÓN DEL DOCENTE
-- Añadimos el campo para subir el PDF/Foto del título
-- Y el estado de la validación (Pendiente por defecto)
ALTER TABLE `docente` 
ADD COLUMN `archivo_titulo` VARCHAR(255) DEFAULT NULL AFTER `precio_hora`,
ADD COLUMN `estado_validacion` ENUM('pendiente', 'verificado', 'rechazado') DEFAULT 'pendiente' AFTER `archivo_titulo`;

-- 3. (OPCIONAL) ACTUALIZAR USUARIOS EXISTENTES
-- Esto es un truco: Si ya tienes usuarios creados, tendrán el apellido vacío.
-- Puedes ejecutar esto para que no se vea feo al principio (opcional).
UPDATE `usuario` SET `apellidos` = '' WHERE `apellidos` IS NULL;