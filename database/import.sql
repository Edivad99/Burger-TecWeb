CREATE DATABASE IF NOT EXISTS Burgheria;
DROP TABLE IF EXISTS Eventi;
DROP TABLE IF EXISTS Commenti;
DROP TABLE IF EXISTS Voti;
DROP TABLE IF EXISTS Utenti;
DROP TABLE IF EXISTS Prodotti;
DROP TABLE IF EXISTS Categoria;

USE Burgheria;

CREATE TABLE Eventi
(
    `ID` INT NOT NULL AUTO_INCREMENT,
    `Nome` VARCHAR(100) NOT NULL,
    `Data_Evento` DATE NOT NULL,
    `Luogo_Evento` VARCHAR(150),
    `Descrizione` VARCHAR(800),
    PRIMARY KEY(`ID`)
 ) ENGINE = InnoDB;

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
    `Username` VARCHAR(30) NOT NULL,
    `Password` VARCHAR(32) NOT NULL,
    `Admin` BOOLEAN NOT NULL,
    PRIMARY KEY (`ID`)
) ENGINE = InnoDB;

CREATE TABLE Voti
(
    `ID_Panino` INT NOT NULL,
    `ID_Utente` INT NOT NULL,
    `Voto` INT NOT NULL,
    PRIMARY KEY(`ID_Panino`, `ID_Utente`),
    FOREIGN KEY (`ID_Panino`) REFERENCES `Prodotti` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`ID_Utente`) REFERENCES `Utenti` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE Commenti
(
    `ID` INT NOT NULL AUTO_INCREMENT,
    `ID_Panino` INT NOT NULL,
    `ID_Utente` INT NOT NULL,
    `Ora_Pubblicazione` DATETIME NOT NULL,
    `Contenuto` VARCHAR(500) NOT NULL,
    PRIMARY KEY(`ID`, `ID_Panino`, `ID_Utente`),
    FOREIGN KEY (`ID_Panino`) REFERENCES `Prodotti` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`ID_Utente`) REFERENCES `Utenti` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

