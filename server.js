const express = require('express');
const cors = require('cors');
const mysql = require('mysql2');

const app = express();

const port = 3000;

app.use(express.json()); 
app.use(cors()); 


app.use(function(req, res, next) {
  res.header("Access-Control-Allow-Origin", "http://localhost:5173");
  next();
});


// Configurações de conexão com o banco de dados
const db = mysql.createConnection({
  host: '34.95.242.142',
  user:  'root',
  password: 'sStvK?Uezdfi8?0',
  database: 'petshop_db',
  port: '3306'
});

// Verifica se a conexão foi estabelecida com sucesso
db.connect((err) => {
  if (err) {
    console.error('Erro ao conectar ao banco de dados:', err);
  } else {
    console.log('Conexão bem-sucedida com o banco de dados!');
  }
});


// Rotas

// Rota de registro
app.post('/api/register', (req, res) => {
  const { email, password, passwordGerente } = req.body;

  // Insere os dados na tabela "usuarios"
  const query = 'INSERT INTO usuarios (email, senha, senhaAcesso) VALUES (?, ?, ?)';
  db.query(query, [email, password, passwordGerente], (err, result) => {
    if (err) {
      console.error('Erro ao inserir os dados:', err);
      res.status(500).json({ message: 'Erro ao registrar usuário' });
    } else {
      console.log('Usuário registrado com sucesso!');
      res.status(200).json({ message: 'Usuário registrado com sucesso' });
    }
  });
});


// Inicia o servidor
app.listen(port, () => {
  console.log(`Servidor ouvindo na porta ${port}`);
});
