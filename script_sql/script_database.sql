/*SET GLOBAL log_bin_trust_function_creators = 1;

/*********************
*
* Création des tables
*
*********************/

drop table if exists Token;
drop table if exists competenceAjouté;
drop table if exists journalError;
drop table if exists competenceCategorie;
drop table if exists competenceActivite;
drop table if exists resultat;
drop table if exists gere;
drop table if exists joue;
drop table if exists etudie;
drop table if exists enseigne;
drop table if exists Responsable;
drop table if exists Competence;
drop table if exists ActiviteDuMoment;
drop table if exists Activite;
drop table if exists Categorie;
drop table if exists IME;
drop table if exists Administrateur;
drop table if exists Directeur;
drop table if exists Eleve;
drop table if exists Educateur;
drop table if exists Personne;

drop procedure if exists insertJournalError;
drop function if exists TokenRDM;
drop function if exists insertToken;

drop trigger if exists verifDoublonActivite;
drop trigger if exists verifDoublonCompetence;
drop trigger if exists verifDoublonCategorie;
drop trigger if exists aucunEduc;
drop trigger if exists doublonIME;
drop trigger if exists doublonEnseigne;
drop trigger if exists doublonEtudie;
drop trigger if exists IMESansResponsable;
drop trigger if exists IMESansResponsable2;
drop trigger if exists doublonEnseigne;
drop trigger if exists doublonELeveIME;
drop trigger if exists doublonResponsable;
drop trigger if exists TokenObselete;

drop function if exists retirePersonne;
drop procedure if exists retireIME;
drop procedure if exists retireEnseigne;
drop procedure if exists retireEtudie;
drop procedure if exists retireJoue;
drop procedure if exists retireGere;
drop procedure if exists retireADM;
drop procedure if exists retireActivite;
drop procedure if exists retireCategorie;
drop procedure if exists retireResultat;
drop procedure if exists retireCompetence;
drop procedure if exists retireCompetenceCategorie;
drop procedure if exists retireCompetenceActivite;

drop procedure if exists CreateIME;
drop procedure if exists insertEnseigne;
drop procedure if exists insertEtudie;
drop procedure if exists changeIMEResponsable;
drop function if exists EleveInIME;

drop function if exists createCompetence;
drop function if exists createActivite;
drop procedure if exists createCategorie;
drop procedure if exists competenceActivite;
drop function if exists competenceCategorie;
drop function if exists competenceUtilie;
drop function if exists createActiviteDuMoment;
DROP FUNCTION IF EXISTS modifyADM;
drop procedure if exists gere;
drop procedure if exists joue;
drop procedure if exists resultat;
drop procedure if exists modifyResultat;
drop procedure if exists modifyActivite;
drop function if exists modifyActivite;
drop function if exists rejouer;

drop procedure if exists createModifyResultat;
drop procedure if exists insertEleveIME;
drop procedure if exists sp_returns_string;
drop function if exists getNumeroHomonyme;

drop procedure if exists getPersonne;
drop function if exists getid;
drop function if exists getNumeroHomonymeFirstCo;
drop function if exists getPassWord;

drop function if exists isFistConnexion;
drop function if exists isEleve;
drop function if exists isIME;
drop function if exists isEducateur;
drop function if exists isResponsable;
drop function if exists isDirecteur;
drop function if exists isAdministrateur;
drop function if exists truePassword;
drop function if exists getType;
drop function if exists getIdToken;

drop function if exists connexion;
drop function if exists fistConnexion;

drop procedure if exists modifyPassword;
drop function if exists getVersionApplication;

drop function if exists numHomonyme;
drop function if exists CreatePersonne;
drop function if exists mdprandom;
drop function if exists CreateDirecteur;
drop function if exists CreateAdministrateur;
drop function if exists CreateEducateur;
drop function if exists CreateResponsable;
drop function if exists CreateEleve;
drop procedure if exists EducVersResp;
DROP FUNCTION IF EXISTS ModifyPersonne;

drop trigger if exists doublonResponsable;
drop procedure if exists enseigne;
drop procedure if exists etudie;

drop procedure if exists joue;
drop procedure if exists gere;

/********************************

classe personne et "heritage"

*********************************/


CREATE TABLE Personne(
   idPersonne INT auto_increment,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   mot_de_passe VARCHAR(255) NOT NULL,
   premiereConnexion boolean NOT NULL,
   numeroHomonyme INT NOT NULL,
   PRIMARY KEY(idPersonne)
);

CREATE TABLE Educateur(
   idPersonne INT,
   PRIMARY KEY(idPersonne),
   FOREIGN KEY(idPersonne) REFERENCES Personne(idPersonne) on delete cascade
);

CREATE TABLE Eleve(
   idPersonne INT,
   PRIMARY KEY(idPersonne),
   FOREIGN KEY(idPersonne) REFERENCES Personne(idPersonne) on delete cascade
);

CREATE TABLE Directeur(
   idPersonne INT,
   PRIMARY KEY(idPersonne),
   FOREIGN KEY(idPersonne) REFERENCES Personne(idPersonne) on delete cascade
);

CREATE TABLE Administrateur(
   idPersonne INT,
   PRIMARY KEY(idPersonne),
   FOREIGN KEY(idPersonne) REFERENCES Personne(idPersonne) on delete cascade
);

