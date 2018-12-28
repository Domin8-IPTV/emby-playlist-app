<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1546026793.
 * Generated on 2018-12-28 19:53:13 
 */
class PropelMigration_1546026793
{
    public $comment = '';

    public function preUp(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postUp(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    public function preDown(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postDown(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `list_song`;

CREATE TABLE `list_file`
(
    `list_id` INTEGER NOT NULL,
    `file_id` INTEGER NOT NULL,
    PRIMARY KEY (`list_id`,`file_id`),
    INDEX `list_file_fi_38afab` (`file_id`),
    CONSTRAINT `list_file_fk_a74631`
        FOREIGN KEY (`list_id`)
        REFERENCES `list` (`id`),
    CONSTRAINT `list_file_fk_38afab`
        FOREIGN KEY (`file_id`)
        REFERENCES `file` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `list_file`;

CREATE TABLE `list_song`
(
    `list_id` INTEGER NOT NULL,
    `file_id` INTEGER NOT NULL,
    PRIMARY KEY (`list_id`,`file_id`),
    INDEX `list_song_fi_38afab` (`file_id`),
    CONSTRAINT `list_song_fk_38afab`
        FOREIGN KEY (`file_id`)
        REFERENCES `file` (`id`),
    CONSTRAINT `list_song_fk_a74631`
        FOREIGN KEY (`list_id`)
        REFERENCES `list` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}