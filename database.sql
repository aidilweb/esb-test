/*
 Navicat Premium Data Transfer

 Source Server         : Local
 Source Server Type    : MySQL
 Source Server Version : 100803
 Source Host           : localhost:3306
 Source Schema         : test_esb

 Target Server Type    : MySQL
 Target Server Version : 100803
 File Encoding         : 65001

 Date: 07/01/2023 16:15:03
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tb_client
-- ----------------------------
DROP TABLE IF EXISTS `tb_client`;
CREATE TABLE `tb_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of tb_client
-- ----------------------------
BEGIN;
INSERT INTO `tb_client` (`id`, `name`, `address_1`, `address_2`, `country`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, 'Barrington Publishers', '17 Great Suffolk Street', 'London SE1 0NS', 'United Kingdom', '2023-01-06 23:37:17', NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for tb_invoice
-- ----------------------------
DROP TABLE IF EXISTS `tb_invoice`;
CREATE TABLE `tb_invoice` (
  `id` char(4) NOT NULL,
  `issue_date` date NOT NULL,
  `due_date` date NOT NULL,
  `subject` varchar(255) NOT NULL,
  `client_id` int(11) NOT NULL,
  `subtotal` double(11,2) NOT NULL,
  `tax` double(11,2) NOT NULL,
  `payment` double(11,2) NOT NULL,
  `amount_due` double(11,2) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`client_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of tb_invoice
-- ----------------------------
BEGIN;
INSERT INTO `tb_invoice` (`id`, `issue_date`, `due_date`, `subject`, `client_id`, `subtotal`, `tax`, `payment`, `amount_due`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES ('0001', '2023-01-07', '2023-01-07', 'Spring Marketing Campaign', 1, 28510.00, 2851.00, 31361.00, 0.00, '1', '2023-01-07 11:42:33', '2023-01-07 16:08:47', NULL);
COMMIT;

-- ----------------------------
-- Table structure for tb_invoice_detail
-- ----------------------------
DROP TABLE IF EXISTS `tb_invoice_detail`;
CREATE TABLE `tb_invoice_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` char(4) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` double(11,2) DEFAULT NULL,
  `amount` double(11,2) DEFAULT NULL,
  PRIMARY KEY (`id`,`invoice_id`,`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of tb_invoice_detail
-- ----------------------------
BEGIN;
INSERT INTO `tb_invoice_detail` (`id`, `invoice_id`, `item_id`, `qty`, `amount`) VALUES (14, '0001', 1, 41.00, 9430.00);
INSERT INTO `tb_invoice_detail` (`id`, `invoice_id`, `item_id`, `qty`, `amount`) VALUES (15, '0001', 2, 57.00, 18810.00);
INSERT INTO `tb_invoice_detail` (`id`, `invoice_id`, `item_id`, `qty`, `amount`) VALUES (16, '0001', 3, 4.50, 270.00);
COMMIT;

-- ----------------------------
-- Table structure for tb_item
-- ----------------------------
DROP TABLE IF EXISTS `tb_item`;
CREATE TABLE `tb_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` double(11,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of tb_item
-- ----------------------------
BEGIN;
INSERT INTO `tb_item` (`id`, `type`, `description`, `price`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, 'Service', 'Design', 230.00, '2023-01-07 00:04:08', NULL, NULL);
INSERT INTO `tb_item` (`id`, `type`, `description`, `price`, `created_at`, `updated_at`, `deleted_at`) VALUES (2, 'Service', 'Development', 330.00, '2023-01-07 00:04:29', NULL, NULL);
INSERT INTO `tb_item` (`id`, `type`, `description`, `price`, `created_at`, `updated_at`, `deleted_at`) VALUES (3, 'Service', 'Meetings', 60.00, '2023-01-07 00:04:45', NULL, NULL);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
