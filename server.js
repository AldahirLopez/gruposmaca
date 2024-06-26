const express = require('express');
const mysql = require('mysql2');
const bodyParser = require('body-parser');
const cors = require('cors');

const app = express();
const port = process.env.PORT || 8000;

// Configuración de las conexiones a las bases de datos
const dbConfig = {
    primera_db: {
        host: 'localhost',
        user: 'root',
        password: '',
        database: 'gruposmaca'
    },
    segunda_db: {
        host: 'localhost',
        user: 'root',
        password: '',
        database: 'armonia'
    }
    // Agrega más bases de datos si es necesario
};

// Crear conexiones a las bases de datos
const connection1 = mysql.createConnection(dbConfig.primera_db);
const connection2 = mysql.createConnection(dbConfig.segunda_db);

// Conectar a las bases de datos (puedes implementar aquí la lógica de conexión)

// Middleware para parsear el body de las peticiones
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// Middleware CORS para permitir solicitudes desde todos los orígenes
app.use(cors());

// Ruta para verificar la existencia de registros en la tabla Datos_Servicio_Anexo_30 (base de datos armonia) según id_servicio
app.get('/api/verificar-registro', (req, res) => {
    const idServicio = req.query.id_servicio; // Obtener id_servicio del parámetro de consulta

    if (!idServicio) {
        res.status(400).json({ error: 'Parámetro id_servicio no proporcionado' });
        return;
    }

    const sql = 'SELECT COUNT(*) AS count FROM datos_servicio_anexo_30 WHERE servicio_anexo_id = ?'; // Ajustar según tu estructura
    connection2.query(sql, [idServicio], (err, results) => {
        if (err) {
            console.error('Error al ejecutar la consulta en la base de datos armonia:', err);
            res.status(500).json({ error: 'Error al verificar el registro' });
            return;
        }
        const existeRegistro = results[0].count > 0;
        res.json({ existe: existeRegistro });
    });
});

// Middleware estático para servir archivos estáticos (CSS, imágenes, etc.)
app.use(express.static('public'));

// Iniciar el servidor
app.listen(port, () => {
    console.log(`Servidor Express escuchando en http://localhost:${port}`);
});