INSERT INTO `Eventi` (`ID`, `Nome`, `Data_Evento`, `Luogo_Evento`, `Descrizione`) VALUES
(1, 'QUARANTINO', '2020/11/18, 19:00-02:00', 'Via Luigi Luzzati, 10 Padova, PD', "Anche durante il periodo di Lockdown gli eventi della Burgheria Padovana non mancano. Ordina a casa il nuovo Quarantino, il panino pensato per non farti mancare niente, neanche in quarantena! Ma l'evento non finisce qua, in tutte le ordinazioni che riceveremo questa sera avranno un Qr-code per potervi collegare in diretta al nostro video-evento con musica e non solo, così da poter fare festa tutti insieme al sicuro nelle nostre case. Partecipa anche tu!"),
(2, 'GIORNATA MONDIALE DEL PANINO', '2020/11/21, 19:00-02:00', 'Via Luigi Luzzati, 10 Padova, PD', "Apertura speciale per festeggiare la giornata mondiale del Panino. Per l'occasione avremo panini con soli ingredienti tradizionali italiani e con pane a scelta tra mantovana, cioppa oppure bastone, tutte forme di pane tipiche del territorio. Non perdere l'occasione di poter gustare un buon panino in questa serata speciale!"),
(3, 'GIORNATA MONDIALE DEL PANINO', '2019/11/21, 19:00-02:00', 'Via Luigi Luzzati, 10 Padova, PD', "Non perdere l'occasione di poter gustare un buon panino in questa serata speciale!"),
(4, 'DUE CUORI E UN PANINO', '2021/02/14, 19:00-02:00', 'Via Luigi Luzzati, 10 Padova, PD', "Approfitta dell'apertura speciale. In occasione della festa degli innamorati potrai gustare, insieme alla tua dolce metà, il nuovo panino: San Valentino. Questo panino è stato pensato apposta per essere mangiato da due persone. Chiama per ordinare da casa oppure per prenotare un tavolo. Ti(Vi) aspettiamo!"),
(5, 'MEX NIGHT', '2021/04/08, 19:00-02:00', 'Via Luigi Luzzati, 10 Padova, PD', "Serata messicana! Per l'occasione ci saranno non solo panini, ma anche altri piatti tipici messicani come tacos e burritos. Vivi anche tu questo tuffo nella cultura messicana in compagnia. Per l'occasione avremo anche una piccola band che ci intratterrà per tutta la serata con musica tipica. Non mancare!"),
(6, "GIORNATA MONDIALE DELL'HAMBURGER", '2021/05/28, 19:00-02:00', 'Via Luigi Luzzati, 10 Padova, PD', "Festeggia con Burgheria Padovana la giornata mondiale dell'Hamburger. Per l'occasione si potra ordinare il nuovo <abbr title=""United States of America"" lang=""en"">USA</abbr>, il nuovo panino pensato apposta per portare l'America anche qua a Padova! Gustati la buonissima carne di black angus con il cheddar tra due fette di pane al latte croccante con i semi di sesamo. Ti aspettiamo!"),
(7, 'COMPLEANNO BURGERIA PADOVANA', '2021/08/20, 19:00-02:00', 'Via Luigi Luzzati, 10 Padova, PD', "Festeggia con noi questi incredibili due anni della Burgheria Padovana. Non mancare in questa serata piena di mini-eventi e regali per i nostri amati clienti. All'evento potranno partecipare anche i nostri amici da casa, quindi non hai scuse per mancare!"),
(8, 'COMPLEANNO BURGERIA PADOVANA', '2020/08/20, 19:00-02:00', 'Via Luigi Luzzati, 10 Padova, PD', "E' stato un anno davvero pieno di bellissimi ricordi, emozioni ma anche qualche situazione difficile. Vieni a condividere con tutti noi di Burgeria Padovana com'è stato quest'anno con la compagnia dei nostri fantastici panini. Sicuramente non mancheranno regali e sorprese per i clienti più affezionati. Ovviamente non possiamo escludere i nostri amici da casa. Non mancate!"),
(9, "BURGHERIA'S GOT TALENT", '2021/03/12, 19:00-02:00', 'Via Luigi Luzzati, 10 Padova, PD', 'Partecipa a questa splendida serata dedicata interamente ai nostri amati clienti! Durante questo evento gli iscritti dovrannon mostrare i loro più strebilianti talenti, sia ai presenti che ai nostri amici da casa. Dopodichè i talenti più votati verranno premiati con panini e gift card della Burgheria. Che aspetti, chiama e iscriviti anche tu!'),
(10, 'PANINO PRIMA DEGLI ESAMI', '2021/06/15, 19:00-02:00', 'Via Luigi Luzzati, 10 Padova, PD', "Cari studenti, venite a eliminare l'ansia pre-esami con i nostri fantastici panini, per voi uno sconto del 50% su tutto il menu. Vedrete, 100 e lode assicurato!"),
(11, 'SERATA CON CHEF RUBIO', '2021/06/30, 19:00-02:00', 'Via Luigi Luzzati, 10 Padova, PD', 'Serata speciale in compagnia dello chef Gabriele Rubini, conosciuto meglio come Chef Rubio. Venite a fare due chiacchere con lo Chef mentre assaggiate le sue speciali creazioni fatte apposta per la Brgheria Padovana. Non mancate!'),
(12, "L'HAMBURGHER E IL SECCHIONE", '2021/07/15, 19:00-02:00', 'Via Luigi Luzzati, 10 Padova, PD', "Serata speciale per i nostri universitari che hanno appena finito la sessione estiva. Chiunque abbia preso 30 in un qualsiasi esame di quest'ultima sessione otterrà un panino a scelta gratis. Dimostriamo al mondo che gli hamburgher sono del carburante fantastico per studiare al top!");

INSERT INTO `Categoria` (`ID`, `Categoria`) VALUES
(1, 'Pollo'),
(2, 'Manzo'),
(3, 'Speciali');

