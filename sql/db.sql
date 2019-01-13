SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for article
-- ----------------------------
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `short_description` text,
  `content` text NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `article_category_id` (`category_id`),
  CONSTRAINT `article_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for article_has_author
-- ----------------------------
CREATE TABLE `article_has_author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `author_id` int(9) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `article_has_author_unique` (`article_id`,`author_id`),
  KEY `article_has_author_author_id` (`author_id`),
  CONSTRAINT `article_has_author_article_id` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
  CONSTRAINT `article_has_author_author_id` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for article_has_tag
-- ----------------------------
CREATE TABLE `article_has_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `tag_id` int(9) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `article_has_tag_unique` (`article_id`,`tag_id`),
  KEY `article_has_tag_tag_id` (`tag_id`),
  CONSTRAINT `article_has_tag_article_id` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
  CONSTRAINT `article_has_tag_tag_id` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for article_has_user
-- ----------------------------
CREATE TABLE `article_has_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(9) NOT NULL,
  `article_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `article_has_user_unique` (`user_id`,`article_id`),
  KEY `article_has_user_article_id` (`article_id`),
  CONSTRAINT `article_has_user_article_id` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
  CONSTRAINT `article_has_user_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for author
-- ----------------------------
CREATE TABLE `author` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `about` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for category
-- ----------------------------
CREATE TABLE `category` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tag
-- ----------------------------
CREATE TABLE `tag` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for user
-- ----------------------------
CREATE TABLE `user` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `wallet` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `article` VALUES ('1', 'Healthy dish you can preapare quickly', 'Nulla vestibulum nec, dignissim in, cursus molestie. Donec est. Integer neque quis porta nisl. Nam pulvinar, quam molestie ultricies vitae.', 'Lorem ipsum primis in erat consectetuer viverra semper orci, viverra lacinia. Vestibulum aliquam lacinia, risus nunc, placerat ornare dapibus. Aenean et netus et velit. Duis hendrerit magna sapien, tempus ac, dictum sed, vestibulum vehicula. Etiam leo at risus commodo ante. Curabitur elit. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Morbi sem dolor eu wisi. Suspendisse at lorem non orci. Proin gravida sit amet nunc volutpat a, pellentesque sed, sodales pede. Duis vulputate nunc. Praesent tortor. Donec vitae felis. Mauris leo. Donec molestie a, tellus. Suspendisse at magna. Etiam vestibulum tristique vitae, lectus. Nam suscipit, risus velit, a dolor lacus, congue quis, dictum id, eleifend purus scelerisque odio sit amet felis odio vitae fringilla fringilla eget, nulla. Nunc justo ac posuere cubilia Curae, Sed vehicula wisi, aliquam arcu. Sed feugiat sapien, congue odio non arcu. Nam risus et ultrices iaculis. Curabitur arcu elit, dictum ut, diam.', '0.00', '1');
INSERT INTO `article` VALUES ('2', 'Germanium-based CPU cores', 'Cum sociis natoque penatibus et ultrices urna, pellentesque tincidunt, velit in dui. Lorem ipsum aliquet elit. Mauris luctus et magnis.', 'Curae, Mauris vel risus. Nulla facilisi. Nullam et lacus a mauris. Nunc ultricies tortor id tortor quis massa ac ipsum. Proin cursus, mi quis viverra elit. Nunc consectetuer adipiscing ornare. Nam molestie. Quisque pharetra, urna ut urna mauris, consectetuer nisl. Fusce mollis, orci a augue. Nam scelerisque pede ac nisl. Morbi fermentum leo facilisis dui ligula, quis eleifend eget, nunc. Nunc velit non sem. Nam lorem eu eros. Pellentesque laoreet metus vitae tellus consectetuer adipiscing quam sagittis eget, bibendum ac, ultricies vehicula, dui gravida vitae, lectus. Curabitur commodo. Curabitur condimentum magna sapien, nec tellus. Quisque nulla. Aenean massa molestie justo euismod scelerisque vel, ipsum. Nunc accumsan at, egestas risus libero, posuere cubilia Curae, In accumsan augue nec turpis quis euismod nibh, dignissim dolor eu elementum quis, ornare at, bibendum porttitor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Curabitur eu dui quis justo. Vestibulum enim.', '1.50', '2');
INSERT INTO `article` VALUES ('3', 'A Pyramid? Found one more!', 'Morbi vitae dui odio nonummy eget, dignissim porttitor, arcu nunc ut erat. Duis ut aliquet ipsum sit amet, ante. Morbi.', 'Aenean feugiat nec, nibh. Donec dolor nibh, dignissim tempor, pede urna mi, nec sapien mauris lacus a blandit malesuada. Suspendisse vel leo. In euismod. Integer lacinia id, sapien. Maecenas sapien quis consectetuer dignissim, lorem fermentum mi, viverra ligula. Phasellus ac lectus. Sed adipiscing risus at tortor. Integer neque ut venenatis augue quis pellentesque consectetuer, augue at consequat tortor, pretium vitae, tortor. Proin dui at sapien. Maecenas imperdiet convallis. Fusce blandit justo, posuere cubilia Curae, Vivamus semper quis, tellus. Aliquam nulla. Aliquam ultricies lobortis sed, ullamcorper varius nunc, tempus nunc. Ut sodales, dictum sed, aliquet elit, varius risus metus gravida non, nunc. Sed aliquet quis, ornare quam. Vestibulum ullamcorper augue, sagittis urna. Donec odio sit amet, sodales nulla. Phasellus urna fringilla vel, ornare bibendum sapien vitae lectus vulputate faucibus. Sed sagittis nibh ultricies leo. In urna. Proin imperdiet dignissim volutpat at, pretium pellentesque. Praesent gravida iaculis odio, sagittis lacus et augue.', '5.75', '3');
INSERT INTO `article` VALUES ('4', 'The prosecution just couldn\'t handle the truth', 'Vestibulum convallis nisl, sollicitudin sed, fermentum facilisis. Maecenas fermentum quis, velit. Duis lobortis, varius sit amet, felis. Pellentesque porta tincidunt.', 'Mauris vestibulum ligula. Ut sagittis, nunc semper feugiat. Cum sociis natoque penatibus et eros orci luctus et lectus. Curabitur placerat, nisl ac odio eget velit wisi, ullamcorper mauris. Etiam ac ligula. Lorem ipsum aliquet feugiat nec, scelerisque arcu. Sed mauris sit amet, vulputate luctus. Sed fringilla sollicitudin, odio vitae velit sit amet, massa. Nunc gravida. Suspendisse est. Lorem ipsum dolor ut magna. Quisque vestibulum. Nulla consequat sed, ullamcorper ac, laoreet a, ligula. Aenean non felis. Pellentesque at ipsum. Aliquam consequat eu, luctus bibendum. Nulla eleifend purus consectetuer massa. Proin sed porta turpis velit, scelerisque odio eget augue commodo volutpat quam nibh faucibus in, dapibus sit amet, iaculis ante, tincidunt quis, ultricies porta. Vivamus pede. Vestibulum aliquam enim. Nunc leo. Phasellus ipsum dolor placerat vehicula elit ac turpis egestas. Mauris rutrum, enim sed massa in accumsan congue. Donec vitae libero at purus. Sed nonummy id, elit. Curabitur fringilla ante sodales eu.', '0.00', '4');
INSERT INTO `article` VALUES ('5', 'A walk to the park', 'Lorem ipsum dolor sapien accumsan congue. Donec ullamcorper, lorem hendrerit wisi. Vestibulum turpis egestas. Aenean posuere elementum odio fermentum suscipit.', 'Nullam aliquet. Vestibulum cursus vitae, sollicitudin mauris sed viverra elit viverra quis, faucibus orci quis nibh. Curabitur ultrices urna, pellentesque leo. Aenean congue porta, metus sed est. Quisque ut mauris sed eros malesuada vitae, dapibus vel, orci. Sed mauris turpis, molestie turpis sagittis libero. Morbi pede. In quis nibh vel lectus. Nullam rutrum et, faucibus orci vitae dui eget sem tincidunt in, tristique eget, aliquam purus. Integer eget tempus ornare arcu quis nibh. Phasellus lorem tempus nunc. Etiam dictum ut, pulvinar interdum. Quisque cursus, mi libero, id rutrum nulla, auctor scelerisque, ante nec quam. Sed porttitor, quam risus, pellentesque at, metus. Vestibulum ante in nonummy id, semper quis, aliquam arcu. In molestie lorem velit eleifend quam nunc, vitae fringilla mi, eu felis augue id leo vitae est sit amet felis mollis pulvinar. Nulla euismod, quam at arcu. Etiam nibh eu urna. Aenean bibendum vitae, vulputate adipiscing. Mauris eget lectus felis.', '0.00', '5');
INSERT INTO `article_has_author` VALUES ('1', '1', '1');
INSERT INTO `article_has_author` VALUES ('3', '2', '2');
INSERT INTO `article_has_author` VALUES ('4', '3', '3');
INSERT INTO `article_has_author` VALUES ('5', '4', '4');
INSERT INTO `article_has_author` VALUES ('6', '5', '5');
INSERT INTO `article_has_tag` VALUES ('2', '1', '1');
INSERT INTO `article_has_tag` VALUES ('3', '1', '2');
INSERT INTO `article_has_tag` VALUES ('4', '1', '3');
INSERT INTO `article_has_tag` VALUES ('7', '2', '4');
INSERT INTO `article_has_tag` VALUES ('9', '2', '5');
INSERT INTO `article_has_tag` VALUES ('10', '2', '6');
INSERT INTO `article_has_tag` VALUES ('11', '3', '4');
INSERT INTO `article_has_tag` VALUES ('15', '3', '5');
INSERT INTO `article_has_tag` VALUES ('12', '3', '7');
INSERT INTO `article_has_tag` VALUES ('14', '3', '8');
INSERT INTO `article_has_tag` VALUES ('16', '3', '9');
INSERT INTO `article_has_tag` VALUES ('17', '4', '10');
INSERT INTO `article_has_tag` VALUES ('18', '4', '11');
INSERT INTO `article_has_tag` VALUES ('21', '4', '12');
INSERT INTO `article_has_tag` VALUES ('22', '5', '1');
INSERT INTO `article_has_tag` VALUES ('23', '5', '9');
INSERT INTO `author` VALUES ('1', 'Gordon', 'Ramsay', null);
INSERT INTO `author` VALUES ('2', 'Roger', 'Penrose', null);
INSERT INTO `author` VALUES ('3', 'Henry', 'Walton Jones III', null);
INSERT INTO `author` VALUES ('4', 'Johann', 'Voynich', null);
INSERT INTO `author` VALUES ('5', 'Martha', 'Stewart', null);
INSERT INTO `category` VALUES ('1', 'Health');
INSERT INTO `category` VALUES ('2', 'Science');
INSERT INTO `category` VALUES ('3', 'Archaeology');
INSERT INTO `category` VALUES ('4', 'Miscelenous');
INSERT INTO `category` VALUES ('5', 'Daily life');
INSERT INTO `tag` VALUES ('5', 'breakthrough');
INSERT INTO `tag` VALUES ('7', 'digsite');
INSERT INTO `tag` VALUES ('1', 'everyday');
INSERT INTO `tag` VALUES ('3', 'fit');
INSERT INTO `tag` VALUES ('11', 'funny');
INSERT INTO `tag` VALUES ('9', 'habits');
INSERT INTO `tag` VALUES ('2', 'healthy');
INSERT INTO `tag` VALUES ('10', 'law');
INSERT INTO `tag` VALUES ('12', 'mistake');
INSERT INTO `tag` VALUES ('4', 'research');
INSERT INTO `tag` VALUES ('8', 'ruins');
INSERT INTO `tag` VALUES ('6', 'technology');
INSERT INTO `user` VALUES ('1', 'sheldon', 'shelly', '50.00');
INSERT INTO `user` VALUES ('2', 'howard', 'bernie', '0.00');
INSERT INTO `user` VALUES ('3', 'leonard', 'penny', '5.00');
INSERT INTO `user` VALUES ('4', 'amy', 'wildebeast', '0.00');
INSERT INTO `user` VALUES ('5', 'penny', 'leonard', '10.00');
INSERT INTO `user` VALUES ('6', 'rajesh', 'password', '0.00');
