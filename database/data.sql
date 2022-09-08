INSERT INTO controller (`name`) VALUES ('users');
INSERT INTO controller (`name`) VALUES ('dashboard');

INSERT INTO method (`name`,`title`,`controller`,`access`) VALUES ('login','Login',1,NULL);
INSERT INTO method (`name`,`title`,`controller`,`access`) VALUES ('index','Painel',2,'user');
INSERT INTO method (`name`,`title`,`controller`,`access`) VALUES ('index','Usuários',1,'admin');
INSERT INTO method (`name`,`title`,`controller`,`access`) VALUES ('new','Novo usuário',1,'admin');
INSERT INTO method (`name`,`title`,`controller`,`access`) VALUES ('edit','Edição de usuário',1,'admin');

INSERT INTO users (`name`,`email`,`password`,`level`) VALUES ('root','root@root.com','$2y$10$UX/6yh4unB/4FojLuwNRXOkihmnI5a7VrpKuOFgt6Q4894pbX/DCi','user');