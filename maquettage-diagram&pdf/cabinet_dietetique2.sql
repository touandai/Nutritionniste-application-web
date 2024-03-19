-- Database: applications

-- DROP DATABASE IF EXISTS applications;
                              --CREATION DE LA BASE DE DONNES 
							  
-- CREATE DATABASE applications
--    WITH
--    OWNER = postgres
--    ENCODING = 'UTF8'
--    LC_COLLATE = 'French_France.1252'
--    LC_CTYPE = 'French_France.1252'
--    LOCALE_PROVIDER = 'libc'
--    TABLESPACE = pg_default
--    CONNECTION LIMIT = -1
--    IS_TEMPLATE = False;
                                          --CREATION DU SCHEMA
										  
--CREATE SCHEMA "cabinet_diet";;
 
            -- indique le nom du schema dans lequel travailler
			 
SET SEARCH_PATH = "cabinet_diet";

    -- pour supprimer cette table si elle existe déjà dans ce schema

    -- DROP TABLE IF EXISTS "type_regime";
	
	                           --CREATION DE TABLE "type_regime" 
					--important ----type bigint par defaut est NOT NULL --
			
			
CREATE TABLE IF NOT EXISTS cabinet_diet.type_regime
(
    id bigint NOT NULL DEFAULT nextval('cabinet_diet.type_regime_id_seq'::regclass),
    libelle character varying COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT type_regime_pkey PRIMARY KEY (id)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS cabinet_diet.type_regime
    OWNER to postgres;

                            --CREATION DE TABLE "categorie_recette"
							
							
CREATE TABLE IF NOT EXISTS cabinet_diet.categorie_recette
(
    id bigint NOT NULL DEFAULT nextval('cabinet_diet.categorie_recette_id_seq'::regclass),
    libelle character varying COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT categorie_recette_pkey PRIMARY KEY (id)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS cabinet_diet.categorie_recette
    OWNER to postgres;

                            --CREATION DE TABLE "contact"


CREATE TABLE IF NOT EXISTS cabinet_diet.contact
(
    id bigint NOT NULL DEFAULT nextval('cabinet_diet.contact_id_seq'::regclass),
    civilite character varying COLLATE pg_catalog."default" NOT NULL,
    nom character varying COLLATE pg_catalog."default" NOT NULL,
    email character varying COLLATE pg_catalog."default" NOT NULL,
    message text COLLATE pg_catalog."default" NOT NULL,
    date_contact timestamp with time zone NOT NULL,
    CONSTRAINT contact_pkey PRIMARY KEY (id)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS cabinet_diet.contact
    OWNER to postgres;

                              --CREATION DE TABLE "patients"
							  
							  
CREATE TABLE IF NOT EXISTS cabinet_diet.patients
(
    id bigint NOT NULL DEFAULT nextval('cabinet_diet.patients_id_seq'::regclass),
    nom character varying COLLATE pg_catalog."default" NOT NULL,
    prenom character varying COLLATE pg_catalog."default",
    email character varying COLLATE pg_catalog."default" NOT NULL,
    mot_de_pass character varying COLLATE pg_catalog."default" NOT NULL,
    date_creation timestamp with time zone NOT NULL,
    statut integer,
    code_recette bigint NOT NULL DEFAULT nextval('cabinet_diet.patients_code_recette_seq'::regclass),
    id_auteur bigint NOT NULL DEFAULT nextval('cabinet_diet.patients_id_auteur_seq'::regclass),
    CONSTRAINT patients_pkey PRIMARY KEY (id),
    CONSTRAINT id_auteur FOREIGN KEY (id_auteur)
        REFERENCES cabinet_diet.administrateur (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT patients_code_recette_fkey FOREIGN KEY (code_recette)
        REFERENCES cabinet_diet.categorie_recette (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS cabinet_diet.patients
    OWNER to postgres;


                                --CREATION DE TABLE "admin"
								
								
CREATE TABLE IF NOT EXISTS cabinet_diet.administrateur
(
    id bigint NOT NULL DEFAULT nextval('cabinet_diet.administrateur_id_seq'::regclass),
    nom character varying COLLATE pg_catalog."default" NOT NULL,
    prenom character varying COLLATE pg_catalog."default",
    email character varying COLLATE pg_catalog."default" NOT NULL,
    mot_de_pass character varying COLLATE pg_catalog."default" NOT NULL,
    date_creation timestamp with time zone NOT NULL,
    CONSTRAINT administrateur_pkey PRIMARY KEY (id)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS cabinet_diet.administrateur
    OWNER to postgres;
	
	
	
                            --CREATION DE TABLE "avis"


CREATE TABLE IF NOT EXISTS cabinet_diet.avis
(
    id bigint NOT NULL DEFAULT nextval('cabinet_diet.avis_id_seq'::regclass),
    auteur character varying COLLATE pg_catalog."default" NOT NULL,
    note integer NOT NULL,
    commentaire text COLLATE pg_catalog."default" NOT NULL,
    recette_id bigint NOT NULL DEFAULT nextval('cabinet_diet.avis_recette_id_seq'::regclass),
    date_avis timestamp with time zone NOT NULL,
    CONSTRAINT avis_pkey PRIMARY KEY (id),
    CONSTRAINT recette_id FOREIGN KEY (recette_id)
        REFERENCES cabinet_diet.recettes (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS cabinet_diet.avis
    OWNER to postgres;
	

                                  --CREATION DE TABLE "recettes"


CREATE TABLE IF NOT EXISTS cabinet_diet.recettes
(
    id bigint NOT NULL DEFAULT nextval('cabinet_diet.recettes_id_seq'::regclass),
    titre character varying COLLATE pg_catalog."default" NOT NULL,
    description text COLLATE pg_catalog."default" NOT NULL,
    temps_preparation character varying COLLATE pg_catalog."default" NOT NULL,
    temps_repos integer NOT NULL,
    ingredients text COLLATE pg_catalog."default" NOT NULL,
    etapes integer NOT NULL,
    allergene character varying COLLATE pg_catalog."default" NOT NULL,
    type_regime bigint NOT NULL DEFAULT nextval('cabinet_diet.recettes_type_regime_seq'::regclass),
    auteur_id bigint NOT NULL DEFAULT nextval('cabinet_diet.recettes_auteur_id_seq'::regclass),
    categorie_recette bigint NOT NULL DEFAULT nextval('cabinet_diet.recettes_categorie_recette_seq'::regclass),
    date_recette timestamp with time zone NOT NULL,
    CONSTRAINT recettes_pkey PRIMARY KEY (id),
    CONSTRAINT auteur_id FOREIGN KEY (auteur_id)
        REFERENCES cabinet_diet.administrateur (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT categorie_recette FOREIGN KEY (categorie_recette)
        REFERENCES cabinet_diet.categorie_recette (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT type_regime FOREIGN KEY (type_regime)
        REFERENCES cabinet_diet.type_regime (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS cabinet_diet.recettes
    OWNER to postgres;
	
	
	
	
	-----type regime ----
--	1 - Le régime sans gluten
--	2 - Le régime sans lactose
--	3 - Le régime sans sel
	
	----categorie recette -----
--  1 - omnivore 
--  2 - vegetarien
--  3 - flexitarien
--  4 - frugivore

     ----