CREATE TABLE IME(
   idIME INT auto_increment,
   nom VARCHAR(200) NOT NULL,
   adresse VARCHAR(250) NOT NULL,
   PRIMARY KEY(idIME)
);

CREATE TABLE Categorie(
   idCategorie INT auto_increment,
   nom VARCHAR(50) NOT NULL,
   description text,
   idIME INT NOT NULL,
   PRIMARY KEY(idCategorie),
   FOREIGN KEY(idIME) REFERENCES IME(idIME) on delete cascade
);

CREATE TABLE Activite(
   idActivite INT auto_increment,
   nom VARCHAR(50) NOT NULL,
   description text,
   idIME INT NOT NULL,
   vers int,
   sous_vers int,
   PRIMARY KEY(idActivite),
   FOREIGN KEY(idIME) REFERENCES IME(idIME) on delete cascade
);

CREATE TABLE ActiviteDuMoment(
   idActiviteDuMoment INT auto_increment,
   dateHeure DATETIME NOT NULL,
   idActivite INT NOT NULL,
   vers int,
   sous_vers int,
   PRIMARY KEY(idActiviteDuMoment),
   FOREIGN KEY(idActivite) REFERENCES Activite(idActivite) on delete cascade
);

CREATE TABLE Competence(
   idCompetence INT auto_increment,
   nom VARCHAR(50) NOT NULL,
   description text,
   PRIMARY KEY(idCompetence)
);

CREATE TABLE journalError(
   idError INT auto_increment,
   numError INT,
   description text,
   idIME INT NOT NULL,
   PRIMARY KEY(idError),
   FOREIGN KEY(idIME) REFERENCES IME(idIME)on delete cascade
);

CREATE TABLE joue(
   idActiviteDuMoment INT,
   idPersonne INT,
   PRIMARY KEY(idActiviteDuMoment, idPersonne),
   FOREIGN KEY(idActiviteDuMoment) REFERENCES ActiviteDuMoment(idActiviteDuMoment) on delete cascade,
   FOREIGN KEY(idPersonne) REFERENCES Eleve(idPersonne) on delete cascade
);

CREATE TABLE Responsable(
   idPersonne INT,
   idIME INT NOT NULL,
   PRIMARY KEY(idPersonne),
   FOREIGN KEY(idPersonne) REFERENCES Educateur(idPersonne) on delete cascade,
   FOREIGN KEY(idIME) REFERENCES IME(idIME) on delete cascade
);

CREATE TABLE enseigne(
   idPersonne INT,
   idIME INT,
   PRIMARY KEY(idPersonne, idIME),
   FOREIGN KEY(idPersonne) REFERENCES Educateur(idPersonne) on delete cascade,
   FOREIGN KEY(idIME) REFERENCES IME(idIME) on delete cascade
);

CREATE TABLE etudie(
   idPersonne INT,
   idIME INT,
   PRIMARY KEY(idPersonne, idIME),
   FOREIGN KEY(idPersonne) REFERENCES Eleve(idPersonne) on delete cascade,
   FOREIGN KEY(idIME) REFERENCES IME(idIME) on delete cascade
);

CREATE TABLE gere(
   idPersonne INT,
   idActiviteDuMoment INT,
   PRIMARY KEY(idPersonne, idActiviteDuMoment),
   FOREIGN KEY(idPersonne) REFERENCES Educateur(idPersonne) on delete cascade,
   FOREIGN KEY(idActiviteDuMoment) REFERENCES ActiviteDuMoment(idActiviteDuMoment) on delete cascade
);

CREATE TABLE resultat(
   idCompetence INT,
   idActiviteDuMoment INT,
   idPersonne INT,
   note INT,
   PRIMARY KEY(idCompetence, idActiviteDuMoment, idPersonne),
   FOREIGN KEY(idCompetence) REFERENCES Competence(idCompetence) on delete cascade,
   FOREIGN KEY(idActiviteDuMoment, idPersonne) REFERENCES joue(idActiviteDuMoment, idPersonne) on delete cascade
);

CREATE TABLE competenceActivite(
   idActivite INT,
   idCompetence INT,
   vers int,
   sous_vers int,
   PRIMARY KEY(idActivite, idCompetence, vers, sous_vers),
   FOREIGN KEY(idActivite) REFERENCES Activite(idActivite) on delete cascade,
   FOREIGN KEY(idCompetence) REFERENCES Competence(idCompetence) on delete cascade
);

CREATE TABLE competenceCategorie(
   idCategorie INT,
   idCompetence INT,
   PRIMARY KEY(idCategorie, idCompetence),
   FOREIGN KEY(idCategorie) REFERENCES Categorie(idCategorie) on delete cascade,
   FOREIGN KEY(idCompetence) REFERENCES Competence(idCompetence) on delete cascade
);

CREATE TABLE Token(
   idPersonne INT,
   dateCreation DATETIME,
   token VARCHAR(32),
   PRIMARY KEY(idPersonne),
   FOREIGN KEY(idPersonne) REFERENCES Educateur(idPersonne) on delete cascade
);

delimiter @

create function TokenRDM()
returns varchar(32)
begin

	declare token varchar(64);
    declare tokentmp varchar(64);
    declare cptr int;
    
    declare curseur cursor for 
    select token from Token;
        
    set token = SUBSTRING(MD5(RAND()) FROM 1 FOR 32);
    
    select count(idPersonne) into cptr from Token;
    
    open curseur;
    while (cptr > 0) do
    
		fetch curseur into tokentmp;
        
        if(tokentmp = token) then 
			set token = SUBSTRING(MD5(RAND()) FROM 1 FOR 32);
        end if;
        
        set cptr = cptr-1;
        
	end while;
    
    return token;

