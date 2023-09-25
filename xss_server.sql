DROP DATABASE IF EXISTS xss_server;
CREATE DATABASE xss_server CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE xss_server;

CREATE TABLE usuarios (
	id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL,
    senha VARCHAR(40) NOT NULL,
    foto VARCHAR(50) NOT NULL,
    criado TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE posts (
	id INT PRIMARY KEY AUTO_INCREMENT,
    usuario INT NOT NULL,
    CONSTRAINT fk_usuario FOREIGN KEY (usuario)
    REFERENCES usuarios (id),
    conteudo VARCHAR(500),
    criado TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO usuarios (username, senha, foto) VALUES ("hacker", "7c4a8d09ca3762af61e59520943dc26494f8941b", "f9a8b14e3a8e9e12c0ba4815704cec9d074b4516.png"); -- 123456
INSERT INTO usuarios (username, senha, foto) VALUES ("usuario", "7c222fb2927d828af22f592134e8932480637c0d", "2fc312bbacacc29f7c80ab25059caa9a9c14ff3c.jpg"); -- 12345675
INSERT INTO usuarios (username, senha, foto) VALUES ("chatgpt", "ab0ddc029a7ee633223b4e7fefab5a5b9d87a733", "f78d8dedd5dabf3b8443e0c399bb735e09cd4d60.png"); -- chatgpt
INSERT INTO usuarios (username, senha, foto) VALUES ("gato", "6d3673b42a9a5b9ff6558e3da66e54963a294c0f", "9f9e377d83b6395d44a2632e18142df4083d2f5f.png"); -- miau

-- conteúdo gerado pelo chatgpt
INSERT INTO posts (usuario, conteudo, criado) VALUES (1, "Hoje foi um daqueles dias em que tudo deu errado, mas lembrei da frase 'quanto maior o desafio, maior a recompensa'. Vamos lá, amanhã é um novo dia! Não importa o quão difícil seja a jornada, a perseverança sempre vale a pena.\n💪 #Persistência #SuperandoDesafios", "2023-09-24 20:42:47");
INSERT INTO posts (usuario, conteudo, criado) VALUES (2, "Acabei de ler um artigo incrível sobre os efeitos positivos da meditação na saúde mental. Fiquei inspirado a começar minha jornada de meditação. A prática diária da meditação não apenas alivia o estresse, mas também ajuda a aumentar a clareza mental e a paz interior.\n🧘‍♂️✨ #Meditação #BemEstar", "2023-09-24 20:42:48");
INSERT INTO posts (usuario, conteudo, criado) VALUES (2, "Comemorei meu aniversário hoje com amigos e família. Foi uma festa incrível! Agradeço a todos pelo carinho e pelas mensagens! A vida é um presente precioso, e momentos como este me lembram de valorizar cada dia.\n🎂🥳❤️ #Aniversário #Celebração", "2023-09-24 20:42:49");
INSERT INTO posts (usuario, conteudo, criado) VALUES (1, "Estou trabalhando em um novo projeto de pesquisa na faculdade, explorando as possibilidades da inteligência artificial na área médica. Mal posso esperar para ver os resultados! A IA tem o potencial de revolucionar o diagnóstico e o tratamento de doenças, melhorando a qualidade de vida de milhões de pessoas.\n🧬🤖🏥 #Pesquisa #IA", "2023-09-24 20:42:50");
INSERT INTO posts (usuario, conteudo, criado) VALUES (3, "A leitura é minha paixão, e acabei de terminar um livro que me fez repensar minha vida e minhas escolhas. Livros têm o poder de nos transformar. Cada página é uma jornada para novos horizontes e perspectivas. Qual é o último livro que te inspirou?\n📖✨ #Leitura #Autoconhecimento", "2023-09-24 20:42:51");
INSERT INTO posts (usuario, conteudo, criado) VALUES (4, "Estou refletindo sobre a importância da sustentabilidade. Cada pequena ação conta. Vamos juntos tornar o mundo um lugar melhor para as gerações futuras.\n♻️🌍 #Sustentabilidade #Mudança", "2023-09-24 20:42:52");
INSERT INTO posts (usuario, conteudo, criado) VALUES (1, "Hoje comecei um curso online de fotografia. Capturar momentos e contar histórias através das imagens é uma forma incrível de expressão. Quem mais é apaixonado por fotografia aqui?\n📷🌟 #Fotografia #Arte", "2023-09-24 20:42:53");
INSERT INTO posts (usuario, conteudo, criado) VALUES (2, "As viagens são minha terapia. Explorar novos lugares, experimentar culturas diferentes e conhecer pessoas incríveis enriquece minha vida de maneiras indescritíveis. Qual foi a viagem mais memorável que você já fez?\n✈️🌎 #Viagens #Aventura", "2023-09-24 20:42:54");
INSERT INTO posts (usuario, conteudo, criado) VALUES (4, "Hoje, celebro 5 anos de casamento com a pessoa mais incrível que já conheci. Cada dia ao seu lado é um presente. Amor verdadeiro só cresce com o tempo.\n💑💕 #Amor #AniversárioDeCasamento", "2023-09-24 20:42:55");
INSERT INTO posts (usuario, conteudo, criado) VALUES (2, "Estou envolvido em um projeto de voluntariado que está construindo escolas em comunidades carentes. A educação é a chave para um futuro melhor. Junte-se a nós na missão de tornar a educação acessível a todos.\n📚🏫 #Voluntariado #Educação", "2023-09-24 20:42:56");