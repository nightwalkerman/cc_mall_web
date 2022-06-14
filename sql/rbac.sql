-- MySQL dump 10.13  Distrib 8.0.26, for Linux (x86_64)
--
-- Host: localhost    Database: cc_rbac
-- ------------------------------------------------------
-- Server version	8.0.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cc_admin`
--

DROP TABLE IF EXISTS `cc_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cc_admin` (
  `admin_id` int NOT NULL AUTO_INCREMENT COMMENT '管理员ID，系统自增',
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '登陆账号',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '登陆密码',
  `pay_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '支付密码',
  `role_id` int DEFAULT NULL COMMENT '角色ID',
  `status` int DEFAULT '1' COMMENT '管理员状态：1正常，2删除',
  `nickname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '昵称',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '备注',
  `mobile` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '手机',
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '邮箱',
  `enabled` int DEFAULT '1' COMMENT '账号状态：1正常：2冻结',
  `add_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增时间，默认为数据库新增时间',
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cc_admin`
--

LOCK TABLES `cc_admin` WRITE;
/*!40000 ALTER TABLE `cc_admin` DISABLE KEYS */;
INSERT INTO `cc_admin` VALUES (1,'admin','$2y$10$9/mRGk/t8M1onucMliakHO6KZisMrxflGLBw/vnKKR/AY.Q9Niq4a','$2y$10$9/mRGk/t8M1onucMliakHO6KZisMrxflGLBw/vnKKR/AY.Q9Niq4a',1,1,NULL,NULL,NULL,NULL,1,'2022-01-10 08:15:01'),(35,'aaaccc','$2y$10$LTLThS27dJO1EPHbjQv4Z.1OdYPswYJy8xkvAw/MB0a2XeHOUrRBW',NULL,42,1,'333','666','444','555',1,'2022-01-10 09:05:46'),(36,'bbb','$2y$10$xtF7f0F0uPasvzTfavcduuUCIwslvtPd2cxgDE/PGCUQyfADIDkza',NULL,43,1,'1','4','2','34',2,'2022-01-10 09:12:38'),(37,'3','$2y$10$HlgJXNZWYV0mfmx4MGLZcu3r3FICqGhCjCYaHgdf/.FG8YlHg1E7m',NULL,43,1,'3','3','3','3',1,'2022-01-10 09:15:25'),(38,'aaa','$2y$10$XxAeWEX3b2.kjqeBVDP4Fu36zZwaVPu8.pBxSx8jIjSq6NpumZ71S',NULL,46,1,'','','','',1,'2022-01-12 09:54:44');
/*!40000 ALTER TABLE `cc_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cc_node`
--

DROP TABLE IF EXISTS `cc_node`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cc_node` (
  `node_id` int NOT NULL AUTO_INCREMENT COMMENT '节点ID，系统自增',
  `parent_id` int DEFAULT '0' COMMENT '上级节点ID',
  `node_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '节点名称',
  `node_action` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '#' COMMENT '节点路径',
  `action_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '节点权限',
  `sort` int DEFAULT '100' COMMENT '排序',
  `icon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '图标',
  `status` int DEFAULT '1' COMMENT '节点状态：1正常，2删除',
  `add_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增时间，默认为数据库新增时间',
  PRIMARY KEY (`node_id`),
  UNIQUE KEY `action_code` (`action_code`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cc_node`
--

LOCK TABLES `cc_node` WRITE;
/*!40000 ALTER TABLE `cc_node` DISABLE KEYS */;
INSERT INTO `cc_node` VALUES (1,0,'authority_management','#','admin',100,'el-icon-brush',1,'2021-01-25 05:45:48'),(5,1,'admin_user_list','/manager/adminList','adminList',10,'el-icon-user',1,'2018-06-29 02:14:50'),(20,1,'admin_role_list','/manager/roleList','roleList',20,'el-icon-s-check',1,'2018-06-29 02:14:50'),(93,0,'test','#','test',100,'el-icon-s-open',1,'2022-01-07 11:49:08'),(94,93,'test_list','/manager/testList','testList',100,'el-icon-s-order',1,'2022-01-07 11:49:20');
/*!40000 ALTER TABLE `cc_node` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cc_role`
--

DROP TABLE IF EXISTS `cc_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cc_role` (
  `role_id` int NOT NULL AUTO_INCREMENT COMMENT '角色ID，系统自增',
  `role_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '角色名称',
  `action_code` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '角色节点权限',
  `menu_code` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '角色后台菜单显示',
  `status` int DEFAULT '1' COMMENT '角色状态：1正常，2删除',
  `read_write` int DEFAULT '2' COMMENT '读写权限：1只读，2读写',
  `add_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增时间，默认为数据库新增时间',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cc_role`
--

LOCK TABLES `cc_role` WRITE;
/*!40000 ALTER TABLE `cc_role` DISABLE KEYS */;
INSERT INTO `cc_role` VALUES (1,'系统管理员','all',NULL,1,2,'2018-06-28 08:46:13'),(42,'a1','admin,adminList,roleList','admin,adminList,roleList',1,1,'2022-01-10 12:47:15'),(43,'测试','adminList,test,testList','admin,adminList,test,testList',1,1,'2022-01-10 13:05:57'),(46,'t22','roleList,test,testList','admin,roleList,test,testList',1,1,'2022-01-12 08:48:13');
/*!40000 ALTER TABLE `cc_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cc_test`
--

DROP TABLE IF EXISTS `cc_test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cc_test` (
  `test_id` int NOT NULL AUTO_INCREMENT COMMENT '测试ID，系统自增',
  `title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '测试标题',
  `add_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增时间',
  PRIMARY KEY (`test_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cc_test`
--

LOCK TABLES `cc_test` WRITE;
/*!40000 ALTER TABLE `cc_test` DISABLE KEYS */;
INSERT INTO `cc_test` VALUES (18,'333','2022-01-09 12:04:40'),(19,'444','2022-01-09 12:04:43'),(22,'555','2022-01-12 08:37:30'),(23,'666','2022-01-12 09:01:21'),(24,'777','2022-01-12 09:16:32'),(25,'888','2022-01-12 11:16:55');
/*!40000 ALTER TABLE `cc_test` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-21 21:31:47
