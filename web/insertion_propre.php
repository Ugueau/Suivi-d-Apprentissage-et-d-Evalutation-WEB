<?php

// creation des IME
echo "test";
/** @var Database $db */
$db->CreateIME("IME Henri Lafay","1 rue du Dr Duby, 01000 Bourg-en-Bresse");
$db->CreateIME("IME Les Pommiers","2 avenue des Arbres, 75000 Paris");
$db->CreateIME("IME Les Hirondelles","3 rue des Oiseaux, 75000 Paris");

//creation des personnes
$db->CreateAdministrateur("Dupont", "Lucie", "123");//1
$db->CreateDirecteur("Martin", "Paul", "123");//2
$db->CreateEducateur("Dubois", "Sophie", "123");//3
$db->CreateEducateur("Durand", "Jacques", "123");//4 a les 3 IME
$db->CreateEleve("Petit", "Marie", "123");//5
$db->CreateEleve("Moreau", "Jean", "123");//6
$db->CreateEleve("Rousseau", "Anne", "0000");//7
$db->CreateEleve("Leclerc", "David", "321");//8
$db->CreateEducateur("Bernard", "Caroline", "123");//9
$db->CreateEducateur("Meyer", "Eric", "123");//10
$db->CreateEducateur("Schmidt", "Sophie", "123");//11
$db->CreateEducateur("Garcia", "Jose", "123");//12


$statment=$db->query("select mdprandom() as result");
$mdp = $statment->fetch();
$db->CreateEducateur("Tavel", "François", "s6v=5S[m3Y");//13
$db->CreateEleve("Dupont", "Jean", "123");//14
$db->CreateEleve("Durand", "Lucie", "123");//15
$db->CreateEleve("Leroy", "Sophie", "123");//16
$db->CreateEleve("Moreau", "Bernard", "123");//17
$db->CreateEleve("Bertrand", "Anne", "123");//18
$db->CreateEleve("Guillot", "Paul", "123");//19
$db->CreateEleve("Petit", "Pierre", "123");//20
$db->CreateEleve("Durand", "Jack", "123");//21
$db->CreateEleve("Moreau", "Nicolas", "123");//22
$db->CreateEleve("Martin", "Pierre", "123");//23
$db->CreateEleve("Martin", "Pierre", "123");//24

$db->CreateResponsable("Rodriguez", "Marie", "123", 2); // 25




// insertion des Educateur/responsable dans les IME
$CreeateResponsable = $db->query("call enseigne(:id,:idIME)", array("id" => 25, "idIME" => 2));
$CreateEleve = $db->query("call enseigne(:id,:idIME)", array("id" => 4, "idIME" => 1));
$CreateEleve = $db->query("call enseigne(:id,:idIME)", array("id" => 4, "idIME" => 2));
$CreateEleve = $db->query("call enseigne(:id,:idIME)", array("id" => 4, "idIME" => 3));

$CreateEleve = $db->query("call enseigne(:id,:idIME)", array("id" => 3, "idIME" => 1));
$CreateEleve = $db->query("call enseigne(:id,:idIME)", array("id" => 3, "idIME" => 2));

$CreateEleve = $db->query("call enseigne(:id,:idIME)", array("id" => 9, "idIME" => 2));
$CreateEleve = $db->query("call enseigne(:id,:idIME)", array("id" => 9, "idIME" => 3));

$CreateEleve = $db->query("call enseigne(:id,:idIME)", array("id" => 10, "idIME" => 1));
$CreateEleve = $db->query("call enseigne(:id,:idIME)", array("id" => 10, "idIME" => 3));

$CreateEleve = $db->query("call enseigne(:id,:idIME)", array("id" => 11, "idIME" => 1));

$CreateEleve = $db->query("call enseigne(:id,:idIME)", array("id" => 12, "idIME" => 1));
$CreateEleve = $db->query("call enseigne(:id,:idIME)", array("id" => 12, "idIME" => 2));
$CreateEleve = $db->query("call enseigne(:id,:idIME)", array("id" => 12, "idIME" => 3));

$CreateEleve = $db->query("call enseigne(:id,:idIME)", array("id" => 13, "idIME" => 1));


// insertion des Eleves dans les IME
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 5, "idIME" => 1));
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 5, "idIME" => 2));
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 6, "idIME" => 1));
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 7, "idIME" => 3));
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 7, "idIME" => 2));
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 8, "idIME" => 1));
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 8, "idIME" => 3));

