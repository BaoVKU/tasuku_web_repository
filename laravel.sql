/*
 Navicat Premium Data Transfer

 Source Server         : MySQLConnection
 Source Server Type    : MySQL
 Source Server Version : 100428 (10.4.28-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : laravel

 Target Server Type    : MySQL
 Target Server Version : 100428 (10.4.28-MariaDB)
 File Encoding         : 65001

 Date: 13/05/2024 21:16:39
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for comment_attachments
-- ----------------------------
DROP TABLE IF EXISTS `comment_attachments`;
CREATE TABLE `comment_attachments`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `comment_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `comment_attachments_comment_id_foreign`(`comment_id` ASC) USING BTREE,
  CONSTRAINT `comment_attachments_comment_id_foreign` FOREIGN KEY (`comment_id`) REFERENCES `task_comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of comment_attachments
-- ----------------------------
INSERT INTO `comment_attachments` VALUES (1, 1, '54e0d04a4c5ba414f1dc8460962e33791c3ad6e04e507440722d72d59345c2_640', 'jpg', 'image/jpeg', 'storage/attachments/comment/4oFDnr7Cd1z5hDjNLAz4C9fHGOZyn1x8n92wfKfo.jpg', '2023-12-12 23:48:50', NULL);
INSERT INTO `comment_attachments` VALUES (3, 3, 'squirrel', 'jpg', 'image/jpeg', 'storage/attachments/comment/pOOavtJZzRTjjVsHsNqqPbW7GuSrExgSvxVW0IDg.jpg', '2024-05-07 13:44:31', NULL);

-- ----------------------------
-- Table structure for email_attachments
-- ----------------------------
DROP TABLE IF EXISTS `email_attachments`;
CREATE TABLE `email_attachments`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `email_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `email_attachments_email_id_foreign`(`email_id` ASC) USING BTREE,
  CONSTRAINT `email_attachments_email_id_foreign` FOREIGN KEY (`email_id`) REFERENCES `emails` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of email_attachments
-- ----------------------------
INSERT INTO `email_attachments` VALUES (1, 1, 'LICH THI K202122 HKI NH 2324_CT', 'xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'storage/attachments/mail/UgAs1MPNc7QDAfaOzTSHc7oFADjRrodqWlANRixO.xlsx', '2023-12-13 00:17:34', NULL);

-- ----------------------------
-- Table structure for email_receivers
-- ----------------------------
DROP TABLE IF EXISTS `email_receivers`;
CREATE TABLE `email_receivers`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `email_id` bigint UNSIGNED NOT NULL,
  `receiver_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `email_receivers_email_id_foreign`(`email_id` ASC) USING BTREE,
  INDEX `email_receivers_receiver_id_foreign`(`receiver_id` ASC) USING BTREE,
  CONSTRAINT `email_receivers_email_id_foreign` FOREIGN KEY (`email_id`) REFERENCES `emails` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `email_receivers_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of email_receivers
-- ----------------------------
INSERT INTO `email_receivers` VALUES (1, 1, 2, '2023-12-12 23:53:09', NULL);
INSERT INTO `email_receivers` VALUES (2, 2, 2, '2023-12-13 00:15:28', NULL);
INSERT INTO `email_receivers` VALUES (3, 3, 2, '2023-12-13 00:20:13', NULL);
INSERT INTO `email_receivers` VALUES (4, 3, 3, '2023-12-13 00:20:13', NULL);

-- ----------------------------
-- Table structure for emails
-- ----------------------------
DROP TABLE IF EXISTS `emails`;
CREATE TABLE `emails`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sender_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `emails_sender_id_foreign`(`sender_id` ASC) USING BTREE,
  CONSTRAINT `emails_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of emails
-- ----------------------------
INSERT INTO `emails` VALUES (1, 1, 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at quam id libero accumsan convallis et in sem. Nullam vel ipsum et est lacinia aliquet ac ac leo. Donec pulvinar vestibulum ex vel laoreet. Nullam ullamcorper lectus nec est consectetur, eu convallis ipsum accumsan. Aenean scelerisque ipsum sit amet luctus convallis. In tristique nunc dapibus erat maximus accumsan. Suspendisse sagittis quis dui non varius. Aliquam erat volutpat. Pellentesque volutpat consequat diam sit amet venenatis. Proin quis dapibus nunc. Nam suscipit, nibh id consectetur porttitor, lacus turpis pulvinar eros, in pretium massa lorem ac felis. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam viverra magna quis molestie rhoncus.', '2023-12-12 23:53:09', NULL);
INSERT INTO `emails` VALUES (2, 1, 'mail test', 'test', '2023-12-13 00:15:28', NULL);
INSERT INTO `emails` VALUES (3, 1, 'mail test 222', '2222', '2023-12-13 00:20:13', NULL);

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for group_members
-- ----------------------------
DROP TABLE IF EXISTS `group_members`;
CREATE TABLE `group_members`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `group_id` bigint UNSIGNED NOT NULL,
  `member_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `group_members_group_id_foreign`(`group_id` ASC) USING BTREE,
  INDEX `group_members_member_id_foreign`(`member_id` ASC) USING BTREE,
  CONSTRAINT `group_members_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `group_members_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of group_members
-- ----------------------------
INSERT INTO `group_members` VALUES (1, 1, 1, '2023-12-12 23:21:20', NULL);
INSERT INTO `group_members` VALUES (2, 1, 2, '2023-12-12 23:37:35', NULL);
INSERT INTO `group_members` VALUES (3, 1, 3, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (4, 1, 4, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (5, 1, 5, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (6, 1, 6, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (7, 1, 7, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (8, 1, 8, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (9, 1, 9, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (10, 1, 10, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (11, 1, 11, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (12, 1, 12, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (13, 1, 13, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (14, 1, 14, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (15, 1, 15, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (16, 1, 16, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (17, 1, 17, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (18, 1, 18, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (19, 1, 19, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (20, 1, 20, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (21, 1, 21, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (22, 1, 22, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (23, 1, 23, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (24, 1, 24, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (25, 1, 25, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (26, 1, 26, '2023-12-12 23:39:38', NULL);
INSERT INTO `group_members` VALUES (27, 2, 1, '2024-05-11 16:14:54', NULL);
INSERT INTO `group_members` VALUES (28, 3, 115, '2024-05-11 16:20:01', NULL);
INSERT INTO `group_members` VALUES (34, 3, 1, '2024-05-12 16:32:29', NULL);

-- ----------------------------
-- Table structure for groups
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `creator_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `join_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `groups_join_key_unique`(`join_key` ASC) USING BTREE,
  INDEX `groups_creator_id_foreign`(`creator_id` ASC) USING BTREE,
  CONSTRAINT `groups_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of groups
-- ----------------------------
INSERT INTO `groups` VALUES (1, 1, 'Marketing Department', 'this is description of Marketing Department group.', '356a192b7913b04c54574d18c28d46e6395428ab', '2023-12-12 23:21:20', NULL);
INSERT INTO `groups` VALUES (2, 1, 'new group 1', 'description', 'da4b9237bacccdf19c0760cab7aec4a8359010b0', '2024-05-11 16:14:54', NULL);
INSERT INTO `groups` VALUES (3, 115, 'Join me', 'join me please', '77de68daecd823babbb58edb1c8e14d7106e83bb', '2024-05-11 16:20:01', NULL);

-- ----------------------------
-- Table structure for message_attachments
-- ----------------------------
DROP TABLE IF EXISTS `message_attachments`;
CREATE TABLE `message_attachments`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `message_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `message_attachments_message_id_foreign`(`message_id` ASC) USING BTREE,
  CONSTRAINT `message_attachments_message_id_foreign` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of message_attachments
-- ----------------------------
INSERT INTO `message_attachments` VALUES (1, 3, '54e1d1444e52ac14f1dc8460962e33791c3ad6e04e50744172277ed0974ac3_640', 'jpg', 'image/jpeg', 'storage/attachments/chat/js1Nua3FuG4xkHcTKcoP3ZFp9n3fnIjb0VeHtrPS.jpg', '2023-12-12 23:57:02', NULL);
INSERT INTO `message_attachments` VALUES (2, 5, 'LICH THI K202122 HKI NH 2324_CT', 'xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'storage/attachments/chat/1OSNfiyzSU78wYoRZRYle4tRPfhO9rqJayuXMndr.xlsx', '2023-12-12 23:57:42', NULL);

-- ----------------------------
-- Table structure for message_channels
-- ----------------------------
DROP TABLE IF EXISTS `message_channels`;
CREATE TABLE `message_channels`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_user_id` bigint UNSIGNED NOT NULL,
  `second_user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `message_channels_name_unique`(`name` ASC) USING BTREE,
  INDEX `message_channels_first_user_id_foreign`(`first_user_id` ASC) USING BTREE,
  INDEX `message_channels_second_user_id_foreign`(`second_user_id` ASC) USING BTREE,
  CONSTRAINT `message_channels_first_user_id_foreign` FOREIGN KEY (`first_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `message_channels_second_user_id_foreign` FOREIGN KEY (`second_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of message_channels
-- ----------------------------
INSERT INTO `message_channels` VALUES (1, 1, 2, 'user-1-and-user-2-channel', '2023-12-12 23:51:13', NULL);

-- ----------------------------
-- Table structure for messages
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `channel_id` bigint UNSIGNED NOT NULL,
  `sender_id` bigint UNSIGNED NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `messages_channel_id_foreign`(`channel_id` ASC) USING BTREE,
  CONSTRAINT `messages_channel_id_foreign` FOREIGN KEY (`channel_id`) REFERENCES `message_channels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of messages
-- ----------------------------
INSERT INTO `messages` VALUES (1, 1, 1, 'chào bạn 😜', '2023-12-12 23:56:03', NULL);
INSERT INTO `messages` VALUES (2, 1, 1, 'cho mình xin tài liệu này được không', '2023-12-12 23:56:41', NULL);
INSERT INTO `messages` VALUES (3, 1, 1, NULL, '2023-12-12 23:57:02', NULL);
INSERT INTO `messages` VALUES (4, 1, 2, 'ok đợi mình tí 😉', '2023-12-12 23:57:31', NULL);
INSERT INTO `messages` VALUES (5, 1, 2, NULL, '2023-12-12 23:57:42', NULL);
INSERT INTO `messages` VALUES (6, 1, 2, 'nè', '2023-12-12 23:57:52', NULL);
INSERT INTO `messages` VALUES (7, 1, 1, 'ok mik cảm ơn nha 😘', '2023-12-12 23:58:07', NULL);
INSERT INTO `messages` VALUES (8, 1, 2, 'k có chi', '2023-12-12 23:58:14', NULL);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 163 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (135, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (136, '2014_10_12_100000_create_password_reset_tokens_table', 1);
INSERT INTO `migrations` VALUES (137, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (138, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (139, '2023_11_18_123056_create_user_avatars_table', 1);
INSERT INTO `migrations` VALUES (140, '2023_11_18_123125_create_user_sessions_table', 1);
INSERT INTO `migrations` VALUES (141, '2023_11_18_123153_create_notifications_table', 1);
INSERT INTO `migrations` VALUES (142, '2023_11_18_123217_create_groups_table', 1);
INSERT INTO `migrations` VALUES (143, '2023_11_18_123225_create_group_members_table', 1);
INSERT INTO `migrations` VALUES (144, '2023_11_18_123257_create_tasks_table', 1);
INSERT INTO `migrations` VALUES (145, '2023_11_18_123304_create_task_members_table', 1);
INSERT INTO `migrations` VALUES (146, '2023_11_18_123317_create_task_attachments_table', 1);
INSERT INTO `migrations` VALUES (147, '2023_11_18_123336_create_task_comments_table', 1);
INSERT INTO `migrations` VALUES (148, '2023_11_18_123350_create_comment_attachments_table', 1);
INSERT INTO `migrations` VALUES (149, '2023_11_18_123414_create_emails_table', 1);
INSERT INTO `migrations` VALUES (150, '2023_11_18_123424_create_email_receivers_table', 1);
INSERT INTO `migrations` VALUES (151, '2023_11_18_123433_create_email_attachments_table', 1);
INSERT INTO `migrations` VALUES (152, '2023_11_18_123447_create_messages_table', 1);
INSERT INTO `migrations` VALUES (153, '2023_11_18_123457_create_message_attachments_table', 1);
INSERT INTO `migrations` VALUES (154, '2023_11_18_142202_create_task_operations_table', 1);
INSERT INTO `migrations` VALUES (155, '2023_11_19_093438_add_join_key', 2);
INSERT INTO `migrations` VALUES (156, '2023_11_19_151310_add_mode_tasks_table', 3);
INSERT INTO `migrations` VALUES (157, '2023_11_21_033556_integrate_avatar', 4);
INSERT INTO `migrations` VALUES (158, '2023_12_03_085746_alter_message_table', 5);
INSERT INTO `migrations` VALUES (159, '2023_12_03_090329_create_message_channels_table', 6);
INSERT INTO `migrations` VALUES (160, '2023_12_03_090753_alter_message_table', 7);
INSERT INTO `migrations` VALUES (161, '2023_12_28_115249_create_notifications_table', 8);
INSERT INTO `migrations` VALUES (162, '2023_12_28_160933_alter_notification', 9);

-- ----------------------------
-- Table structure for notifications
-- ----------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `creator_id` bigint UNSIGNED NOT NULL,
  `task_id` bigint UNSIGNED NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `notifications_task_id_foreign`(`task_id` ASC) USING BTREE,
  CONSTRAINT `notifications_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of notifications
-- ----------------------------
INSERT INTO `notifications` VALUES (1, 1, 1, 'Đào Gia Bảo has finished task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2023-12-28 21:34:08', '2023-12-28 23:20:55');
INSERT INTO `notifications` VALUES (2, 1, 1, 'Đào Gia Bảo is re-doing task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2023-12-28 21:36:02', '2023-12-28 23:20:57');
INSERT INTO `notifications` VALUES (3, 2, 1, 'Đoàn Hải Bình is re-doing task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2023-12-28 21:38:10', '2023-12-28 23:21:00');
INSERT INTO `notifications` VALUES (4, 1, 1, 'Đào Gia Bảo has finished task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2023-12-28 22:36:19', '2023-12-28 23:21:01');
INSERT INTO `notifications` VALUES (5, 1, 2, 'Đào Gia Bảo has created task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2023-12-28 23:00:04', '2023-12-28 23:21:03');
INSERT INTO `notifications` VALUES (6, 1, 2, 'Đào Gia Bảo has updated task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2023-12-28 23:03:03', '2023-12-28 23:21:07');
INSERT INTO `notifications` VALUES (7, 2, 1, 'Đoàn Hải Bình has finished task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2023-12-28 23:37:07', NULL);
INSERT INTO `notifications` VALUES (8, 2, 2, 'Đoàn Hải Bình has finished task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2023-12-28 23:37:25', NULL);
INSERT INTO `notifications` VALUES (9, 2, 2, 'Đoàn Hải Bình is re-doing task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2023-12-28 23:47:36', NULL);
INSERT INTO `notifications` VALUES (10, 1, 1, 'Đào Gia Bảo is re-doing task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2023-12-28 23:47:53', NULL);
INSERT INTO `notifications` VALUES (11, 1, 1, 'Đào Gia Bảo has finished task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2023-12-28 23:53:08', NULL);
INSERT INTO `notifications` VALUES (12, 1, 1, 'Đào Gia Bảo is re-doing task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2023-12-28 23:54:24', NULL);
INSERT INTO `notifications` VALUES (13, 1, 1, 'Đào Gia Bảo has updated task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2023-12-28 23:55:33', NULL);
INSERT INTO `notifications` VALUES (14, 1, 1, 'Đào Gia Bảo has finished task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2023-12-28 23:55:41', NULL);
INSERT INTO `notifications` VALUES (15, 1, 1, 'Đào Gia Bảo is re-doing task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2023-12-28 23:57:49', NULL);
INSERT INTO `notifications` VALUES (16, 1, 1, 'Đào Gia Bảo has finished task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2023-12-28 23:58:20', NULL);
INSERT INTO `notifications` VALUES (17, 2, 2, 'Đoàn Hải Bình has finished task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2023-12-28 23:58:57', NULL);
INSERT INTO `notifications` VALUES (18, 2, 2, 'Đoàn Hải Bình is re-doing task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2023-12-28 23:59:58', NULL);
INSERT INTO `notifications` VALUES (19, 1, 3, 'Đào Gia Bảo has created task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2024-01-02 09:22:36', NULL);
INSERT INTO `notifications` VALUES (20, 1, 1, 'Đào Gia Bảo is re-doing task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2024-01-02 09:24:53', NULL);
INSERT INTO `notifications` VALUES (21, 1, 1, 'Đào Gia Bảo has finished task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2024-01-02 09:24:54', NULL);
INSERT INTO `notifications` VALUES (22, 1, 1, 'Đào Gia Bảo is re-doing task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2024-01-02 09:24:55', NULL);
INSERT INTO `notifications` VALUES (23, 1, 1, 'Đào Gia Bảo has finished task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2024-05-05 21:19:24', NULL);
INSERT INTO `notifications` VALUES (24, 1, 5, 'Đào Gia Bảo has created task', 'workspace/group/356a192b7913b04c54574d18c28d46e6395428ab', '2024-05-11 10:24:18', NULL);
INSERT INTO `notifications` VALUES (25, 115, 14, 'anonymous has created task', 'workspace/group/77de68daecd823babbb58edb1c8e14d7106e83bb', '2024-05-12 16:31:52', NULL);

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 65 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------
INSERT INTO `personal_access_tokens` VALUES (56, 'App\\Models\\User', 113, 'api_token', 'cbaab3d22e63b5c9b9b0daafd5ef9fed817f29fee9ce3cf012c845ef5db9bd23', '[\"*\"]', NULL, NULL, '2024-05-05 11:26:50', '2024-05-05 11:26:50');
INSERT INTO `personal_access_tokens` VALUES (64, 'App\\Models\\User', 1, 'api_token', 'e67e1ebe89dd3ad9789e437831e644054c0fc0e559d563489e0428ac7b3d49d0', '[\"*\"]', '2024-05-13 16:01:55', NULL, '2024-05-08 15:58:45', '2024-05-13 16:01:55');

-- ----------------------------
-- Table structure for task_attachments
-- ----------------------------
DROP TABLE IF EXISTS `task_attachments`;
CREATE TABLE `task_attachments`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `task_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `task_attachments_task_id_foreign`(`task_id` ASC) USING BTREE,
  CONSTRAINT `task_attachments_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of task_attachments
-- ----------------------------
INSERT INTO `task_attachments` VALUES (1, 1, 'jump-2040426_640', 'jpg', 'image/jpeg', 'storage/attachments/task/HsX4dTq3Cb5R4UmCJ6BJEQXOA0WIEkInGzir0d2i.jpg', '2023-12-12 23:46:36', NULL);
INSERT INTO `task_attachments` VALUES (2, 1, 'LICH THI K202122 HKI NH 2324_CT', 'xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'storage/attachments/task/ePEXpxcCWYMQ649uWxI3jrEItWCbonmIfQgpKCh0.xlsx', '2023-12-12 23:46:36', NULL);
INSERT INTO `task_attachments` VALUES (3, 3, 'Bài tập Chương 3', 'pdf', 'application/pdf', 'storage/attachments/task/YREfB0SAHUOMyKn15S6pYAVMzUQ436OtpRhrM8t0.pdf', '2024-01-02 09:22:36', NULL);
INSERT INTO `task_attachments` VALUES (5, 4, 'galaxy', 'jpg', 'image/jpeg', 'storage/attachments/task/H2kM6Czdh3wCiFOD11WqqZTXhPgYVShxCeuaf6P6.jpg', '2024-05-05 15:04:44', NULL);
INSERT INTO `task_attachments` VALUES (6, 5, '1000000034', 'jpg', 'image/*', 'storage/attachments/task/YKagjzoAi7mcg0qsfez4CL64CsPaQlSuahHSxBRW.jpg', '2024-05-11 10:24:18', NULL);
INSERT INTO `task_attachments` VALUES (7, 5, '1000000035', 'jpg', 'image/*', 'storage/attachments/task/cnUJt9QvT2gr7aGwqQlGxDALbYNy3eV2XZgCLmad.jpg', '2024-05-11 10:24:18', NULL);
INSERT INTO `task_attachments` VALUES (11, 6, '1000000034', 'jpg', 'image/*', 'storage/attachments/task/iDUaNOjpeZI4crTSPKxNhpbUeT68LYrEERob8ygN.jpg', '2024-05-12 09:32:06', NULL);

-- ----------------------------
-- Table structure for task_comments
-- ----------------------------
DROP TABLE IF EXISTS `task_comments`;
CREATE TABLE `task_comments`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `task_id` bigint UNSIGNED NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `task_comments_user_id_foreign`(`user_id` ASC) USING BTREE,
  INDEX `task_comments_task_id_foreign`(`task_id` ASC) USING BTREE,
  CONSTRAINT `task_comments_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `task_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of task_comments
-- ----------------------------
INSERT INTO `task_comments` VALUES (1, 1, 1, 'I have finished my task', '2023-12-12 23:48:50', NULL);
INSERT INTO `task_comments` VALUES (3, 1, 4, 'i have done my task, how about you? 😎', '2024-05-07 13:44:31', NULL);

-- ----------------------------
-- Table structure for task_members
-- ----------------------------
DROP TABLE IF EXISTS `task_members`;
CREATE TABLE `task_members`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `task_id` bigint UNSIGNED NOT NULL,
  `member_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `task_members_task_id_foreign`(`task_id` ASC) USING BTREE,
  INDEX `task_members_member_id_foreign`(`member_id` ASC) USING BTREE,
  CONSTRAINT `task_members_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `task_members_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of task_members
-- ----------------------------
INSERT INTO `task_members` VALUES (2, 1, 1, '2023-12-12 23:47:09', NULL);
INSERT INTO `task_members` VALUES (3, 2, 2, '2023-12-28 23:00:04', NULL);
INSERT INTO `task_members` VALUES (5, 3, 2, '2024-01-02 09:22:36', NULL);
INSERT INTO `task_members` VALUES (6, 4, 1, '2024-05-05 15:04:44', NULL);
INSERT INTO `task_members` VALUES (7, 5, 2, '2024-05-11 10:24:18', NULL);
INSERT INTO `task_members` VALUES (8, 5, 11, '2024-05-11 10:24:18', NULL);
INSERT INTO `task_members` VALUES (9, 5, 12, '2024-05-11 10:24:18', NULL);
INSERT INTO `task_members` VALUES (10, 5, 21, '2024-05-11 10:24:18', NULL);
INSERT INTO `task_members` VALUES (11, 6, 1, '2024-05-11 14:52:34', NULL);
INSERT INTO `task_members` VALUES (19, 1, 15, '2024-05-12 10:07:47', NULL);
INSERT INTO `task_members` VALUES (20, 1, 26, '2024-05-12 10:07:47', NULL);

-- ----------------------------
-- Table structure for task_operations
-- ----------------------------
DROP TABLE IF EXISTS `task_operations`;
CREATE TABLE `task_operations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `task_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `is_completed` tinyint(1) NULL DEFAULT NULL,
  `is_important` tinyint(1) NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `task_operations_task_id_foreign`(`task_id` ASC) USING BTREE,
  INDEX `task_operations_user_id_foreign`(`user_id` ASC) USING BTREE,
  CONSTRAINT `task_operations_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `task_operations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of task_operations
-- ----------------------------
INSERT INTO `task_operations` VALUES (2, 1, 1, NULL, NULL, '2023-12-12 23:47:09', '2024-05-12 16:49:56');
INSERT INTO `task_operations` VALUES (3, 2, 2, NULL, NULL, '2023-12-28 23:00:04', '2023-12-28 23:59:58');
INSERT INTO `task_operations` VALUES (5, 3, 2, NULL, NULL, '2024-01-02 09:22:36', NULL);
INSERT INTO `task_operations` VALUES (6, 4, 1, NULL, NULL, '2024-05-05 15:04:44', NULL);
INSERT INTO `task_operations` VALUES (7, 5, 2, NULL, NULL, '2024-05-11 10:24:18', NULL);
INSERT INTO `task_operations` VALUES (8, 5, 11, NULL, NULL, '2024-05-11 10:24:18', NULL);
INSERT INTO `task_operations` VALUES (9, 5, 12, NULL, NULL, '2024-05-11 10:24:18', NULL);
INSERT INTO `task_operations` VALUES (10, 5, 21, NULL, NULL, '2024-05-11 10:24:18', NULL);
INSERT INTO `task_operations` VALUES (11, 6, 1, NULL, 1, '2024-05-11 14:52:34', '2024-05-13 10:45:57');
INSERT INTO `task_operations` VALUES (19, 1, 15, NULL, NULL, '2024-05-12 10:07:47', NULL);
INSERT INTO `task_operations` VALUES (20, 1, 26, NULL, NULL, '2024-05-12 10:07:47', NULL);

-- ----------------------------
-- Table structure for tasks
-- ----------------------------
DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `creator_id` bigint UNSIGNED NOT NULL,
  `group_id` bigint UNSIGNED NULL DEFAULT NULL,
  `mode` tinyint NOT NULL DEFAULT 0 COMMENT '0:Public|1:Group|2:Private',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `end` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tasks_creator_id_foreign`(`creator_id` ASC) USING BTREE,
  INDEX `tasks_group_id_foreign`(`group_id` ASC) USING BTREE,
  CONSTRAINT `tasks_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tasks_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tasks
-- ----------------------------
INSERT INTO `tasks` VALUES (1, 1, 1, 1, 'Lorem ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at quam id libero accumsan convallis et in sem. Nullam vel ipsum et est lacinia aliquet ac ac leo. Donec pulvinar vestibulum ex vel laoreet. Nullam ullamcorper lectus nec est consectetur, eu convallis ipsum accumsan. Aenean scelerisque ipsum sit amet luctus convallis. In tristique nunc dapibus erat maximus accumsan. Suspendisse sagittis quis dui non varius. Aliquam erat volutpat. Pellentesque volutpat consequat diam sit amet venenatis. Proin quis dapibus nunc. Nam suscipit, nibh id consectetur porttitor, lacus turpis pulvinar eros, in pretium massa lorem ac felis. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam viverra magna quis molestie rhoncus.', '2023-12-12 23:47:00', '2023-12-14 15:48:00', '2023-12-12 23:46:36', '2024-05-12 10:07:47');
INSERT INTO `tasks` VALUES (2, 1, 1, 1, 'demo noti22', 'notinoti22', '2023-12-28 23:03:03', '2023-12-19 22:02:00', '2023-12-28 23:00:04', '2023-12-28 23:03:03');
INSERT INTO `tasks` VALUES (3, 1, 1, 1, 'title', 'diesfaewgf', '2024-01-11 09:23:00', '2024-01-24 09:24:00', '2024-01-02 09:22:36', NULL);
INSERT INTO `tasks` VALUES (4, 1, NULL, 2, 'Android app', 'this is descriptions', '2024-05-04 19:07:00', '2024-05-28 15:08:00', '2024-05-05 15:04:44', NULL);
INSERT INTO `tasks` VALUES (5, 1, 1, 0, 'hy', 'description', '2024-05-11 10:22:00', '2024-05-18 10:22:00', '2024-05-11 10:24:18', NULL);
INSERT INTO `tasks` VALUES (6, 1, NULL, 2, 'pickedUri(updated)', 'pickedUripickedUripickedUripickedUri (update)', '2024-05-16 09:29:00', '2024-05-22 14:50:00', '2024-05-11 14:52:34', '2024-05-12 09:32:06');
INSERT INTO `tasks` VALUES (14, 115, 3, 0, 'not your task ok', 'description', '2024-05-16 16:35:00', '2024-05-31 16:33:00', '2024-05-12 16:31:52', NULL);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `phone_number` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `birthday` date NULL DEFAULT NULL,
  `gender` tinyint NULL DEFAULT NULL COMMENT '0:male|1:female|2:other',
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'storage/avatars/default-user-avatar.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE,
  UNIQUE INDEX `users_phone_number_unique`(`phone_number` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 116 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Đào Gia Bảo 2', 'thisisbaomail@gmail.com', NULL, '$2y$12$KCZCJAPabCf50CyB3kaWBuUTIZMlHX7/h4GUNUWfg5bBauuhEdz16', 'owYhjcWacpkKhpMDMSdkL5AcuKLBJlgUiJhywn96uinYlj8HLoU6kZDz5vRL', '0969127111', '2024-05-13', 1, 'ohio', 'heelow', 'storage/avatars/3Suq2vEzzomxIj1Z11vGpx4ZtsIwwTOlb4Swdibj.jpg', '2023-11-18 15:10:57', '2024-05-13 10:43:10');
INSERT INTO `users` VALUES (2, 'Đoàn Hải Bình', 'blackgamerofficial123@gmail.com', NULL, '$2y$12$shnBs30EB57Gpu5270PhnOeH8xTMNxSmNwxh.cF8vnycvKGlZLRX2', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-21 01:51:23', '2023-11-24 22:49:19');
INSERT INTO `users` VALUES (3, 'Ms. Aliyah Wehner', 'schneider.vidal@beahan.com', NULL, '()Rx$+W!<\"Z{%', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:08:25', NULL);
INSERT INTO `users` VALUES (4, 'Dr. Virgil O\'Keefe DDS', 'reina40@gmail.com', NULL, '\'1V:mi\'', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:08:40', NULL);
INSERT INTO `users` VALUES (5, 'Bert Rath', 'cassin.sven@gulgowski.com', NULL, '+6Ljz0N?}', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:08:41', NULL);
INSERT INTO `users` VALUES (6, 'Ms. Laney Smith DVM', 'wullrich@yahoo.com', NULL, 'pNs\"\"o_(O+=LMI`$A)', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:08:42', NULL);
INSERT INTO `users` VALUES (7, 'Willy Luettgen', 'winston.bartell@towne.net', NULL, '<.XlT\'FG{t=)<:x{', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:08:43', NULL);
INSERT INTO `users` VALUES (8, 'Rene Torphy MD', 'selina.wehner@hyatt.net', NULL, 'c\"_0Uv&yg(de]]ulwp.', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:08:58', NULL);
INSERT INTO `users` VALUES (9, 'Annabel Lubowitz', 'parker.adriana@becker.org', NULL, 'ZmCe;3(`#;.NuIUe:`.', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:00', NULL);
INSERT INTO `users` VALUES (10, 'Rory Davis II', 'zkunze@haley.com', NULL, 'twZm0Ci2R/S', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:01', NULL);
INSERT INTO `users` VALUES (11, 'Haven Thiel Sr.', 'helene63@abshire.net', NULL, 'RdgXZ^TE!)YSsqM', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:27', NULL);
INSERT INTO `users` VALUES (12, 'Noble Boyle', 'ottis98@lynch.com', NULL, '+Uto&+', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:27', NULL);
INSERT INTO `users` VALUES (13, 'Abbie Zboncak', 'delbert81@tillman.biz', NULL, 'UVQjD)UM>7Zv<', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:27', NULL);
INSERT INTO `users` VALUES (14, 'Ottilie Eichmann', 'alyce.bayer@wolff.com', NULL, 'zNn5TmN62bK', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:27', NULL);
INSERT INTO `users` VALUES (15, 'Ona Brown', 'kayla.ortiz@moore.net', NULL, 'd;}6-yn/D', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:27', NULL);
INSERT INTO `users` VALUES (16, 'Christophe Pacocha Jr.', 'newton05@yahoo.com', NULL, 'G|WCw>\'pqr\'84T&H=', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:27', NULL);
INSERT INTO `users` VALUES (17, 'Bridie Weber', 'rgreenholt@donnelly.info', NULL, 'uO!SbxJzp', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:27', NULL);
INSERT INTO `users` VALUES (18, 'Felicity Bayer', 'kessler.aliza@gmail.com', NULL, 'kv5?c&lp8', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:27', NULL);
INSERT INTO `users` VALUES (19, 'Abbey Kovacek', 'ralph.abernathy@gmail.com', NULL, 'yhXEE.9F{uunZ%$DZ', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:27', NULL);
INSERT INTO `users` VALUES (20, 'Turner Little Jr.', 'trycia.cassin@schneider.com', NULL, 'hXUb?d8>d', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:27', NULL);
INSERT INTO `users` VALUES (21, 'Kylee Bogisich DDS', 'zhoeger@jast.info', NULL, 'qvhm{l4[V_^W', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (22, 'Florine Blick', 'eschaden@hotmail.com', NULL, '3@4-rpq;e', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (23, 'Janiya Russel', 'genoveva80@hotmail.com', NULL, '$iTp;tq(/', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (24, 'Marvin Stiedemann', 'cydney.crist@ortiz.com', NULL, 'SVU9q!O=\\T$1P3NXS', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (25, 'Prof. Alf D\'Amore', 'wschumm@collier.com', NULL, 'p/\"{5`r|I8tF', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (26, 'Miss Rosina Roob', 'myrna.collier@rempel.info', NULL, '@9V\'7D\'eWjcz}', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (27, 'Joaquin Heathcote', 'nellie.gutmann@brekke.com', NULL, 'lEM$;t', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (28, 'Georgiana O\'Hara', 'emard.blair@gottlieb.com', NULL, '($G^EW=Akzc+Wxt', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (29, 'Tatyana Waters', 'lucienne.barton@gottlieb.net', NULL, '\\oV#Kgn\')Zv3z>', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (30, 'Frieda Leannon', 'sydnie.bartell@yahoo.com', NULL, '*au>pHPb7^\\j*)6', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (31, 'Zena Murray', 'qstiedemann@gmail.com', NULL, '|m,@3\'*t1yR', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (32, 'Ona Kertzmann MD', 'robel.arianna@johnson.com', NULL, '`8:L1=8=D}(fyd;=b0^(', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (33, 'Patsy Kulas', 'rachelle.dibbert@gmail.com', NULL, '//exv~Vw0$5Ej-+7(', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (34, 'Cornell O\'Conner DDS', 'bnikolaus@yahoo.com', NULL, '<ySrlqU5[(ku', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (35, 'Miss Liza Schmeler', 'murphy.blaze@haley.org', NULL, 'w\":u\"^!8Ol6!i:+\\Jw$F', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (36, 'Javonte Lang', 'bfay@marvin.info', NULL, 'B!K]wr$18*KKb;jz~pY', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (37, 'Josue Conn', 'edna09@funk.com', NULL, 'hQrj@_vk$$C', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (38, 'Dr. Geoffrey Effertz', 'ondricka.dangelo@treutel.com', NULL, ')4`*fR2p}CzAn{^>', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (39, 'Sabryna Ryan', 'simonis.myrl@carroll.com', NULL, 'G&!5U)R2', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (40, 'Iliana Bednar', 'marcelina.quitzon@dickinson.biz', NULL, 'jT.1O\\$', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (41, 'Eliezer Hammes', 'kassulke.myrtie@haag.com', NULL, 'NL&Bmd<0c6Na)y~', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (42, 'Maximillian Jast', 'myrna.hamill@gmail.com', NULL, 'vC\'{/7C\"Sih0eSiP_V}{', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (43, 'Rosemarie Nitzsche', 'qabbott@larkin.com', NULL, '##/M|M(J_gd.)\"CBk', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (44, 'Genevieve Carroll', 'zetta67@hotmail.com', NULL, 'HlnIeef;9;', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (45, 'Mr. Casey Murray DDS', 'nmertz@brekke.com', NULL, 'h7UORA2!LzMjj*f`/8P8', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (46, 'Shaina Schmeler', 'everett91@gmail.com', NULL, 'JlQSChY&JFk3', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (47, 'Emmalee Breitenberg', 'augustine71@renner.com', NULL, '=o3Qq+\"', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (48, 'Prof. Torrance Lemke', 'layla.schamberger@champlin.com', NULL, '^tgEXfQzW{.m*aO?', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (49, 'Petra Pagac Jr.', 'savannah.hermann@runte.com', NULL, '[&fvi)\"l,_U*<b*+pD', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (50, 'Greg Nolan', 'quentin.stiedemann@yahoo.com', NULL, 'M\\aG|sa8$|_j', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (51, 'Rosalyn Shields', 'lavada69@gmail.com', NULL, 'KsW,H7t01.M@)IJ;Q', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (52, 'Abbigail Schneider', 'russel.runolfsdottir@hotmail.com', NULL, '\'h6|$,LoWt\\fsDN^', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (53, 'Madisen Maggio', 'dallas.ledner@murazik.info', NULL, '/ob?SIK~uNcv', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (54, 'Mr. Rosendo Hamill', 'fisher.howard@yahoo.com', NULL, 'l5-:7R\"L*R\\', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (55, 'Mack Okuneva', 'broderick55@cronin.info', NULL, 'xQU@s2\"U`|', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (56, 'Isaiah Adams', 'imcdermott@hotmail.com', NULL, '+1bFNZp5u38a>l1/A7', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (57, 'Yasmin Torp', 'marshall.muller@yahoo.com', NULL, 'GVxS{oh#tQc|+e', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (58, 'Prof. Kendra Pfeffer IV', 'orpha.goyette@mckenzie.com', NULL, 'n*:v9h]uzJ{E5r%EV', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (59, 'Ashlee Erdman', 'arch05@oconnell.com', NULL, 'F4<h\'>_+J', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (60, 'Lorenza Greenfelder', 'eschowalter@sawayn.info', NULL, 'FYds;#3', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (61, 'Dr. Charles O\'Connell III', 'kendra.farrell@hotmail.com', NULL, 'xo}\'b*c(bp~\'&a', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (62, 'Myra Hackett', 'lturner@leannon.net', NULL, '4`GvE/X%&0b#@0xZm:', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (63, 'Alexandrine Johnston I', 'tdaugherty@kozey.com', NULL, 'H2/^cq\'Yg*n5?HU', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (64, 'Kristy Torphy', 'elouise81@hessel.com', NULL, '\"{-Xa1RdnS<Ig#F=I9G', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (65, 'Quincy Kuhlman', 'glover.mortimer@smitham.com', NULL, 'O\"2;n%EF', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (66, 'Ms. Carissa Schroeder IV', 'will.shyanne@zboncak.com', NULL, 'JE\"S/]y>w~k}', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (67, 'Gage Purdy', 'nlubowitz@pollich.com', NULL, '=Y[?8X~T:Q7Mr:;l', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (68, 'Katherine Morar', 'lulu05@reilly.com', NULL, 'OiFJPdK', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (69, 'Dr. Corbin Ferry V', 'toconner@schumm.biz', NULL, 'VhE<KH<9q|', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (70, 'Adah McGlynn', 'ecarroll@gmail.com', NULL, 'gj\"pXm+Vs{,', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (71, 'Mrs. Esmeralda Schinner I', 'tkovacek@yahoo.com', NULL, '4k]4ptSlG:twpd^g', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (72, 'Miss Alysha Rau', 'prosacco.kaitlin@hotmail.com', NULL, '1h\",|T', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (73, 'Angelita Walter I', 'jocelyn13@waters.org', NULL, '$9Nf5p7gyxJBj:}|0', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (74, 'Mrs. Cali Wiza', 'tyrel88@hartmann.com', NULL, 'l1my5.', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (75, 'Omer Dach', 'kadin00@witting.com', NULL, '4U4F%d#e', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (76, 'Ansley Hartmann', 'wilfrid.keebler@zemlak.com', NULL, 'U\'13jt5v', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (77, 'Heidi Nitzsche', 'leanne37@mann.net', NULL, '2_4G&<L$r%e{w', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (78, 'Mrs. Rosalia Reinger', 'winston.beahan@yahoo.com', NULL, 'sP8/S\\!2W]', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (79, 'Brandt Bailey', 'deshawn.pacocha@bosco.com', NULL, 'XTf$YPUL#_/3[L}.', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (80, 'Mr. Marques Fisher', 'felicita.flatley@bradtke.com', NULL, 'H39yF5G', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (81, 'Dr. Elliot Cassin', 'eladio.hermiston@gmail.com', NULL, 'WaxK&!Cl]', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (82, 'Frida Dietrich DDS', 'lynn75@gmail.com', NULL, '[0{)X$~v\"|nAZk!', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (83, 'Rahul Williamson', 'ehuels@yahoo.com', NULL, 'n}AG1kd*', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (84, 'Bobbie Zemlak', 'wkilback@yahoo.com', NULL, '=Tmgbux%~VF|`Sj-', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (85, 'Mr. Carroll Bailey DDS', 'augustine.hodkiewicz@upton.com', NULL, 'EBy+|HM%', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (86, 'Harold Wunsch', 'zconsidine@bartell.biz', NULL, 'avr3bBI<]$o#', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (87, 'Desmond Walter', 'mchamplin@gmail.com', NULL, 'Wd/ew~', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (88, 'Tatyana Cummerata', 'anastasia.romaguera@thompson.com', NULL, 'H1g8w30W<nTPI\'o', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (89, 'Gertrude Grant IV', 'streich.reagan@breitenberg.com', NULL, 'jS\"].l', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (90, 'Mr. Davonte Legros', 'leopold.kerluke@hotmail.com', NULL, 'Xx:T+bw}F\"t', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (91, 'Oswaldo Ernser', 'adams.pietro@bailey.com', NULL, 'zR7QPEt)vs', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (92, 'Dr. Dedrick Williamson', 'tiana.kirlin@altenwerth.com', NULL, 'gu~\'m+9_rw&eqr*', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (93, 'Jacinthe Koss MD', 'corkery.alessandra@gmail.com', NULL, 'x`Q^]AJ%&R*Gb,3DZ', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (94, 'Alf Koelpin', 'herman.ramiro@cremin.com', NULL, '(b8zw$[', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (95, 'Irving Harber', 'jermain.zieme@yahoo.com', NULL, 'aDH{}yt!>\"\'lY3x', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (96, 'Matt McCullough III', 'luella.zboncak@gmail.com', NULL, 'eLZx_zY5fe\'E@', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (97, 'Joan Brown', 'ucollier@yahoo.com', NULL, 'J,AVhx_vO+z}48kO', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (98, 'Cameron Hegmann', 'eryn03@yahoo.com', NULL, 'k\'\"JUC', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (99, 'Oscar Beahan', 'ghuel@hotmail.com', NULL, 'pOCmiAl~@hzi', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (100, 'Mrs. Noelia White', 'grady.major@yahoo.com', NULL, 'FDmeaP*7elX*o?06~~_W', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2023-11-25 16:09:48', NULL);
INSERT INTO `users` VALUES (114, 'naruto', 'naruto@gmail.com', NULL, '$2y$12$kCQSx7EKH.h88iqzlC58.ufaDqCV4W0Smm7gmAO02H3/2ajVe5mk2', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2024-05-05 11:31:32', '2024-05-05 11:31:32');
INSERT INTO `users` VALUES (115, 'anonymous', 'baodg.22itb@vku.udn.vn', NULL, '$2y$12$EDPxXy6k3HB5csBfR.NbHuQk6A5OeRHVySDESjbIp8T6M8gkbSQbq', NULL, NULL, NULL, NULL, NULL, NULL, 'storage/avatars/default-user-avatar.png', '2024-05-11 16:19:42', '2024-05-12 16:31:11');

SET FOREIGN_KEY_CHECKS = 1;
