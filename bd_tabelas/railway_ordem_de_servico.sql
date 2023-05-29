-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: containers-us-west-64.railway.app    Database: railway
-- ------------------------------------------------------
-- Server version	8.0.33

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ordem_de_servico`
--

DROP TABLE IF EXISTS `ordem_de_servico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ordem_de_servico` (
  `id` int NOT NULL AUTO_INCREMENT,
  `data_ordem` date DEFAULT NULL,
  `cliente_id` int DEFAULT NULL,
  `animal_id` int DEFAULT NULL,
  `funcionario_id` int DEFAULT NULL,
  `servico_id` int DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_termino` time DEFAULT NULL,
  `duracao` varchar(100) DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'aguardando',
  PRIMARY KEY (`id`),
  KEY `cliente_id` (`cliente_id`),
  KEY `animal_id` (`animal_id`),
  KEY `funcionario_id` (`funcionario_id`),
  KEY `servico_id` (`servico_id`),
  CONSTRAINT `ordem_de_servico_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  CONSTRAINT `ordem_de_servico_ibfk_2` FOREIGN KEY (`animal_id`) REFERENCES `animais` (`id`),
  CONSTRAINT `ordem_de_servico_ibfk_3` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionarios` (`id`),
  CONSTRAINT `ordem_de_servico_ibfk_4` FOREIGN KEY (`servico_id`) REFERENCES `servicos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordem_de_servico`
--

LOCK TABLES `ordem_de_servico` WRITE;
/*!40000 ALTER TABLE `ordem_de_servico` DISABLE KEYS */;
INSERT INTO `ordem_de_servico` VALUES (1,'2023-05-20',3,8,1,1,'20:16:00','20:20:00','4 minutos','aguardando');
/*!40000 ALTER TABLE `ordem_de_servico` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-29 20:47:47
