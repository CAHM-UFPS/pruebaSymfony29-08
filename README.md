# pruebaSymfony29-08
Prueba Symfony del 29 de agosto

### Endpoints

#### Para UserController

##### GET

> localhost/user/read  ---> Lista todos los usuarios registrados en la base de datos con sus propiedades originales

> localhost/user/read/{email} ---> Lista el usuario si está registrado filtrando por email

##### POST

> localhost/user/create ---> Permite registrar un usuario nuevo

##### PUT

> localhost/user/update/{email} ---> Permite editar un usuario registrado filtrando por email

##### DELETE

> localhost/user/delete/{email} ---> Permite eliminar un usuario por medio del email

#### Para OrderController

##### POST

> localhost/orders/create/{email} ---> Permite crear un pedido y registrarlo en la base de datos mediante el email de un usuario registrado

##### GET

> localhost/orders/read ---> Lista todos los pedidos registrados en la base de datos

> localhost/orders/read/{email} ---> Permite buscar pedidos filtrando por el email del usuario registrado

##### PUT

> localhost/orders/update/user/{email}/order/{id} ---> Permite editar un pedido registrado haciendo el filtrado por el email del usuario

##### DELETE

> localhost/orders/delete/user/{email}/order/{id} ---> Permite eliminar un pedido haciendo el filtrado por el email del usuario