end @ 

create function insertToken(idPers int)
returns varchar(32)
begin

	declare tokenRetour varchar(32);
    declare exist int;
    
    select count(idPersonne) into exist from Token where idPersonne = idPers;
    
	select TokenRDM() into tokenRetour;
    if(exist > 0) then
		update Token set token = tokenRetour, dateCreation = now() where idPersonne = idPers;
    else
		insert into Token(idPersonne, dateCreation, token)
        values(idPers, now(), tokenRetour);
    
    end if;
    
    return tokenRetour;

end @

create procedure insertJournalError(in numEr int, in ime int, in descriptionEr text)
begin

	insert into journalerror (numError,idIME,description)
    value (numEr, ime, descriptionEr);

end @

create trigger verifDoublonActivite after insert on Activite for each row
begin
	
    declare cptr int;
    
    select count(idActivite) into cptr from Activite 
    where nom like new.nom and idIME = new.idIME;
    
    if(cptr>1) then 
		SIGNAL SQLSTATE '45000' SET MYSQL_ERRNO=30001, MESSAGE_TEXT='Activité déjà créée pour cet IME';
	end if;
    
end @

create trigger verifDoublonCategorie after insert on Categorie for each row
begin

	 declare cptr int;
    
    select count(idCategorie) into cptr from Categorie 
    where nom like new.nom and idIME = new.idIME;
    
    if(cptr>1) then 
		SIGNAL SQLSTATE '45000' SET MYSQL_ERRNO=30007, MESSAGE_TEXT='Catégorie déjà créée pour cet IME';
	end if;

end @

create trigger aucunEduc after delete on gere for each row 
begin
	
    declare cptr int;
    
	select count(idPersonne) into cptr from gere 
    where idActiviteDuMoment = old.idActiviteDuMoment;
    
    if(cptr = 0) then
		SIGNAL SQLSTATE '45000' SET MYSQL_ERRNO=30011, MESSAGE_TEXT="impossible d'enlever tous les éducateurs supervisant cette activité du moment";
    end if;

end @

create trigger doublonIME after insert on IME for each row
begin

	declare cptr int;
    
    select count(idIME) into cptr from IME 
    where nom like new.nom and adresse like new.adresse;
    
    if(cptr>1) then 
		SIGNAL SQLSTATE '45000' SET MYSQL_ERRNO=30003, MESSAGE_TEXT='IME déjà créée';
	end if;

end @

create trigger doublonEnseigne after insert on enseigne for each row
begin

	declare cptr int;
    
    select count(idIME) into cptr from enseigne
    where idPersonne = new.idPersonne and idIME = new.idIME;
    
    if(cptr>1) then 
		SIGNAL SQLSTATE '45000' SET MYSQL_ERRNO=30004, MESSAGE_TEXT='cet enseignant est déjà ajouté pour cet IME';
	end if;

end @

create trigger doublonEtudie after insert on etudie for each row
begin

	declare cptr int;
    

    select count(idIME) into cptr from etudie 
    where idIME = new.idIME and idPersonne = new.idPersonne;
    
    if(cptr>1) then 
		SIGNAL SQLSTATE '45000' SET MYSQL_ERRNO=30005, MESSAGE_TEXT='cet eleve est déjà ajouté pour cet IME';
	end if;

end @

create trigger IMESansResponsable after update on Responsable for each row
begin

	declare cptr int;
    
    select count(idPersonne) into cptr from Responsable 
    where idIME = old.idIME;
    
    if(cptr=0) then 
		SIGNAL SQLSTATE '45000' SET MYSQL_ERRNO=30006, MESSAGE_TEXT="cette personne est le dernier responsable pour un IME";
	end if;

end @

create trigger IMESansResponsable2 after delete on Responsable for each row
begin

	declare cptr int;
    
    select count(idPersonne) into cptr from Responsable 
    where idIME = old.idIME;
    
    if(cptr=0) then 
		SIGNAL SQLSTATE '45000' SET MYSQL_ERRNO=30006, MESSAGE_TEXT="cette personne est le dernier responsable pour un IME";
	end if;

end @

create trigger doublonResponsable after insert on Responsable for each row
begin

	declare cptr int;
    
    select count(idPersonne) into cptr from Responsable 
    where idPersonne = new.idPersonne;
    
    if(cptr>1) then 
		SIGNAL SQLSTATE '45000' SET MYSQL_ERRNO=30002, MESSAGE_TEXT='cette personne est deja un responsable dans un IME';
	end if;    

end @
delimiter @
create trigger TokenObselete before insert on Token for each row
begin
	
    declare nbLine int;
    declare cptr int default 0;
    declare id int;
    declare date_ datetime;
    
	declare curs cursor for
    select idPersonne, dateCreation from Token;

	select count(idPersonne) into nbLine from Token;
    
    open curs;
    
    while(cptr<nbLine) do
    
		fetch curs into id, date_;
        
        if(datediff(now(), date_) >= 1)then
			delete from Token
            where idPersonne = id;
		end if;
		
        set cptr = cptr + 1;
    end while;
end @

