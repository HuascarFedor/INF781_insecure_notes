-- Base de datos: insecure_notes

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100),
    email VARCHAR(150),
    password VARCHAR(100) -- Almacenará MD5 (32 chars)
);
CREATE TABLE notas (
    id SERIAL PRIMARY KEY,
    titulo VARCHAR(200),
    contenido TEXT,
    user_id INTEGER REFERENCES users(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);