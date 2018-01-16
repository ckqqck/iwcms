-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 22, 2017 at 10:51 PM
-- Server version: 5.7.17-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codeinsect`
--

-- --------------------------------------------------------

--
-- Table structure for table `article_fileimg`
--

CREATE TABLE `article_fileimg` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `aid` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `uid` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `dateline` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `filename` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `filetype` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `filesize` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `imgpath` text CHARACTER SET utf8 NOT NULL,
  `remote` varchar(255) NOT NULL,
  `ext` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `magicframe` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- Dumping data for table `article_fileimg`
--

INSERT INTO `article_fileimg` (`id`, `aid`, `uid`, `dateline`, `filename`, `filetype`, `filesize`, `imgpath`, `remote`, `ext`, `path`, `magicframe`) VALUES
(516, 3, 0, 1495237273, '16071385766999_4324403_14.JPG', 'jpeg', 90, 'uploads/201705/20/2ogms1.JPG', '2ogms.JPG', '.JPG', 'uploads/201705/20/', '2ogms1'),
(541, 3, 0, 1509970858, 'article.jpg', 'jpeg', 70, 'uploads/201711/06/fwuow.jpg', 'fwuow.jpg', '.jpg', 'uploads/201711/06/', 'fwuow'),
(542, 3, 0, 1510144307, '593fb740N045f0832.jpg', 'jpeg', 10, 'uploads/201711/08/iu7kl.jpg', 'iu7kl.jpg', '.jpg', 'uploads/201711/08/', 'iu7kl'),
(543, 3, 0, 1510323940, 'Azcms.png', 'png', 7, 'uploads/201711/10/vcevv.png', 'vcevv.png', '.png', 'uploads/201711/10/', 'vcevv'),
(544, 3, 0, 1510834690, 'Azcms.png', 'png', 7, 'uploads/201711/16/7drcx.png', '7drcx.png', '.png', 'uploads/201711/16/', '7drcx'),
(545, 3, 0, 1511070975, 'Azcms.png', 'png', 87, 'uploads/201711/19/8babn.png', '8babn.png', '.png', 'uploads/201711/19/', '8babn');

-- --------------------------------------------------------

--
-- Table structure for table `blog_category`
--

CREATE TABLE `blog_category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `category_text` text NOT NULL,
  `template_list` varchar(255) NOT NULL,
  `template_read` varchar(255) NOT NULL,
  `date` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blog_category`
--

INSERT INTO `blog_category` (`id`, `category_name`, `category_text`, `template_list`, `template_read`, `date`) VALUES
(1, '优美', '', '', '', 1462090840),
(2, '搞笑', '', '', '', 1462090840),
(3, '视频', '', '', '', 1462090840);

-- --------------------------------------------------------

--
-- Table structure for table `blog_conment`
--

CREATE TABLE `blog_conment` (
  `id` int(9) NOT NULL,
  `aid` int(9) NOT NULL,
  `body` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_conment`
--