$prep = $db->query("call etudie(:id,:idIME)", array("id" => 14, "idIME" => 1));
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 15, "idIME" => 1));
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 16, "idIME" => 1));
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 17, "idIME" => 1));
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 18, "idIME" => 1));
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 19, "idIME" => 1));
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 20, "idIME" => 1));
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 21, "idIME" => 1));
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 22, "idIME" => 1));
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 23, "idIME" => 1));
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 24, "idIME" => 1));

$prep = $db->query("call etudie(:id,:idIME)", array("id" => 19, "idIME" => 2));
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 20, "idIME" => 2));
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 21, "idIME" => 2));
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 22, "idIME" => 2));
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 23, "idIME" => 2));
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 24, "idIME" => 2));

$prep = $db->query("call etudie(:id,:idIME)", array("id" => 22, "idIME" => 3));
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 23, "idIME" => 3));
$prep = $db->query("call etudie(:id,:idIME)", array("id" => 24, "idIME" => 3));


// creation des categories
$prep = $db->query("call createCategorie(:nom, :desc, :idIME)", array("nom" => "Communication", "desc" => "Développer les compétences en expression orale et écrite", "idIME" => 1));
$prep = $db->query("call createCategorie(:nom, :desc, :idIME)", array("nom" => "Autonomie", "desc" => "Apprendre à effectuer des tâches simples de la vie quotidienne", "idIME" => 1));
$prep = $db->query("call createCategorie(:nom, :desc, :idIME)", array("nom" => "Socialisation", "desc" => "Apprendre à se comporter dans des situations sociales et à respecter les règles", "idIME" => 1));
$prep = $db->query("call createCategorie(:nom, :desc, :idIME)", array("nom" => "Expression", "desc" => "Favoriser une expression de ses émotions et ses besoins", "idIME" => 1));
$prep = $db->query("call createCategorie(:nom, :desc, :idIME)", array("nom" => "Cognition", "desc" => "Développer les compétences en raisonnement et résolution de problème", "idIME" => 1));
$prep = $db->query("call createCategorie(:nom, :desc, :idIME)", array("nom" => "Motricité", "desc" => "Améliorer la coordination et la dextérité manuelle", "idIME" => 1));

$prep = $db->query("call createCategorie(:nom, :desc, :idIME)", array("nom" => "Communication", "desc" => "Développer les compétences en expression orale et écrite", "idIME" => 2));
$prep = $db->query("call createCategorie(:nom, :desc, :idIME)", array("nom" => "Autonomie", "desc" => "Apprendre à effectuer des tâches simples de la vie quotidienne", "idIME" => 2));
$prep = $db->query("call createCategorie(:nom, :desc, :idIME)", array("nom" => "Socialisation", "desc" => "Apprendre à se comporter dans des situations sociales et à respecter les règles", "idIME" => 3));

$prep = $db->query("call createCategorie(:nom, :desc, :idIME)", array("nom" => "Expression", "desc" => "Favoriser une expression de ses émotions et ses besoins", "idIME" => 3));
$prep = $db->query("call createCategorie(:nom, :desc, :idIME)", array("nom" => "Cognition", "desc" => "Développer les compétences en raisonnement et résolution de problème", "idIME" => 3));
$prep = $db->query("call createCategorie(:nom, :desc, :idIME)", array("nom" => "Motricité", "desc" => "Améliorer la coordination et la dextérité manuelle", "idIME" => 3));


// creation des competences
$ListeIdcat = array();
array_push($ListeIdcat, 1);
array_push($ListeIdcat, 6);
$db->createCompetence("Ecriture simple", "Apprendre à écrire des phrases simples", $ListeIdcat);
$ListeIdcat = array();
array_push($ListeIdcat, 7);
$db->createCompetence("Ecriture simple", "Apprendre à écrire des phrases simples", $ListeIdcat);
$ListeIdcat = array();
array_push($ListeIdcat, 10);
$db->createCompetence("Ecriture simple", "Apprendre à écrire des phrases simples", $ListeIdcat);