INSERT INTO `Prodotti` (`ID`, `Nome`, `Img`, `Ingredienti`, `Categoria`, `Descrizione`) VALUES
(1, 'Chicken Bacon King', 'img/pollo/chicken_bacon_king.png', 'Bacon;Ketchup;Pollo;Maionese;Formaggio', 1, 'Un nuovo panino epico è arrivato! Pollo croccante, 8 fette di bacon, formaggio filante e salse. Se vi è piaciuto il Bacon King, non potete perdervi questa nuova delizia!'),
(2, 'Chicken Royale', 'img/pollo/chicken_royale.png', 'Pollo;Maionese;Lattuga', 1, 'Certe cose non bastano mai – un buon sapore, per esempio. Ecco perché per il tuo Chicken Royal usiamo solo il nostro panino al sesamo extralungo, con pollo avvolto da una saporita impanatura dorata. Mmmh... con questo gusto delizioso nessuno rimarrà a bocca asciutta.'),
(3, 'Chicken Royale Bacon Cheese', 'img/pollo/chicken_royale_bacon_cheese.png', 'Bacon;Pomodoro a fette;Maionese;Pollo;Lattuga;Formaggio', 1, 'Un panino al sesamo extralungo, con tanto di pollo avvolto da una saporita impanatura dorata, maionese, bacon, formaggio, lattuga e pomodoro. Il pollo sì che sa quello che vuole!'),
(4, 'Crispy Chicken', 'img/pollo/crispy_chicken.png', 'Pomodoro a fette;Maionese;Pollo;Lattuga', 1, 'Succoso pollo con una panatura croccante. Un tocco di spezie. Pomodoro e lattuga fresca. Un bagno di maionese. Non è un sogno: è il nostro irresistibile Crispy Chicken!'),
(5, 'Crunchicken', 'img/pollo/crunchicken.png', 'Pane al mais;Doppia maionese;Pomodoro a fette;Lattuga;Pollo croccante', 1, "Pollo croccante, pomodoro, lattuga e doppia maionese, racchiusi in un morbido pane al mais. Vieni a provare il nostro nuovo Crunchicken. Un pollo così non l'hai mai sentito."),
(6, 'Specktacular Chicken', 'img/pollo/specktacular_chicken.png', 'Pane al mais;Cipolle fresche fritte;Salsa BBQ;Pollo croccante;Formaggio svizzero;Speck Alto Adige IGP', 1, 'Cotoletta di pollo croccante, formaggio, salsa barbecue, cipolla fritta e delizioso Speck Alto Adige IGP Senfter! Nuovo Specktacular Chicken. Provalo subito!'),

