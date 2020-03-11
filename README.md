---
# Gestor de contenidos de Sitio Web

## Descripción y contexto
---
Este proyecto permite registrar, editar y ocultar información de un determinado Sitio Web

## Requisitos previos
---
### 1. Instalar git en el pc
En la pagina de GIT https://git-scm.com/ descargar el aplicativo e instalarlo dependiendo del sistema operativo.

### 2. Crear cuenta en GitHub
Ingresar a la página https://github.com/ y crear allí la cuenta.

## Guía para uso de git y gihub
---
### 1. Subir proyecto de repo local a repo remoto
#### 1.1 Crear repositorio remoto
```r
Ingresar a GitHub y crear un repo 
```
#### 1.2. Crear repo local y subir a remoto
```r
1.2.1 Ubicarse dentro de la carpeta del proyecto local
1.2.2 Abrir la consola de Git Bash
1.2.3 Inspeccionar elementos
    * git --version
    * git config --global --list
    * git help [comandos a buscar]
1.2.4 Asignar nombre de usuario y correo. Verificar actualización
    * git config --global user.name "username"
    * git config --global user.email "useremail"
    * git config --global --list
1.2.5 Inicializar repo local
    * git init
1.2.6 Se valida estado del repo
    * git status
1.2.7 Se agregan los cambios
    * git add -A -> alista todos los archivos para el commit agrega todos los archivos de golpe)
    * git add "nombre del archivo que se requiere adicionar"
1.2.8 Se realiza el commit y se agrega al historial del repo
    * git commit -m "que es este commit"
    * git log
1.2.9 Se indica el repo remoto al que se va a subir la información
    * git remote add origin https://github.com/nancymarcela20/educaIToncms_prueba.git
1.2.10 Se suben los cambios del repo local al remoto
    * git push -u origin master
1.2.11 El sistema pide autenticación
```

### 2. Ignorar fichero en Git
```r
2.1 Se debe crear un archivo .gitignore y escribir dentro los fichero que se debe ignorar al subir los cambios realizados en el proyecto. 
2.2 Si el proyecto se esta compilando con netbeans se debe ignorar el fichero nbproject
2.3 Si ya se había subido el fichero, se debe obligar a GIT a olvidarlo borrando cache
    * git rm -r --cached .
    * git add .
    * git commit -m "Ahora mi .gitignore ya ignora normalmente."
    * git push -u origin master
```

### 3. Hacer uso de ramas de prueba para revisar la información antes de fusionarla con la rama master remota

## Código de conducta 

A este repositorio actualmente se le esta dando mantenimiento por parte del grupo de desarrollo de la Unidad de Educación Virtual de la UFPS. Es un desarrollo con código PHP.

## Autor/es
---
Grupo de la Unidad de Educación Virtual de la UFPS

## Licencia 
---
El software de este repositorio está licenciado bajo una licencia [GNU General Public License v3.0]

## Referencias

Este código esta basado en el lenguaje de programación PHP.
