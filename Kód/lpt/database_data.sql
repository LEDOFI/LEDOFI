CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(255) DEFAULT 'v konceptech',
  `published` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_changed_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `posts` (`id`, `user_id`, `status`, `published`, `created_at`, `last_changed_at`) VALUES
(1, 2, 'recenze vypracovany', 1, '2021-10-05 10:00:46', '2021-10-05 10:00:46'),
(2, 2, 'recenze vypracovany', 1, '2021-11-07 20:00:46', '2021-11-07 20:00:46'),
(3, 3, 'recenze vypracovany', 1, '2021-11-09 20:15:06', '2021-11-09 20:15:06'),
(4, 3, 'recenze vypracovany', 1, '2021-11-11 20:20:20', '2021-11-11 20:20:20'),
(5, 2, 'recenze vypracovany', 1, '2021-11-13 20:25:24', '2021-11-13 20:25:24'),
(6, 2, 'recenze vypracovany', 1, '2021-11-14 20:32:36', '2021-11-14 20:32:36'),
(7, 3, 'recenze vypracovany', 1, '2021-11-15 20:32:26', '2021-11-15 20:32:26');

CREATE TABLE `posts_autors` (
  `id` int(11) NOT NULL,
  `autor_clanku` varchar(255) NOT NULL,
  `email_autora_clanku` varchar(255) NOT NULL,
  `verze` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `posts_autors` (`id`, `autor_clanku`, `email_autora_clanku`, `verze`, `created_at`) VALUES
(1, 'Jan Musil', 'jan@musil.cz', 1, '2021-10-05 10:00:46'),
(2, 'Jan Musil', 'jan@musil.cz', 1, '2021-11-07 20:00:46'),
(3, 'Jan Musil', 'jan@musil.cz', 1, '2021-11-09 20:15:06'),
(3, 'Jan Musil', 'jan@musil.cz', 2, '2021-11-09 20:16:06'),
(3, 'Karel Voráček', 'karel@vrl.cz', 2, '2021-11-09 20:16:06'),
(4, 'Aleš Brabec', 'ales@brabec.cz', 1, '2021-11-11 20:20:20'),
(4, 'Aleš Brabec', 'ales@brabec.cz', 2, '2021-11-13 20:21:24'),
(4, 'Jaromír Lubošuj', 'jara@lubosuj.cz', 2, '2021-11-13 20:21:24'),
(4, 'Aleš Brabec', 'ales@brabec.cz', 3, '2021-11-13 20:22:24'),
(4, 'Jaromír Lubošuj', 'jara@lubosuj.cz', 3, '2021-11-13 20:22:24'),
(5, 'Aleš Brabec', 'ales@brabec.cz', 1, '2021-11-13 20:25:24'),
(5, 'Karel Voráček', 'karel@vrl.cz', 1, '2021-11-13 20:25:24'),
(6, 'Tadeáš Fejt', 'tade@fejt.cz', 1, '2021-11-14 20:32:36'),
(6, 'Karolína Fejtová', 'kara@fejt.cz', 1, '2021-11-14 20:32:36'),
(7, 'Zdeněk Šrámek', 'zdenda@sramek.cz', 1, '2021-11-15 20:32:26'),
(7, 'Karolína Fejtová', 'kara@fejt.cz', 1, '2021-11-14 20:32:26'),
(7, 'Zdeněk Šrámek', 'zdenda@sramek.cz', 2, '2021-11-15 20:33:26'),
(7, 'Karolína Fejtová', 'kara@fejt.cz', 2, '2021-11-14 20:33:26');

CREATE TABLE `posts_assets` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `document` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `verze` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `posts_assets` (`id`, `title`, `document`, `image`, `verze`, `created_at`) VALUES
(1, 'Jak se stát autorem', 'jaksestatautorem.docx', 'autor.jpg', 1, '2021-10-05 10:00:46'),
(2, 'Lorem ipsum dolor sit amet', 'lieuropanlingues.docx', 'img3.jpg', 1, '2021-11-07 20:00:46'),
(3, 'Lorem ipsum', 'cicero.docx', 'img1.jpg', 1, '2021-11-09 20:15:06'),
(3, 'Lorem ipsum consect adiskikng elitos', 'lieuropanlingues.docx', 'img2.jpg', 2, '2021-11-09 20:16:06'),
(4, 'Lorem hfdhfshfd', 'loremipsum.docx', 'img1.jpg', 1, '2021-11-11 20:20:20'),
(4, 'Lorem ipsum bvnfftjgf', 'cicero.docx', 'img1.jpg', 2, '2021-11-11 20:21:20'),
(4, 'Lorem ipsum sapien elit consequat', 'lieuropanlingues.docx', 'img2.jpg', 3, '2021-11-11 20:22:20'),
(5, 'Lorem ipsum sint occaecat cupidatat', 'loremipsum.docx', 'img1.jpg', 1, '2021-11-13 20:25:24'),
(6, 'Lorem ipsum ligula sit amet', 'loremipsum.docx', 'img2.jpg', 1, '2021-11-14 20:32:36'),
(7, 'Post cislo 1 verze 1', 'lieuropanlingues.docx', 'img1.jpg', 1, '2021-11-15 20:32:26'),
(7, 'Post cislo 1 verze 2', 'loremipsum.docx', 'img3.jpg', 2, '2021-11-15 20:32:26');

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'ctenar',
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `zadost_na_zmenu_role` varchar(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `role`, `username`, `email`, `password`, `zadost_na_zmenu_role`, `created_at`) VALUES
(1, 'ctenar', 'user', 'user@gmail.com', 'b23d5ae7ac107b7cba46a06348b44153', '0', '2021-11-23 16:32:39'),
(2, 'admin', 'admin', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', '0','2021-11-27 11:48:42'),
(3, 'autor', 'autor', 'autor@gmail.cum', '7a25cefdc710b155828e91df70fe7478', '0','2021-11-13 09:45:22'),
(4, 'redaktor', 'redaktor', 'redaktor@gmail.cum', 'fc732c7f3293285356b13570bf6a87fd', '0','2021-11-13 09:46:18'),
(5, 'recenzent', 'recenzent', 'recenzent@gmail.cum', 'e6350b6fddd7d5bbf14f3dab3b32bf40', '0','2021-11-13 09:47:27'),
(6, 'ctenar', 'ctenar', 'ctenar@gmail.cum', 'b23d5ae7ac107b7cba46a06348b44153', '0','2021-11-13 09:48:11'),
(7, 'admin', 'administrator', 'administrator@gmail.cum', '200ceb26807d6bf99fd6f4f0d1ca54d4', '0','2021-11-13 09:52:08'),
(8, 'sefredaktor', 'sefredaktor', 'sefredaktor@gmail.cum', '124ff84fcad527dd8cbef03540ef5bd9', '0','2021-11-13 09:52:45'),
(9, 'recenzent', 'recenzent2', 'recenzent2@gmail.cum', 'fd61a704d10b48ab25e22988048b990b', '0','2021-12-10 10:35:51');

CREATE TABLE `posts_vybrani_recenzenti` (
  `id` int(11) NOT NULL,
  `recenzent_id` int(11) NOT NULL,
  `submitted` int(11) NOT NULL DEFAULT '0',
  `zpristupneno_autorovi` int(11) NOT NULL DEFAULT '0',
  `verze` int(11) NOT NULL,  
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `posts_vybrani_recenzenti` (`id`, `recenzent_id`, `submitted`, `zpristupneno_autorovi`, `verze`, `created_at`) VALUES
(1, 5, 1, 1, 1, '2021-10-05 10:00:46'),
(2, 5, 1, 1, 1, '2021-11-07 20:00:46'),
(3, 5, 1, 1, 1, '2021-11-09 20:15:06'),
(3, 5, 1, 1, 2, '2021-11-09 20:16:06'),
(4, 5, 1, 1, 1, '2021-11-11 20:20:20'),
(4, 5, 1, 1, 2, '2021-11-11 20:21:20'),
(4, 5, 1, 1, 3, '2021-11-11 20:22:20'),
(5, 5, 1, 1, 1, '2021-11-13 20:25:24'),
(6, 5, 1, 1, 1, '2021-11-14 20:32:36'),
(7, 5, 1, 1, 1, '2021-11-15 20:32:26'),
(7, 5, 1, 1, 2, '2021-11-15 20:32:26'),
(2, 9, 1, 1, 1, '2021-11-07 22:40:56'),
(4, 9, 1, 1, 1, '2021-11-11 22:40:30'),
(4, 9, 1, 1, 3, '2021-11-11 22:42:30'),
(5, 9, 1, 1, 1, '2021-11-13 22:45:44'),
(7, 9, 1, 1, 2, '2021-11-15 22:42:16');

CREATE TABLE `posts_recenze` (
  `id` int(11) NOT NULL,
  `recenzent_id` int(11) NOT NULL,
  `aktualnost` int(1) NOT NULL,
  `originalita` int(1) NOT NULL,
  `odborna_uroven` int(1) NOT NULL,
  `jazykova_uroven` int(1) NOT NULL,
  `message_recenzent_to_autor` text DEFAULT NULL,
  `hodnoceni` varchar(255) NOT NULL,
  `verze` int(11) NOT NULL,  
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `posts_recenze` (`id`, `recenzent_id`, `aktualnost`, `originalita`, `odborna_uroven`, `jazykova_uroven`, `message_recenzent_to_autor`, `hodnoceni`, `verze`, `created_at`) VALUES
(1, 5, 1, 1, 1, 1, 'Some message 1', 'Clanek prijmut', 1, '2021-10-05 10:00:46'),
(2, 5, 1, 2, 2, 2, 'Some message 1', 'Clanek prijmut', 1, '2021-11-07 20:00:46'),
(3, 5, 3, 3, 1, 3, 'Some message 1', 'Clanek prijmut', 1, '2021-11-09 20:15:06'),
(3, 5, 2, 4, 2, 3, 'Some message 2', 'Clanek prijmut', 2, '2021-11-09 20:16:06'),
(4, 5, 5, 2, 1, 5, 'Some message 1', 'Clanek prijmut', 1, '2021-11-11 20:20:20'),
(4, 5, 4, 3, 2, 4, 'Some message 2', 'Clanek prijmut', 2, '2021-11-11 20:21:20'),
(4, 5, 3, 2, 3, 4, 'Some message 3', 'Clanek prijmut', 3, '2021-11-11 20:22:20'),
(5, 5, 2, 2, 1, 2, 'Some message 1', 'Clanek prijmut', 1, '2021-11-13 20:25:24'),
(6, 5, 1, 1, 2, 2, 'Some message 1', 'Clanek prijmut', 1, '2021-11-14 20:32:36'),
(7, 5, 5, 1, 3, 3, 'Some message 1', 'Clanek prijmut', 1, '2021-11-15 20:32:26'),
(7, 5, 1, 1, 2, 2, 'Some message 2', 'Clanek prijmut', 2, '2021-11-15 20:32:26'),
(2, 9, 2, 1, 3, 4, 'Some message 1', 'Clanek prijmut', 1, '2021-11-07 22:40:56'),
(4, 9, 4, 1, 2, 3, 'Some message 1', 'Clanek prijmut', 1, '2021-11-11 22:40:30'),
(4, 9, 5, 1, 2, 3, 'Some message 2', 'Clanek prijmut', 3, '2021-11-11 22:42:30'),
(5, 9, 1, 2, 3, 4, 'Some message 1', 'Clanek prijmut', 1, '2021-11-13 22:45:44'),
(7, 9, 1, 1, 1, 1, 'Some message 1', 'Clanek prijmut', 2, '2021-11-15 22:42:16');

ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `posts_autors`
  ADD KEY `id` (`id`);

ALTER TABLE `posts_assets`
  ADD KEY `id` (`id`);
  
ALTER TABLE `posts_vybrani_recenzenti`
  ADD KEY `id` (`id`);
  
ALTER TABLE `posts_recenze`
  ADD KEY `id` (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
  
ALTER TABLE `posts_autors`
  ADD CONSTRAINT `posts_autors_ibfk` FOREIGN KEY (`id`) REFERENCES `posts` (`id`);
  
ALTER TABLE `posts_assets`
  ADD CONSTRAINT `posts_assets_ibfk` FOREIGN KEY (`id`) REFERENCES `posts` (`id`);
  
ALTER TABLE `posts_vybrani_recenzenti`
  ADD CONSTRAINT `posts_vybrani_recenzenti_ibfk` FOREIGN KEY (`id`) REFERENCES `posts` (`id`);
  
ALTER TABLE `posts_recenze`
  ADD CONSTRAINT `posts_recenze_ibfk` FOREIGN KEY (`id`) REFERENCES `posts` (`id`);