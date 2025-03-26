<?php
class ImageUploader {
    private $uploadDir = 'uploads/';
    
    public function process($file) {
        // Verificar errores de subida
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Upload error: " . $file['error']);
        }
        
        // Verificar que es una imagen
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        
        if (!in_array($mime, ['image/jpeg', 'image/png', 'image/gif'])) {
            throw new Exception("Only JPG, PNG and GIF images are allowed");
        }
        
        // Generar nombre único
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        $destPath = $this->uploadDir . $filename;
        
        // Procesar con Imagick (versión vulnerable)
        try {
            $imagick = new Imagick($file['tmp_name']);
            
            // Vulnerabilidad: Imagick antes de 6.9.7-4 es vulnerable a ejecución de código
            // a través de imágenes especialmente manipuladas
            
            // Redimensionar para "sanitizar"
            $imagick->resizeImage(800, 600, Imagick::FILTER_LANCZOS, 1);
            
            // Guardar imagen
            if (!$imagick->writeImage($destPath)) {
                throw new Exception("Failed to save image");
            }
            
            return $filename;
        } catch (ImagickException $e) {
            throw new Exception("Image processing error: " . $e->getMessage());
        }
    }
}
?>