$ListeIdcat = array();
array_push($ListeIdcat, 1);
array_push($ListeIdcat, 6);
$db->createCompetence("Lecture Simple", "Apprendre à lie des phrases simples", $ListeIdcat);
$ListeIdcat = array();
array_push($ListeIdcat, 7);
$db->createCompetence("Lecture Simple", "Apprendre à lie des phrases simples", $ListeIdcat);
$ListeIdcat = array();
array_push($ListeIdcat, 10);
$db->createCompetence("Lecture Simple", "Apprendre à lie des phrases simples", $ListeIdcat);

$ListeIdcat = array();
array_push($ListeIdcat, 1);
array_push($ListeIdcat, 3);
$db->createCompetence("Ecoute active", "Apprendre à écouter et comprendre les consignes orales", $ListeIdcat);
$ListeIdcat = array();
array_push($ListeIdcat, 7);
array_push($ListeIdcat, 9);
$db->createCompetence("Ecoute active", "Apprendre à écouter et comprendre les consignes orales", $ListeIdcat);

$ListeIdcat = array();
array_push($ListeIdcat, 2);
array_push($ListeIdcat, 6);
$db->createCompetence("Préparation des repas", "Apprendre à préparer des repas simples", $ListeIdcat);
$ListeIdcat = array();
array_push($ListeIdcat, 8);
$db->createCompetence("Préparation des repas", "Apprendre à préparer des repas simples", $ListeIdcat);
$ListeIdcat = array();
array_push($ListeIdcat, 12);
$db->createCompetence("Préparation des repas", "Apprendre à préparer des repas simples", $ListeIdcat);

$ListeIdcat = array();
array_push($ListeIdcat, 5);
array_push($ListeIdcat, 6);
$db->createCompetence("Résolution de puzzles", "Apprendre à résoudre des puzzles simples", $ListeIdcat);
$ListeIdcat = array();
array_push($ListeIdcat, 11);
array_push($ListeIdcat, 12);
$db->createCompetence("Résolution de puzzles", "Apprendre à résoudre des puzzles simples", $ListeIdcat);

$ListeIdcat = array();
array_push($ListeIdcat, 5);
array_push($ListeIdcat, 6);
$db->createCompetence("Jeux de mémoire", "Apprendre à mémoriser des informations", $ListeIdcat);
$ListeIdcat = array();
array_push($ListeIdcat, 11);
array_push($ListeIdcat, 12);
$db->createCompetence("Jeux de mémoire", "Apprendre à mémoriser des informations", $ListeIdcat);

$ListeIdcat = array();
array_push($ListeIdcat, 2);
array_push($ListeIdcat, 6);
$db->createCompetence("Manipulation de formes", "Améliorer la coordination en manipulant des formes", $ListeIdcat);
$ListeIdcat = array();
array_push($ListeIdcat, 8);
$db->createCompetence("Manipulation de formes", "Améliorer la coordination en manipulant des formes", $ListeIdcat);
$ListeIdcat = array();
array_push($ListeIdcat, 12);
$db->createCompetence("Manipulation de formes", "Améliorer la coordination en manipulant des formes", $ListeIdcat);

$ListeIdcat = array();
array_push($ListeIdcat, 2);
array_push($ListeIdcat, 6);
$db->createCompetence("Construction en blocs", "Améliorer la dextérité manuelle en construisant des structures avec des blocs", $ListeIdcat);
$ListeIdcat = array();
array_push($ListeIdcat, 8);
$db->createCompetence("Construction en blocs", "Améliorer la dextérité manuelle en construisant des structures avec des blocs", $ListeIdcat);
$ListeIdcat = array();
array_push($ListeIdcat, 12);
$db->createCompetence("Construction en blocs", "Améliorer la dextérité manuelle en construisant des structures avec des blocs", $ListeIdcat);

$ListeIdcat = array();
array_push($ListeIdcat, 5);
$db->createCompetence("Résolution de problème", "Apprendre à compter", $ListeIdcat);

$ListeIdcat = array();
array_push($ListeIdcat, 10);
$db->createCompetence("Comptage", "Apprendre à résoudre des problèmes simples", $ListeIdcat);

$ListeIdcat = array();
array_push($ListeIdcat, 8);
$db->createCompetence("Formes", "Apprendre à identifier les formes simples", $ListeIdcat);

$ListeIdcat = array();
array_push($ListeIdcat, 2);
$db->createCompetence("Couleurs", "Apprendre à identifier les couleurs", $ListeIdcat);

