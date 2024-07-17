-- MySQL dump 10.13  Distrib 5.7.42, for Linux (x86_64)
--
-- Host: localhost    Database: 01_xyaa_vip
-- ------------------------------------------------------
-- Server version	5.7.42-log

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
-- Table structure for table `nianbao_admin_user`
--

DROP TABLE IF EXISTS `nianbao_admin_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nianbao_admin_user`
--

LOCK TABLES `nianbao_admin_user` WRITE;
/*!40000 ALTER TABLE `nianbao_admin_user` DISABLE KEYS */;
INSERT INTO `nianbao_admin_user` VALUES (1,'超级管理员','admin','3c1567f3614661076dde95e296df4f9a',1,'超级管理员',1,1548558919),(35,'123456','123456','7b2ad4e307d5b3ec9e786054225d0985',53,'123456',0,1699700519);
/*!40000 ALTER TABLE `nianbao_admin_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nianbao_area`
--

DROP TABLE IF EXISTS `nianbao_area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nianbao_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area_sheng` varchar(255) DEFAULT NULL COMMENT '省',
  `area_shi` varchar(255) DEFAULT NULL COMMENT '市',
  `area_qu` varchar(255) DEFAULT NULL COMMENT '区',
  `area_price` decimal(10,2) DEFAULT '0.00',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nianbao_area`
--

LOCK TABLES `nianbao_area` WRITE;
/*!40000 ALTER TABLE `nianbao_area` DISABLE KEYS */;
/*!40000 ALTER TABLE `nianbao_area` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nianbao_base_config`
--

DROP TABLE IF EXISTS `nianbao_base_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nianbao_base_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(50) NOT NULL,
  `data` text,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nianbao_base_config`
--

LOCK TABLES `nianbao_base_config` WRITE;
/*!40000 ALTER TABLE `nianbao_base_config` DISABLE KEYS */;
INSERT INTO `nianbao_base_config` VALUES (1,'site_title','个体年报'),(2,'logo','https://tieie.xyaa.vip/uploads/admin/202404/660ea2f989956.jpg'),(3,'keyword',''),(4,'descrip','企业年报'),(5,'copyright','版权'),(6,'filesize','100'),(7,'filetype','gif,png,jpg,jpeg,doc,docx,xls,xlsx,csv,pdf,rar,zip,txt,mp4,flv,wgt,pem'),(8,'water_status','0'),(9,'water_position','5'),(10,'domain','https://01.xyaa.vip'),(20,'water_alpha','90'),(21,'appsecret','11'),(22,'appid','111'),(23,'db_img',''),(24,'wxlogo','https://tieie.xyaa.vip/uploads/admin/202404/660ea2f989956.jpg'),(25,'agreement_title','用户协议'),(26,'privacy_content','<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp; 以下简称&ldquo;年报通&rdquo;。确保用户的数据安全和隐私保护是我们的首要任务，本隐私政策载明了您访问和使用我们的产品和服务时所收集的数据及其处理方式。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;请您在继续使用我们的产品前务必认真仔细阅读并确认充分理解本隐私政策全部规则和要点，一旦您选择使用，即视为您同意本隐私政策的全部内容，同意我们按其收集和使用您的相关信息。如您在在阅读过程中对本政策有任何疑问，可联系我们的客服咨询，请通过年报通中的在线客服与我们取得联系。如您不同意相关协议或其中的任何条款的，您应停止使用我们的产品和服务。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 本隐私政策帮助您了解以下内容：</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 一、我们如何收集和使用您的个人信息；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 二、我们如何存储和保护您的个人信息；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 三、我们如何共享、转让、公开披露您的个人信息；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 一、我们如何收集和使用您的个人信息</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 个人信息是指以电子或者其他方式记录的能够单独或者与其他信息，结合识别特定自然人身份或者反映特定自然人活动情况的各种信息。我们根据《中华人民共和国网络安全法》和《信息安全技术个人信息安全规范》(GB/T35273-2017)以及其它相关法律法规的要求，并严格遵循正当、合法、必要的原则，出于您使用我们提供的服务和/或产品等过程中而收集和使用您的个人信息，包括但不限于电话号码等。在怒初次使用本系统时，需要您提供手机号进行登录。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;二、我们如何存储和保护您的个人信息</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;作为一般规则，我们仅在实现信息收集目的所需的时间内保留您的个人信息。我们会在对于管理与您之间的关系严格必要的时间内保留您的人信息。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;当您的个人信息对于我们的法定义务或法定时效对应的目的或档案不再必要时，我们确保将其完全删除或匿名化。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;我们使用符合业界标准的安全防护措施保护您提供的个人信息，并加密其中的关键数据，防止其遭到未经授权访问、公开披露、使用、修改、损坏或丢失。我们会采取一切合理可行的措施，保护您的个人信息。我们会使用加密技术确保数据的保密性;我们会使用受信赖的保护机制防止数据遭到恶意攻击。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;为了加强对隐私数据的保护，我们在收集时就已对其进行了脱敏处理，即使在我们自己的数据库中，也不会储存具有关联性的、明文的隐私数据。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;三、我们如何共享、转让、公开披露您的个人信息在管理我们的日常业务活动所需要时，为追求合法利益以更好地服务客户，我们将合规且恰当的使用您的个人信息。我们不会主动共享或转让你的信息至任何第三方，如存在确需共享或转让时，开发者应当直接征得或确认第三方征得你的单独同意开发者承诺，不会对外公开披露你的信息，如必须公开披露时，我们会向你告知公开披露的目的、披露信息的类型及可能涉及的信息，并征得你的单独同意。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;在以下情形中，共享、转让、公开披露您的个人信息无需事先征得您的授权同意</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;1、与国家安全、国防安全直接相关的；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;2、与犯罪侦查、起诉、审判和判决执行等直接相关的；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;3、出于维护您或其他个人的生命、财产等重大合法权益但又很难得到本人同意的；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;4、您自行向社会公众公开的个人信息；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;5、从合法公开披露的信息中收集个人信息的，如合法的新闻报道、政府信息公开等渠道的;</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;6、根据个人信息主体要求签订和履行合同所必需的；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;7、用于维护所提供的产品或服务的安全稳定运行所必需的，例如发现、处置产品或服务的故障；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;8、法律法规规定的其他情形。若你认为开发者未遵守上述约定，或有其他的投诉建议、或未成年人个人信息保护相关问题，可通过以下方式与开发者联系;或者向微信进行投诉。</span></p>'),(27,'agreement_content','<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp;以下简称&ldquo;本平台&rdquo;，为经营主体提供年报代报、经营异常移出等业务。本平台属于第三方征信机构，为付费用户提供相关代办服务。本协议仅对付费用户与我司就办理代办年报报送、经营异常移出等事宜所签署的具有法律约束力的文件。您已充分阅读、理解并接受本协议的全部内容，知悉支付费用即表示您委托我司全权为您办理年报报送或经营异常移出事宜，我司将通过网络在线方式为您提供代办服务。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp; 一、您知悉，按照《企业信息公示暂行条例》《个体工商户年度报告暂行办法》等法规文件，报送年报是您的法定义务。您也知悉，通过市场监督管理部门渠道报送年报、移除经营异常是免费的，通过我司代办业务您需向我司支付代报费用。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp; 二、您知悉，为办理业务之必要，您需要向我司提供包括但不限于法定代表人或负责人身份证、手机号经营状况等资料，您应当保证资料的真实性、完整性合法性。我司将根据您的委托，按照管辖地市场监督管理部门的规定，及时为您办理相关业务</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp; 三、在您提交相关资料后，我司将在15个工作日完成代办工作，如在15个工作日内未能办结的，我司将根据您的要求或者继续办理或者全额退款。要求退款的我司将在之后5个工作日内完成:要求继续办理的，您将不追究我司在承诺时间内未能办结的任何责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp; 四、年报报送成功或经营异常移出成功或我司向您全额退款即意味着您与我司委托代理关系终止，本协议亦随即终止。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp; 五、我司受理您的委托后，将忠实履行代理义务。如您在业务办理过程中有任何异议，均可通过本协议第八条联系方式向我司反映，我司将及时进行处理。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp; 六、针对为完成年报报送您所提交的资料(见本协议第三条)，您知晓并同意按以下方式处理: 1、凡业务办理成功的，您所提交的资料将保存至下一年度的年报报送截止日，但您选择&ldquo;不公开&rdquo;的内容我司将不做保存;2、业务未办理成功或您要求终止委托关系而全额退款的，我司仅保存您的联系方式(含手机号)，其他资料不做保存: 3、凡我司保存的资料，我司将采取严格的保密措施，未经您同意，不公开、不向任何第三方提供，所保存的联系方式也仅用于与您本人联系。 4因我司违背上述约定而引发的一切后果由我司承担。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 七、我司为您提供人工电话服务;您可通过该电话咨询业务、了解进程、反映问题、进行投诉等。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 八、如我司未违背本协议约定，您不得向任何第三方发布、提供有损我司利益、名誉的信息，否则我司有权追究您的法律责任</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 九、如您与我司就本协议内容或其执行发生任何争议，双方应尽力友好协商解决;协商不成时，应向协议签订地有管辖权的人民法院提起诉讼。</span></p>'),(28,'privacy_title','年报通隐私政策'),(29,'wxtitle','首页'),(30,'specialfee','298'),(31,'normalfee','298'),(32,'submitted_title','代理报送年报服务协议'),(33,'normal_content','<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;一、本协议将成为您与我司就办理年报报送事宜所签署的具有法律约束力的文件。您已充分阅读、理解并接受本协议的全部内容，知悉支付年报代报费用即表示您委托我司全权为您办理年报报送事宜，我司将通过网络在线方式为您提供年报代报服务</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;二、您知悉，按照《企业信息公示暂行条例》《个体工商户年度报告暂行办法》等法规文件，报送年报是您的法定义务。您也知悉，通过市场监督管理部门渠道报送年报是免费的，通过我司代办年报报送您需向我司支付200元代报费用。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;三、您知悉，为办理年报报送之必要，您需要向我司提供包括但不限于法定代表人或负责人身份证、手机号、经营状况等资料，您应当保证资料的真实性、完整性、合法性。我司将根据您的委托，按照管辖地市场监督管理部门的规定，及时为您办理年报报送的相关事宜。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;四、在您提交年报报送资料后，我司将在15个工作日完成年报报送工作，报送成功的标志是您的年报信息在&ldquo;全国企业信用信息公示系统&rdquo;中公示或在辖区市场监管部门网站公示。如在15个工作日内未能办结的，我司将根据您的要求或者继续办理或者全额退款。要求退款的，我司将在之后5个工作日内完成;要求继续办理的，您将不追究我司在承诺时间内未能办结的任何责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;五、年报报送成功或我司向您全额退款即意味着您与我司委托代理关系终止，本协议亦随即终止。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;六、因年报的报送截止日期为每年的6月30日，故我司原则上不再受理6月20日以后的委托。如您仍选择委托我司办理年报代报的，则意味着您自愿承担在6月30日之前报送不成功的风险，届时因未在截止时间前报送成功所产生的一切法律后果(包括但不限于经营异常、行政处罚等)由您自行承担，我司不因此承担任何责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;七、我司受理您的年报报送委托后，将忠实履行代理义务。如您在年报代报过程中有任何异议，均可通过本协议第九条联系方式向我司反映，我司将及时进行处理。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;八、针对为完成年报报送您所提交的资料(见本协议第三条)，您知晓并同意按以下方式处理：</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;1、凡报送成功的，您所提交的资料将保存至下一年度的年报报送截止日，但您选择&ldquo;不公开&rdquo;的内容我司将不做保存；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;2、已提交年报资料但报送未成功或您要求终止委托关系而全额退款的，我司仅保存您的联系方式(含手机号)，其他资料不做保存；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;3、凡我司保存的资料，我司将采取严格的保密措施，未经您同意，不公开、不向任何第三方提供，所保存的联系方式也仅用于与您本人联系。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;4、因我司违背上述约定而引发的一切后果由我司承担。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;九、我司为您提供人工电话服务;您可通过该电话咨询业务、了解进程、反映问题、进行投诉等。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;十、如我司未违背本协议约定，您不得向任何第三方发布、提供有损我司利益、名誉的信息，否则我司有权追究您的法律责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;十一、如您与我司就本协议内容或其执行发生任何争议，双方应尽力友好协商解决:协商不成时，应向协议签订地有管辖权的人民法院提起诉讼。</span></p>'),(34,'special_content','<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;一、本协议将成为您与我司就办理年报报送事宜所签署的具有法律约束力的文件。您已充分阅读、理解并接受本协议的全部内容，知悉支付年报代报费用即表示您委托我司全权为您办理年报报送事宜，我司将通过网络在线方式为您提供年报代报服务</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;二、您知悉，按照《企业信息公示暂行条例》《个体工商户年度报告暂行办法》等法规文件，报送年报是您的法定义务。您也知悉，通过市场监督管理部门渠道报送年报是免费的，通过我司代办年报报送您需向我司支付298元代报费用。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;三、您知悉，为办理年报报送之必要，您需要向我司提供包括但不限于法定代表人或负责人身份证、手机号、经营状况等资料，您应当保证资料的真实性、完整性、合法性。我司将根据您的委托，按照管辖地市场监督管理部门的规定，及时为您办理年报报送的相关事宜。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;四、在您提交年报报送资料后，我司将在15个工作日完成年报报送工作，报送成功的标志是您的年报信息在&ldquo;全国企业信用信息公示系统&rdquo;中公示或在辖区市场监管部门网站公示。如在15个工作日内未能办结的，我司将根据您的要求或者继续办理或者全额退款。要求退款的，我司将在之后5个工作日内完成;要求继续办理的，您将不追究我司在承诺时间内未能办结的任何责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;五、年报报送成功或我司向您全额退款即意味着您与我司委托代理关系终止，本协议亦随即终止。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;六、因年报的报送截止日期为每年的6月30日，故我司原则上不再受理6月20日以后的委托。如您仍选择委托我司办理年报代报的，则意味着您自愿承担在6月30日之前报送不成功的风险，届时因未在截止时间前报送成功所产生的一切法律后果(包括但不限于经营异常、行政处罚等)由您自行承担，我司不因此承担任何责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;七、我司受理您的年报报送委托后，将忠实履行代理义务。如您在年报代报过程中有任何异议，均可通过本协议第九条联系方式向我司反映，我司将及时进行处理。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;八、针对为完成年报报送您所提交的资料(见本协议第三条)，您知晓并同意按以下方式处理：</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;1、凡报送成功的，您所提交的资料将保存至下一年度的年报报送截止日，但您选择&ldquo;不公开&rdquo;的内容我司将不做保存；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;2、已提交年报资料但报送未成功或您要求终止委托关系而全额退款的，我司仅保存您的联系方式(含手机号)，其他资料不做保存；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;3、凡我司保存的资料，我司将采取严格的保密措施，未经您同意，不公开、不向任何第三方提供，所保存的联系方式也仅用于与您本人联系。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;4、因我司违背上述约定而引发的一切后果由我司承担。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;九、我司为您提供人工电话服务;您可通过该电话咨询业务、了解进程、反映问题、进行投诉等。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;十、如我司未违背本协议约定，您不得向任何第三方发布、提供有损我司利益、名誉的信息，否则我司有权追究您的法律责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;十一、如您与我司就本协议内容或其执行发生任何争议，双方应尽力友好协商解决:协商不成时，应向协议签订地有管辖权的人民法院提起诉讼。</span></p>'),(35,'service_telephone','15615626156'),(36,'key',''),(37,'secretkey',''),(38,'type','1'),(39,'mch_id','1624596206'),(40,'pay_secretkey','zccccccccccccccccccccccccccccccc'),(41,'orgid',''),(42,'mno',''),(43,'privatekey',''),(44,'sxfpublic',''),(45,'topleft_logo','https://tieie.xyaa.vip/uploads/admin/202404/660ea305af4e9.png'),(46,'topright_logo','https://tieie.xyaa.vip/uploads/admin/202404/660ea307e6c5a.png'),(47,'specialprompt','为经营主体提供年报代报服务的平台代报服务费200元，如办理不成功全额退款。'),(48,'normalprompt','为经营主体提供年报代报服务的平台代报服务费298元，如办理不成功全额退款。'),(49,'bottom_copyright','鲁ICP备2023023028号-1'),(50,'article_link',''),(51,'top_word','本平台提供年报代办服务，方便快捷，如办理不成功可全额退款。'),(52,'cert_path',''),(53,'key_path',''),(54,'hy_apiid',''),(55,'hy_apikey',''),(56,'hy_type','1'),(57,'shoptop_logo',''),(58,'agreementcontent','<p>48阿达</p>'),(59,'is_mo','1'),(60,'mo_tongyi_content','<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;一、本协议将成为您与我司就办理年报报送事宜所签署的具有法律约束力的文件。您已充分阅读、理解并接受本协议的全部内容，知悉支付年报代报费用即表示您委托我司全权为您办理年报报送事宜，我司将通过网络在线方式为您提供年报代报服务</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;二、您知悉，按照《企业信息公示暂行条例》《个体工商户年度报告暂行办法》等法规文件，报送年报是您的法定义务。您也知悉，通过市场监督管理部门渠道报送年报是免费的，通过我司代办年报报送您需向我司支付代报费用。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;三、您知悉，为办理年报报送之必要，您需要向我司提供包括但不限于法定代表人或负责人身份证、手机号、经营状况等资料，您应当保证资料的真实性、完整性、合法性。我司将根据您的委托，按照管辖地市场监督管理部门的规定，及时为您办理年报报送的相关事宜。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;四、在您提交年报报送资料后，我司将在15个工作日完成年报报送工作，报送成功的标志是您的年报信息在&ldquo;全国企业信用信息公示系统&rdquo;中公示或在辖区市场监管部门网站公示。如在15个工作日内未能办结的，我司将根据您的要求或者继续办理或者全额退款。要求退款的，我司将在之后5个工作日内完成;要求继续办理的，您将不追究我司在承诺时间内未能办结的任何责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;五、年报报送成功或我司向您全额退款即意味着您与我司委托代理关系终止，本协议亦随即终止。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;六、因年报的报送截止日期为每年的6月30日，故我司原则上不再受理6月20日以后的委托。如您仍选择委托我司办理年报代报的，则意味着您自愿承担在6月30日之前报送不成功的风险，届时因未在截止时间前报送成功所产生的一切法律后果(包括但不限于经营异常、行政处罚等)由您自行承担，我司不因此承担任何责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;七、我司受理您的年报报送委托后，将忠实履行代理义务。如您在年报代报过程中有任何异议，均可通过本协议第九条联系方式向我司反映，我司将及时进行处理。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;八、针对为完成年报报送您所提交的资料(见本协议第三条)，您知晓并同意按以下方式处理：</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;1、凡报送成功的，您所提交的资料将保存至下一年度的年报报送截止日，但您选择&ldquo;不公开&rdquo;的内容我司将不做保存；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;2、已提交年报资料但报送未成功或您要求终止委托关系而全额退款的，我司仅保存您的联系方式(含手机号)，其他资料不做保存；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;3、凡我司保存的资料，我司将采取严格的保密措施，未经您同意，不公开、不向任何第三方提供，所保存的联系方式也仅用于与您本人联系。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;4、因我司违背上述约定而引发的一切后果由我司承担。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;九、我司为您提供人工电话服务;您可通过该电话咨询业务、了解进程、反映问题、进行投诉等。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;十、如我司未违背本协议约定，您不得向任何第三方发布、提供有损我司利益、名誉的信息，否则我司有权追究您的法律责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;十一、如您与我司就本协议内容或其执行发生任何争议，双方应尽力友好协商解决:协商不成时，应向协议签订地有管辖权的人民法院提起诉讼。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp;以下简称&ldquo;本平台&rdquo;，为经营主体提供年报代报、经营异常移出等业务。本平台属于第三方征信机构，为付费用户提供相关代办服务。本协议仅对付费用户与我司就办理代办年报报送、经营异常移出等事宜所签署的具有法律约束力的文件。您已充分阅读、理解并接受本协议的全部内容，知悉支付费用即表示您委托我司全权为您办理年报报送或经营异常移出事宜，我司将通过网络在线方式为您提供代办服务。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp; 一、您知悉，按照《企业信息公示暂行条例》《个体工商户年度报告暂行办法》等法规文件，报送年报是您的法定义务。您也知悉，通过市场监督管理部门渠道报送年报、移除经营异常是免费的，通过我司代办业务您需向我司支付代报费用。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp; 二、您知悉，为办理业务之必要，您需要向我司提供包括但不限于法定代表人或负责人身份证、手机号经营状况等资料，您应当保证资料的真实性、完整性合法性。我司将根据您的委托，按照管辖地市场监督管理部门的规定，及时为您办理相关业务</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp; 三、在您提交相关资料后，我司将在15个工作日完成代办工作，如在15个工作日内未能办结的，我司将根据您的要求或者继续办理或者全额退款。要求退款的我司将在之后5个工作日内完成:要求继续办理的，您将不追究我司在承诺时间内未能办结的任何责任。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp; 四、年报报送成功或经营异常移出成功或我司向您全额退款即意味着您与我司委托代理关系终止，本协议亦随即终止。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp; 五、我司受理您的委托后，将忠实履行代理义务。如您在业务办理过程中有任何异议，均可通过本协议第八条联系方式向我司反映，我司将及时进行处理。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp; 六、针对为完成年报报送您所提交的资料(见本协议第三条)，您知晓并同意按以下方式处理: 1、凡业务办理成功的，您所提交的资料将保存至下一年度的年报报送截止日，但您选择&ldquo;不公开&rdquo;的内容我司将不做保存;2、业务未办理成功或您要求终止委托关系而全额退款的，我司仅保存您的联系方式(含手机号)，其他资料不做保存: 3、凡我司保存的资料，我司将采取严格的保密措施，未经您同意，不公开、不向任何第三方提供，所保存的联系方式也仅用于与您本人联系。 4因我司违背上述约定而引发的一切后果由我司承担。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 七、我司为您提供人工电话服务;您可通过该电话咨询业务、了解进程、反映问题、进行投诉等。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 八、如我司未违背本协议约定，您不得向任何第三方发布、提供有损我司利益、名誉的信息，否则我司有权追究您的法律责任</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 九、如您与我司就本协议内容或其执行发生任何争议，双方应尽力友好协商解决;协商不成时，应向协议签订地有管辖权的人民法院提起诉讼。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\"> 以下简称&ldquo;年报通&rdquo;。确保用户的数据安全和隐私保护是我们的首要任务，本隐私政策载明了您访问和使用我们的产品和服务时所收集的数据及其处理方式。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;请您在继续使用我们的产品前务必认真仔细阅读并确认充分理解本隐私政策全部规则和要点，一旦您选择使用，即视为您同意本隐私政策的全部内容，同意我们按其收集和使用您的相关信息。如您在在阅读过程中对本政策有任何疑问，可联系我们的客服咨询，请通过年报通中的在线客服与我们取得联系。如您不同意相关协议或其中的任何条款的，您应停止使用我们的产品和服务。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 本隐私政策帮助您了解以下内容：</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 一、我们如何收集和使用您的个人信息；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 二、我们如何存储和保护您的个人信息；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 三、我们如何共享、转让、公开披露您的个人信息；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 一、我们如何收集和使用您的个人信息</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; 个人信息是指以电子或者其他方式记录的能够单独或者与其他信息，结合识别特定自然人身份或者反映特定自然人活动情况的各种信息。我们根据《中华人民共和国网络安全法》和《信息安全技术个人信息安全规范》(GB/T35273-2017)以及其它相关法律法规的要求，并严格遵循正当、合法、必要的原则，出于您使用我们提供的服务和/或产品等过程中而收集和使用您的个人信息，包括但不限于电话号码等。在怒初次使用本系统时，需要您提供手机号进行登录。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;二、我们如何存储和保护您的个人信息</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;作为一般规则，我们仅在实现信息收集目的所需的时间内保留您的个人信息。我们会在对于管理与您之间的关系严格必要的时间内保留您的人信息。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;当您的个人信息对于我们的法定义务或法定时效对应的目的或档案不再必要时，我们确保将其完全删除或匿名化。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;我们使用符合业界标准的安全防护措施保护您提供的个人信息，并加密其中的关键数据，防止其遭到未经授权访问、公开披露、使用、修改、损坏或丢失。我们会采取一切合理可行的措施，保护您的个人信息。我们会使用加密技术确保数据的保密性;我们会使用受信赖的保护机制防止数据遭到恶意攻击。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;为了加强对隐私数据的保护，我们在收集时就已对其进行了脱敏处理，即使在我们自己的数据库中，也不会储存具有关联性的、明文的隐私数据。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;三、我们如何共享、转让、公开披露您的个人信息在管理我们的日常业务活动所需要时，为追求合法利益以更好地服务客户，我们将合规且恰当的使用您的个人信息。我们不会主动共享或转让你的信息至任何第三方，如存在确需共享或转让时，开发者应当直接征得或确认第三方征得你的单独同意开发者承诺，不会对外公开披露你的信息，如必须公开披露时，我们会向你告知公开披露的目的、披露信息的类型及可能涉及的信息，并征得你的单独同意。</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;在以下情形中，共享、转让、公开披露您的个人信息无需事先征得您的授权同意</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;1、与国家安全、国防安全直接相关的；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;2、与犯罪侦查、起诉、审判和判决执行等直接相关的；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;3、出于维护您或其他个人的生命、财产等重大合法权益但又很难得到本人同意的；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;4、您自行向社会公众公开的个人信息；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;5、从合法公开披露的信息中收集个人信息的，如合法的新闻报道、政府信息公开等渠道的;</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;6、根据个人信息主体要求签订和履行合同所必需的；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;7、用于维护所提供的产品或服务的安全稳定运行所必需的，例如发现、处置产品或服务的故障；</span></p>\n<p><span style=\"color: rgb(128, 128, 128);\">&nbsp; &nbsp; &nbsp; &nbsp;8、法律法规规定的其他情形。若你认为开发者未遵守上述约定，或有其他的投诉建议、或未成年人个人信息保护相关问题，可通过以下方式与开发者联系;或者向微信进行投诉。</span></p>'),(61,'ycpic','https://tieie.xyaa.vip/uploads/admin/202404/660ea3011146f.png'),(62,'qypic','https://tieie.xyaa.vip/uploads/admin/202404/660ea302af1e9.png'),(63,'noareafee','698'),(64,'mo_submitted_title','年报代报送协议'),(65,'is_qiang','0'),(66,'is_yc','1'),(67,'shoptitle','申报服务费用'),(68,'ycshoptitle','异常服务费用'),(69,'max_price','298'),(70,'min_price','298'),(71,'ycmin_price','698'),(72,'ycmax_price','698');
/*!40000 ALTER TABLE `nianbao_base_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nianbao_enterprise`
--

DROP TABLE IF EXISTS `nianbao_enterprise`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nianbao_enterprise` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `enterprise_name` varchar(255) NOT NULL DEFAULT '' COMMENT '企业名称',
  `enterprise_code` varchar(255) NOT NULL DEFAULT '' COMMENT '企业代码',
  `mobile` varchar(255) NOT NULL DEFAULT '' COMMENT '手机号',
  `legal_person` varchar(255) NOT NULL DEFAULT '' COMMENT '法人代表人名称',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态',
  `is_special` tinyint(4) DEFAULT '0' COMMENT '是否是特价企业',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nianbao_enterprise`
--

LOCK TABLES `nianbao_enterprise` WRITE;
/*!40000 ALTER TABLE `nianbao_enterprise` DISABLE KEYS */;
INSERT INTO `nianbao_enterprise` VALUES (1,'aaaaaa','bbbbbb','15896587455','ccc',1,0);
/*!40000 ALTER TABLE `nianbao_enterprise` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nianbao_enterprise_report`
--

DROP TABLE IF EXISTS `nianbao_enterprise_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nianbao_enterprise_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `enterprise_id` int(11) DEFAULT NULL,
  `enterprise_code` varchar(255) NOT NULL COMMENT '企业代码',
  `report_year` varchar(255) NOT NULL DEFAULT '' COMMENT '年报年份',
  `is_report` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否年报：0.未|1.已',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nianbao_enterprise_report`
--

LOCK TABLES `nianbao_enterprise_report` WRITE;
/*!40000 ALTER TABLE `nianbao_enterprise_report` DISABLE KEYS */;
INSERT INTO `nianbao_enterprise_report` VALUES (1,NULL,'bbbbbb','2023',0);
/*!40000 ALTER TABLE `nianbao_enterprise_report` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nianbao_file`
--

DROP TABLE IF EXISTS `nianbao_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nianbao_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filepath` varchar(255) DEFAULT NULL COMMENT '图片路径',
  `hash` varchar(32) DEFAULT NULL COMMENT '文件hash值',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `disk` varchar(20) DEFAULT NULL COMMENT '存储类似',
  `type` tinyint(4) DEFAULT NULL COMMENT '文件类型',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `hash` (`hash`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nianbao_file`
--

LOCK TABLES `nianbao_file` WRITE;
/*!40000 ALTER TABLE `nianbao_file` DISABLE KEYS */;
INSERT INTO `nianbao_file` VALUES (1,'https://tieie.xyaa.vip/uploads/admin/202404/660ea2f989956.jpg','71ffeb9df222fc0c3b207e39cb11f2b5',1712235257,'local',1),(2,'https://tieie.xyaa.vip/uploads/admin/202404/660ea3011146f.png','56a6e15a5975828be9c5ddd75fc41651',1712235265,'local',1),(3,'https://tieie.xyaa.vip/uploads/admin/202404/660ea302af1e9.png','a03f622a7304dabf8844e027f5eb667d',1712235266,'local',1),(4,'https://tieie.xyaa.vip/uploads/admin/202404/660ea305af4e9.png','1f9bdbfd69f689c0039e35cbf5d83002',1712235269,'local',1),(5,'https://tieie.xyaa.vip/uploads/admin/202404/660ea307e6c5a.png','d869d92ea1b3aa75a1ca8b32087f47da',1712235271,'local',1);
/*!40000 ALTER TABLE `nianbao_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nianbao_log`
--

DROP TABLE IF EXISTS `nianbao_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nianbao_log`
--

LOCK TABLES `nianbao_log` WRITE;
/*!40000 ALTER TABLE `nianbao_log` DISABLE KEYS */;
INSERT INTO `nianbao_log` VALUES (1,'admin','admin','https://tieie.xyaa.vip/admin/Login/index.html','140.250.226.96','Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36',NULL,NULL,1712235227,1,NULL),(2,'admin','admin','https://tieie.xyaa.vip/admin/Login/index.html','42.236.203.132','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36',NULL,NULL,1712236272,1,NULL),(3,'api',NULL,'https://tieie.xyaa.vip/api/login/login','42.236.203.132','Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A372 Safari/604.1 wechatdevtools/1.06.2307250 MicroMessenger/8.0.5 Language/zh_CN webview/','{\"code\":\"0d3mLi100No7RR1f91300FOatx1mLi1C\"}','SQLSTATE[23000]: Integrity constraint violation: 1048 Column \'openid\' cannot be null',1712236318,3,NULL),(4,'api',NULL,'https://tieie.xyaa.vip/api/login/login','42.236.203.132','Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A372 Safari/604.1 wechatdevtools/1.06.2307250 MicroMessenger/8.0.5 Language/zh_CN webview/','{\"code\":\"0c3MhG200donQR1RyX100zssSK3MhG2e\"}','SQLSTATE[23000]: Integrity constraint violation: 1048 Column \'openid\' cannot be null',1712236592,3,NULL),(5,'api',NULL,'https://tieie.xyaa.vip/api/login/login','42.236.203.132','Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A372 Safari/604.1 wechatdevtools/1.06.2307250 MicroMessenger/8.0.5 Language/zh_CN webview/','{\"code\":\"0b3n0w1w3vVMw2301y0w38jqHn2n0w1n\"}','SQLSTATE[23000]: Integrity constraint violation: 1048 Column \'openid\' cannot be null',1712236610,3,NULL),(6,'admin','admin','https://tieie.xyaa.vip/admin/Login/index.html','42.236.203.132','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36',NULL,NULL,1712240608,1,NULL),(7,'admin','admin','https://tieie.xyaa.vip/admin/Login/index.html','42.236.203.132','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36',NULL,NULL,1712240875,1,NULL),(8,'admin','admin','https://tieie.xyaa.vip/admin/Enterprise/add','42.236.203.132','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36','{\"enterprise_name\":\"aaaaaa\",\"is_special\":0,\"enterprise_code\":\"bbbbbb\",\"mobile\":\"15896587455\",\"legal_person\":\"ccc\",\"status\":1}',NULL,1712241772,2,NULL),(9,'admin',NULL,'https://tieie.xyaa.vip/admin/Remarks/index','42.236.203.132','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36','{\"limit\":20,\"page\":1,\"order\":\"\",\"sort\":\"\",\"order_id\":\"1\"}','SQLSTATE[42S02]: Base table or view not found: 1146 Table \'tieie_xyaa_vip.nianbao_remarks\' doesn\'t exist',1712243281,3,NULL),(10,'admin','admin','https://tieie.xyaa.vip/admin/Remarks/add','42.236.203.132','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36','{\"remarks_people\":\"123\",\"remarks_content\":\"1231\",\"order_id\":\"1\"}',NULL,1712244565,2,NULL),(11,'api',NULL,'https://tieie.xyaa.vip/api/login/login','140.250.226.96','Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A372 Safari/604.1 wechatdevtools/1.06.2303220 MicroMessenger/8.0.5 Language/zh_CN webview/','{\"code\":\"0e3Ui10w3QrFx23T1i0w38zLfp3Ui106\"}','SQLSTATE[23000]: Integrity constraint violation: 1048 Column \'openid\' cannot be null',1712246050,3,NULL),(12,'api',NULL,'https://tieie.xyaa.vip/api/login/login','140.250.226.96','Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A372 Safari/604.1 wechatdevtools/1.06.2303220 MicroMessenger/8.0.5 Language/zh_CN webview/','{\"code\":\"0a3mp5000k9mSR1Vts0000ft8o3mp50E\"}','SQLSTATE[23000]: Integrity constraint violation: 1048 Column \'openid\' cannot be null',1712246050,3,NULL),(13,'admin','admin','https://tieie.xyaa.vip/admin/Login/index.html','140.250.226.96','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36  115Browser/26.0.5.3',NULL,NULL,1712247605,1,NULL),(14,'admin','admin','https://tieie.xyaa.vip/admin/Login/index.html','140.250.226.96','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',NULL,NULL,1712496538,1,NULL),(15,'admin','admin','https://tieie.xyaa.vip/admin/Login/index.html','140.250.226.96','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',NULL,NULL,1712691699,1,NULL),(16,'admin','admin','https://tieie.xyaa.vip/admin/Login/index.html','140.250.226.96','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 Edg/122.0.0.0',NULL,NULL,1712692082,1,NULL),(17,'admin','admin','https://01.xyaa.vip/admin/Login/index.html','140.250.226.96','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',NULL,NULL,1712693391,1,NULL);
/*!40000 ALTER TABLE `nianbao_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nianbao_member`
--

DROP TABLE IF EXISTS `nianbao_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nianbao_member`
--

LOCK TABLES `nianbao_member` WRITE;
/*!40000 ALTER TABLE `nianbao_member` DISABLE KEYS */;
INSERT INTO `nianbao_member` VALUES (1,'oMM0J47iojXldqnrQWAwkbs1jys4','0602ND2PVZ','https://thirdwx.qlogo.cn/mmopen/vi_32/POgEwh4mIHO4nibH0KlMECNjjGxQUq24ZEaGT4poC6icRiccVGKSyXwibcPq4BWmiaIGuG1icwxaQX6grC9VemZoJ8rg/132','MTcxMjIzNjcwNTE=','','oMM0J47iojXldqnrQWAwkbs1jys4',0,'2024-04-04 13:18:25','2024-04-04 13:18:25',NULL,0),(2,'oMM0J4_j-ADh0nEYqe0Gk6JyhFzc','2815HDTL5U','https://thirdwx.qlogo.cn/mmopen/vi_32/POgEwh4mIHO4nibH0KlMECNjjGxQUq24ZEaGT4poC6icRiccVGKSyXwibcPq4BWmiaIGuG1icwxaQX6grC9VemZoJ8rg/132','MTcxMjI0Mjc4NjI=','','oMM0J4_j-ADh0nEYqe0Gk6JyhFzc',0,'2024-04-04 14:59:46','2024-04-04 14:59:46',NULL,0);
/*!40000 ALTER TABLE `nianbao_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nianbao_member_enterprise`
--

DROP TABLE IF EXISTS `nianbao_member_enterprise`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nianbao_member_enterprise` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `enterprise_id` int(11) DEFAULT NULL,
  `member_mobile` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nianbao_member_enterprise`
--

LOCK TABLES `nianbao_member_enterprise` WRITE;
/*!40000 ALTER TABLE `nianbao_member_enterprise` DISABLE KEYS */;
/*!40000 ALTER TABLE `nianbao_member_enterprise` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nianbao_node`
--

DROP TABLE IF EXISTS `nianbao_node`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nianbao_node`
--

LOCK TABLES `nianbao_node` WRITE;
/*!40000 ALTER TABLE `nianbao_node` DISABLE KEYS */;
INSERT INTO `nianbao_node` VALUES (22,'首页',1,'/admin/Index/main.html',1,'el-icon-s-home',0,1),(51,'配置管理',1,'/admin/Baseconfig/index.html',1,'el-icon-s-data',NULL,51),(52,'基本配置',1,'/admin/Baseconfig/index.html',1,'',51,52),(54,'节点管理',1,'/admin/Node/index.html',1,'',55,59),(55,'系统管理',1,'/admin/Sys',1,'el-icon-s-data',0,55),(56,'用户管理',1,'/admin/Adminuser/index.html',1,'',55,56),(57,'角色管理',1,'/admin/Role/index.html',1,'',55,57),(58,'日志管理',1,'/admin/Log/index.html',1,'',55,58),(70,'会员管理',1,'/admin/Member/index.html',1,'el-icon-user-solid',0,2),(71,'添加',2,'/admin/Member/add.html',1,'',70,1),(72,'修改',2,'/admin/Member/update.html',1,'',70,2),(73,'删除',2,'/admin/Member/delete.html',1,'',70,3),(74,'获取修改信息',2,'/admin/Member/getUpdateInfo.html',1,'',70,4),(75,'企业管理',1,'/admin/Enterprise/index.html',1,'el-icon-office-building',0,3),(76,'添加',2,'/admin/Enterprise/add.html',1,'',75,1),(77,'修改',2,'/admin/Enterprise/update.html',1,'',75,2),(78,'删除',2,'/admin/Enterprise/delete.html',1,'',75,3),(79,'获取修改信息',2,'/admin/Enterprise/getUpdateInfo.html',1,'',75,4),(80,'订单管理',1,'/admin/Order/index.html',1,'el-icon-s-order',0,4),(81,'一键发送短信提醒',2,'/admin/Enterprise/send.html',1,'',75,5),(82,'导入',2,'/admin/Enterprise/importData.html',1,'',75,6),(85,'申报',2,'/admin/Order/declaration.html',1,'',80,1),(86,'退款',2,'/admin/Order/refund.html',1,'',80,2),(87,'申报成功',2,'/admin/Order/declaration_success.html',1,'',80,3),(88,'申报失败',2,'/admin/Order/declaration_fail.html',1,'',80,4),(89,'年报状态',2,'/admin/Report/index.html',1,'',75,7),(93,'支付管理',1,'/admin/Pay/index.html',1,'el-icon-bank-card',0,6),(94,'添加',2,'/admin/Pay/add.html',1,'',93,1),(95,'修改',2,'/admin/Pay/update.html',1,'',93,2),(96,'获取修改信息',2,'/admin/Pay/getUpdateInfo.html',1,'',93,3),(97,'删除',2,'/admin/Pay/delete.html',1,'',93,4),(98,'修改状态',2,'/admin/Pay/updateExt.html',1,'',93,5),(99,'地区价格管理',1,'/admin/Area/index.html',1,'',0,4),(100,'添加',2,'/admin/Area/add.html',1,'',99,1),(101,'修改',2,'/admin/Area/update.html',1,'',99,2),(102,'获取修改信息',2,'/admin/Area/getUpdateInfo.html',1,'',99,3),(103,'删除',2,'/admin/Area/delete.html',1,'',99,4),(104,'修改状态',2,'/admin/Area/updateExt.html',1,'',99,5),(105,'删除',2,'/admin/Order/delete.html',1,'',80,5),(106,'下载模板',2,'/admin/Enterprise/downtemplate.html',1,'',75,8);
/*!40000 ALTER TABLE `nianbao_node` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nianbao_order`
--

DROP TABLE IF EXISTS `nianbao_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nianbao_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `enterprise_id` int(11) DEFAULT NULL,
  `pay_id` int(11) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT '' COMMENT '手机号',
  `title` varchar(255) DEFAULT NULL,
  `idcard` varchar(255) DEFAULT NULL COMMENT '身份证号码',
  `fmobile` varchar(255) DEFAULT NULL COMMENT '用户手动填写的手机号',
  `order_no` varchar(255) NOT NULL DEFAULT '' COMMENT '订单号',
  `sxfuuid` varchar(255) DEFAULT NULL COMMENT '随行付落单号',
  `enterprise_name` varchar(255) NOT NULL DEFAULT '' COMMENT '企业名称',
  `enterprise_code` varchar(255) NOT NULL DEFAULT '' COMMENT '企业代码',
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
  `is_pay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支付：0.未支付|1.已支付',
  `pay_type` tinyint(4) NOT NULL COMMENT '支付方式：1.微信支付 2.随行付',
  `is_refund` varchar(4) DEFAULT '0' COMMENT '是否退款',
  `status` tinyint(4) DEFAULT '0' COMMENT '订单是否已完成 1是已完成',
  `refund_time` timestamp NULL DEFAULT NULL COMMENT '退款时间',
  `pay_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '支付时间',
  `create_time` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `is_delete` tinyint(4) DEFAULT '0',
  `delete_time` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nianbao_order`
--

LOCK TABLES `nianbao_order` WRITE;
/*!40000 ALTER TABLE `nianbao_order` DISABLE KEYS */;
INSERT INTO `nianbao_order` VALUES (1,1,1,1,'1','1','1','1','11','1','1','1','1','1','1','1',NULL,0,0.00,'',0,0,1,0,'0',0,NULL,'0000-00-00 00:00:00',NULL,'2024-04-04 14:48:02',0,NULL),(2,2,0,NULL,'','申报服务费用','','','20240404225956132973',NULL,'','','',NULL,NULL,NULL,NULL,0,296.00,'2023',0,0,0,0,'0',0,NULL,'0000-00-00 00:00:00','2024-04-04 14:59:56',NULL,0,NULL),(3,2,0,NULL,'','申报服务费用','','','20240404225958644870',NULL,'','','',NULL,NULL,NULL,NULL,0,296.00,'2023',0,0,0,0,'0',0,NULL,'0000-00-00 00:00:00','2024-04-04 14:59:58',NULL,0,NULL),(4,2,0,NULL,'','申报服务费用','','','20240404225959692598',NULL,'','','',NULL,NULL,NULL,NULL,0,296.00,'2023',0,0,0,0,'0',0,NULL,'0000-00-00 00:00:00','2024-04-04 14:59:59',NULL,0,NULL),(5,2,0,NULL,'','申报服务费用','','','20240404230003419243',NULL,'','','',NULL,NULL,NULL,NULL,0,296.00,'2023',0,0,0,0,'0',0,NULL,'0000-00-00 00:00:00','2024-04-04 15:00:03',NULL,0,NULL),(6,2,0,NULL,'','申报服务费用','','','20240404230202812526',NULL,'','','',NULL,NULL,NULL,NULL,0,296.00,'2023',0,0,0,0,'0',0,NULL,'0000-00-00 00:00:00','2024-04-04 15:02:02',NULL,0,NULL);
/*!40000 ALTER TABLE `nianbao_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nianbao_pay`
--

DROP TABLE IF EXISTS `nianbao_pay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nianbao_pay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) DEFAULT '1' COMMENT '1是微信2是随行付',
  `mch_id` varchar(255) DEFAULT NULL COMMENT '微信商户号',
  `pay_secretkey` varchar(255) DEFAULT NULL COMMENT '微信支付秘钥',
  `cert_path` varchar(255) DEFAULT NULL COMMENT '微信Cert证书',
  `key_path` varchar(255) DEFAULT NULL COMMENT '微信Key证书',
  `orgid` varchar(255) DEFAULT NULL COMMENT '随行付机构号',
  `mno` varchar(255) DEFAULT NULL COMMENT '随行付商户编号',
  `privatekey` text COMMENT '随行付私钥',
  `sxfpublic` text COMMENT '随行付公钥',
  `notes` text COMMENT '备注',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nianbao_pay`
--

LOCK TABLES `nianbao_pay` WRITE;
/*!40000 ALTER TABLE `nianbao_pay` DISABLE KEYS */;
/*!40000 ALTER TABLE `nianbao_pay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nianbao_remarks`
--

DROP TABLE IF EXISTS `nianbao_remarks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nianbao_remarks`
--

LOCK TABLES `nianbao_remarks` WRITE;
/*!40000 ALTER TABLE `nianbao_remarks` DISABLE KEYS */;
INSERT INTO `nianbao_remarks` VALUES (1,1,1,'1231','123',1712244565,1712244565,NULL,0);
/*!40000 ALTER TABLE `nianbao_remarks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nianbao_role`
--

DROP TABLE IF EXISTS `nianbao_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nianbao_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(36) DEFAULT NULL COMMENT '分组名称',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态',
  `pid` smallint(6) DEFAULT NULL COMMENT '所属父类',
  `description` text COMMENT '描述',
  `access` longtext COMMENT '权限节点',
  PRIMARY KEY (`role_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nianbao_role`
--

LOCK TABLES `nianbao_role` WRITE;
/*!40000 ALTER TABLE `nianbao_role` DISABLE KEYS */;
INSERT INTO `nianbao_role` VALUES (1,'超级管理员',1,0,'超级管理员','/admin/Sys,/admin/Index/main.html,/admin/Member/index.html,/admin/Member/add.html,/admin/Member/update.html,/admin/Member/delete.html,/admin/Member/getUpdateInfo.html,/admin/Enterprise/index.html,/admin/Enterprise/add.html,/admin/Enterprise/update.html,/admin/Enterprise/delete.html,/admin/Enterprise/getUpdateInfo.html,/admin/Enterprise/send.html,/admin/Enterprise/importData.html,/admin/Report/index.html,/admin/Area/index.html,/admin/Order/index.html,/admin/Order/declaration.html,/admin/Order/refund.html,/admin/Order/declaration_success.html,/admin/Order/declaration_fail.html,/admin/Shop/index.html,/admin/Shoptype/index.html,/admin/Shop/index.html,/admin/Pay/index.html,/admin/Pay/add.html,/admin/Pay/update.html,/admin/Pay/getUpdateInfo.html,/admin/Pay/delete.html,/admin/Pay/updateExt.html,/admin/Adminuser/index.html,Home'),(53,'管理员',1,NULL,'管理员','/admin/Index/main.html,/admin/Member/index.html,/admin/Member/add.html,/admin/Member/update.html,/admin/Member/delete.html,/admin/Member/getUpdateInfo.html,/admin/Enterprise/index.html,/admin/Enterprise/add.html,/admin/Enterprise/update.html,/admin/Enterprise/delete.html,/admin/Enterprise/getUpdateInfo.html,/admin/Enterprise/send.html,/admin/Enterprise/importData.html,/admin/Report/index.html,/admin/Enterprise/downtemplate.html,/admin/Area/index.html,/admin/Area/add.html,/admin/Area/update.html,/admin/Area/getUpdateInfo.html,/admin/Area/delete.html,/admin/Area/updateExt.html,/admin/Order/index.html,/admin/Order/declaration.html,/admin/Order/refund.html,/admin/Order/declaration_success.html,/admin/Order/declaration_fail.html,/admin/Order/delete.html,/admin/Pay/index.html,/admin/Pay/add.html,/admin/Pay/update.html,/admin/Pay/getUpdateInfo.html,/admin/Pay/delete.html,/admin/Pay/updateExt.html,Home');
/*!40000 ALTER TABLE `nianbao_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nianbao_secrect`
--

DROP TABLE IF EXISTS `nianbao_secrect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nianbao_secrect` (
  `secrect_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(50) NOT NULL,
  `data` text NOT NULL,
  `appid` varchar(250) DEFAULT NULL COMMENT 'appid',
  PRIMARY KEY (`secrect_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nianbao_secrect`
--

LOCK TABLES `nianbao_secrect` WRITE;
/*!40000 ALTER TABLE `nianbao_secrect` DISABLE KEYS */;
INSERT INTO `nianbao_secrect` VALUES (1,'appid','HbUX4SClpbJv1',NULL),(2,'secrect','OnLQ00vgWXzqohNc7Y2y',NULL);
/*!40000 ALTER TABLE `nianbao_secrect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nianbao_supplier`
--

DROP TABLE IF EXISTS `nianbao_supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nianbao_supplier` (
  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(250) DEFAULT NULL COMMENT '供应商名称',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `username` varchar(250) DEFAULT NULL COMMENT '用户名',
  `password` varchar(250) DEFAULT NULL COMMENT '密码',
  PRIMARY KEY (`supplier_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nianbao_supplier`
--

LOCK TABLES `nianbao_supplier` WRITE;
/*!40000 ALTER TABLE `nianbao_supplier` DISABLE KEYS */;
/*!40000 ALTER TABLE `nianbao_supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nianbao_uploadfile`
--

DROP TABLE IF EXISTS `nianbao_uploadfile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nianbao_uploadfile` (
  `uploadfile_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` varchar(250) DEFAULT NULL COMMENT '标题',
  `pic` varchar(250) DEFAULT NULL COMMENT '单图上传',
  `pic_2` varchar(250) DEFAULT NULL COMMENT '单图2',
  `pics` text COMMENT '多图上传',
  `file` varchar(250) DEFAULT NULL COMMENT '单文件',
  `files` text COMMENT '多文件',
  PRIMARY KEY (`uploadfile_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nianbao_uploadfile`
--

LOCK TABLES `nianbao_uploadfile` WRITE;
/*!40000 ALTER TABLE `nianbao_uploadfile` DISABLE KEYS */;
/*!40000 ALTER TABLE `nianbao_uploadfile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database '01_xyaa_vip'
--

--
-- Dumping routines for database '01_xyaa_vip'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-10  4:13:55
