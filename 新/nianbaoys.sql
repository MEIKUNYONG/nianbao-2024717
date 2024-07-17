/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : nianbaoys

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2024-07-17 13:48:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for nianbao_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_admin_user`;
CREATE TABLE `nianbao_admin_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(250) DEFAULT NULL COMMENT '真实姓名',
  `user` varchar(250) DEFAULT NULL COMMENT '用户名',
  `pwd` varchar(250) DEFAULT NULL COMMENT '密码',
  `role_id` int(11) DEFAULT NULL COMMENT '所属分组',
  `note` varchar(250) DEFAULT NULL COMMENT '备注',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of nianbao_admin_user
-- ----------------------------
INSERT INTO `nianbao_admin_user` VALUES ('1', '超级管理员', 'admin', '7b2ad4e307d5b3ec9e786054225d0985', '1', '超级管理员', '1', '1548558919');
INSERT INTO `nianbao_admin_user` VALUES ('32', '测试', 'test01', '7b2ad4e307d5b3ec9e786054225d0985', '52', '', '1', '1660878486');

-- ----------------------------
-- Table structure for nianbao_area
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_area`;
CREATE TABLE `nianbao_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area_sheng` varchar(255) DEFAULT NULL COMMENT '省',
  `area_shi` varchar(255) DEFAULT NULL COMMENT '市',
  `area_qu` varchar(255) DEFAULT NULL COMMENT '区',
  `area_price` decimal(10,2) DEFAULT '0.00',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of nianbao_area
-- ----------------------------
INSERT INTO `nianbao_area` VALUES ('1', '北京市', '北京市', '东城区', '200.00', '1');
INSERT INTO `nianbao_area` VALUES ('2', '河北省', '石家庄市', '长安区', '100.00', '1');

-- ----------------------------
-- Table structure for nianbao_base_config
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_base_config`;
CREATE TABLE `nianbao_base_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(50) NOT NULL,
  `data` text,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of nianbao_base_config
-- ----------------------------
INSERT INTO `nianbao_base_config` VALUES ('1', 'site_title', '领客年报通管理系统');
INSERT INTO `nianbao_base_config` VALUES ('2', 'logo', 'https://nianbao.2751.cn/uploads/admin/202403/65f797222aa1e.jpg');
INSERT INTO `nianbao_base_config` VALUES ('3', 'keyword', '');
INSERT INTO `nianbao_base_config` VALUES ('4', 'descrip', '企业年报');
INSERT INTO `nianbao_base_config` VALUES ('5', 'copyright', '版权');
INSERT INTO `nianbao_base_config` VALUES ('6', 'filesize', '100');
INSERT INTO `nianbao_base_config` VALUES ('7', 'filetype', 'gif,png,jpg,jpeg,doc,docx,xls,xlsx,csv,pdf,rar,zip,txt,mp4,flv,wgt,pem');
INSERT INTO `nianbao_base_config` VALUES ('8', 'water_status', '0');
INSERT INTO `nianbao_base_config` VALUES ('9', 'water_position', '5');
INSERT INTO `nianbao_base_config` VALUES ('10', 'domain', 'https://nianbao.2751.cn');
INSERT INTO `nianbao_base_config` VALUES ('20', 'water_alpha', '90');
INSERT INTO `nianbao_base_config` VALUES ('21', 'appsecret', '');
INSERT INTO `nianbao_base_config` VALUES ('22', 'appid', '');
INSERT INTO `nianbao_base_config` VALUES ('23', 'db_img', 'https://nianbao.2751.cn/uploads/admin/202306/649e8f97e6c0d.png');
INSERT INTO `nianbao_base_config` VALUES ('24', 'wxlogo', 'https://nianbao.2751.cn/uploads/admin/202306/649e8f884afa2.png');
INSERT INTO `nianbao_base_config` VALUES ('25', 'agreement_title', '年报通用户协议');
INSERT INTO `nianbao_base_config` VALUES ('26', 'privacy_content', '<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp; 领客年报通(以下简称&ldquo;年报通&rdquo;)。确保用户的数据安全和隐私保护是我们的首要任务，本隐私政策载明了您访问和使用我们的产品和服务时所收集的数据及其处理方式。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;请您在继续使用我们的产品前务必认真仔细阅读并确认充分理解本隐私政策全部规则和要点，一旦您选择使用，即视为您同意本隐私政策的全部内容，同意我们按其收集和使用您的相关信息。如您在在阅读过程中对本政策有任何疑问，可联系我们的客服咨询，请通过客服电话15666666666或年报通中的在线客服与我们取得联系。如您不同意相关协议或其中的任何条款的，您应停止使用我们的产品和服务。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 本隐私政策帮助您了解以下内容：</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 一、我们如何收集和使用您的个人信息；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 二、我们如何存储和保护您的个人信息；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 三、我们如何共享、转让、公开披露您的个人信息；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 一、我们如何收集和使用您的个人信息</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 个人信息是指以电子或者其他方式记录的能够单独或者与其他信息，结合识别特定自然人身份或者反映特定自然人活动情况的各种信息。我们根据《中华人民共和国网络安全法》和《信息安全技术个人信息安全规范》(GB/T35273-2017)以及其它相关法律法规的要求，并严格遵循正当、合法、必要的原则，出于您使用我们提供的服务和/或产品等过程中而收集和使用您的个人信息，包括但不限于电话号码等。在怒初次使用本系统时，需要您提供手机号进行登录。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;二、我们如何存储和保护您的个人信息</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;作为一般规则，我们仅在实现信息收集目的所需的时间内保留您的个人信息。我们会在对于管理与您之间的关系严格必要的时间内保留您的人信息。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;当您的个人信息对于我们的法定义务或法定时效对应的目的或档案不再必要时，我们确保将其完全删除或匿名化。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;我们使用符合业界标准的安全防护措施保护您提供的个人信息，并加密其中的关键数据，防止其遭到未经授权访问、公开披露、使用、修改、损坏或丢失。我们会采取一切合理可行的措施，保护您的个人信息。我们会使用加密技术确保数据的保密性;我们会使用受信赖的保护机制防止数据遭到恶意攻击。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;为了加强对隐私数据的保护，我们在收集时就已对其进行了脱敏处理，即使在我们自己的数据库中，也不会储存具有关联性的、明文的隐私数据。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;三、我们如何共享、转让、公开披露您的个人信息在管理我们的日常业务活动所需要时，为追求合法利益以更好地服务客户，我们将合规且恰当的使用您的个人信息。我们不会主动共享或转让你的信息至任何第三方，如存在确需共享或转让时，开发者应当直接征得或确认第三方征得你的单独同意开发者承诺，不会对外公开披露你的信息，如必须公开披露时，我们会向你告知公开披露的目的、披露信息的类型及可能涉及的信息，并征得你的单独同意。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;在以下情形中，共享、转让、公开披露您的个人信息无需事先征得您的授权同意</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;1、与国家安全、国防安全直接相关的；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;2、与犯罪侦查、起诉、审判和判决执行等直接相关的；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;3、出于维护您或其他个人的生命、财产等重大合法权益但又很难得到本人同意的；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;4、您自行向社会公众公开的个人信息；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;5、从合法公开披露的信息中收集个人信息的，如合法的新闻报道、政府信息公开等渠道的;</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;6、根据个人信息主体要求签订和履行合同所必需的；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;7、用于维护所提供的产品或服务的安全稳定运行所必需的，例如发现、处置产品或服务的故障；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;8、法律法规规定的其他情形。若你认为开发者未遵守上述约定，或有其他的投诉建议、或未成年人个人信息保护相关问题，可通过以下方式与开发者联系;或者向微信进行投诉。</span></p>');
INSERT INTO `nianbao_base_config` VALUES ('27', 'agreement_content', '<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;领客年报通(以下简称&ldquo;本平台&rdquo;)，为经营主体提供年报代报、经营异常移出等业务。本平台属于第三方征信机构，为付费用户提供相关代办服务。本协议仅对付费用户与我司就办理代办年报报送、经营异常移出等事宜所签署的具有法律约束力的文件。您已充分阅读、理解并接受本协议的全部内容，知悉支付费用即表示您委托我司全权为您办理年报报送或经营异常移出事宜，我司将通过网络在线方式为您提供代办服务。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp; 一、您知悉，按照《企业信息公示暂行条例》《个体工商户年度报告暂行办法》等法规文件，报送年报是您的法定义务。您也知悉，通过市场监督管理部门渠道报送年报、移除经营异常是免费的，通过我司代办业务您需向我司支付代报费用。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp; 二、您知悉，为办理业务之必要，您需要向我司提供包括但不限于法定代表人或负责人身份证、手机号经营状况等资料，您应当保证资料的真实性、完整性合法性。我司将根据您的委托，按照管辖地市场监督管理部门的规定，及时为您办理相关业务</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp; 三、在您提交相关资料后，我司将在15个工作日完成代办工作，如在15个工作日内未能办结的，我司将根据您的要求或者继续办理或者全额退款。要求退款的我司将在之后5个工作日内完成:要求继续办理的，您将不追究我司在承诺时间内未能办结的任何责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp; 四、年报报送成功或经营异常移出成功或我司向您全额退款即意味着您与我司委托代理关系终止，本协议亦随即终止。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp; 五、我司受理您的委托后，将忠实履行代理义务。如您在业务办理过程中有任何异议，均可通过本协议第八条联系方式向我司反映，我司将及时进行处理。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp; 六、针对为完成年报报送您所提交的资料(见本协议第三条)，您知晓并同意按以下方式处理: 1、凡业务办理成功的，您所提交的资料将保存至下一年度的年报报送截止日，但您选择&ldquo;不公开&rdquo;的内容我司将不做保存;2、业务未办理成功或您要求终止委托关系而全额退款的，我司仅保存您的联系方式(含手机号)，其他资料不做保存: 3、凡我司保存的资料，我司将采取严格的保密措施，未经您同意，不公开、不向任何第三方提供，所保存的联系方式也仅用于与您本人联系。 4因我司违背上述约定而引发的一切后果由我司承担。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 七、我司为您提供人工电话服务，服务电话: 15666666666;您可通过该电话咨询业务、了解进程、反映问题、进行投诉等。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 八、如我司未违背本协议约定，您不得向任何第三方发布、提供有损我司利益、名誉的信息，否则我司有权追究您的法律责任</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 九、如您与我司就本协议内容或其执行发生任何争议，双方应尽力友好协商解决;协商不成时，应向协议签订地有管辖权的人民法院提起诉讼。</span></p>');
INSERT INTO `nianbao_base_config` VALUES ('28', 'privacy_title', '领客年报通隐私政策');
INSERT INTO `nianbao_base_config` VALUES ('29', 'wxtitle', '领客年报通');
INSERT INTO `nianbao_base_config` VALUES ('30', 'specialfee', '0.01');
INSERT INTO `nianbao_base_config` VALUES ('31', 'normalfee', '200');
INSERT INTO `nianbao_base_config` VALUES ('32', 'submitted_title', '代理报送年报服务协议');
INSERT INTO `nianbao_base_config` VALUES ('33', 'normal_content', '<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;一、本协议将成为您与我司就办理年报报送事宜所签署的具有法律约束力的文件。您已充分阅读、理解并接受本协议的全部内容，知悉支付年报代报费用即表示您委托我司全权为您办理年报报送事宜，我司将通过网络在线方式为您提供年报代报服务</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;二、您知悉，按照《企业信息公示暂行条例》《个体工商户年度报告暂行办法》等法规文件，报送年报是您的法定义务。您也知悉，通过市场监督管理部门渠道报送年报是免费的，通过我司代办年报报送您需向我司支付200元代报费用。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;三、您知悉，为办理年报报送之必要，您需要向我司提供包括但不限于法定代表人或负责人身份证、手机号、经营状况等资料，您应当保证资料的真实性、完整性、合法性。我司将根据您的委托，按照管辖地市场监督管理部门的规定，及时为您办理年报报送的相关事宜。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;四、在您提交年报报送资料后，我司将在15个工作日完成年报报送工作，报送成功的标志是您的年报信息在&ldquo;全国企业信用信息公示系统&rdquo;中公示或在辖区市场监管部门网站公示。如在15个工作日内未能办结的，我司将根据您的要求或者继续办理或者全额退款。要求退款的，我司将在之后5个工作日内完成;要求继续办理的，您将不追究我司在承诺时间内未能办结的任何责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;五、年报报送成功或我司向您全额退款即意味着您与我司委托代理关系终止，本协议亦随即终止。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;六、因年报的报送截止日期为每年的6月30日，故我司原则上不再受理6月20日以后的委托。如您仍选择委托我司办理年报代报的，则意味着您自愿承担在6月30日之前报送不成功的风险，届时因未在截止时间前报送成功所产生的一切法律后果(包括但不限于经营异常、行政处罚等)由您自行承担，我司不因此承担任何责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;七、我司受理您的年报报送委托后，将忠实履行代理义务。如您在年报代报过程中有任何异议，均可通过本协议第九条联系方式向我司反映，我司将及时进行处理。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;八、针对为完成年报报送您所提交的资料(见本协议第三条)，您知晓并同意按以下方式处理：</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;1、凡报送成功的，您所提交的资料将保存至下一年度的年报报送截止日，但您选择&ldquo;不公开&rdquo;的内容我司将不做保存；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;2、已提交年报资料但报送未成功或您要求终止委托关系而全额退款的，我司仅保存您的联系方式(含手机号)，其他资料不做保存；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;3、凡我司保存的资料，我司将采取严格的保密措施，未经您同意，不公开、不向任何第三方提供，所保存的联系方式也仅用于与您本人联系。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;4、因我司违背上述约定而引发的一切后果由我司承担。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;九、我司为您提供人工电话服务，服务电话: 15666666666;您可通过该电话咨询业务、了解进程、反映问题、进行投诉等。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;十、如我司未违背本协议约定，您不得向任何第三方发布、提供有损我司利益、名誉的信息，否则我司有权追究您的法律责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;十一、如您与我司就本协议内容或其执行发生任何争议，双方应尽力友好协商解决:协商不成时，应向协议签订地有管辖权的人民法院提起诉讼。</span></p>');
INSERT INTO `nianbao_base_config` VALUES ('34', 'special_content', '<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;一、本协议将成为您与我司就办理年报报送事宜所签署的具有法律约束力的文件。您已充分阅读、理解并接受本协议的全部内容，知悉支付年报代报费用即表示您委托我司全权为您办理年报报送事宜，我司将通过网络在线方式为您提供年报代报服务</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;二、您知悉，按照《企业信息公示暂行条例》《个体工商户年度报告暂行办法》等法规文件，报送年报是您的法定义务。您也知悉，通过市场监督管理部门渠道报送年报是免费的，通过我司代办年报报送您需向我司支付90元代报费用。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;三、您知悉，为办理年报报送之必要，您需要向我司提供包括但不限于法定代表人或负责人身份证、手机号、经营状况等资料，您应当保证资料的真实性、完整性、合法性。我司将根据您的委托，按照管辖地市场监督管理部门的规定，及时为您办理年报报送的相关事宜。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;四、在您提交年报报送资料后，我司将在15个工作日完成年报报送工作，报送成功的标志是您的年报信息在&ldquo;全国企业信用信息公示系统&rdquo;中公示或在辖区市场监管部门网站公示。如在15个工作日内未能办结的，我司将根据您的要求或者继续办理或者全额退款。要求退款的，我司将在之后5个工作日内完成;要求继续办理的，您将不追究我司在承诺时间内未能办结的任何责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;五、年报报送成功或我司向您全额退款即意味着您与我司委托代理关系终止，本协议亦随即终止。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;六、因年报的报送截止日期为每年的6月30日，故我司原则上不再受理6月20日以后的委托。如您仍选择委托我司办理年报代报的，则意味着您自愿承担在6月30日之前报送不成功的风险，届时因未在截止时间前报送成功所产生的一切法律后果(包括但不限于经营异常、行政处罚等)由您自行承担，我司不因此承担任何责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;七、我司受理您的年报报送委托后，将忠实履行代理义务。如您在年报代报过程中有任何异议，均可通过本协议第九条联系方式向我司反映，我司将及时进行处理。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;八、针对为完成年报报送您所提交的资料(见本协议第三条)，您知晓并同意按以下方式处理：</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;1、凡报送成功的，您所提交的资料将保存至下一年度的年报报送截止日，但您选择&ldquo;不公开&rdquo;的内容我司将不做保存；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;2、已提交年报资料但报送未成功或您要求终止委托关系而全额退款的，我司仅保存您的联系方式(含手机号)，其他资料不做保存；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;3、凡我司保存的资料，我司将采取严格的保密措施，未经您同意，不公开、不向任何第三方提供，所保存的联系方式也仅用于与您本人联系。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;4、因我司违背上述约定而引发的一切后果由我司承担。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;九、我司为您提供人工电话服务，服务电话: 15666666666;您可通过该电话咨询业务、了解进程、反映问题、进行投诉等。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;十、如我司未违背本协议约定，您不得向任何第三方发布、提供有损我司利益、名誉的信息，否则我司有权追究您的法律责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;十一、如您与我司就本协议内容或其执行发生任何争议，双方应尽力友好协商解决:协商不成时，应向协议签订地有管辖权的人民法院提起诉讼。</span></p>');
INSERT INTO `nianbao_base_config` VALUES ('35', 'service_telephone', '15666666666');
INSERT INTO `nianbao_base_config` VALUES ('36', 'key', '');
INSERT INTO `nianbao_base_config` VALUES ('37', 'secretkey', '');
INSERT INTO `nianbao_base_config` VALUES ('38', 'type', '1');
INSERT INTO `nianbao_base_config` VALUES ('39', 'mch_id', '');
INSERT INTO `nianbao_base_config` VALUES ('40', 'pay_secretkey', '');
INSERT INTO `nianbao_base_config` VALUES ('41', 'orgid', '');
INSERT INTO `nianbao_base_config` VALUES ('42', 'mno', '');
INSERT INTO `nianbao_base_config` VALUES ('43', 'privatekey', '');
INSERT INTO `nianbao_base_config` VALUES ('44', 'sxfpublic', '');
INSERT INTO `nianbao_base_config` VALUES ('45', 'topleft_logo', 'https://nianbao.2751.cn/uploads/admin/202306/649e90f5decd0.png');
INSERT INTO `nianbao_base_config` VALUES ('46', 'topright_logo', 'https://nianbao.2751.cn/uploads/admin/202306/649258a1a865a.png');
INSERT INTO `nianbao_base_config` VALUES ('47', 'specialprompt', '领客年报通，为经营主体提供年报代报服务的平台代报服务费90元，如办理不成功全额退款。');
INSERT INTO `nianbao_base_config` VALUES ('48', 'normalprompt', '领客年报通，为经营主体提供年报代报服务的平台代报服务费200元，如办理不成功全额退款。');
INSERT INTO `nianbao_base_config` VALUES ('49', 'bottom_copyright', '领客年报通由保定领客信息技术有限公司提供技术支持');
INSERT INTO `nianbao_base_config` VALUES ('50', 'article_link', '');
INSERT INTO `nianbao_base_config` VALUES ('51', 'top_word', '本平台提供年报代办服务，方便快捷，如办理不成功可全额退款。');
INSERT INTO `nianbao_base_config` VALUES ('52', 'cert_path', '/uploads/admin/202306/6497bef061bd2.pem');
INSERT INTO `nianbao_base_config` VALUES ('53', 'key_path', '/uploads/admin/202306/6497bef7d7f51.pem');
INSERT INTO `nianbao_base_config` VALUES ('54', 'hy_apiid', '');
INSERT INTO `nianbao_base_config` VALUES ('55', 'hy_apikey', '');
INSERT INTO `nianbao_base_config` VALUES ('56', 'hy_type', '1');
INSERT INTO `nianbao_base_config` VALUES ('57', 'shoptop_logo', 'https://nianbao.2751.cn/uploads/admin/202311/65487891de2a1.png');
INSERT INTO `nianbao_base_config` VALUES ('58', 'is_mo', '1');
INSERT INTO `nianbao_base_config` VALUES ('59', 'noareafee', '150');
INSERT INTO `nianbao_base_config` VALUES ('60', 'mo_submitted_title', '年报代报送协议');
INSERT INTO `nianbao_base_config` VALUES ('61', 'mo_tongyi_content', '<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;一、本协议将成为您与我司就办理年报报送事宜所签署的具有法律约束力的文件。您已充分阅读、理解并接受本协议的全部内容，知悉支付年报代报费用即表示您委托我司全权为您办理年报报送事宜，我司将通过网络在线方式为您提供年报代报服务</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;二、您知悉，按照《企业信息公示暂行条例》《个体工商户年度报告暂行办法》等法规文件，报送年报是您的法定义务。您也知悉，通过市场监督管理部门渠道报送年报是免费的，通过我司代办年报报送您需向我司支付代报费用。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;三、您知悉，为办理年报报送之必要，您需要向我司提供包括但不限于法定代表人或负责人身份证、手机号、经营状况等资料，您应当保证资料的真实性、完整性、合法性。我司将根据您的委托，按照管辖地市场监督管理部门的规定，及时为您办理年报报送的相关事宜。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;四、在您提交年报报送资料后，我司将在15个工作日完成年报报送工作，报送成功的标志是您的年报信息在&ldquo;全国企业信用信息公示系统&rdquo;中公示或在辖区市场监管部门网站公示。如在15个工作日内未能办结的，我司将根据您的要求或者继续办理或者全额退款。要求退款的，我司将在之后5个工作日内完成;要求继续办理的，您将不追究我司在承诺时间内未能办结的任何责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;五、年报报送成功或我司向您全额退款即意味着您与我司委托代理关系终止，本协议亦随即终止。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;六、因年报的报送截止日期为每年的6月30日，故我司原则上不再受理6月20日以后的委托。如您仍选择委托我司办理年报代报的，则意味着您自愿承担在6月30日之前报送不成功的风险，届时因未在截止时间前报送成功所产生的一切法律后果(包括但不限于经营异常、行政处罚等)由您自行承担，我司不因此承担任何责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;七、我司受理您的年报报送委托后，将忠实履行代理义务。如您在年报代报过程中有任何异议，均可通过本协议第九条联系方式向我司反映，我司将及时进行处理。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;八、针对为完成年报报送您所提交的资料(见本协议第三条)，您知晓并同意按以下方式处理：</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;1、凡报送成功的，您所提交的资料将保存至下一年度的年报报送截止日，但您选择&ldquo;不公开&rdquo;的内容我司将不做保存；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;2、已提交年报资料但报送未成功或您要求终止委托关系而全额退款的，我司仅保存您的联系方式(含手机号)，其他资料不做保存；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;3、凡我司保存的资料，我司将采取严格的保密措施，未经您同意，不公开、不向任何第三方提供，所保存的联系方式也仅用于与您本人联系。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;4、因我司违背上述约定而引发的一切后果由我司承担。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;九、我司为您提供人工电话服务，服务电话: 15666666666;您可通过该电话咨询业务、了解进程、反映问题、进行投诉等。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;十、如我司未违背本协议约定，您不得向任何第三方发布、提供有损我司利益、名誉的信息，否则我司有权追究您的法律责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;十一、如您与我司就本协议内容或其执行发生任何争议，双方应尽力友好协商解决:协商不成时，应向协议签订地有管辖权的人民法院提起诉讼。</span></p>');
INSERT INTO `nianbao_base_config` VALUES ('62', 'ycpic', 'https://nianbao.2751.cn/uploads/admin/202311/65487891de2a1.png');
INSERT INTO `nianbao_base_config` VALUES ('63', 'qypic', 'https://nianbao.2751.cn/uploads/admin/202311/654861faa08a1.png');
INSERT INTO `nianbao_base_config` VALUES ('64', 'is_nbapi', '0');
INSERT INTO `nianbao_base_config` VALUES ('65', 'duo_pay_title', '年报付款协议');
INSERT INTO `nianbao_base_config` VALUES ('66', 'duo_pay_content', '<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;一、本协议将成为您与我司就办理年报报送事宜所签署的具有法律约束力的文件。您已充分阅读、理解并接受本协议的全部内容，知悉支付年报代报费用即表示您委托我司全权为您办理年报报送事宜，我司将通过网络在线方式为您提供年报代报服务</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;二、您知悉，按照《企业信息公示暂行条例》《个体工商户年度报告暂行办法》等法规文件，报送年报是您的法定义务。您也知悉，通过市场监督管理部门渠道报送年报是免费的，通过我司代办年报报送您需向我司支付代报费用。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;三、您知悉，为办理年报报送之必要，您需要向我司提供包括但不限于法定代表人或负责人身份证、手机号、经营状况等资料，您应当保证资料的真实性、完整性、合法性。我司将根据您的委托，按照管辖地市场监督管理部门的规定，及时为您办理年报报送的相关事宜。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;四、在您提交年报报送资料后，我司将在15个工作日完成年报报送工作，报送成功的标志是您的年报信息在&ldquo;全国企业信用信息公示系统&rdquo;中公示或在辖区市场监管部门网站公示。如在15个工作日内未能办结的，我司将根据您的要求或者继续办理或者全额退款。要求退款的，我司将在之后5个工作日内完成;要求继续办理的，您将不追究我司在承诺时间内未能办结的任何责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;五、年报报送成功或我司向您全额退款即意味着您与我司委托代理关系终止，本协议亦随即终止。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;六、因年报的报送截止日期为每年的6月30日，故我司原则上不再受理6月20日以后的委托。如您仍选择委托我司办理年报代报的，则意味着您自愿承担在6月30日之前报送不成功的风险，届时因未在截止时间前报送成功所产生的一切法律后果(包括但不限于经营异常、行政处罚等)由您自行承担，我司不因此承担任何责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;七、我司受理您的年报报送委托后，将忠实履行代理义务。如您在年报代报过程中有任何异议，均可通过本协议第九条联系方式向我司反映，我司将及时进行处理。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;八、针对为完成年报报送您所提交的资料(见本协议第三条)，您知晓并同意按以下方式处理：</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;1、凡报送成功的，您所提交的资料将保存至下一年度的年报报送截止日，但您选择&ldquo;不公开&rdquo;的内容我司将不做保存；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;2、已提交年报资料但报送未成功或您要求终止委托关系而全额退款的，我司仅保存您的联系方式(含手机号)，其他资料不做保存；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;3、凡我司保存的资料，我司将采取严格的保密措施，未经您同意，不公开、不向任何第三方提供，所保存的联系方式也仅用于与您本人联系。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;4、因我司违背上述约定而引发的一切后果由我司承担。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;九、我司为您提供人工电话服务，服务电话: 15666666666;您可通过该电话咨询业务、了解进程、反映问题、进行投诉等。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;十、如我司未违背本协议约定，您不得向任何第三方发布、提供有损我司利益、名誉的信息，否则我司有权追究您的法律责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;十一、如您与我司就本协议内容或其执行发生任何争议，双方应尽力友好协商解决:协商不成时，应向协议签订地有管辖权的人民法院提起诉讼。</span></p>');
INSERT INTO `nianbao_base_config` VALUES ('67', 'is_duan', '1');
INSERT INTO `nianbao_base_config` VALUES ('68', 'duan_apikey', '');

-- ----------------------------
-- Table structure for nianbao_batch
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_batch`;
CREATE TABLE `nianbao_batch` (
  `batch_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` varchar(250) DEFAULT NULL COMMENT '标题',
  `sex` smallint(6) DEFAULT NULL COMMENT '性别',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态',
  `amount` decimal(10,2) DEFAULT NULL COMMENT '金额',
  `sortid` int(11) DEFAULT NULL COMMENT '排序号',
  `wb` text COMMENT '文本域',
  `bq` varchar(250) DEFAULT NULL COMMENT '标签',
  `jsq` decimal(10,2) DEFAULT NULL COMMENT '计数器',
  PRIMARY KEY (`batch_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of nianbao_batch
-- ----------------------------
INSERT INTO `nianbao_batch` VALUES ('1', '测试信息', '1', '1', '239.00', '1', '文本内容', 'layui', '4.00');
INSERT INTO `nianbao_batch` VALUES ('8', '张三', '1', '1', '11.00', '2', '测试2', 'thinkphp', '3.00');
INSERT INTO `nianbao_batch` VALUES ('10', '王五1', '1', '1', '31.00', '4', '寒塘冷月', 'xhadmin,xhcms', '1.00');
INSERT INTO `nianbao_batch` VALUES ('12', '何影青', '2', '1', '100.00', '5', '文本域', 'vue', '5.00');
INSERT INTO `nianbao_batch` VALUES ('13', '寒塘冷月', '1', '1', '568.00', '6', '会更好', 'xhadmin,vue', '4545.00');

-- ----------------------------
-- Table structure for nianbao_dimension
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_dimension`;
CREATE TABLE `nianbao_dimension` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dimension_content` longtext NOT NULL COMMENT '标注内容',
  `amount` double(10,2) NOT NULL COMMENT '金额',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `sortid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of nianbao_dimension
-- ----------------------------
INSERT INTO `nianbao_dimension` VALUES ('1', '高德标注', '1.00', '1', '1');
INSERT INTO `nianbao_dimension` VALUES ('2', '2024企业年报', '199.00', '1', '2');
INSERT INTO `nianbao_dimension` VALUES ('3', '花小猪', '99.00', '1', '3');

-- ----------------------------
-- Table structure for nianbao_dimensionfrom
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_dimensionfrom`;
CREATE TABLE `nianbao_dimensionfrom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `prompt` varchar(255) DEFAULT NULL COMMENT '提示',
  `is_must` tinyint(4) DEFAULT '1' COMMENT '是否必填',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `sortid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of nianbao_dimensionfrom
-- ----------------------------
INSERT INTO `nianbao_dimensionfrom` VALUES ('2', '标注名称', '请填写标注名称', '1', '1', '1');
INSERT INTO `nianbao_dimensionfrom` VALUES ('3', '营业电活', '请填写营业电话', '1', '1', '2');
INSERT INTO `nianbao_dimensionfrom` VALUES ('4', '经营详细地址', '请填写详细经营地址', '1', '1', '3');

-- ----------------------------
-- Table structure for nianbao_editor
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_editor`;
CREATE TABLE `nianbao_editor` (
  `editor_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL COMMENT '标题',
  `wangeditor` text COMMENT 'wangeditor编辑器',
  `tinymce` longtext COMMENT 'tinymce编辑器',
  `markdown` text COMMENT 'markdown编辑器',
  PRIMARY KEY (`editor_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of nianbao_editor
-- ----------------------------
INSERT INTO `nianbao_editor` VALUES ('1', '这是系统生成的编辑器组件', '<p>测试<img src=\"http://vue.whpj.vip/uploads/admin/202105/60af9043e29d0.jpg\" style=\"max-width: 100%;\"/></p>', '<p>在测试<img src=\"http://vue.whpj.vip/uploads/admin/202105/60af904d14069.jpg\" alt=\"\" width=\"200\" height=\"200\" /></p>', '![Deion](http://vue.whpj.vip/uploads/admin/202105/60af906eb84d6.jpg)');

-- ----------------------------
-- Table structure for nianbao_enterprise
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_enterprise`;
CREATE TABLE `nianbao_enterprise` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `enterprise_name` varchar(255) NOT NULL DEFAULT '' COMMENT '企业名称',
  `enterprise_code` varchar(255) NOT NULL DEFAULT '' COMMENT '企业代码',
  `mobile` varchar(255) NOT NULL DEFAULT '' COMMENT '手机号',
  `legal_person` varchar(255) NOT NULL DEFAULT '' COMMENT '法人代表人名称',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态',
  `is_special` tinyint(4) DEFAULT '0' COMMENT '是否是特价企业',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of nianbao_enterprise
-- ----------------------------

-- ----------------------------
-- Table structure for nianbao_enterprise_report
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_enterprise_report`;
CREATE TABLE `nianbao_enterprise_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `enterprise_id` int(11) DEFAULT NULL,
  `enterprise_code` varchar(255) NOT NULL COMMENT '企业代码',
  `report_year` varchar(255) NOT NULL DEFAULT '' COMMENT '年报年份',
  `is_report` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否年报：0.未|1.已',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of nianbao_enterprise_report
-- ----------------------------

-- ----------------------------
-- Table structure for nianbao_file
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_file`;
CREATE TABLE `nianbao_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filepath` varchar(255) DEFAULT NULL COMMENT '图片路径',
  `hash` varchar(32) DEFAULT NULL COMMENT '文件hash值',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `disk` varchar(20) DEFAULT NULL COMMENT '存储类似',
  `type` tinyint(4) DEFAULT NULL COMMENT '文件类型',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `hash` (`hash`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=372 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of nianbao_file
-- ----------------------------
INSERT INTO `nianbao_file` VALUES ('326', 'http://images.whpj.vip/admin/202208/cc608c637bec9117018cef0e4cc9c6dd.jpg', 'cc608c637bec9117018cef0e4cc9c6dd', '1660903432', 'qiniuyun', '1');
INSERT INTO `nianbao_file` VALUES ('368', 'https://nianbao.2751.cn/uploads/admin/202403/65f797222aa1e.jpg', '18459094dfe8e4512da3cb05a40780fe', '1710724898', 'local', '1');
INSERT INTO `nianbao_file` VALUES ('338', 'https://nianbao.2751.cn/uploads/admin/202306/649e90f5decd0.png', '5d018af2c8c5e5d3df3489a6f925c80d', '1688113397', 'local', '1');
INSERT INTO `nianbao_file` VALUES ('335', 'https://nianbao.2751.cn/uploads/admin/202306/649e8f884afa2.png', '44cf88e074aa6b35a1c114363cb3e75b', '1688113032', 'local', '1');
INSERT INTO `nianbao_file` VALUES ('367', 'https://nianbao.2751.cn/uploads/admin/202403/65f566fa2cf56.png', '858de299bb239547a657fa4e81f87000', '1710581498', 'local', '1');
INSERT INTO `nianbao_file` VALUES ('332', 'https://nianbao.2751.cn/uploads/admin/202306/649258a1a865a.png', '874cbddb0abea0a1a309fbc19e9569a6', '1687312545', 'local', '1');
INSERT INTO `nianbao_file` VALUES ('346', 'https://nianbao.2751.cn/uploads/admin/202311/654861faa08a1.png', '4c2e8b09f2216b6e6a4165a2329f41c6', '1699242490', 'local', '1');
INSERT INTO `nianbao_file` VALUES ('336', 'https://nianbao.2751.cn/uploads/admin/202306/649e8f97e6c0d.png', '213292a2a39dfa2e62ac0090c2b65e84', '1688113047', 'local', '1');
INSERT INTO `nianbao_file` VALUES ('342', 'https://nianbao.2751.cn/uploads/admin/202310/653689ad7c2a1.jpg', '83974cbd8e71a4edd645119410896481', '1698073005', 'local', '1');
INSERT INTO `nianbao_file` VALUES ('348', 'https://nianbao.2751.cn/uploads/admin/202311/65487891de2a1.png', 'f3710c313959fb0978a3f3dd36a286b6', '1699248273', 'local', '1');
INSERT INTO `nianbao_file` VALUES ('370', '/uploads/admin/202403/65fbe47b5c9b3.pem', 'c701b93911309af6a6fc267513df1627', '1711006843', 'local', null);
INSERT INTO `nianbao_file` VALUES ('360', '/uploads/admin/202311/654c4e6586b3e.pem', '38d1b7572a23dd8c0f7433d7d185502c', '1699499621', 'local', null);
INSERT INTO `nianbao_file` VALUES ('366', 'https://nianbao.2751.cn/uploads/admin/202403/65e2a5c00e51c.jpg', '8ca614b1147d5f6cf3eb8e842f844ab5', '1709352384', 'local', '1');
INSERT INTO `nianbao_file` VALUES ('369', '/uploads/admin/202403/65fbe478471cf.pem', 'ba7b4de573b043c484a3e84a254eb5a2', '1711006840', 'local', null);
INSERT INTO `nianbao_file` VALUES ('371', 'https://nianbao.2751.cn/uploads/admin/202403/6603e659725bf.png', 'c34ae1e11248822c76ca52a250b632be', '1711531609', 'local', '1');

-- ----------------------------
-- Table structure for nianbao_goods
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_goods`;
CREATE TABLE `nianbao_goods` (
  `goods_id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_name` varchar(250) DEFAULT NULL COMMENT '商品名称',
  `class_id` smallint(6) DEFAULT NULL COMMENT '所属分类',
  `pic` varchar(250) DEFAULT NULL COMMENT '封面图',
  `sale_price` decimal(10,2) DEFAULT NULL COMMENT '销售价',
  `images` text COMMENT '图集',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态',
  `cd` varchar(250) DEFAULT NULL COMMENT '产地',
  `store` int(11) DEFAULT NULL COMMENT '库存',
  `sortid` int(11) DEFAULT NULL COMMENT '排序',
  `create_time` int(11) DEFAULT NULL COMMENT '发布时间',
  `detail` text COMMENT '内容详情',
  `supplier_id` smallint(6) DEFAULT NULL COMMENT '供应商',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  PRIMARY KEY (`goods_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of nianbao_goods
-- ----------------------------

-- ----------------------------
-- Table structure for nianbao_goods_cata
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_goods_cata`;
CREATE TABLE `nianbao_goods_cata` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `class_name` varchar(250) DEFAULT NULL COMMENT '分类名称',
  `pid` smallint(6) DEFAULT NULL COMMENT '所属父类',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态',
  `sortid` int(11) DEFAULT NULL COMMENT '排序',
  `supplier_id` smallint(6) DEFAULT NULL COMMENT '供应商',
  PRIMARY KEY (`class_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of nianbao_goods_cata
-- ----------------------------

-- ----------------------------
-- Table structure for nianbao_link
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_link`;
CREATE TABLE `nianbao_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `enterprise_id` int(11) NOT NULL,
  `long_link` text NOT NULL,
  `duan_link` text NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of nianbao_link
-- ----------------------------

-- ----------------------------
-- Table structure for nianbao_linkcata
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_linkcata`;
CREATE TABLE `nianbao_linkcata` (
  `linkcata_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `class_name` varchar(250) DEFAULT NULL COMMENT '分类名称',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态',
  `jdt` smallint(6) DEFAULT NULL COMMENT '进度条',
  PRIMARY KEY (`linkcata_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of nianbao_linkcata
-- ----------------------------
INSERT INTO `nianbao_linkcata` VALUES ('2', '底部链接', '1', '41');
INSERT INTO `nianbao_linkcata` VALUES ('3', '首页分类', '1', '18');
INSERT INTO `nianbao_linkcata` VALUES ('4', '广告分类', '1', '48');
INSERT INTO `nianbao_linkcata` VALUES ('5', '测试分类a', '1', '24');
INSERT INTO `nianbao_linkcata` VALUES ('6', '默认分类', '1', '45');

-- ----------------------------
-- Table structure for nianbao_log
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_log`;
CREATE TABLE `nianbao_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `application_name` varchar(50) DEFAULT NULL COMMENT '应用名称',
  `username` varchar(250) DEFAULT NULL COMMENT '操作用户',
  `url` varchar(250) DEFAULT NULL COMMENT '请求url',
  `ip` varchar(250) DEFAULT NULL COMMENT 'ip',
  `useragent` text COMMENT 'useragent',
  `content` text COMMENT '请求内容',
  `errmsg` text COMMENT '异常信息',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `type` smallint(6) DEFAULT NULL COMMENT '类型',
  `times` int(11) DEFAULT NULL COMMENT '日期',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of nianbao_log
-- ----------------------------

-- ----------------------------
-- Table structure for nianbao_map
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_map`;
CREATE TABLE `nianbao_map` (
  `map_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` varchar(250) DEFAULT NULL COMMENT '标题',
  `bddt` text COMMENT '百度地图',
  `gddt` text COMMENT '高德地图',
  `txdt` text COMMENT '腾讯地图',
  PRIMARY KEY (`map_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of nianbao_map
-- ----------------------------
INSERT INTO `nianbao_map` VALUES ('1', '这是生成的地图组件', '{\"address\":\"武汉市武昌区梅园一路/梅园二路(路口)\",\"lng\":114.37015,\"lat\":30.540872}', '{\"address\":\"湖北省武汉市洪山区洪山街道保利中央公馆4期\",\"lng\":114.319124,\"lat\":30.494455}', '{\"address\":\"湖北省武汉市武昌区珞珈山16号武汉大学武汉大学-鉴湖\",\"lng\":114.363274,\"lat\":30.537601}');

-- ----------------------------
-- Table structure for nianbao_membe
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_membe`;
CREATE TABLE `nianbao_membe` (
  `membe_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `username` varchar(250) DEFAULT NULL COMMENT '用户名',
  `sex` smallint(6) DEFAULT NULL COMMENT '性别',
  `pic` varchar(250) DEFAULT NULL COMMENT '头像',
  `mobile` varchar(250) DEFAULT NULL COMMENT '手机号',
  `email` varchar(250) DEFAULT NULL COMMENT '邮箱',
  `password` varchar(250) DEFAULT NULL COMMENT '密码',
  `amount` decimal(10,2) DEFAULT NULL COMMENT '积分',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `ssq` varchar(250) DEFAULT NULL COMMENT '省市区',
  `tinymce` longtext COMMENT '编辑器',
  `tinymce2` longtext COMMENT '编辑器',
  PRIMARY KEY (`membe_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of nianbao_membe
-- ----------------------------
INSERT INTO `nianbao_membe` VALUES ('25', '韩梅梅', '1', 'http://vue.whpj.vip/uploads/admin/202105/60af8d8de9d0f.jpg', '13545028657', '274363574@qq.com', '978655f0ed9a6c3a33f104d64a2481a9', '22.00', '1', '1620211664', '山西省-大同市-城区', null, null);
INSERT INTO `nianbao_membe` VALUES ('26', '李磊', '2', 'http://vue.whpj.vip/uploads/admin/202105/60af8d85f101d.jpg', '13545098761', '36732767@qq.com', '', '99.00', '1', '1620211664', '山东省-青岛市-市南区', null, null);
INSERT INTO `nianbao_membe` VALUES ('27', '王五', '2', 'http://vue.whpj.vip/uploads/admin/202105/60af8d7d47a10.jpg', '13545098761', '36732767@qq.com', 'dfb32a9216356c14d12f162bfce8b35b', '102.00', '1', '1620211677', '山东省-青岛市-市南区', null, null);
INSERT INTO `nianbao_membe` VALUES ('28', '李四a', '2', 'http://vue.whpj.vip/uploads/admin/202105/60af8d752fe38.jpg', '13545028657', '274363574@qq.com', 'f588c178d94d0bd418ba8ddfbff84184', '20.00', '1', '1620211677', '山西省-大同市-城区', null, null);
INSERT INTO `nianbao_membe` VALUES ('29', '赵六', '1', 'http://vue.whpj.vip/uploads/admin/202105/60af9200b555c.jpg', '13545026847', '454512@qq.com', '6a5888d05ceb8033ebf0a3dfbf2b416e', '25.00', '1', '1633573323', '河北省-秦皇岛市-北戴河区', '<p>测试内容</p>', '<p>测试内容</p>');

-- ----------------------------
-- Table structure for nianbao_member
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_member`;
CREATE TABLE `nianbao_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL,
  `nickname` varchar(45) NOT NULL DEFAULT '',
  `avatar` varchar(255) NOT NULL DEFAULT '',
  `access_token` text,
  `mobile` varchar(255) NOT NULL DEFAULT '',
  `unionid` varchar(64) DEFAULT '',
  `is_perfect` tinyint(4) DEFAULT '0' COMMENT '是否完善信息',
  `create_time` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_time` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `openid` (`openid`(191)) USING BTREE,
  KEY `access_token` (`access_token`(128)) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of nianbao_member
-- ----------------------------

-- ----------------------------
-- Table structure for nianbao_member_enterprise
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_member_enterprise`;
CREATE TABLE `nianbao_member_enterprise` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `enterprise_id` int(11) DEFAULT NULL,
  `member_mobile` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of nianbao_member_enterprise
-- ----------------------------

-- ----------------------------
-- Table structure for nianbao_node
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_node`;
CREATE TABLE `nianbao_node` (
  `node_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL COMMENT '节点名称',
  `type` smallint(6) DEFAULT NULL COMMENT '类型',
  `path` varchar(250) DEFAULT NULL COMMENT '节点路径',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态',
  `icon` varchar(250) DEFAULT NULL COMMENT '图标',
  `pid` smallint(6) DEFAULT '0' COMMENT '所属父类',
  `sortid` int(11) DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`node_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of nianbao_node
-- ----------------------------
INSERT INTO `nianbao_node` VALUES ('22', '首页', '1', '/admin/Index/main.html', '1', 'el-icon-s-home', '0', '1');
INSERT INTO `nianbao_node` VALUES ('51', '配置管理', '1', '/admin/Baseconfig/index.html', '1', 'el-icon-s-data', null, '51');
INSERT INTO `nianbao_node` VALUES ('52', '基本配置', '1', '/admin/Baseconfig/index.html', '1', '', '51', '52');
INSERT INTO `nianbao_node` VALUES ('54', '节点管理', '1', '/admin/Node/index.html', '1', '', '55', '59');
INSERT INTO `nianbao_node` VALUES ('55', '系统管理', '1', '/admin/Sys', '1', 'el-icon-s-data', '0', '55');
INSERT INTO `nianbao_node` VALUES ('56', '用户管理', '1', '/admin/Adminuser/index.html', '1', '', '55', '56');
INSERT INTO `nianbao_node` VALUES ('57', '角色管理', '1', '/admin/Role/index.html', '1', '', '55', '57');
INSERT INTO `nianbao_node` VALUES ('58', '日志管理', '1', '/admin/Log/index.html', '1', '', '55', '58');
INSERT INTO `nianbao_node` VALUES ('70', '会员管理', '1', '/admin/Member/index.html', '1', 'el-icon-user-solid', '0', '2');
INSERT INTO `nianbao_node` VALUES ('71', '添加', '2', '/admin/Member/add.html', '1', '', '70', '1');
INSERT INTO `nianbao_node` VALUES ('72', '修改', '2', '/admin/Member/update.html', '1', '', '70', '2');
INSERT INTO `nianbao_node` VALUES ('73', '删除', '2', '/admin/Member/delete.html', '1', '', '70', '3');
INSERT INTO `nianbao_node` VALUES ('74', '获取修改信息', '2', '/admin/Member/getUpdateInfo.html', '1', '', '70', '4');
INSERT INTO `nianbao_node` VALUES ('75', '企业管理', '1', '/admin/Enterprise/index.html', '1', 'el-icon-office-building', '0', '3');
INSERT INTO `nianbao_node` VALUES ('76', '添加', '2', '/admin/Enterprise/add.html', '1', '', '75', '1');
INSERT INTO `nianbao_node` VALUES ('77', '修改', '2', '/admin/Enterprise/update.html', '1', '', '75', '2');
INSERT INTO `nianbao_node` VALUES ('78', '删除', '2', '/admin/Enterprise/delete.html', '1', '', '75', '3');
INSERT INTO `nianbao_node` VALUES ('79', '获取修改信息', '2', '/admin/Enterprise/getUpdateInfo.html', '1', '', '75', '4');
INSERT INTO `nianbao_node` VALUES ('80', '订单管理', '1', '/admin/Order/index.html', '1', 'el-icon-s-order', '0', '4');
INSERT INTO `nianbao_node` VALUES ('81', '一键发送短信提醒', '2', '/admin/Enterprise/send.html', '1', '', '75', '5');
INSERT INTO `nianbao_node` VALUES ('82', '导入', '2', '/admin/Enterprise/importData.html', '1', '', '75', '6');
INSERT INTO `nianbao_node` VALUES ('85', '申报', '2', '/admin/Order/declaration.html', '1', '', '80', '1');
INSERT INTO `nianbao_node` VALUES ('86', '退款', '2', '/admin/Order/refund.html', '1', '', '80', '2');
INSERT INTO `nianbao_node` VALUES ('87', '申报成功', '2', '/admin/Order/declaration_success.html', '1', '', '80', '3');
INSERT INTO `nianbao_node` VALUES ('88', '申报失败', '2', '/admin/Order/declaration_fail.html', '1', '', '80', '4');
INSERT INTO `nianbao_node` VALUES ('89', '年报状态', '2', '/admin/Report/index.html', '1', '', '75', '7');
INSERT INTO `nianbao_node` VALUES ('90', '商城管理', '1', '/admin/Shop/index.html', '1', 'el-icon-shopping-bag-2', '0', '5');
INSERT INTO `nianbao_node` VALUES ('91', '分类', '1', '/admin/Shoptype/index.html', '1', '', '90', '1');
INSERT INTO `nianbao_node` VALUES ('92', '商品列表', '1', '/admin/Shop/index.html', '1', 'el-icon-goods', '90', '2');

-- ----------------------------
-- Table structure for nianbao_order
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_order`;
CREATE TABLE `nianbao_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `enterprise_id` int(11) DEFAULT NULL,
  `pay_id` int(11) DEFAULT NULL COMMENT '支付id',
  `mobile` varchar(255) NOT NULL DEFAULT '' COMMENT '手机号',
  `title` varchar(255) DEFAULT NULL,
  `order_content` longtext COMMENT '订单内容',
  `idcard` varchar(255) DEFAULT NULL COMMENT '身份证号码',
  `fmobile` varchar(255) DEFAULT NULL COMMENT '法人手机号',
  `order_no` varchar(255) NOT NULL DEFAULT '' COMMENT '订单号',
  `sxfuuid` varchar(255) DEFAULT NULL COMMENT '随行付落单号',
  `out_trade_no` varchar(255) DEFAULT NULL COMMENT '悟能订单号',
  `out_refund_no` varchar(255) DEFAULT NULL COMMENT '悟能退款订单号',
  `enterprise_name` varchar(255) NOT NULL DEFAULT '' COMMENT '企业名称',
  `enterprise_code` varchar(255) DEFAULT '' COMMENT '企业代码',
  `legal_person` varchar(255) DEFAULT NULL COMMENT '法人姓名',
  `notes` text COMMENT '备注',
  `area_sheng` varchar(200) DEFAULT NULL COMMENT '省',
  `area_shi` varchar(200) DEFAULT NULL COMMENT '市',
  `area_qu` varchar(200) DEFAULT NULL COMMENT '区',
  `declaration_type` tinyint(4) DEFAULT '0' COMMENT '申报主体1是个人，2是企业，3是合作社',
  `total_price` decimal(10,2) NOT NULL COMMENT '订单总金额',
  `report_year` varchar(255) NOT NULL COMMENT '申报年份',
  `is_declaration` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否申报：0.待申报|1.已申报',
  `is_success` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否申报成功：1是成功|2.是失败',
  `pay_type` tinyint(4) NOT NULL COMMENT '支付方式：1.微信支付 2.随行付 3.悟能支付',
  `is_pay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支付：0.未支付|1.已支付',
  `is_user_tui` tinyint(4) DEFAULT '0' COMMENT '1是申请退款',
  `is_refund` varchar(4) DEFAULT '0' COMMENT '是否退款',
  `status` tinyint(4) DEFAULT '0' COMMENT '订单是否已完成 1是已完成',
  `refund_time` timestamp NULL DEFAULT NULL COMMENT '退款时间',
  `pay_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '支付时间',
  `create_time` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_time` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of nianbao_order
-- ----------------------------

-- ----------------------------
-- Table structure for nianbao_other
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_other`;
CREATE TABLE `nianbao_other` (
  `other_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` varchar(250) DEFAULT NULL COMMENT '标题',
  `jsq` varchar(250) DEFAULT NULL COMMENT '计数器',
  `tags` varchar(250) DEFAULT NULL COMMENT '标签',
  `hk` smallint(6) DEFAULT NULL COMMENT '滑块',
  `color` varchar(250) DEFAULT NULL COMMENT '颜色选择器',
  `jzd` text COMMENT '键值对',
  `ssq` varchar(250) DEFAULT NULL COMMENT '省市区联动',
  `rate` smallint(6) DEFAULT NULL COMMENT '评分',
  PRIMARY KEY (`other_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of nianbao_other
-- ----------------------------
INSERT INTO `nianbao_other` VALUES ('1', '生成的常用组件测试', '11', 'xhadmin,快速开发', '14', '#141313', '[{\"key\":\"A\",\"val\":\"中国\"},{\"key\":\"B\",\"val\":\"法国\"}]', '河北省-石家庄市-长安区', '4');
INSERT INTO `nianbao_other` VALUES ('2', '测试西悉尼', '11', 'xhadmin,xhcms,vue', '28', '#EB0707', '[{\"key\":\"A\",\"val\":\"中国\"},{\"key\":\"B\",\"val\":\"发过\"},{\"key\":\"C\",\"val\":\"德国\"}]', '天津市-市辖区-和平区', '5');
INSERT INTO `nianbao_other` VALUES ('4', '测试', '11', 'vue,git', '11', '#744242', '[{\"key\":\"A\",\"val\":\"测试\"}]', '天津市-市辖区-河西区', '1');
INSERT INTO `nianbao_other` VALUES ('5', '地方的', '100', 'heyingm ', '44', '#4F92BC', '[{\"key\":\"A\",\"val\":\"中国\"},{\"key\":\"B\",\"val\":\"美国\"},{\"key\":\"C\",\"val\":\"德国\"}]', '山西省-阳泉市-郊区', '3');

-- ----------------------------
-- Table structure for nianbao_pay
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_pay`;
CREATE TABLE `nianbao_pay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) DEFAULT '1' COMMENT '1是微信2是随行付3是悟能支付',
  `mch_id` varchar(255) DEFAULT NULL COMMENT '微信商户号',
  `pay_secretkey` varchar(255) DEFAULT NULL COMMENT '微信支付秘钥',
  `cert_path` varchar(255) DEFAULT NULL COMMENT '微信Cert证书',
  `key_path` varchar(255) DEFAULT NULL COMMENT '微信Key证书',
  `orgid` varchar(255) DEFAULT NULL COMMENT '随行付机构号',
  `mno` varchar(255) DEFAULT NULL COMMENT '随行付商户编号',
  `privatekey` text COMMENT '随行付私钥',
  `sxfpublic` text COMMENT '随行付公钥',
  `merchantno` varchar(255) DEFAULT NULL COMMENT '门店编号',
  `sign_appkey` varchar(255) DEFAULT NULL COMMENT 'key',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of nianbao_pay
-- ----------------------------

-- ----------------------------
-- Table structure for nianbao_remarks
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_remarks`;
CREATE TABLE `nianbao_remarks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `remarks_content` longtext NOT NULL,
  `remarks_people` varchar(255) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of nianbao_remarks
-- ----------------------------

-- ----------------------------
-- Table structure for nianbao_role
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_role`;
CREATE TABLE `nianbao_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(36) DEFAULT NULL COMMENT '分组名称',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态',
  `pid` smallint(6) DEFAULT NULL COMMENT '所属父类',
  `description` text COMMENT '描述',
  `access` longtext COMMENT '权限节点',
  PRIMARY KEY (`role_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of nianbao_role
-- ----------------------------
INSERT INTO `nianbao_role` VALUES ('1', '超级管理员', '1', '0', '超级管理员', '');
INSERT INTO `nianbao_role` VALUES ('52', '普通管理员', '1', null, '', '/admin/Index/main.html,/admin/Member/index.html,/admin/Enterprise/index.html,/admin/Order/index.html,/admin/Config,/admin/Baseconfig/index.html,Home');

-- ----------------------------
-- Table structure for nianbao_secrect
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_secrect`;
CREATE TABLE `nianbao_secrect` (
  `secrect_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(50) NOT NULL,
  `data` text NOT NULL,
  `appid` varchar(250) DEFAULT NULL COMMENT 'appid',
  PRIMARY KEY (`secrect_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of nianbao_secrect
-- ----------------------------
INSERT INTO `nianbao_secrect` VALUES ('1', 'appid', 'HbUX4SClpbJv1', null);
INSERT INTO `nianbao_secrect` VALUES ('2', 'secrect', 'OnLQ00vgWXzqohNc7Y2y', null);

-- ----------------------------
-- Table structure for nianbao_shop
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_shop`;
CREATE TABLE `nianbao_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_name` varchar(250) DEFAULT NULL COMMENT '商品名称',
  `subtitle` varchar(255) DEFAULT NULL COMMENT '副标题',
  `class_id` smallint(6) DEFAULT NULL COMMENT '所属分类',
  `pic` varchar(250) DEFAULT NULL COMMENT '封面图',
  `sale_price` decimal(10,2) DEFAULT NULL COMMENT '销售价',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态',
  `sortid` int(11) DEFAULT NULL COMMENT '排序',
  `create_time` int(11) DEFAULT NULL COMMENT '发布时间',
  `detail` text COMMENT '内容详情',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of nianbao_shop
-- ----------------------------
INSERT INTO `nianbao_shop` VALUES ('3', '代办服务', '办理经营证(餐饮类))，具体价办理经营证(餐饮类))，具体价', '3', 'https://nianbao.2751.cn/uploads/admin/202403/6603e659725bf.png', '5000.00', '1', '2', '1693630671', '');

-- ----------------------------
-- Table structure for nianbao_shop_type
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_shop_type`;
CREATE TABLE `nianbao_shop_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `class_name` varchar(250) DEFAULT NULL COMMENT '分类名称',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态',
  `sortid` int(11) DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of nianbao_shop_type
-- ----------------------------
INSERT INTO `nianbao_shop_type` VALUES ('1', '代账服务', '1', '1');
INSERT INTO `nianbao_shop_type` VALUES ('2', '超值套餐', '1', '2');
INSERT INTO `nianbao_shop_type` VALUES ('3', '工商服务', '1', '3');
INSERT INTO `nianbao_shop_type` VALUES ('4', '税务办理', '1', '4');
INSERT INTO `nianbao_shop_type` VALUES ('5', '人事业务', '1', '5');
INSERT INTO `nianbao_shop_type` VALUES ('6', '人事外勤', '1', '6');
INSERT INTO `nianbao_shop_type` VALUES ('7', '资质业务', '1', '7');
INSERT INTO `nianbao_shop_type` VALUES ('8', '商标业务', '1', '8');
INSERT INTO `nianbao_shop_type` VALUES ('9', '版权专利', '1', '9');
INSERT INTO `nianbao_shop_type` VALUES ('10', '高端财税', '1', '10');
INSERT INTO `nianbao_shop_type` VALUES ('11', '审计申报', '1', '11');

-- ----------------------------
-- Table structure for nianbao_supplier
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_supplier`;
CREATE TABLE `nianbao_supplier` (
  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(250) DEFAULT NULL COMMENT '供应商名称',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `username` varchar(250) DEFAULT NULL COMMENT '用户名',
  `password` varchar(250) DEFAULT NULL COMMENT '密码',
  PRIMARY KEY (`supplier_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of nianbao_supplier
-- ----------------------------
INSERT INTO `nianbao_supplier` VALUES ('1', '仟吉', '1', '1622120604', 'qianji', '7b2ad4e307d5b3ec9e786054225d0985');
INSERT INTO `nianbao_supplier` VALUES ('2', '周黑鸭', '1', '1622120611', 'zhouheiya', '7b2ad4e307d5b3ec9e786054225d0985');
INSERT INTO `nianbao_supplier` VALUES ('3', '皇冠蛋糕', '1', '1622120618', 'huangguan', '7b2ad4e307d5b3ec9e786054225d0985');
INSERT INTO `nianbao_supplier` VALUES ('4', '精武鸭脖', '1', '1622120630', 'jingwu', '7b2ad4e307d5b3ec9e786054225d0985');

-- ----------------------------
-- Table structure for nianbao_uploadfile
-- ----------------------------
DROP TABLE IF EXISTS `nianbao_uploadfile`;
CREATE TABLE `nianbao_uploadfile` (
  `uploadfile_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` varchar(250) DEFAULT NULL COMMENT '标题',
  `pic` varchar(250) DEFAULT NULL COMMENT '单图上传',
  `pic_2` varchar(250) DEFAULT NULL COMMENT '单图2',
  `pics` text COMMENT '多图上传',
  `file` varchar(250) DEFAULT NULL COMMENT '单文件',
  `files` text COMMENT '多文件',
  PRIMARY KEY (`uploadfile_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of nianbao_uploadfile
-- ----------------------------
INSERT INTO `nianbao_uploadfile` VALUES ('1', '这是系统生成的上传组件测试', 'http://vue.whpj.vip/uploads/admin/202105/60af91ed8763f.jpg', 'http://vue.whpj.vip/uploads/admin/202105/60af9200b555c.jpg', '[{\"url\":\"http:\\/\\/vue.whpj.vip\\/uploads\\/admin\\/202105\\/60af8d8de9d0f.jpg\",\"name\":\"60af8d8de9d0f.jpg\"},{\"url\":\"http:\\/\\/vue.whpj.vip\\/uploads\\/admin\\/202105\\/60af8d752fe38.jpg\",\"name\":\"60af8d752fe38.jpg\"},{\"url\":\"http:\\/\\/vue.whpj.vip\\/uploads\\/admin\\/202105\\/60af8d85f101d.jpg\",\"name\":\"60af8d85f101d.jpg\"}]', '/uploads/admin/202104/607e911312e48.jpg', '[{\"url\":\"http:\\/\\/zhangling.me\\/uploads\\/admin\\/202104\\/607e91189159c.jpg\",\"name\":\"607e910dc5e7b.jpg\"},{\"url\":\"http:\\/\\/zhangling.me\\/uploads\\/admin\\/202104\\/607e911896d47.jpg\",\"name\":\"607e9106a0212.jpg\"}]');
