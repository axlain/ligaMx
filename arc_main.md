cafeteria-api/
│── src/                     
│   ├── config/               # Configuración de la base de datos
│   ├── empleados/            # Servicio de empleados
│   │   ├── controllers/      # Controladores de la API
│   │   ├── models/           # Modelos de datos
│   │   ├── services/         # Lógica de negocio
│   │   ├── routes/           # Definición de rutas y endpoints
│   │   ├── index.php         # Punto de entrada del servicio
│   ├── sucursales/           
│   ├── productos/            
│   ├── ventas/               
│
│── api-gateway/              
│   ├── middleware/           # Seguridad, logging, etc.
│   ├── routes/               # Enrutamiento hacia los servicios
│   ├── index.php             # Configuración general del API Gateway
│
│── database/                 
│── tests/                    
│── docs/                    
│── .env                      # Variables de entorno (credenciales)
│── README.md                 
│── .gitignore                
