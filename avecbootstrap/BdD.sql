DROP DATABASE IF EXISTS domotheque;
CREATE DATABASE IF NOT EXISTS domotheque;

USE domotheque;

/*==============================================================*/
/* Table : PARTENAIRE                                           */
/*==============================================================*/
create table PARTENAIRE 
(
   PART_ID              integer                        not null auto_increment,
   PART_RAISOC          long varchar                   not null,
   PART_EMAIL           long varchar                   not null,
   PART_TEL             char(12)                       null,
   constraint PK_PARTENAIRE primary key (PART_ID)
)Engine=InnoDB;

/*==============================================================*/
/* Table : CLIENT                                               */
/*==============================================================*/
create table CLIENT 
(
   CLI_ID               integer                        not null auto_increment,
   PART_ID              integer                        null,
   CLI_EMAIL            long varchar                   not null,
   CLI_PASSWORD         long varchar                   not null,
   CLI_PSEUDO           long varchar                   not null,
   constraint PK_CLIENT primary key (CLI_ID),
   constraint FK_CLIENT_CONSIDERE_PARTENAI foreign key (PART_ID)
      references PARTENAIRE (PART_ID)
        on update restrict
        on delete restrict
)Engine=InnoDB;

/*==============================================================*/
/* Table : VILLE                                                */
/*==============================================================*/
create table VILLE 
(
   VILLE_ID             integer                        not null auto_increment,
   VILLE_NOM            long varchar                   not null,
   VILLE_CP             integer                        not null,
   constraint PK_VILLE primary key (VILLE_ID)
)Engine=InnoDB;

/*==============================================================*/
/* Table : ADRESSE                                              */
/*==============================================================*/
create table ADRESSE 
(
   AD_ID                integer                        not null auto_increment,
   CLI_ID               integer                        not null,
   VILLE_ID             integer                        not null,
   AD_LIGNE1            long varchar                   not null,
   AD_LIGNE2            long varchar                   null default null,
   constraint PK_ADRESSE primary key (AD_ID),
   constraint FK_ADRESSE_HABITE_CLIENT foreign key (CLI_ID)
      references CLIENT (CLI_ID)
        on update restrict
        on delete restrict,
   constraint FK_ADRESSE_CPVILLE_VILLE foreign key (VILLE_ID)
      references VILLE (VILLE_ID)
        on update restrict
        on delete restrict
)Engine=InnoDB;

/*==============================================================*/
/* Table : CATEGORIE                                            */
/*==============================================================*/
create table CATEGORIE 
(
   CAT_ID               integer                        not null auto_increment,
   CAT_LIBELLE          long varchar                   not null,
   constraint PK_CATEGORIE primary key (CAT_ID)
)Engine=InnoDB;

/*==============================================================*/
/* Table : PRODUIT                                              */
/*==============================================================*/
create table PRODUIT 
(
   PROD_ID              integer                        not null auto_increment,
   CLI_ID               integer                        not null,
   CAT_ID               integer                        not null,
   PROD_LIBELLE         long varchar                   not null,
   PROD_UNITE           integer                        not null default 1,
   PROD_PRIXTTC         float                          not null default 0.00,
   PROD_DATEAJ          timestamp                      not null,
   constraint PK_PRODUIT primary key (PROD_ID),
   constraint FK_PRODUIT_APPARTIEN_CATEGORI foreign key (CAT_ID)
      references CATEGORIE (CAT_ID)
        on update restrict
        on delete restrict,
   constraint FK_PRODUIT_PROPOSE_CLIENT foreign key (CLI_ID)
      references CLIENT (CLI_ID)
        on update restrict
        on delete restrict
)Engine=InnoDB;

