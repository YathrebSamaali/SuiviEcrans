-- suiviecrans.users definition

-- Drop table

-- DROP TABLE suiviecrans.users;

CREATE TABLE suiviecrans.users (
	username varchar NULL,
	id serial4 NOT NULL,
	matricule varchar NULL,
	email varchar NULL,
	telephone varchar NULL,
	adresse varchar NULL
);
-- suiviecrans.admins definition

-- Drop table

-- DROP TABLE suiviecrans.admins;

CREATE TABLE suiviecrans.admins (
	id serial4 NOT NULL,
	username varchar NULL,
	"password" varchar NULL
);
INSERT INTO suiviecrans.admins (username, "password")
VALUES ('admin', 'admin');

-- suiviecrans.ecrans definition

-- Drop table

-- DROP TABLE suiviecrans.ecrans;

CREATE TABLE suiviecrans.ecrans (
	id serial4 NOT NULL,
	numero_ecran varchar NULL,
	emplacement varchar NULL,
	produit varchar NULL,
	"ref" varchar NULL,
	face varchar NULL,
	CONSTRAINT ecrans_pkey PRIMARY KEY (id)
);
-- suiviecrans.utilisation definition

-- Drop table

-- DROP TABLE suiviecrans.utilisation;

CREATE TABLE suiviecrans.utilisation (
	id int4 NOT NULL DEFAULT nextval('suiviecrans.operations_id_seq'::regclass),
	matricule varchar NULL,
	operation varchar NULL,
	numero_ecran varchar NULL,
	etat varchar NULL,
	numero_ligne_cms varchar NULL,
	equipe varchar NULL,
	commentaire varchar NULL,
	"date" date NULL,
	CONSTRAINT operations_pkey PRIMARY KEY (id)
);




