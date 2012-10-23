DROP DATABASE IF EXISTS domotheque;
CREATE DATABASE IF NOT EXISTS domotheque;

USE domotheque;

CREATE TABLE partenaire(
	part_id INT NOT NULL auto_increment,
	part_raisoc VARCHAR(45) NOT NULL,
	part_email VARCHAR(45) NOT NULL,
	part_tel VARCHAR(12) NOT NULL,
	part_url VARCHAR(150) NULL,
	CONSTRAINT PK_PART PRIMARY KEY (part_id)
)Engine=InnoDB;

CREATE TABLE client(
	cli_id INT NOT NULL auto_increment,
	cli_email VARCHAR(45) NOT NULL,
	cli_pseudo VARCHAR (45) NOT NULL,
	cli_password VARCHAR(45) NOT NULL,
	cli_idpart INT NULL,
	CONSTRAINT PK_CLI PRIMARY KEY (cli_id),
	CONSTRAINT FK_CLIPART FOREIGN KEY (cli_idpart) REFERENCES partenaire(part_id)
)Engine=InnoDB;

CREATE TABLE categorie(
	cat_id INT NOT NULL auto_increment,
	cat_libelle VARCHAR(45) NOT NULL,
	CONSTRAINT PK_CAT PRIMARY KEY (cat_id)
)Engine=InnoDB;

CREATE TABLE produit(
	prod_id INT NOT NULL auto_increment,
	prod_libelle VARCHAR(45) NOT NULL,
	prod_unite INT NOT NULL DEFAULT 1,
	prod_prixTTC FLOAT NOT NULL DEFAULT 0.00,
	prod_datemis DATE NOT NULL,
	prod_idcli INT NOT NULL,
	prod_idcat INT NOT NULL,
	CONSTRAINT PK_PROD PRIMARY KEY (prod_id),
	CONSTRAINT FK_PRODCLI FOREIGN KEY (prod_idcli) REFERENCES client(cli_id),
	CONSTRAINT FK_PRODCAT FOREIGN KEY (prod_idcat) REFERENCES categorie(cat_id)
)Engine=InnoDB;

CREATE TABLE adresse(
	ad_id INT NOT NULL auto_increment,
	ad_ligne1 VARCHAR(45) NOT NULL,
	ad_ligne2 VARCHAR(45) NULL DEFAULT NULL,
	ad_idcli INT NOT NULL,
	CONSTRAINT PK_AD PRIMARY KEY (ad_id),
	CONSTRAINT FK_ADCLI FOREIGN KEY (ad_idcli) REFERENCES client(cli_id)
)Engine=InnoDB;

CREATE TABLE commande(
	cde_id INT NOT NULL auto_increment,
	cde_datedeb DATE NOT NULL,
	cde_datefin DATE NOT NULL,
	cde_idcli INT NOT NULL,
	cde_idprod INT NOT NULL,
	cde_idad INT NOT NULL,
	CONSTRAINT PK_CDE PRIMARY KEY (cde_id),
	CONSTRAINT FK_CDECLI FOREIGN KEY (cde_idcli) REFERENCES client(cli_id),
	CONSTRAINT FK_CDEPROD FOREIGN KEY (cde_idprod) REFERENCES produit(prod_id),
	CONSTRAINT FK_CDEAD FOREIGN KEY (cde_idad) REFERENCES adresse(ad_id)
)Engine=InnoDB;

CREATE TABLE cdeprod(
	cdeprod_id INT NOT NULL auto_increment,
	cdeprod_idcde INT NOT NULL,
	cdeprod_idprod INT NOT NULL,
	cdeprod_qte INT NOT NULL DEFAULT 1,
	CONSTRAINT PK_CDEPROD PRIMARY KEY (cdeprod_id),
	CONSTRAINT FK_CDEPRODCDE FOREIGN KEY (cdeprod_idcde) REFERENCES commande(cde_id),
	CONSTRAINT FK_CDEPRODPROD FOREIGN KEY (cdeprod_idprod) REFERENCES produit(prod_id)
)Engine=InnoDB;