delimiter ;
create or replace view activiterDuMoment
as select a.idActiviteDuMoment,a.idActivite,p.idPersonne, p.nom,p.prenom,p.numeroHomonyme,r.idCompetence, r.note 
from ActiviteDuMoment a  
natural join joue j 
natural join Personne p 
natural left join resultat r 
left join competenceActivite c on r.idCompetence=c.idCompetence and c.idActivite=a.idActivite
where (a.vers= c.vers AND a.sous_vers = c.sous_vers)or isnull(c.vers);


create or replace view competence
as 	SELECT am.idActiviteDuMoment, a.idActivite, a.nom AS nomActivite, a.description AS descActivite, a.idIME, c.idCompetence, c.nom AS nomCompetence, c.description AS descCompetence
    FROM Activite a 
    JOIN competenceActivite ca ON a.idActivite = ca.idActivite
    JOIN Competence c ON ca.idCompetence = c.idCompetence
    JOIN ActiviteDuMoment am ON am.idActivite = a.idActivite
    WHERE am.vers = ca.vers AND am.sous_vers = ca.sous_vers AND am.sous_vers = (SELECT MAX(sous_vers) FROM ActiviteDuMoment WHERE idActiviteDuMoment = am.idActiviteDuMoment);
    
create or replace view personnel as
SELECT p.idPersonne, p.nom, p.prenom, p.numeroHomonyme,
    CASE
        WHEN a.idPersonne IS NOT NULL THEN 'administrateur'
        WHEN d.idPersonne IS NOT NULL THEN 'directeur'
        WHEN r.idPersonne IS NOT NULL THEN 'responsable'
        WHEN e.idPersonne IS NOT NULL THEN 'educateur'
    END AS type,
    GROUP_CONCAT(DISTINCT i.idIME SEPARATOR ',') AS imes
FROM Personne p
LEFT JOIN Administrateur a ON p.idPersonne = a.idPersonne
LEFT JOIN Directeur d ON p.idPersonne = d.idPersonne
LEFT JOIN Responsable r ON p.idPersonne = r.idPersonne
LEFT JOIN Educateur e ON p.idPersonne = e.idPersonne
LEFT JOIN enseigne en ON p.idPersonne = en.idPersonne
LEFT JOIN IME i ON en.idIME = i.idIME
WHERE p.idPersonne NOT IN (SELECT Eleve.idPersonne FROM Eleve)
GROUP BY p.idPersonne;


/***********
*
* scripte procedure delete
*
***********/

delimiter @

create function retirePersonne(id int)
returns bool
begin

	declare supp bool default false;

	if(select isDirecteur(id)) then
		delete from directeur where idPersonne = id;
        set supp = true;
	end if;
    if (select isAdministrateur(id)) then
		delete from Administrateur where idPersonne = id;
        set supp = true;
	end if;
    if (select isEducateur(id)) then
		if(select isResponsable(id)) then
			delete from Responsable where idPersonne = id;
        end if;
        delete from Educateur where idPersonne = id;
		set supp = true;
	end if;
    if (select isEleve(id)) then
		delete from Eleve where idPersonne = id;
        set supp = true;
    end if;
	
    if(supp) then
		delete from Personne where idPersonne = id;
	end if;
    
    return supp;
    
end @


create procedure retireIME(id int)
begin
	
	delete from IME where idIME = id;

end @

create procedure retireEnseigne(in Educ int, in IME int)
begin

	delete from enseigne where idPersonne = Educ and idIME = IME;

end @

create procedure retireEtudie(in eleve int, in IME int)
begin

	delete from etudie where idPersonne = eleve and idIME = IME;

end @

create procedure retireJoue(in eleve int, in ActiviteMoment int)
begin

	delete from joue where idPersonne = eleve and idActiviteDuMoment = ActiviteMoment;

end @

create procedure retireGere(in Educ int, in ActiviteMoment int)
begin

	delete from gere where idPersonne = Educ and idActiviteDuMoment = ActiviteMoment;

end @

create procedure retireADM(in ADM int)
begin

	delete from ActiviteDuMoment where idActiviteDuMoment = ADM;

end @

create procedure retireActivite(in activite int)
begin

	delete from Activite where idActivite = activite;

end @

create procedure retireCategorie(in categorie int)
begin

	delete from Categorie where idCategorie = categorie;

end @

create procedure retireResultat(in idComp int, in idADM int, in idPers int)
begin

	delete from resultat where idCompetence = idComp and idActiviteDuMoment = idADM and idPersonne = idPers;

end @

create procedure retireCompetence(in idComp int)
begin

	delete from Competence where idCompetence = idComp;

end @

create procedure retireCompetenceCategorie(in idCat int, idComp int)
begin

	delete from competenceCategorie where idCategorie = idCat and idCompetence = idComp;

end @

create procedure retireCompetenceActivite(in idAct int, idComp int)
begin

	delete from competenceActivite where idActivite = idAct and idCompetence = idComp;

end @

delimiter ;

/********************
*
* scripte pour les IME
*
********************/

delimiter @

create procedure CreateIME(in nomIME varchar(200), in adresseIME varchar(250))
begin

declare id int;

insert into IME (nom,adresse)
value( nomIME, adresseIME);

select idIME into id from IME where nom = nomIME and adresse = adresseIME;

end @

create procedure insertEnseigne(in idEduc int, in idIME int)
begin

	insert into enseigne (idPersonne,idIME)
	value(idEduc, idIME);

