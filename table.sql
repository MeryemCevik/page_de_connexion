/*MISSION 1 :*/
/* ici je créer la table utlisateurs*/
CREATE TABLE `utilisateurs` (
   `id` int(10) unsigned NOT NULL auto_increment,
   `date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP, /*en choisi la date actuelle et on updtae(actualise) le temps*/
   `nom` varchar(40) NOT NULL,
   `prenom` varchar(40) NOT NULL,
   `login` varchar(40) NOT NULL,
   `pass` varchar(40) NOT NULL,
   PRIMARY KEY (`id`)
);