#TareaAPI
**Mini proyecto para mostrar consumo de API y grafico de Unidad de Fomento en codeigniter 4** 
### Acerca de

- Se utiliza el Framework Codeigniter 4. para montar rapidamente, utilizar "php spark serve"
- PostgreSql 15, crear base de datos en este caso 'TestAPIDB', ingresar datos en archivo .env (renombrar archivo env).
- El sistema utiliza crud, por lo que el certificado cacert.pem debe estar configurado correctamente en php.ini para solicitudes seguras.
- El sistema utiliza la api de https://postulaciones.solutoria.cl/index.html , se asume que el Schema de esta pagina es el correcto.
- El sistema hace una solicidtud de token JWT, el usuario debe ser proporsionado por usted en el campo API_USERNAME de .env .

### Consideraciones
- Solo se almacenan en la base de datos los datos relacionados con la unidad de Fomento
- Se asume que solo los campos de fecha y valor pueden cambiar, el resto se ingresan a la base de datos estaticamente.

### Dependencias
##### El sistema utiliza los siguientes cdn para su funcionamiento:
- Bootstrap 5 y su stylesheet
- JQuery 3.6.3
- Datatables 1.13.1 y su stylesheet
- Toastr 2.1.4 y su stylesheet
- Chart.js 4.2.0 y chartjs-adapter-date-fns

##### Las siguientes configuraciones de php.ini se descomentaron para su utilizacion:
- curl.cainfo
- extension=curl
- extension=intl
- extension=mbstring
- extension=pgsql


