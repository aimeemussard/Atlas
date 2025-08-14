DROP DATABASE IF EXISTS friends;
CREATE DATABASE friends;

USE friends;

DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS user_gender;
DROP TABLE IF EXISTS gender;
DROP TABLE IF EXISTS user_hobby;
DROP TABLE IF EXISTS hobby;
DROP TABLE IF EXISTS user_pictures;
DROP TABLE IF EXISTS pictures;
DROP TABLE IF EXISTS user_status;
DROP TABLE IF EXISTS status;
DROP TABLE IF EXISTS user_messages;
DROP TABLE IF EXISTS messages;

CREATE TABLE user (
        id              INT             NOT NULL AUTO_INCREMENT,
        firstname       VARCHAR(255)    NOT NULL,
        lastname        VARCHAR(255)    NOT NULL,
        hide_gender     INT             NOT NULL DEFAULT 0,
        birthdate       DATETIME        NOT NULL,
        biography         VARCHAR(255)    NULL,
        zipcode         VARCHAR(10)     NULL,
        city            VARCHAR(255)    NOT NULL,
        country         VARCHAR(255)    NULL,
        email           VARCHAR(255)    NOT NULL UNIQUE,
        salt_password   VARCHAR(255)    NOT NULL,
        password        VARCHAR(255)    NOT NULL,
        PRIMARY KEY (id)
);

CREATE TABLE gender (
        id              INT             NOT NULL AUTO_INCREMENT,
        name            VARCHAR(255)    NOT NULL UNIQUE,
        PRIMARY KEY (id)
);

CREATE TABLE user_gender (
        id_user        INT             NOT NULL,
        id_gender        INT             NULL,
        FOREIGN KEY (id_user) REFERENCES user(id),
        FOREIGN KEY (id_gender) REFERENCES gender(id)
);

CREATE TABLE hobby (
        id              INT             NOT NULL AUTO_INCREMENT,
        name            VARCHAR(255)    NOT NULL UNIQUE,
        PRIMARY KEY (id)
);

CREATE TABLE user_hobby (
        id_user        INT             NOT NULL,
        id_hobby        INT             NULL,
        FOREIGN KEY (id_user) REFERENCES user(id),
        FOREIGN KEY (id_hobby) REFERENCES hobby(id)
);

CREATE TABLE pictures (
        id              INT             NOT NULL AUTO_INCREMENT,
        path            VARCHAR(255)    NOT NULL,
        creation_time     DATETIME      DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
);

CREATE TABLE user_pictures (
        id_user        INT             NOT NULL,
        id_picture        INT             NOT NULL DEFAULT 0,
        FOREIGN KEY (id_user) REFERENCES user(id),
        FOREIGN KEY (id_picture) REFERENCES pictures(id)
);

CREATE TABLE status (
        id              INT             NOT NULL,
        description            VARCHAR(255)    NOT NULL UNIQUE,
        PRIMARY KEY (id)
);

CREATE TABLE user_status (
        id_user        INT             NOT NULL,
        id_status        INT             NOT NULL DEFAULT 1,
        FOREIGN KEY (id_user) REFERENCES user(id),
        FOREIGN KEY (id_status) REFERENCES status(id)
);

CREATE TABLE messages (
        id              INT             NOT NULL AUTO_INCREMENT,
        id_sender        INT             NOT NULL,
        description            VARCHAR(255)    NOT NULL UNIQUE,
        creation_time     DATETIME      DEFAULT CURRENT_TIMESTAMP,
        modification_time        DATETIME       ON UPDATE CURRENT_TIMESTAMP,
        id_recipient         INT             NOT NULL,
        PRIMARY KEY (id)
);

CREATE TABLE user_messages (
        id_user        INT             NOT NULL,
        id_message        INT             NOT NULL,
        FOREIGN KEY (id_user) REFERENCES user(id),
        FOREIGN KEY (id_message) REFERENCES messages(id)
);

INSERT INTO pictures 
                (id, path)
        VALUES          (0, 'https://www.svgrepo.com/show/384671/account-avatar-profile-user-14.svg')
;

INSERT INTO status 
                (id, description)
        VALUES          (1, 'Active'),
                        (0, 'Inactive')
;

INSERT INTO gender
                (name)
        VALUES          ('Man'),
                        ('Non-binary'),
                        ('Woman')
;

INSERT INTO hobby 
                (name)
        VALUES          
                        ('Art'),
                        ("Attraction Parc"),
                        ('Bar'),
                        ('Board Games'),
                        ('Coffee'),
                        ('Cooking'),
                        ('Dance'),
                        ('Documentaries'),
                        ('Drawings'),
                        ('Fashion'),
                        ('Manga'),
                        ('Museums'),
                        ('Music'),
                        ('Podcasts'),
                        ('Sewing'),
                        ('Sport'),
                        ('Reading'),
                        ('Theatre'),
                        ('Video Games')
;
