# Diagrama de bases de datos

1. Abrir: [memaid.live](https://mermaid.live/)
2. Pegar el codigo debajo:

```
erDiagram
    Usuarios {
        bigint id PK
        varchar Nombre
        varchar Apellidos
        varchar Correo
        varchar DNI
        bigint Telefono
        varchar DireccionCompleta
        text FotoPerfil
        boolean esDueno
        boolean esCuidador
        boolean esAdmin
        boolean cuentaActiva
    }
    
    Duenos {
        bigint idUsuario PK, FK
        bigint idMascota PK, FK
    }
    
    Mascotas {
        bigint id PK
        text Foto
        text Descripcion
        enum Tipo
    }
    
    Cuidadores {
        bigint idUsuario PK, FK
        enum TiposDeMascotas
        decimal Tarifa
        text Descripcion
        enum ServiciosAdicionales
        tinyint Valoracion
    }
    
    TiposDeMascotas {
        bigint id PK
        varchar Nombre
    }
    
    ServiciosAdicionales {
        bigint id PK
        varchar Nombre
        bigint Coste
    }
    
    Reservas {
        bigint id PK
        bigint idMascota FK
        bigint idCuidador FK
        datetime FechaInicio
        datetime FechaFin
        boolean esAceptadaPorCuidador
        tinyint Valoracion
        text Resena
        text ComentariosAdicionales
    }
    
    Usuarios ||--o{ Duenos : ""
    Usuarios ||--o{ Cuidadores : ""
    Duenos ||--o{ Mascotas : ""
    Mascotas ||--o{ Reservas : ""
    Cuidadores ||--o{ Reservas : ""
    Cuidadores }o--|| TiposDeMascotas : ""
    Mascotas }o--|| TiposDeMascotas : ""
    Cuidadores }o--|| ServiciosAdicionales : ""

```