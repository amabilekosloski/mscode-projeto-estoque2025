-- Create categoria table
CREATE TABLE categoria (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(50) NOT NULL
);

-- Create produto table
CREATE TABLE produtos (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  descricao TEXT,
  categoria_id INT,
  data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
  quantidade_inicial INT,
  quantidade_disponivel INT,
  valor INT,
  FOREIGN KEY (categoria_id) REFERENCES categoria(id)
);

-- Create usuario table
CREATE TABLE usuario (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL
);

-- Create venda table
CREATE TABLE venda (
  id INT PRIMARY KEY AUTO_INCREMENT,
  data_venda DATETIME DEFAULT CURRENT_TIMESTAMP,
  cpf_cliente VARCHAR(11),
  status ENUM('pendente', 'finalizada', 'cancelada') NOT NULL DEFAULT 'pendente'
);

-- Create venda_item table
CREATE TABLE venda_item (
  id INT PRIMARY KEY AUTO_INCREMENT,
  venda_id INT,
  produto_id INT,
  quantidade INT NOT NULL,
  preco_unitario DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (venda_id) REFERENCES venda(id),
  FOREIGN KEY (produto_id) REFERENCES produto(id)
);

CREATE TABLE logins (
  id INT PRIMARY KEY AUTO_INCREMENT,
  email VARCHAR(255) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL
);
