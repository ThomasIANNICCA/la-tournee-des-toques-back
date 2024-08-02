-- Adminer 4.8.1 MySQL 10.11.3-MariaDB-1:10.11.3+maria~ubu2004 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `category` (`id`, `name`) VALUES
(9,	'Africain'),
(10,	'Asiatique'),
(11,	'Boissons'),
(12,	'Brunch'),
(13,	'Chinois'),
(14,	'Indien'),
(15,	'Italien'),
(17,	'Healthy'),
(18,	'Mexicain'),
(19,	'Oriental'),
(20,	'Américain'),
(21,	'Burgers'),
(22,	'Pizzas'),
(23,	'Crêpes'),
(24,	'Frites'),
(25,	'Nouilles'),
(26,	'Poké'),
(27,	'Méditerranéen');

DROP TABLE IF EXISTS `dish`;
CREATE TABLE `dish` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `truck_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `picture_name` varchar(255) DEFAULT 'dish.jpg',
  `description` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `menu_order` int(11) DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_957D8CB8C6957CCE` (`truck_id`),
  CONSTRAINT `FK_957D8CB8C6957CCE` FOREIGN KEY (`truck_id`) REFERENCES `truck` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `dish` (`id`, `truck_id`, `name`, `picture_name`, `description`, `price`, `menu_order`, `type`, `updated_at`) VALUES
(2,	6,	'dish numero 2',	'dish.jpg',	'Superbe plat bien présenté numéro 2',	18,	2,	'Dessert',	NULL),
(4,	3,	'dish numero 4',	'dish.jpg',	'Superbe plat bien présenté numéro 4',	9,	4,	'Plat',	NULL),
(5,	3,	'dish numero 5',	'dish.jpg',	'Superbe plat bien présenté numéro 5',	12,	5,	'Cocktails',	NULL),
(6,	4,	'dish numero 6',	'dish.jpg',	'Superbe plat bien présenté numéro 6',	23,	6,	'Cocktails',	NULL),
(7,	4,	'dish numero 7',	'dish.jpg',	'Superbe plat bien présenté numéro 7',	19,	7,	'Plat',	NULL),
(8,	7,	'dish numero 8',	'dish.jpg',	'Superbe plat bien présenté numéro 8',	15,	8,	'Plat',	NULL),
(9,	7,	'dish numero 9',	'dish.jpg',	'Superbe plat bien présenté numéro 9',	15,	9,	'Boisson',	NULL),
(10,	7,	'dish numero 10',	'dish.jpg',	'Superbe plat bien présenté numéro 10',	9,	10,	'Cocktails',	NULL),
(11,	2,	'dish numero 11',	'dish.jpg',	'Superbe plat bien présenté numéro 11',	7,	11,	'Cocktails',	NULL),
(12,	2,	'dish numero 12',	'dish.jpg',	'Superbe plat bien présenté numéro 12',	22,	12,	'Cocktails',	NULL),
(13,	3,	'dish numero 13',	'dish.jpg',	'Superbe plat bien présenté numéro 13',	21,	13,	'Boisson',	NULL),
(14,	7,	'dish numero 14',	'dish.jpg',	'Superbe plat bien présenté numéro 14',	22,	14,	'Plat',	NULL),
(16,	3,	'dish numero 16',	'dish.jpg',	'Superbe plat bien présenté numéro 16',	7,	16,	'Boisson',	NULL),
(17,	3,	'dish numero 17',	'dish.jpg',	'Superbe plat bien présenté numéro 17',	17,	17,	'Cocktails',	NULL),
(18,	7,	'dish numero 18',	'dish.jpg',	'Superbe plat bien présenté numéro 18',	11,	18,	'Entrée',	NULL),
(19,	3,	'dish numero 19',	'dish.jpg',	'Superbe plat bien présenté numéro 19',	20,	19,	'Entrée',	NULL),
(25,	7,	'dish numero 25',	'dish.jpg',	'Superbe plat bien présenté numéro 25',	15,	25,	'Dessert',	NULL),
(26,	2,	'dish numero 26',	'dish.jpg',	'Superbe plat bien présenté numéro 26',	19,	26,	'Dessert',	NULL),
(27,	6,	'dish numero 27',	'dish.jpg',	'Superbe plat bien présenté numéro 27',	21,	27,	'Plat',	NULL),
(29,	7,	'dish numero 29',	'dish.jpg',	'Superbe plat bien présenté numéro 29',	14,	29,	'Dessert',	NULL),
(31,	7,	'dish numero 31',	'dish.jpg',	'Superbe plat bien présenté numéro 31',	8,	31,	'Cocktails',	NULL),
(32,	2,	'dish numero 32',	'dish.jpg',	'Superbe plat bien présenté numéro 32',	18,	32,	'Entrée',	NULL),
(33,	3,	'dish numero 33',	'dish.jpg',	'Superbe plat bien présenté numéro 33',	9,	33,	'Plat',	NULL),
(34,	7,	'dish numero 34',	'dish.jpg',	'Superbe plat bien présenté numéro 34',	7,	34,	'Dessert',	NULL),
(35,	2,	'dish numero 35',	'dish.jpg',	'Superbe plat bien présenté numéro 35',	24,	35,	'Cocktails',	NULL),
(38,	4,	'dish numero 38',	'dish.jpg',	'Superbe plat bien présenté numéro 38',	22,	38,	'Cocktails',	NULL),
(42,	7,	'dish numero 42',	'dish.jpg',	'Superbe plat bien présenté numéro 42',	23,	42,	'Plat',	NULL),
(44,	2,	'dish numero 44',	'dish.jpg',	'Superbe plat bien présenté numéro 44',	20,	44,	'Dessert',	NULL),
(45,	3,	'dish numero 45',	'dish.jpg',	'Superbe plat bien présenté numéro 45',	18,	45,	'Plat',	NULL),
(46,	2,	'dish numero 46',	'dish.jpg',	'Superbe plat bien présenté numéro 46',	16,	46,	'Boisson',	NULL),
(50,	3,	'dish numero 50',	'dish.jpg',	'Superbe plat bien présenté numéro 50',	9,	50,	'Plat',	NULL);

