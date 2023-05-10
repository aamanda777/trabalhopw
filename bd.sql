CREATE DATABASE trabalho;

USE trabalho;

CREATE TABLE usuarios (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  senha VARCHAR(100) NOT NULL
);

CREATE TABLE documentos (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(100) NOT NULL,
  descricao TEXT,
  arquivo LONGBLOB NOT NULL,
  formato ENUM('pdf', 'doc', 'docx') NOT NULL,
  data_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  id_usuario INT NOT NULL,
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

CREATE TABLE permissoes (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_documento INT NOT NULL,
  id_usuario INT NOT NULL,
  permissao ENUM('visualizar', 'editar', 'excluir') NOT NULL,
  FOREIGN KEY (id_documento) REFERENCES documentos(id),
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

ALTER TABLE documentos ADD COLUMN extensao VARCHAR(10) NOT NULL AFTER arquivo;
