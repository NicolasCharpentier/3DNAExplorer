-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mar 30 Décembre 2014 à 19:32
-- Version du serveur :  5.5.38
-- Version de PHP :  5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `bioptimize`
--

-- --------------------------------------------------------

--
-- Structure de la table `seq_locus`
--

CREATE TABLE `seq_locus` (
`id` int(11) NOT NULL,
  `id_locus` int(11) NOT NULL,
  `base` varchar(70) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3428325 DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `seq_locus`