INSERT INTO `blog_conment` (`id`, `aid`, `body`) VALUES
(176, 176, '<p><iframe src=\"http://v.qq.com/iframe/player.html?vid=j0107em4fiv&500&375&auto=0\" scrolling=\"no\" frameborder=\"0\" align=\"\"></iframe></p>'),
(177, 177, '<p><iframe src=\"http://v.qq.com/iframe/player.html?vid=d01939n0tzr&tiny=0&auto=0\" scrolling=\"no\" frameborder=\"0\" align=\"\"></iframe></p>'),
(178, 178, '<p><img src=\"http://127.0.0.1/azcms/uploads/201711/10/vcevv.png\" /></p>\r\n'),
(179, 179, '<p><img src=\"http://127.0.0.1/azcms/uploads/201711/06/fwuow.jpg\" style=\"height:650px; width:820px\" /></p>\r\n'),
(180, 180, '<p><iframe src=\"http://v.qq.com/iframe/player.html?vid=d01882voyxh&tiny=0&auto=0\" scrolling=\"no\" frameborder=\"0\" align=\"\"></iframe></p>'),
(174, 174, '<p>导致胸部越来越小的元凶</p>\r\n\r\n<p><strong>第一：胸罩尺码不符，穿戴方法错误</strong></p>\r\n\r\n<p><strong><img alt=\"1462196781338189.jpg\" src=\"/upload/image/20160502/1462196781338189.jpg\" style=\"height:345px; width:555px\" /></strong></p>\r\n\r\n<p>　　许多女性买胸罩试都不试就买回家了，其实，过小的胸罩会影响胸部的发育，而长期穿戴过大的胸罩又可能导致胸部下垂。</p>\r\n\r\n<p>　　随着年龄的变化以及婚前婚后或孕育前后，女性的乳房大小会发生变化，这时选购胸罩就要调整尺码，试过之后再买。</p>\r\n\r\n<p>　　穿胸罩时，也不是随便扣上就行了，而应当先把胸罩扣好，然后调整肩带，身体前屈，用手将整个乳房及周围的<strong>脂肪</strong>都塞进罩杯里，使之显得充实饱满，也可避免乳房脂肪外移，使乳房越来越小。</p>\r\n\r\n<p>　　<strong>第二：运动伤害</strong></p>\r\n\r\n<p><strong><img alt=\"1462197169300957.jpg\" src=\"/upload/image/20160502/1462197169300957.jpg\" style=\"height:349px; width:500px\" /></strong></p>\r\n\r\n<p>　　适当的运动有助于乳房的健美，过量的运动或运动时不注意<strong>内衣</strong>穿戴则可能伤害乳房。有些人运动时会感到<strong>胸罩</strong>是个累赘，因此不戴胸罩，这样容易使胸部曲线走样。特别是<strong>跑步</strong>、<strong>跳绳</strong>等，运动时更要注意保<strong>护胸</strong>部，避免胸部下垂。</p>\r\n\r\n<p>　　<strong>第三：错误按摩</strong></p>\r\n\r\n<p>　　按摩可以促使乳房丰满，但如果随便拍打或者向下按摩只会让乳房越来越小。正确的按摩方法应当是先在乳房上涂上按摩霜，然后顺着乳腺组织向上划圈。</p>\r\n\r\n<p><img alt=\"1462196879353760.jpg\" src=\"/upload/image/20160502/1462196879353760.jpg\" /></p>\r\n\r\n<p>　　<strong>第四：随便服用药物</strong></p>\r\n\r\n<p>　　用<strong>避孕药</strong>来除<strong>青春痘</strong>，或用避孕药让乳房变丰满的做法都是不可取的。</p>\r\n\r\n<p>　　避孕药的主要成分是雌<strong>激素</strong>和孕激素，长期服用会打乱女性的内分泌平衡，造成月经不调，这样只会使胸部越来越小。</p>\r\n\r\n<p>&nbsp;</p>\r\n'),
(175, 175, '<p>&nbsp;</p>\r\n\r\n<p>在众多的人际交往中，女人起着关键的作用。和谐幸福的家庭往往是有一个好女人；协调有序的社会往往是有一群好女人。甚至可以夸张地说，女人的交际影响着整个社会的交际。那么，怎样才能做个在交际中讨人喜欢的女人呢？很重要的一点就是做一个有味道的女人。</p>\r\n\r\n<p>清代文人李渔曾就女人味发表过一段很妙的文字：女人味就是当她在一颦一笑，一举手一投足间，无意中自然流露出来的那种勾人魂魄的韵味。</p>\r\n\r\n<p>女人味是一种境界，是一种情调，是一种优雅的生活态度。聪明的女人，永远女人味十足，让男人永远被她的女人味所吸引。而不聪明的女人往往在岁月的流逝中，不注意保存自己的青春，让女人味也一同溜走了。</p>\r\n\r\n<p>所以，做女人一定要有女人味，因为女人味是女人的魅力之所在。女人没有女人味，就像鲜花失去香味，明月失去清辉。女人有味，三分漂亮可增加到七分；女人无味，七分漂亮能降至三分。女人味，让女人向往，令男人沉醉。男人无一例外地会喜欢有味的女人，而女人征服男人的，往往不是因为美丽，而是她的女人味。</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>没有女人味的女人也许有漂亮的脸蛋和魔鬼般的身材，但那是衣服架子，焕发不出迷人的风采。漂亮的女人不一定有味道，很多漂亮的女人借助上帝赐给她的一种娇好的容颜可以满足一时的虚荣心。她们以为，凭着扭动一下腰姿、抛一个媚眼就可以达到自己的目的，但万物生息皆难逃过年华终老去的劫数，再鲜艳的花朵也有凋谢的那一天，当岁月在那张曾经年轻的脸蛋上涂满风霜的时候，原本漂亮的女人还有什么呢？</p>\r\n\r\n<p>前卫的女人不一定有味道。很多女人为了追求所谓的超众脱俗，脸上涂满各种各样的色彩，身上穿着各种名贵品牌、奇装异服。但是，用物质涂抹起来的面具终归是浅薄的，前卫的女人以昂贵的化妆品和时髦的衣物武装起了自己，口里吐的却是狂言秽语，行为扮的是暧昧猥琐。也许，这也是一种味道，不过是那种让人掩鼻的怪味罢了。</p>\r\n\r\n<p>有钱的女人不一定有味道。金钱虽然是人类生存所必需的物质基础，但它却不是万能的。有人说，钱可以买到房子，却买不到家；可以买到婚姻，却买不到爱；可以买到钟表，却买不到时间；可以买到吹捧，却买不到尊重；可以买到阿谀奉承，却买不到真心实意。有钱的女人铜臭有余而情调不足，情调不足则索然寡味。</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>有权的女人不一定有味道。这种女人可以利用手中的权势对人发号施令，颐指气使，一时好像也是叱吒风云的人物，但是，如果没有涵养，滥施权贵，也会显得权势味太浓而韵味不足。</p>\r\n\r\n<p>乌克兰的美女总理季莫申科可谓是政界&ldquo;铁娘子&rdquo;，但季氏给人的感觉与印象却是女人味十足。季氏首先在衣着上尽显女人本色&mdash;&mdash;花呢连衣裙、香奈尔时尚裤装、高筒皮鞋、牛仔裤，甚至超短裙，都是她的最爱。而且，她性情乐观开朗，不失女人风情。外界评论说：&ldquo;她在服饰上力图给人一种印象，她首先是个女人，之后才是个政治家。&rdquo;她的魅力在于，既是总理，也是天使。</p>\r\n\r\n<p>虽然现在的女人身担不同的角色，但她首先是女人，然后才能是其他。况且女性的身份，在某些情况下，如果利用得当，还能成为一种优势，助你一臂之力。</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>琼出身IT行业，从大学起一直到身为某大型公司的市场副总裁，都是处在一个女少男多的圈子里，但这并没有让她感到有什么不妥，反而因为她的女性身份而受到了更多的照顾。</p>\r\n\r\n<p>她说：&ldquo;一直觉得女人味很重要，即便是工作时，也不可能板起脸来训斥人，相反，有时候你采取宽容而温和的管理方式，效果会更好。&rdquo;</p>\r\n\r\n<p>当然，琼也强调，工作起来谁也不会因为你是女人就对你降低工作标准，但在同样拥有技术和智商的前提下，女人自然也有她不可比拟的优势。琼是个聪明的女人，在男人和女人平分秋色的世界里，她懂得进取，更懂得适时地妥协。她承认差异，更能很好地利用这种差异，所以她的很多男同事都认为这是她身上的女人味。</p>\r\n\r\n<p>有味道的女人是精致的。漂亮的女人不一定有味，但有味的女人一定漂亮。她淡雅而不失妩媚，楚楚动人。</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>有味道的女人是有涵养的。她读书、看报、听歌、品茗、上网&hellip;&hellip;李白的浪漫、杜甫的沉郁、苏轼的豪放，民歌的清越、轻音乐的纯净、流行歌曲的动感，浸润她的心灵，滋养她的灵秀。广泛的兴趣爱好，积淀她的内涵；深厚的文化底蕴，烹出醉人的味道。她淡泊恬静、优雅从容，心胸开阔。虽然也有难过，也受过伤，但决不歇斯底里，而是静静地自我安慰、自我疗伤。</p>\r\n\r\n<p>有味道的女人高雅不流俗。她也爱钱，但决不贪；她也戴首饰，但决不一只手上戴三个戒指晃来晃去；她懂得生活，更懂得享受生活；她品味时尚，但不追逐潮流附庸风雅；她学富五车才高八斗，但决不卖弄自己的满腹经纶，她把自己的聪慧和才思用于工作和事业上；她懂人情但不世故，尽心做事但不功利，虽洞察人世间的种种龌龊，但不随波逐流。</p>\r\n\r\n<p>有味道的女人洋溢着一种柔美的气质。她喜欢一个人逛街，喜欢听朋友的诉说，喜欢做一桌美味看家人吃得香甜&hellip;&hellip;有味道的女人，妆是淡妆，话很恰当，笑能可掬，爱却执著。</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>有味道的女人是平凡的。她挚爱一切美好的事物，包括她自己，她被人欣赏，也欣赏别人，欣赏世界上的一切美景，欣赏人间的种种真情。</p>\r\n\r\n<p>有味道的女人也许春风得意，但决不咄咄逼人，占尽满园风情，纵然有无限的风光，自己也只去享受一小块田园。她与人为善，不知刻薄为何物，从不在同事间挑拨是非，看待上司和看待同事的目光一样真诚。她会在你有成就的时候报以掌声，由衷地为你高兴；会在你摔倒的时候伸出双手拉你一把，鼓励你站起来前行。</p>\r\n\r\n<p>有味道的女人从内到外，都散发着一种迷人的气质，吸引更多的人与之交往。所以，有味道的女人不用花费太大的力气，就会有很好的人脉。</p>\r\n\r\n<p>&nbsp;</p>\r\n'),
(181, 181, '<p><img src=\"http://www.ty185.cn/uploads/201706/04/vwj2b.png\" /></p>\r\n\r\n<p><img src=\"http://www.ty185.cn/uploads/201706/04/l8uhf.jpg\" /></p>\r\n\r\n<p>ddddddddddddddddddd佛挡杀佛5666666666666666666666</p>\r\n'),
(182, 182, '<p><img src=\"http://www.ty185.cn/uploads/201706/04/1uy82.png\" /><img src=\"http://127.0.0.1/CodeIgniter-3.0.5/uploads/pic_160.png\" />导致胸部越来越小的元凶</p>\r\n\r\n<p><strong>第一：胸罩尺码不符，穿戴方法错误</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>　　许多女性买胸罩试都不试就买回家了，其实，过小的胸罩会影响胸部的发育，而长期穿戴过大的胸罩又可能导致胸部下垂。</p>\r\n\r\n<p>　　随着年龄的变化以及婚前婚后或孕育前后，女性的乳房大小会发生变化，这时选购胸罩就要调整尺码，试过之后再买。</p>\r\n\r\n<p>　　穿胸罩时，也不是随便扣上就行了，而应当先把胸罩扣好，然后调整肩带，身体前屈，用手将整个乳房及周围的<strong>脂肪</strong>都塞进罩杯里，使之显得充实饱满，也可避免乳房脂肪外移，使乳房越来越小。</p>\r\n\r\n<p>　　<strong>第二：运动伤害</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>　　适当的运动有助于乳房的健美，过量的运动或运动时不注意<strong>内衣</strong>穿戴则可能伤害乳房。有些人运动时会感到<strong>胸罩</strong>是个累赘，因此不戴胸罩，这样容易使胸部曲线走样。特别是<strong>跑步</strong>、<strong>跳绳</strong>等，运动时更要注意保<strong>护胸</strong>部，避免胸部下垂。</p>\r\n\r\n<p>　　<strong>第三：错误按摩</strong></p>\r\n\r\n<p>　　按摩可以促使乳房丰满，但如果随便拍打或者向下按摩只会让乳房越来越小。正确的按摩方法应当是先在乳房上涂上按摩霜，然后顺着乳腺组织向上划圈。</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>　　<strong>第四：随便服用药物</strong></p>\r\n\r\n<p>　　用<strong>避孕药</strong>来除<strong>青春痘</strong>，或用避孕药让乳房变丰满的做法都是不可取的。</p>\r\n\r\n<p>　　避孕药的主要成分是雌<strong>激素</strong>和孕激素，长期服用会打乱女性的内分泌平衡，造成月经不调，这样只会使胸部越来越小。</p>\r\n\r\n<p>&nbsp;</p>\r\n'),
(183, 183, '<p>反倒是</p>\r\n'),
(184, 184, '<p>反倒是所所所所所所所所所所所所所所所所所所反倒是56777</p>\r\n'),
(185, 185, '<p><span style=\"font-size:28px\">反倒是多少发的所发生的反倒是反倒是分为五额外任务二</span></p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `blog_title`
--

CREATE TABLE `blog_title` (
  `id` int(9) NOT NULL,
  `user_id` int(9) NOT NULL,
  `catid` int(2) NOT NULL DEFAULT '1',
  `title` text CHARACTER SET utf8 NOT NULL,
  `summary` text CHARACTER SET utf8 NOT NULL,
  `imgurl` text CHARACTER SET utf8 NOT NULL,
  `click` int(1) NOT NULL DEFAULT '0',
  `readnum` int(9) NOT NULL,
  `zannum` int(9) NOT NULL DEFAULT '0',
  `del` int(1) NOT NULL DEFAULT '0',
  `created_at` int(10) NOT NULL,
  `updated_at` int(10) NOT NULL,
  `cj_url` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_title`
--

INSERT INTO `blog_title` (`id`, `user_id`, `catid`, `title`, `summary`, `imgurl`, `click`, `readnum`, `zannum`, `del`, `created_at`, `updated_at`, `cj_url`) VALUES
(179, 0, 1, '客服', '真诚为您服务', 'http://127.0.0.1/azcms/uploads/201711/10/vcevv.png', 0, 146, 2, 0, 1462313100, 1510323964, ''),
(180, 0, 1, '蜜汁酸爽！妹子直接蒙圈了', '蜜汁酸爽！妹子直接蒙圈了', 'upload/20160504/351r6.jpg', 1, 157, 2, 0, 1462309200, 1462352287, ''),
(176, 0, 1, '酸溜溜的对唱：好摸不过少妇腿~', '好摸不过少妇腿！', 'upload/20160503/lwmez.jpg', 1, 240, 4, 1, 1462158000, 1462236105, ''),
(177, 0, 1, '美女在电梯出口洗澡 汉子看呆了！', '美女在电梯出口洗澡 汉子看呆了！', 'upload/20160503/zj5mp.jpg', 0, 169, 2, 1, 1462237200, 1462237065, ''),
(178, 0, 1, '神恶搞！美女坐电梯 乖乖！究竟发生了神马？', '然在电梯里面激情相吻，还摆出各种姿势，真是让大家情何以堪不忍直视啊', 'http://127.0.0.1/azcms/uploads/201711/10/vcevv.png', 0, 81, 1, 1, 1462241100, 1510323945, ''),
(174, 0, 1, '胸部变小的元凶', '适当的运动有助于乳房的健美，过量的运动或运动时不注意内衣穿戴则可能伤害乳房。', 'upload/image/20160502/1462197169300957.jpg', 0, 154, 3, 1, 1462075500, 1510055446, ''),
(175, 0, 1, '做个有味道的女人，玩转你的社交圈', '在众多的人际交往中，女人起着关键的作用。和谐幸福的家庭往往是有一个好女人 ...', 'upload/image/20160502/1462199196591204.jpg', 0, 120, 1, 1, 1462154700, 1510055435, ''),
(181, 0, 1, '新用户夺宝宝典', '精彩夺宝，从这里开始', 'http://www.ty185.cn/uploads/201706/04/vwj2b.png', 0, 21, 1, 0, 1495022707, 1496535623, ''),
(182, 0, 1, '首充返利100%', '充多少送多少', 'http://127.0.0.1/azcms/uploads/201711/06/fwuow.jpg', 0, 12, 0, 0, 1495022712, 1509971096, ''),
(183, 0, 1, '萌娃投票343244324', '反倒是', 'uploads/article.jpg', 1, 1, 0, 0, 1509883860, 1509889673, ''),
(184, 0, 1, '萌娃投票1', '32131312大声道撒4569897', 'http://127.0.0.1/azcms/uploads/201711/19/8babn.png', 0, 1, 0, 0, 1511442710, 1511183032, ''),
(185, 0, 1, '法第三方士大夫1231321', '佛挡杀佛', 'uploads/article.jpg', 0, 1, 0, 0, 1509970285, 1511177823, '');

-- --------------------------------------------------------

--
-- Table structure for table `blog_tousu`
--

CREATE TABLE `blog_tousu` (
  `id` int(11) NOT NULL,
  `tousu_name` text NOT NULL,
  `tousu_num` int(11) NOT NULL,
  `tousu_url` text NOT NULL,
  `date` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blog_tousu`
--

INSERT INTO `blog_tousu` (`id`, `tousu_name`, `tousu_num`, `tousu_url`, `date`) VALUES
(1, '欺诈', 0, '', 1462090840),
(2, '色情', 8, '', 1462090840),
(3, '政治谣言', 0, '', 1462090840),
(4, '常识性谣言', 7, '', 1462090840),
(5, '诱导分享', 3, '', 1462090840),
(6, '恶意营销', 2, '', 1462090840),
(7, '营私信息收集抄袭公众号文章', 2, '', 1462090840),
(8, '其他侵权类(冒名、诽谤、抄袭)', 1, '', 1462090840),
(9, '违规声明原创', 3, '', 1462090840);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_items`
--

CREATE TABLE `tbl_items` (
  `itemId` int(11) NOT NULL,
  `itemHeader` varchar(512) NOT NULL COMMENT 'Heading',
  `itemSub` varchar(1021) NOT NULL COMMENT 'sub heading',
  `itemDesc` text COMMENT 'content or description',
  `itemImage` varchar(80) DEFAULT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `createdBy` int(11) NOT NULL,
  `createdDtm` datetime NOT NULL,
  `updatedDtm` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_items`
--

INSERT INTO `tbl_items` (`itemId`, `itemHeader`, `itemSub`, `itemDesc`, `itemImage`, `isDeleted`, `createdBy`, `createdDtm`, `updatedDtm`, `updatedBy`) VALUES
(1, 'jquery.validation.js', 'Contribution towards jquery.validation.js', 'jquery.validation.js is the client side javascript validation library authored by Jörn Zaefferer hosted on github for us and we are trying to contribute to it. Working on localization now', 'validation.png', 0, 1, '2015-09-02 00:00:00', NULL, NULL),
(2, 'CodeIgniter User Management', 'Demo for user management system', 'This the demo of User Management System (Admin Panel) using CodeIgniter PHP MVC Framework and AdminLTE bootstrap theme. You can download the code from the repository or forked it to contribute. Usage and installation instructions are provided in ReadMe.MD', 'cias.png', 0, 1, '2015-09-02 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reset_password`
--

CREATE TABLE `tbl_reset_password` (
  `id` bigint(20) NOT NULL,
  `email` varchar(128) NOT NULL,
  `activation_id` varchar(32) NOT NULL,
  `agent` varchar(512) NOT NULL,
  `client_ip` varchar(32) NOT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `createdBy` bigint(20) NOT NULL DEFAULT '1',
  `createdDtm` datetime NOT NULL,
  `updatedBy` bigint(20) DEFAULT NULL,
  `updatedDtm` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `roleId` tinyint(4) NOT NULL COMMENT 'role id',
  `role` varchar(50) NOT NULL COMMENT 'role text'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`roleId`, `role`) VALUES
(1, 'System Administrator'),
(2, 'Manager'),
(3, 'Employee');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `userId` int(11) NOT NULL,
  `email` varchar(128) NOT NULL COMMENT 'login email',
  `password` varchar(128) NOT NULL COMMENT 'hashed login password',
  `name` varchar(128) DEFAULT NULL COMMENT 'full name of user',
  `mobile` varchar(20) DEFAULT NULL,
  `roleId` tinyint(4) NOT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `createdBy` int(11) NOT NULL,
  `createdDtm` datetime NOT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `updatedDtm` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`userId`, `email`, `password`, `name`, `mobile`, `roleId`, `isDeleted`, `createdBy`, `createdDtm`, `updatedBy`, `updatedDtm`) VALUES
(1, 'admin@codeinsect.com', '$2y$10$WQQRBQDkxV/98bqK.24Dp.uMVS6KcztVqdwwTrOBLIWLSeSqE2gii', 'admin', '9890098900', 1, 0, 0, '2015-07-01 18:56:49', 1, '2017-03-03 12:08:39'),
(2, 'manager@codeinsect.com', '$2y$10$quODe6vkNma30rcxbAHbYuKYAZQqUaflBgc4YpV9/90ywd.5Koklm', 'Manager', '9890098444', 2, 0, 1, '2016-12-09 17:49:56', 1, '2017-11-16 17:00:30'),
(3, 'employee@codeinsect.com', '$2y$10$M3ttjnzOV2lZSigBtP0NxuCtKRte70nc8TY5vIczYAQvfG/8syRze', 'Employee', '9890098900', 3, 0, 1, '2016-12-09 17:50:22', 1, '2017-11-19 13:56:49'),
(4, '89064844@qq.com', '$2y$10$1Q3py/ZxdPdaDAw8GjmJ5eLH5okNM1Ii9lPeNvXb595YQ4tG/pfuO', 'Dfsfs12356', '9890098333', 3, 1, 1, '2017-11-04 10:44:35', 1, '2017-11-04 10:56:39'),
(5, '89064844@qq.com', '$2y$10$kcgc7Nx3HXXZh8wNrILqCOYD395jiBb9Ak9o6a1quhQ1.VG9gALYG', 'Dfsfs1234', '9890098333', 3, 0, 1, '2017-11-04 10:57:41', 1, '2017-11-17 15:42:14'),
(6, 'admin123@codeinsect.com', '$2y$10$Ligv97OUGeB7DOTlHPCHNu3X4DzUzmKBhmF.cqpJ/CQpe1WVSOJMW', 'Dfsfs123', '1234567890', 3, 0, 1, '2017-11-19 13:53:28', 1, '2017-11-19 13:53:35'),
(7, '89064844@qq.com', '$2y$10$5E7MrRPUGXWaAH9WAkAJNOs1bsa3pHFLyr.bSAgXQ/82usC8tPF1.', 'Dfsfs123', '1234567897', 2, 0, 1, '2017-11-20 19:32:32', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE `vote` (
  `id` int(11) NOT NULL,
  `catid` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `imgurl` text NOT NULL,
  `info` text NOT NULL COMMENT '投票介绍',
  `infosm` text NOT NULL COMMENT '投票说明',
  `infojp` text NOT NULL COMMENT '奖品说明',
  `statdate` int(11) NOT NULL,
  `enddate` int(11) NOT NULL,
  `cknums` tinyint(3) NOT NULL DEFAULT '1' COMMENT '最多可选择，默认1',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `votelimit` tinyint(4) DEFAULT '1' COMMENT '投票次数限制'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vote`
--

INSERT INTO `vote` (`id`, `catid`, `title`, `imgurl`, `info`, `infosm`, `infojp`, `statdate`, `enddate`, `cknums`, `status`, `votelimit`) VALUES
(18, 1, '萌娃投票', '', '萌娃投票萌娃投票萌娃投票12312321321', '', '', 1509878700, 1512038700, 1, 0, 0),
(19, 2, '萌娃投票21313245677', 'http://127.0.0.1/azcms/uploads/201711/08/iu7kl.jpg', '<p>佛挡杀佛</p>\r\n', '', '', 1510144454, 1510922055, 0, 0, 0),
(20, 1, '标题投票说明', 'http://127.0.0.1/azcms/uploads/201711/08/iu7kl.jpg', '<p>1231321</p>\r\n', '', '', 1511611879, 1512043879, 0, 0, 0),
(21, 2, '萌娃投票2213213123', 'http://127.0.0.1/azcms/uploads/201711/08/iu7kl.jpg', '<p>等等撒</p>\r\n', '<p>投票说明</p>\r\n', '<p>奖品说明</p>\r\n', 1510143097, 1510143101, 1, 0, 0),
(22, 2, '萌娃投票更新测试3', 'http://127.0.0.1/azcms/uploads/201711/08/iu7kl.jpg', '<p>等等撒1232312312更新测试</p>\r\n', '<p>更新测试</p>\r\n', '<p>更新测试</p>\r\n', 1510143097, 1510143101, 1, 0, 0),
(23, 2, '萌娃投票更新测试12', 'http://127.0.0.1/azcms/uploads/201711/08/iu7kl.jpg', '<p>等等撒1232312312更新测试</p>\r\n', '<p>更新测试</p>\r\n', '<p>更新测试</p>\r\n', 1510143097, 1510143101, 0, 0, 0),
(24, 1, '萌娃投票更新测试1', 'http://127.0.0.1/azcms/uploads/201711/08/iu7kl.jpg', '<p>等等撒1232312312更新测试</p>\r\n', '<p>更新测试</p>\r\n', '<p>更新测试</p>\r\n', 1510143097, 1510143101, 0, 0, 0),
(25, 2, '萌娃投票更新测试21213', 'http://127.0.0.1/azcms/uploads/201711/08/iu7kl.jpg', '<p>等等撒1232312312更新测试更新测试21213</p>\r\n', '<p>更新测试更新测试21213</p>\r\n', '<p>更新测试更新测试21213</p>\r\n', 1510143097, 1510143101, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vote_item`
--

CREATE TABLE `vote_item` (
  `id` int(11) NOT NULL,
  `vid` int(11) NOT NULL COMMENT 'vote_id',
  `item` varchar(50) NOT NULL,
  `dcount` int(11) DEFAULT '0' COMMENT '取消关注失去票数',
  `vcount` int(11) NOT NULL,
  `startpicurl` varchar(200) NOT NULL DEFAULT '',
  `tourl` varchar(200) NOT NULL DEFAULT '',
  `rank` tinyint(4) NOT NULL COMMENT '排序',
  `intro` text NOT NULL COMMENT '选项介绍',
  `status` smallint(2) NOT NULL DEFAULT '0' COMMENT '审核状态 0-未审核 1-审核同感 2 锁定',
  `wechat_id` varchar(100) DEFAULT NULL COMMENT '微信id',
  `addtime` int(10) DEFAULT NULL COMMENT '添加时间',
  `lockinfo` varchar(260) DEFAULT NULL COMMENT '锁定回复'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vote_item`
--

INSERT INTO `vote_item` (`id`, `vid`, `item`, `dcount`, `vcount`, `startpicurl`, `tourl`, `rank`, `intro`, `status`, `wechat_id`, `addtime`, `lockinfo`) VALUES
(2, 18, 'ck123', 0, 389, 'uploads/article.jpg,http://127.0.0.1/azcms/uploads/201711/08/iu7kl.jpg', '150925805456', 1, '<p>dfsfds12123</p>\r\n', 1, NULL, 1510119177, NULL),
(3, 25, 'ck123test123', 0, 1, 'http://127.0.0.1/azcms/uploads/201711/08/iu7kl.jpg', '223344567', 1, '<p>cfsdsaa1223456790</p>\r\n', 0, NULL, NULL, NULL),
(4, 24, '32', 0, 2, 'http://127.0.0.1/azcms/uploads/201711/08/iu7kl.jpg', '22', 1, '<p>222</p>\r\n', 0, NULL, 1510295309, NULL),
(5, 25, 'testck', 0, 250, 'http://127.0.0.1/azcms/uploads/201711/08/iu7kl.jpg', '123456', 2, '<p>fffffffffff</p>\r\n', 0, NULL, 1510302728, NULL),
(6, 25, 'ck123333', 0, 45, 'http://127.0.0.1/azcms/uploads/201711/08/iu7kl.jpg', '3244', 3, '<p>ffffff</p>\r\n', 0, NULL, 1510302933, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vote_record`
--

CREATE TABLE `vote_record` (
  `id` int(11) NOT NULL,
  `item_id` varchar(50) NOT NULL COMMENT '投票项 1,2,3,',
  `vid` int(11) NOT NULL,
  `wecha_id` varchar(100) NOT NULL,
  `touched` tinyint(4) NOT NULL,
  `touch_time` int(11) NOT NULL COMMENT '投票日期',
  `token` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vote_record`
--

INSERT INTO `vote_record` (`id`, `item_id`, `vid`, `wecha_id`, `touched`, `touch_time`, `token`) VALUES
(98, '60', 0, 'odO_fjjBbj6HIW3s8CYhBDoK_p-4', 1, 1417491684, 'Arraytoken'),
(102, '60', 0, 'odO_fjjBbj6HIW3s8CYhBDoK_p-4', 1, 1417491737, 'Arraytoken');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article_fileimg`
--
ALTER TABLE `article_fileimg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aid` (`id`);

--
-- Indexes for table `blog_category`
--
ALTER TABLE `blog_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_conment`
--
ALTER TABLE `blog_conment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `blog_title`
--
ALTER TABLE `blog_title`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_tousu`
--
ALTER TABLE `blog_tousu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_items`
--
ALTER TABLE `tbl_items`
  ADD PRIMARY KEY (`itemId`);

--
-- Indexes for table `tbl_reset_password`
--
ALTER TABLE `tbl_reset_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`roleId`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `vote` ADD FULLTEXT KEY `title` (`title`);

--
-- Indexes for table `vote_item`
--
ALTER TABLE `vote_item`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `vote_record`
--
ALTER TABLE `vote_record`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article_fileimg`
--
ALTER TABLE `article_fileimg`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=546;
--
-- AUTO_INCREMENT for table `blog_category`
--
ALTER TABLE `blog_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `blog_conment`
--
ALTER TABLE `blog_conment`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;
--
-- AUTO_INCREMENT for table `blog_title`
--
ALTER TABLE `blog_title`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;
--
-- AUTO_INCREMENT for table `blog_tousu`
--
ALTER TABLE `blog_tousu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tbl_items`
--
ALTER TABLE `tbl_items`
  MODIFY `itemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_reset_password`
--
ALTER TABLE `tbl_reset_password`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `roleId` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'role id', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `vote`
--
ALTER TABLE `vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `vote_item`
--
ALTER TABLE `vote_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `vote_record`
--
ALTER TABLE `vote_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
