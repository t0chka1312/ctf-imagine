# Imagnine CTF

Máquina de Capture The Flag (CTF) con vulnerabilidades web diseñada para prácticas de hacking ético.

## Vulnerabilidades implementadas
- **Inyección SQL basada en tiempo**: Extrae la contraseña del admin midiendo tiempos de respuesta.
- **RCE en ImageMagick**: Ejecuta código arbitrario mediante imágenes maliciosas.

## Requisitos
- Ubuntu 20.04/22.04 LTS
- Apache2, PHP, MariaDB
- ImageMagick (versión vulnerable <= 6.9.7-4)

## Instalación rápida
```bash
# Clonar repositorio
sudo git clone https://github.com/tu-usuario/ctf-bloodmoon.git /var/www/html/ctf

# Configurar permisos
sudo chown -R www-data:www-data /var/www/html/ctf
sudo chmod -R 755 /var/www/html/ctf
sudo chmod 777 /var/www/html/ctf/uploads

# Crear archivo de configuración
sudo nano /var/www/html/ctf/includes/config.php  # Ajusta credenciales