end @

create procedure insertEtudie(in idIME int, in idEleve int)
begin 

insert into etudie (idPersonne,idIME)
value(idEleve,idIME);

end @

create procedure changeIMEResponsable(IME int, Responsable int)
begin

	update responsable set idIME = IME 
    where idResponsable = Responsable;

end @

create function EleveInIME( idEleve int, idIMEVerif int)
returns boolean
begin

	declare cptr int;
	declare retour int;

	declare curs cursor for
	select idIME from etudie where idPersonne = idEleve;

	select count(idIME) into cptr from etudie where idPersonne = idEleve;

	open curs;
	while (cptr != 0) do

		fetch curs into retour;
		if(retour = idIMEVerif)then
			return true;
		end if;
	set cptr = cptr -1;
	end while;
return false;
end @

delimiter ;

/***************************
*
* scripte activite competence et categorie
*
***************************/

DELIMITER @
CREATE FUNCTION rejouer(idADM int) RETURNS int
begin
declare newidADM int;

declare v_idActiviteDuMoment int;
declare v_idPersonne int;

DECLARE fincurs BOOLEAN DEFAULT 0;
DECLARE curs CURSOR FOR select idActiviteDuMoment,idPersonne from joue where idActiviteDuMoment=idADM;

DECLARE curs2 CURSOR FOR select idActiviteDuMoment,idPersonne from gere where idActiviteDuMoment=idADM;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET fincurs := 1;
    insert into ActiviteDuMoment (dateHeure,idActivite,vers,sous_vers) select dateHeure,idActivite,vers,sous_vers from ActiviteDuMoment where idActiviteDuMoment=idADM;
    select max(idActiviteDuMoment) into newidADM from ActiviteDuMoment;
    
    update ActiviteDuMoment set dateHeure=now() where idActiviteDuMoment=newidADM;
    
    OPEN curs;
    FETCH curs INTO v_idActiviteDuMoment,v_idPersonne;
	While NOT fincurs DO
    
		insert into joue (idActiviteDuMoment,idPersonne) values(newidADM,v_idPersonne);
		FETCH curs INTO v_idActiviteDuMoment,v_idPersonne;
	END While;
	CLOSE curs;
    
    set fincurs:=0;
    
    OPEN curs2;
    FETCH curs2 INTO v_idActiviteDuMoment,v_idPersonne;
	While NOT fincurs DO
		insert into gere (idActiviteDuMoment,idPersonne) values(newidADM,v_idPersonne);
		FETCH curs2 INTO v_idActiviteDuMoment,v_idPersonne;
	END While;
	CLOSE curs2;
return newidADM;
end
@

CREATE FUNCTION createActivite(nomAct varchar(50), descriptionAct varchar(200), idIMEAct int) 
RETURNS int
begin
	declare idAct int;
    insert into Activite (nom, description, idIME,vers,sous_vers)
    value(nomAct, descriptionAct, idIMEAct, 1,0);
    
    select max(idActivite) into idAct from Activite
    where nom like nomAct and description like descriptionAct;
	
    
	return idAct;
end @
DELIMITER ;

DELIMITER @
CREATE FUNCTION modifyActivite(idAct int, nomAct varchar(50), descriptionAct varchar(255)) 
RETURNS float(53)
begin
    declare version float(53);
	update Activite set nom = nomAct, description = descriptionAct, vers = vers + 1, sous_vers = 0
    where idActivite = idAct;
    select vers from Activite where idActivite = idAct into version;
    return version;
end @
DELIMITER ;

/************************************************************************

PROCEDURE POUR LES COMPETENCES

************************************************************************/

delimiter @

create function createCompetence(nomComp varchar(50), descriptionCompetence varchar(200))
returns int
begin
	declare idComp int;
    insert into Competence(nom,description)
    value(nomComp, descriptionCompetence);
    
    select max(idCompetence) into idComp from Competence
    where nom like nomComp and description like descriptionCompetence;
	
    
	return idComp;
end @

create function competenceCategorie(idComp int, idCat int)
returns bool
begin

	insert into competenceCategorie (idCategorie,idCompetence) values(idCat,idComp);
	return true;

end @

create procedure competenceActivite(in idComp int, in idActivite int, in vers int, in sous_vers int)
begin
	insert into competenceActivite (idActivite,idCompetence,vers,sous_vers) values(idActivite,idComp, vers, sous_vers);
end @

create function competenceUtilie(idComp int)
returns bool
begin

	declare cptr int;

	select count(idCategorie) into cptr from competenceCategorie 
    where idCompetence = idComp;
    
    if(cptr = 0) then 
		return false;
    else 
		return true;
    end if;
    
end @;

delimiter ;

/************************************************************************

PROCEDURE POUR LES CATEGORIES

************************************************************************/


delimiter @

create procedure createCategorie(in nom varchar(50), in descriptionCategorie varchar(200), in idIME int)
begin
	
    declare isI bool;
    select isIME(idIME) into isI;
    
    if isI then 
		 insert into Categorie (nom, description, idIME) 
        value (nom, descriptionCategorie, idIME);
    end if;
    
end @

delimiter ;

/************************************************************************

PROCEDURE POUR LES ACTIVITEDUMOMENTS

************************************************************************/


delimiter @


