--
-- Table structure for table `email`
--

CREATE TABLE `email` (
  `lid_id` int(10) UNSIGNED DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email`
--

INSERT INTO `email` (`lid_id`, `email`) VALUES
(1, 'jan.piet@gmail.com'),
(2, 'lisa_van_leen@hotmail.com'),
(3, 'g.remmers@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `lid`
--

CREATE TABLE `lid` (
  `id` int(10) UNSIGNED NOT NULL,
  `naam` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `achternaam` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `postcode` char(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `huisnummer` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lid`
--

INSERT INTO `lid` (`id`, `naam`, `achternaam`, `postcode`, `huisnummer`) VALUES
(1, 'Jan', 'Piet', '2511FF', '5'),
(2, 'Lisa', 'van Leen', '2566ER', '67'),
(3, 'Gerard', 'van Remmers', '1087UR', '25');

-- --------------------------------------------------------

--
-- Table structure for table `postcode`
--

CREATE TABLE `postcode` (
  `postcode` char(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `adres` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `woonplaats` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `postcode`
--

INSERT INTO `postcode` (`postcode`, `adres`, `woonplaats`) VALUES
('1087UR', 'Van Berglaan', 'Amsterdam'),
('2511FF', 'Hoogstraat', 'Den Haag'),
('2566ER', 'Vaaringslaan', 'Delft');

-- --------------------------------------------------------

--
-- Table structure for table `telefoonnummer`
--

CREATE TABLE `telefoonnummer` (
  `lid_id` int(10) UNSIGNED DEFAULT NULL,
  `telefoonnummer` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `telefoonnummer`
--

INSERT INTO `telefoonnummer` (`lid_id`, `telefoonnummer`) VALUES
(1, '0701234567'),
(2, '0687654321'),
(3, '0202457806');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`email`),
  ADD KEY `lid_id` (`lid_id`);

--
-- Indexes for table `lid`
--
ALTER TABLE `lid`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postcode_id` (`postcode`);

--
-- Indexes for table `postcode`
--
ALTER TABLE `postcode`
  ADD PRIMARY KEY (`postcode`);

--
-- Indexes for table `telefoonnummer`
--
ALTER TABLE `telefoonnummer`
  ADD PRIMARY KEY (`telefoonnummer`),
  ADD KEY `lid_id` (`lid_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lid`
--
ALTER TABLE `lid`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `email`
--
ALTER TABLE `email`
  ADD CONSTRAINT `FK_email` FOREIGN KEY (`lid_id`) REFERENCES `lid` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `lid`
--
ALTER TABLE `lid`
  ADD CONSTRAINT `FK_postcode1` FOREIGN KEY (`postcode`) REFERENCES `postcode` (`postcode`);

--
-- Constraints for table `telefoonnummer`
--
ALTER TABLE `telefoonnummer`
  ADD CONSTRAINT `FK_telefoon` FOREIGN KEY (`lid_id`) REFERENCES `lid` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
