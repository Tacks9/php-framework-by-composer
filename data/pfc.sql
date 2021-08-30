--- 创建数据库 ---
create database pfc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;


--- 创建表 ---
DROP TABLE IF EXISTS `article`;

CREATE TABLE `article` (
  `id`      int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title`   varchar(255) DEFAULT '' COMMENT '文章标题' COLLATE 'utf8mb4_general_ci',
  `link`    varchar(255) DEFAULT '' COMMENT '文章链接' COLLATE 'utf8mb4_general_ci',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--- 创建用户 ---
CREATE USER 'tacks'@'%' IDENTIFIED BY '123456';


--- 授权 ---
GRANT ALL ON pfc.* TO 'tacks'@'%';

--- 刷新 ---
flush privileges;


--- 导入数据 ---
INSERT INTO `article` (`title`, `link`) VALUES ('直播回看丨贵州公安英模先进事迹报告会', 'http://mp.weixin.qq.com/s?__biz=MzA4NjQ1NDU2Mg==&mid=2695499963&idx=2&sn=9e99176f4f0de2d08c688334b47ddcfc&chksm=ba96c8f68de141e09513a9b6065b92f5cc4215292f4e56e2ff0e3c6874863ec65366b5a9471a#rd');
INSERT INTO `article` (`title`, `link`) VALUES ('暴雨、山洪蓝色预警连发！四川的周末和雨҈雨҈雨҈杠上了', 'http://mp.weixin.qq.com/s?__biz=MzI0MTEwNTIyMA==&mid=2650817774&idx=1&sn=20e700441187f4fab96d6f2b65d3e7ff&chksm=f2e444c5c593cdd3e142e449a9b5d92a72e30bbc9caeb98ce88b8722f8b0f17fe10f4be8b9f4#rd');
INSERT INTO `article` (`title`, `link`) VALUES ('2021年海南省全民健身运动会万宁分会场活动正式启幕', 'http://mp.weixin.qq.com/s?__biz=MzA4ODkzNDcyNw==&mid=2653970739&idx=4&sn=a0eb1edff100c44c125d043417fafe43&chksm=8be6511bbc91d80d00a75934054593bc8e94498484aea27eb3cfc610b17775574e474be03bbe#rd');
INSERT INTO `article` (`title`, `link`) VALUES ('明日，成都国际车展开幕！最全出行攻略看这里→', 'http://mp.weixin.qq.com/s?__biz=MzA4MTg1NzYyNQ==&mid=2652249713&idx=2&sn=3a2f3963fcbb178fb85e31196d7fdc1e&chksm=846c2347b31baa510dadd91bf842c805aaea5ba0957c327384a2fae8f9bfa672e1856d7a5917#rd');
INSERT INTO `article` (`title`, `link`) VALUES ('预告丨今日20：30，《万宁请您来投诉》首期将准时上线→', 'http://mp.weixin.qq.com/s?__biz=MzA4ODkzNDcyNw==&mid=2653970739&idx=2&sn=51d9eff23ff57e0d36b6891d55081bcf&chksm=8be6511bbc91d80d3494cf714a90b9f1c61c90c3dc77c4b644f455247e7383fc58c95323a770#rd');
INSERT INTO `article` (`title`, `link`) VALUES ('查堵点、破难题、促发展丨主动探索优化行政审批流程 市行政审批服务局2股室和3个人获表彰', 'http://mp.weixin.qq.com/s?__biz=MzA4ODkzNDcyNw==&mid=2653970739&idx=5&sn=49df2109ed3e195c0df7306f85fdee8a&chksm=8be6511bbc91d80d55b28c071f9e9e1f37b49101ed8ec2e8e15a1beb3140bbadec7e0885fc04#rd');
INSERT INTO `article` (`title`, `link`) VALUES ('【关注】事关课后托管，湖北多地最新通知！', 'http://mp.weixin.qq.com/s?__biz=MzA5MzY2MDkzOQ==&mid=2650700011&idx=2&sn=4f743eb2898f325d1b838aaab91e1ff9&chksm=8850aa8fbf2723995b1cd1e9d2900c893cf586e4a88e0df33176bd2242adaf086d2e00cde14f#rd');
INSERT INTO `article` (`title`, `link`) VALUES ('大唐万宁燃气电厂工程项目启动验收委员会首次会议暨1号机组整套启动试运会议顺利召开', 'http://mp.weixin.qq.com/s?__biz=MzA4ODkzNDcyNw==&mid=2653970739&idx=3&sn=1bf18e92bf36d38322b63d06b7f4972c&chksm=8be6511bbc91d80df91a70f3aee18454dac3ebde923031702342cee98ef7ba8189256664d1e4#rd');
INSERT INTO `article` (`title`, `link`) VALUES ('万宁召开十三届市委理论学习中心组第117次（扩大）学习会议', 'http://mp.weixin.qq.com/s?__biz=MzA4ODkzNDcyNw==&mid=2653970739&idx=1&sn=c73d226da79991779e78bcf9b3a88390&chksm=8be6511bbc91d80dc5ed6a2126b3d4c0edcd2361b51a7ca688fa42d84080d742aecd7f3de9d0#rd');
INSERT INTO `article` (`title`, `link`) VALUES ('公开招聘！这次的岗位与“熊猫”、“机器人”有关', 'http://mp.weixin.qq.com/s?__biz=MzA4MTg1NzYyNQ==&mid=2652249713&idx=1&sn=ca2db5db9f24794f1e98bfe040f93e96&chksm=846c2347b31baa5186bd57fdd11ee039ad7acf5837731d00949651c08984d0a54731e9cd862e#rd');
INSERT INTO `article` (`title`, `link`) VALUES ('“三步走”推进法官进网格 融入基层社会治理格局', 'http://mp.weixin.qq.com/s?__biz=MzAxNzM3Mjk1OQ==&mid=2652914180&idx=2&sn=878a14f5f5719ca08c8701a3d11035ea&chksm=80326074b745e962fc572220e11c34726769b030cbf45e5f695c46d086a966c55517c49674f8#rd');
INSERT INTO `article` (`title`, `link`) VALUES ('点亮开学季，你开学我护航，站好“护学岗” | 开学季', 'http://mp.weixin.qq.com/s?__biz=MzA4NjQ1NDU2Mg==&mid=2695499963&idx=3&sn=b9a416c1e6bba28c231887749c04ebe2&chksm=ba96c8f68de141e0a5ff0568dd21ca8d8cf739764cc95096de349baa98ebf3966a1fe5de919c#rd');
INSERT INTO `article` (`title`, `link`) VALUES ('偶像选秀频翻车，选秀到底该选什么样的偶像？', 'http://mp.weixin.qq.com/s?__biz=MjM5OTU4Nzc0Mg==&mid=2658734681&idx=1&sn=3b4b5e9324aff7d3dc78533cde18955b&chksm=bcb488a88bc301be72c616d62e30a1783dbe720d59d99374c7f7a02964fe244ea42a49333f8d#rd');
INSERT INTO `article` (`title`, `link`) VALUES ('7项一等奖！南农学子在这项赛事中创佳绩！', 'http://mp.weixin.qq.com/s?__biz=MzA3OTIwNTUyNQ==&mid=2651142483&idx=1&sn=6a096e40ad8e6d85b5d39431785cc8e2&chksm=84469ca9b33115bf652c91615547495f4541ea85f47e15a8bd0215ed663aaff0cd7d6325a54a#rd');
INSERT INTO `article` (`title`, `link`) VALUES ('【学习贯彻市委十届十一次全会精神】贵阳市民宗委：凝聚力量 争创全国民族团结进步示范市', 'http://mp.weixin.qq.com/s?__biz=MzA5MzMxNjIzNQ==&mid=2654182516&idx=3&sn=e686a453ebc53a01943d5fbc9a6521ff&chksm=8b988990bcef0086cb2f682302dc860d3ddb08a534637dba9c79e26e8f8a7b3c777c0afafa1e#rd');
INSERT INTO `article` (`title`, `link`) VALUES ('扎心了！关于吃喝拉撒睡，有这10个习惯，可能影响寿命！小编连中好几条，你呢？', 'http://mp.weixin.qq.com/s?__biz=MjM5ODMxNzE2NQ==&mid=2651645591&idx=1&sn=bcd1307b14092abf4012f50b118d7189&chksm=bd34db958a435283808df03521a930b9474c904de7174df9a05de7a69f71037c499d91277228#rd');
INSERT INTO `article` (`title`, `link`) VALUES ('一图读懂丨全国公安机关深入学习贯彻习近平总书记重要训词精神电视电话会议', 'http://mp.weixin.qq.com/s?__biz=MzA4NjQ1NDU2Mg==&mid=2695499963&idx=1&sn=63f019f87a0b92218de6e74c66517732&chksm=ba96c8f68de141e08b130ae45502363c545dacdeddabc325678ee21b14b396136f707173cc27#rd');
INSERT INTO `article` (`title`, `link`) VALUES ('一部短片了解：助力“专精特新”中小企业发展，税务总局这样做', 'http://mp.weixin.qq.com/s?__biz=MjM5NTYxNDUwNQ==&mid=2650661867&idx=2&sn=95b51d168bcd185c2be9c9b8e6235cb9&chksm=befc99ad898b10bb0ac9e8496ea2e53f2dac1c620a40b9304fd4e73e72f4bf799af88c673e3b#rd');
INSERT INTO `article` (`title`, `link`) VALUES ('解锁贵阳人的幸福密码⑩：活力之城', 'http://mp.weixin.qq.com/s?__biz=MzA5MzMxNjIzNQ==&mid=2654182516&idx=6&sn=4c169676f53f45a64ffd48114b77566a&chksm=8b988990bcef0086b774b2e3f609bea8bddbbbc90c4fb1e0b7a0767de70998b7d6444a249521#rd');
INSERT INTO `article` (`title`, `link`) VALUES ('【全国文明城市巩固提升进行时】贵阳市“绿丝带”文明共建巡访团今日开展首次巡访', 'http://mp.weixin.qq.com/s?__biz=MzA5MzMxNjIzNQ==&mid=2654182516&idx=7&sn=fcb802c1e17ecb07dd29b261b040f76e&chksm=8b988990bcef0086239463409aceb9ab00160fb7ce0fd3b9a04747426d87d0fcfdf344ab6dfc#rd');
