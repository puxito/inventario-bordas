CREATE TABLE users (
    idUser INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(45) UNIQUE,
    realname VARCHAR(100),
    dept ENUM('staff','ddf','f&f','fla'),
    
    PRIMARY KEY(idUser)
);

CREATE TABLE computers (
    nexp INT,
    model VARCHAR(45),
    cpu VARCHAR(45),
    ram INT,
    motherboard VARCHAR(45),
    storage INT,
    so ENUM('Windows XP','Windows 7','Windows 10','Windows 11'),
    license VARCHAR(45),
    ip VARCHAR(20),
    mac VARCHAR(45),
    pcname VARCHAR(45),
    netuser VARCHAR(45),
    
    PRIMARY KEY(nexp),
    FOREIGN KEY(netuser) REFERENCES users(username)
);