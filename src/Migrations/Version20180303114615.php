<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180303114615 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');


        $this->addSql('ALTER TABLE Accounts ADD strPhotoPath VARCHAR(500) NOT NULL, CHANGE username strUsername VARCHAR(30) NOT NULL, CHANGE password strPassword VARCHAR(100) NOT NULL, CHANGE email strEmail VARCHAR(40) NOT NULL, CHANGE full_name strFullName VARCHAR(60) DEFAULT NULL, CHANGE token strToken VARCHAR(300) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_33BEFCFA49BAF0E7 ON Accounts (strUsername)');
        $this->addSql('CREATE INDEX User_Login_uindex ON Accounts (strUsername)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Accounts DROP strPhotoPath, CHANGE strusername username VARCHAR(30) NOT NULL COLLATE utf8_unicode_ci, CHANGE strpassword password VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE stremail email VARCHAR(40) NOT NULL COLLATE utf8_unicode_ci, CHANGE strfullname full_name VARCHAR(60) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE strtoken token VARCHAR(300) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_33BEFCFAF85E0677 ON Accounts (username)');
        $this->addSql('CREATE INDEX User_Login_uindex ON Accounts (username)');
    }
}
