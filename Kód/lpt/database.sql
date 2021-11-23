CREATE DATABASE lospolostechnikos;

CREATE TABLE `users` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `admin` tinyint(4) NOT NULL,
  `username` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(255) UNIQUE COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `users` (`id`, `admin`, `username`, `email`, `password`, `created_at`) VALUES
(1, 1, 'admin', 'admin@lospolostechnikos.cz', 'admin', '2021-11-14 16:21:25');