/*==============================================================*/
/* Table : COMMANDE                                             */
/*==============================================================*/
create table COMMANDE 
(
   CDE_ID               integer                        not null auto_increment,
   CLI_ID               integer                        not null,
   AD_ID                integer                        not null,
   CDE_DATEDEB          timestamp                      not null,
   CDE_DATEFIN          timestamp                      not null,
   CDE_ACCEPTEE         smallint                       not null default false,
   constraint PK_COMMANDE primary key (CDE_ID),
   constraint FK_COMMANDE_DETIENT_CLIENT foreign key (CLI_ID)
      references CLIENT (CLI_ID)
        on update restrict
        on delete restrict,
   constraint FK_COMMANDE_LIVRE_ADRESSE foreign key (AD_ID)
      references ADRESSE (AD_ID)
        on update restrict
        on delete restrict
)Engine=InnoDB;

/*==============================================================*/
/* Table : CDEPROD                                              */
/*==============================================================*/
create table CDEPROD 
(
   PROD_ID              integer                        not null,
   CDE_ID               integer                        not null,
   QTE                  integer                        not null,
   constraint PK_CDEPROD primary key clustered (PROD_ID, CDE_ID),
   constraint FK_CDEPROD_CDEPROD_PRODUIT foreign key (PROD_ID)
      references PRODUIT (PROD_ID)
        on update restrict
        on delete restrict,
   constraint FK_CDEPROD_CDEPROD2_COMMANDE foreign key (CDE_ID)
      references COMMANDE (CDE_ID)
        on update restrict
        on delete restrict
)Engine=InnoDB;

/*==============================================================*/
/* Table : COMMENTAIRE                                          */
/*==============================================================*/
create table COMMENTAIRE 
(
   COM_ID               integer                        not null auto_increment,
   CLI_ID               integer                        not null,
   CLI_IDCLI			integer						   not null,
   COM_DATE             timestamp                      not null,
   COM_CONTENU          long varchar                   not null,
   constraint PK_COMMENTAIRE primary key (COM_ID),
   constraint FK_COMMENTA_LAISSE_CLIENT foreign key (CLI_ID)
      references CLIENT (CLI_ID),
   constraint FK_COMMENTA_LAISSE_CLIID foreign key (CLI_IDCLI)
      references CLIENT (CLI_ID)
        on update restrict
        on delete restrict
)Engine=InnoDB;

/*==============================================================*/
/* Table : RANG                                                 */
/*==============================================================*/
create table RANG 
(
   RANG_ID              integer                        not null auto_increment,
   CLI_ID               integer                        not null,
   RANG_NBR             integer                        not null,
   constraint PK_RANG primary key (RANG_ID),
   constraint FK_RANG_ATTRIBUE_CLIENT foreign key (CLI_ID)
      references CLIENT (CLI_ID)
        on update restrict
        on delete restrict
)Engine=InnoDB;

/*==============================================================*/
/* Données test			                                         */
/*==============================================================*/
insert into PARTENAIRE (PART_RAISOC, PART_EMAIL, PART_TEL) values ('Castorama', 'casto@wanadoo.fr', 0553456578);
insert into PARTENAIRE (PART_RAISOC, PART_EMAIL, PART_TEL) values ('Monsier Meubles', 'mrmeuble@orange.fr', 0553846591);
insert into PARTENAIRE (PART_RAISOC, PART_EMAIL, PART_TEL) values ('R&D Factory', 'rdfactory@gmail.com', '+338495653278');

insert into CLIENT (CLI_PSEUDO, CLI_EMAIL, CLI_PASSWORD, PART_ID) values ('Castorama', 'casto@wanadoo.fr', 'casto', 1);
insert into CLIENT (CLI_PSEUDO, CLI_EMAIL, CLI_PASSWORD, PART_ID) values ('MrMeuble', 'mrmeuble@orange.fr', 'mrmeuble', 2);
insert into CLIENT (CLI_PSEUDO, CLI_EMAIL, CLI_PASSWORD, PART_ID) values ('R&DFact', 'rdfactory@gmail.com', 'rdfact', 3);
insert into CLIENT (CLI_PSEUDO, CLI_EMAIL, CLI_PASSWORD) values ('Bob', 'bricolo@hotmail.fr', 'bicolo');
insert into CLIENT (CLI_PSEUDO, CLI_EMAIL, CLI_PASSWORD) values ('Avina', 'squadf@atlus.com', 'squadf');

