CREATE TABLE controller (
	id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE method (
	id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    title varchar(255) NOT NULL,
    controller int(11) NOT NULL,
    access varchar(255) DEFAULT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_controller_method FOREIGN KEY (controller)
    REFERENCES controller(id)
);

CREATE TABLE users (
	id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    level varchar(20) DEFAULT 'user',
    PRIMARY KEY (id)
);