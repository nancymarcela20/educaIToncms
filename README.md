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

## Guía para uso en git y gihub
---
### Subir proyecto de repo local a repo remoto
#### 1. Crear repositorio remoto
```r
Ingresar a GitHub y crear un repo 
```
#### 2. Cargar repo local al repo remoto
```r
2.1 Ubicarse dentro de la carpeta del proyecto local
2.2 Abrir la consola de Git Bash
2.3 Inspeccionar elementos
    * git --version
    * git config --global --list
    * git help [comandos a buscar]
2.4 Asignar nombre de usuario y correo. Verificar actualización
    * git config --global user.name "username"
    * git config --global user.email "useremail"
    * git config --global --list
2.5 Inicializar repo local
    * git init
2.6 Se valida estado del repo
    * git status
2.7 Se agregan los cambios
    * git add -A -> alista todos los archivos para el commit agrega todos los archivos de golpe)
    * git add "nombre del archivo que se requiere adicionar"
2.8 Se realiza el commit y se agrega al historial del repo
    * git commit -m "que es este commit"
    * git log
2.9 Se indica el repo remoto al que se va a subir la información
    * git remote add origin https://github.com/nancymarcela20/educaIToncms_prueba.git
2.10 Se suben los cambios del repo local al remoto
    * git push -u origin master
2.11 El sistema pide autenticación
```

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