(7, 'Specktacular', 'img/manzo/specktacular.png', 'Pane al mais;Carne alla griglia;Cipolle fresche fritte;Salsa BBQ;Formaggio svizzero;Speck Alto Adige IGP', 2, 'Tanta carne alla griglia, formaggio, salsa barbecue, cipolla fritta e delizioso Speck Alto Adige IGP Senfter! Nuovo Specktacular. Resterai a bocca piena. Provalo subito!'),
(8, 'Bacon King 3.0 Ranch Sauce', 'img/manzo/bacon_king_3_0_ranch_sauce.png', 'Carne alla griglia;Bacon;Maionese;Ketchup;Formaggio;Salsa Ranch', 2, 'Tanto abbondante quanto gustoso, il nuovo Bacon King 3.0 Ranch Sauce, con 3 strati di carne, 3 strati di formaggio, 8 fette di bacon e tantissima salsa Ranch, saprà conquistarti al primo morso. Provalo subito'),
(9, 'Bacon King 3.0', 'img/manzo/bacon_king_3_0.png', 'Carne alla griglia;Bacon;Maionese;Ketchup;Formaggio', 2, "L'evoluzione del Bacon King: 3 strati di carne alla griglia, 3 strati di formaggio e 8 fette di delizioso bacon. Vieni a scoprire Bacon King 3.0 in tutta la sua esagerazione."),
(10, 'Bacon King', 'img/manzo/bacon_king.png', 'Carne alla griglia;Ketchup;Maionese;Formaggio', 2, 'Il panino definitivo. La combinazione perfetta di ingredienti. Il gusto sublime del bacon e quello della carne alla griglia, accompagnati da ketchup, maionese e saporito pane al mais: il Bacon King è un panino che non si fa dire di no. Provalo in tutti i nostri ristoranti: ti innamorerai!'),
(11, 'Bronx Steakhouse', 'img/manzo/bronx_steakhouse.png', 'Pane al mais;Carne alla griglia;Bacon;Pomodoro a fette;Maionese;Salsa BBQ;Lattuga;Cipolla;Formaggio', 2, 'Un gusto irresistibile per veri amanti dei panini super farciti. 175 grammi di carne di manzo alla griglia e tutti gli ingredienti più amati: bacon, gustoso formaggio cheddar, cipolle croccanti, insalata, pomodoro, salsa BBQ e maionese. Il tutto racchiuso in un soffice pane al mais.'),
(12, 'Big King', 'img/manzo/big_king.png', 'Doppia carne;Cipolla fresca;Lattuga;Formaggio', 2, 'Il re degli hamburger è qui. Il nostro BIG KING ti conquisterà con doppia carne di manzo alla griglia, formaggio e deliziosa salsa BIG KING. Un hamburger decisamente maestoso, che, con i suoi 4 pollici di diametro, rende merito al proprio nome.'),
(13, 'Big King XXL', 'img/manzo/big_king_xxl.png', 'Doppia carne;Cipolla fresca;Lattuga;Formaggio', 2, 'Extra-Extra-Large! Non è solo una maxi taglia, ma una vera e propria sfida! Con la sua doppia porzione di succosa carne alla griglia, gusto unico della salsa speciale e non una, non due, ma ben quattro fette di gustoso formaggio Cheddar il BIG KING XXL, vuole essere domato. Semplicemente irresistibile.'),
(14, 'Hamburger', 'img/manzo/hamburger.png', 'Carne alla griglia;Ketchup;Senape;Cetrioli', 2, "Un capolavoro di pura eleganza. L'entusiasmo per il nostro Hamburger risveglia in alcune persone una vena poetica. Non ci sorprende. In fondo è un autentico capolavoro. Carne di manzo cotta sulla fiamma viva, decorata con saporiti cetrioli: è il vero compimento del piacere."),
(15, 'Cheeseburger', 'img/manzo/cheeseburger.png', 'Carne alla griglia;Ketchup;Senape;Formaggio;Cetrioli', 2, 'Quando si dice "Cheeeeeese" sorridono tutti. Certo, perché a chi non verrebbe da pensare al nostro delizioso Cheeseburger: con delicato formaggio Cheddar fuso e carne di manzo cotta sulla fiamma viva. Allora, anche tu sorridi già?'),

(16, 'Pretzel Bacon Pub Cheeseburger', 'img/speciali/pretzel_bacon_pub_cheeseburger.png', 'Pane pretzel;Hamburger;Formaggio;Cipolle;Salsa alla birra;Bacon affumicato;Senape;Cetrioli', 3, '100 grammi di manzo fresco, salsa di formaggio alla birra, pancetta affumicata in legno di mele, senape affumicata al miele, cipolle fritte croccanti, sottaceti e una fetta di formaggio muenster, il tutto su un panino pretzel extra morbido. Vieni per il panino Pretzel.'),
(17, 'Pretzel Bacon Pub Double Cheeseburger', 'img/speciali/pretzel_bacon_pub_double_cheeseburger.png', 'Pane pretzel;Hamburger;Formaggio;Cipolle;Salsa alla birra;Bacon affumicato;Senape;Cetrioli', 3, '200 grammi di manzo fresco, salsa di formaggio alla birra, pancetta affumicata in legno di mele, senape affumicata al miele, cipolle fritte croccanti, sottaceti e una fetta di formaggio muenster, il tutto su un panino pretzel extra morbido. Vieni per il panino Pretzel.'),
(18, 'Pretzel Bacon Pub Triple Cheeseburger', 'img/speciali/pretzel_bacon_pub_triple_cheeseburger.png', 'Pane pretzel;Hamburger;Formaggio;Cipolle;Salsa alla birra;Bacon affumicato;Senape;Cetrioli', 3, '300 grammi di manzo fresco, salsa di formaggio alla birra, pancetta affumicata in legno di mele, senape affumicata al miele, cipolle fritte croccanti, sottaceti e una fetta di formaggio muenster, il tutto su un panino pretzel extra morbido. Vieni per il panino Pretzel.');