CREATE TABLE ville(
	ville_id INT NOT NULL auto_increment,
	ville_libelle VARCHAR(45) NOT NULL,
	CONSTRAINT PK_VILLE PRIMARY KEY (ville_id)
)Engine=InnoDB;

CREATE TABLE codepostal(
	cp_id INT NOT NULL auto_increment,
	cp_code VARCHAR(10) NOT NULL,
	CONSTRAINT PK_CP PRIMARY KEY (cp_id)
)Engine=InnoDB;

CREATE TABLE cpville(
	cpville_id INT NOT NULL auto_increment,
	cpville_idad INT NOT NULL,
	cpville_idcp INT NOT NULL,
	cpville_idville INT NOT NULL,
	CONSTRAINT PK_CVILLE PRIMARY KEY (cpville_id),
	CONSTRAINT FK_CPVILLEAD FOREIGN KEY (cpville_idad) REFERENCES adresse(ad_id),
	CONSTRAINT FK_CPVILLECP FOREIGN KEY (cpville_idcp) REFERENCES codepostal(cp_id),
	CONSTRAINT FK_CPVILLEVILLE FOREIGN KEY (cpville_idville) REFERENCES ville(ville_id)
)Engine=InnoDB;


/*---------------------------
-- Données test
----------------------------*/
INSERT INTO partenaire(part_raisoc, part_email,part_tel,part_url) VALUES ('Castorama', 'casto@wanadoo.fr', 0553456578, "http://www.castorama.fr/store/");
INSERT INTO partenaire(part_raisoc, part_email,part_tel) VALUES ('Monsier Meubles', 'mrmeuble@orange.fr', 0553846591);
INSERT INTO partenaire(part_raisoc, part_email,part_tel) VALUES ('R&D Factory', 'rdfactory@gmail.com', '+338495653278');

INSERT INTO client(cli_pseudo, cli_email, cli_password, cli_idpart) VALUES ('Castorama', 'casto@wanadoo.fr', 'casto', 1);
INSERT INTO client(cli_pseudo, cli_email, cli_password, cli_idpart) VALUES ('MrMeuble', 'mrmeuble@orange.fr', 'mrmeuble', 2);
INSERT INTO client(cli_pseudo, cli_email, cli_password, cli_idpart) VALUES ('R&DFact', 'rdfactory@gmail.com', 'rdfact', 3);
INSERT INTO client(cli_pseudo, cli_email, cli_password) VALUES ('Bob', 'bricolo@hotmail.fr', 'bicolo');
INSERT INTO client(cli_pseudo, cli_email, cli_password) VALUES ('Avina', 'squadf@atlus.com', 'squadf');

INSERT INTO categorie(cat_libelle) VALUES ('electricite et domotique');
INSERT INTO categorie(cat_libelle) VALUES ('outillage');
INSERT INTO categorie(cat_libelle) VALUES ('plomberie et traitement des eaux');
INSERT INTO categorie(cat_libelle) VALUES ('securite');
INSERT INTO categorie(cat_libelle) VALUES ('quincaillerie et visserie');

