DROP DATABASE IF EXISTS H5AI;
CREATE DATABASE H5AI;

USE H5AI;

DROP TABLE IF EXISTS tag;
DROP TABLE IF EXISTS color;
DROP TABLE IF EXISTS file;
DROP TABLE IF EXISTS tag_file;
DROP TABLE IF EXISTS color_file;


CREATE TABLE tag (
    id              INT             NOT NULL AUTO_INCREMENT,
    name            VARCHAR(255)    NOT NULL UNIQUE,
    PRIMARY KEY (id)
);

CREATE TABLE color (
    id              INT             NOT NULL AUTO_INCREMENT,
    value            VARCHAR(255)    NOT NULL UNIQUE,
    PRIMARY KEY (id)
);


CREATE TABLE file (
    id              INT             NOT NULL AUTO_INCREMENT,
    Path            VARCHAR(400)    NOT NULL UNIQUE,
    PRIMARY KEY (id)
);


CREATE TABLE tag_file (
    id_tag             INT             NOT NULL,
    id_file            INT    NOT NULL ,
    FOREIGN KEY (id_tag) REFERENCES tag(id),
    FOREIGN KEY (id_file) REFERENCES file(id)
);

CREATE TABLE color_file (
    id_tag             INT             NOT NULL,
    id_file            INT    NOT NULL ,
    FOREIGN KEY (id_tag) REFERENCES tag(id),
    FOREIGN KEY (id_file) REFERENCES file(id)
);