insert into VILLE (VILLE_NOM, VILLE_CP) values ('Bordeaux', '33000');
insert into VILLE (VILLE_NOM, VILLE_CP) values ('Carigan de Bordeaux', '33360');
insert into VILLE (VILLE_NOM, VILLE_CP) values ('Lignan de Bordeaux', '33360');
insert into VILLE (VILLE_NOM, VILLE_CP) values ('Saint-Caprais', '33880');

insert into ADRESSE (CLI_ID, VILLE_ID, AD_LIGNE1) values (1,1,'68 rue Ciceron');
insert into ADRESSE (CLI_ID, VILLE_ID, AD_LIGNE1) values (2,1,'1 rue Victor Hugo');
insert into ADRESSE (CLI_ID, VILLE_ID, AD_LIGNE1) values (3,2,'27 rue Platon');
insert into ADRESSE (CLI_ID, VILLE_ID, AD_LIGNE1) values (3,3,'7 rue Galarian');
insert into ADRESSE (CLI_ID, VILLE_ID, AD_LIGNE1, AD_LIGNE2) values (4,4,'64 rue Montesquieu','Appartement 2');
insert into ADRESSE (CLI_ID, VILLE_ID, AD_LIGNE1) values (5,1,'47 rue Cury');

insert into CATEGORIE (CAT_LIBELLE) values ('electricite et domotique');
insert into CATEGORIE (CAT_LIBELLE) values ('outillage');
insert into CATEGORIE (CAT_LIBELLE) values ('plomberie et traitement des eaux');
insert into CATEGORIE (CAT_LIBELLE) values ('securite');
insert into CATEGORIE (CAT_LIBELLE) values ('quincaillerie et visserie');

insert into PRODUIT (PROD_LIBELLE, PROD_UNITE, PROD_PRIXTTC, CAT_ID, CLI_ID, PROD_DATEAJ) values ('voltmetre', 1, 15.00, 1, 1,'2012-01-01');
insert into PRODUIT (PROD_LIBELLE, PROD_UNITE, PROD_PRIXTTC, CAT_ID, CLI_ID, PROD_DATEAJ) values ('perceuse X3', 1, 40.99, 2, 1,'2012-02-02');
insert into PRODUIT (PROD_LIBELLE, PROD_UNITE, PROD_PRIXTTC, CAT_ID, CLI_ID, PROD_DATEAJ) values ('perceuse M45', 1, 50.50, 2, 2,'2012-03-03');
insert into PRODUIT (PROD_LIBELLE, PROD_UNITE, PROD_PRIXTTC, CAT_ID, CLI_ID, PROD_DATEAJ) values ('Glu XtraF', 1, 4.60, 5, 2,'2012-04-04');
insert into PRODUIT (PROD_LIBELLE, PROD_UNITE, PROD_PRIXTTC, CAT_ID, CLI_ID, PROD_DATEAJ) values ('cle a molette', 1, 5.10, 2, 3,'2012-05-05');
insert into PRODUIT (PROD_LIBELLE, PROD_UNITE, PROD_PRIXTTC, CAT_ID, CLI_ID, PROD_DATEAJ) values ('marteau P1', 1, 10.50, 2, 3,'2011-06-06');
insert into PRODUIT (PROD_LIBELLE, PROD_UNITE, PROD_PRIXTTC, CAT_ID, CLI_ID, PROD_DATEAJ) values ('bloc waterproof 20x30cm', 1, 22.00, 3, 3,'2011-07-07');
insert into PRODUIT (PROD_LIBELLE, PROD_UNITE, PROD_PRIXTTC, CAT_ID, CLI_ID, PROD_DATEAJ) values ('vis 0.3mm', 50, 6.55, 5, 3,'2011-08-08');
insert into PRODUIT (PROD_LIBELLE, PROD_UNITE, PROD_PRIXTTC, CAT_ID, CLI_ID, PROD_DATEAJ) values ('veilleur', 1, 15.20, 4, 5,'2011-09-09');
insert into PRODUIT (PROD_LIBELLE, PROD_UNITE, PROD_PRIXTTC, CAT_ID, CLI_ID, PROD_DATEAJ) values ('echelle 1m50', 1, 37.00, 2, 3,'2011-10-10');

