# Proyecto Desarrollo WEB 2DAM - Examen Final

## Instrucciones de Entrega

1. Crea una carpeta con tu nombre y apellido que contenga el proyecto.
2. Elimina los directorios `vendor` y `migrations` antes de la entrega.
3. Asegúrate de que el proyecto se pueda ejecutar después de recuperar las dependencias de Composer y crear el modelo de datos.

## Descripción del Proyecto

Este proyecto consiste en desarrollar una API REST para la gestión de apartamentos destinados a estudiantes de Cuatrovientos (Apartamentos4V). La API se dividirá en tres partes principales: API de Apartamentos, API de Reservas, y Segurización de las API.

## Arquitectura y Nombrado

El proyecto debe seguir una arquitectura coherente, incluyendo controladores, entidades, repositorios y modelos. Asegúrate de utilizar un nombrado consistente para los componentes del código.

## 1. API de Apartamentos (3 Puntos)

El objetivo de esta API es proporcionar información sobre los apartamentos disponibles. 

### Modelado JSON de Apartamentos

El modelado JSON debe incluir información detallada de los apartamentos, incluyendo fotos. Además, debe indicar si un apartamento está ocupado actualmente y con qué fechas.

## 2. API de Reservas (5 Puntos)

Esta API permite la creación y anulación de reservas.

### Crear Reserva

Permite crear nuevas reservas y valida que el apartamento no esté reservado previamente en esas fechas. Además, verifica que todos los campos del BODY son obligatorios y que el apartamento exista.

### Anular Reserva

Permite anular reservas marcándolas como anuladas y registrando la fecha de anulación. Se debe proporcionar el ID de la reserva a anular, y esta no debe estar anulada previamente.

## 3. Seguridad (1 Punto)

La API de Reservas debe estar securizada por un API KEY. La lista de API KEY está registrada en la tabla de la base de datos llamada `clientes`. Se debe incluir la APIKEY como parámetro en cada llamada a la API de reservas. Si la APIKEY no es correcta, se debe dar un error HTTP de tipo 403.

## 4. Postman (1 Punto)

Crea una colección en Postman que contenga todas las llamadas a la API para poder probar el desarrollo. Exporta el fichero y colócalo en un directorio específico para su entrega.

---

Recuerda que se valorará la arquitectura de la solución, el nombrado coherente, la validación correcta de los datos y la persistencia utilizando ORM/Doctrine. Utiliza el modelo E/R proporcionado para guiar el desarrollo del proyecto.