INSERT INTO `Utenti` (`ID`, `Username`, `Password`, `Admin`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1),
(2, 'Davide', 'ee11cbb19052e40b07aac0ca060c23ee', 0),
(3, 'Matteo', 'ee11cbb19052e40b07aac0ca060c23ee', 0),
(4, 'Laura', 'ee11cbb19052e40b07aac0ca060c23ee', 0),
(5, 'Cristiano','ee11cbb19052e40b07aac0ca060c23ee', 0),
(6, 'Alessandro', 'ee11cbb19052e40b07aac0ca060c23ee', 0),
(7, 'Anna', 'ee11cbb19052e40b07aac0ca060c23ee', 0),
(8, 'Cesare', 'ee11cbb19052e40b07aac0ca060c23ee', 0),
(9, 'Picasso', 'ee11cbb19052e40b07aac0ca060c23ee', 0),
(10, 'Van Gogh', 'ee11cbb19052e40b07aac0ca060c23ee', 0),
(11, 'Alessandro Borghese', 'ee11cbb19052e40b07aac0ca060c23ee', 0),
(12, 'Homer', 'ee11cbb19052e40b07aac0ca060c23ee', 0),
(13, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 0);

/* admin o user come password */

INSERT INTO `Voti` (`ID_Panino`, `ID_Utente`, `Voto`) VALUES
(1, 2, 3),
(1, 5, 1),
(2, 7, 4),
(3, 6, 5),
(3, 9, 3),
(4, 4, 2),
(5, 3, 3),
(5, 8, 2),
(6, 2, 4),
(7, 10, 4),
(8, 7, 4),
(8, 5, 5),
(9, 4, 4),
(9, 2, 2),
(10, 8, 3),
(11, 9, 4),
(12, 11, 2),
(12, 4, 4),
(13, 3, 5),
(13, 2, 3),
(13, 11, 5),
(14, 5, 1),
(15, 9, 2),
(15, 3, 3),
(16, 5, 3),
(16, 10, 4),
(17, 7, 4),
(18, 4, 5);

