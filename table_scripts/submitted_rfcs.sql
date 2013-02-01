delimiter $$

CREATE TABLE `submitted_rfcs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL COMMENT 'The name of the RFC, e.g. "A Standard for the Transmission of IP Datagrams on Avian Carriers"\n',
  `description` text NOT NULL COMMENT 'What the RFC is for, this should be concise, well worded, and contain no grammatical or spelling errors. If it does, it will not be considered and eventually removed from the database. It is highly recommended that you compose your RFC in a word processor before submitting it to avoid removal.',
  `updated` varchar(45) DEFAULT NULL COMMENT 'This holds the name of the RFC that was updated by this RFC. "N/A" if none.',
  `submit_date` datetime DEFAULT NULL,
  `username` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8$$