CREATE DATABASE IF NOT EXISTS Burgheria;
DROP TABLE IF EXISTS Commenti;
DROP TABLE IF EXISTS Voti;
DROP TABLE IF EXISTS Utenti;
DROP TABLE IF EXISTS Prodotti;
DROP TABLE IF EXISTS Categoria;

USE Burgheria;

CREATE TABLE Categoria
(
    `ID` INT NOT NULL AUTO_INCREMENT,
    `Categoria` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`ID`)
) ENGINE = InnoDB;

CREATE TABLE Prodotti
(
    `ID` INT NOT NULL AUTO_INCREMENT,
    `Nome` VARCHAR(50) NOT NULL,
    `Img` VARCHAR(100) NOT NULL,
    `Categoria` INT NOT NULL,
    `Ingredienti` VARCHAR(200),
    `Descrizione` VARCHAR(500),
    PRIMARY KEY (`ID`),
    FOREIGN KEY (`Categoria`) REFERENCES `Categoria` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE Utenti
(
    `ID` INT NOT NULL AUTO_INCREMENT,
    `Password` VARCHAR(30) NOT NULL,
    `Username` VARCHAR(30) NOT NULL,
    `Admin` ENUM('Si', 'No') NOT NULL,
    PRIMARY KEY (`ID`)
) ENGINE = InnoDB;

CREATE TABLE Voti
(
    `ID_Panino` INT NOT NULL,
    `ID_Utente` INT NOT NULL,
    `Voto` ENUM('1', '2', '3', '4', '5') NOT NULL,
    PRIMARY KEY(`ID_Panino`, `ID_Utente`),
    FOREIGN KEY (`ID_Panino`) REFERENCES `Prodotti` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`ID_Utente`) REFERENCES `Utenti` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE Commenti
(
    `ID` INT NOT NULL AUTO_INCREMENT,
    `ID_Panino` INT NOT NULL,
    `ID_Utente` INT NOT NULL,
    `Data_Ora` DATETIME NOT NULL,
    `Contenuto` VARCHAR(500) NOT NULL,
    PRIMARY KEY(`ID`, `ID_Panino`, `ID_Utente`),
    FOREIGN KEY (`ID_Panino`) REFERENCES `Prodotti` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`ID_Utente`) REFERENCES `Utenti` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

INSERT INTO `Categoria` (`Categoria`) VALUES
('Pollo'),
('Manzo'),
('Speciali');

INSERT INTO `Prodotti` (`Nome`, `Img`, `Ingredienti`, `Categoria`, `Descrizione`) VALUES
('Chicken Bacon King', 'img/pollo/chicken_bacon_king.png', 'Bacon;Ketchup;Pollo;Maionese;Formaggio', 1, 'Un nuovo panino epico è arrivato! Pollo croccante, 8 fette di bacon, formaggio filante e salse. Se vi è piaciuto il Bacon King, non potete perdervi questa nuova delizia!'),
('Chicken Royale', 'img/pollo/chicken_royale.png', 'Pollo;Maionese;Lattuga', 1, 'Certe cose non bastano mai – un buon sapore, per esempio. Ecco perché per il tuo Chicken Royal usiamo solo il nostro panino al sesamo extralungo, con pollo avvolto da una saporita impanatura dorata. Mmmh... con questo gusto delizioso nessuno rimarrà a bocca asciutta.'),
('Chicken Royale Bacon Cheese', 'img/pollo/chicken_royale_bacon_cheese.png', 'Bacon;Pomodoro a fette;Maionese;Pollo;Lattuga;Formaggio', 1, 'Un panino al sesamo extralungo, con tanto di pollo avvolto da una saporita impanatura dorata, maionese, bacon, formaggio, lattuga e pomodoro. Il pollo sì che sa quello che vuole!'),
('Crispy Chicken', 'img/pollo/crispy_chicken.png', 'Pomodoro a fette;Maionese;Pollo;Lattuga', 1, 'Succoso pollo con una panatura croccante. Un tocco di spezie. Pomodoro e lattuga fresca. Un bagno di maionese. Non è un sogno: è il nostro irresistibile Crispy Chicken!'),
('Crunchicken', 'img/pollo/crunchicken.png', 'Pane al mais;Doppia maionese;Pomodoro a fette;Lattuga;Pollo croccante', 1, "Pollo croccante, pomodoro, lattuga e doppia maionese, racchiusi in un morbido pane al mais. Vieni a provare il nostro nuovo Crunchicken. Un pollo così non l'hai mai sentito."),
('Specktacular Chicken', 'img/pollo/specktacular_chicken.png', 'Pane al mais;Cipolle fresche fritte;Salsa BBQ;Pollo croccante;Formaggio svizzero;Speck Alto Adige IGP', 1, 'Cotoletta di pollo croccante, formaggio, salsa barbecue, cipolla fritta e delizioso Speck Alto Adige IGP Senfter! Nuovo Specktacular Chicken. Provalo subito!'),

('Specktacular', 'img/manzo/specktacular.png', 'Pane al mais;Carne alla griglia;Cipolle fresche fritte;Salsa BBQ;Formaggio svizzero;Speck Alto Adige IGP', 2, 'Tanta carne alla griglia, formaggio, salsa barbecue, cipolla fritta e delizioso Speck Alto Adige IGP Senfter! Nuovo Specktacular. Resterai a bocca piena. Provalo subito!'),
('Bacon King 3.0 Ranch Sauce', 'img/manzo/bacon_king_3_0_ranch_sauce.png', 'Carne alla griglia;Bacon;Maionese;Ketchup;Formaggio;Salsa Ranch', 2, 'Tanto abbondante quanto gustoso, il nuovo Bacon King 3.0 Ranch Sauce, con 3 strati di carne, 3 strati di formaggio, 8 fette di bacon e tantissima salsa Ranch, saprà conquistarti al primo morso. Provalo subito'),
('Bacon King 3.0', 'img/manzo/bacon_king_3_0.png', 'Carne alla griglia;Bacon;Maionese;Ketchup;Formaggio', 2, "L'evoluzione del Bacon King: 3 strati di carne alla griglia, 3 strati di formaggio e 8 fette di delizioso bacon. Vieni a scoprire Bacon King 3.0 in tutta la sua esagerazione."),
('Bacon King', 'img/manzo/bacon_king.png', 'Carne alla griglia;Ketchup;Maionese;Formaggio', 2, 'Il panino definitivo. La combinazione perfetta di ingredienti. Il gusto sublime del bacon e quello della carne alla griglia, accompagnati da ketchup, maionese e saporito pane al mais: il Bacon King è un panino che non si fa dire di no. Provalo in tutti i nostri ristoranti: ti innamorerai!'),
('Bronx Steakhouse', 'img/manzo/bronx_steakhouse.png', 'Pane al mais;Carne alla griglia;Bacon;Pomodoro a fette;Maionese;Salsa BBQ;Lattuga;Cipolla;Formaggio', 2, 'Un gusto irresistibile per veri amanti dei panini super farciti. 175 grammi di carne di manzo alla griglia e tutti gli ingredienti più amati: bacon, gustoso formaggio cheddar, cipolle croccanti, insalata, pomodoro, salsa BBQ e maionese. Il tutto racchiuso in un soffice pane al mais.'),
('Big King', 'img/manzo/big_king.png', 'Doppia carne;Cipolla fresca;Lattuga;Formaggio', 2, 'Il re degli hamburger è qui. Il nostro BIG KING ti conquisterà con doppia carne di manzo alla griglia, formaggio e deliziosa salsa BIG KING. Un hamburger decisamente maestoso, che, con i suoi 4 pollici di diametro, rende merito al proprio nome.'),
('Big King XXL', 'img/manzo/big_king_xxl.png', 'Doppia carne;Cipolla fresca;Lattuga;Formaggio', 2, 'Extra-Extra-Large! Non è solo una maxi taglia, ma una vera e propria sfida! Con la sua doppia porzione di succosa carne alla griglia, gusto unico della salsa speciale e non una, non due, ma ben quattro fette di gustoso formaggio Cheddar il BIG KING XXL, vuole essere domato. Semplicemente irresistibile.'),
('Hamburger', 'img/manzo/hamburger.png', 'Carne alla griglia;Ketchup;Senape;Cetrioli', 2, "Un capolavoro di pura eleganza. L'entusiasmo per il nostro Hamburger risveglia in alcune persone una vena poetica. Non ci sorprende. In fondo è un autentico capolavoro. Carne di manzo cotta sulla fiamma viva, decorata con saporiti cetrioli: è il vero compimento del piacere."),
('Cheeseburger', 'img/manzo/cheeseburger.png', 'Carne alla griglia;Ketchup;Senape;Formaggio;Cetrioli', 2, 'Quando si dice "Cheeeeeese" sorridono tutti. Certo, perché a chi non verrebbe da pensare al nostro delizioso Cheeseburger: con delicato formaggio Cheddar fuso e carne di manzo cotta sulla fiamma viva. Allora, anche tu sorridi già?'),

('Pretzel Bacon Pub Cheeseburger', 'img/speciali/pretzel_bacon_pub_cheeseburger.jpg', 'Pane pretzel;Hamburger;Formaggio;Cipolle;Salsa alla birra;Bacon affumicato;Senape;Cetrioli', 3, '100 grammi di manzo fresco, salsa di formaggio alla birra, pancetta affumicata in legno di mele, senape affumicata al miele, cipolle fritte croccanti, sottaceti e una fetta di formaggio muenster, il tutto su un panino pretzel extra morbido. Vieni per il panino Pretzel.'),
('Pretzel Bacon Pub Double Cheeseburger', 'img/speciali/pretzel_bacon_pub_double_cheeseburger.jpg', 'Pane pretzel;Hamburger;Formaggio;Cipolle;Salsa alla birra;Bacon affumicato;Senape;Cetrioli', 3, '200 grammi di manzo fresco, salsa di formaggio alla birra, pancetta affumicata in legno di mele, senape affumicata al miele, cipolle fritte croccanti, sottaceti e una fetta di formaggio muenster, il tutto su un panino pretzel extra morbido. Vieni per il panino Pretzel.'),
('Pretzel Bacon Pub Triple Cheeseburger', 'img/speciali/pretzel_bacon_pub_triple_cheeseburger.jpg', 'Pane pretzel;Hamburger;Formaggio;Cipolle;Salsa alla birra;Bacon affumicato;Senape;Cetrioli', 3, '300 grammi di manzo fresco, salsa di formaggio alla birra, pancetta affumicata in legno di mele, senape affumicata al miele, cipolle fritte croccanti, sottaceti e una fetta di formaggio muenster, il tutto su un panino pretzel extra morbido. Vieni per il panino Pretzel.');

INSERT INTO `Utenti` (`Password`, `Username`, `Admin`) VALUES
('Admin', 'Admin', 'Si'),
('Luca', 'userL', 'No'),
('Paolo', 'userP', 'No'),
('Laura', 'userL', 'No'),
('Valeria', 'userV', 'No');

INSERT INTO `Voti` (`ID_Panino`, `ID_Utente`, `Voto`) VALUES
(1, 2, '3'),
(6, 2, '4'),
(9, 4, '2'),
(13, 3, '5'),
(14, 5, '1'),
(16, 5, '3'),
(18, 4, '4');

INSERT INTO `Commenti` (`ID_Panino`, `ID_Utente`, `Data_Ora`, `Contenuto`) VALUES
(1, 2, '2018-01-01 13:26', 'Panino passabile, niente di speciale.'),
(6, 2, '2018-02-03 16:25', 'Panino perfetto per gli amanti del pollo come me.'),
(9, 4, '2018-06-01 12:55', 'Un vero King del Bacon, croccante e delizioso'),
(13, 3, '2019-04-02 22:00', 'Squisito! Una vera delizia per il palato, se ne avete occasione prendetelo.'),
(14, 5, '2020-05-19 19:30', 'Sono rimasta molto delusa, un panino veramente povero, da non prendere mai!!!'),
(16, 5, '2020-07-08 15:47', 'Panino molto particolare ma niente di speciale.'),
(18, 4, '2020-09-08 21:32', 'Un panino veramente assurdo, talmente grande che non sono riuscita a finirlo. Roba da matti.');