INSERT INTO `Commenti` (`ID_Panino`, `ID_Utente`, `Ora_Pubblicazione`, `Contenuto`) VALUES
(1, 10, '2018-01-11 17:26', 'Panino passabile, niente di speciale.'),
(2, 12, '2018-04-11 12:45', 'Mmmm... Pollo!.'),
(3, 2, '2019-07-21 13:38', 'Una soluzione ideale come alternativa al manzo.'),
(4, 8, '2020-06-13 12:01', 'Veni, vidi... me lo magnai'),
(6, 8, '2020-07-03 14:25', 'Panino perfetto per gli amanti del pollo come me.'),
(7, 4, '2020-08-18 15:11', 'Buono ma poco sostanzioso.'),
(8, 6, '2018-01-01 20:20', 'Un panino formidabile, mi ricorda casa.'),
(9, 7, '2018-09-12 12:55', 'Un vero King del Bacon, croccante e delizioso.'),
(10, 4, '2018-06-01 12:01', 'Una versione mini del king bacon, a sto punto prendete direttamente quello!'),
(11, 9, '2019-03-21 21:12', 'Ne ho visto uno prendere vita e scappare dal locale, ho paura di sapere con cosa sono fatti sti panini'),
(12, 11, '2019-04-02 22:45', 'Un panino croccante, buono e con ingredienti freschi. Con questo voto andrò a confermare o a ribaltare il risultato. Il mio voto è... diesci'),
(13, 3, '2019-11-24 17:00', 'Squisito! Una vera delizia per il palato, se ne avete occasione prendetelo.'),
(13, 6, '2019-08-05 13:28', 'Uno dei migliori panini che abbia mai mangiato, se potessi vivrei solo di questi.'),
(13, 8, '2019-09-15 21:20', 'Veramente buono, si sentono gli ingredienti di qualità.'),
(13, 10, '2019-06-21 19:13', 'Che vergogna si vede che è una brutta copia del panino del MC, ma almeno questo non sa di plastica.'),
(13, 2, '2019-10-02 22:00', "Non so il perchè di tutti questi commenti entusiasti. L'ho provato ma non è niente di che in realtà."),
(14, 5, '2020-05-19 19:30', 'Sono rimasta molto delusa, un panino veramente povero, da non prendere mai!!!'),
(16, 5, '2020-07-08 15:47', 'Panino molto particolare ma niente di speciale.'),
(18, 4, '2020-09-08 21:32', 'Un panino veramente assurdo, talmente grande che non sono riuscita a finirlo. Roba da matti.'),
(14, 3, '2019-01-11 12:18', 'Tanto semplice quanto delizioso, super!'),
(4, 5, '2019-01-25 19:33', 'La croccantezza di questo panino me la sognerò di notte, è perfetta'),
(18, 10, '2019-01-28 20:14', 'Per essere buono è buono... un pò pesantino però'),
(2, 3, '2018-04-10 20:48', "Con questi inredienti nostrani è tutta un'altra cosa rispetto ai panini dei fastfood"),
(6, 12, '2018-11-28 00:28', 'Il nome dice tutto! un sogno per gli amanti del pollo come me'),
(2, 8, '2019-09-27 19:39', 'Leggermente secco, non male però'),
(1, 7, '2019-03-06 15:21', "Il re di tutti i panini. L'accoppiata bacon-pollo è assuramente buona"),
(2, 10, '2020-03-10 12:50', "Panino fenomenale, del pollo così non l'ho mai mangiato"),
(16, 9, '2019-04-04 01:22', 'Ho scoperto da poco questa Burgheria Padovana. Un posto spaziale, per non parlare dei panini che sono di un altro universo'),
(9, 8, '2020-10-07 13:21', 'Davvero pieno di ingredienti, da mangiare dopo che si è digiunato per tutto il giorno'),
(8, 5, '2020-02-03 01:05', 'Dopo che ho mangiato devo sentirmi sazio. Finalmente con questo Bacon King 3.0 ci riesco, fantastico. La salsa Ranch da quel tocco in più che lo rende veramente speciale'),
(3, 4, '2020-07-21 21:49', 'Pensate ad un panino da sogno....Questo è meglio'),
(6, 9, '2019-05-29 12:58', 'Davvero sorpendente. La combinazione di speck, pollo e formaggio svizzero mi ha aperto un mondo tutto nuovo'),
(6, 11, '2020-10-15 01:43', 'Fidatevi, se non avete mai mangiato questo panino non sapete cosa vul dire vivere'),
(1, 6, '2019-06-18 22:09', 'Sempre il solito panino, niente di che rispetto a quelli della concorrenza'),
(18, 8, '2020-06-29 15:38', 'Non sono un amante del pretzel, mi sa che dovrò ricredermi però con questa prelibatezza'),
(8, 7, '2019-08-15 01:48', 'Non so se sia stato il cuoco a scivolare e mettere tutta questa salsa Ranch o cosa...'),
(4, 2, '2020-09-21 12:53', 'Semplicemente una imitazione di quello del Burger King... fatta MOLTO meglio però'),
(7, 3, '2019-07-01 23:23', 'Che dire, è davvero spektacolare ;)'),
(10, 11, '2020-01-06 00:04', 'Burger king, il giusto panino da re. Strepitoso'),
(13, 12, '2020-04-09 01:12', "Talmente grande che ci puoi sfamare un'intera squadra di rugby"),
(18, 7, '2020-04-08 14:22', 'Mi sono ritrovato catapultato in Germania, impressionante da quanto buono. La salsa alla birra è quel tocco incredibile che non mi aspettavo');