create function createActiviteDuMoment(idAct int)
/*
important il faut faire une transaction directement en PHP pour cette procedure et
celle d'ajout des profs et eleves ( afin de permettre d'annuler la creation de 
l'activité du moment et de limiter le nombre de requetes à la base )
*/
returns int
begin

	declare newADM int;
    declare ver float;
    declare sous_ver float;
    select vers, sous_vers into ver,sous_ver from Activite where idActivite=idAct;

	insert into ActiviteDuMoment (dateHeure,idActivite,vers,sous_vers)
    value (now(), idAct, ver, sous_ver);
    
    select max(idActiviteDuMoment) into newADM from ActiviteDuMoment 
    where idActivite = idAct;
    
    return newADM;

end @


DELIMITER @
CREATE FUNCTION modifyADM(idADM int) RETURNS int
begin
    DECLARE sous_version INT;
    DECLARE max_sous_version INT;
    SELECT DISTINCT MAX(sous_vers) FROM ActiviteDuMoment WHERE idActivite = (SELECT DISTINCT idActivite FROM ActiviteDuMoment WHERE idActiviteDuMoment = idADM) INTO max_sous_version;
    UPDATE ActiviteDuMoment SET sous_vers = max_sous_version + 1 WHERE idActiviteDuMoment = idADM;
    SELECT sous_vers FROM ActiviteDuMoment WHERE idActiviteDuMoment = idADM INTO sous_version;
    RETURN sous_version;
end@

create procedure gere(idEduc int, idADM int)
begin

	insert into gere (idPersonne,idActiviteDuMoment)
    value (idEduc, idADM);

end @

create procedure joue(idEleve int, idADM int)
begin

	insert into joue (idActiviteDuMoment,idPersonne)
    value (idADM,idEleve);

end @

create procedure resultat(in idComp int, in idADM int, in idPers int, in note int)
begin 
    
	insert into resultat (idCompetence,idActiviteDuMoment,idPersonne,note)
    values (idComp, idADM, idPers, note);

end @

create procedure modifyResultat(in idComp int, in idADM int, in idPers int, in newNote int)
begin

	update resultat set note = newNote 
    where idCompetence = idComp and idActiviteDuMoment = idADM and idPersonne = idPers;

end @

delimiter ;

/********************************
*
* scripte manquant OVH
*
********************************/

delimiter @
CREATE PROCEDURE `createModifyResultat`(in idComp int, in idADM int, in idPers int, in note int)
begin
    declare nbr int;
    start transaction;
    select count(*) into nbr from resultat where idCompetence=idComp and idActiviteDuMoment=idADM and idPersonne=idPers;
    
    if (nbr>0) then
        call modifyResultat(idComp,idADM,idPers,note);
    end if;
    if(nbr=0) then
        call resultat(idComp,idADM,idPers,note);
    end if;
    commit;
end@
CREATE PROCEDURE `insertEleveIME`(in idIME int, in idEleve int)
begin 

insert into eleveime
value(idIME, idEleve);

end@

CREATE PROCEDURE `sp_returns_string`(out t int)
begin
set t:=10;
end@
CREATE FUNCTION `getNumeroHomonyme`(n varchar(256),p varchar(256),mdp varchar(256),PremiereCo bool) RETURNS int
begin
declare id int default -1;
select numeroHomonyme into id from Personne where nom=n and prenom=p and mot_de_passe=mdp and premiereConnexion=FistCo;
return id;
end@

/****************************
*
* fonciton de connexion
*
****************************/

delimiter @
create function getVersionApplication()
returns int
begin
    return 4;
end
@
create function getPassWord(id int)
returns varchar(255)
begin
	declare mdp varchar(255);
	select mot_de_passe into mdp from Personne where idPersonne=id;
    return mdp;
end
@

create function getid(n varchar(256),p varchar(256),i int)
returns int
begin
declare id int default 0;
select idPersonne into id from Personne where nom=n and prenom=p and numeroHomonyme=i;

if id=0 then set id:=-1;
end if;
return id;
end
@
create function truePassword(id int, psw varchar(256))
returns bool
begin
declare tPsw bool;
select count(*) into tPsw from Personne where idPersonne=id and mot_de_passe=psw;
return tPsw;
end
@
create function getNumeroHomonymeFirstCo(n varchar(256),p varchar(256))
returns int
begin
declare id int default -1;
select numeroHomonyme into id from Personne where nom=n and prenom=p and premiereConnexion=true;
return id;
end
@

/*********************************************************************
**********************************************************************
****************function is...... ************************************
**********************************************************************
**********************************************************************/
create function isEleve(id int)
returns bool
begin
	declare cpt int default 0;
	select count(*) into cpt from Eleve where idPersonne=id;
    
    if cpt=0 then return false;
    else return true;
    end if;
end
@
create function isIME(id int)
returns bool
begin
	declare cpt int default 0;
	select count(*) into cpt from IME where idIME=id;
    
    if cpt=0 then return false;
    else return true;
    end if;
end
@
create function isEducateur(id int)
returns bool
begin
	declare cpt int default 0;
	select count(*) into cpt from Educateur where idPersonne=id;
    
    if cpt=0 then return false;
    else return true;
    end if;
end
@
create function isResponsable(id int)
returns bool
begin
	declare cpt int default 0;
	select count(*) into cpt from Responsable where idPersonne=id;
    
    if cpt=0 then return false;
    else return true;
    end if;
