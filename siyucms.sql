/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : tp6

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 03/12/2021 14:10:56
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tp_ad
-- ----------------------------
DROP TABLE IF EXISTS `tp_ad`;
CREATE TABLE `tp_ad`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间	',
  `sort` mediumint(8) NULL DEFAULT 50 COMMENT '排序',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `type_id` int(8) NOT NULL DEFAULT 0 COMMENT '广告位',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '广告名称',
  `image` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `thumb` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '缩略图',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '链接地址',
  `description` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '广告列表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_ad
-- ----------------------------
INSERT INTO `tp_ad` VALUES (1, 1580378718, 1580378718, 1, 1, 1, 'banner_1 ', '/uploads/20181225/b671c6f234a72c2e6560c63ddd9dc0ff.jpg', '/uploads/20181225/b671c6f234a72c2e6560c63ddd9dc0ff.jpg', '', '免费、开源\n快速、简单');
INSERT INTO `tp_ad` VALUES (2, 1580378773, 1583585682, 2, 1, 1, 'banner_2', '/uploads/20181225/25670f5712b4acfb61c5d2a1bce79225.jpg', '/uploads/20181225/25670f5712b4acfb61c5d2a1bce79225.jpg', '', 'banner_2');

-- ----------------------------
-- Table structure for tp_ad_type
-- ----------------------------
DROP TABLE IF EXISTS `tp_ad_type`;
CREATE TABLE `tp_ad_type`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间	',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分组名称',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `sort` int(10) UNSIGNED NOT NULL DEFAULT 50 COMMENT '排序',
  `status` tinyint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '广告分组' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_ad_type
-- ----------------------------
INSERT INTO `tp_ad_type` VALUES (1, 1580372414, 1580372414, '【首页】顶部通栏', '导航下的焦点图', 1, 1);
INSERT INTO `tp_ad_type` VALUES (2, 1580372431, 1580372431, '【内页】顶部通栏', '内页顶部通栏', 2, 1);

-- ----------------------------
-- Table structure for tp_admin
-- ----------------------------
DROP TABLE IF EXISTS `tp_admin`;
CREATE TABLE `tp_admin`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `username` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '密码',
  `login_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '登录时间',
  `login_ip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '登录IP',
  `nickname` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '昵称',
  `image` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '头像',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '管理员列表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_admin
-- ----------------------------
INSERT INTO `tp_admin` VALUES (1, 1580695622, 1583672118, 1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1583748582, '127.0.0.1', 'admin', '/static/plugins/AdminLTE/dist/img/user2-160x160.jpg');
INSERT INTO `tp_admin` VALUES (2, 1583727997, 1583749457, 0, 'test', 'e10adc3949ba59abbe56e057f20f883e', 1583748408, '127.0.0.1', 'test', '/static/plugins/AdminLTE/dist/img/user2-160x160.jpg');

-- ----------------------------
-- Table structure for tp_admin_log
-- ----------------------------
DROP TABLE IF EXISTS `tp_admin_log`;
CREATE TABLE `tp_admin_log`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `admin_id` int(8) NOT NULL DEFAULT 0 COMMENT '管理员',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '操作页面	',
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '日志标题',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '日志内容',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '操作IP',
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'User-Agent',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '管理员日志' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_admin_log
-- ----------------------------

-- ----------------------------
-- Table structure for tp_area
-- ----------------------------
DROP TABLE IF EXISTS `tp_area`;
CREATE TABLE `tp_area`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `pid` int(11) NULL DEFAULT NULL COMMENT '父级id',
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '区划编码',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '区划名称',
  `level` tinyint(1) NULL DEFAULT NULL COMMENT '级次id 0:省/自治区/直辖市 1:市级 2:县级',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间	',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3221 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '区域模块' ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of tp_area
-- ----------------------------
INSERT INTO `tp_area` VALUES (1, 0, '110000', '北京', 0, 0, 0);
INSERT INTO `tp_area` VALUES (2, 3216, '110101', '东城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3, 3216, '110102', '西城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (4, 3216, '110105', '朝阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (5, 3216, '110106', '丰台区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (6, 3216, '110107', '石景山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (7, 3216, '110108', '海淀区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (8, 3216, '110109', '门头沟区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (9, 3216, '110111', '房山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (10, 3216, '110112', '通州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (11, 3216, '110113', '顺义区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (12, 3216, '110114', '昌平区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (13, 3216, '110115', '大兴区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (14, 3216, '110116', '怀柔区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (15, 3216, '110117', '平谷区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (16, 3216, '110118', '密云区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (17, 3216, '110119', '延庆区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (18, 0, '120000', '天津', 0, 0, 0);
INSERT INTO `tp_area` VALUES (19, 3217, '120101', '和平区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (20, 3217, '120102', '河东区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (21, 3217, '120103', '河西区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (22, 3217, '120104', '南开区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (23, 3217, '120105', '河北区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (24, 3217, '120106', '红桥区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (25, 3217, '120110', '东丽区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (26, 3217, '120111', '西青区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (27, 3217, '120112', '津南区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (28, 3217, '120113', '北辰区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (29, 3217, '120114', '武清区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (30, 3217, '120115', '宝坻区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (31, 3217, '120116', '滨海新区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (32, 3217, '120117', '宁河区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (33, 3217, '120118', '静海区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (34, 3217, '120119', '蓟州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (35, 0, '130000', '河北省', 0, 0, 0);
INSERT INTO `tp_area` VALUES (36, 35, '130100', '石家庄市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (37, 36, '130102', '长安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (38, 36, '130104', '桥西区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (39, 36, '130105', '新华区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (40, 36, '130107', '井陉矿区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (41, 36, '130108', '裕华区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (42, 36, '130109', '藁城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (43, 36, '130110', '鹿泉区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (44, 36, '130111', '栾城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (45, 36, '130121', '井陉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (46, 36, '130123', '正定县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (47, 36, '130125', '行唐县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (48, 36, '130126', '灵寿县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (49, 36, '130127', '高邑县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (50, 36, '130128', '深泽县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (51, 36, '130129', '赞皇县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (52, 36, '130130', '无极县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (53, 36, '130131', '平山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (54, 36, '130132', '元氏县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (55, 36, '130133', '赵县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (56, 36, '130181', '辛集市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (57, 36, '130183', '晋州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (58, 36, '130184', '新乐市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (59, 35, '130200', '唐山市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (60, 59, '130202', '路南区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (61, 59, '130203', '路北区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (62, 59, '130204', '古冶区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (63, 59, '130205', '开平区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (64, 59, '130207', '丰南区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (65, 59, '130208', '丰润区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (66, 59, '130209', '曹妃甸区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (67, 59, '130224', '滦南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (68, 59, '130225', '乐亭县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (69, 59, '130227', '迁西县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (70, 59, '130229', '玉田县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (71, 59, '130281', '遵化市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (72, 59, '130283', '迁安市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (73, 59, '130284', '滦州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (74, 35, '130300', '秦皇岛市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (75, 74, '130302', '海港区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (76, 74, '130303', '山海关区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (77, 74, '130304', '北戴河区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (78, 74, '130306', '抚宁区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (79, 74, '130321', '青龙满族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (80, 74, '130322', '昌黎县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (81, 74, '130324', '卢龙县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (82, 35, '130400', '邯郸市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (83, 82, '130402', '邯山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (84, 82, '130403', '丛台区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (85, 82, '130404', '复兴区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (86, 82, '130406', '峰峰矿区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (87, 82, '130407', '肥乡区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (88, 82, '130408', '永年区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (89, 82, '130423', '临漳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (90, 82, '130424', '成安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (91, 82, '130425', '大名县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (92, 82, '130426', '涉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (93, 82, '130427', '磁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (94, 82, '130430', '邱县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (95, 82, '130431', '鸡泽县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (96, 82, '130432', '广平县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (97, 82, '130433', '馆陶县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (98, 82, '130434', '魏县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (99, 82, '130435', '曲周县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (100, 82, '130481', '武安市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (101, 35, '130500', '邢台市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (102, 101, '130502', '桥东区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (103, 101, '130503', '桥西区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (104, 101, '130521', '邢台县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (105, 101, '130522', '临城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (106, 101, '130523', '内丘县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (107, 101, '130524', '柏乡县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (108, 101, '130525', '隆尧县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (109, 101, '130526', '任县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (110, 101, '130527', '南和县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (111, 101, '130528', '宁晋县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (112, 101, '130529', '巨鹿县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (113, 101, '130530', '新河县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (114, 101, '130531', '广宗县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (115, 101, '130532', '平乡县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (116, 101, '130533', '威县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (117, 101, '130534', '清河县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (118, 101, '130535', '临西县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (119, 101, '130581', '南宫市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (120, 101, '130582', '沙河市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (121, 35, '130600', '保定市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (122, 121, '130602', '竞秀区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (123, 121, '130606', '莲池区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (124, 121, '130607', '满城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (125, 121, '130608', '清苑区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (126, 121, '130609', '徐水区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (127, 121, '130623', '涞水县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (128, 121, '130624', '阜平县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (129, 121, '130626', '定兴县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (130, 121, '130627', '唐县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (131, 121, '130628', '高阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (132, 121, '130629', '容城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (133, 121, '130630', '涞源县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (134, 121, '130631', '望都县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (135, 121, '130632', '安新县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (136, 121, '130633', '易县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (137, 121, '130634', '曲阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (138, 121, '130635', '蠡县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (139, 121, '130636', '顺平县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (140, 121, '130637', '博野县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (141, 121, '130638', '雄县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (142, 121, '130681', '涿州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (143, 121, '130682', '定州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (144, 121, '130683', '安国市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (145, 121, '130684', '高碑店市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (146, 35, '130700', '张家口市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (147, 146, '130702', '桥东区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (148, 146, '130703', '桥西区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (149, 146, '130705', '宣化区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (150, 146, '130706', '下花园区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (151, 146, '130708', '万全区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (152, 146, '130709', '崇礼区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (153, 146, '130722', '张北县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (154, 146, '130723', '康保县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (155, 146, '130724', '沽源县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (156, 146, '130725', '尚义县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (157, 146, '130726', '蔚县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (158, 146, '130727', '阳原县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (159, 146, '130728', '怀安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (160, 146, '130730', '怀来县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (161, 146, '130731', '涿鹿县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (162, 146, '130732', '赤城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (163, 35, '130800', '承德市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (164, 163, '130802', '双桥区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (165, 163, '130803', '双滦区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (166, 163, '130804', '鹰手营子矿区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (167, 163, '130821', '承德县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (168, 163, '130822', '兴隆县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (169, 163, '130824', '滦平县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (170, 163, '130825', '隆化县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (171, 163, '130826', '丰宁满族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (172, 163, '130827', '宽城满族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (173, 163, '130828', '围场满族蒙古族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (174, 163, '130881', '平泉市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (175, 35, '130900', '沧州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (176, 175, '130902', '新华区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (177, 175, '130903', '运河区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (178, 175, '130921', '沧县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (179, 175, '130922', '青县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (180, 175, '130923', '东光县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (181, 175, '130924', '海兴县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (182, 175, '130925', '盐山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (183, 175, '130926', '肃宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (184, 175, '130927', '南皮县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (185, 175, '130928', '吴桥县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (186, 175, '130929', '献县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (187, 175, '130930', '孟村回族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (188, 175, '130981', '泊头市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (189, 175, '130982', '任丘市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (190, 175, '130983', '黄骅市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (191, 175, '130984', '河间市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (192, 35, '131000', '廊坊市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (193, 192, '131002', '安次区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (194, 192, '131003', '广阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (195, 192, '131022', '固安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (196, 192, '131023', '永清县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (197, 192, '131024', '香河县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (198, 192, '131025', '大城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (199, 192, '131026', '文安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (200, 192, '131028', '大厂回族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (201, 192, '131081', '霸州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (202, 192, '131082', '三河市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (203, 35, '131100', '衡水市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (204, 203, '131102', '桃城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (205, 203, '131103', '冀州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (206, 203, '131121', '枣强县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (207, 203, '131122', '武邑县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (208, 203, '131123', '武强县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (209, 203, '131124', '饶阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (210, 203, '131125', '安平县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (211, 203, '131126', '故城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (212, 203, '131127', '景县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (213, 203, '131128', '阜城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (214, 203, '131182', '深州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (215, 0, '140000', '山西省', 0, 0, 0);
INSERT INTO `tp_area` VALUES (216, 215, '140100', '太原市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (217, 216, '140105', '小店区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (218, 216, '140106', '迎泽区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (219, 216, '140107', '杏花岭区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (220, 216, '140108', '尖草坪区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (221, 216, '140109', '万柏林区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (222, 216, '140110', '晋源区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (223, 216, '140121', '清徐县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (224, 216, '140122', '阳曲县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (225, 216, '140123', '娄烦县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (226, 216, '140181', '古交市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (227, 215, '140200', '大同市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (228, 227, '140212', '新荣区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (229, 227, '140213', '平城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (230, 227, '140214', '云冈区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (231, 227, '140215', '云州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (232, 227, '140221', '阳高县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (233, 227, '140222', '天镇县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (234, 227, '140223', '广灵县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (235, 227, '140224', '灵丘县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (236, 227, '140225', '浑源县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (237, 227, '140226', '左云县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (238, 215, '140300', '阳泉市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (239, 238, '140302', '城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (240, 238, '140303', '矿区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (241, 238, '140311', '郊区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (242, 238, '140321', '平定县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (243, 238, '140322', '盂县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (244, 215, '140400', '长治市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (245, 244, '140403', '潞州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (246, 244, '140404', '上党区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (247, 244, '140405', '屯留区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (248, 244, '140406', '潞城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (249, 244, '140423', '襄垣县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (250, 244, '140425', '平顺县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (251, 244, '140426', '黎城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (252, 244, '140427', '壶关县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (253, 244, '140428', '长子县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (254, 244, '140429', '武乡县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (255, 244, '140430', '沁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (256, 244, '140431', '沁源县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (257, 215, '140500', '晋城市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (258, 257, '140502', '城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (259, 257, '140521', '沁水县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (260, 257, '140522', '阳城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (261, 257, '140524', '陵川县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (262, 257, '140525', '泽州县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (263, 257, '140581', '高平市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (264, 215, '140600', '朔州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (265, 264, '140602', '朔城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (266, 264, '140603', '平鲁区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (267, 264, '140621', '山阴县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (268, 264, '140622', '应县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (269, 264, '140623', '右玉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (270, 264, '140681', '怀仁市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (271, 215, '140700', '晋中市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (272, 271, '140702', '榆次区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (273, 271, '140703', '太谷区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (274, 271, '140721', '榆社县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (275, 271, '140722', '左权县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (276, 271, '140723', '和顺县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (277, 271, '140724', '昔阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (278, 271, '140725', '寿阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (279, 271, '140727', '祁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (280, 271, '140728', '平遥县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (281, 271, '140729', '灵石县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (282, 271, '140781', '介休市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (283, 215, '140800', '运城市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (284, 283, '140802', '盐湖区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (285, 283, '140821', '临猗县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (286, 283, '140822', '万荣县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (287, 283, '140823', '闻喜县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (288, 283, '140824', '稷山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (289, 283, '140825', '新绛县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (290, 283, '140826', '绛县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (291, 283, '140827', '垣曲县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (292, 283, '140828', '夏县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (293, 283, '140829', '平陆县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (294, 283, '140830', '芮城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (295, 283, '140881', '永济市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (296, 283, '140882', '河津市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (297, 215, '140900', '忻州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (298, 297, '140902', '忻府区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (299, 297, '140921', '定襄县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (300, 297, '140922', '五台县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (301, 297, '140923', '代县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (302, 297, '140924', '繁峙县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (303, 297, '140925', '宁武县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (304, 297, '140926', '静乐县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (305, 297, '140927', '神池县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (306, 297, '140928', '五寨县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (307, 297, '140929', '岢岚县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (308, 297, '140930', '河曲县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (309, 297, '140931', '保德县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (310, 297, '140932', '偏关县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (311, 297, '140981', '原平市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (312, 215, '141000', '临汾市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (313, 312, '141002', '尧都区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (314, 312, '141021', '曲沃县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (315, 312, '141022', '翼城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (316, 312, '141023', '襄汾县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (317, 312, '141024', '洪洞县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (318, 312, '141025', '古县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (319, 312, '141026', '安泽县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (320, 312, '141027', '浮山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (321, 312, '141028', '吉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (322, 312, '141029', '乡宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (323, 312, '141030', '大宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (324, 312, '141031', '隰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (325, 312, '141032', '永和县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (326, 312, '141033', '蒲县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (327, 312, '141034', '汾西县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (328, 312, '141081', '侯马市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (329, 312, '141082', '霍州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (330, 215, '141100', '吕梁市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (331, 330, '141102', '离石区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (332, 330, '141121', '文水县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (333, 330, '141122', '交城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (334, 330, '141123', '兴县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (335, 330, '141124', '临县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (336, 330, '141125', '柳林县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (337, 330, '141126', '石楼县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (338, 330, '141127', '岚县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (339, 330, '141128', '方山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (340, 330, '141129', '中阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (341, 330, '141130', '交口县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (342, 330, '141181', '孝义市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (343, 330, '141182', '汾阳市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (344, 0, '150000', '内蒙古自治区', 0, 0, 0);
INSERT INTO `tp_area` VALUES (345, 344, '150100', '呼和浩特市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (346, 345, '150102', '新城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (347, 345, '150103', '回民区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (348, 345, '150104', '玉泉区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (349, 345, '150105', '赛罕区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (350, 345, '150121', '土默特左旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (351, 345, '150122', '托克托县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (352, 345, '150123', '和林格尔县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (353, 345, '150124', '清水河县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (354, 345, '150125', '武川县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (355, 344, '150200', '包头市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (356, 355, '150202', '东河区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (357, 355, '150203', '昆都仑区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (358, 355, '150204', '青山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (359, 355, '150205', '石拐区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (360, 355, '150206', '白云鄂博矿区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (361, 355, '150207', '九原区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (362, 355, '150221', '土默特右旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (363, 355, '150222', '固阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (364, 355, '150223', '达尔罕茂明安联合旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (365, 344, '150300', '乌海市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (366, 365, '150302', '海勃湾区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (367, 365, '150303', '海南区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (368, 365, '150304', '乌达区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (369, 344, '150400', '赤峰市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (370, 369, '150402', '红山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (371, 369, '150403', '元宝山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (372, 369, '150404', '松山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (373, 369, '150421', '阿鲁科尔沁旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (374, 369, '150422', '巴林左旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (375, 369, '150423', '巴林右旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (376, 369, '150424', '林西县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (377, 369, '150425', '克什克腾旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (378, 369, '150426', '翁牛特旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (379, 369, '150428', '喀喇沁旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (380, 369, '150429', '宁城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (381, 369, '150430', '敖汉旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (382, 344, '150500', '通辽市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (383, 382, '150502', '科尔沁区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (384, 382, '150521', '科尔沁左翼中旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (385, 382, '150522', '科尔沁左翼后旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (386, 382, '150523', '开鲁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (387, 382, '150524', '库伦旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (388, 382, '150525', '奈曼旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (389, 382, '150526', '扎鲁特旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (390, 382, '150581', '霍林郭勒市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (391, 344, '150600', '鄂尔多斯市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (392, 391, '150602', '东胜区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (393, 391, '150603', '康巴什区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (394, 391, '150621', '达拉特旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (395, 391, '150622', '准格尔旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (396, 391, '150623', '鄂托克前旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (397, 391, '150624', '鄂托克旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (398, 391, '150625', '杭锦旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (399, 391, '150626', '乌审旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (400, 391, '150627', '伊金霍洛旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (401, 344, '150700', '呼伦贝尔市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (402, 401, '150702', '海拉尔区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (403, 401, '150703', '扎赉诺尔区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (404, 401, '150721', '阿荣旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (405, 401, '150722', '莫力达瓦达斡尔族自治旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (406, 401, '150723', '鄂伦春自治旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (407, 401, '150724', '鄂温克族自治旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (408, 401, '150725', '陈巴尔虎旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (409, 401, '150726', '新巴尔虎左旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (410, 401, '150727', '新巴尔虎右旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (411, 401, '150781', '满洲里市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (412, 401, '150782', '牙克石市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (413, 401, '150783', '扎兰屯市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (414, 401, '150784', '额尔古纳市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (415, 401, '150785', '根河市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (416, 344, '150800', '巴彦淖尔市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (417, 416, '150802', '临河区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (418, 416, '150821', '五原县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (419, 416, '150822', '磴口县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (420, 416, '150823', '乌拉特前旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (421, 416, '150824', '乌拉特中旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (422, 416, '150825', '乌拉特后旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (423, 416, '150826', '杭锦后旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (424, 344, '150900', '乌兰察布市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (425, 424, '150902', '集宁区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (426, 424, '150921', '卓资县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (427, 424, '150922', '化德县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (428, 424, '150923', '商都县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (429, 424, '150924', '兴和县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (430, 424, '150925', '凉城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (431, 424, '150926', '察哈尔右翼前旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (432, 424, '150927', '察哈尔右翼中旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (433, 424, '150928', '察哈尔右翼后旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (434, 424, '150929', '四子王旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (435, 424, '150981', '丰镇市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (436, 344, '152200', '兴安盟', 1, 0, 0);
INSERT INTO `tp_area` VALUES (437, 436, '152201', '乌兰浩特市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (438, 436, '152202', '阿尔山市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (439, 436, '152221', '科尔沁右翼前旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (440, 436, '152222', '科尔沁右翼中旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (441, 436, '152223', '扎赉特旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (442, 436, '152224', '突泉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (443, 344, '152500', '锡林郭勒盟', 1, 0, 0);
INSERT INTO `tp_area` VALUES (444, 443, '152501', '二连浩特市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (445, 443, '152502', '锡林浩特市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (446, 443, '152522', '阿巴嘎旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (447, 443, '152523', '苏尼特左旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (448, 443, '152524', '苏尼特右旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (449, 443, '152525', '东乌珠穆沁旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (450, 443, '152526', '西乌珠穆沁旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (451, 443, '152527', '太仆寺旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (452, 443, '152528', '镶黄旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (453, 443, '152529', '正镶白旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (454, 443, '152530', '正蓝旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (455, 443, '152531', '多伦县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (456, 344, '152900', '阿拉善盟', 1, 0, 0);
INSERT INTO `tp_area` VALUES (457, 456, '152921', '阿拉善左旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (458, 456, '152922', '阿拉善右旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (459, 456, '152923', '额济纳旗', 2, 0, 0);
INSERT INTO `tp_area` VALUES (460, 0, '210000', '辽宁省', 0, 0, 0);
INSERT INTO `tp_area` VALUES (461, 460, '210100', '沈阳市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (462, 461, '210102', '和平区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (463, 461, '210103', '沈河区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (464, 461, '210104', '大东区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (465, 461, '210105', '皇姑区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (466, 461, '210106', '铁西区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (467, 461, '210111', '苏家屯区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (468, 461, '210112', '浑南区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (469, 461, '210113', '沈北新区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (470, 461, '210114', '于洪区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (471, 461, '210115', '辽中区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (472, 461, '210123', '康平县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (473, 461, '210124', '法库县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (474, 461, '210181', '新民市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (475, 460, '210200', '大连市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (476, 475, '210202', '中山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (477, 475, '210203', '西岗区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (478, 475, '210204', '沙河口区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (479, 475, '210211', '甘井子区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (480, 475, '210212', '旅顺口区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (481, 475, '210213', '金州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (482, 475, '210214', '普兰店区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (483, 475, '210224', '长海县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (484, 475, '210281', '瓦房店市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (485, 475, '210283', '庄河市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (486, 460, '210300', '鞍山市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (487, 486, '210302', '铁东区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (488, 486, '210303', '铁西区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (489, 486, '210304', '立山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (490, 486, '210311', '千山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (491, 486, '210321', '台安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (492, 486, '210323', '岫岩满族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (493, 486, '210381', '海城市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (494, 460, '210400', '抚顺市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (495, 494, '210402', '新抚区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (496, 494, '210403', '东洲区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (497, 494, '210404', '望花区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (498, 494, '210411', '顺城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (499, 494, '210421', '抚顺县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (500, 494, '210422', '新宾满族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (501, 494, '210423', '清原满族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (502, 460, '210500', '本溪市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (503, 502, '210502', '平山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (504, 502, '210503', '溪湖区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (505, 502, '210504', '明山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (506, 502, '210505', '南芬区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (507, 502, '210521', '本溪满族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (508, 502, '210522', '桓仁满族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (509, 460, '210600', '丹东市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (510, 509, '210602', '元宝区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (511, 509, '210603', '振兴区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (512, 509, '210604', '振安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (513, 509, '210624', '宽甸满族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (514, 509, '210681', '东港市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (515, 509, '210682', '凤城市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (516, 460, '210700', '锦州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (517, 516, '210702', '古塔区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (518, 516, '210703', '凌河区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (519, 516, '210711', '太和区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (520, 516, '210726', '黑山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (521, 516, '210727', '义县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (522, 516, '210781', '凌海市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (523, 516, '210782', '北镇市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (524, 460, '210800', '营口市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (525, 524, '210802', '站前区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (526, 524, '210803', '西市区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (527, 524, '210804', '鲅鱼圈区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (528, 524, '210811', '老边区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (529, 524, '210881', '盖州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (530, 524, '210882', '大石桥市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (531, 460, '210900', '阜新市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (532, 531, '210902', '海州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (533, 531, '210903', '新邱区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (534, 531, '210904', '太平区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (535, 531, '210905', '清河门区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (536, 531, '210911', '细河区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (537, 531, '210921', '阜新蒙古族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (538, 531, '210922', '彰武县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (539, 460, '211000', '辽阳市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (540, 539, '211002', '白塔区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (541, 539, '211003', '文圣区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (542, 539, '211004', '宏伟区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (543, 539, '211005', '弓长岭区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (544, 539, '211011', '太子河区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (545, 539, '211021', '辽阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (546, 539, '211081', '灯塔市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (547, 460, '211100', '盘锦市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (548, 547, '211102', '双台子区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (549, 547, '211103', '兴隆台区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (550, 547, '211104', '大洼区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (551, 547, '211122', '盘山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (552, 460, '211200', '铁岭市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (553, 552, '211202', '银州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (554, 552, '211204', '清河区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (555, 552, '211221', '铁岭县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (556, 552, '211223', '西丰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (557, 552, '211224', '昌图县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (558, 552, '211281', '调兵山市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (559, 552, '211282', '开原市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (560, 460, '211300', '朝阳市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (561, 560, '211302', '双塔区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (562, 560, '211303', '龙城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (563, 560, '211321', '朝阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (564, 560, '211322', '建平县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (565, 560, '211324', '喀喇沁左翼蒙古族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (566, 560, '211381', '北票市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (567, 560, '211382', '凌源市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (568, 460, '211400', '葫芦岛市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (569, 568, '211402', '连山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (570, 568, '211403', '龙港区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (571, 568, '211404', '南票区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (572, 568, '211421', '绥中县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (573, 568, '211422', '建昌县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (574, 568, '211481', '兴城市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (575, 0, '220000', '吉林省', 0, 0, 0);
INSERT INTO `tp_area` VALUES (576, 575, '220100', '长春市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (577, 576, '220102', '南关区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (578, 576, '220103', '宽城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (579, 576, '220104', '朝阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (580, 576, '220105', '二道区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (581, 576, '220106', '绿园区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (582, 576, '220112', '双阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (583, 576, '220113', '九台区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (584, 576, '220122', '农安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (585, 576, '220182', '榆树市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (586, 576, '220183', '德惠市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (587, 575, '220200', '吉林市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (588, 587, '220202', '昌邑区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (589, 587, '220203', '龙潭区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (590, 587, '220204', '船营区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (591, 587, '220211', '丰满区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (592, 587, '220221', '永吉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (593, 587, '220281', '蛟河市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (594, 587, '220282', '桦甸市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (595, 587, '220283', '舒兰市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (596, 587, '220284', '磐石市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (597, 575, '220300', '四平市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (598, 597, '220302', '铁西区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (599, 597, '220303', '铁东区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (600, 597, '220322', '梨树县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (601, 597, '220323', '伊通满族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (602, 597, '220381', '公主岭市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (603, 597, '220382', '双辽市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (604, 575, '220400', '辽源市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (605, 604, '220402', '龙山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (606, 604, '220403', '西安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (607, 604, '220421', '东丰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (608, 604, '220422', '东辽县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (609, 575, '220500', '通化市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (610, 609, '220502', '东昌区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (611, 609, '220503', '二道江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (612, 609, '220521', '通化县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (613, 609, '220523', '辉南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (614, 609, '220524', '柳河县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (615, 609, '220581', '梅河口市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (616, 609, '220582', '集安市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (617, 575, '220600', '白山市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (618, 617, '220602', '浑江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (619, 617, '220605', '江源区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (620, 617, '220621', '抚松县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (621, 617, '220622', '靖宇县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (622, 617, '220623', '长白朝鲜族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (623, 617, '220681', '临江市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (624, 575, '220700', '松原市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (625, 624, '220702', '宁江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (626, 624, '220721', '前郭尔罗斯蒙古族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (627, 624, '220722', '长岭县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (628, 624, '220723', '乾安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (629, 624, '220781', '扶余市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (630, 575, '220800', '白城市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (631, 630, '220802', '洮北区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (632, 630, '220821', '镇赉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (633, 630, '220822', '通榆县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (634, 630, '220881', '洮南市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (635, 630, '220882', '大安市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (636, 575, '222400', '延边朝鲜族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (637, 636, '222401', '延吉市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (638, 636, '222402', '图们市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (639, 636, '222403', '敦化市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (640, 636, '222404', '珲春市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (641, 636, '222405', '龙井市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (642, 636, '222406', '和龙市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (643, 636, '222424', '汪清县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (644, 636, '222426', '安图县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (645, 0, '230000', '黑龙江省', 0, 0, 0);
INSERT INTO `tp_area` VALUES (646, 645, '230100', '哈尔滨市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (647, 646, '230102', '道里区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (648, 646, '230103', '南岗区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (649, 646, '230104', '道外区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (650, 646, '230108', '平房区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (651, 646, '230109', '松北区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (652, 646, '230110', '香坊区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (653, 646, '230111', '呼兰区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (654, 646, '230112', '阿城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (655, 646, '230113', '双城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (656, 646, '230123', '依兰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (657, 646, '230124', '方正县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (658, 646, '230125', '宾县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (659, 646, '230126', '巴彦县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (660, 646, '230127', '木兰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (661, 646, '230128', '通河县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (662, 646, '230129', '延寿县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (663, 646, '230183', '尚志市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (664, 646, '230184', '五常市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (665, 645, '230200', '齐齐哈尔市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (666, 665, '230202', '龙沙区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (667, 665, '230203', '建华区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (668, 665, '230204', '铁锋区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (669, 665, '230205', '昂昂溪区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (670, 665, '230206', '富拉尔基区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (671, 665, '230207', '碾子山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (672, 665, '230208', '梅里斯达斡尔族区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (673, 665, '230221', '龙江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (674, 665, '230223', '依安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (675, 665, '230224', '泰来县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (676, 665, '230225', '甘南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (677, 665, '230227', '富裕县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (678, 665, '230229', '克山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (679, 665, '230230', '克东县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (680, 665, '230231', '拜泉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (681, 665, '230281', '讷河市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (682, 645, '230300', '鸡西市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (683, 682, '230302', '鸡冠区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (684, 682, '230303', '恒山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (685, 682, '230304', '滴道区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (686, 682, '230305', '梨树区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (687, 682, '230306', '城子河区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (688, 682, '230307', '麻山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (689, 682, '230321', '鸡东县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (690, 682, '230381', '虎林市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (691, 682, '230382', '密山市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (692, 645, '230400', '鹤岗市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (693, 692, '230402', '向阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (694, 692, '230403', '工农区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (695, 692, '230404', '南山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (696, 692, '230405', '兴安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (697, 692, '230406', '东山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (698, 692, '230407', '兴山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (699, 692, '230421', '萝北县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (700, 692, '230422', '绥滨县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (701, 645, '230500', '双鸭山市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (702, 701, '230502', '尖山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (703, 701, '230503', '岭东区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (704, 701, '230505', '四方台区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (705, 701, '230506', '宝山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (706, 701, '230521', '集贤县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (707, 701, '230522', '友谊县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (708, 701, '230523', '宝清县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (709, 701, '230524', '饶河县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (710, 645, '230600', '大庆市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (711, 710, '230602', '萨尔图区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (712, 710, '230603', '龙凤区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (713, 710, '230604', '让胡路区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (714, 710, '230605', '红岗区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (715, 710, '230606', '大同区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (716, 710, '230621', '肇州县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (717, 710, '230622', '肇源县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (718, 710, '230623', '林甸县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (719, 710, '230624', '杜尔伯特蒙古族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (720, 645, '230700', '伊春市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (721, 720, '230717', '伊美区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (722, 720, '230718', '乌翠区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (723, 720, '230719', '友好区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (724, 720, '230722', '嘉荫县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (725, 720, '230723', '汤旺县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (726, 720, '230724', '丰林县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (727, 720, '230725', '大箐山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (728, 720, '230726', '南岔县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (729, 720, '230751', '金林区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (730, 720, '230781', '铁力市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (731, 645, '230800', '佳木斯市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (732, 731, '230803', '向阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (733, 731, '230804', '前进区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (734, 731, '230805', '东风区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (735, 731, '230811', '郊区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (736, 731, '230822', '桦南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (737, 731, '230826', '桦川县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (738, 731, '230828', '汤原县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (739, 731, '230881', '同江市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (740, 731, '230882', '富锦市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (741, 731, '230883', '抚远市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (742, 645, '230900', '七台河市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (743, 742, '230902', '新兴区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (744, 742, '230903', '桃山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (745, 742, '230904', '茄子河区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (746, 742, '230921', '勃利县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (747, 645, '231000', '牡丹江市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (748, 747, '231002', '东安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (749, 747, '231003', '阳明区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (750, 747, '231004', '爱民区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (751, 747, '231005', '西安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (752, 747, '231025', '林口县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (753, 747, '231081', '绥芬河市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (754, 747, '231083', '海林市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (755, 747, '231084', '宁安市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (756, 747, '231085', '穆棱市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (757, 747, '231086', '东宁市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (758, 645, '231100', '黑河市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (759, 758, '231102', '爱辉区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (760, 758, '231123', '逊克县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (761, 758, '231124', '孙吴县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (762, 758, '231181', '北安市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (763, 758, '231182', '五大连池市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (764, 758, '231183', '嫩江市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (765, 645, '231200', '绥化市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (766, 765, '231202', '北林区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (767, 765, '231221', '望奎县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (768, 765, '231222', '兰西县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (769, 765, '231223', '青冈县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (770, 765, '231224', '庆安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (771, 765, '231225', '明水县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (772, 765, '231226', '绥棱县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (773, 765, '231281', '安达市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (774, 765, '231282', '肇东市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (775, 765, '231283', '海伦市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (776, 645, '232700', '大兴安岭地区', 1, 0, 0);
INSERT INTO `tp_area` VALUES (777, 776, '232701', '漠河市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (778, 776, '232721', '呼玛县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (779, 776, '232722', '塔河县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (780, 0, '310000', '上海', 0, 0, 0);
INSERT INTO `tp_area` VALUES (781, 3218, '310101', '黄浦区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (782, 3218, '310104', '徐汇区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (783, 3218, '310105', '长宁区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (784, 3218, '310106', '静安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (785, 3218, '310107', '普陀区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (786, 3218, '310109', '虹口区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (787, 3218, '310110', '杨浦区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (788, 3218, '310112', '闵行区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (789, 3218, '310113', '宝山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (790, 3218, '310114', '嘉定区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (791, 3218, '310115', '浦东新区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (792, 3218, '310116', '金山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (793, 3218, '310117', '松江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (794, 3218, '310118', '青浦区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (795, 3218, '310120', '奉贤区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (796, 3218, '310151', '崇明区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (797, 0, '320000', '江苏省', 0, 0, 0);
INSERT INTO `tp_area` VALUES (798, 797, '320100', '南京市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (799, 798, '320102', '玄武区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (800, 798, '320104', '秦淮区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (801, 798, '320105', '建邺区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (802, 798, '320106', '鼓楼区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (803, 798, '320111', '浦口区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (804, 798, '320113', '栖霞区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (805, 798, '320114', '雨花台区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (806, 798, '320115', '江宁区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (807, 798, '320116', '六合区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (808, 798, '320117', '溧水区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (809, 798, '320118', '高淳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (810, 797, '320200', '无锡市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (811, 810, '320205', '锡山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (812, 810, '320206', '惠山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (813, 810, '320211', '滨湖区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (814, 810, '320213', '梁溪区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (815, 810, '320214', '新吴区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (816, 810, '320281', '江阴市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (817, 810, '320282', '宜兴市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (818, 797, '320300', '徐州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (819, 818, '320302', '鼓楼区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (820, 818, '320303', '云龙区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (821, 818, '320305', '贾汪区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (822, 818, '320311', '泉山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (823, 818, '320312', '铜山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (824, 818, '320321', '丰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (825, 818, '320322', '沛县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (826, 818, '320324', '睢宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (827, 818, '320381', '新沂市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (828, 818, '320382', '邳州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (829, 797, '320400', '常州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (830, 829, '320402', '天宁区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (831, 829, '320404', '钟楼区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (832, 829, '320411', '新北区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (833, 829, '320412', '武进区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (834, 829, '320413', '金坛区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (835, 829, '320481', '溧阳市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (836, 797, '320500', '苏州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (837, 836, '320505', '虎丘区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (838, 836, '320506', '吴中区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (839, 836, '320507', '相城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (840, 836, '320508', '姑苏区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (841, 836, '320509', '吴江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (842, 836, '320581', '常熟市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (843, 836, '320582', '张家港市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (844, 836, '320583', '昆山市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (845, 836, '320585', '太仓市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (846, 797, '320600', '南通市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (847, 846, '320602', '崇川区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (848, 846, '320611', '港闸区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (849, 846, '320612', '通州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (850, 846, '320623', '如东县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (851, 846, '320681', '启东市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (852, 846, '320682', '如皋市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (853, 846, '320684', '海门市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (854, 846, '320685', '海安市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (855, 797, '320700', '连云港市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (856, 855, '320703', '连云区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (857, 855, '320706', '海州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (858, 855, '320707', '赣榆区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (859, 855, '320722', '东海县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (860, 855, '320723', '灌云县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (861, 855, '320724', '灌南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (862, 797, '320800', '淮安市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (863, 862, '320803', '淮安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (864, 862, '320804', '淮阴区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (865, 862, '320812', '清江浦区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (866, 862, '320813', '洪泽区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (867, 862, '320826', '涟水县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (868, 862, '320830', '盱眙县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (869, 862, '320831', '金湖县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (870, 797, '320900', '盐城市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (871, 870, '320902', '亭湖区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (872, 870, '320903', '盐都区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (873, 870, '320904', '大丰区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (874, 870, '320921', '响水县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (875, 870, '320922', '滨海县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (876, 870, '320923', '阜宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (877, 870, '320924', '射阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (878, 870, '320925', '建湖县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (879, 870, '320981', '东台市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (880, 797, '321000', '扬州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (881, 880, '321002', '广陵区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (882, 880, '321003', '邗江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (883, 880, '321012', '江都区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (884, 880, '321023', '宝应县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (885, 880, '321081', '仪征市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (886, 880, '321084', '高邮市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (887, 797, '321100', '镇江市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (888, 887, '321102', '京口区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (889, 887, '321111', '润州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (890, 887, '321112', '丹徒区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (891, 887, '321181', '丹阳市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (892, 887, '321182', '扬中市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (893, 887, '321183', '句容市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (894, 797, '321200', '泰州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (895, 894, '321202', '海陵区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (896, 894, '321203', '高港区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (897, 894, '321204', '姜堰区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (898, 894, '321281', '兴化市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (899, 894, '321282', '靖江市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (900, 894, '321283', '泰兴市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (901, 797, '321300', '宿迁市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (902, 901, '321302', '宿城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (903, 901, '321311', '宿豫区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (904, 901, '321322', '沭阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (905, 901, '321323', '泗阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (906, 901, '321324', '泗洪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (907, 0, '330000', '浙江省', 0, 0, 0);
INSERT INTO `tp_area` VALUES (908, 907, '330100', '杭州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (909, 908, '330102', '上城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (910, 908, '330103', '下城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (911, 908, '330104', '江干区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (912, 908, '330105', '拱墅区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (913, 908, '330106', '西湖区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (914, 908, '330108', '滨江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (915, 908, '330109', '萧山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (916, 908, '330110', '余杭区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (917, 908, '330111', '富阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (918, 908, '330112', '临安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (919, 908, '330122', '桐庐县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (920, 908, '330127', '淳安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (921, 908, '330182', '建德市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (922, 907, '330200', '宁波市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (923, 922, '330203', '海曙区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (924, 922, '330205', '江北区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (925, 922, '330206', '北仑区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (926, 922, '330211', '镇海区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (927, 922, '330212', '鄞州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (928, 922, '330213', '奉化区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (929, 922, '330225', '象山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (930, 922, '330226', '宁海县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (931, 922, '330281', '余姚市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (932, 922, '330282', '慈溪市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (933, 907, '330300', '温州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (934, 933, '330302', '鹿城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (935, 933, '330303', '龙湾区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (936, 933, '330304', '瓯海区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (937, 933, '330305', '洞头区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (938, 933, '330324', '永嘉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (939, 933, '330326', '平阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (940, 933, '330327', '苍南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (941, 933, '330328', '文成县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (942, 933, '330329', '泰顺县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (943, 933, '330381', '瑞安市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (944, 933, '330382', '乐清市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (945, 933, '330383', '龙港市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (946, 907, '330400', '嘉兴市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (947, 946, '330402', '南湖区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (948, 946, '330411', '秀洲区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (949, 946, '330421', '嘉善县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (950, 946, '330424', '海盐县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (951, 946, '330481', '海宁市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (952, 946, '330482', '平湖市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (953, 946, '330483', '桐乡市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (954, 907, '330500', '湖州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (955, 954, '330502', '吴兴区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (956, 954, '330503', '南浔区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (957, 954, '330521', '德清县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (958, 954, '330522', '长兴县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (959, 954, '330523', '安吉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (960, 907, '330600', '绍兴市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (961, 960, '330602', '越城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (962, 960, '330603', '柯桥区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (963, 960, '330604', '上虞区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (964, 960, '330624', '新昌县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (965, 960, '330681', '诸暨市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (966, 960, '330683', '嵊州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (967, 907, '330700', '金华市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (968, 967, '330702', '婺城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (969, 967, '330703', '金东区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (970, 967, '330723', '武义县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (971, 967, '330726', '浦江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (972, 967, '330727', '磐安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (973, 967, '330781', '兰溪市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (974, 967, '330782', '义乌市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (975, 967, '330783', '东阳市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (976, 967, '330784', '永康市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (977, 907, '330800', '衢州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (978, 977, '330802', '柯城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (979, 977, '330803', '衢江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (980, 977, '330822', '常山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (981, 977, '330824', '开化县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (982, 977, '330825', '龙游县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (983, 977, '330881', '江山市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (984, 907, '330900', '舟山市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (985, 984, '330902', '定海区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (986, 984, '330903', '普陀区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (987, 984, '330921', '岱山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (988, 984, '330922', '嵊泗县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (989, 907, '331000', '台州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (990, 989, '331002', '椒江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (991, 989, '331003', '黄岩区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (992, 989, '331004', '路桥区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (993, 989, '331022', '三门县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (994, 989, '331023', '天台县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (995, 989, '331024', '仙居县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (996, 989, '331081', '温岭市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (997, 989, '331082', '临海市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (998, 989, '331083', '玉环市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (999, 907, '331100', '丽水市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1000, 999, '331102', '莲都区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1001, 999, '331121', '青田县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1002, 999, '331122', '缙云县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1003, 999, '331123', '遂昌县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1004, 999, '331124', '松阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1005, 999, '331125', '云和县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1006, 999, '331126', '庆元县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1007, 999, '331127', '景宁畲族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1008, 999, '331181', '龙泉市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1009, 0, '340000', '安徽省', 0, 0, 0);
INSERT INTO `tp_area` VALUES (1010, 1009, '340100', '合肥市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1011, 1010, '340102', '瑶海区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1012, 1010, '340103', '庐阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1013, 1010, '340104', '蜀山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1014, 1010, '340111', '包河区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1015, 1010, '340121', '长丰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1016, 1010, '340122', '肥东县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1017, 1010, '340123', '肥西县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1018, 1010, '340124', '庐江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1019, 1010, '340181', '巢湖市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1020, 1009, '340200', '芜湖市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1021, 1020, '340202', '镜湖区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1022, 1020, '340203', '弋江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1023, 1020, '340207', '鸠江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1024, 1020, '340208', '三山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1025, 1020, '340221', '芜湖县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1026, 1020, '340222', '繁昌县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1027, 1020, '340223', '南陵县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1028, 1020, '340281', '无为市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1029, 1009, '340300', '蚌埠市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1030, 1029, '340302', '龙子湖区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1031, 1029, '340303', '蚌山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1032, 1029, '340304', '禹会区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1033, 1029, '340311', '淮上区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1034, 1029, '340321', '怀远县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1035, 1029, '340322', '五河县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1036, 1029, '340323', '固镇县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1037, 1009, '340400', '淮南市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1038, 1037, '340402', '大通区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1039, 1037, '340403', '田家庵区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1040, 1037, '340404', '谢家集区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1041, 1037, '340405', '八公山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1042, 1037, '340406', '潘集区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1043, 1037, '340421', '凤台县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1044, 1037, '340422', '寿县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1045, 1009, '340500', '马鞍山市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1046, 1045, '340503', '花山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1047, 1045, '340504', '雨山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1048, 1045, '340506', '博望区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1049, 1045, '340521', '当涂县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1050, 1045, '340522', '含山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1051, 1045, '340523', '和县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1052, 1009, '340600', '淮北市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1053, 1052, '340602', '杜集区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1054, 1052, '340603', '相山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1055, 1052, '340604', '烈山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1056, 1052, '340621', '濉溪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1057, 1009, '340700', '铜陵市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1058, 1057, '340705', '铜官区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1059, 1057, '340706', '义安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1060, 1057, '340711', '郊区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1061, 1057, '340722', '枞阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1062, 1009, '340800', '安庆市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1063, 1062, '340802', '迎江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1064, 1062, '340803', '大观区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1065, 1062, '340811', '宜秀区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1066, 1062, '340822', '怀宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1067, 1062, '340825', '太湖县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1068, 1062, '340826', '宿松县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1069, 1062, '340827', '望江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1070, 1062, '340828', '岳西县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1071, 1062, '340881', '桐城市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1072, 1062, '340882', '潜山市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1073, 1009, '341000', '黄山市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1074, 1073, '341002', '屯溪区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1075, 1073, '341003', '黄山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1076, 1073, '341004', '徽州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1077, 1073, '341021', '歙县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1078, 1073, '341022', '休宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1079, 1073, '341023', '黟县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1080, 1073, '341024', '祁门县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1081, 1009, '341100', '滁州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1082, 1081, '341102', '琅琊区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1083, 1081, '341103', '南谯区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1084, 1081, '341122', '来安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1085, 1081, '341124', '全椒县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1086, 1081, '341125', '定远县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1087, 1081, '341126', '凤阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1088, 1081, '341181', '天长市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1089, 1081, '341182', '明光市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1090, 1009, '341200', '阜阳市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1091, 1090, '341202', '颍州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1092, 1090, '341203', '颍东区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1093, 1090, '341204', '颍泉区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1094, 1090, '341221', '临泉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1095, 1090, '341222', '太和县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1096, 1090, '341225', '阜南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1097, 1090, '341226', '颍上县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1098, 1090, '341282', '界首市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1099, 1009, '341300', '宿州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1100, 1099, '341302', '埇桥区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1101, 1099, '341321', '砀山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1102, 1099, '341322', '萧县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1103, 1099, '341323', '灵璧县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1104, 1099, '341324', '泗县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1105, 1009, '341500', '六安市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1106, 1105, '341502', '金安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1107, 1105, '341503', '裕安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1108, 1105, '341504', '叶集区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1109, 1105, '341522', '霍邱县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1110, 1105, '341523', '舒城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1111, 1105, '341524', '金寨县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1112, 1105, '341525', '霍山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1113, 1009, '341600', '亳州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1114, 1113, '341602', '谯城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1115, 1113, '341621', '涡阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1116, 1113, '341622', '蒙城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1117, 1113, '341623', '利辛县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1118, 1009, '341700', '池州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1119, 1118, '341702', '贵池区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1120, 1118, '341721', '东至县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1121, 1118, '341722', '石台县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1122, 1118, '341723', '青阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1123, 1009, '341800', '宣城市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1124, 1123, '341802', '宣州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1125, 1123, '341821', '郎溪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1126, 1123, '341823', '泾县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1127, 1123, '341824', '绩溪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1128, 1123, '341825', '旌德县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1129, 1123, '341881', '宁国市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1130, 1123, '341882', '广德市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1131, 0, '350000', '福建省', 0, 0, 0);
INSERT INTO `tp_area` VALUES (1132, 1131, '350100', '福州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1133, 1132, '350102', '鼓楼区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1134, 1132, '350103', '台江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1135, 1132, '350104', '仓山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1136, 1132, '350105', '马尾区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1137, 1132, '350111', '晋安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1138, 1132, '350112', '长乐区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1139, 1132, '350121', '闽侯县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1140, 1132, '350122', '连江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1141, 1132, '350123', '罗源县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1142, 1132, '350124', '闽清县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1143, 1132, '350125', '永泰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1144, 1132, '350128', '平潭县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1145, 1132, '350181', '福清市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1146, 1131, '350200', '厦门市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1147, 1146, '350203', '思明区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1148, 1146, '350205', '海沧区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1149, 1146, '350206', '湖里区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1150, 1146, '350211', '集美区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1151, 1146, '350212', '同安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1152, 1146, '350213', '翔安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1153, 1131, '350300', '莆田市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1154, 1153, '350302', '城厢区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1155, 1153, '350303', '涵江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1156, 1153, '350304', '荔城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1157, 1153, '350305', '秀屿区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1158, 1153, '350322', '仙游县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1159, 1131, '350400', '三明市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1160, 1159, '350402', '梅列区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1161, 1159, '350403', '三元区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1162, 1159, '350421', '明溪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1163, 1159, '350423', '清流县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1164, 1159, '350424', '宁化县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1165, 1159, '350425', '大田县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1166, 1159, '350426', '尤溪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1167, 1159, '350427', '沙县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1168, 1159, '350428', '将乐县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1169, 1159, '350429', '泰宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1170, 1159, '350430', '建宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1171, 1159, '350481', '永安市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1172, 1131, '350500', '泉州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1173, 1172, '350502', '鲤城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1174, 1172, '350503', '丰泽区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1175, 1172, '350504', '洛江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1176, 1172, '350505', '泉港区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1177, 1172, '350521', '惠安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1178, 1172, '350524', '安溪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1179, 1172, '350525', '永春县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1180, 1172, '350526', '德化县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1181, 1172, '350527', '金门县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1182, 1172, '350581', '石狮市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1183, 1172, '350582', '晋江市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1184, 1172, '350583', '南安市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1185, 1131, '350600', '漳州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1186, 1185, '350602', '芗城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1187, 1185, '350603', '龙文区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1188, 1185, '350622', '云霄县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1189, 1185, '350623', '漳浦县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1190, 1185, '350624', '诏安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1191, 1185, '350625', '长泰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1192, 1185, '350626', '东山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1193, 1185, '350627', '南靖县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1194, 1185, '350628', '平和县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1195, 1185, '350629', '华安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1196, 1185, '350681', '龙海市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1197, 1131, '350700', '南平市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1198, 1197, '350702', '延平区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1199, 1197, '350703', '建阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1200, 1197, '350721', '顺昌县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1201, 1197, '350722', '浦城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1202, 1197, '350723', '光泽县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1203, 1197, '350724', '松溪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1204, 1197, '350725', '政和县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1205, 1197, '350781', '邵武市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1206, 1197, '350782', '武夷山市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1207, 1197, '350783', '建瓯市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1208, 1131, '350800', '龙岩市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1209, 1208, '350802', '新罗区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1210, 1208, '350803', '永定区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1211, 1208, '350821', '长汀县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1212, 1208, '350823', '上杭县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1213, 1208, '350824', '武平县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1214, 1208, '350825', '连城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1215, 1208, '350881', '漳平市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1216, 1131, '350900', '宁德市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1217, 1216, '350902', '蕉城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1218, 1216, '350921', '霞浦县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1219, 1216, '350922', '古田县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1220, 1216, '350923', '屏南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1221, 1216, '350924', '寿宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1222, 1216, '350925', '周宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1223, 1216, '350926', '柘荣县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1224, 1216, '350981', '福安市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1225, 1216, '350982', '福鼎市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1226, 0, '360000', '江西省', 0, 0, 0);
INSERT INTO `tp_area` VALUES (1227, 1226, '360100', '南昌市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1228, 1227, '360102', '东湖区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1229, 1227, '360103', '西湖区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1230, 1227, '360104', '青云谱区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1231, 1227, '360111', '青山湖区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1232, 1227, '360112', '新建区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1233, 1227, '360113', '红谷滩区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1234, 1227, '360121', '南昌县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1235, 1227, '360123', '安义县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1236, 1227, '360124', '进贤县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1237, 1226, '360200', '景德镇市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1238, 1237, '360202', '昌江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1239, 1237, '360203', '珠山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1240, 1237, '360222', '浮梁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1241, 1237, '360281', '乐平市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1242, 1226, '360300', '萍乡市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1243, 1242, '360302', '安源区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1244, 1242, '360313', '湘东区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1245, 1242, '360321', '莲花县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1246, 1242, '360322', '上栗县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1247, 1242, '360323', '芦溪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1248, 1226, '360400', '九江市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1249, 1248, '360402', '濂溪区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1250, 1248, '360403', '浔阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1251, 1248, '360404', '柴桑区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1252, 1248, '360423', '武宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1253, 1248, '360424', '修水县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1254, 1248, '360425', '永修县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1255, 1248, '360426', '德安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1256, 1248, '360428', '都昌县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1257, 1248, '360429', '湖口县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1258, 1248, '360430', '彭泽县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1259, 1248, '360481', '瑞昌市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1260, 1248, '360482', '共青城市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1261, 1248, '360483', '庐山市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1262, 1226, '360500', '新余市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1263, 1262, '360502', '渝水区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1264, 1262, '360521', '分宜县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1265, 1226, '360600', '鹰潭市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1266, 1265, '360602', '月湖区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1267, 1265, '360603', '余江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1268, 1265, '360681', '贵溪市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1269, 1226, '360700', '赣州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1270, 1269, '360702', '章贡区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1271, 1269, '360703', '南康区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1272, 1269, '360704', '赣县区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1273, 1269, '360722', '信丰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1274, 1269, '360723', '大余县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1275, 1269, '360724', '上犹县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1276, 1269, '360725', '崇义县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1277, 1269, '360726', '安远县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1278, 1269, '360727', '龙南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1279, 1269, '360728', '定南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1280, 1269, '360729', '全南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1281, 1269, '360730', '宁都县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1282, 1269, '360731', '于都县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1283, 1269, '360732', '兴国县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1284, 1269, '360733', '会昌县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1285, 1269, '360734', '寻乌县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1286, 1269, '360735', '石城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1287, 1269, '360781', '瑞金市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1288, 1226, '360800', '吉安市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1289, 1288, '360802', '吉州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1290, 1288, '360803', '青原区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1291, 1288, '360821', '吉安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1292, 1288, '360822', '吉水县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1293, 1288, '360823', '峡江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1294, 1288, '360824', '新干县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1295, 1288, '360825', '永丰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1296, 1288, '360826', '泰和县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1297, 1288, '360827', '遂川县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1298, 1288, '360828', '万安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1299, 1288, '360829', '安福县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1300, 1288, '360830', '永新县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1301, 1288, '360881', '井冈山市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1302, 1226, '360900', '宜春市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1303, 1302, '360902', '袁州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1304, 1302, '360921', '奉新县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1305, 1302, '360922', '万载县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1306, 1302, '360923', '上高县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1307, 1302, '360924', '宜丰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1308, 1302, '360925', '靖安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1309, 1302, '360926', '铜鼓县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1310, 1302, '360981', '丰城市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1311, 1302, '360982', '樟树市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1312, 1302, '360983', '高安市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1313, 1226, '361000', '抚州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1314, 1313, '361002', '临川区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1315, 1313, '361003', '东乡区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1316, 1313, '361021', '南城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1317, 1313, '361022', '黎川县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1318, 1313, '361023', '南丰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1319, 1313, '361024', '崇仁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1320, 1313, '361025', '乐安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1321, 1313, '361026', '宜黄县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1322, 1313, '361027', '金溪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1323, 1313, '361028', '资溪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1324, 1313, '361030', '广昌县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1325, 1226, '361100', '上饶市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1326, 1325, '361102', '信州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1327, 1325, '361103', '广丰区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1328, 1325, '361104', '广信区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1329, 1325, '361123', '玉山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1330, 1325, '361124', '铅山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1331, 1325, '361125', '横峰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1332, 1325, '361126', '弋阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1333, 1325, '361127', '余干县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1334, 1325, '361128', '鄱阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1335, 1325, '361129', '万年县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1336, 1325, '361130', '婺源县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1337, 1325, '361181', '德兴市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1338, 0, '370000', '山东省', 0, 0, 0);
INSERT INTO `tp_area` VALUES (1339, 1338, '370100', '济南市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1340, 1339, '370102', '历下区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1341, 1339, '370103', '市中区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1342, 1339, '370104', '槐荫区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1343, 1339, '370105', '天桥区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1344, 1339, '370112', '历城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1345, 1339, '370113', '长清区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1346, 1339, '370114', '章丘区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1347, 1339, '370115', '济阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1348, 1339, '370116', '莱芜区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1349, 1339, '370117', '钢城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1350, 1339, '370124', '平阴县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1351, 1339, '370126', '商河县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1352, 1338, '370200', '青岛市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1353, 1352, '370202', '市南区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1354, 1352, '370203', '市北区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1355, 1352, '370211', '黄岛区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1356, 1352, '370212', '崂山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1357, 1352, '370213', '李沧区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1358, 1352, '370214', '城阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1359, 1352, '370215', '即墨区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1360, 1352, '370281', '胶州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1361, 1352, '370283', '平度市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1362, 1352, '370285', '莱西市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1363, 1338, '370300', '淄博市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1364, 1363, '370302', '淄川区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1365, 1363, '370303', '张店区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1366, 1363, '370304', '博山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1367, 1363, '370305', '临淄区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1368, 1363, '370306', '周村区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1369, 1363, '370321', '桓台县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1370, 1363, '370322', '高青县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1371, 1363, '370323', '沂源县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1372, 1338, '370400', '枣庄市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1373, 1372, '370402', '市中区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1374, 1372, '370403', '薛城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1375, 1372, '370404', '峄城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1376, 1372, '370405', '台儿庄区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1377, 1372, '370406', '山亭区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1378, 1372, '370481', '滕州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1379, 1338, '370500', '东营市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1380, 1379, '370502', '东营区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1381, 1379, '370503', '河口区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1382, 1379, '370505', '垦利区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1383, 1379, '370522', '利津县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1384, 1379, '370523', '广饶县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1385, 1338, '370600', '烟台市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1386, 1385, '370602', '芝罘区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1387, 1385, '370611', '福山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1388, 1385, '370612', '牟平区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1389, 1385, '370613', '莱山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1390, 1385, '370634', '长岛县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1391, 1385, '370681', '龙口市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1392, 1385, '370682', '莱阳市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1393, 1385, '370683', '莱州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1394, 1385, '370684', '蓬莱市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1395, 1385, '370685', '招远市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1396, 1385, '370686', '栖霞市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1397, 1385, '370687', '海阳市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1398, 1338, '370700', '潍坊市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1399, 1398, '370702', '潍城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1400, 1398, '370703', '寒亭区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1401, 1398, '370704', '坊子区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1402, 1398, '370705', '奎文区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1403, 1398, '370724', '临朐县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1404, 1398, '370725', '昌乐县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1405, 1398, '370781', '青州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1406, 1398, '370782', '诸城市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1407, 1398, '370783', '寿光市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1408, 1398, '370784', '安丘市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1409, 1398, '370785', '高密市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1410, 1398, '370786', '昌邑市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1411, 1338, '370800', '济宁市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1412, 1411, '370811', '任城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1413, 1411, '370812', '兖州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1414, 1411, '370826', '微山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1415, 1411, '370827', '鱼台县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1416, 1411, '370828', '金乡县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1417, 1411, '370829', '嘉祥县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1418, 1411, '370830', '汶上县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1419, 1411, '370831', '泗水县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1420, 1411, '370832', '梁山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1421, 1411, '370881', '曲阜市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1422, 1411, '370883', '邹城市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1423, 1338, '370900', '泰安市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1424, 1423, '370902', '泰山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1425, 1423, '370911', '岱岳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1426, 1423, '370921', '宁阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1427, 1423, '370923', '东平县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1428, 1423, '370982', '新泰市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1429, 1423, '370983', '肥城市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1430, 1338, '371000', '威海市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1431, 1430, '371002', '环翠区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1432, 1430, '371003', '文登区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1433, 1430, '371082', '荣成市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1434, 1430, '371083', '乳山市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1435, 1338, '371100', '日照市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1436, 1435, '371102', '东港区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1437, 1435, '371103', '岚山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1438, 1435, '371121', '五莲县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1439, 1435, '371122', '莒县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1440, 1338, '371300', '临沂市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1441, 1440, '371302', '兰山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1442, 1440, '371311', '罗庄区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1443, 1440, '371312', '河东区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1444, 1440, '371321', '沂南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1445, 1440, '371322', '郯城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1446, 1440, '371323', '沂水县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1447, 1440, '371324', '兰陵县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1448, 1440, '371325', '费县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1449, 1440, '371326', '平邑县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1450, 1440, '371327', '莒南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1451, 1440, '371328', '蒙阴县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1452, 1440, '371329', '临沭县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1453, 1338, '371400', '德州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1454, 1453, '371402', '德城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1455, 1453, '371403', '陵城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1456, 1453, '371422', '宁津县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1457, 1453, '371423', '庆云县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1458, 1453, '371424', '临邑县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1459, 1453, '371425', '齐河县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1460, 1453, '371426', '平原县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1461, 1453, '371427', '夏津县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1462, 1453, '371428', '武城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1463, 1453, '371481', '乐陵市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1464, 1453, '371482', '禹城市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1465, 1338, '371500', '聊城市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1466, 1465, '371502', '东昌府区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1467, 1465, '371503', '茌平区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1468, 1465, '371521', '阳谷县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1469, 1465, '371522', '莘县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1470, 1465, '371524', '东阿县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1471, 1465, '371525', '冠县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1472, 1465, '371526', '高唐县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1473, 1465, '371581', '临清市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1474, 1338, '371600', '滨州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1475, 1474, '371602', '滨城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1476, 1474, '371603', '沾化区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1477, 1474, '371621', '惠民县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1478, 1474, '371622', '阳信县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1479, 1474, '371623', '无棣县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1480, 1474, '371625', '博兴县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1481, 1474, '371681', '邹平市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1482, 1338, '371700', '菏泽市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1483, 1482, '371702', '牡丹区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1484, 1482, '371703', '定陶区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1485, 1482, '371721', '曹县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1486, 1482, '371722', '单县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1487, 1482, '371723', '成武县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1488, 1482, '371724', '巨野县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1489, 1482, '371725', '郓城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1490, 1482, '371726', '鄄城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1491, 1482, '371728', '东明县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1492, 0, '410000', '河南省', 0, 0, 0);
INSERT INTO `tp_area` VALUES (1493, 1492, '410100', '郑州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1494, 1493, '410102', '中原区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1495, 1493, '410103', '二七区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1496, 1493, '410104', '管城回族区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1497, 1493, '410105', '金水区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1498, 1493, '410106', '上街区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1499, 1493, '410108', '惠济区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1500, 1493, '410122', '中牟县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1501, 1493, '410181', '巩义市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1502, 1493, '410182', '荥阳市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1503, 1493, '410183', '新密市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1504, 1493, '410184', '新郑市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1505, 1493, '410185', '登封市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1506, 1492, '410200', '开封市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1507, 1506, '410202', '龙亭区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1508, 1506, '410203', '顺河回族区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1509, 1506, '410204', '鼓楼区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1510, 1506, '410205', '禹王台区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1511, 1506, '410212', '祥符区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1512, 1506, '410221', '杞县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1513, 1506, '410222', '通许县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1514, 1506, '410223', '尉氏县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1515, 1506, '410225', '兰考县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1516, 1492, '410300', '洛阳市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1517, 1516, '410302', '老城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1518, 1516, '410303', '西工区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1519, 1516, '410304', '瀍河回族区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1520, 1516, '410305', '涧西区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1521, 1516, '410306', '吉利区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1522, 1516, '410311', '洛龙区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1523, 1516, '410322', '孟津县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1524, 1516, '410323', '新安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1525, 1516, '410324', '栾川县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1526, 1516, '410325', '嵩县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1527, 1516, '410326', '汝阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1528, 1516, '410327', '宜阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1529, 1516, '410328', '洛宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1530, 1516, '410329', '伊川县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1531, 1516, '410381', '偃师市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1532, 1492, '410400', '平顶山市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1533, 1532, '410402', '新华区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1534, 1532, '410403', '卫东区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1535, 1532, '410404', '石龙区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1536, 1532, '410411', '湛河区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1537, 1532, '410421', '宝丰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1538, 1532, '410422', '叶县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1539, 1532, '410423', '鲁山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1540, 1532, '410425', '郏县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1541, 1532, '410481', '舞钢市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1542, 1532, '410482', '汝州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1543, 1492, '410500', '安阳市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1544, 1543, '410502', '文峰区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1545, 1543, '410503', '北关区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1546, 1543, '410505', '殷都区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1547, 1543, '410506', '龙安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1548, 1543, '410522', '安阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1549, 1543, '410523', '汤阴县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1550, 1543, '410526', '滑县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1551, 1543, '410527', '内黄县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1552, 1543, '410581', '林州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1553, 1492, '410600', '鹤壁市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1554, 1553, '410602', '鹤山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1555, 1553, '410603', '山城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1556, 1553, '410611', '淇滨区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1557, 1553, '410621', '浚县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1558, 1553, '410622', '淇县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1559, 1492, '410700', '新乡市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1560, 1559, '410702', '红旗区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1561, 1559, '410703', '卫滨区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1562, 1559, '410704', '凤泉区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1563, 1559, '410711', '牧野区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1564, 1559, '410721', '新乡县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1565, 1559, '410724', '获嘉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1566, 1559, '410725', '原阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1567, 1559, '410726', '延津县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1568, 1559, '410727', '封丘县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1569, 1559, '410781', '卫辉市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1570, 1559, '410782', '辉县市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1571, 1559, '410783', '长垣市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1572, 1492, '410800', '焦作市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1573, 1572, '410802', '解放区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1574, 1572, '410803', '中站区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1575, 1572, '410804', '马村区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1576, 1572, '410811', '山阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1577, 1572, '410821', '修武县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1578, 1572, '410822', '博爱县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1579, 1572, '410823', '武陟县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1580, 1572, '410825', '温县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1581, 1572, '410882', '沁阳市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1582, 1572, '410883', '孟州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1583, 1492, '410900', '濮阳市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1584, 1583, '410902', '华龙区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1585, 1583, '410922', '清丰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1586, 1583, '410923', '南乐县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1587, 1583, '410926', '范县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1588, 1583, '410927', '台前县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1589, 1583, '410928', '濮阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1590, 1492, '411000', '许昌市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1591, 1590, '411002', '魏都区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1592, 1590, '411003', '建安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1593, 1590, '411024', '鄢陵县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1594, 1590, '411025', '襄城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1595, 1590, '411081', '禹州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1596, 1590, '411082', '长葛市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1597, 1492, '411100', '漯河市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1598, 1597, '411102', '源汇区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1599, 1597, '411103', '郾城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1600, 1597, '411104', '召陵区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1601, 1597, '411121', '舞阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1602, 1597, '411122', '临颍县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1603, 1492, '411200', '三门峡市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1604, 1603, '411202', '湖滨区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1605, 1603, '411203', '陕州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1606, 1603, '411221', '渑池县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1607, 1603, '411224', '卢氏县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1608, 1603, '411281', '义马市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1609, 1603, '411282', '灵宝市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1610, 1492, '411300', '南阳市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1611, 1610, '411302', '宛城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1612, 1610, '411303', '卧龙区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1613, 1610, '411321', '南召县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1614, 1610, '411322', '方城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1615, 1610, '411323', '西峡县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1616, 1610, '411324', '镇平县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1617, 1610, '411325', '内乡县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1618, 1610, '411326', '淅川县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1619, 1610, '411327', '社旗县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1620, 1610, '411328', '唐河县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1621, 1610, '411329', '新野县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1622, 1610, '411330', '桐柏县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1623, 1610, '411381', '邓州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1624, 1492, '411400', '商丘市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1625, 1624, '411402', '梁园区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1626, 1624, '411403', '睢阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1627, 1624, '411421', '民权县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1628, 1624, '411422', '睢县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1629, 1624, '411423', '宁陵县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1630, 1624, '411424', '柘城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1631, 1624, '411425', '虞城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1632, 1624, '411426', '夏邑县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1633, 1624, '411481', '永城市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1634, 1492, '411500', '信阳市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1635, 1634, '411502', '浉河区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1636, 1634, '411503', '平桥区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1637, 1634, '411521', '罗山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1638, 1634, '411522', '光山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1639, 1634, '411523', '新县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1640, 1634, '411524', '商城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1641, 1634, '411525', '固始县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1642, 1634, '411526', '潢川县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1643, 1634, '411527', '淮滨县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1644, 1634, '411528', '息县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1645, 1492, '411600', '周口市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1646, 1645, '411602', '川汇区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1647, 1645, '411603', '淮阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1648, 1645, '411621', '扶沟县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1649, 1645, '411622', '西华县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1650, 1645, '411623', '商水县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1651, 1645, '411624', '沈丘县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1652, 1645, '411625', '郸城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1653, 1645, '411627', '太康县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1654, 1645, '411628', '鹿邑县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1655, 1645, '411681', '项城市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1656, 1492, '411700', '驻马店市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1657, 1656, '411702', '驿城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1658, 1656, '411721', '西平县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1659, 1656, '411722', '上蔡县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1660, 1656, '411723', '平舆县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1661, 1656, '411724', '正阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1662, 1656, '411725', '确山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1663, 1656, '411726', '泌阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1664, 1656, '411727', '汝南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1665, 1656, '411728', '遂平县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1666, 1656, '411729', '新蔡县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1667, 1492, '419001', '济源市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1668, 0, '420000', '湖北省', 0, 0, 0);
INSERT INTO `tp_area` VALUES (1669, 1668, '420100', '武汉市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1670, 1669, '420102', '江岸区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1671, 1669, '420103', '江汉区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1672, 1669, '420104', '硚口区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1673, 1669, '420105', '汉阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1674, 1669, '420106', '武昌区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1675, 1669, '420107', '青山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1676, 1669, '420111', '洪山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1677, 1669, '420112', '东西湖区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1678, 1669, '420113', '汉南区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1679, 1669, '420114', '蔡甸区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1680, 1669, '420115', '江夏区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1681, 1669, '420116', '黄陂区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1682, 1669, '420117', '新洲区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1683, 1668, '420200', '黄石市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1684, 1683, '420202', '黄石港区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1685, 1683, '420203', '西塞山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1686, 1683, '420204', '下陆区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1687, 1683, '420205', '铁山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1688, 1683, '420222', '阳新县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1689, 1683, '420281', '大冶市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1690, 1668, '420300', '十堰市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1691, 1690, '420302', '茅箭区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1692, 1690, '420303', '张湾区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1693, 1690, '420304', '郧阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1694, 1690, '420322', '郧西县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1695, 1690, '420323', '竹山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1696, 1690, '420324', '竹溪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1697, 1690, '420325', '房县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1698, 1690, '420381', '丹江口市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1699, 1668, '420500', '宜昌市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1700, 1699, '420502', '西陵区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1701, 1699, '420503', '伍家岗区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1702, 1699, '420504', '点军区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1703, 1699, '420505', '猇亭区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1704, 1699, '420506', '夷陵区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1705, 1699, '420525', '远安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1706, 1699, '420526', '兴山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1707, 1699, '420527', '秭归县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1708, 1699, '420528', '长阳土家族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1709, 1699, '420529', '五峰土家族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1710, 1699, '420581', '宜都市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1711, 1699, '420582', '当阳市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1712, 1699, '420583', '枝江市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1713, 1668, '420600', '襄阳市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1714, 1713, '420602', '襄城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1715, 1713, '420606', '樊城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1716, 1713, '420607', '襄州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1717, 1713, '420624', '南漳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1718, 1713, '420625', '谷城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1719, 1713, '420626', '保康县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1720, 1713, '420682', '老河口市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1721, 1713, '420683', '枣阳市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1722, 1713, '420684', '宜城市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1723, 1668, '420700', '鄂州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1724, 1723, '420702', '梁子湖区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1725, 1723, '420703', '华容区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1726, 1723, '420704', '鄂城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1727, 1668, '420800', '荆门市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1728, 1727, '420802', '东宝区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1729, 1727, '420804', '掇刀区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1730, 1727, '420822', '沙洋县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1731, 1727, '420881', '钟祥市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1732, 1727, '420882', '京山市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1733, 1668, '420900', '孝感市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1734, 1733, '420902', '孝南区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1735, 1733, '420921', '孝昌县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1736, 1733, '420922', '大悟县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1737, 1733, '420923', '云梦县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1738, 1733, '420981', '应城市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1739, 1733, '420982', '安陆市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1740, 1733, '420984', '汉川市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1741, 1668, '421000', '荆州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1742, 1741, '421002', '沙市区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1743, 1741, '421003', '荆州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1744, 1741, '421022', '公安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1745, 1741, '421023', '监利县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1746, 1741, '421024', '江陵县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1747, 1741, '421081', '石首市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1748, 1741, '421083', '洪湖市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1749, 1741, '421087', '松滋市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1750, 1668, '421100', '黄冈市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1751, 1750, '421102', '黄州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1752, 1750, '421121', '团风县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1753, 1750, '421122', '红安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1754, 1750, '421123', '罗田县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1755, 1750, '421124', '英山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1756, 1750, '421125', '浠水县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1757, 1750, '421126', '蕲春县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1758, 1750, '421127', '黄梅县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1759, 1750, '421181', '麻城市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1760, 1750, '421182', '武穴市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1761, 1668, '421200', '咸宁市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1762, 1761, '421202', '咸安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1763, 1761, '421221', '嘉鱼县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1764, 1761, '421222', '通城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1765, 1761, '421223', '崇阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1766, 1761, '421224', '通山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1767, 1761, '421281', '赤壁市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1768, 1668, '421300', '随州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1769, 1768, '421303', '曾都区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1770, 1768, '421321', '随县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1771, 1768, '421381', '广水市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1772, 1668, '422800', '恩施土家族苗族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1773, 1772, '422801', '恩施市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1774, 1772, '422802', '利川市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1775, 1772, '422822', '建始县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1776, 1772, '422823', '巴东县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1777, 1772, '422825', '宣恩县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1778, 1772, '422826', '咸丰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1779, 1772, '422827', '来凤县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1780, 1772, '422828', '鹤峰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1781, 1668, '429004', '仙桃市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1782, 1668, '429005', '潜江市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1783, 1668, '429006', '天门市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1784, 1668, '429021', '神农架林区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1785, 0, '430000', '湖南省', 0, 0, 0);
INSERT INTO `tp_area` VALUES (1786, 1785, '430100', '长沙市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1787, 1786, '430102', '芙蓉区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1788, 1786, '430103', '天心区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1789, 1786, '430104', '岳麓区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1790, 1786, '430105', '开福区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1791, 1786, '430111', '雨花区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1792, 1786, '430112', '望城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1793, 1786, '430121', '长沙县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1794, 1786, '430181', '浏阳市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1795, 1786, '430182', '宁乡市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1796, 1785, '430200', '株洲市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1797, 1796, '430202', '荷塘区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1798, 1796, '430203', '芦淞区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1799, 1796, '430204', '石峰区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1800, 1796, '430211', '天元区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1801, 1796, '430212', '渌口区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1802, 1796, '430223', '攸县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1803, 1796, '430224', '茶陵县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1804, 1796, '430225', '炎陵县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1805, 1796, '430281', '醴陵市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1806, 1785, '430300', '湘潭市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1807, 1806, '430302', '雨湖区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1808, 1806, '430304', '岳塘区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1809, 1806, '430321', '湘潭县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1810, 1806, '430381', '湘乡市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1811, 1806, '430382', '韶山市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1812, 1785, '430400', '衡阳市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1813, 1812, '430405', '珠晖区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1814, 1812, '430406', '雁峰区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1815, 1812, '430407', '石鼓区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1816, 1812, '430408', '蒸湘区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1817, 1812, '430412', '南岳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1818, 1812, '430421', '衡阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1819, 1812, '430422', '衡南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1820, 1812, '430423', '衡山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1821, 1812, '430424', '衡东县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1822, 1812, '430426', '祁东县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1823, 1812, '430481', '耒阳市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1824, 1812, '430482', '常宁市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1825, 1785, '430500', '邵阳市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1826, 1825, '430502', '双清区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1827, 1825, '430503', '大祥区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1828, 1825, '430511', '北塔区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1829, 1825, '430522', '新邵县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1830, 1825, '430523', '邵阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1831, 1825, '430524', '隆回县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1832, 1825, '430525', '洞口县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1833, 1825, '430527', '绥宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1834, 1825, '430528', '新宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1835, 1825, '430529', '城步苗族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1836, 1825, '430581', '武冈市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1837, 1825, '430582', '邵东市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1838, 1785, '430600', '岳阳市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1839, 1838, '430602', '岳阳楼区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1840, 1838, '430603', '云溪区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1841, 1838, '430611', '君山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1842, 1838, '430621', '岳阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1843, 1838, '430623', '华容县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1844, 1838, '430624', '湘阴县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1845, 1838, '430626', '平江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1846, 1838, '430681', '汨罗市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1847, 1838, '430682', '临湘市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1848, 1785, '430700', '常德市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1849, 1848, '430702', '武陵区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1850, 1848, '430703', '鼎城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1851, 1848, '430721', '安乡县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1852, 1848, '430722', '汉寿县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1853, 1848, '430723', '澧县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1854, 1848, '430724', '临澧县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1855, 1848, '430725', '桃源县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1856, 1848, '430726', '石门县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1857, 1848, '430781', '津市市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1858, 1785, '430800', '张家界市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1859, 1858, '430802', '永定区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1860, 1858, '430811', '武陵源区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1861, 1858, '430821', '慈利县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1862, 1858, '430822', '桑植县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1863, 1785, '430900', '益阳市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1864, 1863, '430902', '资阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1865, 1863, '430903', '赫山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1866, 1863, '430921', '南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1867, 1863, '430922', '桃江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1868, 1863, '430923', '安化县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1869, 1863, '430981', '沅江市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1870, 1785, '431000', '郴州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1871, 1870, '431002', '北湖区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1872, 1870, '431003', '苏仙区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1873, 1870, '431021', '桂阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1874, 1870, '431022', '宜章县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1875, 1870, '431023', '永兴县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1876, 1870, '431024', '嘉禾县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1877, 1870, '431025', '临武县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1878, 1870, '431026', '汝城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1879, 1870, '431027', '桂东县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1880, 1870, '431028', '安仁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1881, 1870, '431081', '资兴市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1882, 1785, '431100', '永州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1883, 1882, '431102', '零陵区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1884, 1882, '431103', '冷水滩区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1885, 1882, '431121', '祁阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1886, 1882, '431122', '东安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1887, 1882, '431123', '双牌县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1888, 1882, '431124', '道县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1889, 1882, '431125', '江永县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1890, 1882, '431126', '宁远县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1891, 1882, '431127', '蓝山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1892, 1882, '431128', '新田县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1893, 1882, '431129', '江华瑶族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1894, 1785, '431200', '怀化市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1895, 1894, '431202', '鹤城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1896, 1894, '431221', '中方县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1897, 1894, '431222', '沅陵县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1898, 1894, '431223', '辰溪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1899, 1894, '431224', '溆浦县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1900, 1894, '431225', '会同县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1901, 1894, '431226', '麻阳苗族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1902, 1894, '431227', '新晃侗族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1903, 1894, '431228', '芷江侗族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1904, 1894, '431229', '靖州苗族侗族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1905, 1894, '431230', '通道侗族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1906, 1894, '431281', '洪江市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1907, 1785, '431300', '娄底市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1908, 1907, '431302', '娄星区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1909, 1907, '431321', '双峰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1910, 1907, '431322', '新化县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1911, 1907, '431381', '冷水江市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1912, 1907, '431382', '涟源市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1913, 1785, '433100', '湘西土家族苗族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1914, 1913, '433101', '吉首市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1915, 1913, '433122', '泸溪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1916, 1913, '433123', '凤凰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1917, 1913, '433124', '花垣县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1918, 1913, '433125', '保靖县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1919, 1913, '433126', '古丈县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1920, 1913, '433127', '永顺县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1921, 1913, '433130', '龙山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1922, 0, '440000', '广东省', 0, 0, 0);
INSERT INTO `tp_area` VALUES (1923, 1922, '440100', '广州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1924, 1923, '440103', '荔湾区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1925, 1923, '440104', '越秀区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1926, 1923, '440105', '海珠区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1927, 1923, '440106', '天河区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1928, 1923, '440111', '白云区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1929, 1923, '440112', '黄埔区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1930, 1923, '440113', '番禺区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1931, 1923, '440114', '花都区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1932, 1923, '440115', '南沙区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1933, 1923, '440117', '从化区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1934, 1923, '440118', '增城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1935, 1922, '440200', '韶关市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1936, 1935, '440203', '武江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1937, 1935, '440204', '浈江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1938, 1935, '440205', '曲江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1939, 1935, '440222', '始兴县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1940, 1935, '440224', '仁化县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1941, 1935, '440229', '翁源县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1942, 1935, '440232', '乳源瑶族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1943, 1935, '440233', '新丰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1944, 1935, '440281', '乐昌市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1945, 1935, '440282', '南雄市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1946, 1922, '440300', '深圳市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1947, 1946, '440303', '罗湖区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1948, 1946, '440304', '福田区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1949, 1946, '440305', '南山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1950, 1946, '440306', '宝安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1951, 1946, '440307', '龙岗区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1952, 1946, '440308', '盐田区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1953, 1946, '440309', '龙华区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1954, 1946, '440310', '坪山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1955, 1946, '440311', '光明区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1956, 1922, '440400', '珠海市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1957, 1956, '440402', '香洲区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1958, 1956, '440403', '斗门区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1959, 1956, '440404', '金湾区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1960, 1922, '440500', '汕头市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1961, 1960, '440507', '龙湖区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1962, 1960, '440511', '金平区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1963, 1960, '440512', '濠江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1964, 1960, '440513', '潮阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1965, 1960, '440514', '潮南区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1966, 1960, '440515', '澄海区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1967, 1960, '440523', '南澳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1968, 1922, '440600', '佛山市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1969, 1968, '440604', '禅城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1970, 1968, '440605', '南海区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1971, 1968, '440606', '顺德区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1972, 1968, '440607', '三水区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1973, 1968, '440608', '高明区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1974, 1922, '440700', '江门市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1975, 1974, '440703', '蓬江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1976, 1974, '440704', '江海区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1977, 1974, '440705', '新会区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1978, 1974, '440781', '台山市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1979, 1974, '440783', '开平市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1980, 1974, '440784', '鹤山市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1981, 1974, '440785', '恩平市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1982, 1922, '440800', '湛江市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1983, 1982, '440802', '赤坎区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1984, 1982, '440803', '霞山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1985, 1982, '440804', '坡头区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1986, 1982, '440811', '麻章区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1987, 1982, '440823', '遂溪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1988, 1982, '440825', '徐闻县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1989, 1982, '440881', '廉江市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1990, 1982, '440882', '雷州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1991, 1982, '440883', '吴川市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1992, 1922, '440900', '茂名市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1993, 1992, '440902', '茂南区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1994, 1992, '440904', '电白区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1995, 1992, '440981', '高州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1996, 1992, '440982', '化州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1997, 1992, '440983', '信宜市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (1998, 1922, '441200', '肇庆市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (1999, 1998, '441202', '端州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2000, 1998, '441203', '鼎湖区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2001, 1998, '441204', '高要区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2002, 1998, '441223', '广宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2003, 1998, '441224', '怀集县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2004, 1998, '441225', '封开县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2005, 1998, '441226', '德庆县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2006, 1998, '441284', '四会市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2007, 1922, '441300', '惠州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2008, 2007, '441302', '惠城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2009, 2007, '441303', '惠阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2010, 2007, '441322', '博罗县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2011, 2007, '441323', '惠东县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2012, 2007, '441324', '龙门县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2013, 1922, '441400', '梅州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2014, 2013, '441402', '梅江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2015, 2013, '441403', '梅县区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2016, 2013, '441422', '大埔县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2017, 2013, '441423', '丰顺县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2018, 2013, '441424', '五华县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2019, 2013, '441426', '平远县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2020, 2013, '441427', '蕉岭县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2021, 2013, '441481', '兴宁市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2022, 1922, '441500', '汕尾市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2023, 2022, '441502', '城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2024, 2022, '441521', '海丰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2025, 2022, '441523', '陆河县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2026, 2022, '441581', '陆丰市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2027, 1922, '441600', '河源市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2028, 2027, '441602', '源城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2029, 2027, '441621', '紫金县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2030, 2027, '441622', '龙川县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2031, 2027, '441623', '连平县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2032, 2027, '441624', '和平县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2033, 2027, '441625', '东源县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2034, 1922, '441700', '阳江市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2035, 2034, '441702', '江城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2036, 2034, '441704', '阳东区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2037, 2034, '441721', '阳西县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2038, 2034, '441781', '阳春市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2039, 1922, '441800', '清远市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2040, 2039, '441802', '清城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2041, 2039, '441803', '清新区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2042, 2039, '441821', '佛冈县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2043, 2039, '441823', '阳山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2044, 2039, '441825', '连山壮族瑶族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2045, 2039, '441826', '连南瑶族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2046, 2039, '441881', '英德市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2047, 2039, '441882', '连州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2048, 1922, '441900', '东莞市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2049, 1922, '442000', '中山市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2050, 1922, '445100', '潮州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2051, 2050, '445102', '湘桥区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2052, 2050, '445103', '潮安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2053, 2050, '445122', '饶平县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2054, 1922, '445200', '揭阳市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2055, 2054, '445202', '榕城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2056, 2054, '445203', '揭东区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2057, 2054, '445222', '揭西县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2058, 2054, '445224', '惠来县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2059, 2054, '445281', '普宁市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2060, 1922, '445300', '云浮市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2061, 2060, '445302', '云城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2062, 2060, '445303', '云安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2063, 2060, '445321', '新兴县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2064, 2060, '445322', '郁南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2065, 2060, '445381', '罗定市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2066, 0, '450000', '广西壮族自治区', 0, 0, 0);
INSERT INTO `tp_area` VALUES (2067, 2066, '450100', '南宁市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2068, 2067, '450102', '兴宁区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2069, 2067, '450103', '青秀区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2070, 2067, '450105', '江南区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2071, 2067, '450107', '西乡塘区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2072, 2067, '450108', '良庆区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2073, 2067, '450109', '邕宁区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2074, 2067, '450110', '武鸣区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2075, 2067, '450123', '隆安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2076, 2067, '450124', '马山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2077, 2067, '450125', '上林县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2078, 2067, '450126', '宾阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2079, 2067, '450127', '横县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2080, 2066, '450200', '柳州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2081, 2080, '450202', '城中区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2082, 2080, '450203', '鱼峰区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2083, 2080, '450204', '柳南区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2084, 2080, '450205', '柳北区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2085, 2080, '450206', '柳江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2086, 2080, '450222', '柳城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2087, 2080, '450223', '鹿寨县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2088, 2080, '450224', '融安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2089, 2080, '450225', '融水苗族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2090, 2080, '450226', '三江侗族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2091, 2066, '450300', '桂林市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2092, 2091, '450302', '秀峰区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2093, 2091, '450303', '叠彩区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2094, 2091, '450304', '象山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2095, 2091, '450305', '七星区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2096, 2091, '450311', '雁山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2097, 2091, '450312', '临桂区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2098, 2091, '450321', '阳朔县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2099, 2091, '450323', '灵川县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2100, 2091, '450324', '全州县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2101, 2091, '450325', '兴安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2102, 2091, '450326', '永福县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2103, 2091, '450327', '灌阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2104, 2091, '450328', '龙胜各族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2105, 2091, '450329', '资源县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2106, 2091, '450330', '平乐县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2107, 2091, '450381', '荔浦市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2108, 2091, '450332', '恭城瑶族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2109, 2066, '450400', '梧州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2110, 2109, '450403', '万秀区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2111, 2109, '450405', '长洲区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2112, 2109, '450406', '龙圩区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2113, 2109, '450421', '苍梧县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2114, 2109, '450422', '藤县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2115, 2109, '450423', '蒙山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2116, 2109, '450481', '岑溪市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2117, 2066, '450500', '北海市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2118, 2117, '450502', '海城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2119, 2117, '450503', '银海区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2120, 2117, '450512', '铁山港区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2121, 2117, '450521', '合浦县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2122, 2066, '450600', '防城港市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2123, 2122, '450602', '港口区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2124, 2122, '450603', '防城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2125, 2122, '450621', '上思县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2126, 2122, '450681', '东兴市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2127, 2066, '450700', '钦州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2128, 2127, '450702', '钦南区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2129, 2127, '450703', '钦北区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2130, 2127, '450721', '灵山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2131, 2127, '450722', '浦北县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2132, 2066, '450800', '贵港市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2133, 2132, '450802', '港北区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2134, 2132, '450803', '港南区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2135, 2132, '450804', '覃塘区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2136, 2132, '450821', '平南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2137, 2132, '450881', '桂平市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2138, 2066, '450900', '玉林市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2139, 2138, '450902', '玉州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2140, 2138, '450903', '福绵区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2141, 2138, '450921', '容县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2142, 2138, '450922', '陆川县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2143, 2138, '450923', '博白县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2144, 2138, '450924', '兴业县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2145, 2138, '450981', '北流市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2146, 2066, '451000', '百色市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2147, 2146, '451002', '右江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2148, 2146, '451003', '田阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2149, 2146, '451022', '田东县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2150, 2146, '451024', '德保县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2151, 2146, '451026', '那坡县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2152, 2146, '451027', '凌云县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2153, 2146, '451028', '乐业县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2154, 2146, '451029', '田林县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2155, 2146, '451030', '西林县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2156, 2146, '451031', '隆林各族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2157, 2146, '451081', '靖西市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2158, 2146, '451082', '平果市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2159, 2066, '451100', '贺州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2160, 2159, '451102', '八步区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2161, 2159, '451103', '平桂区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2162, 2159, '451121', '昭平县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2163, 2159, '451122', '钟山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2164, 2159, '451123', '富川瑶族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2165, 2066, '451200', '河池市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2166, 2165, '451202', '金城江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2167, 2165, '451203', '宜州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2168, 2165, '451221', '南丹县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2169, 2165, '451222', '天峨县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2170, 2165, '451223', '凤山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2171, 2165, '451224', '东兰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2172, 2165, '451225', '罗城仫佬族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2173, 2165, '451226', '环江毛南族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2174, 2165, '451227', '巴马瑶族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2175, 2165, '451228', '都安瑶族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2176, 2165, '451229', '大化瑶族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2177, 2066, '451300', '来宾市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2178, 2177, '451302', '兴宾区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2179, 2177, '451321', '忻城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2180, 2177, '451322', '象州县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2181, 2177, '451323', '武宣县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2182, 2177, '451324', '金秀瑶族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2183, 2177, '451381', '合山市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2184, 2066, '451400', '崇左市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2185, 2184, '451402', '江州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2186, 2184, '451421', '扶绥县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2187, 2184, '451422', '宁明县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2188, 2184, '451423', '龙州县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2189, 2184, '451424', '大新县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2190, 2184, '451425', '天等县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2191, 2184, '451481', '凭祥市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2192, 0, '460000', '海南省', 0, 0, 0);
INSERT INTO `tp_area` VALUES (2193, 2192, '460100', '海口市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2194, 2193, '460105', '秀英区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2195, 2193, '460106', '龙华区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2196, 2193, '460107', '琼山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2197, 2193, '460108', '美兰区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2198, 2192, '460200', '三亚市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2199, 2198, '460202', '海棠区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2200, 2198, '460203', '吉阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2201, 2198, '460204', '天涯区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2202, 2198, '460205', '崖州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2203, 2192, '460300', '三沙市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2204, 2192, '460400', '儋州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2205, 2192, '469001', '五指山市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2206, 2192, '469002', '琼海市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2207, 2192, '469005', '文昌市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2208, 2192, '469006', '万宁市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2209, 2192, '469007', '东方市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2210, 2192, '469021', '定安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2211, 2192, '469022', '屯昌县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2212, 2192, '469023', '澄迈县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2213, 2192, '469024', '临高县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2214, 2192, '469025', '白沙黎族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2215, 2192, '469026', '昌江黎族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2216, 2192, '469027', '乐东黎族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2217, 2192, '469028', '陵水黎族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2218, 2192, '469029', '保亭黎族苗族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2219, 2192, '469030', '琼中黎族苗族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2220, 0, '500000', '重庆', 0, 0, 0);
INSERT INTO `tp_area` VALUES (2221, 3219, '500101', '万州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2222, 3219, '500102', '涪陵区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2223, 3219, '500103', '渝中区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2224, 3219, '500104', '大渡口区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2225, 3219, '500105', '江北区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2226, 3219, '500106', '沙坪坝区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2227, 3219, '500107', '九龙坡区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2228, 3219, '500108', '南岸区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2229, 3219, '500109', '北碚区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2230, 3219, '500110', '綦江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2231, 3219, '500111', '大足区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2232, 3219, '500112', '渝北区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2233, 3219, '500113', '巴南区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2234, 3219, '500114', '黔江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2235, 3219, '500115', '长寿区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2236, 3219, '500116', '江津区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2237, 3219, '500117', '合川区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2238, 3219, '500118', '永川区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2239, 3219, '500119', '南川区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2240, 3219, '500120', '璧山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2241, 3219, '500151', '铜梁区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2242, 3219, '500152', '潼南区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2243, 3219, '500153', '荣昌区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2244, 3219, '500154', '开州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2245, 3219, '500155', '梁平区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2246, 3219, '500156', '武隆区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2247, 3219, '500229', '城口县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2248, 3219, '500230', '丰都县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2249, 3219, '500231', '垫江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2250, 3219, '500233', '忠县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2251, 3219, '500235', '云阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2252, 3219, '500236', '奉节县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2253, 3219, '500237', '巫山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2254, 3219, '500238', '巫溪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2255, 3219, '500240', '石柱土家族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2256, 3219, '500241', '秀山土家族苗族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2257, 3219, '500242', '酉阳土家族苗族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2258, 3219, '500243', '彭水苗族土家族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2259, 0, '510000', '四川省', 0, 0, 0);
INSERT INTO `tp_area` VALUES (2260, 2259, '510100', '成都市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2261, 2260, '510104', '锦江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2262, 2260, '510105', '青羊区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2263, 2260, '510106', '金牛区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2264, 2260, '510107', '武侯区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2265, 2260, '510108', '成华区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2266, 2260, '510112', '龙泉驿区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2267, 2260, '510113', '青白江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2268, 2260, '510114', '新都区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2269, 2260, '510115', '温江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2270, 2260, '510116', '双流区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2271, 2260, '510117', '郫都区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2272, 2260, '510121', '金堂县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2273, 2260, '510129', '大邑县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2274, 2260, '510131', '蒲江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2275, 2260, '510132', '新津县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2276, 2260, '510181', '都江堰市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2277, 2260, '510182', '彭州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2278, 2260, '510183', '邛崃市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2279, 2260, '510184', '崇州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2280, 2260, '510185', '简阳市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2281, 2259, '510300', '自贡市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2282, 2281, '510302', '自流井区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2283, 2281, '510303', '贡井区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2284, 2281, '510304', '大安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2285, 2281, '510311', '沿滩区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2286, 2281, '510321', '荣县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2287, 2281, '510322', '富顺县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2288, 2259, '510400', '攀枝花市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2289, 2288, '510402', '东区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2290, 2288, '510403', '西区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2291, 2288, '510411', '仁和区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2292, 2288, '510421', '米易县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2293, 2288, '510422', '盐边县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2294, 2259, '510500', '泸州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2295, 2294, '510502', '江阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2296, 2294, '510503', '纳溪区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2297, 2294, '510504', '龙马潭区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2298, 2294, '510521', '泸县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2299, 2294, '510522', '合江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2300, 2294, '510524', '叙永县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2301, 2294, '510525', '古蔺县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2302, 2259, '510600', '德阳市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2303, 2302, '510603', '旌阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2304, 2302, '510604', '罗江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2305, 2302, '510623', '中江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2306, 2302, '510681', '广汉市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2307, 2302, '510682', '什邡市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2308, 2302, '510683', '绵竹市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2309, 2259, '510700', '绵阳市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2310, 2309, '510703', '涪城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2311, 2309, '510704', '游仙区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2312, 2309, '510705', '安州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2313, 2309, '510722', '三台县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2314, 2309, '510723', '盐亭县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2315, 2309, '510725', '梓潼县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2316, 2309, '510726', '北川羌族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2317, 2309, '510727', '平武县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2318, 2309, '510781', '江油市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2319, 2259, '510800', '广元市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2320, 2319, '510802', '利州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2321, 2319, '510811', '昭化区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2322, 2319, '510812', '朝天区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2323, 2319, '510821', '旺苍县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2324, 2319, '510822', '青川县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2325, 2319, '510823', '剑阁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2326, 2319, '510824', '苍溪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2327, 2259, '510900', '遂宁市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2328, 2327, '510903', '船山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2329, 2327, '510904', '安居区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2330, 2327, '510921', '蓬溪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2331, 2327, '510923', '大英县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2332, 2327, '510981', '射洪市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2333, 2259, '511000', '内江市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2334, 2333, '511002', '市中区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2335, 2333, '511011', '东兴区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2336, 2333, '511024', '威远县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2337, 2333, '511025', '资中县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2338, 2333, '511083', '隆昌市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2339, 2259, '511100', '乐山市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2340, 2339, '511102', '市中区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2341, 2339, '511111', '沙湾区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2342, 2339, '511112', '五通桥区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2343, 2339, '511113', '金口河区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2344, 2339, '511123', '犍为县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2345, 2339, '511124', '井研县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2346, 2339, '511126', '夹江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2347, 2339, '511129', '沐川县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2348, 2339, '511132', '峨边彝族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2349, 2339, '511133', '马边彝族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2350, 2339, '511181', '峨眉山市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2351, 2259, '511300', '南充市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2352, 2351, '511302', '顺庆区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2353, 2351, '511303', '高坪区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2354, 2351, '511304', '嘉陵区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2355, 2351, '511321', '南部县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2356, 2351, '511322', '营山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2357, 2351, '511323', '蓬安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2358, 2351, '511324', '仪陇县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2359, 2351, '511325', '西充县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2360, 2351, '511381', '阆中市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2361, 2259, '511400', '眉山市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2362, 2361, '511402', '东坡区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2363, 2361, '511403', '彭山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2364, 2361, '511421', '仁寿县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2365, 2361, '511423', '洪雅县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2366, 2361, '511424', '丹棱县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2367, 2361, '511425', '青神县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2368, 2259, '511500', '宜宾市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2369, 2368, '511502', '翠屏区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2370, 2368, '511503', '南溪区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2371, 2368, '511504', '叙州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2372, 2368, '511523', '江安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2373, 2368, '511524', '长宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2374, 2368, '511525', '高县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2375, 2368, '511526', '珙县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2376, 2368, '511527', '筠连县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2377, 2368, '511528', '兴文县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2378, 2368, '511529', '屏山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2379, 2259, '511600', '广安市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2380, 2379, '511602', '广安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2381, 2379, '511603', '前锋区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2382, 2379, '511621', '岳池县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2383, 2379, '511622', '武胜县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2384, 2379, '511623', '邻水县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2385, 2379, '511681', '华蓥市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2386, 2259, '511700', '达州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2387, 2386, '511702', '通川区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2388, 2386, '511703', '达川区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2389, 2386, '511722', '宣汉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2390, 2386, '511723', '开江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2391, 2386, '511724', '大竹县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2392, 2386, '511725', '渠县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2393, 2386, '511781', '万源市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2394, 2259, '511800', '雅安市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2395, 2394, '511802', '雨城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2396, 2394, '511803', '名山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2397, 2394, '511822', '荥经县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2398, 2394, '511823', '汉源县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2399, 2394, '511824', '石棉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2400, 2394, '511825', '天全县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2401, 2394, '511826', '芦山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2402, 2394, '511827', '宝兴县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2403, 2259, '511900', '巴中市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2404, 2403, '511902', '巴州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2405, 2403, '511903', '恩阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2406, 2403, '511921', '通江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2407, 2403, '511922', '南江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2408, 2403, '511923', '平昌县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2409, 2259, '512000', '资阳市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2410, 2409, '512002', '雁江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2411, 2409, '512021', '安岳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2412, 2409, '512022', '乐至县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2413, 2259, '513200', '阿坝藏族羌族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2414, 2413, '513201', '马尔康市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2415, 2413, '513221', '汶川县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2416, 2413, '513222', '理县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2417, 2413, '513223', '茂县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2418, 2413, '513224', '松潘县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2419, 2413, '513225', '九寨沟县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2420, 2413, '513226', '金川县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2421, 2413, '513227', '小金县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2422, 2413, '513228', '黑水县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2423, 2413, '513230', '壤塘县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2424, 2413, '513231', '阿坝县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2425, 2413, '513232', '若尔盖县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2426, 2413, '513233', '红原县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2427, 2259, '513300', '甘孜藏族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2428, 2427, '513301', '康定市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2429, 2427, '513322', '泸定县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2430, 2427, '513323', '丹巴县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2431, 2427, '513324', '九龙县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2432, 2427, '513325', '雅江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2433, 2427, '513326', '道孚县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2434, 2427, '513327', '炉霍县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2435, 2427, '513328', '甘孜县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2436, 2427, '513329', '新龙县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2437, 2427, '513330', '德格县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2438, 2427, '513331', '白玉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2439, 2427, '513332', '石渠县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2440, 2427, '513333', '色达县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2441, 2427, '513334', '理塘县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2442, 2427, '513335', '巴塘县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2443, 2427, '513336', '乡城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2444, 2427, '513337', '稻城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2445, 2427, '513338', '得荣县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2446, 2259, '513400', '凉山彝族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2447, 2446, '513401', '西昌市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2448, 2446, '513422', '木里藏族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2449, 2446, '513423', '盐源县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2450, 2446, '513424', '德昌县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2451, 2446, '513425', '会理县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2452, 2446, '513426', '会东县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2453, 2446, '513427', '宁南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2454, 2446, '513428', '普格县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2455, 2446, '513429', '布拖县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2456, 2446, '513430', '金阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2457, 2446, '513431', '昭觉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2458, 2446, '513432', '喜德县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2459, 2446, '513433', '冕宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2460, 2446, '513434', '越西县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2461, 2446, '513435', '甘洛县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2462, 2446, '513436', '美姑县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2463, 2446, '513437', '雷波县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2464, 0, '520000', '贵州省', 0, 0, 0);
INSERT INTO `tp_area` VALUES (2465, 2464, '520100', '贵阳市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2466, 2465, '520102', '南明区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2467, 2465, '520103', '云岩区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2468, 2465, '520111', '花溪区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2469, 2465, '520112', '乌当区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2470, 2465, '520113', '白云区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2471, 2465, '520115', '观山湖区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2472, 2465, '520121', '开阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2473, 2465, '520122', '息烽县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2474, 2465, '520123', '修文县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2475, 2465, '520181', '清镇市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2476, 2464, '520200', '六盘水市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2477, 2476, '520201', '钟山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2478, 2476, '520203', '六枝特区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2479, 2476, '520221', '水城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2480, 2476, '520281', '盘州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2481, 2464, '520300', '遵义市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2482, 2481, '520302', '红花岗区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2483, 2481, '520303', '汇川区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2484, 2481, '520304', '播州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2485, 2481, '520322', '桐梓县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2486, 2481, '520323', '绥阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2487, 2481, '520324', '正安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2488, 2481, '520325', '道真仡佬族苗族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2489, 2481, '520326', '务川仡佬族苗族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2490, 2481, '520327', '凤冈县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2491, 2481, '520328', '湄潭县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2492, 2481, '520329', '余庆县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2493, 2481, '520330', '习水县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2494, 2481, '520381', '赤水市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2495, 2481, '520382', '仁怀市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2496, 2464, '520400', '安顺市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2497, 2496, '520402', '西秀区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2498, 2496, '520403', '平坝区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2499, 2496, '520422', '普定县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2500, 2496, '520423', '镇宁布依族苗族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2501, 2496, '520424', '关岭布依族苗族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2502, 2496, '520425', '紫云苗族布依族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2503, 2464, '520500', '毕节市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2504, 2503, '520502', '七星关区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2505, 2503, '520521', '大方县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2506, 2503, '520522', '黔西县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2507, 2503, '520523', '金沙县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2508, 2503, '520524', '织金县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2509, 2503, '520525', '纳雍县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2510, 2503, '520526', '威宁彝族回族苗族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2511, 2503, '520527', '赫章县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2512, 2464, '520600', '铜仁市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2513, 2512, '520602', '碧江区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2514, 2512, '520603', '万山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2515, 2512, '520621', '江口县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2516, 2512, '520622', '玉屏侗族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2517, 2512, '520623', '石阡县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2518, 2512, '520624', '思南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2519, 2512, '520625', '印江土家族苗族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2520, 2512, '520626', '德江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2521, 2512, '520627', '沿河土家族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2522, 2512, '520628', '松桃苗族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2523, 2464, '522300', '黔西南布依族苗族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2524, 2523, '522301', '兴义市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2525, 2523, '522302', '兴仁市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2526, 2523, '522323', '普安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2527, 2523, '522324', '晴隆县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2528, 2523, '522325', '贞丰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2529, 2523, '522326', '望谟县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2530, 2523, '522327', '册亨县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2531, 2523, '522328', '安龙县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2532, 2464, '522600', '黔东南苗族侗族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2533, 2532, '522601', '凯里市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2534, 2532, '522622', '黄平县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2535, 2532, '522623', '施秉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2536, 2532, '522624', '三穗县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2537, 2532, '522625', '镇远县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2538, 2532, '522626', '岑巩县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2539, 2532, '522627', '天柱县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2540, 2532, '522628', '锦屏县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2541, 2532, '522629', '剑河县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2542, 2532, '522630', '台江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2543, 2532, '522631', '黎平县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2544, 2532, '522632', '榕江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2545, 2532, '522633', '从江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2546, 2532, '522634', '雷山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2547, 2532, '522635', '麻江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2548, 2532, '522636', '丹寨县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2549, 2464, '522700', '黔南布依族苗族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2550, 2549, '522701', '都匀市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2551, 2549, '522702', '福泉市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2552, 2549, '522722', '荔波县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2553, 2549, '522723', '贵定县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2554, 2549, '522725', '瓮安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2555, 2549, '522726', '独山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2556, 2549, '522727', '平塘县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2557, 2549, '522728', '罗甸县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2558, 2549, '522729', '长顺县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2559, 2549, '522730', '龙里县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2560, 2549, '522731', '惠水县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2561, 2549, '522732', '三都水族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2562, 0, '530000', '云南省', 0, 0, 0);
INSERT INTO `tp_area` VALUES (2563, 2562, '530100', '昆明市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2564, 2563, '530102', '五华区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2565, 2563, '530103', '盘龙区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2566, 2563, '530111', '官渡区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2567, 2563, '530112', '西山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2568, 2563, '530113', '东川区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2569, 2563, '530114', '呈贡区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2570, 2563, '530115', '晋宁区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2571, 2563, '530124', '富民县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2572, 2563, '530125', '宜良县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2573, 2563, '530126', '石林彝族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2574, 2563, '530127', '嵩明县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2575, 2563, '530128', '禄劝彝族苗族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2576, 2563, '530129', '寻甸回族彝族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2577, 2563, '530181', '安宁市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2578, 2562, '530300', '曲靖市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2579, 2578, '530302', '麒麟区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2580, 2578, '530303', '沾益区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2581, 2578, '530304', '马龙区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2582, 2578, '530322', '陆良县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2583, 2578, '530323', '师宗县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2584, 2578, '530324', '罗平县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2585, 2578, '530325', '富源县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2586, 2578, '530326', '会泽县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2587, 2578, '530381', '宣威市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2588, 2562, '530400', '玉溪市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2589, 2588, '530402', '红塔区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2590, 2588, '530403', '江川区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2591, 2588, '530423', '通海县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2592, 2588, '530424', '华宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2593, 2588, '530425', '易门县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2594, 2588, '530426', '峨山彝族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2595, 2588, '530427', '新平彝族傣族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2596, 2588, '530428', '元江哈尼族彝族傣族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2597, 2588, '530481', '澄江市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2598, 2562, '530500', '保山市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2599, 2598, '530502', '隆阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2600, 2598, '530521', '施甸县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2601, 2598, '530523', '龙陵县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2602, 2598, '530524', '昌宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2603, 2598, '530581', '腾冲市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2604, 2562, '530600', '昭通市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2605, 2604, '530602', '昭阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2606, 2604, '530621', '鲁甸县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2607, 2604, '530622', '巧家县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2608, 2604, '530623', '盐津县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2609, 2604, '530624', '大关县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2610, 2604, '530625', '永善县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2611, 2604, '530626', '绥江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2612, 2604, '530627', '镇雄县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2613, 2604, '530628', '彝良县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2614, 2604, '530629', '威信县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2615, 2604, '530681', '水富市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2616, 2562, '530700', '丽江市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2617, 2616, '530702', '古城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2618, 2616, '530721', '玉龙纳西族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2619, 2616, '530722', '永胜县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2620, 2616, '530723', '华坪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2621, 2616, '530724', '宁蒗彝族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2622, 2562, '530800', '普洱市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2623, 2622, '530802', '思茅区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2624, 2622, '530821', '宁洱哈尼族彝族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2625, 2622, '530822', '墨江哈尼族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2626, 2622, '530823', '景东彝族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2627, 2622, '530824', '景谷傣族彝族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2628, 2622, '530825', '镇沅彝族哈尼族拉祜族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2629, 2622, '530826', '江城哈尼族彝族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2630, 2622, '530827', '孟连傣族拉祜族佤族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2631, 2622, '530828', '澜沧拉祜族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2632, 2622, '530829', '西盟佤族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2633, 2562, '530900', '临沧市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2634, 2633, '530902', '临翔区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2635, 2633, '530921', '凤庆县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2636, 2633, '530922', '云县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2637, 2633, '530923', '永德县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2638, 2633, '530924', '镇康县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2639, 2633, '530925', '双江拉祜族佤族布朗族傣族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2640, 2633, '530926', '耿马傣族佤族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2641, 2633, '530927', '沧源佤族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2642, 2562, '532300', '楚雄彝族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2643, 2642, '532301', '楚雄市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2644, 2642, '532322', '双柏县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2645, 2642, '532323', '牟定县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2646, 2642, '532324', '南华县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2647, 2642, '532325', '姚安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2648, 2642, '532326', '大姚县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2649, 2642, '532327', '永仁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2650, 2642, '532328', '元谋县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2651, 2642, '532329', '武定县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2652, 2642, '532331', '禄丰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2653, 2562, '532500', '红河哈尼族彝族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2654, 2653, '532501', '个旧市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2655, 2653, '532502', '开远市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2656, 2653, '532503', '蒙自市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2657, 2653, '532504', '弥勒市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2658, 2653, '532523', '屏边苗族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2659, 2653, '532524', '建水县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2660, 2653, '532525', '石屏县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2661, 2653, '532527', '泸西县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2662, 2653, '532528', '元阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2663, 2653, '532529', '红河县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2664, 2653, '532530', '金平苗族瑶族傣族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2665, 2653, '532531', '绿春县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2666, 2653, '532532', '河口瑶族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2667, 2562, '532600', '文山壮族苗族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2668, 2667, '532601', '文山市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2669, 2667, '532622', '砚山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2670, 2667, '532623', '西畴县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2671, 2667, '532624', '麻栗坡县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2672, 2667, '532625', '马关县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2673, 2667, '532626', '丘北县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2674, 2667, '532627', '广南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2675, 2667, '532628', '富宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2676, 2562, '532800', '西双版纳傣族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2677, 2676, '532801', '景洪市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2678, 2676, '532822', '勐海县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2679, 2676, '532823', '勐腊县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2680, 2562, '532900', '大理白族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2681, 2680, '532901', '大理市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2682, 2680, '532922', '漾濞彝族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2683, 2680, '532923', '祥云县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2684, 2680, '532924', '宾川县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2685, 2680, '532925', '弥渡县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2686, 2680, '532926', '南涧彝族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2687, 2680, '532927', '巍山彝族回族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2688, 2680, '532928', '永平县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2689, 2680, '532929', '云龙县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2690, 2680, '532930', '洱源县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2691, 2680, '532931', '剑川县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2692, 2680, '532932', '鹤庆县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2693, 2562, '533100', '德宏傣族景颇族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2694, 2693, '533102', '瑞丽市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2695, 2693, '533103', '芒市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2696, 2693, '533122', '梁河县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2697, 2693, '533123', '盈江县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2698, 2693, '533124', '陇川县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2699, 2562, '533300', '怒江傈僳族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2700, 2699, '533301', '泸水市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2701, 2699, '533323', '福贡县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2702, 2699, '533324', '贡山独龙族怒族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2703, 2699, '533325', '兰坪白族普米族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2704, 2562, '533400', '迪庆藏族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2705, 2704, '533401', '香格里拉市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2706, 2704, '533422', '德钦县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2707, 2704, '533423', '维西傈僳族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2708, 0, '540000', '西藏自治区', 0, 0, 0);
INSERT INTO `tp_area` VALUES (2709, 2708, '540100', '拉萨市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2710, 2709, '540102', '城关区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2711, 2709, '540103', '堆龙德庆区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2712, 2709, '540104', '达孜区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2713, 2709, '540121', '林周县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2714, 2709, '540122', '当雄县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2715, 2709, '540123', '尼木县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2716, 2709, '540124', '曲水县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2717, 2709, '540127', '墨竹工卡县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2718, 2708, '540200', '日喀则市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2719, 2718, '540202', '桑珠孜区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2720, 2718, '540221', '南木林县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2721, 2718, '540222', '江孜县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2722, 2718, '540223', '定日县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2723, 2718, '540224', '萨迦县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2724, 2718, '540225', '拉孜县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2725, 2718, '540226', '昂仁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2726, 2718, '540227', '谢通门县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2727, 2718, '540228', '白朗县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2728, 2718, '540229', '仁布县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2729, 2718, '540230', '康马县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2730, 2718, '540231', '定结县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2731, 2718, '540232', '仲巴县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2732, 2718, '540233', '亚东县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2733, 2718, '540234', '吉隆县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2734, 2718, '540235', '聂拉木县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2735, 2718, '540236', '萨嘎县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2736, 2718, '540237', '岗巴县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2737, 2708, '540300', '昌都市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2738, 2737, '540302', '卡若区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2739, 2737, '540321', '江达县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2740, 2737, '540322', '贡觉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2741, 2737, '540323', '类乌齐县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2742, 2737, '540324', '丁青县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2743, 2737, '540325', '察雅县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2744, 2737, '540326', '八宿县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2745, 2737, '540327', '左贡县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2746, 2737, '540328', '芒康县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2747, 2737, '540329', '洛隆县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2748, 2737, '540330', '边坝县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2749, 2708, '540400', '林芝市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2750, 2749, '540402', '巴宜区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2751, 2749, '540421', '工布江达县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2752, 2749, '540422', '米林县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2753, 2749, '540423', '墨脱县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2754, 2749, '540424', '波密县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2755, 2749, '540425', '察隅县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2756, 2749, '540426', '朗县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2757, 2708, '540500', '山南市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2758, 2757, '540502', '乃东区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2759, 2757, '540521', '扎囊县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2760, 2757, '540522', '贡嘎县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2761, 2757, '540523', '桑日县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2762, 2757, '540524', '琼结县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2763, 2757, '540525', '曲松县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2764, 2757, '540526', '措美县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2765, 2757, '540527', '洛扎县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2766, 2757, '540528', '加查县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2767, 2757, '540529', '隆子县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2768, 2757, '540530', '错那县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2769, 2757, '540531', '浪卡子县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2770, 2708, '540600', '那曲市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2771, 2770, '540602', '色尼区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2772, 2770, '540621', '嘉黎县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2773, 2770, '540622', '比如县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2774, 2770, '540623', '聂荣县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2775, 2770, '540624', '安多县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2776, 2770, '540625', '申扎县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2777, 2770, '540626', '索县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2778, 2770, '540627', '班戈县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2779, 2770, '540628', '巴青县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2780, 2770, '540629', '尼玛县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2781, 2770, '540630', '双湖县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2782, 2708, '542500', '阿里地区', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2783, 2782, '542521', '普兰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2784, 2782, '542522', '札达县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2785, 2782, '542523', '噶尔县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2786, 2782, '542524', '日土县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2787, 2782, '542525', '革吉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2788, 2782, '542526', '改则县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2789, 2782, '542527', '措勤县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2790, 0, '610000', '陕西省', 0, 0, 0);
INSERT INTO `tp_area` VALUES (2791, 2790, '610100', '西安市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2792, 2791, '610102', '新城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2793, 2791, '610103', '碑林区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2794, 2791, '610104', '莲湖区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2795, 2791, '610111', '灞桥区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2796, 2791, '610112', '未央区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2797, 2791, '610113', '雁塔区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2798, 2791, '610114', '阎良区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2799, 2791, '610115', '临潼区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2800, 2791, '610116', '长安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2801, 2791, '610117', '高陵区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2802, 2791, '610118', '鄠邑区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2803, 2791, '610122', '蓝田县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2804, 2791, '610124', '周至县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2805, 2790, '610200', '铜川市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2806, 2805, '610202', '王益区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2807, 2805, '610203', '印台区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2808, 2805, '610204', '耀州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2809, 2805, '610222', '宜君县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2810, 2790, '610300', '宝鸡市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2811, 2810, '610302', '渭滨区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2812, 2810, '610303', '金台区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2813, 2810, '610304', '陈仓区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2814, 2810, '610322', '凤翔县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2815, 2810, '610323', '岐山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2816, 2810, '610324', '扶风县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2817, 2810, '610326', '眉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2818, 2810, '610327', '陇县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2819, 2810, '610328', '千阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2820, 2810, '610329', '麟游县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2821, 2810, '610330', '凤县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2822, 2810, '610331', '太白县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2823, 2790, '610400', '咸阳市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2824, 2823, '610402', '秦都区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2825, 2823, '610403', '杨陵区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2826, 2823, '610404', '渭城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2827, 2823, '610422', '三原县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2828, 2823, '610423', '泾阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2829, 2823, '610424', '乾县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2830, 2823, '610425', '礼泉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2831, 2823, '610426', '永寿县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2832, 2823, '610428', '长武县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2833, 2823, '610429', '旬邑县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2834, 2823, '610430', '淳化县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2835, 2823, '610431', '武功县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2836, 2823, '610481', '兴平市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2837, 2823, '610482', '彬州市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2838, 2790, '610500', '渭南市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2839, 2838, '610502', '临渭区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2840, 2838, '610503', '华州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2841, 2838, '610522', '潼关县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2842, 2838, '610523', '大荔县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2843, 2838, '610524', '合阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2844, 2838, '610525', '澄城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2845, 2838, '610526', '蒲城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2846, 2838, '610527', '白水县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2847, 2838, '610528', '富平县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2848, 2838, '610581', '韩城市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2849, 2838, '610582', '华阴市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2850, 2790, '610600', '延安市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2851, 2850, '610602', '宝塔区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2852, 2850, '610603', '安塞区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2853, 2850, '610621', '延长县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2854, 2850, '610622', '延川县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2855, 2850, '610625', '志丹县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2856, 2850, '610626', '吴起县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2857, 2850, '610627', '甘泉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2858, 2850, '610628', '富县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2859, 2850, '610629', '洛川县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2860, 2850, '610630', '宜川县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2861, 2850, '610631', '黄龙县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2862, 2850, '610632', '黄陵县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2863, 2850, '610681', '子长市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2864, 2790, '610700', '汉中市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2865, 2864, '610702', '汉台区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2866, 2864, '610703', '南郑区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2867, 2864, '610722', '城固县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2868, 2864, '610723', '洋县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2869, 2864, '610724', '西乡县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2870, 2864, '610725', '勉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2871, 2864, '610726', '宁强县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2872, 2864, '610727', '略阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2873, 2864, '610728', '镇巴县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2874, 2864, '610729', '留坝县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2875, 2864, '610730', '佛坪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2876, 2790, '610800', '榆林市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2877, 2876, '610802', '榆阳区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2878, 2876, '610803', '横山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2879, 2876, '610822', '府谷县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2880, 2876, '610824', '靖边县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2881, 2876, '610825', '定边县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2882, 2876, '610826', '绥德县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2883, 2876, '610827', '米脂县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2884, 2876, '610828', '佳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2885, 2876, '610829', '吴堡县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2886, 2876, '610830', '清涧县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2887, 2876, '610831', '子洲县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2888, 2876, '610881', '神木市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2889, 2790, '610900', '安康市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2890, 2889, '610902', '汉滨区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2891, 2889, '610921', '汉阴县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2892, 2889, '610922', '石泉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2893, 2889, '610923', '宁陕县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2894, 2889, '610924', '紫阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2895, 2889, '610925', '岚皋县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2896, 2889, '610926', '平利县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2897, 2889, '610927', '镇坪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2898, 2889, '610928', '旬阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2899, 2889, '610929', '白河县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2900, 2790, '611000', '商洛市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2901, 2900, '611002', '商州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2902, 2900, '611021', '洛南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2903, 2900, '611022', '丹凤县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2904, 2900, '611023', '商南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2905, 2900, '611024', '山阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2906, 2900, '611025', '镇安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2907, 2900, '611026', '柞水县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2908, 0, '620000', '甘肃省', 0, 0, 0);
INSERT INTO `tp_area` VALUES (2909, 2908, '620100', '兰州市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2910, 2909, '620102', '城关区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2911, 2909, '620103', '七里河区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2912, 2909, '620104', '西固区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2913, 2909, '620105', '安宁区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2914, 2909, '620111', '红古区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2915, 2909, '620121', '永登县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2916, 2909, '620122', '皋兰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2917, 2909, '620123', '榆中县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2918, 2908, '620200', '嘉峪关市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2919, 2908, '620300', '金昌市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2920, 2919, '620302', '金川区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2921, 2919, '620321', '永昌县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2922, 2908, '620400', '白银市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2923, 2922, '620402', '白银区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2924, 2922, '620403', '平川区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2925, 2922, '620421', '靖远县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2926, 2922, '620422', '会宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2927, 2922, '620423', '景泰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2928, 2908, '620500', '天水市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2929, 2928, '620502', '秦州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2930, 2928, '620503', '麦积区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2931, 2928, '620521', '清水县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2932, 2928, '620522', '秦安县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2933, 2928, '620523', '甘谷县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2934, 2928, '620524', '武山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2935, 2928, '620525', '张家川回族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2936, 2908, '620600', '武威市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2937, 2936, '620602', '凉州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2938, 2936, '620621', '民勤县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2939, 2936, '620622', '古浪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2940, 2936, '620623', '天祝藏族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2941, 2908, '620700', '张掖市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2942, 2941, '620702', '甘州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2943, 2941, '620721', '肃南裕固族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2944, 2941, '620722', '民乐县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2945, 2941, '620723', '临泽县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2946, 2941, '620724', '高台县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2947, 2941, '620725', '山丹县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2948, 2908, '620800', '平凉市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2949, 2948, '620802', '崆峒区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2950, 2948, '620821', '泾川县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2951, 2948, '620822', '灵台县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2952, 2948, '620823', '崇信县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2953, 2948, '620825', '庄浪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2954, 2948, '620826', '静宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2955, 2948, '620881', '华亭市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2956, 2908, '620900', '酒泉市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2957, 2956, '620902', '肃州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2958, 2956, '620921', '金塔县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2959, 2956, '620922', '瓜州县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2960, 2956, '620923', '肃北蒙古族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2961, 2956, '620924', '阿克塞哈萨克族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2962, 2956, '620981', '玉门市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2963, 2956, '620982', '敦煌市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2964, 2908, '621000', '庆阳市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2965, 2964, '621002', '西峰区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2966, 2964, '621021', '庆城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2967, 2964, '621022', '环县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2968, 2964, '621023', '华池县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2969, 2964, '621024', '合水县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2970, 2964, '621025', '正宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2971, 2964, '621026', '宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2972, 2964, '621027', '镇原县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2973, 2908, '621100', '定西市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2974, 2973, '621102', '安定区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2975, 2973, '621121', '通渭县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2976, 2973, '621122', '陇西县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2977, 2973, '621123', '渭源县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2978, 2973, '621124', '临洮县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2979, 2973, '621125', '漳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2980, 2973, '621126', '岷县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2981, 2908, '621200', '陇南市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2982, 2981, '621202', '武都区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2983, 2981, '621221', '成县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2984, 2981, '621222', '文县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2985, 2981, '621223', '宕昌县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2986, 2981, '621224', '康县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2987, 2981, '621225', '西和县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2988, 2981, '621226', '礼县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2989, 2981, '621227', '徽县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2990, 2981, '621228', '两当县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2991, 2908, '622900', '临夏回族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (2992, 2991, '622901', '临夏市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2993, 2991, '622921', '临夏县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2994, 2991, '622922', '康乐县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2995, 2991, '622923', '永靖县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2996, 2991, '622924', '广河县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2997, 2991, '622925', '和政县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2998, 2991, '622926', '东乡族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (2999, 2991, '622927', '积石山保安族东乡族撒拉族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3000, 2908, '623000', '甘南藏族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3001, 3000, '623001', '合作市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3002, 3000, '623021', '临潭县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3003, 3000, '623022', '卓尼县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3004, 3000, '623023', '舟曲县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3005, 3000, '623024', '迭部县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3006, 3000, '623025', '玛曲县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3007, 3000, '623026', '碌曲县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3008, 3000, '623027', '夏河县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3009, 0, '630000', '青海省', 0, 0, 0);
INSERT INTO `tp_area` VALUES (3010, 3009, '630100', '西宁市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3011, 3010, '630102', '城东区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3012, 3010, '630103', '城中区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3013, 3010, '630104', '城西区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3014, 3010, '630105', '城北区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3015, 3010, '630106', '湟中区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3016, 3010, '630121', '大通回族土族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3017, 3010, '630123', '湟源县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3018, 3009, '630200', '海东市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3019, 3018, '630202', '乐都区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3020, 3018, '630203', '平安区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3021, 3018, '630222', '民和回族土族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3022, 3018, '630223', '互助土族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3023, 3018, '630224', '化隆回族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3024, 3018, '630225', '循化撒拉族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3025, 3009, '632200', '海北藏族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3026, 3025, '632221', '门源回族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3027, 3025, '632222', '祁连县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3028, 3025, '632223', '海晏县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3029, 3025, '632224', '刚察县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3030, 3009, '632300', '黄南藏族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3031, 3030, '632321', '同仁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3032, 3030, '632322', '尖扎县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3033, 3030, '632323', '泽库县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3034, 3030, '632324', '河南蒙古族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3035, 3009, '632500', '海南藏族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3036, 3035, '632521', '共和县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3037, 3035, '632522', '同德县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3038, 3035, '632523', '贵德县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3039, 3035, '632524', '兴海县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3040, 3035, '632525', '贵南县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3041, 3009, '632600', '果洛藏族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3042, 3041, '632621', '玛沁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3043, 3041, '632622', '班玛县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3044, 3041, '632623', '甘德县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3045, 3041, '632624', '达日县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3046, 3041, '632625', '久治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3047, 3041, '632626', '玛多县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3048, 3009, '632700', '玉树藏族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3049, 3048, '632701', '玉树市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3050, 3048, '632722', '杂多县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3051, 3048, '632723', '称多县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3052, 3048, '632724', '治多县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3053, 3048, '632725', '囊谦县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3054, 3048, '632726', '曲麻莱县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3055, 3009, '632800', '海西蒙古族藏族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3056, 3055, '632801', '格尔木市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3057, 3055, '632802', '德令哈市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3058, 3055, '632803', '茫崖市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3059, 3055, '632821', '乌兰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3060, 3055, '632822', '都兰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3061, 3055, '632823', '天峻县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3062, 0, '640000', '宁夏回族自治区', 0, 0, 0);
INSERT INTO `tp_area` VALUES (3063, 3062, '640100', '银川市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3064, 3063, '640104', '兴庆区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3065, 3063, '640105', '西夏区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3066, 3063, '640106', '金凤区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3067, 3063, '640121', '永宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3068, 3063, '640122', '贺兰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3069, 3063, '640181', '灵武市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3070, 3062, '640200', '石嘴山市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3071, 3070, '640202', '大武口区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3072, 3070, '640205', '惠农区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3073, 3070, '640221', '平罗县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3074, 3062, '640300', '吴忠市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3075, 3074, '640302', '利通区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3076, 3074, '640303', '红寺堡区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3077, 3074, '640323', '盐池县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3078, 3074, '640324', '同心县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3079, 3074, '640381', '青铜峡市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3080, 3062, '640400', '固原市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3081, 3080, '640402', '原州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3082, 3080, '640422', '西吉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3083, 3080, '640423', '隆德县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3084, 3080, '640424', '泾源县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3085, 3080, '640425', '彭阳县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3086, 3062, '640500', '中卫市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3087, 3086, '640502', '沙坡头区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3088, 3086, '640521', '中宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3089, 3086, '640522', '海原县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3090, 0, '650000', '新疆维吾尔自治区', 0, 0, 0);
INSERT INTO `tp_area` VALUES (3091, 3090, '650100', '乌鲁木齐市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3092, 3091, '650102', '天山区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3093, 3091, '650103', '沙依巴克区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3094, 3091, '650104', '新市区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3095, 3091, '650105', '水磨沟区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3096, 3091, '650106', '头屯河区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3097, 3091, '650107', '达坂城区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3098, 3091, '650109', '米东区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3099, 3091, '650121', '乌鲁木齐县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3100, 3090, '650200', '克拉玛依市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3101, 3100, '650202', '独山子区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3102, 3100, '650203', '克拉玛依区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3103, 3100, '650204', '白碱滩区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3104, 3100, '650205', '乌尔禾区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3105, 3090, '650400', '吐鲁番市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3106, 3105, '650402', '高昌区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3107, 3105, '650421', '鄯善县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3108, 3105, '650422', '托克逊县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3109, 3090, '650500', '哈密市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3110, 3109, '650502', '伊州区', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3111, 3109, '650521', '巴里坤哈萨克自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3112, 3109, '650522', '伊吾县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3113, 3090, '652300', '昌吉回族自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3114, 3113, '652301', '昌吉市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3115, 3113, '652302', '阜康市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3116, 3113, '652323', '呼图壁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3117, 3113, '652324', '玛纳斯县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3118, 3113, '652325', '奇台县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3119, 3113, '652327', '吉木萨尔县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3120, 3113, '652328', '木垒哈萨克自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3121, 3090, '652700', '博尔塔拉蒙古自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3122, 3121, '652701', '博乐市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3123, 3121, '652702', '阿拉山口市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3124, 3121, '652722', '精河县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3125, 3121, '652723', '温泉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3126, 3090, '652800', '巴音郭楞蒙古自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3127, 3126, '652801', '库尔勒市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3128, 3126, '652822', '轮台县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3129, 3126, '652823', '尉犁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3130, 3126, '652824', '若羌县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3131, 3126, '652825', '且末县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3132, 3126, '652826', '焉耆回族自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3133, 3126, '652827', '和静县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3134, 3126, '652828', '和硕县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3135, 3126, '652829', '博湖县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3136, 3090, '652900', '阿克苏地区', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3137, 3136, '652901', '阿克苏市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3138, 3136, '652902', '库车市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3139, 3136, '652922', '温宿县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3140, 3136, '652924', '沙雅县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3141, 3136, '652925', '新和县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3142, 3136, '652926', '拜城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3143, 3136, '652927', '乌什县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3144, 3136, '652928', '阿瓦提县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3145, 3136, '652929', '柯坪县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3146, 3090, '653000', '克孜勒苏柯尔克孜自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3147, 3146, '653001', '阿图什市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3148, 3146, '653022', '阿克陶县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3149, 3146, '653023', '阿合奇县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3150, 3146, '653024', '乌恰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3151, 3090, '653100', '喀什地区', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3152, 3151, '653101', '喀什市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3153, 3151, '653121', '疏附县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3154, 3151, '653122', '疏勒县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3155, 3151, '653123', '英吉沙县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3156, 3151, '653124', '泽普县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3157, 3151, '653125', '莎车县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3158, 3151, '653126', '叶城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3159, 3151, '653127', '麦盖提县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3160, 3151, '653128', '岳普湖县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3161, 3151, '653129', '伽师县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3162, 3151, '653130', '巴楚县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3163, 3151, '653131', '塔什库尔干塔吉克自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3164, 3090, '653200', '和田地区', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3165, 3164, '653201', '和田市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3166, 3164, '653221', '和田县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3167, 3164, '653222', '墨玉县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3168, 3164, '653223', '皮山县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3169, 3164, '653224', '洛浦县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3170, 3164, '653225', '策勒县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3171, 3164, '653226', '于田县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3172, 3164, '653227', '民丰县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3173, 3090, '654000', '伊犁哈萨克自治州', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3174, 3173, '654002', '伊宁市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3175, 3173, '654003', '奎屯市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3176, 3173, '654004', '霍尔果斯市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3177, 3173, '654021', '伊宁县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3178, 3173, '654022', '察布查尔锡伯自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3179, 3173, '654023', '霍城县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3180, 3173, '654024', '巩留县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3181, 3173, '654025', '新源县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3182, 3173, '654026', '昭苏县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3183, 3173, '654027', '特克斯县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3184, 3173, '654028', '尼勒克县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3185, 3090, '654200', '塔城地区', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3186, 3185, '654201', '塔城市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3187, 3185, '654202', '乌苏市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3188, 3185, '654221', '额敏县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3189, 3185, '654223', '沙湾县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3190, 3185, '654224', '托里县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3191, 3185, '654225', '裕民县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3192, 3185, '654226', '和布克赛尔蒙古自治县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3193, 3090, '654300', '阿勒泰地区', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3194, 3193, '654301', '阿勒泰市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3195, 3193, '654321', '布尔津县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3196, 3193, '654322', '富蕴县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3197, 3193, '654323', '福海县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3198, 3193, '654324', '哈巴河县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3199, 3193, '654325', '青河县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3200, 3193, '654326', '吉木乃县', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3201, 3090, '659001', '石河子市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3202, 3090, '659002', '阿拉尔市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3203, 3090, '659003', '图木舒克市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3204, 3090, '659004', '五家渠市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3205, 3090, '659005', '北屯市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3206, 3090, '659006', '铁门关市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3207, 3090, '659007', '双河市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3208, 3090, '659008', '可克达拉市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3209, 3090, '659009', '昆玉市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3210, 3090, '659010', '胡杨河市', 2, 0, 0);
INSERT INTO `tp_area` VALUES (3211, 0, '710000', '中国台湾', 0, 0, 0);
INSERT INTO `tp_area` VALUES (3212, 0, '810000', '中国香港', 0, 0, 0);
INSERT INTO `tp_area` VALUES (3213, 0, '820000', '中国澳门', 0, 0, 0);
INSERT INTO `tp_area` VALUES (3216, 1, '110010', '北京市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3217, 18, '120010', '天津市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3218, 780, '310010', '上海市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3219, 2220, '500010', '重庆市', 1, 0, 0);
INSERT INTO `tp_area` VALUES (3220, NULL, '', '', NULL, 0, 0);

-- ----------------------------
-- Table structure for tp_article
-- ----------------------------
DROP TABLE IF EXISTS `tp_article`;
CREATE TABLE `tp_article`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `sort` mediumint(8) NULL DEFAULT 50 COMMENT '排序',
  `status` tinyint(1) NULL DEFAULT NULL COMMENT '状态',
  `cate_id` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '栏目',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '作者',
  `source` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '来源',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',
  `summary` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '摘要',
  `image` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '图片集',
  `download` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文件下载',
  `tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'TAG',
  `hits` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '点击次数',
  `keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '关键词',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '描述',
  `template` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '模板',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '跳转地址',
  `view_auth` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '阅读权限',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '文章模块' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_article
-- ----------------------------
INSERT INTO `tp_article` VALUES (1, 1581052220, 1581052220, 50, 1, 5, '为什么学习PHP？', '未知', 'php中文网', '<p>回答本书的几个问题吧。你到底，为什么要学习PHP？</p>\n\n<p>全国都缺PHP人才，非常好就业，PHP现在的工资水平很高，刚毕业可以拿到5000-9000每个月，特别优秀还可以破万。并且有非常多的就业机会。</p>\n\n<p>PHP入门简单，学习入门易入手。</p>\n\n<p>很多人反馈上完大学的C语言课程、java课程不会写任何东西。<br />\n诚然，中国的大学都以C语言作为主要的入门语言。但是，我们认为PHP是最简单入门，也是最合适入门的语言。</p>\n\n<p>你将学习到编程的思路，更加程序化的去处理问题。处理问题，将会更加规范化。</p>\n\n<p>如果你要创业，如果你要与互联网人沟通。未来互联网、移动互联网、信息化将会进一步围绕在你身边。你需要与人沟通，与人打交道。</p>\n\n<p>还有机会进入BAT（百度、阿里、腾讯），BAT这些企业他们在用PHP。国内和国外超一线的互联网公司，在超过90%在使用PHP来做手机API或者是网站。连微信等开放平台中的公众号的服务端也可以使用到PHP。</p>\n\n<p>大并发，还能免费。一天1个亿的访问量怎么办？PHP拥有大量优秀的开发者，在一定数据量的情况下完全能满足你的需求。国内外一线的互联网公司，很多将自己的大并发方案进行开源了。你可以免费获得很多成熟的、免费的、开源的大并发解决方案。</p>\n\n<p>开源更加节约成本也更加安全。windows很多都要收取授权费用，而使用linux的LAMP架构或者LNMP架构会更加安全。全球的黑客在帮你找漏洞。全球的工程师在帮忙修复漏洞。你发现一个他人已经消灭10个。</p>\n', '回答本书的几个问题吧。你到底，为什么要学习PHP？\n全国都缺PHP人才，非常好就业，PHP现在的工资水平很高，刚毕业可以拿到5000-9000每个月，特别优秀还可以破万。并且有非常多的就业机会。', '/uploads/20181224/168eb2135c7abbc3f2efcad91c7106e3.jpg', '', '', 'php', 0, '', '', '', '', 0);
INSERT INTO `tp_article` VALUES (2, 1581052888, 1581052888, 50, 1, 5, 'PHP是什么', '未知', 'php中文网', '<p>PHP（外文名:PHP: Hypertext Preprocessor，中文名：&ldquo;超文本预处理器&rdquo;）是一种通用开源脚本语言。语法吸收了C语言、Java和Perl的特点，利于学习，使用广泛，主要适用于Web开发领域。</p>\n\n<p>用PHP做出的动态页面与其他的编程语言相比，PHP是将程序嵌入到HTML（标准通用标记语言下的一个应用）文档中去执行，执行效率比完全生成HTML标记的CGI要高许多；PHP还可以执行编译后代码，编译可以达到加密和优化代码运行，使代码运行更快。</p>\n\n<p>全球市场分析</p>\n\n<p>目前PHP在全球网页市场、手机网页市场还有为手机提供API（程序接口）排名第一。</p>\n\n<p>在中国微信开发大量使用PHP来进行开发。</p>\n', 'PHP（外文名:PHP: Hypertext Preprocessor，中文名：“超文本预处理器”）是一种通用开源脚本语言。语法吸收了C语言、Java和Perl的特点，利于学习，使用广泛，主要适用于Web开发领域。', '/uploads/20181224/fc3112ab0fab9f255726674dc1fd0d17.jpg', '', '', 'PHP', 0, '', '', '', '', 0);
INSERT INTO `tp_article` VALUES (3, 1581052950, 1581052950, 50, 1, 5, '零基础也能学习', '未知', 'php中文网', '<p>学习PHP前很多人担心PHP是不是能真的学会。</p>\n\n<p>学习PHP学历要求不高，数学水平要求也不高，只需要会下面这些，你就可以跟着PHP中文网，开始愉快、高薪的PHP学习之旅：</p>\n\n<p>有一台电脑</p>\n\n<p>初中及以上文化水平</p>\n\n<p>必须会打字（五笔、拼音均可）</p>\n\n<p>会word（微软的office办公软件中的文字编辑软件）</p>\n\n<p>会上网（QQ，写邮件，玩微信，看小说，看电影，注册网站帐号，网上购物等）</p>\n\n<p>有一颗坚持的心</p>\n\n<p>如果会一点html就更好了.学习HTML可以去看我们开源的另外一本HTML入门书籍。</p>\n\n<p>不会HTML怎么办？也可以学习我们免费的HTML入门视频。</p>\n', '学习PHP前很多人担心PHP是不是能真的学会。\n学习PHP学历要求不高，数学水平要求也不高，只需要会下面这些，你就可以跟着PHP中文网，开始愉快、高薪的PHP学习之旅：\n有一台电脑', '/uploads/20181224/894485902f96b13551b5450c7ddca081.jpg', '', '', '零基础', 0, '', '', '', '', 0);
INSERT INTO `tp_article` VALUES (4, 1581053047, 1581053047, 50, 1, 5, '为什么有些人学不会', '未知', 'php中文网', '<p>互联网进入到人们生活中的方方面面了，世界首富比尔盖茨多次提到青少年编程，而编程是一种思维习惯的转化。</p>\n\n<p>作为写了10几年程序的人，我听到过一些说编程不好学的抱怨。</p>\n\n<p>从目前见到的数据统计，主要是因为在大学学习时遇到了C语言，学完后还不知道能干什么。很多人大学上完也就这么糊涂、恐惧的就过来了。</p>\n\n<p>只有很少的不到1%的人学不会，这部份往往是专业的艺术家，在艺术家里面极少一部份人外，他们的思维模式和我们遇到的大多数人不太一样，并且不进行编程思维的训练，所以学不会。</p>\n\n<p>而造成这个原因主要是因为社会、文化、背景、生活圈子多方面造成的。而不是因为笨。</p>\n\n<p>那我们绝大多数的人是哪些原因学不会的呢？</p>\n\n<p>1. 不相信自己能学会</p>\n\n<p>这一块很多人可能不相信，涉及到很深的心理学知识。与心理暗示、诅咒的原理一样。</p>\n\n<p>如果不相信自己能够学好，心里潜意识的念头里如果总是：PHP很难，我学不会。那么这个人肯定很难学会。</p>\n\n<p>把不相信自己能学会的负面情绪和观念给抛掉。</p>\n\n<p>只要你每天练习代码并相信自己。你肯定能学会，并且能学得很好，代码写的很成功，成为大牛！</p>\n\n<p>2. 懒</p>\n\n<p>人的天性有善有恶，而学不好程序的人，身上的一个通病，只有一个字就是&mdash;&mdash;&mdash;&mdash;懒！<br />\n基本语法，需要去背<br />\n函数需要去默写</p>\n\n<p>3. 自以为是</p>\n\n<p>一看就会，一写就错。以为自己是神童。</p>\n\n<p>4. 英文单词</p>\n\n<p>计算机里面常用的英文单词就那么一些。</p>\n\n<p>不要找英语的借口。本书会把英语单词都会跟你标注出来。看到不会的，就去翻一翻。</p>\n\n<p>5. 不坚持</p>\n\n<p>学着学着就放弃了。</p>\n\n<p>6. 不去提问，不会提问，不去思考</p>\n\n<p>解决问题前，先去搜索</p>\n\n<p>搜索解决不了再去提问</p>\n\n<p>PHP学院为大家准备了视频，也为大家准备了问答中心。</p>\n\n<p>大多数的人，不把问题详述清楚，不把错误代码贴完整。</p>\n\n<p>张嘴就来提问。我想神仙也不知道你的问题是什么吧？问题发出来前。换位思考一下自己看不看得懂这个问题。</p>\n\n<p>7. 你还需要自我鼓励</p>\n\n<p>在学习过程中，你会否定自己。其实任何人都会。大多数人都会遇到跟你一样的困难。只不过他们在克服困难，而一些人在逃避困难。</p>\n\n<p>学累的时候，放松一会儿。再去多读几遍。不断的告诉自己，你就是最棒的！</p>\n\n<p>学会交流和倾诉而非抱怨，并且不断的自我鼓励</p>\n', '', '/uploads/20181224/b640f82ccf862c3b34e11f792220a1f5.jpg', '', '', '不会', 0, '', '', '', '', 0);
INSERT INTO `tp_article` VALUES (5, 1581053131, 1581053131, 50, 1, 5, '开发环境是什么？', '未知', 'php中文网', '<p>PHP是一门开发语言。而开发语言写出来的代码，通常需要在指定的软件下才能运行。因此，我们写好的代码需要（运行）显示出来看到，就需要安装这几个软件来运行代码。</p>\n\n<p>我们把运行我们写代码的几个软件和运行代码的软件统一都可称为开发环境。</p>\n\n<p>新手学习前常遇到的环境问题</p>\n\n<p>很多朋友最开始学习的时候，听说某个环境好就安装某些软件。由于缺乏相关知识，所以没有主见。陷入人云即云的怪圈里。今天换这个，明天换那个。</p>\n\n<p>当前验证真理的唯一标准，请始终保证一点：</p>\n\n<p>环境能满足你的学习需求。不要在环境上面反复纠结，耽误宝贵的学习时间。</p>\n\n<p>我们认为环境只要能满足学习要求即可。等学会了后，再去着磨一些更加复杂的互联网线上的、生产环境中的具体配置。</p>\n', 'PHP是一门开发语言。而开发语言写出来的代码，通常需要在指定的软件下才能运行。因此，我们写好的代码需要（运行）显示出来看到，就需要安装这几个软件来运行代码。', '/uploads/20181224/a11e9ab3e8dc289dca70a105a7f177ee.jpg', '', '', '开发环境', 0, '', '', '', '', 0);
INSERT INTO `tp_article` VALUES (6, 1581053179, 1581053179, 50, 1, 5, 'windows环境安装', '未知', 'php中文网', '<p>所谓服务器：不要把它想的太过于高深，不过就是提供一项特殊功能（服务）的电脑而已。</p>\n\n<p>显示网页的叫网页(web)服务器（server）。</p>\n\n<p>帮我们代为收发电子邮件(Email)的服务器叫邮件服务器。</p>\n\n<p>帮我们把各个游戏玩家连接在一起的叫游戏服务器。</p>\n\n<p>帮我们存储数据的叫数据库服务器</p>\n\n<p>... ...等等</p>\n\n<p>我们现在使用的一部手机的性能比10年前的一台电脑和服务器的性能还要强劲、给力。</p>\n\n<p>而我们的学习过程当中完全可以把自己使用的这一台windows电脑作为服务器来使用。</p>\n\n<p>原来如此，一讲就通了吧？</p>\n\n<p>我们大多数人使用的电脑通常是windows操作系统的电脑。而我们的讲解主要在windows电脑上进行。</p>\n\n<p>你不需要去理解所谓高深的电脑知识、操作系统原型等。在这一章节当中，你只需要会安装QQ、杀毒软件一样，点击：下一步、下一步即可完成本章的学习。</p>\n\n<p>在最开始学习时，我们强烈建议初学者使用集成环境包进行安装。</p>\n\n<p>什么是集成环境包？</p>\n\n<p>我们学习PHP要安装的东西有很多。例如：网页服务器、数据库服务器和PHP语言核心的解释器。</p>\n\n<p>我们可以分开安装各部份，也可以合在一起安装一个集成好的软件。</p>\n\n<p>将这些合在一起的一个软件我们就叫作：集成环境包。</p>\n\n<p>这个过程需要修改很多配置文件才能完成。并且每个人的电脑情况，权限，经常容易操作出错。</p>\n\n<p>很容易因为环境问题影响到心情，我们的学习计划在初期非常绝对化：</p>\n\n<p>请使用集成环境包完成最开始的学习。</p>\n\n<p>等你学好PHP NB后，你爱用啥用啥，网上成堆的文章教你配置各种环境。</p>\n\n<p>选用什么样的集成环境包？</p>\n\n<p>集成环境包比较多。以下的这些全是各种英文名。只不过代表的是不同集成环境包的名字，不用去深纠。如下所示：</p>\n\n<p>AppServ</p>\n\n<p>PHPStudy</p>\n\n<p>APMserv</p>\n\n<p>XAMPP</p>\n\n<p>WAMPServer<br />\n... ...等等</p>\n\n<p>对于我们才入门的学习者来说，选择集成环境包的原则：</p>\n\n<p>更新快，版本比较新</p>\n\n<p>操作简单易于上手</p>\n\n<p>选择项不要过多</p>\n\n<p>因此，我们下面使用的集成环境包是：PHPstudy。当然，如果你对此块很熟悉了，也可以自行选择选择集成环境包。</p>\n\n<p>可以以在官方网址下载：<br />\nhttp://www.phpstudy.net/&nbsp;</p>\n\n<p>也可以在百度中搜索：*PHPstudy *&nbsp;&nbsp;这个5个字文字母进行下载。</p>\n\n<p>对学习PHP的新手来说，WINDOWS下PHP环境配置是一件很困难的事，就是老手也是一件烦琐的事。因此，无论你是新手还是老手，phpStudy 2016都是一个不错的选择，该程序集成Apache+PHP+MySQL+phpMyAdmin+ZendOptimizer，最新版本已集成最新的&nbsp;PHP7。</p>\n', '所谓服务器：不要把它想的太过于高深，不过就是提供一项特殊功能（服务）的电脑而已。\n显示网页的叫网页(web)服务器（server）。', '/uploads/20181224/f5421f965b0f46d9c1b8f1a927df7894.jpg', '', '', '开发环境', 0, '', '', '', '', 0);
INSERT INTO `tp_article` VALUES (7, 1581053231, 1581053231, 50, 1, 5, 'Linux环境安装', '未知', 'php中文网', '<p>这一个章节是本书中永远不会写的一个章节，很多人被一些市面上的书籍误导，认为学习PHP前要学习Linux。结果，一看Linux，就对人生和学习失去了希望。我们作为有过10年以上开发经验和内部训经验的专业人士告戒各位：</p>\n\n<p>Linux学习与PHP学习没有必然的联系，这是两个不同的知识体系。</p>\n\n<p>作为有多年开发经验和教学经验的我们。</p>\n\n<p>我们强烈不建议没有接触过Linux的学生，为了学习PHP而去安装Linux环境</p>\n\n<p>如果您有经验，我们相信你一定能解决，如果解决不了。</p>\n\n<p>请加QQ群和访问官网：PHP中文网&nbsp;学习视频和提问。</p>\n', '这一个章节是本书中永远不会写的一个章节，很多人被一些市面上的书籍误导，认为学习PHP前要学习Linux。结果，一看Linux，就对人生和学习失去了希望。我们作为有过10年以上开发经验和内部训经验的专业人士告戒各位：', '/uploads/20181224/5cd61fb68c8bc8fe6d24be4229ec0ca5.jpg', '', '', '开发环境', 0, '', '', '', '', 0);
INSERT INTO `tp_article` VALUES (8, 1581054083, 1581054083, 50, 1, 5, '其他开发环境', '未知', 'php中文网', '<p>对本章不感兴趣，可以略过，只是介绍和说明。</p>\n\n<p>其他开发环境有很多：</p>\n\n<p>1，比如 苹果电脑的系统 Mac os</p>\n\n<p>2，比如 &nbsp;在线环境（你使用了百度、新浪、阿里等云计算环境）</p>\n\n<p>3，其他更多... ...</p>\n\n<p>当然，你甚至可以使用安卓手机和苹果手机来部署你的开发环境。就像有些人可以在各种复杂的环境，甚至U衣酷的试衣间里M..L。我想，这应该不是正常人类该进行的尝试吧。</p>\n\n<p>如果你在使用这些环境遇到了问题，相信你已经有过一定的开发经验和处理问题的经验了，这不是刚开始学习编程该掌握的内容。</p>\n\n<p>但是，如果你真遇到了这些问题。你可以上PHP中文网来提问。</p>\n', '对本章不感兴趣，可以略过，只是介绍和说明。\n其他开发环境有很多：\n1，比如 苹果电脑的系统 Mac os\n2，比如  在线环境（你使用了百度、新浪、阿里等云计算环境）\n3，其他更多... ...', '', '', '', '开发环境,其他', 0, '', '', '', '', 0);
INSERT INTO `tp_article` VALUES (9, 1581054168, 1581054168, 50, 1, 5, '写代码的工具选择', '未知', 'php中文网', '<p>写代码的工具有很多。对于刚开始学习PHP的朋友来说。选择工具有几个原则：</p>\n\n<p>1，不要使用带自动提示的工具（例如eclipse、zend studio等PHP开发工具集）</p>\n\n<p>2，写完的代码必须要有颜色高亮显示。（不能使用：txt文本编辑器等无代码颜色显示的编辑器）</p>\n\n<p>你可能想问，为什么呀？</p>\n\n<p>我们发现电视、电影和现实生活中的编程高手，噼里哗啦就写一堆代码，一点都不报错，点击就能运行。而我们对着他们的代码抄袭反倒抄错。这种感觉特别不好！！！</p>\n\n<p>&mdash;&mdash;传说中的这些高手，他们都曾经在基础代码上反复练习过，所以他们不会写错。</p>\n\n<p>而我们需要高手之境界，在学习初期就不能使用先进的工具。这样会浪费我们保贵的练习代码的机会、调试错误的机会。</p>\n\n<p>因为先进的编辑器通常有很多先进的功能，例如：</p>\n\n<p>代码自动显示错误</p>\n\n<p>代码自动换行</p>\n\n<p>这些先进的工具，对于开始入门学习的你，不利于新手产生独立解决问题的能力！</p>\n\n<p>推荐的开发工具</p>\n\n<p>1. NotePad++&nbsp;</p>\n\n<p>https://notepad-plus-plus.org/&nbsp;由于某些不可抗的原因，请使用百度搜索NotePad++&nbsp;</p>\n\n<p>2.phpstorm（强烈推荐）</p>\n\n<p>https://www.jetbrains.com/phpstorm/&nbsp;</p>\n\n<p>这些工具，你只需要下载下来，一直点击下一步，安装到你的电脑上即可。</p>\n', '写代码的工具有很多。对于刚开始学习PHP的朋友来说。选择工具有几个原则：\n1，不要使用带自动提示的工具（例如eclipse、zend studio等PHP开发工具集）\n2，写完的代码必须要有颜色高亮显示。（不能使用：txt文本编辑器等无代码颜色显示的编辑器）', '', '', '', '代码工具', 0, '', '', '', '', 0);
INSERT INTO `tp_article` VALUES (10, 1581054212, 1581054212, 50, 1, 5, 'php中的变量－读过初中你就会变量', '未知', 'php中文网', '<p>大家在读初中的时候呀。老师经常会这么教大家。</p>\n\n<p>请问，李磊和韩梅梅同学，假如：</p>\n\n<p>x&nbsp;=&nbsp;5<br />\ny&nbsp;=&nbsp;6</p>\n\n<p>那么x + y 等于多少呢？大家会义无反顾的回答。x + y 等于11。</p>\n\n<p>接下来我们看下面的初中的数学知识，请问x + y 的结果是多少？</p>\n\n<p>x&nbsp;=&nbsp;5<br />\ny&nbsp;=&nbsp;6<br />\nx&nbsp;＝&nbsp;8</p>\n\n<p>我估计大家也会义无反顾的回答：x + y 的结果为14。</p>\n\n<p>这就是变量！</p>\n\n<p>变量的几个特点：</p>\n\n<p>1.x = 5 将右边值5，赋值给左边的x</p>\n\n<p>2.第二段x ＝ 8，最后x + y 的结果等于14，说明x在从上到下的运算（执行）中，可以被重新赋值。</p>\n\n<p>我们在PHP中的变量也是如此。不过有几个特点：</p>\n\n<p>1.必须要以$开始。如变量x必须要写成$x</p>\n\n<p>2.变量的首字母不能以数字开始</p>\n\n<p>3.变量的名字区分大小写</p>\n\n<p>4.变量不要用特殊符号、中文，_不算特殊符号</p>\n\n<p>5.变量命名要有意义（别写xxx，aaa，ccc这种 变量名）</p>\n\n<p>错误举列：</p>\n\n<p>错误：变量以数字开始</p>\n\n<p><!--?php<br/-->$123&nbsp;=&nbsp;345;<br />\n?&gt;</p>\n\n<p>错误：变量中有特殊字符，中文</p>\n\n<p><!--?php<br/-->//$a*d&nbsp;=&nbsp;345;<br />\n<br />\n//$中国&nbsp;=&nbsp;123;<br />\n?&gt;</p>\n\n<p>错误：变量命名没有意义aaa容易数错，也没有含意</p>\n\n<p><!--?php<br/-->$aaaaaaa&nbsp;=&nbsp;345;<br />\n?&gt;</p>\n\n<p>错误：变量严格区分大小写 $dog 和 $Dog是PHP学院的变量,尝试将$dog的值改为8.结果D写成了大写。</p>\n\n<p><!--?php<br/-->$dog&nbsp;=&nbsp;5;<br />\n//重新修改$dog的值，将$dog改为8<br />\n$Dog&nbsp;=&nbsp;8;<br />\n?&gt;</p>\n\n<p>正确举例：</p>\n\n<p>正确：变量不能以数字开始,但是数字可以夹在变量名中间和结尾</p>\n\n<p><!--?php<br/-->$iphone6&nbsp;=&nbsp;5880;<br />\n$iphone6plus&nbsp;=&nbsp;6088;<br />\n?&gt;</p>\n\n<p>正确：变量不能有特殊符号，但是_(下划线不算特殊符号)</p>\n\n<p><!--?php<br/-->$_cup&nbsp;=&nbsp;123;<br />\n?&gt;</p>\n\n<p>注：你会发现代码是从上向下执行的。</p>\n\n<p>$ 叫作美元符，英文单词：dollar。PHP的变量必须以美元符开始。说明搞PHP有&ldquo;钱&rdquo;途。</p>\n\n<p>dollar<br />\n读音：[&#39;dɒlə(r)]<br />\n解释：美元</p>\n', '大家在读初中的时候呀。老师经常会这么教大家。\n请问，李磊和韩梅梅同学，假如：', '', '', '', 'PHP变量', 0, '', '', '', '', 0);
INSERT INTO `tp_article` VALUES (11, 1581054249, 1581054249, 50, 1, 5, 'echo 显示命令', '未知', 'php中文网', '<p>echo 是在PHP里面最常用的一个输出、显示功能的命令。</p>\n\n<p>我们可以让他显示任何可见的字符。</p>\n\n<p><!--?php<br/--><br />\necho&nbsp;123;<br />\n<br />\n?&gt;<br />\n<!--?php<br/--><br />\n$iphone&nbsp;=&nbsp;6088;<br />\n<br />\necho&nbsp;$iphone;<br />\n<br />\n?&gt;</p>\n\n<p>你可以对着做做实验。等下一章，我们讲数据类型的时候，我教大家输出中文和用PHP显示网页内容。</p>\n\n<p>单词：</p>\n\n<p>*echo *&nbsp;读音： [&#39;ekoʊ]<br />\n解释：发出回声；回响。<br />\n功能解释：输出、显示</p>\n', 'echo 是在PHP里面最常用的一个输出、显示功能的命令。\n我们可以让他显示任何可见的字符。', '', '', '', 'echo,echo命令', 0, '', '', '', '', 0);
INSERT INTO `tp_article` VALUES (12, 1581054302, 1581054302, 50, 1, 5, 'php注释的学习', '未知', 'php中文网', '<p>注释的功能很强大</p>\n\n<p>所谓注释，汉语解释可以为：注解。更为准确一些。<br />\n因为代码是英文的、并且代码很长，时间长了人会忘。<br />\n所以我们会加上注释。</p>\n\n<p>注释的功能有很多：</p>\n\n<p>&nbsp;&nbsp;&nbsp;&nbsp;1.对重点进行标注</p>\n\n<p>&nbsp;&nbsp;&nbsp;&nbsp;2.时间长了容易忘快速回忆，方便查找</p>\n\n<p>&nbsp;&nbsp;&nbsp;&nbsp;3.让其他人看的时候快速看懂</p>\n\n<p>&nbsp;&nbsp;&nbsp;&nbsp;4.还可以生成文档，代码写完相关的文档就写完了，提高工作效率</p>\n\n<p>&nbsp;&nbsp;&nbsp;&nbsp;5.注释、空行、回车之后的代码看起来更优美</p>\n\n<p>&nbsp;&nbsp;&nbsp;&nbsp;6.注释可用来排错。不确定代码中哪一块写错了，可以将一大段注释，确定错误区间</p>\n\n<p>&nbsp;&nbsp;&nbsp;&nbsp;7.注释中间的部份的内容，电脑不会执行它</p>\n\n<p>先给大家看看我们觉得优美的代码，整齐、规范、说明清楚、一看就懂。（不需要理解代码的含义）：</p>\n\n<p>&nbsp;</p>\n\n<p>再看看我们眼中觉得丑陋的代码，对齐丑陋不说，并且没有功能说明（不需要理解代码的含义）：</p>\n\n<p>&nbsp;</p>\n\n<p>我们了解了注释的好处，接下来我们来说PHP的注释，注释分别：</p>\n\n<p>单行注释（只注释一行）</p>\n\n<p>多行注释（注释多行）</p>\n\n<p>单行注释</p>\n\n<p>//&nbsp;&nbsp;&nbsp;表示单行注释<br />\n#&nbsp;&nbsp;&nbsp;&nbsp;#号也表示单行注释，用的比较少</p>\n\n<p>多行注释</p>\n\n<p>/*&nbsp;<br />\n多行注释&nbsp;这里是注释区域代码<br />\n&nbsp;*/</p>\n\n<p>单行注释举例：</p>\n\n<p><!--?php<br/--><br />\n//声明一部iphone6手机的价格变量<br />\n$iphone6_price&nbsp;=&nbsp;6088;<br />\n<br />\n//显示输出手机价格<br />\necho&nbsp;$iphone6_price;<br />\n?&gt;</p>\n\n<p>注：通过上例我们知道，注释通常写代码上面。</p>\n\n<p>多行注释举例：</p>\n\n<p><!--?php<br/-->/*<br />\n作者：PHP中文网<br />\n时间：2048.12.23<br />\n功能：这是一个假的多行注释的例子<br />\n*/<br />\n<br />\n/*<br />\n&nbsp;&nbsp;声明一个爱情变量<br />\n&nbsp;&nbsp;$love&nbsp;是指爱情<br />\n&nbsp;&nbsp;爱情是一个变量，因为人的爱总是在发生变化<br />\n&nbsp;&nbsp;所以，爱情变量的值为250<br />\n*/<br />\n$love&nbsp;=&nbsp;250;<br />\n<br />\n?&gt;</p>\n\n<p>注：通过上面的例子我们发现，我们要写上很多注释的时候，释用多行注释。</p>\n\n<p>注：暂进不讲解如何通过专门的工具生成注释</p>\n', '注释的功能很强大\n所谓注释，汉语解释可以为：注解。更为准确一些。\n因为代码是英文的、并且代码很长，时间长了人会忘。', '/uploads/20181224/2d208c7893a9981a6216b83ef9fcb11f.jpg', '', '', 'php,php注释', 0, '', '', '', '', 0);
INSERT INTO `tp_article` VALUES (13, 1581054369, 1581054369, 50, 1, 5, 'php整型就是整数', '未知', 'php中文网', '<p>我&nbsp; &nbsp;一直在讲，不要被名词的含义所吓唬住。</p>\n\n<p>到底什么是整型呀？</p>\n\n<p>所谓整型，就是大家数学中所学的整数。</p>\n\n<p>整型&mdash;&mdash;整数也，英文称之:integer。英文简写：int</p>\n\n<p>整型分为：</p>\n\n<p>&nbsp;&nbsp;&nbsp;&nbsp;1.10进行</p>\n\n<p>&nbsp;&nbsp;&nbsp;&nbsp;2.8进制 （了解，基本不用）</p>\n\n<p>&nbsp;&nbsp;&nbsp;&nbsp;3.16进制（了解，基本不用）</p>\n\n<p>整型（整数）在计算机里面是有最大值和最小值范围的。</p>\n\n<p>【了解知识点，开发中不常用】大家经常听说32位计算机，也就是32位计算机一次运算处理的最大范围为-232至232-1。<br />\n64位计算机呢？&mdash;&mdash;</p>\n\n<p>10 进制声明：</p>\n\n<p><!--?php<br-->//为了方便大家记忆和前期学习，英文不好的朋友也可用拼音来声明变量。以后再用英文来声明变量也无所谓<br />\n//声明变量&nbsp;整数，英文&nbsp;int<br />\n//$int&nbsp;=&nbsp;1000;<br />\n$zhengshu&nbsp;=&nbsp;1000;<br />\necho&nbsp;$zhengshu;<br />\n?&gt;</p>\n\n<p>8进制声明：&nbsp;以0开始，后面跟0-7的整数（了解知识点）</p>\n\n<p><!--?php<br-->//8进制的取值范围最大为0-7,即0,1,2,3,4,5,6,7<br />\n<br />\n$bajingzhi&nbsp;=&nbsp;&nbsp;033145;<br />\necho&nbsp;$bajingzhi;<br />\n<br />\n?&gt;</p>\n\n<p>16进制声明：&nbsp;以0x开始，后面跟0-f的，0x的abcdef不区分大小写。（了解知识点）</p>\n\n<p><!--?php<br-->//16进制的取值范围最大为0-f,即0,1,2,3,4,5,6,7,8,9,a,b,c,d,e,f<br />\n$shiliu&nbsp;=&nbsp;&nbsp;0x6ff;<br />\necho&nbsp;$shiliu;<br />\n?&gt;</p>\n\n<p>本章学习重点，学会如何声明10制制整数即可。了解8制制和16进制的声明，实在不会也不要紧。</p>\n\n<p>思维误区：容易去考虑8进制和16进制到底是怎么产生的。</p>\n', '我一直在讲，不要被名词的含义所吓唬住。\n到底什么是整型呀？\n所谓整型，就是大家数学中所学的整数。', '/uploads/20181224/588ac2b0eca6de73b61c125db692e020.jpg', '', '', 'php,php整型', 0, '', '', '', '', 0);
INSERT INTO `tp_article` VALUES (14, 1581054439, 1581054439, 50, 1, 6, 'PHP中的流程控制', '未知', 'php中文网', '<p>流程控制就是人类社会的做事和思考和处理问题的方式和方法。通过本章，你将会发现采用计算机的思维去考虑问题，我们在做事的过程当中会更加严谨。</p>\n\n<p>我们通过一个一个的场景来去推理流程：</p>\n\n<p>有一个高富帅，他姓王。他的名字叫&mdash;&mdash;王。王同学计划要投资一个项目。如果这个项目计划开始，为了这个投资项目每周往返一次北京和大连。什么时候王思总同学不再往返呢？项目失败后或者万（da）集团临时除知除外，他就可以不再这么每周往返了。</p>\n\n<p>王同学呢，有一个好习惯，就是每次往返的时候，害怕自己到底一年往返了多少次。王同学都会在自己的记事本上记上往返的次数，第一次就写上一，第2次就写上2... ...直至最后项目停止。</p>\n\n<p>王同学家里头特别有钱，所以他的行程方式和正常人的又有些不同。不仅有更多的方式，而且王同学还迷信。</p>\n\n<p>他的出行方式呢有6种，如下：</p>\n\n<p>1，司机开车<br />\n2，民航<br />\n3，自己家的专机<br />\n4，火车动车<br />\n5，骑马<br />\n6，游轮</p>\n\n<p>每次王同学，都自己会在骰子上写上1，2，3，4，5，6。摇到哪种方式，王同学就会采用哪种方式进行往返两地。</p>\n\n<p>并且呢，王同学是生活极度充满娱乐化和享受生活的人。他抵达北京或者大连的时候不同，他抵达后做的事情都不同，如下：</p>\n\n<p>半夜到达，先去夜店参加假面舞会<br />\n早上抵达，爱在酒店泡个澡<br />\n中午到达，会吃上一份神户牛肉<br />\n晚上到达，总爱去找朋友去述说一下心中的寂寞</p>\n\n<p>王同学在出行和项目中也是极度有计划性。他给自己的生活秘书和工作秘书分别指派了出差的行程：</p>\n\n<p>生活上：<br />\n先查天气，下雨带雨具和毛巾。不下雨要带防晒霜<br />\n雨具、毛巾和防晒霜的情况要提前检查，如果没有要及时买</p>\n\n<p>工作上：<br />\n要提前沟通去大连前的工作计划，准备好了要及时检查，检查合格，要提前打印现来。<br />\n及时没有及时准备好的情况下，要列出主要的项目沟通议题。</p>\n', '流程控制就是人类社会的做事和思考和处理问题的方式和方法。通过本章，你将会发现采用计算机的思维去考虑问题，我们在做事的过程当中会更加严谨。我们通过一个一个的场景来去推理流程：', '', '', '', 'php,php流程', 0, '', '', '', '', 0);
INSERT INTO `tp_article` VALUES (15, 1581054482, 1581054482, 50, 1, 6, 'php流程控制之if条件结构流程', '未知', 'php中文网', '<p>if条件结构流程</p>\n\n<p>if和else 语句，在之前的3.2.5章节中已经做了说明。我们配合王思总同学的例子，再次进行说明，方便大家对此章节的理解。</p>\n\n<p>本章的知识点为：【默写级】</p>\n\n<p>基本语法，不能有半点马乎，完全是语法规范规定的，不这么写就错！</p>\n\n<p><!--?php <br/-->$week=date(&quot;4&quot;);<br />\n//判断星期小于6，则输出：还没到周末，继续上班.....<br />\nif&nbsp;($week&lt;&quot;6&quot;)&nbsp;{<br />\n&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;还没到周末，继续上班.....&quot;;<br />\n}&nbsp;<br />\n?&gt;</p>\n\n<p>在之前我们也讲过，因此if的结构可以根据人类思维推理出来两种结构：</p>\n\n<p>//if单行判断<br />\nif(布尔值判断)<br />\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;只写一句话;<br />\n后续代码<br />\n//if多行判断<br />\nif(布尔值判断){<br />\n&nbsp;&nbsp;&nbsp;&nbsp;可以写多句话;<br />\n}<br />\n后续代码</p>\n', 'if条件结构流程\nif和else 语句，在之前的3.2.5章节中已经做了说明。我们配合王思总同学的例子，再次进行说明，方便大家对此章节的理解。\n本章的知识点为：【默写级】', '', '', '', 'php,php流程', 0, '', '', '', '', 0);
INSERT INTO `tp_article` VALUES (16, 1581054524, 1581054524, 50, 1, 6, 'PHP流程控制之if语句', '未知', 'php中文网', '<p>我们为了加强大家对代码的理解，我们串了一个故事恶搞了一个王思总同学。</p>\n\n<p>在4.1和3.2.5这两个章节中我们都介绍到了if和if...else结构。并且我们讲解的很清楚。</p>\n\n<p>我们现在来用if...else结构来写一个小东西，加强大家对逻辑的理解。</p>\n', '我们为了加强大家对代码的理解，我们串了一个故事恶搞了一个王思总同学。\n在4.1和3.2.5这两个章节中我们都介绍到了if和if...else结构。并且我们讲解的很清楚。\n我们现在来用if...else结构来写一个小东西，加强大家对逻辑的理解。', '', '', '', 'php,if', 45, '', '', '', '', 0);
INSERT INTO `tp_article` VALUES (17, 1581054590, 1581054590, 50, 1, 6, 'PHP流程控制之嵌套if...else...elseif结构', '未知', 'php中文网', '<p>还记得本章开篇我们讲了一个王思总同学的例子：</p>\n\n<p>王同学是生活极度充满娱乐化和享受生活的人。他抵达北京或者大连的时候做的事，他抵达后做的事情，如下：</p>\n\n<p>半夜到达，先去夜店参加假面舞会<br />\n&nbsp;早上抵达，爱在酒店泡个澡<br />\n&nbsp;中午到达，会吃上一份神户牛肉<br />\n&nbsp;晚上到达，总爱去找朋友去述说一下心中的寂寞</p>\n\n<p>我们来了解一下他的语法规则【知识点要求：默写】</p>\n\n<p><!--?php<br/-->if（判断语句1）{<br />\n&nbsp;&nbsp;&nbsp;&nbsp;执行语句体1<br />\n}elseif(判断语句2){<br />\n&nbsp;&nbsp;&nbsp;&nbsp;执行语句体2<br />\n}else&nbsp;if(判断语句n){<br />\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;执行语句体n<br />\n}else{<br />\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;最后的else语句可选<br />\n}<br />\n<br />\n//后续代码<br />\n?&gt;</p>\n', '还记得本章开篇我们讲了一个王思总同学的例子：\n王同学是生活极度充满娱乐化和享受生活的人。他抵达北京或者大连的时候做的事，他抵达后做的事情。', '', '', '', 'if', 7, '', '', '', '', 0);

-- ----------------------------
-- Table structure for tp_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `tp_auth_group`;
CREATE TABLE `tp_auth_group`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '角色组',
  `rules` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '权限',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '角色组管理' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_auth_group
-- ----------------------------
INSERT INTO `tp_auth_group` VALUES (1, 1580633995, 1583732574, 1, '超级管理员', '0,157,92,93,94,95,96,97,98,99,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,171,172,173,174,175,176,268,269,270,271,272,273,274,275,276,158,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,106,107,108,109,110,111,112,113,114,115,100,101,102,103,104,105,159,163,164,165,166,167,168,169,170,160,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,39,40,41,42,43,44,45,46,47,48,187,177,178,179,180,181,182,183,184,185,186,161,49,50,51,52,53,54,55,56,57,58,69,70,71,72,73,74,75,76,77,78,59,60,61,62,63,64,65,66,67,68,79,80,81,82,83,84,85,86,87,88,162,1,2,3,4,5,6,7,8,29,30,31,32,33,34,35,36,37,38,188,189,190,191,192,193,194,195,196,197,198,199,200,201,202,203,204,205,206,207,208,209,210,211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,241,242,243,244,245,246,247,248,249,250,251,252,253,254,255,256,257,258,260,261,262,263,264,265,266,267,');
INSERT INTO `tp_auth_group` VALUES (2, 1580634019, 1613634834, 1, '测试组', '0,157,92,93,95,99,9,10,12,16,19,20,22,26,171,174,268,269,271,274,277,278,158,116,117,119,123,125,126,128,132,134,106,107,109,113,100,101,105,159,163,164,165,166,167,169,170,160,136,137,139,143,147,148,150,154,39,40,42,46,187,177,178,180,184,281,161,49,50,52,56,69,70,72,76,59,60,62,66,79,80,82,86,162,1,2,4,8,29,30,32,36,188,189,190,192,196,199,200,202,206,209,210,212,216,219,220,222,226,229,230,232,236,239,240,242,246,249,252,256,258,260,261,262,263,264,265,266,267,');

-- ----------------------------
-- Table structure for tp_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `tp_auth_group_access`;
CREATE TABLE `tp_auth_group_access`  (
  `uid` mediumint(8) UNSIGNED NOT NULL COMMENT '用户ID',
  `group_id` mediumint(8) UNSIGNED NOT NULL COMMENT '分组ID',
  `create_time` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '更新时间	',
  UNIQUE INDEX `uid_group_id`(`uid`, `group_id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `group_id`(`group_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '用户组明细表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_auth_group_access
-- ----------------------------
INSERT INTO `tp_auth_group_access` VALUES (1, 1, 1553846932, 1553846932);
INSERT INTO `tp_auth_group_access` VALUES (2, 2, 1583728403, 1583748601);

-- ----------------------------
-- Table structure for tp_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `tp_auth_rule`;
CREATE TABLE `tp_auth_rule`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `pid` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '父ID',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '控制器/方法',
  `title` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '权限名称',
  `type` tinyint(1) NOT NULL DEFAULT 1,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '菜单状态',
  `condition` char(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sort` mediumint(8) NOT NULL DEFAULT 0 COMMENT '排序',
  `auth_open` tinyint(2) NULL DEFAULT 1 COMMENT '验证权限',
  `icon` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '图标名称',
  `create_time` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `param` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '参数',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 283 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '规则表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_auth_rule
-- ----------------------------
INSERT INTO `tp_auth_rule` VALUES (1, 162, 'Users/index', '会员管理', 1, 1, '', 71, 1, 'fa fa-user', 1580861016, 1580908159, '');
INSERT INTO `tp_auth_rule` VALUES (2, 1, 'Users/add', '操作-添加', 1, 0, '', 1, 1, '', 1580861016, 1580861016, '');
INSERT INTO `tp_auth_rule` VALUES (3, 1, 'Users/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1580861016, 1580861016, '');
INSERT INTO `tp_auth_rule` VALUES (4, 1, 'Users/edit', '操作-修改', 1, 0, '', 3, 1, '', 1580861016, 1580861016, '');
INSERT INTO `tp_auth_rule` VALUES (5, 1, 'Users/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1580861016, 1580861016, '');
INSERT INTO `tp_auth_rule` VALUES (6, 1, 'Users/del', '操作-删除', 1, 0, '', 5, 1, '', 1580861016, 1580861016, '');
INSERT INTO `tp_auth_rule` VALUES (7, 1, 'Users/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1580861016, 1580861016, '');
INSERT INTO `tp_auth_rule` VALUES (8, 1, 'Users/export', '操作-导出', 1, 0, '', 7, 1, '', 1580861016, 1580861016, '');
INSERT INTO `tp_auth_rule` VALUES (9, 157, 'DictionaryType/index', '字典类型', 1, 1, '', 12, 1, '', 1580861057, 1580861057, '');
INSERT INTO `tp_auth_rule` VALUES (10, 9, 'DictionaryType/add', '操作-添加', 1, 0, '', 1, 1, '', 1580861057, 1580861057, '');
INSERT INTO `tp_auth_rule` VALUES (11, 9, 'DictionaryType/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1580861057, 1580861057, '');
INSERT INTO `tp_auth_rule` VALUES (12, 9, 'DictionaryType/edit', '操作-修改', 1, 0, '', 3, 1, '', 1580861057, 1580861057, '');
INSERT INTO `tp_auth_rule` VALUES (13, 9, 'DictionaryType/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1580861057, 1580861057, '');
INSERT INTO `tp_auth_rule` VALUES (14, 9, 'DictionaryType/del', '操作-删除', 1, 0, '', 5, 1, '', 1580861057, 1580861057, '');
INSERT INTO `tp_auth_rule` VALUES (15, 9, 'DictionaryType/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1580861057, 1580861057, '');
INSERT INTO `tp_auth_rule` VALUES (16, 9, 'DictionaryType/export', '操作-导出', 1, 0, '', 7, 1, '', 1580861057, 1580861057, '');
INSERT INTO `tp_auth_rule` VALUES (17, 9, 'DictionaryType/sort', '操作-排序', 1, 0, '', 8, 1, '', 1580861057, 1580861057, '');
INSERT INTO `tp_auth_rule` VALUES (18, 9, 'DictionaryType/state', '操作-状态', 1, 0, '', 9, 1, '', 1580861057, 1580861057, '');
INSERT INTO `tp_auth_rule` VALUES (19, 157, 'Dictionary/index', '字典数据', 1, 1, '', 13, 1, '', 1580861065, 1580861065, '');
INSERT INTO `tp_auth_rule` VALUES (20, 19, 'Dictionary/add', '操作-添加', 1, 0, '', 1, 1, '', 1580861065, 1580861065, '');
INSERT INTO `tp_auth_rule` VALUES (21, 19, 'Dictionary/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1580861065, 1580861065, '');
INSERT INTO `tp_auth_rule` VALUES (22, 19, 'Dictionary/edit', '操作-修改', 1, 0, '', 3, 1, '', 1580861065, 1580861065, '');
INSERT INTO `tp_auth_rule` VALUES (23, 19, 'Dictionary/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1580861065, 1580861065, '');
INSERT INTO `tp_auth_rule` VALUES (24, 19, 'Dictionary/del', '操作-删除', 1, 0, '', 5, 1, '', 1580861065, 1580861065, '');
INSERT INTO `tp_auth_rule` VALUES (25, 19, 'Dictionary/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1580861065, 1580861065, '');
INSERT INTO `tp_auth_rule` VALUES (26, 19, 'Dictionary/export', '操作-导出', 1, 0, '', 7, 1, '', 1580861065, 1580861065, '');
INSERT INTO `tp_auth_rule` VALUES (27, 19, 'Dictionary/sort', '操作-排序', 1, 0, '', 8, 1, '', 1580861065, 1580861065, '');
INSERT INTO `tp_auth_rule` VALUES (28, 19, 'Dictionary/state', '操作-状态', 1, 0, '', 9, 1, '', 1580861065, 1580861065, '');
INSERT INTO `tp_auth_rule` VALUES (29, 162, 'UsersType/index', '会员分组', 1, 1, '', 72, 1, 'fa fa-users', 1580861073, 1580908165, '');
INSERT INTO `tp_auth_rule` VALUES (30, 29, 'UsersType/add', '操作-添加', 1, 0, '', 1, 1, '', 1580861073, 1580861073, '');
INSERT INTO `tp_auth_rule` VALUES (31, 29, 'UsersType/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1580861073, 1580861073, '');
INSERT INTO `tp_auth_rule` VALUES (32, 29, 'UsersType/edit', '操作-修改', 1, 0, '', 3, 1, '', 1580861073, 1580861073, '');
INSERT INTO `tp_auth_rule` VALUES (33, 29, 'UsersType/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1580861073, 1580861073, '');
INSERT INTO `tp_auth_rule` VALUES (34, 29, 'UsersType/del', '操作-删除', 1, 0, '', 5, 1, '', 1580861073, 1580861073, '');
INSERT INTO `tp_auth_rule` VALUES (35, 29, 'UsersType/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1580861073, 1580861073, '');
INSERT INTO `tp_auth_rule` VALUES (36, 29, 'UsersType/export', '操作-导出', 1, 0, '', 7, 1, '', 1580861073, 1580861073, '');
INSERT INTO `tp_auth_rule` VALUES (37, 29, 'UsersType/sort', '操作-排序', 1, 0, '', 8, 1, '', 1580861073, 1580861073, '');
INSERT INTO `tp_auth_rule` VALUES (38, 29, 'UsersType/state', '操作-状态', 1, 0, '', 9, 1, '', 1580861073, 1580861073, '');
INSERT INTO `tp_auth_rule` VALUES (39, 160, 'FieldGroup/index', '字段分组', 1, 1, '', 43, 1, 'fa fa-bullseye', 1580861081, 1580861081, '');
INSERT INTO `tp_auth_rule` VALUES (40, 39, 'FieldGroup/add', '操作-添加', 1, 0, '', 1, 1, '', 1580861081, 1580861081, '');
INSERT INTO `tp_auth_rule` VALUES (41, 39, 'FieldGroup/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1580861081, 1580861081, '');
INSERT INTO `tp_auth_rule` VALUES (42, 39, 'FieldGroup/edit', '操作-修改', 1, 0, '', 3, 1, '', 1580861081, 1580861081, '');
INSERT INTO `tp_auth_rule` VALUES (43, 39, 'FieldGroup/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1580861081, 1580861081, '');
INSERT INTO `tp_auth_rule` VALUES (44, 39, 'FieldGroup/del', '操作-删除', 1, 0, '', 5, 1, '', 1580861081, 1580861081, '');
INSERT INTO `tp_auth_rule` VALUES (45, 39, 'FieldGroup/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1580861081, 1580861081, '');
INSERT INTO `tp_auth_rule` VALUES (46, 39, 'FieldGroup/export', '操作-导出', 1, 0, '', 7, 1, '', 1580861081, 1580861081, '');
INSERT INTO `tp_auth_rule` VALUES (47, 39, 'FieldGroup/sort', '操作-排序', 1, 0, '', 8, 1, '', 1580861081, 1580861081, '');
INSERT INTO `tp_auth_rule` VALUES (48, 39, 'FieldGroup/state', '操作-状态', 1, 0, '', 9, 1, '', 1580861081, 1580861081, '');
INSERT INTO `tp_auth_rule` VALUES (49, 161, 'Link/index', '友情链接', 1, 1, '', 61, 1, 'fa fa-link', 1580861091, 1580908119, '');
INSERT INTO `tp_auth_rule` VALUES (50, 49, 'Link/add', '操作-添加', 1, 0, '', 1, 1, '', 1580861091, 1580861091, '');
INSERT INTO `tp_auth_rule` VALUES (51, 49, 'Link/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1580861091, 1580861091, '');
INSERT INTO `tp_auth_rule` VALUES (52, 49, 'Link/edit', '操作-修改', 1, 0, '', 3, 1, '', 1580861091, 1580861091, '');
INSERT INTO `tp_auth_rule` VALUES (53, 49, 'Link/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1580861091, 1580861091, '');
INSERT INTO `tp_auth_rule` VALUES (54, 49, 'Link/del', '操作-删除', 1, 0, '', 5, 1, '', 1580861091, 1580861091, '');
INSERT INTO `tp_auth_rule` VALUES (55, 49, 'Link/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1580861091, 1580861091, '');
INSERT INTO `tp_auth_rule` VALUES (56, 49, 'Link/export', '操作-导出', 1, 0, '', 7, 1, '', 1580861091, 1580861091, '');
INSERT INTO `tp_auth_rule` VALUES (57, 49, 'Link/sort', '操作-排序', 1, 0, '', 8, 1, '', 1580861091, 1580861091, '');
INSERT INTO `tp_auth_rule` VALUES (58, 49, 'Link/state', '操作-状态', 1, 0, '', 9, 1, '', 1580861091, 1580861091, '');
INSERT INTO `tp_auth_rule` VALUES (59, 161, 'AdType/index', '广告分组', 1, 1, '', 63, 1, 'fa fa-tv', 1580861099, 1580908135, '');
INSERT INTO `tp_auth_rule` VALUES (60, 59, 'AdType/add', '操作-添加', 1, 0, '', 1, 1, '', 1580861099, 1580861099, '');
INSERT INTO `tp_auth_rule` VALUES (61, 59, 'AdType/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1580861099, 1580861099, '');
INSERT INTO `tp_auth_rule` VALUES (62, 59, 'AdType/edit', '操作-修改', 1, 0, '', 3, 1, '', 1580861099, 1580861099, '');
INSERT INTO `tp_auth_rule` VALUES (63, 59, 'AdType/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1580861099, 1580861099, '');
INSERT INTO `tp_auth_rule` VALUES (64, 59, 'AdType/del', '操作-删除', 1, 0, '', 5, 1, '', 1580861099, 1580861099, '');
INSERT INTO `tp_auth_rule` VALUES (65, 59, 'AdType/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1580861099, 1580861099, '');
INSERT INTO `tp_auth_rule` VALUES (66, 59, 'AdType/export', '操作-导出', 1, 0, '', 7, 1, '', 1580861099, 1580861099, '');
INSERT INTO `tp_auth_rule` VALUES (67, 59, 'AdType/sort', '操作-排序', 1, 0, '', 8, 1, '', 1580861099, 1580861099, '');
INSERT INTO `tp_auth_rule` VALUES (68, 59, 'AdType/state', '操作-状态', 1, 0, '', 9, 1, '', 1580861099, 1580861099, '');
INSERT INTO `tp_auth_rule` VALUES (69, 161, 'Ad/index', '广告管理', 1, 1, '', 62, 1, 'fa fa-tv', 1580861106, 1580908132, '');
INSERT INTO `tp_auth_rule` VALUES (70, 69, 'Ad/add', '操作-添加', 1, 0, '', 1, 1, '', 1580861106, 1580861106, '');
INSERT INTO `tp_auth_rule` VALUES (71, 69, 'Ad/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1580861106, 1580861106, '');
INSERT INTO `tp_auth_rule` VALUES (72, 69, 'Ad/edit', '操作-修改', 1, 0, '', 3, 1, '', 1580861106, 1580861106, '');
INSERT INTO `tp_auth_rule` VALUES (73, 69, 'Ad/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1580861106, 1580861106, '');
INSERT INTO `tp_auth_rule` VALUES (74, 69, 'Ad/del', '操作-删除', 1, 0, '', 5, 1, '', 1580861106, 1580861106, '');
INSERT INTO `tp_auth_rule` VALUES (75, 69, 'Ad/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1580861106, 1580861106, '');
INSERT INTO `tp_auth_rule` VALUES (76, 69, 'Ad/export', '操作-导出', 1, 0, '', 7, 1, '', 1580861106, 1580861106, '');
INSERT INTO `tp_auth_rule` VALUES (77, 69, 'Ad/sort', '操作-排序', 1, 0, '', 8, 1, '', 1580861107, 1580861107, '');
INSERT INTO `tp_auth_rule` VALUES (78, 69, 'Ad/state', '操作-状态', 1, 0, '', 9, 1, '', 1580861107, 1580861107, '');
INSERT INTO `tp_auth_rule` VALUES (79, 161, 'Debris/index', '碎片管理', 1, 1, '', 64, 1, 'fa fa-gift', 1580861113, 1580908138, '');
INSERT INTO `tp_auth_rule` VALUES (80, 79, 'Debris/add', '操作-添加', 1, 0, '', 1, 1, '', 1580861113, 1580861113, '');
INSERT INTO `tp_auth_rule` VALUES (81, 79, 'Debris/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1580861113, 1580861113, '');
INSERT INTO `tp_auth_rule` VALUES (82, 79, 'Debris/edit', '操作-修改', 1, 0, '', 3, 1, '', 1580861113, 1580861113, '');
INSERT INTO `tp_auth_rule` VALUES (83, 79, 'Debris/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1580861113, 1580861113, '');
INSERT INTO `tp_auth_rule` VALUES (84, 79, 'Debris/del', '操作-删除', 1, 0, '', 5, 1, '', 1580861113, 1580861113, '');
INSERT INTO `tp_auth_rule` VALUES (85, 79, 'Debris/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1580861113, 1580861113, '');
INSERT INTO `tp_auth_rule` VALUES (86, 79, 'Debris/export', '操作-导出', 1, 0, '', 7, 1, '', 1580861113, 1580861113, '');
INSERT INTO `tp_auth_rule` VALUES (87, 79, 'Debris/sort', '操作-排序', 1, 0, '', 8, 1, '', 1580861113, 1580861113, '');
INSERT INTO `tp_auth_rule` VALUES (88, 79, 'Debris/state', '操作-状态', 1, 0, '', 9, 1, '', 1580861113, 1580861113, '');
INSERT INTO `tp_auth_rule` VALUES (92, 157, 'System/index', '系统设置', 1, 1, '', 11, 1, 'fa fa-cog', 1580861127, 1580874204, '');
INSERT INTO `tp_auth_rule` VALUES (93, 92, 'System/add', '操作-添加', 1, 0, '', 1, 1, '', 1580861127, 1580861127, '');
INSERT INTO `tp_auth_rule` VALUES (94, 92, 'System/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1580861127, 1580861127, '');
INSERT INTO `tp_auth_rule` VALUES (95, 92, 'System/edit', '操作-修改', 1, 0, '', 3, 1, '', 1580861127, 1580861127, '');
INSERT INTO `tp_auth_rule` VALUES (96, 92, 'System/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1580861127, 1580861127, '');
INSERT INTO `tp_auth_rule` VALUES (97, 92, 'System/del', '操作-删除', 1, 0, '', 5, 1, '', 1580861127, 1580861127, '');
INSERT INTO `tp_auth_rule` VALUES (98, 92, 'System/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1580861127, 1580861127, '');
INSERT INTO `tp_auth_rule` VALUES (99, 92, 'System/export', '操作-导出', 1, 0, '', 7, 1, '', 1580861127, 1580861127, '');
INSERT INTO `tp_auth_rule` VALUES (100, 158, 'AdminLog/index', '管理员日志', 1, 1, '', 24, 1, 'fa fa-book', 1580871750, 1580871750, '');
INSERT INTO `tp_auth_rule` VALUES (101, 100, 'AdminLog/edit', '操作-修改', 1, 0, '', 3, 1, '', 1580871750, 1580871750, '');
INSERT INTO `tp_auth_rule` VALUES (102, 100, 'AdminLog/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1580871750, 1580871750, '');
INSERT INTO `tp_auth_rule` VALUES (103, 100, 'AdminLog/del', '操作-删除', 1, 0, '', 5, 1, '', 1580871750, 1580871750, '');
INSERT INTO `tp_auth_rule` VALUES (104, 100, 'AdminLog/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1580871750, 1580871750, '');
INSERT INTO `tp_auth_rule` VALUES (105, 100, 'AdminLog/export', '操作-导出', 1, 0, '', 7, 1, '', 1580871750, 1580871750, '');
INSERT INTO `tp_auth_rule` VALUES (106, 158, 'AuthRule/index', '菜单规则', 1, 1, '', 23, 1, 'fa fa-bars', 1580871826, 1580871826, '');
INSERT INTO `tp_auth_rule` VALUES (107, 106, 'AuthRule/add', '操作-添加', 1, 0, '', 1, 1, '', 1580871826, 1580871826, '');
INSERT INTO `tp_auth_rule` VALUES (108, 106, 'AuthRule/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1580871826, 1580871826, '');
INSERT INTO `tp_auth_rule` VALUES (109, 106, 'AuthRule/edit', '操作-修改', 1, 0, '', 3, 1, '', 1580871826, 1580871826, '');
INSERT INTO `tp_auth_rule` VALUES (110, 106, 'AuthRule/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1580871826, 1580871826, '');
INSERT INTO `tp_auth_rule` VALUES (111, 106, 'AuthRule/del', '操作-删除', 1, 0, '', 5, 1, '', 1580871826, 1580871826, '');
INSERT INTO `tp_auth_rule` VALUES (112, 106, 'AuthRule/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1580871826, 1580871826, '');
INSERT INTO `tp_auth_rule` VALUES (113, 106, 'AuthRule/export', '操作-导出', 1, 0, '', 7, 1, '', 1580871826, 1580871826, '');
INSERT INTO `tp_auth_rule` VALUES (114, 106, 'AuthRule/sort', '操作-排序', 1, 0, '', 8, 1, '', 1580871826, 1580871826, '');
INSERT INTO `tp_auth_rule` VALUES (115, 106, 'AuthRule/state', '操作-状态', 1, 0, '', 9, 1, '', 1580871826, 1580871826, '');
INSERT INTO `tp_auth_rule` VALUES (116, 158, 'Admin/index', '管理员管理', 1, 1, '', 21, 1, 'fa fa-user', 1580871882, 1580871882, '');
INSERT INTO `tp_auth_rule` VALUES (117, 116, 'Admin/add', '操作-添加', 1, 0, '', 1, 1, '', 1580871882, 1580871882, '');
INSERT INTO `tp_auth_rule` VALUES (118, 116, 'Admin/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1580871882, 1580871882, '');
INSERT INTO `tp_auth_rule` VALUES (119, 116, 'Admin/edit', '操作-修改', 1, 0, '', 3, 1, '', 1580871882, 1580871882, '');
INSERT INTO `tp_auth_rule` VALUES (120, 116, 'Admin/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1580871882, 1580871882, '');
INSERT INTO `tp_auth_rule` VALUES (121, 116, 'Admin/del', '操作-删除', 1, 0, '', 5, 1, '', 1580871882, 1580871882, '');
INSERT INTO `tp_auth_rule` VALUES (122, 116, 'Admin/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1580871882, 1580871882, '');
INSERT INTO `tp_auth_rule` VALUES (123, 116, 'Admin/export', '操作-导出', 1, 0, '', 7, 1, '', 1580871882, 1580871882, '');
INSERT INTO `tp_auth_rule` VALUES (124, 116, 'Admin/state', '操作-状态', 1, 0, '', 9, 1, '', 1580871882, 1580871882, '');
INSERT INTO `tp_auth_rule` VALUES (125, 158, 'AuthGroup/index', '角色组管理', 1, 1, '', 22, 1, 'fas fa-user-shield', 1580871965, 1580871965, '');
INSERT INTO `tp_auth_rule` VALUES (126, 125, 'AuthGroup/add', '操作-添加', 1, 0, '', 1, 1, '', 1580871965, 1580871965, '');
INSERT INTO `tp_auth_rule` VALUES (127, 125, 'AuthGroup/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1580871965, 1580871965, '');
INSERT INTO `tp_auth_rule` VALUES (128, 125, 'AuthGroup/edit', '操作-修改', 1, 0, '', 3, 1, '', 1580871965, 1580871965, '');
INSERT INTO `tp_auth_rule` VALUES (129, 125, 'AuthGroup/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1580871965, 1580871965, '');
INSERT INTO `tp_auth_rule` VALUES (130, 125, 'AuthGroup/del', '操作-删除', 1, 0, '', 5, 1, '', 1580871965, 1580871965, '');
INSERT INTO `tp_auth_rule` VALUES (131, 125, 'AuthGroup/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1580871965, 1580871965, '');
INSERT INTO `tp_auth_rule` VALUES (132, 125, 'AuthGroup/export', '操作-导出', 1, 0, '', 7, 1, '', 1580871965, 1580871965, '');
INSERT INTO `tp_auth_rule` VALUES (133, 125, 'AuthGroup/state', '操作-状态', 1, 0, '', 9, 1, '', 1580871965, 1580871965, '');
INSERT INTO `tp_auth_rule` VALUES (134, 125, 'AuthGroup/access', '操作-权限', 1, 0, '', 10, 1, '', 1580872096, 1580872096, '');
INSERT INTO `tp_auth_rule` VALUES (135, 125, 'AuthGroup/accessPost', '操作-权限保存', 1, 0, '', 11, 1, '', 1580872132, 1580872132, '');
INSERT INTO `tp_auth_rule` VALUES (136, 160, 'Module/index', '模块管理', 1, 1, '', 41, 1, 'fa fa-th-list', 1580872182, 1580878146, '');
INSERT INTO `tp_auth_rule` VALUES (137, 136, 'Module/add', '操作-添加', 1, 0, '', 1, 1, '', 1580872182, 1580872182, '');
INSERT INTO `tp_auth_rule` VALUES (138, 136, 'Module/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1580872182, 1580872182, '');
INSERT INTO `tp_auth_rule` VALUES (139, 136, 'Module/edit', '操作-修改', 1, 0, '', 3, 1, '', 1580872182, 1580872182, '');
INSERT INTO `tp_auth_rule` VALUES (140, 136, 'Module/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1580872182, 1580872182, '');
INSERT INTO `tp_auth_rule` VALUES (141, 136, 'Module/del', '操作-删除', 1, 0, '', 5, 1, '', 1580872182, 1580872182, '');
INSERT INTO `tp_auth_rule` VALUES (142, 136, 'Module/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1580872182, 1580872182, '');
INSERT INTO `tp_auth_rule` VALUES (143, 136, 'Module/export', '操作-导出', 1, 0, '', 7, 1, '', 1580872182, 1580872182, '');
INSERT INTO `tp_auth_rule` VALUES (144, 136, 'Module/sort', '操作-排序', 1, 0, '', 8, 1, '', 1580872182, 1580872182, '');
INSERT INTO `tp_auth_rule` VALUES (145, 136, 'Module/build', '操作-生成代码', 1, 0, '', 9, 1, '', 1580872699, 1580872699, '');
INSERT INTO `tp_auth_rule` VALUES (146, 136, 'Module/makeRule', '操作-生成菜单规则', 1, 0, '', 10, 1, '', 1580872730, 1580872730, '');
INSERT INTO `tp_auth_rule` VALUES (147, 160, 'Field/index', '字段管理', 1, 1, '', 42, 1, 'fa fa-bullhorn', 1580872859, 1580872859, '');
INSERT INTO `tp_auth_rule` VALUES (148, 147, 'Field/add', '操作-添加', 1, 0, '', 1, 1, '', 1580872859, 1580872859, '');
INSERT INTO `tp_auth_rule` VALUES (149, 147, 'Field/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1580872859, 1580872859, '');
INSERT INTO `tp_auth_rule` VALUES (150, 147, 'Field/edit', '操作-修改', 1, 0, '', 3, 1, '', 1580872859, 1580872859, '');
INSERT INTO `tp_auth_rule` VALUES (151, 147, 'Field/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1580872859, 1580872859, '');
INSERT INTO `tp_auth_rule` VALUES (152, 147, 'Field/del', '操作-删除', 1, 0, '', 5, 1, '', 1580872859, 1580872859, '');
INSERT INTO `tp_auth_rule` VALUES (153, 147, 'Field/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1580872859, 1580872859, '');
INSERT INTO `tp_auth_rule` VALUES (154, 147, 'Field/changeType', '操作-加载配置', 1, 0, '', 7, 1, '', 1580872859, 1580872859, '');
INSERT INTO `tp_auth_rule` VALUES (155, 147, 'Field/sort', '操作-排序', 1, 0, '', 8, 1, '', 1580872859, 1580872859, '');
INSERT INTO `tp_auth_rule` VALUES (156, 147, 'Field/state', '操作-状态', 1, 0, '', 9, 1, '', 1580872859, 1580872859, '');
INSERT INTO `tp_auth_rule` VALUES (157, 0, 'System', '系统管理', 1, 1, '', 1, 1, 'fa fa-cogs', 1580874149, 1580874149, '');
INSERT INTO `tp_auth_rule` VALUES (158, 0, 'Auth', '权限管理', 1, 1, '', 2, 1, 'fas fa-user-cog', 1580874265, 1580874265, '');
INSERT INTO `tp_auth_rule` VALUES (159, 0, 'Database', '数据库管理', 1, 1, '', 3, 1, 'fa fa-database', 1580876394, 1580876394, '');
INSERT INTO `tp_auth_rule` VALUES (160, 0, 'Module', '模块管理', 1, 1, '', 4, 1, 'fa fa-bolt', 1580876437, 1580876437, '');
INSERT INTO `tp_auth_rule` VALUES (161, 0, 'Link', '网站功能', 1, 1, '', 6, 1, 'fas fa-layer-group', 1580878492, 1580908102, '');
INSERT INTO `tp_auth_rule` VALUES (162, 0, 'Users', '会员管理', 1, 1, '', 7, 1, 'fa fa-user', 1580878687, 1580908154, '');
INSERT INTO `tp_auth_rule` VALUES (163, 159, 'Database/database', '数据库备份', 1, 1, '', 31, 1, 'fa fa-server', 1580881507, 1580881507, '');
INSERT INTO `tp_auth_rule` VALUES (164, 163, 'Database/backup', '操作-备份', 1, 0, '', 1, 1, '', 1580881536, 1580881536, '');
INSERT INTO `tp_auth_rule` VALUES (165, 163, 'Database/repair', '操作-修复', 1, 0, '', 2, 1, '', 1580881567, 1580881567, '');
INSERT INTO `tp_auth_rule` VALUES (166, 163, 'Database/optimize', '操作-优化', 1, 0, '', 3, 1, '', 1580881596, 1580881596, '');
INSERT INTO `tp_auth_rule` VALUES (167, 159, 'Database/restore', '数据库还原', 1, 1, '', 32, 1, 'fa fa-recycle', 1580881718, 1580881729, '');
INSERT INTO `tp_auth_rule` VALUES (168, 167, 'Database/import', '操作-还原', 1, 0, '', 1, 1, '', 1580881791, 1580881791, '');
INSERT INTO `tp_auth_rule` VALUES (169, 167, 'Database/downFile', '操作-下载', 1, 0, '', 2, 1, '', 1580881823, 1580881823, '');
INSERT INTO `tp_auth_rule` VALUES (170, 167, 'Database/del', '操作-删除', 1, 0, '', 3, 1, '', 1580881861, 1580881861, '');
INSERT INTO `tp_auth_rule` VALUES (171, 157, 'Config/email', '邮件配置', 1, 1, '', 14, 1, 'fas fa-envelope nav-icon', 1580882102, 1580882122, '');
INSERT INTO `tp_auth_rule` VALUES (172, 171, 'Config/emailPost', '操作-修改保存', 1, 0, '', 1, 1, '', 1580882214, 1580882214, '');
INSERT INTO `tp_auth_rule` VALUES (173, 171, 'Config/emailSend', '操作-测试邮箱', 1, 0, '', 2, 1, '', 1580882294, 1580882294, '');
INSERT INTO `tp_auth_rule` VALUES (174, 157, 'Config/sms', '短信配置', 1, 1, '', 15, 1, 'fas fa-comment-dots', 1580882360, 1580882360, '');
INSERT INTO `tp_auth_rule` VALUES (175, 174, 'Config/smsPost', '操作-修改保存', 1, 0, '', 1, 1, '', 1580882449, 1580882449, '');
INSERT INTO `tp_auth_rule` VALUES (176, 174, 'Config/smsSend', '操作-测试短信', 1, 0, '', 2, 1, '', 1580882486, 1580882486, '');
INSERT INTO `tp_auth_rule` VALUES (177, 187, 'Cate/index', '栏目管理', 1, 1, '', 51, 1, 'fas fa-th-list', 1580907966, 1580908113, '');
INSERT INTO `tp_auth_rule` VALUES (178, 177, 'Cate/add', '操作-添加', 1, 0, '', 1, 1, '', 1580907966, 1580907966, '');
INSERT INTO `tp_auth_rule` VALUES (179, 177, 'Cate/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1580907966, 1580907966, '');
INSERT INTO `tp_auth_rule` VALUES (180, 177, 'Cate/edit', '操作-修改', 1, 0, '', 3, 1, '', 1580907966, 1580907966, '');
INSERT INTO `tp_auth_rule` VALUES (181, 177, 'Cate/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1580907966, 1580907966, '');
INSERT INTO `tp_auth_rule` VALUES (182, 177, 'Cate/del', '操作-删除', 1, 0, '', 5, 1, '', 1580907966, 1580907966, '');
INSERT INTO `tp_auth_rule` VALUES (183, 177, 'Cate/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1580907966, 1580907966, '');
INSERT INTO `tp_auth_rule` VALUES (184, 177, 'Cate/export', '操作-导出', 1, 0, '', 7, 1, '', 1580907966, 1580907966, '');
INSERT INTO `tp_auth_rule` VALUES (185, 177, 'Cate/sort', '操作-排序', 1, 0, '', 8, 1, '', 1580907966, 1580907966, '');
INSERT INTO `tp_auth_rule` VALUES (186, 177, 'Cate/state', '操作-状态', 1, 0, '', 9, 1, '', 1580907966, 1580907966, '');
INSERT INTO `tp_auth_rule` VALUES (187, 0, 'Cate', '栏目管理', 1, 1, '', 5, 1, 'fa fa-th', 1580908039, 1580908039, '');
INSERT INTO `tp_auth_rule` VALUES (188, 0, 'Page', '内容管理', 1, 1, '', 8, 1, 'fa fa-briefcase', 1581080617, 1581080617, '');
INSERT INTO `tp_auth_rule` VALUES (189, 188, 'Page/index', '单页模块', 1, 1, '', 81, 1, '', 1581080630, 1581080705, '');
INSERT INTO `tp_auth_rule` VALUES (190, 189, 'Page/add', '操作-添加', 1, 0, '', 1, 1, '', 1581080630, 1581080630, '');
INSERT INTO `tp_auth_rule` VALUES (191, 189, 'Page/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1581080630, 1581080630, '');
INSERT INTO `tp_auth_rule` VALUES (192, 189, 'Page/edit', '操作-修改', 1, 0, '', 3, 1, '', 1581080630, 1581080630, '');
INSERT INTO `tp_auth_rule` VALUES (193, 189, 'Page/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1581080630, 1581080630, '');
INSERT INTO `tp_auth_rule` VALUES (194, 189, 'Page/del', '操作-删除', 1, 0, '', 5, 1, '', 1581080630, 1581080630, '');
INSERT INTO `tp_auth_rule` VALUES (195, 189, 'Page/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1581080630, 1581080630, '');
INSERT INTO `tp_auth_rule` VALUES (196, 189, 'Page/export', '操作-导出', 1, 0, '', 7, 1, '', 1581080630, 1581080630, '');
INSERT INTO `tp_auth_rule` VALUES (197, 189, 'Page/sort', '操作-排序', 1, 0, '', 8, 1, '', 1581080630, 1581080630, '');
INSERT INTO `tp_auth_rule` VALUES (198, 189, 'Page/state', '操作-状态', 1, 0, '', 9, 1, '', 1581080630, 1581080630, '');
INSERT INTO `tp_auth_rule` VALUES (199, 188, 'Article/index', '文章模块', 1, 1, '', 82, 1, '', 1581080635, 1581080712, '');
INSERT INTO `tp_auth_rule` VALUES (200, 199, 'Article/add', '操作-添加', 1, 0, '', 1, 1, '', 1581080635, 1581080635, '');
INSERT INTO `tp_auth_rule` VALUES (201, 199, 'Article/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1581080635, 1581080635, '');
INSERT INTO `tp_auth_rule` VALUES (202, 199, 'Article/edit', '操作-修改', 1, 0, '', 3, 1, '', 1581080635, 1581080635, '');
INSERT INTO `tp_auth_rule` VALUES (203, 199, 'Article/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1581080635, 1581080635, '');
INSERT INTO `tp_auth_rule` VALUES (204, 199, 'Article/del', '操作-删除', 1, 0, '', 5, 1, '', 1581080635, 1581080635, '');
INSERT INTO `tp_auth_rule` VALUES (205, 199, 'Article/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1581080635, 1581080635, '');
INSERT INTO `tp_auth_rule` VALUES (206, 199, 'Article/export', '操作-导出', 1, 0, '', 7, 1, '', 1581080635, 1581080635, '');
INSERT INTO `tp_auth_rule` VALUES (207, 199, 'Article/sort', '操作-排序', 1, 0, '', 8, 1, '', 1581080635, 1581080635, '');
INSERT INTO `tp_auth_rule` VALUES (208, 199, 'Article/state', '操作-状态', 1, 0, '', 9, 1, '', 1581080635, 1581080635, '');
INSERT INTO `tp_auth_rule` VALUES (209, 188, 'Picture/index', '图片模块', 1, 1, '', 83, 1, '', 1581080640, 1581080717, '');
INSERT INTO `tp_auth_rule` VALUES (210, 209, 'Picture/add', '操作-添加', 1, 0, '', 1, 1, '', 1581080640, 1581080640, '');
INSERT INTO `tp_auth_rule` VALUES (211, 209, 'Picture/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1581080640, 1581080640, '');
INSERT INTO `tp_auth_rule` VALUES (212, 209, 'Picture/edit', '操作-修改', 1, 0, '', 3, 1, '', 1581080640, 1581080640, '');
INSERT INTO `tp_auth_rule` VALUES (213, 209, 'Picture/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1581080640, 1581080640, '');
INSERT INTO `tp_auth_rule` VALUES (214, 209, 'Picture/del', '操作-删除', 1, 0, '', 5, 1, '', 1581080640, 1581080640, '');
INSERT INTO `tp_auth_rule` VALUES (215, 209, 'Picture/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1581080640, 1581080640, '');
INSERT INTO `tp_auth_rule` VALUES (216, 209, 'Picture/export', '操作-导出', 1, 0, '', 7, 1, '', 1581080640, 1581080640, '');
INSERT INTO `tp_auth_rule` VALUES (217, 209, 'Picture/sort', '操作-排序', 1, 0, '', 8, 1, '', 1581080640, 1581080640, '');
INSERT INTO `tp_auth_rule` VALUES (218, 209, 'Picture/state', '操作-状态', 1, 0, '', 9, 1, '', 1581080640, 1581080640, '');
INSERT INTO `tp_auth_rule` VALUES (219, 188, 'Product/index', '产品模块', 1, 1, '', 84, 1, '', 1581080644, 1581080721, '');
INSERT INTO `tp_auth_rule` VALUES (220, 219, 'Product/add', '操作-添加', 1, 0, '', 1, 1, '', 1581080644, 1581080644, '');
INSERT INTO `tp_auth_rule` VALUES (221, 219, 'Product/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1581080644, 1581080644, '');
INSERT INTO `tp_auth_rule` VALUES (222, 219, 'Product/edit', '操作-修改', 1, 0, '', 3, 1, '', 1581080644, 1581080644, '');
INSERT INTO `tp_auth_rule` VALUES (223, 219, 'Product/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1581080644, 1581080644, '');
INSERT INTO `tp_auth_rule` VALUES (224, 219, 'Product/del', '操作-删除', 1, 0, '', 5, 1, '', 1581080644, 1581080644, '');
INSERT INTO `tp_auth_rule` VALUES (225, 219, 'Product/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1581080644, 1581080644, '');
INSERT INTO `tp_auth_rule` VALUES (226, 219, 'Product/export', '操作-导出', 1, 0, '', 7, 1, '', 1581080644, 1581080644, '');
INSERT INTO `tp_auth_rule` VALUES (227, 219, 'Product/sort', '操作-排序', 1, 0, '', 8, 1, '', 1581080644, 1581080644, '');
INSERT INTO `tp_auth_rule` VALUES (228, 219, 'Product/state', '操作-状态', 1, 0, '', 9, 1, '', 1581080644, 1581080644, '');
INSERT INTO `tp_auth_rule` VALUES (229, 188, 'Download/index', '下载模块', 1, 1, '', 85, 1, '', 1581080647, 1581080726, '');
INSERT INTO `tp_auth_rule` VALUES (230, 229, 'Download/add', '操作-添加', 1, 0, '', 1, 1, '', 1581080647, 1581080647, '');
INSERT INTO `tp_auth_rule` VALUES (231, 229, 'Download/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1581080647, 1581080647, '');
INSERT INTO `tp_auth_rule` VALUES (232, 229, 'Download/edit', '操作-修改', 1, 0, '', 3, 1, '', 1581080647, 1581080647, '');
INSERT INTO `tp_auth_rule` VALUES (233, 229, 'Download/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1581080647, 1581080647, '');
INSERT INTO `tp_auth_rule` VALUES (234, 229, 'Download/del', '操作-删除', 1, 0, '', 5, 1, '', 1581080647, 1581080647, '');
INSERT INTO `tp_auth_rule` VALUES (235, 229, 'Download/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1581080647, 1581080647, '');
INSERT INTO `tp_auth_rule` VALUES (236, 229, 'Download/export', '操作-导出', 1, 0, '', 7, 1, '', 1581080647, 1581080647, '');
INSERT INTO `tp_auth_rule` VALUES (237, 229, 'Download/sort', '操作-排序', 1, 0, '', 8, 1, '', 1581080647, 1581080647, '');
INSERT INTO `tp_auth_rule` VALUES (238, 229, 'Download/state', '操作-状态', 1, 0, '', 9, 1, '', 1581080647, 1581080647, '');
INSERT INTO `tp_auth_rule` VALUES (239, 188, 'Team/index', '团队模块', 1, 1, '', 86, 1, '', 1581080650, 1581080731, '');
INSERT INTO `tp_auth_rule` VALUES (240, 239, 'Team/add', '操作-添加', 1, 0, '', 1, 1, '', 1581080650, 1581080650, '');
INSERT INTO `tp_auth_rule` VALUES (241, 239, 'Team/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1581080650, 1581080650, '');
INSERT INTO `tp_auth_rule` VALUES (242, 239, 'Team/edit', '操作-修改', 1, 0, '', 3, 1, '', 1581080650, 1581080650, '');
INSERT INTO `tp_auth_rule` VALUES (243, 239, 'Team/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1581080650, 1581080650, '');
INSERT INTO `tp_auth_rule` VALUES (244, 239, 'Team/del', '操作-删除', 1, 0, '', 5, 1, '', 1581080650, 1581080650, '');
INSERT INTO `tp_auth_rule` VALUES (245, 239, 'Team/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1581080650, 1581080650, '');
INSERT INTO `tp_auth_rule` VALUES (246, 239, 'Team/export', '操作-导出', 1, 0, '', 7, 1, '', 1581080650, 1581080650, '');
INSERT INTO `tp_auth_rule` VALUES (247, 239, 'Team/sort', '操作-排序', 1, 0, '', 8, 1, '', 1581080650, 1581080650, '');
INSERT INTO `tp_auth_rule` VALUES (248, 239, 'Team/state', '操作-状态', 1, 0, '', 9, 1, '', 1581080650, 1581080650, '');
INSERT INTO `tp_auth_rule` VALUES (249, 188, 'Message/index', '留言模块', 1, 1, '', 87, 1, '', 1581080655, 1581080741, '');
INSERT INTO `tp_auth_rule` VALUES (250, 249, 'Message/add', '操作-添加', 1, 0, '', 1, 1, '', 1581080655, 1581080655, '');
INSERT INTO `tp_auth_rule` VALUES (251, 249, 'Message/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1581080655, 1581080655, '');
INSERT INTO `tp_auth_rule` VALUES (252, 249, 'Message/edit', '操作-修改', 1, 0, '', 3, 1, '', 1581080655, 1581080655, '');
INSERT INTO `tp_auth_rule` VALUES (253, 249, 'Message/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1581080655, 1581080655, '');
INSERT INTO `tp_auth_rule` VALUES (254, 249, 'Message/del', '操作-删除', 1, 0, '', 5, 1, '', 1581080655, 1581080655, '');
INSERT INTO `tp_auth_rule` VALUES (255, 249, 'Message/selectDel', '操作-批量删除', 1, 0, '', 6, 1, '', 1581080655, 1581080655, '');
INSERT INTO `tp_auth_rule` VALUES (256, 249, 'Message/export', '操作-导出', 1, 0, '', 7, 1, '', 1581080655, 1581080655, '');
INSERT INTO `tp_auth_rule` VALUES (257, 249, 'Message/state', '操作-状态', 1, 0, '', 9, 1, '', 1581080655, 1581214069, '');
INSERT INTO `tp_auth_rule` VALUES (258, 0, 'Demo', '实例演示', 1, 1, '', 9, 1, 'fa fa-desktop', 1581210913, 1581210922, '');
INSERT INTO `tp_auth_rule` VALUES (260, 258, 'Demo/button', '按钮', 1, 1, '', 91, 1, '', 1581212447, 1581212473, '');
INSERT INTO `tp_auth_rule` VALUES (261, 258, 'Demo/icons', '图标', 1, 1, '', 92, 1, '', 1581217423, 1581217753, '');
INSERT INTO `tp_auth_rule` VALUES (262, 258, 'Demo/general', '常规', 1, 1, '', 93, 1, '', 1581217729, 1581217756, '');
INSERT INTO `tp_auth_rule` VALUES (263, 258, 'Demo/modals', '模态框', 1, 1, '', 94, 1, '', 1581218146, 1581218146, '');
INSERT INTO `tp_auth_rule` VALUES (264, 258, 'Demo/timeline', '时间轴', 1, 1, '', 95, 1, '', 1581218342, 1581218342, '');
INSERT INTO `tp_auth_rule` VALUES (265, 258, 'Demo/layer', '弹层', 1, 1, '', 96, 1, '', 1581223849, 1581223863, '');
INSERT INTO `tp_auth_rule` VALUES (266, 258, 'Demo/layerForm', 'layer表单', 1, 1, '', 97, 1, '', 1581297357, 1581297367, '');
INSERT INTO `tp_auth_rule` VALUES (267, 258, 'Demo/addPost', '提交演示', 1, 0, '', 98, 0, '', 1581299002, 1581299009, '');
INSERT INTO `tp_auth_rule` VALUES (268, 157, 'Template/index', '模板管理', 1, 1, '', 16, 1, 'fa fa-code', 1581385089, 1581385089, '');
INSERT INTO `tp_auth_rule` VALUES (269, 268, 'Template/add', '操作-添加', 1, 0, '', 1, 1, '', 1581385125, 1581385125, '');
INSERT INTO `tp_auth_rule` VALUES (270, 268, 'Template/addPost', '操作-添加保存', 1, 0, '', 2, 1, '', 1581385157, 1581385157, '');
INSERT INTO `tp_auth_rule` VALUES (271, 268, 'Template/edit', '操作-修改', 1, 0, '', 3, 1, '', 1581385175, 1581385175, '');
INSERT INTO `tp_auth_rule` VALUES (272, 268, 'Template/editPost', '操作-修改保存', 1, 0, '', 4, 1, '', 1581385230, 1581385230, '');
INSERT INTO `tp_auth_rule` VALUES (273, 268, 'Template/del', '操作-删除', 1, 0, '', 5, 1, '', 1581385315, 1581385315, '');
INSERT INTO `tp_auth_rule` VALUES (274, 268, 'Template/img', '媒体文件-列表', 1, 0, '', 6, 1, '', 1581385347, 1581385347, '');
INSERT INTO `tp_auth_rule` VALUES (275, 268, 'Template/imgDel', '媒体文件-删除', 1, 0, '', 7, 1, '', 1581385377, 1581385377, '');
INSERT INTO `tp_auth_rule` VALUES (276, 268, 'Template/selectDel', '操作-批量删除', 1, 0, '', 8, 1, '', 1583732028, 1583732057, '');
INSERT INTO `tp_auth_rule` VALUES (277, 157, 'Plugin/index', '插件管理', 1, 1, '', 17, 1, 'fa fa-plug', 1583976240, 1583976276, '');
INSERT INTO `tp_auth_rule` VALUES (278, 277, 'Plugin/config', '操作-配置', 1, 0, '', 1, 1, '', 1583976343, 1583976343, '');
INSERT INTO `tp_auth_rule` VALUES (279, 277, 'Plugin/configSave', '操作-配置保存', 1, 0, '', 2, 1, '', 1583976405, 1583976405, '');
INSERT INTO `tp_auth_rule` VALUES (280, 277, 'Plugin/state', '操作-安装/卸载', 1, 0, '', 3, 1, '', 1583976450, 1583976450, '');
INSERT INTO `tp_auth_rule` VALUES (281, 177, 'Cate/batchAdd', '操作-批量添加', 1, 0, '', 10, 1, '', 1613634680, 1613634680, '');
INSERT INTO `tp_auth_rule` VALUES (282, 177, 'Cate/batchAddPost', '操作-批量添加保存', 1, 0, '', 11, 1, '', 1613634757, 1613634784, '');

-- ----------------------------
-- Table structure for tp_cate
-- ----------------------------
DROP TABLE IF EXISTS `tp_cate`;
CREATE TABLE `tp_cate`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `sort` int(8) UNSIGNED NOT NULL DEFAULT 50 COMMENT '排序',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态',
  `cate_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '栏目名称',
  `en_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '英文名称',
  `cate_folder` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '栏目目录',
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上级栏目',
  `module_id` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属模块',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '外部链接',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '栏目图片',
  `ico_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'ICO图片',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO关键字',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `summary` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '简介',
  `template_list` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '列表模板',
  `template_show` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '详情模版',
  `page_size` int(8) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分页条数',
  `is_menu` tinyint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT '导航状态',
  `is_next` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '跳转下级',
  `is_blank` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '新窗口打开',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '栏目管理' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_cate
-- ----------------------------
INSERT INTO `tp_cate` VALUES (1, 1580900049, 1583671301, 1, 1, '关于我们', 'About Us', 'about', 0, 18, '', '/uploads/20181224/65ea8dcb1cbd16c8dc46144069afeaf5.jpg', '', '', '', '', '', '', '', 0, 1, 0, 0);
INSERT INTO `tp_cate` VALUES (2, 1580906596, 1580906596, 11, 1, '公司介绍', 'Company Introduction', 'introduction', 1, 18, '', '', '', '', '', '', '', '', '', 0, 1, 0, 0);
INSERT INTO `tp_cate` VALUES (3, 1580907009, 1580907009, 12, 1, '公司文化', 'culture', 'culture', 1, 18, '', '', '', '', '', '', '', '', '', 0, 1, 0, 0);
INSERT INTO `tp_cate` VALUES (4, 1580907057, 1580907057, 2, 1, '新闻中心', 'News Center', 'news', 0, 19, '', '/uploads/20181224/65ea8dcb1cbd16c8dc46144069afeaf5.jpg', '', '', '', '', '', '', '', 0, 1, 0, 0);
INSERT INTO `tp_cate` VALUES (5, 1580907159, 1580907159, 21, 1, '公司新闻', '', '', 4, 19, '', '', '', '', '', '', '', '', '', 0, 1, 0, 0);
INSERT INTO `tp_cate` VALUES (6, 1580907197, 1580907197, 22, 1, '行业资讯', 'Industry Information', 'information', 4, 19, '', '', '', '', '', '', '', '', '', 0, 1, 0, 0);
INSERT INTO `tp_cate` VALUES (7, 1580907252, 1580907252, 3, 1, '资质荣誉', 'Qualifications & Honours', 'honours', 0, 21, '', '/uploads/20181224/bf913edfcd8dcdeeec910860f12a0542.jpg', '', '', '', '', '', '', '', 0, 1, 0, 0);
INSERT INTO `tp_cate` VALUES (8, 1580907289, 1580907289, 4, 1, '产品中心', 'Pdoduct  Center', 'product', 0, 22, '', '/uploads/20181224/643f5b9e297a0bd3accd79981ce347a1.jpg', '', '', '', '', '', '', '', 0, 1, 0, 0);
INSERT INTO `tp_cate` VALUES (9, 1580907315, 1580907315, 41, 1, '精选产品', '', '', 8, 22, '', '', '', '', '', '', '', '', '', 0, 1, 0, 0);
INSERT INTO `tp_cate` VALUES (10, 1580907339, 1580907339, 42, 1, '热销产品', '', '', 8, 22, '', '', '', '', '', '', '', '', '', 0, 1, 0, 0);
INSERT INTO `tp_cate` VALUES (11, 1580907374, 1580907374, 5, 1, '资料下载', 'Download', 'download', 0, 23, '', '/uploads/20181224/f4ef6f5df6abac86e8c685b2f2549079.jpg', '', '', '', '', '', '', '', 0, 1, 0, 0);
INSERT INTO `tp_cate` VALUES (12, 1580907407, 1580907407, 6, 1, '优秀团队', 'Team', 'team', 0, 24, '', '/uploads/20181224/bf3d6e8ff8f21760572ac25dd216daf9.jpg', '', '', '', '', '', '', '', 4, 1, 0, 0);
INSERT INTO `tp_cate` VALUES (13, 1580907441, 1580907441, 7, 1, '联系我们', 'Contact Us', 'contact', 0, 25, '', '/uploads/20181224/65ea8dcb1cbd16c8dc46144069afeaf5.jpg', '', '', '', '', '', '', '', 0, 1, 0, 0);

-- ----------------------------
-- Table structure for tp_config
-- ----------------------------
DROP TABLE IF EXISTS `tp_config`;
CREATE TABLE `tp_config`  (
  `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '配置的key键名',
  `value` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '配置的val值',
  `inc_type` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '配置分组',
  `desc` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '描述',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 95 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '配置表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_config
-- ----------------------------
INSERT INTO `tp_config` VALUES (60, 'smtp_server', 'smtp.qq.com', 'smtp', '0');
INSERT INTO `tp_config` VALUES (61, 'smtp_port', '465', 'smtp', '0');
INSERT INTO `tp_config` VALUES (62, 'smtp_user', '407593529@qq.com', 'smtp', '0');
INSERT INTO `tp_config` VALUES (63, 'smtp_pwd', '发ff', 'smtp', '0');
INSERT INTO `tp_config` VALUES (64, 'regis_smtp_enable', '测试', 'smtp', '0');
INSERT INTO `tp_config` VALUES (65, 'test_eamil', '123@qq.com', 'smtp', '0');
INSERT INTO `tp_config` VALUES (88, 'email_id', 'SIYUCMS', 'smtp', '0');
INSERT INTO `tp_config` VALUES (89, 'test_eamil_info', '<p>您好！这是一封来自SIYUCMS的测试邮件！</p>\n', 'smtp', '0');
INSERT INTO `tp_config` VALUES (90, 'accessKeyId', 'LTAIqinwPNwEawUK', 'sms', NULL);
INSERT INTO `tp_config` VALUES (91, 'accessKeySecret', '', 'sms', NULL);
INSERT INTO `tp_config` VALUES (92, 'templateCode', '', 'sms', NULL);
INSERT INTO `tp_config` VALUES (93, 'signName', '', 'sms', NULL);
INSERT INTO `tp_config` VALUES (94, 'test_mobile', '', 'sms', NULL);

-- ----------------------------
-- Table structure for tp_debris
-- ----------------------------
DROP TABLE IF EXISTS `tp_debris`;
CREATE TABLE `tp_debris`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `sort` mediumint(8) NULL DEFAULT 50 COMMENT '排序',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '碎片标题',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '调用名称',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '碎片内容',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '链接地址',
  `image` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '碎片列表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_debris
-- ----------------------------
INSERT INTO `tp_debris` VALUES (1, 1580388141, 1580388225, 1, 1, '关于我们', 'AboutUs', '<p>SIYUCMS内容管理系统，包含系统设置，权限管理，模型管理，数据库管理，栏目管理，会员管理，网站功能，模版管理，微信管理等相关模块。<br />\nSIYUCMS内容管理系统，包含系统设置，权限管理，模型管理，数据库管理，栏目管理，会员管理，网站功能，模版管理，微信管理等相关模块。&nbsp;&nbsp;</p>\n\n<p>&nbsp;</p>\n', '', '', '首页调用');

-- ----------------------------
-- Table structure for tp_dictionary
-- ----------------------------
DROP TABLE IF EXISTS `tp_dictionary`;
CREATE TABLE `tp_dictionary`  (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `dict_label` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '字典标签',
  `dict_value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '字典键值',
  `dict_type` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '字典类型',
  `remark` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '修改时间',
  `sort` int(5) UNSIGNED NOT NULL DEFAULT 50 COMMENT '排序',
  `status` tinyint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '字典数据' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_dictionary
-- ----------------------------
INSERT INTO `tp_dictionary` VALUES (1, '显示', '1', '1', '显示', 1579227398, 1579484762, 1, 1);
INSERT INTO `tp_dictionary` VALUES (2, '隐藏', '0', '1', '隐藏', 1579227507, 1579484767, 2, 1);
INSERT INTO `tp_dictionary` VALUES (3, '是', '1', '2', '是', 1579227536, 1579227536, 1, 1);
INSERT INTO `tp_dictionary` VALUES (4, '否', '0', '2', '否', 1579227552, 1579488433, 2, 1);
INSERT INTO `tp_dictionary` VALUES (5, 'CMS', '1', '3', 'CMS', 1579490699, 1579490699, 1, 1);
INSERT INTO `tp_dictionary` VALUES (6, '后台', '2', '3', '后台', 1579490732, 1579490732, 2, 1);
INSERT INTO `tp_dictionary` VALUES (7, '保密', '0', '4', '', 1579586378, 1579586378, 1, 1);
INSERT INTO `tp_dictionary` VALUES (8, '男', '1', '4', '', 1579586392, 1579586392, 1, 1);
INSERT INTO `tp_dictionary` VALUES (9, '女', '2', '4', '', 1579586406, 1579586406, 2, 1);
INSERT INTO `tp_dictionary` VALUES (10, '已验证', '1', '5', '', 1579587175, 1579587175, 1, 1);
INSERT INTO `tp_dictionary` VALUES (11, '未验证', '0', '5', '', 1579587190, 1579587190, 2, 1);
INSERT INTO `tp_dictionary` VALUES (12, '新增', 'add', '6', '新增按钮', 1580442656, 1580442656, 1, 1);
INSERT INTO `tp_dictionary` VALUES (13, '修改', 'edit', '6', '修改按钮', 1580442715, 1580442715, 2, 1);
INSERT INTO `tp_dictionary` VALUES (14, '删除', 'del', '6', '批量删除按钮', 1580442742, 1580442742, 3, 1);
INSERT INTO `tp_dictionary` VALUES (15, '导出', 'export', '6', '导出按钮', 1580442770, 1580442770, 4, 1);
INSERT INTO `tp_dictionary` VALUES (16, '修改', 'edit', '7', '修改按钮', 1580444389, 1585894146, 2, 1);
INSERT INTO `tp_dictionary` VALUES (17, '删除', 'delete', '7', '删除按钮', 1580444406, 1585894149, 3, 1);
INSERT INTO `tp_dictionary` VALUES (18, '开启', '1', '8', '开启', 1580559235, 1580559235, 1, 1);
INSERT INTO `tp_dictionary` VALUES (19, '关闭', '0', '8', '关闭', 1580559262, 1580559262, 2, 1);
INSERT INTO `tp_dictionary` VALUES (20, '字段本身', '0', '9', '字段本身', 1580793928, 1580793928, 1, 1);
INSERT INTO `tp_dictionary` VALUES (21, '系统字典', '1', '9', '系统字典', 1580793956, 1580793956, 2, 1);
INSERT INTO `tp_dictionary` VALUES (22, '模型数据', '2', '9', '模型数据', 1580793975, 1580793975, 3, 1);
INSERT INTO `tp_dictionary` VALUES (23, '国内', '1', '10', '', 1584510855, 1584510855, 1, 1);
INSERT INTO `tp_dictionary` VALUES (24, '国外', '2', '10', '', 1584510871, 1584510871, 2, 1);
INSERT INTO `tp_dictionary` VALUES (25, '预览', 'preview', '7', '预览按钮', 1585894123, 1585894136, 1, 1);
INSERT INTO `tp_dictionary` VALUES (26, '本地上传', '1', '11', '本地上传', 1586855924, 1586855935, 1, 1);
INSERT INTO `tp_dictionary` VALUES (27, 'CKEditor', '0', '12', 'CKEditor', 1612507944, 1612508054, 1, 1);

-- ----------------------------
-- Table structure for tp_dictionary_type
-- ----------------------------
DROP TABLE IF EXISTS `tp_dictionary_type`;
CREATE TABLE `tp_dictionary_type`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `dict_name` char(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '字典名称',
  `status` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `remark` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `sort` int(5) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '字典类型' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_dictionary_type
-- ----------------------------
INSERT INTO `tp_dictionary_type` VALUES (1, '显示状态', 1, 1579167978, 1579167978, '1 显示， 0 隐藏', 1);
INSERT INTO `tp_dictionary_type` VALUES (2, '系统是否', 1, 1579168087, 1579168087, '1 是， 0 否', 2);
INSERT INTO `tp_dictionary_type` VALUES (3, '表类型', 1, 1579168087, 1581165223, '1 CMS,2 后台', 7);
INSERT INTO `tp_dictionary_type` VALUES (4, '性别', 1, 1579586355, 1581165215, '0 保密，1 男，2 女', 9);
INSERT INTO `tp_dictionary_type` VALUES (5, '验证状态', 1, 1579587122, 1581165094, '1 已验证， 0 未验证	', 4);
INSERT INTO `tp_dictionary_type` VALUES (6, '顶部按钮', 1, 1580442606, 1581165100, '列表页顶部按钮组', 5);
INSERT INTO `tp_dictionary_type` VALUES (7, '右侧按钮', 1, 1580444354, 1581165102, '列表页右侧按钮组', 6);
INSERT INTO `tp_dictionary_type` VALUES (8, '开关状态', 1, 1580559205, 1581165084, '1 开启， 0 关闭	', 3);
INSERT INTO `tp_dictionary_type` VALUES (9, '数据源', 1, 1580793811, 1581165226, '0 字段本身，1 系统字典， 2  模型数据', 8);
INSERT INTO `tp_dictionary_type` VALUES (10, '所属地区', 1, 1584510809, 1584510822, '', 10);
INSERT INTO `tp_dictionary_type` VALUES (11, '上传驱动', 1, 1586855872, 1586855880, '上传驱动', 11);
INSERT INTO `tp_dictionary_type` VALUES (12, '编辑器', 1, 1612507874, 1612508175, '编辑器', 12);

-- ----------------------------
-- Table structure for tp_download
-- ----------------------------
DROP TABLE IF EXISTS `tp_download`;
CREATE TABLE `tp_download`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `sort` mediumint(8) NULL DEFAULT 50 COMMENT '排序',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `cate_id` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '栏目',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '作者',
  `source` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '来源',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',
  `summary` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '摘要',
  `image` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '图片集',
  `download` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文件下载',
  `tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'TAG',
  `hits` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '点击次数',
  `keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '关键词',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '描述',
  `template` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '模板',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '跳转地址',
  `view_auth` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '阅读权限',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '下载模块' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_download
-- ----------------------------
INSERT INTO `tp_download` VALUES (1, 1581079500, 1581079500, 50, 1, 11, '招聘表格下载', '管理员', '本站', '', '', '/uploads/20181224/6b449574a2358edd20c10f10f64bd09c.jpg', '', '/uploads/20181224/06d08f008e54d9ac4eae3d0a6d53cff7.rar', '', 0, '', '', '', '', 0);
INSERT INTO `tp_download` VALUES (2, 1581079531, 1581079531, 50, 1, 11, '报名表格下载', '管理员', '本站', '', '', '/uploads/20181224/d6df5528408d8974777ae29280428ad6.jpg', '', '/uploads/20181224/4d3569541beb373334582df5aaaa126b.rar', '', 0, '', '', '', '', 0);
INSERT INTO `tp_download` VALUES (3, 1581079561, 1581079561, 50, 1, 11, '供应商表格下载', '管理员', '本站', '', '', '/uploads/20181224/363944f333897882e4424bacb186e693.jpg', '', '/uploads/20181224/d21fb51f503d487d67a4c8c10577c458.rar', '', 0, '', '', '', '', 0);

-- ----------------------------
-- Table structure for tp_field
-- ----------------------------
DROP TABLE IF EXISTS `tp_field`;
CREATE TABLE `tp_field`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `module_id` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属模块',
  `field` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '字段名',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '字段别名',
  `tips` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '提示信息',
  `required` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否必填',
  `minlength` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '最小长度',
  `maxlength` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '最大长度',
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '字段类型',
  `data_source` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '数据源',
  `relation_model` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '模型关联',
  `relation_field` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '展示字段',
  `dict_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '字典类型',
  `is_add` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否可插入',
  `is_edit` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否可编辑',
  `is_list` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否可列表展示',
  `is_search` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否可查询',
  `is_sort` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否可排序',
  `search_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '查询类型',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `sort` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `remark` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `setup` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '其他设置',
  `group_id` int(8) NOT NULL DEFAULT 0 COMMENT '字段分组',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 356 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '模型字段表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_field
-- ----------------------------
INSERT INTO `tp_field` VALUES (1, 2, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 1, '自增ID', 'array (\r\n  \'default\' => \'0\',\r\n  \'extra_attr\' => \'\',\r\n  \'extra_class\' => \'\',\r\n  \'step\' => \'1\',\r\n  \'fieldtype\' => \'int\',\r\n  \'group\' => \'\',\r\n)', 0);
INSERT INTO `tp_field` VALUES (2, 1, 'email', '邮箱', '', 1, 0, 100, 'text', 0, '', '', '', 1, 0, 1, 1, 0, '=', 1, 2, '邮箱', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (4, 3, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 1, '自增ID', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (6, 4, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 1, 0, '=', 1, 1, '自增ID', 'array (\r\n  \'default\' => \'0\',\r\n  \'extra_attr\' => \'\',\r\n  \'extra_class\' => \'\',\r\n  \'step\' => \'1\',\r\n  \'fieldtype\' => \'int\',\r\n  \'group\' => \'\',\r\n)', 0);
INSERT INTO `tp_field` VALUES (7, 4, 'dict_name', '字典名称', '', 1, 0, 100, 'text', 0, '', '', '', 1, 1, 1, 1, 0, '=', 1, 2, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'char\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (9, 4, 'status', '状态', '', 1, 0, 0, 'radio', 1, '', '', '2', 1, 1, 1, 1, 0, '=', 1, 3, '', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (10, 4, 'create_time', '创建时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 5, '', 'array (\n  \'default\' => \'0\',\n  \'format\' => \'Y-m-d H:i:s\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (11, 4, 'update_time', '更新时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 6, '', 'array (\n  \'default\' => \'0\',\n  \'format\' => \'Y-m-d H:i:s\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (12, 4, 'remark', '备注', '', 0, 0, 200, 'textarea', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 7, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (13, 5, 'dict_label', '字典标签', '通常用做展示，如：男,女', 1, 0, 100, 'text', 0, '', '', '', 1, 1, 1, 1, 0, '=', 1, 1, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (14, 5, 'dict_value', '字典键值', '通常用做键值，如：0,1', 1, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 1, 1, '=', 1, 2, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (15, 5, 'dict_type', '字典类型', '', 1, 0, 5, 'select', 2, 'DictionaryType', 'dict_name', '', 1, 1, 1, 1, 1, '=', 1, 3, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'char\',\n)', 0);
INSERT INTO `tp_field` VALUES (16, 5, 'remark', '备注', '', 0, 0, 200, 'textarea', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 5, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (17, 5, 'create_time', '创建时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 1, '=', 1, 50, '', 'array (\n  \'default\' => \'0\',\n  \'format\' => \'Y-m-d H:i:s\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (18, 5, 'update_time', '更新时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 1, '=', 1, 50, '', 'array (\n  \'default\' => \'0\',\n  \'format\' => \'Y-m-d H:i:s\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (19, 5, 'sort', '排序', '', 1, 0, 5, 'number', 0, '', '', '', 1, 1, 1, 0, 1, '=', 1, 4, '', 'array (\n  \'default\' => \'50\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'step\' => \'1\',\n  \'fieldtype\' => \'int\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (20, 4, 'sort', '排序', '', 1, 0, 5, 'number', 0, '', '', '', 1, 1, 1, 0, 1, '=', 1, 4, '', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'step\' => \'1\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (21, 5, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\r\n  \'default\' => \'0\',\r\n  \'extra_attr\' => \'\',\r\n  \'extra_class\' => \'\',\r\n  \'step\' => \'1\',\r\n  \'fieldtype\' => \'int\',\r\n  \'group\' => \'\',\r\n)', 0);
INSERT INTO `tp_field` VALUES (22, 5, 'status', '状态', '', 1, 0, 0, 'radio', 1, '', '', '1', 1, 1, 1, 1, 1, '=', 1, 50, '', 'array (\n  \'default\' => \'1\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (23, 3, 'create_time', '创建时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '', 'array (\r\n  \'default\' => \'0\',\r\n  \'format\' => \'Y-m-d H:i:s\',\r\n  \'extra_attr\' => \'\',\r\n  \'extra_class\' => \'\',\r\n  \'placeholder\' => \'\',\r\n  \'fieldtype\' => \'int\',\r\n)', 0);
INSERT INTO `tp_field` VALUES (24, 3, 'update_time', '更新时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '', 'array (\r\n  \'default\' => \'0\',\r\n  \'format\' => \'Y-m-d H:i:s\',\r\n  \'extra_attr\' => \'\',\r\n  \'extra_class\' => \'\',\r\n  \'placeholder\' => \'\',\r\n  \'fieldtype\' => \'int\',\r\n)', 0);
INSERT INTO `tp_field` VALUES (25, 3, 'sort', '排序', '', 1, 0, 5, 'number', 0, '', '', '', 1, 1, 1, 0, 1, '=', 1, 8, '', 'array (\r\n  \'default\' => \'50\',\r\n  \'extra_attr\' => \'\',\r\n  \'extra_class\' => \'\',\r\n  \'step\' => \'1\',\r\n  \'fieldtype\' => \'int\',\r\n  \'group\' => \'\',\r\n)', 0);
INSERT INTO `tp_field` VALUES (26, 3, 'module_name', '模块名称', '填写中文名称，如：友情链接', 1, 0, 100, 'text', 0, '', '', '', 1, 1, 1, 1, 0, 'like', 1, 3, '模块名称', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (27, 3, 'table_name', '表名称', '除去表前缀的数据表名称，全部小写并以`_`分割，如：user_group', 1, 0, 50, 'text', 0, '', '', '', 1, 1, 1, 1, 0, 'like', 1, 2, '表名称', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (28, 3, 'model_name', '模型名称', '除去表前缀的数据表名称，驼峰法命名，且首字母大写，如：UserGroup', 1, 0, 50, 'text', 0, '', '', '', 1, 1, 1, 1, 0, 'like', 1, 4, '模型名称', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (29, 3, 'table_comment', '表描述', '', 1, 0, 200, 'text', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 5, '表描述', 'array (\r\n  \'default\' => \'\',\r\n  \'extra_attr\' => \'\',\r\n  \'extra_class\' => \'\',\r\n  \'placeholder\' => \'\',\r\n  \'fieldtype\' => \'varchar\',\r\n  \'group\' => \'\',\r\n)', 0);
INSERT INTO `tp_field` VALUES (30, 3, 'table_type', '表类型', '', 1, 0, 10, 'select', 1, '', '', '3', 1, 1, 1, 1, 0, '=', 1, 6, '表类型', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (31, 3, 'pk', '主键', '', 1, 0, 50, 'text', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 6, '主键', 'array (\n  \'default\' => \'id\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (32, 3, 'list_fields', '列表页字段', '', 1, 0, 255, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 9, '列表页字段', 'array (\r\n  \'default\' => \'*\',\r\n  \'extra_attr\' => \'\',\r\n  \'extra_class\' => \'\',\r\n  \'placeholder\' => \'\',\r\n  \'fieldtype\' => \'varchar\',\r\n  \'group\' => \'\',\r\n)', 0);
INSERT INTO `tp_field` VALUES (33, 3, 'remark', '备注', '', 0, 0, 200, 'textarea', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 16, '', 'array (\r\n  \'default\' => \'\',\r\n  \'extra_attr\' => \'\',\r\n  \'extra_class\' => \'\',\r\n  \'placeholder\' => \'\',\r\n  \'fieldtype\' => \'varchar\',\r\n)', 0);
INSERT INTO `tp_field` VALUES (34, 6, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 0, 0, '', 1, 1, '自增ID', 'array (\'default\' => \'0\',\'extra_attr\' => \'\',\'extra_class\' => \'\',\'step\' => \'1\',\'fieldtype\' => \'int\',\'group\' => \'\')', 0);
INSERT INTO `tp_field` VALUES (35, 6, 'create_time', '创建时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (36, 6, 'update_time', '更新时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (37, 6, 'name', '分组名称', '', 1, 0, 100, 'text', 0, '', '', '', 1, 1, 1, 1, 1, '=', 1, 2, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (38, 6, 'remark', '描述', '', 0, 0, 0, 'textarea', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 3, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'text\',\n)', 0);
INSERT INTO `tp_field` VALUES (39, 6, 'sort', '排序', '', 1, 0, 5, 'number', 0, '', '', '', 1, 1, 1, 0, 1, '=', 1, 4, '', 'array (\n  \'default\' => \'50\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'step\' => \'1\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (40, 6, 'status', '状态', '', 1, 0, 0, 'radio', 1, '', '', '1', 1, 1, 1, 1, 0, '=', 1, 5, '', 'array (\n  \'default\' => \'1\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (41, 2, 'module_id', '所属模块', '', 1, 0, 3, 'select', 2, 'Module', 'module_name', '', 1, 1, 1, 1, 1, '=', 1, 2, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (42, 2, 'field', '字段名', '', 1, 0, 100, 'text', 0, '', '', '', 1, 1, 1, 1, 0, '=', 1, 3, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (43, 2, 'name', '字段别名', '', 1, 0, 100, 'text', 0, '', '', '', 1, 1, 1, 1, 0, '=', 1, 4, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (44, 2, 'tips', '提示信息', '', 0, 0, 200, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 5, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (45, 2, 'required', '是否必填', '', 1, 0, 1, 'radio', 1, '', '', '2', 1, 1, 1, 0, 0, '=', 1, 6, '', 'array (\r\n  \'default\' => \'1\',\r\n  \'extra_attr\' => \'\',\r\n  \'extra_class\' => \'js_required\',\r\n  \'fieldtype\' => \'tinyint\',\r\n)', 0);
INSERT INTO `tp_field` VALUES (46, 2, 'minlength', '最小长度', '', 0, 0, 10, 'number', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 7, '', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'step\' => \'1\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (47, 2, 'maxlength', '最大长度', '', 0, 0, 10, 'number', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 8, '', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'step\' => \'1\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (48, 2, 'type', '字段类型', '', 1, 0, 20, 'text', 0, '', '', '', 1, 1, 1, 1, 1, '=', 1, 9, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (49, 2, 'data_source', '数据源', '', 0, 0, 10, 'number', 1, '', '', '9', 1, 1, 1, 1, 0, '=', 1, 10, '', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'step\' => \'1\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (50, 2, 'relation_model', '模型关联', '', 0, 0, 100, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 11, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (51, 2, 'relation_field', '展示字段', '', 0, 0, 100, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 12, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (52, 2, 'dict_code', '字典类型', '', 0, 0, 100, 'text', 2, 'DictionaryType', 'module_name', '', 1, 1, 1, 0, 0, '=', 1, 13, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (53, 2, 'is_add', '添加', '', 0, 0, 1, 'radio', 1, '', '', '2', 1, 1, 1, 0, 0, '=', 1, 14, '', 'array (\r\n  \'default\' => \'\',\r\n  \'extra_attr\' => \'\',\r\n  \'extra_class\' => \'js_is_add\',\r\n  \'fieldtype\' => \'tinyint\',\r\n)', 0);
INSERT INTO `tp_field` VALUES (54, 2, 'is_edit', '修改', '', 0, 0, 1, 'radio', 1, '', '', '2', 1, 1, 1, 0, 0, '=', 1, 15, '', 'array (\r\n  \'default\' => \'\',\r\n  \'extra_attr\' => \'\',\r\n  \'extra_class\' => \'js_is_edit\',\r\n  \'fieldtype\' => \'tinyint\',\r\n)', 0);
INSERT INTO `tp_field` VALUES (55, 2, 'is_list', '列表', '', 0, 0, 1, 'radio', 1, '', '', '2', 1, 1, 1, 0, 0, '=', 1, 16, '', 'array (\r\n  \'default\' => \'0\',\r\n  \'extra_attr\' => \'\',\r\n  \'extra_class\' => \'js_is_list\',\r\n  \'fieldtype\' => \'tinyint\',\r\n)', 0);
INSERT INTO `tp_field` VALUES (56, 2, 'is_search', '搜索', '', 0, 0, 1, 'radio', 1, '', '', '2', 1, 1, 1, 0, 0, '=', 1, 17, '', 'array (\r\n  \'default\' => \'0\',\r\n  \'extra_attr\' => \'\',\r\n  \'extra_class\' => \'js_is_search\',\r\n  \'fieldtype\' => \'tinyint\',\r\n)', 0);
INSERT INTO `tp_field` VALUES (57, 2, 'is_sort', '排序', '', 0, 0, 1, 'radio', 1, '', '', '2', 1, 1, 1, 0, 0, '=', 1, 18, '', 'array (\r\n  \'default\' => \'0\',\r\n  \'extra_attr\' => \'\',\r\n  \'extra_class\' => \'js_is_sort\',\r\n  \'fieldtype\' => \'tinyint\',\r\n)', 0);
INSERT INTO `tp_field` VALUES (58, 2, 'search_type', '查询类型', '', 0, 0, 100, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 19, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (59, 2, 'status', '状态', '', 1, 0, 0, 'radio', 1, '', '', '1', 1, 1, 1, 1, 0, '=', 1, 20, '', 'array (\r\n  \'default\' => \'1\',\r\n  \'extra_attr\' => \'\',\r\n  \'extra_class\' => \'\',\r\n  \'fieldtype\' => \'tinyint\',\r\n)', 0);
INSERT INTO `tp_field` VALUES (60, 2, 'sort', '排序', '', 1, 0, 5, 'number', 0, '', '', '', 1, 1, 1, 0, 1, '=', 1, 21, '', 'array (\r\n  \'default\' => \'50\',\r\n  \'extra_attr\' => \'\',\r\n  \'extra_class\' => \'\',\r\n  \'step\' => \'1\',\r\n  \'fieldtype\' => \'int\',\r\n)', 0);
INSERT INTO `tp_field` VALUES (61, 2, 'remark', '备注', '', 0, 0, 200, 'textarea', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 22, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (62, 2, 'setup', '其他设置', '', 0, 0, 0, 'textarea', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 23, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'text\',\n)', 0);
INSERT INTO `tp_field` VALUES (63, 1, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 0, 0, '', 1, 1, '自增ID', 'array (\'default\' => \'0\',\'extra_attr\' => \'\',\'extra_class\' => \'\',\'step\' => \'1\',\'fieldtype\' => \'int\',\'group\' => \'\')', 0);
INSERT INTO `tp_field` VALUES (64, 1, 'password', '密码', '', 0, 0, 100, 'password', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 3, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (65, 1, 'sex', '性别', '', 1, 0, 1, 'radio', 1, '', '', '4', 1, 1, 1, 1, 1, '=', 1, 4, '', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (66, 1, 'last_login_time', '最后登录时间', '', 0, 0, 10, 'datetime', 0, '', '', '', 1, 0, 1, 0, 0, '=', 1, 5, '', 'array (\n  \'default\' => \'0\',\n  \'format\' => \'Y-m-d H:i:s\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (67, 1, 'last_login_ip', '最后登录IP', '', 0, 0, 15, 'text', 0, '', '', '', 1, 0, 1, 1, 0, '=', 1, 6, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (68, 1, 'qq', 'QQ', '', 0, 0, 20, 'text', 0, '', '', '', 1, 0, 1, 1, 0, '=', 1, 7, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (69, 1, 'mobile', '手机', '', 0, 0, 20, 'text', 0, '', '', '', 1, 0, 1, 1, 0, '=', 1, 8, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (70, 1, 'mobile_validated', '手机验证', '', 1, 0, 3, 'radio', 1, '', '', '5', 1, 1, 1, 1, 1, '=', 1, 9, '', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (71, 1, 'email_validated', '邮箱验证', '', 1, 0, 3, 'radio', 1, '', '', '5', 1, 1, 1, 1, 1, '=', 1, 10, '', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (72, 1, 'type_id', '所属分组', '', 1, 0, 3, 'select', 2, 'UsersType', 'name', '', 1, 1, 1, 1, 1, '=', 1, 11, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (73, 1, 'status', '状态', '', 1, 0, 0, 'radio', 1, '', '', '1', 1, 1, 1, 1, 0, '=', 1, 12, '', 'array (\r\n  \'default\' => \'1\',\r\n  \'extra_attr\' => \'\',\r\n  \'extra_class\' => \'\',\r\n  \'fieldtype\' => \'tinyint\',\r\n)', 0);
INSERT INTO `tp_field` VALUES (74, 1, 'create_ip', '注册IP', '', 0, 0, 15, 'text', 0, '', '', '', 1, 0, 1, 0, 0, '=', 1, 13, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (75, 1, 'create_time', '创建时间', '', 0, 0, 10, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 14, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (76, 1, 'update_time', '更新时间', '', 0, 0, 10, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 15, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (77, 2, 'group_id', '字段分组', '用于添加和修改时显示在对应的分组中', 0, 0, 8, 'select', 2, 'FieldGrooup', 'group_name', '', 1, 1, 0, 0, 0, '=', 1, 50, '用于添加和修改时显示在对应的分组中', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'char\',\n)', 0);
INSERT INTO `tp_field` VALUES (78, 7, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 0, 0, '', 1, 1, '自增ID', 'array (\'default\' => \'0\',\'extra_attr\' => \'\',\'extra_class\' => \'\',\'step\' => \'1\',\'fieldtype\' => \'int\',\'group\' => \'\')', 0);
INSERT INTO `tp_field` VALUES (79, 7, 'create_time', '创建时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (80, 7, 'update_time', '更新时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (81, 7, 'module_id', '所属模块', '用于判断当前字段所属模块', 1, 0, 5, 'select', 2, 'Module', 'module_name', '', 1, 1, 1, 1, 0, '=', 1, 2, '', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (82, 7, 'group_name', '分组名称', '用于添加/修改时显示对应的分组名称', 1, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 1, 0, '=', 1, 3, '用于添加/修改时显示对应的分组名称', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (83, 7, 'status', '状态', '', 1, 0, 0, 'radio', 1, '', '', '1', 1, 1, 1, 1, 0, '=', 1, 4, '', 'array (\n  \'default\' => \'1\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (84, 7, 'sort', '排序', '', 1, 0, 5, 'number', 0, '', '', '', 1, 1, 1, 0, 1, '=', 1, 5, '', 'array (\n  \'default\' => \'50\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'step\' => \'1\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (85, 8, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 0, 0, '', 1, 1, '自增ID', 'array (\'default\' => \'0\',\'extra_attr\' => \'\',\'extra_class\' => \'\',\'step\' => \'1\',\'fieldtype\' => \'int\',\'group\' => \'\')', 0);
INSERT INTO `tp_field` VALUES (86, 8, 'create_time', '创建时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (87, 8, 'update_time', '更新时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (88, 8, 'name', '网站名称', '', 1, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 1, 0, 'LIKE', 1, 2, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (89, 8, 'url', '网站地址', '请填写完整的网站地址', 1, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 1, 0, 'LIKE', 1, 3, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (90, 8, 'logo', '网站logo', '', 0, 0, 0, 'image', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 4, '', 'array (\n  \'ext\' => \'jpg|jpeg|gif|png\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (91, 8, 'description', '描述', '', 0, 0, 0, 'textarea', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 5, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (92, 8, 'sort', '排序', '', 1, 0, 0, 'number', 0, '', '', '', 1, 1, 1, 0, 1, '=', 1, 6, '', 'array (\n  \'default\' => \'50\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'step\' => \'1\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (93, 8, 'status', '状态', '', 1, 0, 0, 'radio', 1, '', '', '1', 1, 1, 1, 1, 0, '=', 1, 7, '', 'array (\n  \'default\' => \'1\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (94, 9, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 0, 0, '', 1, 1, '自增ID', 'array (\'default\' => \'0\',\'extra_attr\' => \'\',\'extra_class\' => \'\',\'step\' => \'1\',\'fieldtype\' => \'int\',\'group\' => \'\')', 0);
INSERT INTO `tp_field` VALUES (95, 9, 'create_time', '创建时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (96, 9, 'update_time', '更新时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (97, 9, 'name', '分组名称', '', 1, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 1, 1, 'LIKE', 1, 2, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (98, 9, 'description', '备注', '', 0, 0, 0, 'textarea', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 3, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (99, 9, 'sort', '排序', '', 1, 0, 0, 'number', 0, '', '', '', 1, 1, 1, 0, 1, '=', 1, 4, '', 'array (\n  \'default\' => \'50\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'step\' => \'1\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (101, 9, 'status', '状态', '', 1, 0, 0, 'radio', 1, '', '', '1', 1, 1, 1, 1, 0, '=', 1, 5, '', 'array (\n  \'default\' => \'1\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (102, 3, 'is_sort', '排序字段', '选择是则在生成模块时自动创建`排序`字段', 0, 0, 0, 'radio', 1, '', '', '2', 1, 1, 1, 0, 0, '=', 1, 10, '生成模块时自动创建', 'array (\n  \'default\' => \'1\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (103, 3, 'is_status', '状态字段', '选择是则在生成模块时自动创建`状态`字段', 0, 0, 0, 'radio', 1, '', '', '2', 1, 1, 1, 0, 0, '=', 1, 11, '生成模块时自动创建', 'array (\n  \'default\' => \'1\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (104, 10, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 0, 0, '', 1, 1, '自增ID', 'array (\'default\' => \'0\',\'extra_attr\' => \'\',\'extra_class\' => \'\',\'step\' => \'1\',\'fieldtype\' => \'int\',\'group\' => \'\')', 0);
INSERT INTO `tp_field` VALUES (105, 10, 'create_time', '创建时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (106, 10, 'update_time', '更新时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (107, 10, 'sort', '排序', '', 1, 0, 8, 'number', 0, '', '', '', 1, 1, 1, 0, 1, '=', 1, 49, '', 'array (\'default\' => \'50\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'step\' => \'1\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (108, 10, 'status', '状态', '', 1, 0, 1, 'radio', 1, '', '', '1', 1, 1, 1, 1, 0, '=', 1, 48, '', 'array (\'default\' => \'1\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'fieldtype\' => \'tinyint\',)', 0);
INSERT INTO `tp_field` VALUES (109, 10, 'type_id', '广告位', '', 1, 0, 0, 'select2', 2, 'AdType', 'name', '', 1, 1, 1, 1, 0, '=', 1, 2, '所属广告位', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (110, 10, 'name', '广告名称', '', 1, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 1, 0, 'LIKE', 1, 3, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (111, 10, 'image', '图片', '', 0, 0, 0, 'image', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 4, '', 'array (\n  \'ext\' => \'jpg|jpeg|gif|png\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (112, 10, 'thumb', '缩略图', '', 0, 0, 0, 'image', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 5, '', 'array (\n  \'ext\' => \'jpg|jpeg|gif|png\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (113, 10, 'url', '链接地址', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 6, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (114, 10, 'description', '备注', '', 0, 0, 250, 'textarea', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 7, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (115, 11, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 0, 0, '', 1, 1, '自增ID', 'array (\'default\' => \'0\',\'extra_attr\' => \'\',\'extra_class\' => \'\',\'step\' => \'1\',\'fieldtype\' => \'int\',\'group\' => \'\')', 0);
INSERT INTO `tp_field` VALUES (116, 11, 'create_time', '创建时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (117, 11, 'update_time', '更新时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (118, 11, 'sort', '排序', '', 1, 0, 8, 'number', 0, '', '', '', 1, 1, 1, 0, 1, '=', 1, 49, '', 'array (\'default\' => \'50\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'step\' => \'1\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (119, 11, 'status', '状态', '', 1, 0, 1, 'radio', 1, '', '', '1', 1, 1, 1, 1, 0, '=', 1, 48, '', 'array (\'default\' => \'1\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'fieldtype\' => \'tinyint\',)', 0);
INSERT INTO `tp_field` VALUES (120, 11, 'title', '碎片标题', '通常为中文，如：关于我们', 1, 0, 255, 'text', 0, '', '', '', 1, 1, 1, 1, 0, 'LIKE', 1, 2, '标题', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (121, 11, 'name', '调用名称', '通常为英文，如：AboutUs', 1, 0, 255, 'text', 0, '', '', '', 1, 1, 1, 1, 0, 'LIKE', 1, 3, '调用名称', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (122, 11, 'content', '碎片内容', '', 0, 0, 0, 'editor', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 4, '碎片内容', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'height\' => \'\',\n  \'fieldtype\' => \'text\',\n)', 0);
INSERT INTO `tp_field` VALUES (123, 11, 'url', '链接地址', '', 0, 0, 255, 'text', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 5, '链接地址', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (124, 11, 'image', '图片', '', 0, 0, 0, 'image', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 6, '', 'array (\n  \'ext\' => \'jpg|jpeg|gif|png\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (125, 11, 'description', '描述', '', 0, 0, 255, 'textarea', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 7, '描述', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (133, 3, 'top_button', '顶部按钮', '列表页面顶部按钮组中的按钮', 0, 0, 255, 'checkbox', 1, '', '', '6', 1, 1, 0, 0, 0, '=', 1, 12, '列表页面顶部按钮组中的按钮', 'array (\n  \'default\' => \'add,edit,del,export\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (134, 3, 'right_button', '右侧按钮', '列表页面右侧按钮组中的按钮', 0, 0, 255, 'checkbox', 1, '', '', '7', 1, 1, 0, 0, 0, '=', 1, 13, '列表页面右侧按钮组中的按钮', 'array (\n  \'default\' => \'edit,delete\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (135, 13, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 0, 0, '', 1, 1, '自增ID', 'array (\'default\' => \'0\',\'extra_attr\' => \'\',\'extra_class\' => \'\',\'step\' => \'1\',\'fieldtype\' => \'int\',\'group\' => \'\')', 1);
INSERT INTO `tp_field` VALUES (136, 13, 'create_time', '添加时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (137, 13, 'update_time', '更新时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\n  \'default\' => \'0\',\n  \'format\' => \'Y-m-d H:i:s\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (138, 13, 'name', '网站名称', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 2, '网站名称', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 1);
INSERT INTO `tp_field` VALUES (139, 13, 'logo', '网站LOGO', '', 0, 0, 0, 'image', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 3, '', 'array (\n  \'ext\' => \'jpg|jpeg|gif|png\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 1);
INSERT INTO `tp_field` VALUES (140, 13, 'icp', '备案号', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 4, '备案号', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 1);
INSERT INTO `tp_field` VALUES (141, 13, 'copyright', '版权信息', '', 0, 0, 255, 'textarea', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 5, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 1);
INSERT INTO `tp_field` VALUES (142, 13, 'url', '网站地址', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 6, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 1);
INSERT INTO `tp_field` VALUES (143, 13, 'address', '公司地址', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 7, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 1);
INSERT INTO `tp_field` VALUES (144, 13, 'contacts', '联系人', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 8, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 1);
INSERT INTO `tp_field` VALUES (145, 13, 'tel', '联系电话', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 9, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 1);
INSERT INTO `tp_field` VALUES (146, 13, 'mobile_phone', '手机号码', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 10, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 1);
INSERT INTO `tp_field` VALUES (147, 13, 'fax', '传真号码', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 11, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 1);
INSERT INTO `tp_field` VALUES (148, 13, 'email', '邮箱账号', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 12, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 1);
INSERT INTO `tp_field` VALUES (149, 13, 'qq', 'QQ', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 13, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 1);
INSERT INTO `tp_field` VALUES (150, 13, 'qrcode', '二维码', '', 0, 0, 0, 'image', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 14, '', 'array (\n  \'ext\' => \'jpg|jpeg|gif|png\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 1);
INSERT INTO `tp_field` VALUES (151, 13, 'title', 'SEO标题', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 0, 0, 'LIKE', 1, 15, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 2);
INSERT INTO `tp_field` VALUES (152, 13, 'key', 'SEO关键字', '', 0, 0, 0, 'textarea', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 16, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 2);
INSERT INTO `tp_field` VALUES (153, 13, 'des', 'SEO描述', '', 0, 0, 0, 'textarea', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 17, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 2);
INSERT INTO `tp_field` VALUES (154, 13, 'mobile', '手机端', '开启后自动跳转到mobile，自适应网站或无手机端网站请关闭', 0, 0, 0, 'radio', 1, '', '', '8', 1, 1, 1, 0, 0, '=', 1, 18, '', 'array (\n  \'default\' => \'1\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 3);
INSERT INTO `tp_field` VALUES (156, 13, 'code', '后台验证码', '后台登录时是否需要验证码', 0, 0, 0, 'radio', 1, '', '', '8', 1, 1, 1, 0, 0, '=', 1, 19, '', 'array (\n  \'default\' => \'1\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 3);
INSERT INTO `tp_field` VALUES (157, 13, 'message_code', '前台验证码', '前台留言等是否需要验证码', 0, 0, 0, 'radio', 1, '', '', '8', 1, 1, 1, 0, 0, '=', 1, 20, '', 'array (\n  \'default\' => \'1\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 3);
INSERT INTO `tp_field` VALUES (158, 13, 'message_send_mail', '留言邮件提醒', '前台留言时是否需要邮件提醒，如开启请先进行邮箱配置', 0, 0, 0, 'radio', 1, '', '', '8', 1, 1, 1, 0, 0, '=', 1, 21, '', 'array (\n  \'default\' => \'1\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 3);
INSERT INTO `tp_field` VALUES (159, 13, 'template_opening', '模板修改备份', '开启后后台模板管理中修改文件时会进行自动备份', 0, 0, 0, 'radio', 1, '', '', '8', 1, 1, 1, 0, 0, '=', 1, 22, '', 'array (\n  \'default\' => \'1\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 3);
INSERT INTO `tp_field` VALUES (160, 13, 'template', '模板目录', '模版所在的目录名称，默认为 default', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 23, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 4);
INSERT INTO `tp_field` VALUES (161, 13, 'html', 'Html目录', 'Html所在的目录名称，默认为 html', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 24, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 4);
INSERT INTO `tp_field` VALUES (162, 13, 'other', '其他', '其他信息', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 50, '备用字段', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 5);
INSERT INTO `tp_field` VALUES (163, 14, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 0, 0, '', 1, 1, '自增ID', 'array (\'default\' => \'0\',\'extra_attr\' => \'\',\'extra_class\' => \'\',\'step\' => \'1\',\'fieldtype\' => \'int\',\'group\' => \'\')', 0);
INSERT INTO `tp_field` VALUES (164, 14, 'create_time', '添加时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (165, 14, 'update_time', '更新时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\n  \'default\' => \'0\',\n  \'format\' => \'Y-m-d H:i:s\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (166, 14, 'status', '状态', '', 1, 0, 1, 'radio', 1, '', '', '1', 1, 1, 1, 1, 0, '=', 1, 48, '', 'array (\'default\' => \'1\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'fieldtype\' => \'tinyint\',)', 0);
INSERT INTO `tp_field` VALUES (167, 14, 'title', '角色组', '', 1, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 0, 0, 'LIKE', 1, 2, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (168, 14, 'rules', '权限', '', 0, 0, 0, 'textarea', 0, '', '', '', 0, 0, 0, 0, 0, '=', 1, 3, '权限', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'text\',\n)', 0);
INSERT INTO `tp_field` VALUES (169, 15, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 0, 0, '', 1, 1, '自增ID', 'array (\'default\' => \'0\',\'extra_attr\' => \'\',\'extra_class\' => \'\',\'step\' => \'1\',\'fieldtype\' => \'int\',\'group\' => \'\')', 0);
INSERT INTO `tp_field` VALUES (170, 15, 'create_time', '添加时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (171, 15, 'update_time', '更新时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\n  \'default\' => \'0\',\n  \'format\' => \'Y-m-d H:i:s\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (172, 15, 'status', '状态', '', 1, 0, 1, 'radio', 1, '', '', '1', 1, 1, 1, 1, 0, '=', 1, 48, '', 'array (\'default\' => \'1\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'fieldtype\' => \'tinyint\',)', 0);
INSERT INTO `tp_field` VALUES (173, 15, 'username', '用户名', '用户名在4到25个字符之间', 1, 4, 25, 'text', 0, '', '', '', 1, 1, 1, 1, 0, '=', 1, 2, '用户名', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (174, 15, 'password', '密码', '密码在5到25个字符之间', 1, 5, 25, 'password', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 3, '密码', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (175, 15, 'login_time', '登录时间', '', 0, 0, 0, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 4, '最后登录时间', 'array (\n  \'default\' => \'0\',\n  \'format\' => \'Y-m-d H:i:s\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (176, 15, 'login_ip', '登录IP', '', 0, 0, 0, 'text', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 5, '最后登录IP', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (177, 15, 'nickname', '昵称', '昵称在4到25个字符之间', 1, 4, 25, 'text', 0, '', '', '', 1, 1, 1, 0, 0, 'LIKE', 1, 6, '昵称', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (178, 15, 'image', '头像', '', 1, 0, 0, 'image', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 6, '头像', 'array (\n  \'ext\' => \'jpg|jpeg|gif|png\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (179, 16, 'status', '菜单状态', '是否需要显示在左侧菜单', 1, 0, 1, 'radio', 1, '', '', '1', 1, 1, 1, 0, 0, '=', 1, 48, '', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (180, 16, 'update_time', '更新时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\n  \'default\' => \'0\',\n  \'format\' => \'Y-m-d H:i:s\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (181, 16, 'create_time', '添加时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (182, 16, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 0, 0, '', 1, 1, '自增ID', 'array (\'default\' => \'0\',\'extra_attr\' => \'\',\'extra_class\' => \'\',\'step\' => \'1\',\'fieldtype\' => \'int\',\'group\' => \'\')', 0);
INSERT INTO `tp_field` VALUES (183, 16, 'pid', '父ID', '', 0, 0, 0, 'select2', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 2, '', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (184, 16, 'name', '控制器/方法', '', 1, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 4, '控制器/方法', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (185, 16, 'title', '权限名称', '', 1, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 0, 0, 'LIKE', 1, 5, '权限名称', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (186, 16, 'auth_open', '验证权限', '', 0, 0, 0, 'radio', 1, '', '', '2', 1, 1, 1, 0, 0, '=', 1, 7, '', 'array (\n  \'default\' => \'1\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (187, 16, 'icon', '图标名称', '如：fa fa-cogs', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 3, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (188, 16, 'sort', '排序', '', 1, 0, 8, 'number', 0, '', '', '', 1, 1, 1, 0, 1, '=', 1, 49, '', 'array (\'default\' => \'50\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'step\' => \'1\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (189, 17, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 0, 0, '', 1, 1, '自增ID', 'array (\'default\' => \'0\',\'extra_attr\' => \'\',\'extra_class\' => \'\',\'step\' => \'1\',\'fieldtype\' => \'int\',\'group\' => \'\')', 0);
INSERT INTO `tp_field` VALUES (190, 17, 'create_time', '添加时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (191, 17, 'update_time', '更新时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\n  \'default\' => \'0\',\n  \'format\' => \'Y-m-d H:i:s\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (192, 17, 'admin_id', '管理员', '', 0, 0, 8, 'select', 2, 'Admin', 'username', '', 1, 0, 1, 1, 0, 'LIKE', 1, 2, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (193, 17, 'url', '操作页面	', '', 0, 0, 0, 'text', 0, '', '', '', 1, 0, 1, 1, 0, 'LIKE', 1, 3, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (194, 17, 'title', '日志标题', '', 0, 0, 100, 'text', 0, '', '', '', 1, 0, 1, 1, 0, 'LIKE', 1, 4, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (195, 17, 'content', '日志内容', '', 0, 0, 0, 'textarea', 0, '', '', '', 1, 0, 0, 0, 0, '=', 1, 5, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'text\',\n)', 0);
INSERT INTO `tp_field` VALUES (196, 17, 'ip', '操作IP', '', 0, 0, 20, 'text', 0, '', '', '', 1, 0, 1, 0, 0, '=', 1, 6, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (197, 17, 'user_agent', 'User-Agent', '', 0, 0, 0, 'textarea', 0, '', '', '', 1, 0, 1, 0, 0, '=', 1, 7, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'text\',\n)', 0);
INSERT INTO `tp_field` VALUES (198, 3, 'is_single', '单页模式', '选择是后列表页会自动跳转到添加或修改页面', 0, 0, 0, 'radio', 1, '', '', '2', 1, 1, 1, 1, 0, '=', 1, 14, '选择是后列表页会自动跳转到添加或修改页面', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (199, 3, 'show_all', '查看全部', '添加/修改页面头部是否显示`查看全部`按钮', 0, 0, 0, 'radio', 1, '', '', '2', 1, 1, 0, 0, 0, '=', 1, 15, '添加/修改页面头部是否显示`查看全部`按钮', 'array (\n  \'default\' => \'1\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (200, 19, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 0, 0, '', 1, 1, '自增ID', 'array (\'default\' => \'0\',\'extra_attr\' => \'\',\'extra_class\' => \'\',\'step\' => \'1\',\'fieldtype\' => \'int\',\'group\' => \'\')', 0);
INSERT INTO `tp_field` VALUES (201, 19, 'create_time', '添加时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (202, 19, 'update_time', '更新时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\n  \'default\' => \'0\',\n  \'format\' => \'Y-m-d H:i:s\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (203, 19, 'sort', '排序', '', 1, 0, 8, 'number', 0, '', '', '', 1, 1, 1, 0, 1, '=', 1, 49, '', 'array (\'default\' => \'50\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'step\' => \'1\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (204, 19, 'status', '状态', '', 1, 0, 1, 'radio', 1, '', '', '1', 1, 1, 1, 1, 0, '=', 1, 48, '', 'array (\'default\' => \'1\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'fieldtype\' => \'tinyint\',)', 0);
INSERT INTO `tp_field` VALUES (205, 18, 'status', '状态', '', 1, 0, 1, 'radio', 1, '', '', '1', 1, 1, 1, 1, 0, '=', 1, 48, '', 'array (\'default\' => \'1\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'fieldtype\' => \'tinyint\',)', 0);
INSERT INTO `tp_field` VALUES (206, 18, 'sort', '排序', '', 1, 0, 8, 'number', 0, '', '', '', 1, 1, 1, 0, 1, '=', 1, 49, '', 'array (\'default\' => \'50\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'step\' => \'1\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (207, 18, 'update_time', '更新时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\n  \'default\' => \'0\',\n  \'format\' => \'Y-m-d H:i:s\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (208, 18, 'create_time', '添加时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (209, 18, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 0, 0, '', 1, 1, '自增ID', 'array (\'default\' => \'0\',\'extra_attr\' => \'\',\'extra_class\' => \'\',\'step\' => \'1\',\'fieldtype\' => \'int\',\'group\' => \'\')', 0);
INSERT INTO `tp_field` VALUES (210, 20, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 0, 0, '', 1, 0, '自增ID', 'array (\'default\' => \'0\',\'extra_attr\' => \'\',\'extra_class\' => \'\',\'step\' => \'1\',\'fieldtype\' => \'int\',\'group\' => \'\')', 6);
INSERT INTO `tp_field` VALUES (211, 20, 'create_time', '添加时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 6);
INSERT INTO `tp_field` VALUES (212, 20, 'update_time', '更新时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\n  \'default\' => \'0\',\n  \'format\' => \'Y-m-d H:i:s\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'int\',\n)', 6);
INSERT INTO `tp_field` VALUES (213, 20, 'sort', '排序', '', 1, 0, 8, 'number', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 49, '', 'array (\n  \'default\' => \'50\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'step\' => \'1\',\n  \'fieldtype\' => \'int\',\n)', 6);
INSERT INTO `tp_field` VALUES (214, 20, 'status', '状态', '', 1, 0, 1, 'radio', 1, '', '', '1', 1, 1, 1, 0, 0, '=', 1, 48, '', 'array (\n  \'default\' => \'1\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 6);
INSERT INTO `tp_field` VALUES (215, 20, 'cate_name', '栏目名称', '', 1, 0, 255, 'text', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 3, '栏目名称', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 6);
INSERT INTO `tp_field` VALUES (216, 20, 'en_name', '英文名称', '', 0, 0, 255, 'text', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 4, '英文名称', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 6);
INSERT INTO `tp_field` VALUES (217, 20, 'cate_folder', '栏目目录', '请填写不含空格的字母、数字，用于URL美化，如：AboutUs , about_us , about/us', 0, 0, 255, 'text', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 5, '栏目目录', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 6);
INSERT INTO `tp_field` VALUES (218, 20, 'parent_id', '上级栏目', '', 0, 0, 0, 'select', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 2, '上级栏目', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'int\',\n)', 6);
INSERT INTO `tp_field` VALUES (219, 20, 'module_id', '所属模块', '', 1, 0, 0, 'select', 2, 'Module', 'module_name', '', 1, 1, 1, 0, 0, '=', 1, 1, '所属模块', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 6);
INSERT INTO `tp_field` VALUES (220, 20, 'url', '外部链接', '如需跳转，请填写完整的网站地址，为空则不跳转', 0, 0, 255, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 6, '外部链接', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 8);
INSERT INTO `tp_field` VALUES (221, 20, 'image', '栏目图片', '', 0, 0, 255, 'image', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 7, '栏目图片', 'array (\n  \'ext\' => \'jpg|jpeg|gif|png\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 6);
INSERT INTO `tp_field` VALUES (222, 20, 'ico_image', 'ICO图片', '', 0, 0, 255, 'image', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 8, 'ICO图片', 'array (\n  \'ext\' => \'jpg|jpeg|gif|png\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 6);
INSERT INTO `tp_field` VALUES (223, 20, 'title', 'SEO标题', '', 0, 0, 255, 'text', 0, '', '', '', 1, 1, 0, 0, 0, 'LIKE', 1, 9, 'SEO标题', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 7);
INSERT INTO `tp_field` VALUES (224, 20, 'keywords', 'SEO关键字', '', 0, 0, 255, 'textarea', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 10, 'SEO关键字', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 7);
INSERT INTO `tp_field` VALUES (225, 20, 'description', 'SEO描述', '', 0, 0, 255, 'textarea', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 11, 'SEO描述', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 7);
INSERT INTO `tp_field` VALUES (226, 20, 'summary', '简介', '', 0, 0, 0, 'textarea', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 12, '栏目简介', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'text\',\n)', 6);
INSERT INTO `tp_field` VALUES (227, 20, 'template_list', '列表模板', '', 0, 0, 255, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 13, '列表模板', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 8);
INSERT INTO `tp_field` VALUES (228, 20, 'template_show', '详情模版', '', 0, 0, 255, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 14, '详情模版', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 8);
INSERT INTO `tp_field` VALUES (229, 20, 'page_size', '分页条数', '分页显示的数量，为空时默认值为系统设置中的值', 0, 0, 5, 'number', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 15, '分页条数', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'step\' => \'1\',\n  \'fieldtype\' => \'char\',\n)', 8);
INSERT INTO `tp_field` VALUES (230, 20, 'is_menu', '导航状态', '', 0, 0, 0, 'radio', 1, '', '', '1', 1, 1, 1, 0, 0, '=', 1, 16, '导航状态', 'array (\n  \'default\' => \'1\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 6);
INSERT INTO `tp_field` VALUES (231, 20, 'is_next', '跳转下级', '是否直接跳转到下级第一个栏目', 0, 0, 0, 'radio', 1, '', '', '2', 1, 1, 1, 0, 0, '=', 1, 17, '跳转下级', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 8);
INSERT INTO `tp_field` VALUES (232, 20, 'is_blank', '新窗口打开', '', 0, 0, 0, 'radio', 1, '', '', '2', 1, 1, 0, 0, 0, '=', 1, 18, '新窗口打开', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 8);
INSERT INTO `tp_field` VALUES (233, 18, 'cate_id', '栏目', '', 1, 0, 0, 'select', 2, 'Cate', 'cate_name', '', 1, 1, 1, 1, 0, '=', 1, 2, '栏目', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (234, 18, 'title', '标题', '', 0, 0, 255, 'text', 0, '', '', '', 1, 1, 1, 0, 0, 'LIKE', 1, 3, '标题', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (235, 18, 'content', '内容', '', 0, 0, 0, 'editor', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 4, '内容', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'height\' => \'\',\n  \'fieldtype\' => \'text\',\n)', 0);
INSERT INTO `tp_field` VALUES (236, 19, 'cate_id', '栏目', '', 1, 0, 0, 'select', 2, 'Cate', 'cate_name', '', 1, 1, 1, 1, 0, '=', 1, 2, '栏目', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (237, 19, 'title', '标题', '', 1, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 1, 0, 'LIKE', 1, 3, '标题', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (238, 19, 'author', '作者', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 4, '作者', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (239, 19, 'source', '来源', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 5, '来源', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (240, 19, 'content', '内容', '', 0, 0, 0, 'editor', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 6, '内容', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'height\' => \'\',\n  \'fieldtype\' => \'text\',\n)', 0);
INSERT INTO `tp_field` VALUES (241, 19, 'summary', '摘要', '', 0, 0, 0, 'textarea', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 7, '摘要', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'text\',\n)', 0);
INSERT INTO `tp_field` VALUES (242, 19, 'image', '图片', '', 0, 0, 0, 'image', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 8, '图片', 'array (\n  \'ext\' => \'jpg|jpeg|gif|png\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (243, 19, 'images', '图片集', '', 0, 0, 0, 'images', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 9, '图片集', 'array (\n  \'ext\' => \'jpg|jpeg|gif|png\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'text\',\n)', 0);
INSERT INTO `tp_field` VALUES (244, 19, 'download', '文件下载', '', 0, 0, 0, 'file', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 10, '文件下载', 'array (\n  \'ext\' => \'rar|zip|avi|rmvb|3gp|flv|mp3|txt|doc|xls|ppt|pdf|xls|docx|xlsx|doc\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (245, 19, 'tags', 'TAG', '', 0, 0, 0, 'tag', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 11, 'TAG', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (246, 19, 'hits', '点击次数', '', 0, 0, 0, 'number', 0, '', '', '', 1, 1, 1, 0, 1, '=', 1, 12, '点击次数', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'step\' => \'1\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (247, 19, 'keywords', '关键词', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 13, '关键词', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (248, 19, 'description', '描述', '', 0, 0, 0, 'textarea', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 14, '描述', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (249, 19, 'template', '模板', '单独设置此条记录的模板，如：article_show.html 或 article_show', 0, 0, 30, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 15, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (250, 3, 'add_param', '添加参数', '列表页面顶部按钮组中添加按钮的参数，如 cate_id,多个用`,`分割', 0, 0, 100, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 17, '列表页面顶部按钮组中添加按钮的参数，如 cate_id,多个用`,`分割', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (251, 21, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 0, 0, '', 1, 1, '自增ID', 'array (\'default\' => \'0\',\'extra_attr\' => \'\',\'extra_class\' => \'\',\'step\' => \'1\',\'fieldtype\' => \'int\',\'group\' => \'\')', 0);
INSERT INTO `tp_field` VALUES (252, 21, 'create_time', '添加时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (253, 21, 'update_time', '更新时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\n  \'default\' => \'0\',\n  \'format\' => \'Y-m-d H:i:s\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (254, 21, 'sort', '排序', '', 1, 0, 8, 'number', 0, '', '', '', 1, 1, 1, 0, 1, '=', 1, 49, '', 'array (\'default\' => \'50\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'step\' => \'1\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (255, 21, 'status', '状态', '', 1, 0, 1, 'radio', 1, '', '', '1', 1, 1, 1, 1, 0, '=', 1, 48, '', 'array (\'default\' => \'1\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'fieldtype\' => \'tinyint\',)', 0);
INSERT INTO `tp_field` VALUES (256, 21, 'cate_id', '栏目', '', 1, 0, 0, 'select', 2, 'Cate', 'cate_name', '', 1, 1, 1, 1, 0, '=', 1, 2, '栏目', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (257, 21, 'title', '标题', '', 1, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 1, 0, 'LIKE', 1, 3, '标题', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (258, 21, 'author', '作者', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 4, '作者', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (259, 21, 'source', '来源', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 5, '来源', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (260, 21, 'content', '内容', '', 0, 0, 0, 'editor', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 6, '内容', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'height\' => \'\',\n  \'fieldtype\' => \'text\',\n)', 0);
INSERT INTO `tp_field` VALUES (261, 21, 'summary', '摘要', '', 0, 0, 0, 'textarea', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 7, '摘要', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'text\',\n)', 0);
INSERT INTO `tp_field` VALUES (262, 21, 'image', '图片', '', 0, 0, 0, 'image', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 8, '图片', 'array (\n  \'ext\' => \'jpg|jpeg|gif|png\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (263, 21, 'images', '图片集', '', 0, 0, 0, 'images', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 9, '图片集', 'array (\n  \'ext\' => \'jpg|jpeg|gif|png\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'text\',\n)', 0);
INSERT INTO `tp_field` VALUES (264, 21, 'download', '文件下载', '', 0, 0, 0, 'file', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 10, '文件下载', 'array (\n  \'ext\' => \'rar|zip|avi|rmvb|3gp|flv|mp3|txt|doc|xls|ppt|pdf|xls|docx|xlsx|doc\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (265, 21, 'tags', 'TAG', '', 0, 0, 0, 'tag', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 11, 'TAG', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (266, 21, 'hits', '点击次数', '', 0, 0, 0, 'number', 0, '', '', '', 1, 1, 1, 0, 1, '=', 1, 12, '点击次数', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'step\' => \'1\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (267, 21, 'keywords', '关键词', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 13, '关键词', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (268, 21, 'description', '描述', '', 0, 0, 0, 'textarea', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 14, '描述', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (269, 21, 'template', '模板', '单独设置此条记录的模板，如：article_show.html 或 article_show', 0, 0, 30, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 15, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (270, 22, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 0, 0, '', 1, 1, '自增ID', 'array (\'default\' => \'0\',\'extra_attr\' => \'\',\'extra_class\' => \'\',\'step\' => \'1\',\'fieldtype\' => \'int\',\'group\' => \'\')', 0);
INSERT INTO `tp_field` VALUES (271, 22, 'create_time', '添加时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (272, 22, 'update_time', '更新时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\n  \'default\' => \'0\',\n  \'format\' => \'Y-m-d H:i:s\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (273, 22, 'sort', '排序', '', 1, 0, 8, 'number', 0, '', '', '', 1, 1, 1, 0, 1, '=', 1, 49, '', 'array (\'default\' => \'50\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'step\' => \'1\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (274, 22, 'status', '状态', '', 1, 0, 1, 'radio', 1, '', '', '1', 1, 1, 1, 1, 0, '=', 1, 48, '', 'array (\'default\' => \'1\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'fieldtype\' => \'tinyint\',)', 0);
INSERT INTO `tp_field` VALUES (275, 22, 'cate_id', '栏目', '', 1, 0, 0, 'select', 2, 'Cate', 'cate_name', '', 1, 1, 1, 1, 0, '=', 1, 2, '栏目', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (276, 22, 'title', '标题', '', 1, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 1, 0, 'LIKE', 1, 3, '标题', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (277, 22, 'author', '作者', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 4, '作者', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (278, 22, 'source', '来源', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 5, '来源', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (279, 22, 'content', '内容', '', 0, 0, 0, 'editor', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 6, '内容', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'height\' => \'\',\n  \'fieldtype\' => \'text\',\n)', 0);
INSERT INTO `tp_field` VALUES (280, 22, 'summary', '摘要', '', 0, 0, 0, 'textarea', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 7, '摘要', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'text\',\n)', 0);
INSERT INTO `tp_field` VALUES (281, 22, 'image', '图片', '', 0, 0, 0, 'image', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 8, '图片', 'array (\n  \'ext\' => \'jpg|jpeg|gif|png\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (282, 22, 'images', '图片集', '', 0, 0, 0, 'images', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 9, '图片集', 'array (\n  \'ext\' => \'jpg|jpeg|gif|png\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'text\',\n)', 0);
INSERT INTO `tp_field` VALUES (283, 22, 'download', '文件下载', '', 0, 0, 0, 'file', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 10, '文件下载', 'array (\n  \'ext\' => \'rar|zip|avi|rmvb|3gp|flv|mp3|txt|doc|xls|ppt|pdf|xls|docx|xlsx|doc\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (284, 22, 'tags', 'TAG', '', 0, 0, 0, 'tag', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 11, 'TAG', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (285, 22, 'hits', '点击次数', '', 0, 0, 0, 'number', 0, '', '', '', 1, 1, 1, 0, 1, '=', 1, 12, '点击次数', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'step\' => \'1\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (286, 22, 'keywords', '关键词', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 13, '关键词', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (287, 22, 'description', '描述', '', 0, 0, 0, 'textarea', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 14, '描述', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (288, 22, 'template', '模板', '单独设置此条记录的模板，如：article_show.html 或 article_show', 0, 0, 30, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 15, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (289, 23, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 0, 0, '', 1, 1, '自增ID', 'array (\'default\' => \'0\',\'extra_attr\' => \'\',\'extra_class\' => \'\',\'step\' => \'1\',\'fieldtype\' => \'int\',\'group\' => \'\')', 0);
INSERT INTO `tp_field` VALUES (290, 23, 'create_time', '添加时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (291, 23, 'update_time', '更新时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\n  \'default\' => \'0\',\n  \'format\' => \'Y-m-d H:i:s\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (292, 23, 'sort', '排序', '', 1, 0, 8, 'number', 0, '', '', '', 1, 1, 1, 0, 1, '=', 1, 49, '', 'array (\'default\' => \'50\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'step\' => \'1\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (293, 23, 'status', '状态', '', 1, 0, 1, 'radio', 1, '', '', '1', 1, 1, 1, 1, 0, '=', 1, 48, '', 'array (\'default\' => \'1\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'fieldtype\' => \'tinyint\',)', 0);
INSERT INTO `tp_field` VALUES (294, 23, 'cate_id', '栏目', '', 1, 0, 0, 'select', 2, 'Cate', 'cate_name', '', 1, 1, 1, 1, 0, '=', 1, 2, '栏目', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (295, 23, 'title', '标题', '', 1, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 1, 0, 'LIKE', 1, 3, '标题', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (296, 23, 'author', '作者', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 4, '作者', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (297, 23, 'source', '来源', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 5, '来源', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (298, 23, 'content', '内容', '', 0, 0, 0, 'editor', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 6, '内容', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'height\' => \'\',\n  \'fieldtype\' => \'text\',\n)', 0);
INSERT INTO `tp_field` VALUES (299, 23, 'summary', '摘要', '', 0, 0, 0, 'textarea', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 7, '摘要', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'text\',\n)', 0);
INSERT INTO `tp_field` VALUES (300, 23, 'image', '图片', '', 0, 0, 0, 'image', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 8, '图片', 'array (\n  \'ext\' => \'jpg|jpeg|gif|png\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (301, 23, 'images', '图片集', '', 0, 0, 0, 'images', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 9, '图片集', 'array (\n  \'ext\' => \'jpg|jpeg|gif|png\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'text\',\n)', 0);
INSERT INTO `tp_field` VALUES (302, 23, 'download', '文件下载', '', 0, 0, 0, 'file', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 10, '文件下载', 'array (\n  \'ext\' => \'rar|zip|avi|rmvb|3gp|flv|mp3|txt|doc|xls|ppt|pdf|xls|docx|xlsx|doc\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (303, 23, 'tags', 'TAG', '', 0, 0, 0, 'tag', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 11, 'TAG', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (304, 23, 'hits', '点击次数', '', 0, 0, 0, 'number', 0, '', '', '', 1, 1, 1, 0, 1, '=', 1, 12, '点击次数', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'step\' => \'1\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (305, 23, 'keywords', '关键词', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 13, '关键词', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (306, 23, 'description', '描述', '', 0, 0, 0, 'textarea', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 14, '描述', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (307, 23, 'template', '模板', '单独设置此条记录的模板，如：article_show.html 或 article_show', 0, 0, 30, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 15, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (308, 24, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 0, 0, '', 1, 1, '自增ID', 'array (\'default\' => \'0\',\'extra_attr\' => \'\',\'extra_class\' => \'\',\'step\' => \'1\',\'fieldtype\' => \'int\',\'group\' => \'\')', 0);
INSERT INTO `tp_field` VALUES (309, 24, 'create_time', '添加时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (310, 24, 'update_time', '更新时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\n  \'default\' => \'0\',\n  \'format\' => \'Y-m-d H:i:s\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (311, 24, 'sort', '排序', '', 1, 0, 8, 'number', 0, '', '', '', 1, 1, 1, 0, 1, '=', 1, 49, '', 'array (\'default\' => \'50\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'step\' => \'1\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (312, 24, 'status', '状态', '', 1, 0, 1, 'radio', 1, '', '', '1', 1, 1, 1, 1, 0, '=', 1, 48, '', 'array (\'default\' => \'1\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'fieldtype\' => \'tinyint\',)', 0);
INSERT INTO `tp_field` VALUES (313, 24, 'cate_id', '栏目', '', 1, 0, 0, 'select', 2, 'Cate', 'cate_name', '', 1, 1, 1, 1, 0, '=', 1, 2, '栏目', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (314, 24, 'title', '标题', '', 1, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 1, 0, 'LIKE', 1, 3, '标题', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (315, 24, 'author', '作者', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 4, '作者', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (316, 24, 'source', '来源', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 5, '来源', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (317, 24, 'content', '内容', '', 0, 0, 0, 'editor', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 6, '内容', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'height\' => \'\',\n  \'fieldtype\' => \'text\',\n)', 0);
INSERT INTO `tp_field` VALUES (318, 24, 'summary', '摘要', '', 0, 0, 0, 'textarea', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 7, '摘要', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'text\',\n)', 0);
INSERT INTO `tp_field` VALUES (319, 24, 'image', '图片', '', 0, 0, 0, 'image', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 8, '图片', 'array (\n  \'ext\' => \'jpg|jpeg|gif|png\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (320, 24, 'images', '图片集', '', 0, 0, 0, 'images', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 9, '图片集', 'array (\n  \'ext\' => \'jpg|jpeg|gif|png\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'text\',\n)', 0);
INSERT INTO `tp_field` VALUES (321, 24, 'download', '文件下载', '', 0, 0, 0, 'file', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 10, '文件下载', 'array (\n  \'ext\' => \'rar|zip|avi|rmvb|3gp|flv|mp3|txt|doc|xls|ppt|pdf|xls|docx|xlsx|doc\',\n  \'size\' => \'10240\',\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (322, 24, 'tags', 'TAG', '', 0, 0, 0, 'tag', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 11, 'TAG', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (323, 24, 'hits', '点击次数', '', 0, 0, 0, 'number', 0, '', '', '', 1, 1, 1, 0, 1, '=', 1, 12, '点击次数', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'step\' => \'1\',\n  \'fieldtype\' => \'int\',\n)', 0);
INSERT INTO `tp_field` VALUES (324, 24, 'keywords', '关键词', '', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 13, '关键词', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (325, 24, 'description', '描述', '', 0, 0, 0, 'textarea', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 14, '描述', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n)', 0);
INSERT INTO `tp_field` VALUES (326, 24, 'template', '模板', '单独设置此条记录的模板，如：article_show.html 或 article_show', 0, 0, 30, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 15, '', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (327, 25, 'content', '内容', '', 0, 0, 0, 'editor', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 6, '内容', 'array (\r\n  \'default\' => \'\',\r\n  \'extra_attr\' => \'\',\r\n  \'extra_class\' => \'\',\r\n  \'height\' => \'\',\r\n  \'fieldtype\' => \'text\',\r\n)', 0);
INSERT INTO `tp_field` VALUES (328, 25, 'title', '标题', '', 1, 0, 0, 'text', 0, '', '', '', 1, 1, 1, 1, 0, 'LIKE', 1, 3, '标题', 'array (\r\n  \'default\' => \'\',\r\n  \'extra_attr\' => \'\',\r\n  \'extra_class\' => \'\',\r\n  \'placeholder\' => \'\',\r\n  \'fieldtype\' => \'varchar\',\r\n  \'group\' => \'\',\r\n)', 0);
INSERT INTO `tp_field` VALUES (329, 25, 'cate_id', '栏目', '', 1, 0, 0, 'select', 2, 'Cate', 'cate_name', '', 1, 1, 1, 1, 0, '=', 1, 2, '栏目', 'array (\r\n  \'default\' => \'0\',\r\n  \'extra_attr\' => \'\',\r\n  \'extra_class\' => \'\',\r\n  \'fieldtype\' => \'tinyint\',\r\n)', 0);
INSERT INTO `tp_field` VALUES (330, 25, 'status', '状态', '', 1, 0, 1, 'radio', 1, '', '', '1', 1, 1, 1, 1, 0, '=', 1, 48, '', 'array (\'default\' => \'1\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'fieldtype\' => \'tinyint\',)', 0);
INSERT INTO `tp_field` VALUES (331, 25, 'update_time', '更新时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\r\n  \'default\' => \'0\',\r\n  \'format\' => \'Y-m-d H:i:s\',\r\n  \'extra_attr\' => \'\',\r\n  \'extra_class\' => \'\',\r\n  \'placeholder\' => \'\',\r\n  \'fieldtype\' => \'int\',\r\n)', 0);
INSERT INTO `tp_field` VALUES (332, 25, 'create_time', '添加时间', '', 0, 0, 11, 'datetime', 0, '', '', '', 0, 0, 1, 0, 0, '=', 1, 50, '自增ID', 'array (\'default\' => \'0\', \'format\' => \'Y-m-d H:i:s\', \'extra_attr\' => \'\', \'extra_class\' => \'\', \'placeholder\' => \'\', \'fieldtype\' => \'int\',)', 0);
INSERT INTO `tp_field` VALUES (333, 25, 'id', '编号', '', 0, 0, 0, 'hidden', 0, '', '', '', 0, 0, 1, 0, 0, '', 1, 1, '自增ID', 'array (\'default\' => \'0\',\'extra_attr\' => \'\',\'extra_class\' => \'\',\'step\' => \'1\',\'fieldtype\' => \'int\',\'group\' => \'\')', 0);
INSERT INTO `tp_field` VALUES (334, 25, 'name', '姓名', '', 0, 0, 255, 'text', 0, '', '', '', 1, 1, 1, 1, 0, '=', 1, 4, '姓名', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (335, 25, 'phone', '电话', '', 0, 0, 255, 'text', 0, '', '', '', 1, 1, 1, 0, 0, '=', 1, 5, '电话', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (336, 16, 'param', '参数', 'URL地址后的参数，如 type=button&name=my', 0, 0, 50, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 6, '参数', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (337, 19, 'url', '跳转地址', '如需直接跳转，请填写完整的网站地址或相对地址', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 16, '跳转地址', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (338, 21, 'url', '跳转地址', '如需直接跳转，请填写完整的网站地址或相对地址', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 16, '跳转地址', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (339, 22, 'url', '跳转地址', '如需直接跳转，请填写完整的网站地址或相对地址', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 16, '跳转地址', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (340, 23, 'url', '跳转地址', '如需直接跳转，请填写完整的网站地址或相对地址', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 16, '跳转地址', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (341, 24, 'url', '跳转地址', '如需直接跳转，请填写完整的网站地址或相对地址', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 16, '跳转地址', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 0);
INSERT INTO `tp_field` VALUES (342, 24, 'area', '区域', '', 0, 0, 4, 'radio', 1, '', '', '10', 1, 1, 1, 0, 0, '=', 1, 17, '区域', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (343, 24, 'sex', '性别', '', 0, 0, 4, 'select', 1, '', '', '4', 1, 1, 1, 0, 0, '=', 1, 18, '', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (344, 13, 'upload_driver', '上传驱动', '文件/图片上传的驱动', 1, 0, 0, 'radio', 1, '', '', '11', 1, 1, 0, 0, 0, '=', 1, 26, '上传驱动', 'array (\n  \'default\' => \'1\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 9);
INSERT INTO `tp_field` VALUES (345, 13, 'upload_file_size', '文件限制', '单位：KB，0表示不限制上传大小', 0, 0, 50, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 27, '文件限制', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 9);
INSERT INTO `tp_field` VALUES (346, 13, 'upload_file_ext', '文件格式', '多个格式请用英文逗号（,）隔开', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 28, '文件格式', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 9);
INSERT INTO `tp_field` VALUES (347, 13, 'upload_image_size', '图片限制', '单位：KB，0表示不限制上传大小', 0, 0, 50, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 29, '图片限制', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 9);
INSERT INTO `tp_field` VALUES (348, 13, 'upload_image_ext', '图片格式', '多个格式请用英文逗号（,）隔开', 0, 0, 0, 'text', 0, '', '', '', 1, 1, 0, 0, 0, '=', 1, 30, '图片格式', 'array (\n  \'default\' => \'\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'placeholder\' => \'\',\n  \'fieldtype\' => \'varchar\',\n  \'group\' => \'\',\n)', 9);
INSERT INTO `tp_field` VALUES (349, 13, 'editor', '编辑器', '', 0, 0, 0, 'radio', 1, '', '', '12', 1, 1, 0, 0, 0, '=', 1, 31, '', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 5);
INSERT INTO `tp_field` VALUES (350, 19, 'view_auth', '阅读权限', '', 0, 0, 0, 'select', 2, 'UsersType', 'name', '', 1, 1, 0, 0, 0, '=', 1, 17, '阅读权限', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (351, 18, 'view_auth', '阅读权限', '', 0, 0, 0, 'select', 2, 'UsersType', 'name', '', 1, 1, 0, 0, 0, '=', 1, 17, '阅读权限', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (352, 21, 'view_auth', '阅读权限', '', 0, 0, 0, 'select', 2, 'UsersType', 'name', '', 1, 1, 0, 0, 0, '=', 1, 17, '阅读权限', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (353, 22, 'view_auth', '阅读权限', '', 0, 0, 0, 'select', 2, 'UsersType', 'name', '', 1, 1, 0, 0, 0, '=', 1, 17, '阅读权限', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (354, 23, 'view_auth', '阅读权限', '', 0, 0, 0, 'select', 2, 'UsersType', 'name', '', 1, 1, 0, 0, 0, '=', 1, 17, '阅读权限', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);
INSERT INTO `tp_field` VALUES (355, 24, 'view_auth', '阅读权限', '', 0, 0, 0, 'select', 2, 'UsersType', 'name', '', 1, 1, 0, 0, 0, '=', 1, 17, '阅读权限', 'array (\n  \'default\' => \'0\',\n  \'extra_attr\' => \'\',\n  \'extra_class\' => \'\',\n  \'fieldtype\' => \'tinyint\',\n)', 0);

-- ----------------------------
-- Table structure for tp_field_group
-- ----------------------------
DROP TABLE IF EXISTS `tp_field_group`;
CREATE TABLE `tp_field_group`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `module_id` int(8) NOT NULL DEFAULT 0 COMMENT '所属模块',
  `group_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分组名称',
  `status` tinyint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态',
  `sort` int(5) UNSIGNED NOT NULL DEFAULT 50 COMMENT '排序',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '字段分组' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_field_group
-- ----------------------------
INSERT INTO `tp_field_group` VALUES (1, 1580561499, 1580561499, 13, '基础设置', 1, 1);
INSERT INTO `tp_field_group` VALUES (2, 1580561539, 1580561539, 13, 'SEO设置', 1, 2);
INSERT INTO `tp_field_group` VALUES (3, 1580561551, 1580561551, 13, '开关设置', 1, 3);
INSERT INTO `tp_field_group` VALUES (4, 1580561568, 1580561568, 13, '模板设置', 1, 4);
INSERT INTO `tp_field_group` VALUES (5, 1580561585, 1580561585, 13, '其他设置', 1, 6);
INSERT INTO `tp_field_group` VALUES (6, 1580896600, 1580896600, 20, '基础设置', 1, 1);
INSERT INTO `tp_field_group` VALUES (7, 1580896624, 1580896624, 20, 'SEO设置', 1, 2);
INSERT INTO `tp_field_group` VALUES (8, 1580896925, 1580896925, 20, '其他', 1, 3);
INSERT INTO `tp_field_group` VALUES (9, 1586855728, 1586855814, 13, '上传设置', 1, 5);

-- ----------------------------
-- Table structure for tp_link
-- ----------------------------
DROP TABLE IF EXISTS `tp_link`;
CREATE TABLE `tp_link`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '网站名称',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '网站地址',
  `logo` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '网站logo',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '描述',
  `sort` int(10) UNSIGNED NOT NULL DEFAULT 50 COMMENT '排序',
  `status` tinyint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '友情链接' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_link
-- ----------------------------
INSERT INTO `tp_link` VALUES (1, 1580360741, 1580360741, 'SIYUCMS', 'http://www.siyucms.com', '', '', 1, 1);

-- ----------------------------
-- Table structure for tp_message
-- ----------------------------
DROP TABLE IF EXISTS `tp_message`;
CREATE TABLE `tp_message`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `cate_id` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '栏目',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '姓名',
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '电话',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '留言模块' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_message
-- ----------------------------
INSERT INTO `tp_message` VALUES (1, 1581080488, 1581080488, 1, 13, '测试留言标题', '<p>测试留言内容</p>\n', '赵先生', '15888888888');

-- ----------------------------
-- Table structure for tp_module
-- ----------------------------
DROP TABLE IF EXISTS `tp_module`;
CREATE TABLE `tp_module`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `module_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '模块名称',
  `table_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '表名称',
  `model_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '模型名称',
  `table_comment` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '表描述',
  `table_type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '表类型',
  `pk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'id' COMMENT '主键',
  `list_fields` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '前台列表页可调用字段,默认为*,仅用作前台CMS调用时使用',
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '备注',
  `sort` smallint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `is_sort` tinyint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT '排序字段',
  `is_status` tinyint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态字段',
  `top_button` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'add,edit,del,export' COMMENT '顶部按钮',
  `right_button` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'edit,delete' COMMENT '右侧按钮',
  `is_single` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '单页模式',
  `show_all` tinyint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT '查看全部',
  `add_param` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '添加参数',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '模块配置表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_module
-- ----------------------------
INSERT INTO `tp_module` VALUES (1, '会员管理', 'users', 'Users', '会员管理', '2', 'id', '*', '前台会员列表，需要关联会员类型表', 1, 1572852406, 1572852406, 0, 0, 'add,edit,del,export', 'edit,delete', 0, 1, '');
INSERT INTO `tp_module` VALUES (2, '字段管理', 'field', 'Field', '字段管理', '2', 'id', '*', '字段管理', 3, 1572852406, 1580359578, 1, 1, 'add,edit,del,export', 'edit,delete', 0, 1, '');
INSERT INTO `tp_module` VALUES (3, '模块管理', 'module', 'Module', '模块管理', '2', 'id', '*', '模块管理', 4, 1572852406, 1580359586, 1, 0, 'add,edit,del,export', 'edit,delete', 0, 1, '');
INSERT INTO `tp_module` VALUES (4, '字典类型', 'dictionary_type', 'DictionaryType', '字典类型', '2', 'id', '*', '字典类型', 5, 1572852406, 1580359592, 1, 1, 'add,edit,del,export', 'edit,delete', 0, 1, '');
INSERT INTO `tp_module` VALUES (5, '字典数据', 'dictionary', 'Dictionary', '字典数据', '2', 'id', '*', '字典数据', 6, 1572852406, 1580359596, 1, 1, 'add,edit,del,export', 'edit,delete', 0, 1, '');
INSERT INTO `tp_module` VALUES (6, '会员分组', 'users_type', 'UsersType', '会员分组', '2', 'id', '*', '会员分组', 2, 1579499169, 1580359573, 1, 1, 'add,edit,del,export', 'edit,delete', 0, 1, '');
INSERT INTO `tp_module` VALUES (7, '字段分组', 'field_group', 'FieldGroup', '字段分组', '2', 'id', '*', '字段分组', 7, 1580358477, 1580359113, 1, 1, 'add,edit,del,export', 'edit,delete', 0, 1, '');
INSERT INTO `tp_module` VALUES (8, '友情链接', 'link', 'Link', '友情链接', '2', 'id', '*', '友情链接', 8, 1580360170, 1580360176, 1, 1, 'add,edit,del,export', 'edit,delete', 0, 1, '');
INSERT INTO `tp_module` VALUES (9, '广告分组', 'ad_type', 'AdType', '广告分组', '2', 'id', '*', '广告分组', 9, 1580371813, 1580371820, 1, 1, 'add,edit,del,export', 'edit,delete', 0, 1, '');
INSERT INTO `tp_module` VALUES (10, '广告管理', 'ad', 'Ad', '广告管理', '2', 'id', '*', '广告管理', 10, 1580377198, 1580377198, 1, 1, 'add,edit,del,export', 'edit,delete', 0, 1, '');
INSERT INTO `tp_module` VALUES (11, '碎片管理', 'debris', 'Debris', '碎片管理', '2', 'id', '*', '碎片管理', 11, 1580387498, 1580387503, 1, 1, 'add,edit,del,export', 'edit,delete', 0, 1, '');
INSERT INTO `tp_module` VALUES (13, '系统设置', 'system', 'System', '系统设置', '2', 'id', '*', '系统设置', 13, 1580558207, 1580558207, 0, 0, 'add,edit,del,export', 'edit,delete', 1, 0, '');
INSERT INTO `tp_module` VALUES (14, '角色组管理', 'auth_group', 'AuthGroup', '角色组管理', '2', 'id', '*', '角色组管理', 14, 1580633766, 1580633772, 0, 1, 'add,edit,del,export', 'edit,delete', 0, 1, '');
INSERT INTO `tp_module` VALUES (15, '管理员管理', 'admin', 'Admin', '管理员列表', '2', 'id', '*', '管理员列表', 15, 1580692727, 1580702316, 0, 1, 'add,edit,del,export', 'edit,delete', 0, 1, '');
INSERT INTO `tp_module` VALUES (16, '菜单规则', 'auth_rule', 'AuthRule', '菜单规则', '2', 'id', '*', '', 16, 1580702184, 1580702320, 1, 1, 'add,edit,del,export', 'edit,delete', 0, 1, '');
INSERT INTO `tp_module` VALUES (17, '管理员日志', 'admin_log', 'AdminLog', '管理员日志', '2', 'id', '*', '管理员日志', 17, 1580722266, 1580722266, 0, 0, 'edit,del,export', 'edit,delete', 0, 1, '');
INSERT INTO `tp_module` VALUES (18, '单页模块', 'page', 'Page', '单页模块', '1', 'id', '*', '单页模块', 31, 1580892306, 1580892306, 1, 1, 'add,edit,del,export', 'edit,delete', 1, 1, '');
INSERT INTO `tp_module` VALUES (19, '文章模块', 'article', 'Article', '文章模块', '1', 'id', '*', '文章模块', 32, 1580892395, 1585894205, 1, 1, 'add,edit,del,export', 'preview,edit,delete', 0, 1, 'cate_id');
INSERT INTO `tp_module` VALUES (20, '栏目管理', 'cate', 'Cate', '栏目管理', '2', 'id', '*', '栏目管理', 30, 1580892776, 1580892776, 1, 1, 'add,edit,del,export', 'edit,delete', 0, 1, '');
INSERT INTO `tp_module` VALUES (21, '图片模块', 'picture', 'Picture', '图片模块', '1', 'id', '*', '图片模块', 33, 1580899028, 1585894194, 1, 1, 'add,edit,del,export', 'preview,edit,delete', 0, 1, 'cate_id');
INSERT INTO `tp_module` VALUES (22, '产品模块', 'product', 'Product', '产品模块', '1', 'id', '*', '产品模块', 34, 1580899060, 1585894186, 1, 1, 'add,edit,del,export', 'preview,edit,delete', 0, 1, 'cate_id');
INSERT INTO `tp_module` VALUES (23, '下载模块', 'download', 'Download', '下载模块', '1', 'id', '*', '下载模块', 35, 1580899102, 1585894179, 1, 1, 'add,edit,del,export', 'preview,edit,delete', 0, 1, 'cate_id');
INSERT INTO `tp_module` VALUES (24, '团队模块', 'team', 'Team', '团队模块', '1', 'id', '*', '团队模块', 36, 1580899132, 1585894171, 1, 1, 'add,edit,del,export', 'preview,edit,delete', 0, 1, 'cate_id');
INSERT INTO `tp_module` VALUES (25, '留言模块', 'message', 'Message', '留言模块', '1', 'id', '*', '留言模块', 37, 1580899172, 1580899172, 0, 1, 'add,edit,del,export', 'edit,delete', 0, 1, 'cate_id');
INSERT INTO `tp_module` VALUES (26, '区域模块', 'area', 'Area', '区域模块', '2', 'id', '*', '区域模块', 50, 1627637083, 1627637083, 0, 0, '', '', 0, 0, '');

-- ----------------------------
-- Table structure for tp_page
-- ----------------------------
DROP TABLE IF EXISTS `tp_page`;
CREATE TABLE `tp_page`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `sort` mediumint(8) NULL DEFAULT 50 COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  `cate_id` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '栏目',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',
  `view_auth` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '阅读权限',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '文章模块' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_page
-- ----------------------------
INSERT INTO `tp_page` VALUES (1, 1580966383, 1580966383, 1, 1, 1, '关于我们', '<p>ThinkPHP是一个免费开源的，快速、简单的面向对象的轻量级PHP开发框架，是为了敏捷WEB应用开发和简化企业应用开发而诞生的。ThinkPHP从诞生以来一直秉承简洁实用的设计原则，在保持出色的性能和至简代码的同时，更注重易用性。遵循<code>Apache2</code>开源许可协议发布，意味着你可以免费使用ThinkPHP，甚至允许把你基于ThinkPHP开发的应用开源或商业产品发布/销售。</p>\n\n<p>ThinkPHP<code>6.0</code>基于精简核心和统一用法两大原则在<code>5.1</code>的基础上对底层架构做了进一步的优化改进，并更加规范化。由于引入了一些新特性，ThinkPHP<code>6.0</code>运行环境要求<code>PHP7.1+</code>，不支持<code>5.1</code>的无缝升级（官方给出了升级指导用于项目的升级参考）。</p>\n', 0);
INSERT INTO `tp_page` VALUES (2, 1580966471, 1580966471, 11, 1, 2, '公司介绍', '<p><code>ThinkPHP6.0</code>遵循<code>PSR-2</code>命名规范和<code>PSR-4</code>自动加载规范，并且注意如下规范：</p>\n\n<h3><a id=\"_4\"></a>目录和文件</h3>\n\n<ul>\n	<li>目录使用小写+下划线；</li>\n	<li>类库、函数文件统一以<code>.php</code>为后缀；</li>\n	<li>类的文件名均以命名空间定义，并且命名空间的路径和类库文件所在路径一致；</li>\n	<li>类（包含接口和Trait）文件采用驼峰法命名（首字母大写），其它文件采用小写+下划线命名；</li>\n	<li>类名（包括接口和Trait）和文件名保持一致，统一采用驼峰法命名（首字母大写）；</li>\n</ul>\n\n<h3><a id=\"_12\"></a>函数和类、属性命名</h3>\n\n<ul>\n	<li>类的命名采用驼峰法（首字母大写），例如&nbsp;<code>User</code>、<code>UserType</code>；</li>\n	<li>函数的命名使用小写字母和下划线（小写字母开头）的方式，例如&nbsp;<code>get_client_ip</code>；</li>\n	<li>方法的命名使用驼峰法（首字母小写），例如&nbsp;<code>getUserName</code>；</li>\n	<li>属性的命名使用驼峰法（首字母小写），例如&nbsp;<code>tableName</code>、<code>instance</code>；</li>\n	<li>特例：以双下划线<code>__</code>打头的函数或方法作为魔术方法，例如&nbsp;<code>__call</code>&nbsp;和&nbsp;<code>__autoload</code>；</li>\n</ul>\n\n<h3><a id=\"_20\"></a>常量和配置</h3>\n\n<ul>\n	<li>常量以大写字母和下划线命名，例如&nbsp;<code>APP_PATH</code>；</li>\n	<li>配置参数以小写字母和下划线命名，例如&nbsp;<code>url_route_on</code>&nbsp;和<code>url_convert</code>；</li>\n	<li>环境变量定义使用大写字母和下划线命名，例如<code>APP_DEBUG</code>；</li>\n</ul>\n\n<h3><a id=\"_26\"></a>数据表和字段</h3>\n\n<ul>\n	<li>数据表和字段采用小写加下划线方式命名，并注意字段名不要以下划线开头，例如&nbsp;<code>think_user</code>&nbsp;表和&nbsp;<code>user_name</code>字段，不建议使用驼峰和中文作为数据表及字段命名。</li>\n</ul>\n\n<p><strong>请理解并尽量遵循以上命名规范，可以减少在开发过程中出现不必要的错误。</strong></p>\n', 0);
INSERT INTO `tp_page` VALUES (3, 1580966524, 1580966524, 12, 1, 3, '公司文化', '<p>对于一个HTTP应用来说，从用户发起请求到响应输出结束，大致的标准请求流程如下：</p>\n\n<ul>\n	<li>载入<code>Composer</code>的自动加载<code>autoload</code>文件</li>\n	<li>实例化系统应用基础类<code>think\\App</code></li>\n	<li>获取应用目录等相关路径信息</li>\n	<li>加载全局的服务提供<code>provider.php</code>文件</li>\n	<li>设置容器实例及应用对象实例，确保当前容器对象唯一</li>\n	<li>从容器中获取<code>HTTP</code>应用类<code>think\\Http</code></li>\n	<li>执行<code>HTTP</code>应用类的<code>run</code>方法启动一个<code>HTTP</code>应用</li>\n	<li>获取当前请求对象实例（默认为&nbsp;<code>app\\Request</code>&nbsp;继承<code>think\\Request</code>）保存到容器</li>\n	<li>执行<code>think\\App</code>类的初始化方法<code>initialize</code></li>\n	<li>加载环境变量文件<code>.env</code>和全局初始化文件</li>\n	<li>加载全局公共文件、系统助手函数、全局配置文件、全局事件定义和全局服务定义</li>\n	<li>判断应用模式（调试或者部署模式）</li>\n	<li>监听<code>AppInit</code>事件</li>\n	<li>注册异常处理</li>\n	<li>服务注册</li>\n	<li>启动注册的服务</li>\n	<li>加载全局中间件定义</li>\n	<li>监听<code>HttpRun</code>事件</li>\n	<li>执行全局中间件</li>\n	<li>执行路由调度（<code>Route</code>类<code>dispatch</code>方法）</li>\n	<li>如果开启路由则检查路由缓存</li>\n	<li>加载路由定义</li>\n	<li>监听<code>RouteLoaded</code>事件</li>\n	<li>如果开启注解路由则检测注解路由</li>\n	<li>路由检测（中间流程很复杂 略）</li>\n	<li>路由调度对象<code>think\\route\\Dispatch</code>初始化</li>\n	<li>设置当前请求的控制器和操作名</li>\n	<li>注册路由中间件</li>\n	<li>绑定数据模型</li>\n	<li>设置路由额外参数</li>\n	<li>执行数据自动验证</li>\n	<li>执行路由调度子类的<code>exec</code>方法返回响应<code>think\\Response</code>对象</li>\n	<li>获取当前请求的控制器对象实例</li>\n	<li>利用反射机制注册控制器中间件</li>\n	<li>执行控制器方法以及前后置中间件</li>\n	<li>执行当前响应对象的<code>send</code>方法输出</li>\n	<li>执行HTTP应用对象的<code>end</code>方法善后</li>\n	<li>监听<code>HttpEnd</code>事件</li>\n	<li>执行中间件的<code>end</code>回调</li>\n	<li>写入当前请求的日志信息</li>\n</ul>\n\n<p>至此，当前请求流程结束。</p>\n', 0);

-- ----------------------------
-- Table structure for tp_picture
-- ----------------------------
DROP TABLE IF EXISTS `tp_picture`;
CREATE TABLE `tp_picture`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `sort` mediumint(8) NULL DEFAULT 50 COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  `cate_id` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '栏目',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '作者',
  `source` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '来源',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',
  `summary` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '摘要',
  `image` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '图片集',
  `download` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文件下载',
  `tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'TAG',
  `hits` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '点击次数',
  `keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '关键词',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '描述',
  `template` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '模板',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '跳转地址',
  `view_auth` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '阅读权限',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '图片模块' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_picture
-- ----------------------------
INSERT INTO `tp_picture` VALUES (1, 1581076265, 1581076265, 50, 1, 7, '资质荣誉一', '管理员', '本站', '<p style=\"text-indent: 2em;\">2017年7月12日，国资委正式发布2016年度中央企业负责人经营业绩考核结果。51家央企位列2016年度考核Ａ级，占全部中央企业的50%。集团公司2016年度经营业绩考核综合得分为135.26分，考核结果为A级，在51家A级企业中排名第25位，排名较上年提高8个位次，这是XX集团公司第六次被评为年度经营业绩考核A级企业。</p>\n', '2017年7月12日，国资委正式发布2016年度中央企业负责人经营业绩考核结果。51家央企位列2016年度考核Ａ级，占全部中央企业的50%。集团公司2016年度经营业绩考核综合得分为135.26分，考核结果为A级，在51家A级企业中排名第25位，排名较上年提高8个位次，这是XX集团公司第六次被评为年度经营业绩考核A级企业。', '/uploads/20181224/df4a0aaf70da70634efb8c682c50a8df.jpg', '', '', '', 0, '', '', '', '', 0);
INSERT INTO `tp_picture` VALUES (2, 1581076308, 1581076308, 50, 1, 7, '资质荣誉二', '管理员', '本站', '<p style=\"text-indent: 2em;\">2017年7月12日，国资委正式发布2016年度中央企业负责人经营业绩考核结果。51家央企位列2016年度考核Ａ级，占全部中央企业的50%。集团公司2016年度经营业绩考核综合得分为135.26分，考核结果为A级，在51家A级企业中排名第25位，排名较上年提高8个位次，这是XX集团公司第六次被评为年度经营业绩考核A级企业。</p>\n', '2017年7月12日，国资委正式发布2016年度中央企业负责人经营业绩考核结果。51家央企位列2016年度考核Ａ级，占全部中央企业的50%。集团公司2016年度经营业绩考核综合得分为135.26分，考核结果为A级，在51家A级企业中排名第25位，排名较上年提高8个位次，这是XX集团公司第六次被评为年度经营业绩考核A级企业。', '/uploads/20181224/acb269b78bf5a08dda27ae155768e688.jpg', '', '', '', 0, '', '', '', '', 0);
INSERT INTO `tp_picture` VALUES (3, 1581076347, 1581076347, 50, 1, 7, '资质荣誉三', '管理员', '本站', '<p style=\"text-indent: 2em;\">2017年7月12日，国资委正式发布2016年度中央企业负责人经营业绩考核结果。51家央企位列2016年度考核Ａ级，占全部中央企业的50%。集团公司2016年度经营业绩考核综合得分为135.26分，考核结果为A级，在51家A级企业中排名第25位，排名较上年提高8个位次，这是XX集团公司第六次被评为年度经营业绩考核A级企业。</p>\n', '2017年7月12日，国资委正式发布2016年度中央企业负责人经营业绩考核结果。51家央企位列2016年度考核Ａ级，占全部中央企业的50%。集团公司2016年度经营业绩考核综合得分为135.26分，考核结果为A级，在51家A级企业中排名第25位，排名较上年提高8个位次，这是XX集团公司第六次被评为年度经营业绩考核A级企业。', '/uploads/20181224/dd30ed06a39d73f8bbc8012741a3010a.jpg', '', '', '', 0, '', '', '', '', 0);
INSERT INTO `tp_picture` VALUES (4, 1581076385, 1581076385, 50, 1, 7, '资质荣誉四', '管理员', '本站', '<p><span style=\"text-indent: 32px;\">2017年7月12日，国资委正式发布2016年度中央企业负责人经营业绩考核结果。51家央企位列2016年度考核Ａ级，占全部中央企业的50%。集团公司2016年度经营业绩考核综合得分为135.26分，考核结果为A级，在51家A级企业中排名第25位，排名较上年提高8个位次，这是XX集团公司第六次被评为年度经营业绩考核A级企业。</span></p>\n', '2017年7月12日，国资委正式发布2016年度中央企业负责人经营业绩考核结果。51家央企位列2016年度考核Ａ级，占全部中央企业的50%。集团公司2016年度经营业绩考核综合得分为135.26分，考核结果为A级，在51家A级企业中排名第25位，排名较上年提高8个位次，这是XX集团公司第六次被评为年度经营业绩考核A级企业。', '/uploads/20181224/10ba9f34431727269dbeadae6dc786f8.jpg', '', '', '', 0, '', '', '', '', 0);
INSERT INTO `tp_picture` VALUES (5, 1581076418, 1581076418, 50, 1, 7, '资质荣誉五', '管理员', '本站', '<p>2017年7月12日，国资委正式发布2016年度中央企业负责人经营业绩考核结果。51家央企位列2016年度考核Ａ级，占全部中央企业的50%。集团公司2016年度经营业绩考核综合得分为135.26分，考核结果为A级，在51家A级企业中排名第25位，排名较上年提高8个位次，这是XX集团公司第六次被评为年度经营业绩考核A级企业。</p>\n', '2017年7月12日，国资委正式发布2016年度中央企业负责人经营业绩考核结果。51家央企位列2016年度考核Ａ级，占全部中央企业的50%。集团公司2016年度经营业绩考核综合得分为135.26分，考核结果为A级，在51家A级企业中排名第25位，排名较上年提高8个位次，这是XX集团公司第六次被评为年度经营业绩考核A级企业。', '/uploads/20181224/1806bd7cc4c2beaf6be64833a891671b.jpg', '', '', '', 1, '', '', '', '', 0);
INSERT INTO `tp_picture` VALUES (6, 1581076451, 1581076451, 50, 1, 7, '资质荣誉六', '管理员', '本站', '<p>2017年7月12日，国资委正式发布2016年度中央企业负责人经营业绩考核结果。51家央企位列2016年度考核Ａ级，占全部中央企业的50%。集团公司2016年度经营业绩考核综合得分为135.26分，考核结果为A级，在51家A级企业中排名第25位，排名较上年提高8个位次，这是XX集团公司第六次被评为年度经营业绩考核A级企业。</p>\n', '2017年7月12日，国资委正式发布2016年度中央企业负责人经营业绩考核结果。51家央企位列2016年度考核Ａ级，占全部中央企业的50%。集团公司2016年度经营业绩考核综合得分为135.26分，考核结果为A级，在51家A级企业中排名第25位，排名较上年提高8个位次，这是XX集团公司第六次被评为年度经营业绩考核A级企业。', '/uploads/20181224/97e072ae3a03895617e6b8ef6dc73529.jpg', '', '', '', 0, '', '', '', '', 0);

-- ----------------------------
-- Table structure for tp_product
-- ----------------------------
DROP TABLE IF EXISTS `tp_product`;
CREATE TABLE `tp_product`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `sort` mediumint(8) NULL DEFAULT 50 COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  `cate_id` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '栏目',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '作者',
  `source` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '来源',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',
  `summary` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '摘要',
  `image` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '图片集',
  `download` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文件下载',
  `tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'TAG',
  `hits` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '点击次数',
  `keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '关键词',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '描述',
  `template` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '模板',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '跳转地址',
  `view_auth` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '阅读权限',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '产品模块' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_product
-- ----------------------------
INSERT INTO `tp_product` VALUES (1, 1581076523, 1581076523, 50, 1, 9, '一本书', '管理员', '本站', '', '', '/uploads/20181224/065928f94ebe13ab1fbdc09cdd28a18b.jpg', '', '', '书本', 0, '', '', '', '', 0);
INSERT INTO `tp_product` VALUES (2, 1581076563, 1581076563, 50, 1, 9, '一支笔', '管理员', '本站', '', '', '/uploads/20181224/f05f564a79e650d566251152fa4fa75e.jpg', '', '', '笔', 0, '', '', '', '', 0);
INSERT INTO `tp_product` VALUES (3, 1581076594, 1581076594, 50, 1, 9, '一支铅笔', '管理员', '本站', '', '', '/uploads/20181224/d5e07bd3fdd9f3cbb0bdc798ccdba178.jpg', '', '', '笔', 2, '', '', '', '', 0);
INSERT INTO `tp_product` VALUES (4, 1581076620, 1581076620, 50, 1, 9, '背包', '管理员', '本站', '', '', '/uploads/20181224/8852280b4dc3365af4855c779e4239c6.jpg', '', '', '', 0, '', '', '', '', 0);
INSERT INTO `tp_product` VALUES (5, 1581076652, 1581076652, 50, 1, 9, '笔记本', '管理员', '本站', '', '', '/uploads/20181224/d42552c77b14805f6d48e00b7a38f2e8.jpg', '', '', '', 0, '', '', '', '', 0);
INSERT INTO `tp_product` VALUES (6, 1581076690, 1581076690, 50, 1, 9, '一支笔', '管理员', '本站', '', '', '/uploads/20181224/d42552c77b14805f6d48e00b7a38f2e8.jpg', '', '', '笔', 0, '', '', '', '', 0);
INSERT INTO `tp_product` VALUES (7, 1581076718, 1581076718, 50, 1, 9, '铅笔盒', '管理员', '本站', '', '', '/uploads/20181224/c89c7634f5bcd3b60884da427bc0b384.jpg', '', '', '', 0, '', '', '', '', 0);
INSERT INTO `tp_product` VALUES (8, 1581076758, 1581076758, 50, 1, 9, '钢笔', '管理员', '本站', '', '', '/uploads/20181224/f05f564a79e650d566251152fa4fa75e.jpg', '', '', '笔,钢笔', 9, '', '', '', '', 0);

-- ----------------------------
-- Table structure for tp_system
-- ----------------------------
DROP TABLE IF EXISTS `tp_system`;
CREATE TABLE `tp_system`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '网站名称',
  `logo` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '网站LOGO',
  `icp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备案号',
  `copyright` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '版权信息',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '网站地址',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '公司地址',
  `contacts` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '联系人',
  `tel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '联系电话',
  `mobile_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号码',
  `fax` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '传真号码',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '邮箱账号',
  `qq` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'QQ',
  `qrcode` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '二维码',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO关键字',
  `des` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `mobile` tinyint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT '手机端',
  `code` tinyint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT '后台验证码',
  `message_code` tinyint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT '前台验证码',
  `message_send_mail` tinyint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT '留言邮件提醒',
  `template_opening` tinyint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT '模板修改备份',
  `template` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '模板目录',
  `html` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Html目录',
  `other` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '其他',
  `upload_driver` tinyint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT '上传驱动',
  `upload_file_size` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文件限制',
  `upload_file_ext` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文件格式',
  `upload_image_size` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片限制',
  `upload_image_ext` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片格式',
  `editor` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '编辑器',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '系统设置' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_system
-- ----------------------------
INSERT INTO `tp_system` VALUES (1, 1580560560, 1586857104, 'SIYUCMS', '/uploads/20181226/a3a4245ec095da4903c6c81123fd480d.png', '辽ICP备12345678号-1', 'Copyright © SIYUCMS 2019.All right reserved.Powered by SIYUCMS', 'www.xxx.com', '辽宁省沈阳市铁西区重工街XX路XX号1-1-1', 'X先生', '010-8888 7777', '158 4018 8888', '010-8888 9999', '407593529@qq.com', '407593529', '/uploads/20181226/cb7a4c21d6443bc5e7a8d16ac2cbe242.png', 'SIYUCMS 官网', 'SIYUCMS，SIYUCMS内容管理系统，php，ThinkPHP CMS，ThinkPHP建站系统', 'SIYUCMS 是一款基于 ThinkPHP + AdminLTE 的内容管理系统。后台界面采用响应式布局，清爽、极简、简单、易用，是做开发的最佳选择。', 0, 1, 0, 0, 1, 'default', 'html', '', 1, '0', 'rar,zip,avi,rmvb,3gp,flv,mp3,mp4,txt,doc,xls,ppt,pdf,xls,docx,xlsx,doc', '0', 'jpg,png,gif,jpeg,ico', 0);

-- ----------------------------
-- Table structure for tp_team
-- ----------------------------
DROP TABLE IF EXISTS `tp_team`;
CREATE TABLE `tp_team`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `sort` mediumint(8) NULL DEFAULT 50 COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  `cate_id` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '栏目',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '作者',
  `source` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '来源',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',
  `summary` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '摘要',
  `image` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '图片集',
  `download` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文件下载',
  `tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'TAG',
  `hits` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '点击次数',
  `keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '关键词',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '描述',
  `template` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '模板',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '跳转地址',
  `area` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '区域',
  `sex` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '性别',
  `view_auth` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '阅读权限',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '团队模块' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_team
-- ----------------------------
INSERT INTO `tp_team` VALUES (1, 1581079608, 1581079608, 50, 1, 12, '国内总设计师', '管理员', '本站', '', '多年从业经验，精益求精，客户至上，您的满意是我们不懈的追求！', '/uploads/20181224/6d003cbc391614dda73fbb2ab2bb109c.jpg', '', '', '', 0, '', '', '', '', 1, 0, 0);
INSERT INTO `tp_team` VALUES (2, 1581079640, 1581079640, 50, 1, 12, '国外销售总监', '管理员', '本站', '', '多年从业经验，精益求精，客户至上，您的满意是我们不懈的追求！', '/uploads/20181224/7ea6c84dc1454ab28a4d54c90655e6e0.jpg', '', '', '', 1, '', '', '', '', 2, 2, 0);
INSERT INTO `tp_team` VALUES (3, 1581079668, 1581079668, 50, 1, 12, '国内技术总监', '管理员', '本站', '', '多年从业经验，精益求精，客户至上，您的满意是我们不懈的追求！', '/uploads/20181224/7ea6c84dc1454ab28a4d54c90655e6e0.jpg', '', '', '', 0, '', '', '', '', 1, 2, 0);
INSERT INTO `tp_team` VALUES (4, 1581079697, 1581079697, 50, 1, 12, '国内网络总监', '管理员', '本站', '', '多年从业经验，精益求精，客户至上，您的满意是我们不懈的追求！', '/uploads/20181224/afd088573e24003aadddb5744649dda9.jpg', '', '', '', 0, '', '', '', '', 1, 1, 0);
INSERT INTO `tp_team` VALUES (5, 1581079608, 1581079608, 50, 1, 12, '国内总设计师', '管理员', '本站', '', '多年从业经验，精益求精，客户至上，您的满意是我们不懈的追求！', '/uploads/20181224/6d003cbc391614dda73fbb2ab2bb109c.jpg', '', '', '', 0, '', '', '', '', 1, 0, 0);
INSERT INTO `tp_team` VALUES (6, 1581079640, 1581079640, 50, 1, 12, '国外销售总监', '管理员', '本站', '', '多年从业经验，精益求精，客户至上，您的满意是我们不懈的追求！', '/uploads/20181224/7ea6c84dc1454ab28a4d54c90655e6e0.jpg', '', '', '', 1, '', '', '', '', 2, 2, 0);
INSERT INTO `tp_team` VALUES (7, 1581079668, 1581079668, 50, 1, 12, '国内技术总监', '管理员', '本站', '', '多年从业经验，精益求精，客户至上，您的满意是我们不懈的追求！', '/uploads/20181224/7ea6c84dc1454ab28a4d54c90655e6e0.jpg', '', '', '', 0, '', '', '', '', 1, 2, 0);
INSERT INTO `tp_team` VALUES (8, 1581079697, 1581079697, 50, 1, 12, '国内网络总监', '管理员', '本站', '', '多年从业经验，精益求精，客户至上，您的满意是我们不懈的追求！', '/uploads/20181224/afd088573e24003aadddb5744649dda9.jpg', '', '', '', 0, '', '', '', '', 1, 1, 0);
INSERT INTO `tp_team` VALUES (9, 1581079608, 1581079608, 50, 1, 12, '国内总设计师', '管理员', '本站', '', '多年从业经验，精益求精，客户至上，您的满意是我们不懈的追求！', '/uploads/20181224/6d003cbc391614dda73fbb2ab2bb109c.jpg', '', '', '', 0, '', '', '', '', 1, 0, 0);
INSERT INTO `tp_team` VALUES (10, 1581079640, 1581079640, 50, 1, 12, '国外销售总监', '管理员', '本站', '', '多年从业经验，精益求精，客户至上，您的满意是我们不懈的追求！', '/uploads/20181224/7ea6c84dc1454ab28a4d54c90655e6e0.jpg', '', '', '', 1, '', '', '', '', 2, 2, 0);
INSERT INTO `tp_team` VALUES (11, 1581079668, 1581079668, 50, 1, 12, '国内技术总监', '管理员', '本站', '', '多年从业经验，精益求精，客户至上，您的满意是我们不懈的追求！', '/uploads/20181224/7ea6c84dc1454ab28a4d54c90655e6e0.jpg', '', '', '', 0, '', '', '', '', 1, 2, 0);
INSERT INTO `tp_team` VALUES (12, 1581079697, 1581079697, 50, 1, 12, '国内网络总监', '管理员', '本站', '', '多年从业经验，精益求精，客户至上，您的满意是我们不懈的追求！', '/uploads/20181224/afd088573e24003aadddb5744649dda9.jpg', '', '', '', 0, '', '', '', '', 1, 1, 0);
INSERT INTO `tp_team` VALUES (13, 1581079608, 1581079608, 50, 1, 12, '国内保密设计师', '管理员', '本站', '', '多年从业经验，精益求精，客户至上，您的满意是我们不懈的追求！', '/uploads/20181224/6d003cbc391614dda73fbb2ab2bb109c.jpg', '', '', '', 0, '', '', '', '', 1, 0, 0);
INSERT INTO `tp_team` VALUES (14, 1581079640, 1581079640, 50, 1, 12, '国外销售总监', '管理员', '本站', '', '多年从业经验，精益求精，客户至上，您的满意是我们不懈的追求！', '/uploads/20181224/7ea6c84dc1454ab28a4d54c90655e6e0.jpg', '', '', '', 1, '', '', '', '', 2, 2, 0);
INSERT INTO `tp_team` VALUES (15, 1581079668, 1581079668, 50, 1, 12, '国内技术总监', '管理员', '本站', '', '多年从业经验，精益求精，客户至上，您的满意是我们不懈的追求！', '/uploads/20181224/7ea6c84dc1454ab28a4d54c90655e6e0.jpg', '', '', '', 0, '', '', '', '', 1, 2, 0);
INSERT INTO `tp_team` VALUES (16, 1581079697, 1581079697, 50, 1, 12, '国内网络总监', '管理员', '本站', '', '多年从业经验，精益求精，客户至上，您的满意是我们不懈的追求！', '/uploads/20181224/afd088573e24003aadddb5744649dda9.jpg', '', '', '', 0, '', '', '', '', 1, 1, 0);

-- ----------------------------
-- Table structure for tp_users
-- ----------------------------
DROP TABLE IF EXISTS `tp_users`;
CREATE TABLE `tp_users`  (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '密码',
  `sex` tinyint(1) NOT NULL DEFAULT 0 COMMENT '性别:0=保密,1=男,2=女',
  `last_login_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '最后登录时间',
  `last_login_ip` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `qq` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT 'QQ',
  `mobile` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '手机号',
  `mobile_validated` tinyint(3) NULL DEFAULT 0 COMMENT '验证手机:1=验证,0=未验证',
  `email_validated` tinyint(3) NULL DEFAULT 0 COMMENT '验证邮箱:1=验证,0=未验证',
  `type_id` tinyint(3) NULL DEFAULT 0 COMMENT '所属分组',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `create_ip` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '注册IP',
  `update_time` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '更新时间',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '会员表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_users
-- ----------------------------
INSERT INTO `tp_users` VALUES (1, 'test001@qq.com', 'e10adc3949ba59abbe56e057f20f883e', 2, 1583746801, '127.0.0.1', '222222', '111111', 0, 0, 1, 1, '127.0.0.1', 1583747367, 1541405155);
INSERT INTO `tp_users` VALUES (2, 'test002@qq.com', 'e10adc3949ba59abbe56e057f20f883e', 0, 1541405185, '127.0.0.1', '407593529', '15840189627', 0, 0, 2, 1, '127.0.0.1', 1541405155, 1541405185);
INSERT INTO `tp_users` VALUES (3, 'test003@qq.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 1546060654, '127.0.0.1', '', '', 0, 0, 1, 1, '127.0.0.1', 1541405155, 1546060654);
INSERT INTO `tp_users` VALUES (4, 'test004@qq.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 1546060666, '127.0.0.1', '', '', 0, 0, 1, 1, '127.0.0.1', 1541405155, 1546060666);
INSERT INTO `tp_users` VALUES (5, 'test005@qq.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 1546060680, '127.0.0.1', '', '15840189625', 0, 0, 1, 1, '127.0.0.1', 1579591129, 1546060680);
INSERT INTO `tp_users` VALUES (6, 'test007@qq.com', 'e10adc3949ba59abbe56e057f20f883e', 0, 1546061841, '127.0.0.1', NULL, NULL, 0, 0, 1, 1, '127.0.0.1', 1541405155, 1546061841);
INSERT INTO `tp_users` VALUES (7, 'test008@qq.com', 'e10adc3949ba59abbe56e057f20f883e', 0, 1546062123, '127.0.0.1', '123', '', 1, 0, 1, 1, '127.0.0.1', 1551844614, 1546061953);
INSERT INTO `tp_users` VALUES (13, 'test009@qq.com', '96e79218965eb72c92a549dd5a330112', 0, 1583747029, '127.0.0.1', NULL, NULL, 0, 0, 1, 1, '127.0.0.1', 0, 1583747029);

-- ----------------------------
-- Table structure for tp_users_type
-- ----------------------------
DROP TABLE IF EXISTS `tp_users_type`;
CREATE TABLE `tp_users_type`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分组名称',
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '描述',
  `sort` int(5) UNSIGNED NOT NULL DEFAULT 50 COMMENT '排序',
  `status` tinyint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '会员分组' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tp_users_type
-- ----------------------------
INSERT INTO `tp_users_type` VALUES (1, 1541405155, 1541405155, '普通会员', '普通会员', 1, 1);
INSERT INTO `tp_users_type` VALUES (2, 1541405155, 1541405155, 'VIP会员', 'VIP会员', 2, 1);

SET FOREIGN_KEY_CHECKS = 1;
