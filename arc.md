cafeteria-soa-php/
│── services/
│   ├── empleados/
│   │   ├── src/
│   │   │   ├── EmployeeService.php             # Implementación del servicio
│   │   │   ├── Employee.php                    # Clases de datos (DTOs)
│   │   ├── wsdl/
│   │   │   ├── EmployeeService.wsdl            # Definición WSDL del servicio
│   │   ├── tests/
│   │   ├── composer.json                       # Dependencias del servicio
│   ├── sucursales/
│   │   ├── ... (estructura similar a empleados)
│   ├── productos/
│   │   ├── ...
│   ├── ventas/
│   │   ├── ...
│
│── service-registry/
│   ├── uddi/
│   │   ├── uddi-server/                        # Implementación de UDDI (podría ser una adaptación o simulación)
│   │   ├── publish-services.php                # Script para publicar servicios en UDDI
│
│── esb/
│   ├── routes/                                 # Rutas de mensajes y transformaciones
│   ├── transformations/                        # Transformaciones XSLT
│   ├── security/                               # Configuración de seguridad (WS-Security)
│   ├── logging/                                # Configuración de logs
│
│── client-applications/
│   ├── cliente-empleados/
│   │   ├── src/
│   │   ├── composer.json
│   ├── cliente-sucursales/
│   │   ├── ...
│
│── database/
│── docs/
│── composer.json                       # Dependencias generales del proyecto
│── README.md
│── .gitignore