end
@
create function isDirecteur(id int)
returns bool
begin
	declare cpt int default 0;
	select count(*) into cpt from Directeur where idPersonne=id;
    
    if cpt=0 then return false;
    else return true;
    end if;
end
@
create function isAdministrateur(id int)
returns bool
begin
	declare cpt int default 0;
	select count(*) into cpt from Administrateur where idPersonne=id;
    
    if cpt=0 then return false;
    else return true;
    end if;
end
@
create function isFistConnexion(id int)
returns bool
begin
declare nbrLigne int default 0;

select count(*) into nbrLigne from Personne where idPersonne=id and premiereConnexion=false;

if nbrLigne=0 then return true;
else return false;
end if;
end
@
/*********************************************************************
**********************************************************************
**********************************************************************
**********************************************************************
**********************************************************************/

create function getIdToken(_token varchar(255))
returns int
begin
	declare idP int;
	select idPersonne id into idP from Token where token=_token;
    return idP;
end
@


create function getType(id int)
returns varchar(255)
begin
declare Eleve bool;
declare Educateur bool;
declare Responsable bool;
declare Directeur bool;
declare Administrateur bool;

	select isEleve(id) into Eleve;
    select isEducateur(id) into Educateur;
    select isResponsable(id) into Responsable;
    select isDirecteur(id) into Directeur;
    select isAdministrateur(id) into Administrateur;
    Case
		when Eleve then 
			return "eleve";
        when Educateur then 
			return "educateur";
        when Responsable then 
			return "responsable";
        when Directeur then 
			return "directeur";
        when Administrateur then 
			return "administrateur";
        else return null;
	end case;
end
@

create procedure getPersonne(in id int,out n varchar(50),out p varchar(50),out numeroH int,out typeP varchar(50),out idI varchar(255),out nomI varchar(255))

begin


select getType(id) into typeP;
    
	set idI:=null;
	set nomI:=null;
    Case
		when typeP="eleve" then 
            select p.nom,p.prenom,p.numeroHomonyme, group_concat(i.idIME), group_concat(i.nom) into n,p,numeroH,idI,nomI from Personne p left join etudie e on p.idPersonne=e.idPersonne left join IME i on e.idIME=i.idIME where p.idPersonne=id group by nom,prenom,numeroHomonyme;
        when typeP="educateur" then 
            select p.nom,p.prenom,p.numeroHomonyme, group_concat(i.idIME), group_concat(i.nom) into n,p,numeroH,idI,nomI from Personne p left join enseigne e on p.idPersonne=e.idPersonne left join IME i on e.idIME=i.idIME where p.idPersonne=id group by nom,prenom,numeroHomonyme;
        when typeP="responsable" then 
            select nom,prenom,numeroHomonyme, group_concat(idIME), group_concat(i.nom) into n,p,numeroH,idI,nomI from Personne p left join Responsable r on p.idPersonne=r.idPersonne left join IME i on r.idIME=i.idIME where p.idPersonne=id group by nom,prenom,numeroHomonyme;
        when typeP="directeur" then 
            select nom,prenom,numeroHomonyme into n,p,numeroH from Personne p where idPersonne=id;
        when typeP="administrateur" then 
            select nom,prenom,numeroHomonyme into n,p,numeroH from Personne p where idPersonne=id;
        else set typeP:=null;
	end case;
end
@

-- code erreur -1 nom ou prenom ou code fail, -2 vous avez deja fait votre premiere connexion
create function fistConnexion(nom varchar(256), prenom varchar(256),mdp varchar(256))
returns int
begin
	declare id int;
    declare num int;
	declare isFistConnexion bool;
    declare truePassword bool;
    declare toReturn int;
    
    select getNumeroHomonymeFirstCo(nom,prenom,mdp) into num;
	if num=-1 then set toReturn:=-1;
    else 
		select getid(nom,prenom,num) into id;
		select isFistConnexion(id) into isFistConnexion;
        select truePassword(id, mdp)into truePassword;
        if not isFistConnexion then set toReturn:=-2;
		else set toReturn:=id;
		end if;
    end if;
    return toReturn;
end
@

create procedure modifyPassword(id int, newmdp varchar(256))
begin
UPDATE Personne SET mot_de_passe = newmdp,premiereConnexion=false WHERE idPersonne = id;
end
@

/******************************
*
* fonction de creation d'utilisateur
*
******************************/

delimiter @

create function CreatePersonne(nomInsert varchar(50), prenomInsert varchar(50), mdp varchar(255))
returns int
begin
	declare Homonyme int;
    declare idCree int;
    
    select numHomonyme(nomInsert, prenomInsert) into Homonyme;

	insert into Personne (nom,prenom,mot_de_passe,premiereConnexion,numeroHomonyme)
	value ( nomInsert, prenomInsert,  mdp, true, Homonyme);
    
    select idPersonne into idCree from Personne where nom = nomInsert and prenom = prenomInsert and numeroHomonyme = Homonyme;
    
    return idCree;

end @

create function mdprandom()
returns varchar(30)
begin

	declare mdp varchar(255);
    declare mdptmp varchar(255);
    declare cptr int;
    
    declare curseur cursor for 
    select mot_de_passe from Personne;
        
    set mdp = SUBSTRING(MD5(RAND()) FROM 1 FOR 10);
    
    select count(idPersonne) into cptr from Personne;
    
    open curseur;
    while (cptr > 0) do
    
		fetch curseur into mdptmp;
        
        if(mdptmp = mdp) then 
			set mdp = SUBSTRING(MD5(RAND()) FROM 1 FOR 10);
        end if;
        
        set cptr = cptr-1;
        
	end while;
    
    return mdp;