insert into COMMANDE (CDE_DATEDEB, CDE_DATEFIN, CLI_ID, AD_ID, CDE_ACCEPTEE) values ('2012-04-26','2012-04-30',5,6,true);
insert into COMMANDE (CDE_DATEDEB, CDE_DATEFIN, CLI_ID, AD_ID, CDE_ACCEPTEE) values ('2012-01-10','2012-01-11',4,5,true);
insert into COMMANDE (CDE_DATEDEB, CDE_DATEFIN, CLI_ID, AD_ID, CDE_ACCEPTEE) values ('2011-01-10','2012-01-11',4,5,true);
insert into COMMANDE (CDE_DATEDEB, CDE_DATEFIN, CLI_ID, AD_ID, CDE_ACCEPTEE) values ('2011-08-03','2012-08-13',4,5,true);
insert into COMMANDE (CDE_DATEDEB, CDE_DATEFIN, CLI_ID, AD_ID) values ('2012-10-17', '2012-10-19',5,6);

insert into CDEPROD (CDE_ID, PROD_ID, QTE) values (1,7,1);
insert into CDEPROD (CDE_ID, PROD_ID, QTE) values (2,10,1);
insert into CDEPROD (CDE_ID, PROD_ID, QTE) values (3,10,1);
insert into CDEPROD (CDE_ID, PROD_ID, QTE) values (4,3,1);
insert into CDEPROD (CDE_ID, PROD_ID, QTE) values (5,5,1);

insert into RANG (CLI_ID, RANG_NBR) values (1,5);
insert into RANG (CLI_ID, RANG_NBR) values (1,5);
insert into RANG (CLI_ID, RANG_NBR) values (1,5);
insert into RANG (CLI_ID, RANG_NBR) values (1,1);
insert into RANG (CLI_ID, RANG_NBR) values (1,3);
insert into RANG (CLI_ID, RANG_NBR) values (2,3);
insert into RANG (CLI_ID, RANG_NBR) values (2,4);
insert into RANG (CLI_ID, RANG_NBR) values (2,4);
insert into RANG (CLI_ID, RANG_NBR) values (3,5);
insert into RANG (CLI_ID, RANG_NBR) values (3,5);
insert into RANG (CLI_ID, RANG_NBR) values (3,5);
insert into RANG (CLI_ID, RANG_NBR) values (3,5);
insert into RANG (CLI_ID, RANG_NBR) values (3,5);
insert into RANG (CLI_ID, RANG_NBR) values (3,4);
insert into RANG (CLI_ID, RANG_NBR) values (3,4);
insert into RANG (CLI_ID, RANG_NBR) values (3,4);
insert into RANG (CLI_ID, RANG_NBR) values (5,4);

insert into COMMENTAIRE (CLI_ID, COM_DATE, COM_CONTENU, CLI_IDCLI) values (3, '2012-10-19 18:20:07','fiable',4);
insert into COMMENTAIRE (CLI_ID, COM_DATE, COM_CONTENU, CLI_IDCLI) values (3, '2012-01-09 13:20:07','Impeccable',2);
insert into COMMENTAIRE (CLI_ID, COM_DATE, COM_CONTENU, CLI_IDCLI) values (2, '2012-01-09 13:20:07', 'Ok',5);


