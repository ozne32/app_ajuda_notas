-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: ajuda_nota
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `ajuda_nota`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `ajuda_nota` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `ajuda_nota`;

--
-- Table structure for table `tb_materias`
--

DROP TABLE IF EXISTS `tb_materias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_materias` (
  `id_materia` int(11) NOT NULL AUTO_INCREMENT,
  `nome_materia` varchar(100) NOT NULL,
  PRIMARY KEY (`id_materia`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tb_materias` WRITE;
/*!40000 ALTER TABLE `tb_materias` DISABLE KEYS */;
INSERT INTO `tb_materias` VALUES (1,'Física'),(2,'Matematica'),(3,'Interpretação textual'),(4,'Química'),(5,'Geografia'),(6,'História'),(7,'Sociologia'),(8,'Literatura'),(9,'Inglês'),(10,'Filosofia'),(11,'Biologia');
/*!40000 ALTER TABLE `tb_materias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_observacao`
--

DROP TABLE IF EXISTS `tb_observacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_observacao` (
  `observacao` text NOT NULL,
  `id_observacao` int(11) NOT NULL AUTO_INCREMENT,
  `tb_user_materia` int(11) NOT NULL,
  PRIMARY KEY (`id_observacao`),
  KEY `tb_user_materia` (`tb_user_materia`),
  CONSTRAINT `tb_observacao_ibfk_1` FOREIGN KEY (`tb_user_materia`) REFERENCES `tb_user_materia` (`id_user_materia`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_simulados`
--

DROP TABLE IF EXISTS `tb_simulados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_simulados` (
  `id_simulado` int(11) NOT NULL AUTO_INCREMENT,
  `nome_simulado` varchar(100) NOT NULL,
  PRIMARY KEY (`id_simulado`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


LOCK TABLES `tb_simulados` WRITE;
/*!40000 ALTER TABLE `tb_simulados` DISABLE KEYS */;
INSERT INTO `tb_simulados` VALUES (1,'enem'),(2,'fuvest'),(3,'unicamp'),(4,'unesp');
/*!40000 ALTER TABLE `tb_simulados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_user_materia`
--

DROP TABLE IF EXISTS `tb_user_materia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_user_materia` (
  `id_user_materia` int(11) NOT NULL AUTO_INCREMENT,
  `acertos` int(2) NOT NULL,
  `erros` int(2) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `id_simulado` int(11) NOT NULL,
  PRIMARY KEY (`id_user_materia`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_materia` (`id_materia`),
  KEY `id_simulado` (`id_simulado`),
  CONSTRAINT `tb_user_materia_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`),
  CONSTRAINT `tb_user_materia_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `tb_materias` (`id_materia`),
  CONSTRAINT `tb_user_materia_ibfk_3` FOREIGN KEY (`id_simulado`) REFERENCES `tb_simulados` (`id_simulado`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_usuario`
--

DROP TABLE IF EXISTS `tb_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(25) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-21 21:21:26