$ListeIdcat = array();
array_push($ListeIdcat, 1);
array_push($ListeIdcat, 2);
array_push($ListeIdcat, 4);
array_push($ListeIdcat, 6);
$db->createCompetence("Écriture des lettres", "Apprendre à écrire les lettres", $ListeIdcat);
$ListeIdcat = array();
array_push($ListeIdcat, 7);
array_push($ListeIdcat, 8);
$db->createCompetence("Écriture des lettres", "Apprendre à écrire les lettres", $ListeIdcat);
$ListeIdcat = array();
array_push($ListeIdcat, 10);
array_push($ListeIdcat, 12);
$db->createCompetence("Écriture des lettres", "Apprendre à écrire les lettres", $ListeIdcat);

$ListeIdcat = array();
array_push($ListeIdcat, 1);
$db->createCompetence("Comptines", "Apprendre les comptines simples", $ListeIdcat);

$ListeIdcat = array();
array_push($ListeIdcat, 12);
$db->createCompetence("Coloriage", "Apprendre à colorier des formes simples", $ListeIdcat);



// creation des activites 
$prep = $db->query("select createActivite(:nom, :desc, :idIME)", array("nom" => "Atelier lecture", "desc" => "Les élèves lisent une histoire en autonomie", "idIME" => 1));
$prep = $db->query("select createActivite(:nom, :desc, :idIME)", array("nom" => "Atelier lecture", "desc" => "Les élèves lisent une histoire en autonomie", "idIME" => 2));
$prep = $db->query("select createActivite(:nom, :desc, :idIME)", array("nom" => "Atelier lecture", "desc" => "Les élèves lisent une histoire en autonomie", "idIME" => 3));

$prep = $db->query("select createActivite(:nom, :desc, :idIME)", array("nom" => "Uno", "desc" => "Jouer au Uno", "idIME" => 1));
$prep = $db->query("select createActivite(:nom, :desc, :idIME)", array("nom" => "Uno", "desc" => "Jouer au Uno", "idIME" => 2));
$prep = $db->query("select createActivite(:nom, :desc, :idIME)", array("nom" => "Uno", "desc" => "Jouer au Uno", "idIME" => 3));

$prep = $db->query("select createActivite(:nom, :desc, :idIME)", array("nom" => "Tri des produits de supermarché", "desc" => "savoir reconnaitre les différents prodit et les placer dans les casiers correspondants", "idIME" => 1));
$prep = $db->query("select createActivite(:nom, :desc, :idIME)", array("nom" => "Tri des produits de supermarché", "desc" => "savoir reconnaitre les différents prodit et les placer dans les casiers correspondants", "idIME" => 2));
$prep = $db->query("select createActivite(:nom, :desc, :idIME)", array("nom" => "Tri des produits de supermarché", "desc" => "savoir reconnaitre les différents prodit et les placer dans les casiers correspondants", "idIME" => 3));


//  associer les competences aux activités(il faut au moins associer une competence par activité 
//  et on peut les changer depuis le site plus facilement)
$prep = $db->query("call competenceActivite(:idComp, :idAc, 1,0)", array("idComp" => 4, "idAc" => 1));

$prep = $db->query("call competenceActivite(:idComp, :idAc, 1,0)", array("idComp" => 5, "idAc" => 2));

$prep = $db->query("call competenceActivite(:idComp, :idAc, 1,0)", array("idComp" => 6, "idAc" => 3));

$prep = $db->query("call competenceActivite(:idComp, :idAc, 1,0)", array("idComp" => 4, "idAc" => 4));

$prep = $db->query("call competenceActivite(:idComp, :idAc, 1,0)", array("idComp" => 5, "idAc" => 5));

$prep = $db->query("call competenceActivite(:idComp, :idAc, 1,0)", array("idComp" => 6, "idAc" => 6));

$prep = $db->query("call competenceActivite(:idComp, :idAc, 1,0)", array("idComp" => 4, "idAc" => 7));

$prep = $db->query("call competenceActivite(:idComp, :idAc, 1,0)", array("idComp" => 5, "idAc" => 8));

$prep = $db->query("call competenceActivite(:idComp, :idAc, 1,0)", array("idComp" => 6, "idAc" => 9));


echo "Si vous voyez ca c'est que tout marche bien";