end @ 


create function CreateDirecteur(nomInsert varchar(50), prenomInsert varchar(50), mdp varchar(255))
returns int
begin

declare idPersonneCree int;

select CreatePersonne(nomInsert, prenomInsert, mdp) into idPersonneCree;

insert into Directeur(idPersonne)
value(idPersonneCree);

return idPersonneCree;

end @


create function CreateAdministrateur(nomInsert varchar(50), prenomInsert varchar(50), mdp varchar(255))
returns int
begin

declare idPersonneCree int;

select CreatePersonne(nomInsert, prenomInsert, mdp) into idPersonneCree;

insert into Administrateur(idPersonne)
value(idPersonneCree);

return idPersonneCree;

end @


create function CreateEducateur(nomInsert varchar(50), prenomInsert varchar(50), mdp varchar(255))
returns int
begin

declare idPersonneCree int;

select CreatePersonne(nomInsert, prenomInsert, mdp) into idPersonneCree;

insert into Educateur(idPersonne)
value(idPersonneCree);

return idPersonneCree;

end @


create function CreateResponsable(nomInsert varchar(50), prenomInsert varchar(50), mdp varchar(255), IdIME int)
returns int
begin

declare idPersonneCree int;

select CreatePersonne(nomInsert, prenomInsert, mdp) into idPersonneCree;

insert into Educateur(idPersonne)
value(idPersonneCree);

insert into Responsable(idPersonne,idIME)
value(idPersonneCree, idIME);

return idPersonneCree;

end @


create function CreateEleve(nomInsert varchar(50), prenomInsert varchar(50), mdp varchar(255))
returns int
begin

declare idPersonneCree int;

select CreatePersonne(nomInsert, prenomInsert, mdp) into idPersonneCree;

insert into Eleve(idPersonne)
value(idPersonneCree);

return idPersonneCree;

end @

delimiter ;

/******************************************************************************************************************

MODIFY PERSONNE

******************************************************************************************************************/




DELIMITER @
CREATE FUNCTION ModifyPersonne (idInsert INT, nomInsert varchar(50), prenomInsert varchar(50), roleInsert varchar(50), idIMEInsert INT) RETURNS int
begin
   
    DELETE FROM Responsable WHERE idPersonne = idInsert;
    DELETE FROM Directeur WHERE idPersonne = idInsert;
    DELETE FROM enseigne WHERE idPersonne = idInsert;
     DELETE FROM Educateur WHERE idPersonne = idInsert;
    
	UPDATE Personne SET nom = nomInsert, prenom = prenomInsert WHERE idPersonne = idInsert;
    
    IF roleInsert = 'educateur' THEN
		INSERT INTO Educateur(idPersonne) VALUES (idInsert);
        INSERT INTO enseigne(idPersonne, idIME) VALUES (idInsert, idIMEInsert);
	ELSEIF roleInsert = 'responsable' THEN
		INSERT INTO Educateur(idPersonne) VALUES (idInsert);
		INSERT INTO Responsable(idPersonne, idIME) VALUES (idInsert, idIMEInsert);
        INSERT INTO enseigne(idPersonne, idIME) VALUES (idInsert, idIMEInsert);
	ELSEIF roleInsert = 'directeur' THEN
		INSERT INTO Directeur(idPersonne) VALUES (idInsert);
    END IF;
    
    return idInsert;

end @
DELIMITER ;


/******************************************************************************************************************

FONCTION DE TRANSFERT VERS UN RÔLE

******************************************************************************************************************/



delimiter @

create procedure EducVersResp(in idEduc int, in idIME int)
begin

	insert into Responsable(idPersonne, idIME)
    value(idEduc, idIME);

end @

delimiter ;

/******************************************************************************************************************

FONCTION DE affectation 

******************************************************************************************************************/


delimiter @
create procedure etudie(in idEleve int,in idIME int)
begin
	declare isE bool;
    declare isI bool;
    select isEleve(idEleve) into isE;
    select isIME(idIME) into isI;
    
    if isE and isI then 
		insert etudie values(idEleve,idIME);
    end if;
    
end
@

create procedure enseigne(in idEducateur int,in idIME int)
begin
	declare isE bool;
    declare isI bool;
    select isEducateur(idEducateur) into isE;
    select isIME(idIME) into isI;
    
    if isE and isI then 
		insert enseigne values(idEducateur,idIME);
    end if;
    
end
@

create function numHomonyme(n varchar(50), p varchar(50))
returns int
begin

	declare maxi int;
    declare num int default 0;
    declare cptr int;
    declare numTmp int;
    
	declare curs cursor for
    select numeroHomonyme from Personne where nom = "Martin" and prenom = "Pierre" order by numeroHomonyme asc;
    
    select count(idPersonne) into cptr from Personne where nom = n and prenom = p;
    select max(numeroHomonyme) into maxi from Personne where nom = n and prenom = p;
    
    if(cptr = 0)then
		return 0;
    else
        open curs;
        while(cptr != 0) do
        
			fetch curs into numTmp;
            if(numTmp - num >1) then
				return num + 1;
            else
				set num = numTmp;
            end if;
            set cptr = cptr -1;
        end while;
        return num +1;
    end if;
end 
@