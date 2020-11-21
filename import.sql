DROP DATABASE IF EXISTS Burgheria;
CREATE DATABASE Burgheria;
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
    `Nome` VARCHAR(30) NOT NULL,
    `Img` VARCHAR(100) NOT NULL,
    `Categoria` INT NOT NULL,
    `Ingredienti` VARCHAR(200),
    PRIMARY KEY (`ID`),
    FOREIGN KEY (`Categoria`) REFERENCES `Categoria` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;


INSERT INTO `Categoria` (`Categoria`) VALUES
('Pollo'),
('Manzo'),
('Speciali'),
('Bevande');

INSERT INTO `Prodotti` (`Nome`, `Img`, `Ingredienti`, `Categoria`) VALUES
('Chicken Bacon King', 'img/pollo/chicken_bacon_king.png', 'Bacon;Ketchup;Pollo;Maionese;Formaggio', 1),
('Chicken Royale', 'img/pollo/chicken_royale.png', 'Pollo,Maionese,Lattuga', 1),
('Chicken Royale Bacon Cheese', 'img/pollo/chicken_royale_bacon_cheese.png', 'Bacon;Pomodoro a fette;Maionese;Pollo;Lattuga;Formaggio', 1),
('Crispy Chicken', 'img/pollo/crispy_chicken.png', 'Pomodoro a fette;Maionese;Pollo;Lattuga', 1),
('Crunchicken', 'img/pollo/crunchicken.png', 'Pane al mais;Doppia maionese;Pomodoro a fette;Lattuga;Pollo croccante', 1),
('Specktacular Chicken', 'img/pollo/specktacular_chicken.png', 'Pane al mais;Cipolle fresche fritte;Salsa BBQ;Pollo croccante;Formaggio svizzero;Speck Alto Adige IGP', 1),

('Specktacular', 'img/manzo/specktacular.png', 'Pane al mais;Carne alla griglia;Cipolle fresche fritte;Salsa BBQ;Formaggio svizzero;Speck Alto Adige IGP', 2),
('Bacon King 3.0 Ranch Sauce', 'img/manzo/bacon_king_3_0_ranch_sauce.png', 'Carne alla griglia;Bacon;Maionese;Ketchup;Formaggio;Salsa Ranch', 2),
('Bacon King 3.0', 'img/manzo/bacon_king_3_0.png', 'Carne alla griglia;Bacon;Maionese;Ketchup;Formaggio', 2),
('Bacon King', 'img/manzo/bacon_king.png', 'Carne alla griglia;Ketchup;Maionese;Formaggio', 2),
('Bronx Steakhouse', 'img/manzo/bronx_steakhouse.png', 'Pane al mais;Carne alla griglia;Bacon;Pomodoro a fette;Maionese;Salsa BBQ;Lattuga;Cipolla;Formaggio', 2),
('Big King', 'img/manzo/big_king.png', 'Doppia carne;Cipolla fresca;Lattuga;Formaggio', 2),
('Big King XXL', 'img/manzo/big_king_xxl.png', 'Doppia carne; Cipolla fresca;Lattuga;Formaggio', 2),
('Hamburger', 'img/manzo/hamburger.png', 'Carne alla griglia;Ketchup;Senape;Cetrioli', 2),
('Cheeseburger', 'img/manzo/cheeseburger.png', 'Carne alla griglia;Ketchup;Senape;Formaggio;Cetrioli', 2),

('Pretzel Bacon Pub Cheeseburger', 'img/speciali/pretzel_bacon_pub_cheeseburger.jpg', 'Pane pretzel;Hamburger;Formaggio;Cipolle;Salsa alla birra;Bacon affumicato;Senape;Cetrioli', 3),
('Pretzel Bacon Pub Double Cheeseburger', 'img/speciali/pretzel_bacon_pub_double_cheeseburger.jpg', 'Pane pretzel;Hamburger;Formaggio;Cipolle;Salsa alla birra;Bacon affumicato;Senape;Cetrioli', 3),
('Pretzel Bacon Pub Triple Cheeseburger', 'img/speciali/pretzel_bacon_pub_triple_cheeseburger.jpg', 'Pane pretzel;Hamburger;Formaggio;Cipolle;Salsa alla birra;Bacon affumicato;Senape;Cetrioli', 3),

('Acqua minerale', 'img/bevande/acqua_minerale.jpg', NULL, 4),
('Birra', 'img/bevande/birra.jpg', NULL, 4),
('CocaCola zero', 'img/bevande/cocacola_zero.jpg', NULL, 4),
('CocaCola', 'img/bevande/cocacola.jpg', NULL, 4),
('Fanta', 'img/bevande/fanta.jpg', NULL, 4),
('Sprite', 'img/bevande/sprite.jpg', NULL, 4),
('Succo di frutta', 'img/bevande/succo_di_frutta.jpg', NULL, 4),
('The', 'img/bevande/the.jpg', NULL, 4);