INSERT INTO produit(prod_libelle, prod_unite, prod_prixTTC, prod_idcat, prod_idcli, prod_datemis) VALUES ('voltmetre', 1, 15.00, 1, 1,'2012-01-01');
INSERT INTO produit(prod_libelle, prod_unite, prod_prixTTC, prod_idcat, prod_idcli, prod_datemis) VALUES ('perceuse X3', 1, 40.99, 2, 1,'2012-02-02');
INSERT INTO produit(prod_libelle, prod_unite, prod_prixTTC, prod_idcat, prod_idcli, prod_datemis) VALUES ('perceuse M45', 1, 50.50, 2, 2,'2012-03-03');
INSERT INTO produit(prod_libelle, prod_unite, prod_prixTTC, prod_idcat, prod_idcli, prod_datemis) VALUES ('Glu XtraF', 1, 4.60, 5, 2,'2012-04-04');
INSERT INTO produit(prod_libelle, prod_unite, prod_prixTTC, prod_idcat, prod_idcli, prod_datemis) VALUES ('cle a molette', 1, 5.10, 2, 3,'2012-05-05');
INSERT INTO produit(prod_libelle, prod_unite, prod_prixTTC, prod_idcat, prod_idcli, prod_datemis) VALUES ('marteau P1', 1, 10.50, 2, 3,'2011-06-06');
INSERT INTO produit(prod_libelle, prod_unite, prod_prixTTC, prod_idcat, prod_idcli, prod_datemis) VALUES ('bloc waterproof 20x30cm', 1, 22.00, 3, 3,'2011-07-07');
INSERT INTO produit(prod_libelle, prod_unite, prod_prixTTC, prod_idcat, prod_idcli, prod_datemis) VALUES ('vis 0.3mm', 50, 6.55, 5, 3,'2011-08-08');
INSERT INTO produit(prod_libelle, prod_unite, prod_prixTTC, prod_idcat, prod_idcli, prod_datemis) VALUES ('veilleur', 1, 15.20, 4, 5,'2011-09-09');
INSERT INTO produit(prod_libelle, prod_unite, prod_prixTTC, prod_idcat, prod_idcli, prod_datemis) VALUES ('echelle 1m50', 1, 37.00, 2, 3,'2011-10-10');

INSERT INTO adresse(ad_ligne1, ad_idcli) VALUES ('68 rue Ciceron', 1);
INSERT INTO adresse(ad_ligne1, ad_idcli) VALUES ('1 rue Victor Hugo', 2);
INSERT INTO adresse(ad_ligne1, ad_idcli) VALUES ('27 rue Platon', 3);
INSERT INTO adresse(ad_ligne1, ad_idcli) VALUES ('7 rue Galarian', 3);
INSERT INTO adresse(ad_ligne1, ad_idcli) VALUES ('64 rue Montesquieu', 4);
INSERT INTO adresse(ad_ligne1, ad_idcli) VALUES ('47 rue Cury', 5);

INSERT INTO ville(ville_libelle) VALUES ('Bordeaux');
INSERT INTO ville(ville_libelle) VALUES ('Carigan de Bordeaux');
INSERT INTO ville(ville_libelle) VALUES ('Lignan de Bordeaux');
INSERT INTO ville(ville_libelle) VALUES ('Saint-Caprais');

INSERT INTO codepostal (cp_code) VALUES ('33000');
INSERT INTO codepostal (cp_code) VALUES ('33360');
INSERT INTO codepostal (cp_code) VALUES ('33360');
INSERT INTO codepostal (cp_code) VALUES ('33880');

INSERT INTO cpville (cpville_idad, cpville_idcp, cpville_idville) VALUES (3,1,1);
INSERT INTO cpville (cpville_idad, cpville_idcp, cpville_idville) VALUES (4,1,1);
INSERT INTO cpville (cpville_idad, cpville_idcp, cpville_idville) VALUES (2,2,2);
INSERT INTO cpville (cpville_idad, cpville_idcp, cpville_idville) VALUES (3,3,3);
INSERT INTO cpville (cpville_idad, cpville_idcp, cpville_idville) VALUES (4,4,4);
INSERT INTO cpville (cpville_idad, cpville_idcp, cpville_idville) VALUES (5,1,1);

INSERT INTO commande (cde_datedeb, cde_datefin, cde_idcli, cde_idprod, cde_idad) VALUES ('2012-04-26','2012-04-30',5,7,6);
INSERT INTO commande (cde_datedeb, cde_datefin, cde_idcli, cde_idprod, cde_idad) VALUES ('2012-01-10','2012-01-11',4,10,5);
INSERT INTO commande (cde_datedeb, cde_datefin, cde_idcli, cde_idprod, cde_idad) VALUES ('2011-08-03','2012-08-13',4,3,5);

INSERT INTO cdeprod (cdeprod_idcde, cdeprod_idprod, cdeprod_qte) VALUES (1,7,1);
INSERT INTO cdeprod (cdeprod_idcde, cdeprod_idprod, cdeprod_qte) VALUES (2,10,1);
INSERT INTO cdeprod (cdeprod_idcde, cdeprod_idprod, cdeprod_qte) VALUES (3,3,1);