DROP TABLE IF EXISTS `dish_tag`;
CREATE TABLE `dish_tag` (
  `dish_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`dish_id`,`tag_id`),
  KEY `IDX_64FF4A98148EB0CB` (`dish_id`),
  KEY `IDX_64FF4A98BAD26311` (`tag_id`),
  CONSTRAINT `FK_64FF4A98148EB0CB` FOREIGN KEY (`dish_id`) REFERENCES `dish` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_64FF4A98BAD26311` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `dish_tag` (`dish_id`, `tag_id`) VALUES
(5,	3),
(5,	4),
(6,	5),
(9,	5),
(10,	3),
(11,	2),
(12,	5),
(13,	2),
(16,	5),
(16,	6),
(18,	7),
(27,	5),
(31,	1),
(32,	7),
(33,	4),
(33,	6),
(35,	4),
(38,	4),
(42,	8),
(44,	5),
(45,	2),
(45,	4),
(46,	5),
(50,	8);

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240529131847',	'2024-05-29 13:18:57',	414);

DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `picture_name` varchar(255) DEFAULT NULL,
  `content` longtext NOT NULL,
  `opened_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `closed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `location` varchar(255) NOT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `event` (`id`, `title`, `picture_name`, `content`, `opened_at`, `closed_at`, `location`, `updated_at`) VALUES
(1,	'Concours du plus gros mangeur de Hot-Dog',	'hotdogs.jpg',	'Le \"Concours du plus gros mangeur de Hot-Dog\" est un événement spectaculaire où des participants affamés s\'affrontent pour dévorer le plus grand nombre de hot-dogs en un temps limité. Ce défi gastronomique met en avant la détermination, la rapidité et la capacité des concurrents à engloutir ces sandwichs emblématiques à une vitesse incroyable. Les spectateurs sont captivés par l\'intensité de la compétition, encouragent les participants et vivent des moments d\'excitation et d\'amusement.',	'2024-07-10 14:00:00',	'2024-07-10 15:00:00',	'Au niveau de l\'emplacement numéro 1',	NULL),
(2,	'Cours de cuisine \"empanadas\"',	'empanadas.jpg',	'Le \"Cours de cuisine Empanadas\" est une expérience immersive où les participants découvrent les secrets de la préparation de ce délicieux plat traditionnel d\'Amérique latine. Sous la direction d\'un chef expérimenté, les participants apprennent à pétrir la pâte, à préparer la garniture savoureuse et à plier les empanadas avec précision. C\'est une occasion idéale pour explorer la richesse de la culture culinaire latino-américaine tout en développant ses compétences en cuisine. L\'atmosphère est conviviale et interactive, permettant aux participants de poser des questions, d\'échanger des astuces et de partager des anecdotes culinaires. À la fin du cours, les participants dégustent fièrement leurs propres créations, ce qui ajoute une touche de satisfaction personnelle à cette expérience enrichissante.',	'2024-07-12 17:00:00',	'2024-07-12 18:00:00',	'Au niveau de l\'emplacement numéro 2',	NULL),
(3,	'Election Mister & Miss Foodtruck',	'miss.png',	'Voici ce qu\'il va se passer dans cet evenement bla bla bla blabla bla bla blabla bla bla blabla bla bla blabla bla bla blabla bla bla blabla bla bla blabla bla bla blabla bla bla blabla bla bla blabla bla bla blabla bla bla bla',	'2024-07-12 19:00:00',	'2024-07-12 20:00:00',	'à l\'emplacement numéro 3',	NULL),
(4,	'Tournoi de Mölkky',	'molkky.jpg',	'Le \"Tournoi de Mölkky\" est une célébration ludique et compétitive qui rassemble des passionnés de ce jeu de quilles finlandais. Les participants s\'affrontent en équipes pour tester leur précision, leur stratégie et leur habileté à renverser les quilles avec un bâton de bois, le Mölkky. L\'atmosphère est détendue et joyeuse, avec des rires et des encouragements alors que les équipes rivalisent sur le terrain. Les spectateurs se mêlent souvent à l\'action, applaudissant les performances impressionnantes et partageant l\'excitation du jeu. Que ce soit en famille, entre amis ou même en compétition officielle, le Tournoi de Mölkky offre une expérience divertissante et conviviale, où le plaisir de jouer ensemble est au cœur de l\'événement.',	'2024-07-09 16:00:00',	'2024-07-09 17:00:00',	'Au niveau de l\'emplacement numéro 4',	NULL),
(5,	'Blind test',	'blindtest.jpg',	'\"Blind Test\" est un jeu musical où les participants doivent deviner des chansons ou des extraits musicaux sans voir les titres ou les artistes. C\'est un défi divertissant qui teste la connaissance et l\'oreille musicale des joueurs, le tout dans une atmosphère amusante et compétitive.',	'2024-07-11 16:00:00',	'2024-07-11 18:00:00',	'Au niveau de l\'emplacement numéro 5',	NULL),
(6,	'Concert des Toqués',	'concert.jpg',	'Venez assister à un concert de vos Toqués préférés qui vont vous montrer que leurs talents ne se limitent pas aux fourneaux !',	'2024-07-12 20:00:00',	'2024-07-12 22:00:00',	'Au niveau de l\'emplacement numéro 6',	NULL);

DROP TABLE IF EXISTS `partner`;
CREATE TABLE `partner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `logo_name` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `partner` (`id`, `name`, `logo_name`, `updated_at`) VALUES
(1,	'PneuFrance',	'pneuFrance.png',	NULL),
(2,	'Le guide Michelinne',	'guideMichelinne.png',	NULL),
(3,	'Bison Affûté',	'bisonAffute.png',	NULL),
(4,	'La Région',	'laRegion.png',	NULL),
(5,	'La ville de Coolcity',	'coolCity.png',	NULL),
(6,	'O\'Clock',	'oclock.png',	NULL),
(7,	'France Travailleur',	'franceTravailleur.png',	NULL),
(8,	'CAFFE',	'caffe.png',	NULL),
(9,	'NRV',	'nrv.png',	NULL);

DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tag` (`id`, `name`) VALUES
(1,	'Sans gluten'),
(2,	'Faible en calories'),
(3,	'Sucré'),
(4,	'Epicé'),
(5,	'Sans lactose'),
(6,	'Très gourmand'),
(7,	'Sans alcool'),
(8,	'Alcoolisé');

DROP TABLE IF EXISTS `truck`;
CREATE TABLE `truck` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `picture_name` varchar(255) NOT NULL DEFAULT 'logo.png',
  `presentation` varchar(255) NOT NULL,
  `location` int(11) NOT NULL,
  `status` varchar(30) NOT NULL,
  `chef_name` varchar(100) NOT NULL,
  `chef_picture_name` varchar(255) DEFAULT 'chef.jpg',
  `chef_description` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_CDCCF30AA76ED395` (`user_id`),
  CONSTRAINT `FK_CDCCF30AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `truck` (`id`, `user_id`, `name`, `picture_name`, `presentation`, `location`, `status`, `chef_name`, `chef_picture_name`, `chef_description`, `slug`, `updated_at`) VALUES
(2,	2,	'truck numero 2',	'logo.png',	'Superbe truck bien décoré numéro 2',	18,	'pending',	'Michel Robuchon num 2',	'chef.jpg',	'Top chef forcément',	'truck-numero-2',	NULL),
(3,	2,	'truck numero 3',	'logo.png',	'Superbe truck bien décoré numéro 3',	18,	'pending',	'Michel Robuchon num 3',	'chef.jpg',	'Top chef forcément',	'truck-numero-3',	NULL),
(4,	3,	'truck numero 4',	'logo.png',	'Superbe truck bien décoré numéro 4',	13,	'pending',	'Michel Robuchon num 4',	'chef.jpg',	'Top chef forcément',	'truck-numero-4',	NULL),
(6,	4,	'truck numero 6',	'logo.png',	'Superbe truck bien décoré numéro 6',	24,	'pending',	'Michel Robuchon num 6',	'chef.jpg',	'Top chef forcément',	'truck-numero-6',	NULL),
(7,	5,	'Ay Pépito',	'logo.png',	'Toutes les saveurs du Mexique directement dans votre plat !',	15,	'validated',	'Juan Esposito',	'chef.jpg',	'Le roi des Tacos.',	'ay-pepito',	NULL),
(8,	6,	'Vin diu',	'logo.png',	'Vin Diu : l'\essence de la tradition viticole, un voyage gustatif à travers les vignobles du monde, servi avec passion dans un foodtruck',	8,	'pending',	'Thérésa',	'chef.jpg',	'Top chef forcément',	'vin-diu',	NULL),
(11,	7,	'La cantine du Mékong',	'logo.png',	'Découvrez l\'exotisme culinaire avec La Cantine du Mékong : des saveurs authentiques d\'Asie servies dans un foodtruck vibrant de vie urbaine',	7,	'draft',	'Mickaël Seng',	'chef.jpg',	'Maître des délices asiatiques, expert en fusion culinaire, chef créatif de La Cantine du Mékong.',	'cantine-mekong',	NULL);

DROP TABLE IF EXISTS `truck_category`;
CREATE TABLE `truck_category` (
  `truck_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`truck_id`,`category_id`),
  KEY `IDX_6A8D3D03C6957CCE` (`truck_id`),
  KEY `IDX_6A8D3D0312469DE2` (`category_id`),
  CONSTRAINT `FK_6A8D3D0312469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_6A8D3D03C6957CCE` FOREIGN KEY (`truck_id`) REFERENCES `truck` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `truck_category` (`truck_id`, `category_id`) VALUES
(2,	11),
(7,	18),
(8,	11),
(8,	27),
(11,	10),
(11,	17);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `firstname`, `lastname`) VALUES
(1,	'admin@oclock.fr',	'["ROLE_ADMIN", "ROLE_USER"]',	'$2y$13$3LSJyDCppWUsNmTsEVmiZewZfcAUMCYDPtXRSks4q3ZJBd7bOqO5O',	'Laurent',	'Matheu'),
(2,	'user1@oclock.fr',	'[\"ROLE_USER\"]',	'$2y$13$RQdcotA5Aq7h37dJj51HcO5DPDK0Q5X7x1IBDJ1zdoW62ewH5sW0m',	'Marine',	'Montaru'),
(3,	'user3@oclock.fr',	'[\"ROLE_USER\"]',	'$2y$13$ahDvQO1ZX5QmmcMba97.D.Y6re5Xfa0j2s5hlGwSzhrdWp0d2HWry',	'Guilhaume',	'Oclock'),
(4,	'user4@oclock.fr',	'[\"ROLE_USER\"]',	'$2y$13$EMr1fvOJ.anua5CgsX/86OSxSAWTaCzVcizjTQgiaLrA7F3hQQ.jW',	'Guilhaume',	'Arnaud'),
(5,	'user5@oclock.fr',	'[\"ROLE_USER\"]',	'$2y$13$/SK7ybxqisgRdkHLlOaGwOcisdgR5jLs1aVNuMRzE//oUwU.c02iS',	'Marcel',	'Paçorcié'),
(6,	'user6@oclock.fr',	'[\"ROLE_USER\"]',	'$2y$13$dzPTXxGA7avveYIsAQzN.OCSyduQpF.3wwp1sMhjT3Oot9fjTOuuG',	'Sabine',	'Paçorcié'),
(7,	'user7@oclock.fr',	'[\"ROLE_USER\"]',	'$2y$13$QzA0uhYRJfxZs4ihAqTgV.u5RAPppuD7MEJqbm/Y8ZiC4fErY9W3.',	'Fred',	'Paçorcié'),
(8,	'user8@oclock.fr',	'[\"ROLE_USER\"]',	'$2y$13$caE.3L382E.NEsSRMOxtGOPbSyM0/Y2DVhxf0f2BN92sNBjSuK27y',	'Jamy',	'Paçorcié'),
(9,	'new@oclock.fr',	'[\"ROLE_USER\"]',	'$2y$13$p/Ogtvh/5.WttJR6Ond/n.lOrWR0mhxEXx/I7sRvmiu3I9vzkUGke',	'Jean',	'Peplux'),
(10,	'new2@oclock.fr',	'[\"ROLE_USER\"]',	'$2y$13$aD2YHz02PLEignZqsNOSHeLrsvYULALMt8LsZkKWocoPqB3Oi7gg.',	'Jeanne',	'Peplux'),
(11,	'new3@oclock.fr',	'[\"ROLE_USER\"]',	'$2y$13$9zrxdFTY5ukkghYGOEiNDu/Lqsc/1gkfPY6AsomAvC8bGidDQ6XHq',	'Alain',	'Thérieur'),
(12,	'user2@oclock.fr',	'[\"ROLE_USER\"]',	'$2y$13$iYwmxkF2l7ZtAsulv2wmmO1DrkkQoOliwUTeIHMUAhxw1QfYW8PEy',	'Thomas',	'Iannicca');

-- 2024-05-30 14:39:50