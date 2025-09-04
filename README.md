# MiChampion_TFG
![Logo del Proyecto](public/michampion_oscuro.png)

## 🎓 Trabajo Fin de Grado

MiChampion_TFG es el **Trabajo Fin de Grado** desarrollado como parte de mis estudios en Desarrollo de Aplicaciones Web.  
El proyecto consiste en una **aplicación web interactiva** que permite a los usuarios explorar, valorar y registrar sus hamburguesas favoritas, inspirada en la experiencia de *The Champion's Burger*.


## 🎯 Objetivo del proyecto

El objetivo principal de MiChampion_TFG es **recrear la experiencia de un restaurante virtual**, donde los usuarios puedan:

- Consultar las hamburguesas disponibles.
- Valorar cada hamburguesa según sus preferencias.
- Crear una lista personalizada de las mejores opciones.

  
## 🛠️ Tecnologías utilizadas

- **Frontend:** HTML, CSS, JavaScript  
- **Backend:** PHP  
- **Base de datos:** >MySQL
  
<br><br>
# 🚀 Instalación y Requisitos
## Requisitos

Para ejecutar MiChampion_TFG necesitas:

- **Servidor web** con soporte PHP (por ejemplo, XAMPP, WAMP o MAMP)  
- **PHP 7 o superior**  
- **MySQL** para la base de datos  
- **Navegador moderno** (Chrome, Firefox, Edge, etc.)

## Instalación
1. **Clonar el repositorio**:

   ```bash
   git clone https://github.com/lygarmo/MiChampion_TFG.git

2. **Coloca los archivos en la carpeta raíz de tu servidor web
(por ejemplo, htdocs en XAMPP)**

3. **Importar la base de datos:**
   - Abre phpMyAdmin o tu gestor MySQL
   - Crea una base de datos llamada michampion (o el nombre que prefieras)
   - Importa el archivo SQL con las tablas y datos iniciales (si tienes uno, por ejemplo michampion.sql)
  
4. **Configurar la conexión a la base de datos:**
   - Abre el archivo Conexion.php
   - Modifica las variables según tu servidor:
     ```php
      $host = "localhost";       // usualmente 'localhost'
      $usuario = "root";         // tu usuario de MySQL
      $password = "";            // tu contraseña de MySQL
      $baseDatos = "michampion"; // nombre de la base de datos

5. **Ya puedes abrir tu aplicacion en el navegador**
    ```php
    http://localhost/MiChampion_TFG/


