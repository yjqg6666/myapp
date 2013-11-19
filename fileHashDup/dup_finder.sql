BEGIN;
CREATE TABLE dup_finder (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `path` varchar(255) NOT NULL,
  `size` INTEGER(15) NOT NULL,
  `size_str` char(30) NOT NULL,
  `hash` CHAR(32) NOT NULL,
  `hash_num` INTEGER(15) NOT NULL
);
CREATE INDEX size ON `dup_finder` (`size`);
CREATE INDEX hash ON `dup_finder` (`hash`);
CREATE INDEX hash_num ON `dup_finder` (`hash_num`);
COMMIT;
