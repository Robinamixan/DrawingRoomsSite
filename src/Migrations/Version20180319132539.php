<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180319132539 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Accounts (id_access INT DEFAULT NULL, id_condition INT DEFAULT NULL, intIdUser INT AUTO_INCREMENT NOT NULL, strUsername VARCHAR(30) NOT NULL, strPassword VARCHAR(100) NOT NULL, strEmail VARCHAR(40) NOT NULL, strFullName VARCHAR(60) DEFAULT NULL, strToken VARCHAR(300) NOT NULL, strPhotoPath VARCHAR(500) DEFAULT NULL, UNIQUE INDEX UNIQ_33BEFCFA49BAF0E7 (strUsername), INDEX IDX_33BEFCFA205E9EB9 (id_access), INDEX IDX_33BEFCFA3DE33464 (id_condition), INDEX User_Login_uindex (strUsername), PRIMARY KEY(intIdUser)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE User_Conditions (id_condition INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id_condition)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Canvases (intIdCanvas INT AUTO_INCREMENT NOT NULL, strCanvasName VARCHAR(100) NOT NULL, strCanvasFilePath VARCHAR(200) NOT NULL, blFlagActive TINYINT(1) DEFAULT NULL, intIdRoom INT DEFAULT NULL, INDEX IDX_AF36DF787C83CE70 (intIdRoom), PRIMARY KEY(intIdCanvas)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Accesses (id_access INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id_access)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Rooms (intIdRoom INT AUTO_INCREMENT NOT NULL, strRoomName VARCHAR(300) NOT NULL, PRIMARY KEY(intIdRoom)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Accounts ADD CONSTRAINT FK_33BEFCFA205E9EB9 FOREIGN KEY (id_access) REFERENCES Accesses (id_access)');
        $this->addSql('ALTER TABLE Accounts ADD CONSTRAINT FK_33BEFCFA3DE33464 FOREIGN KEY (id_condition) REFERENCES User_Conditions (id_condition)');
        $this->addSql('ALTER TABLE Canvases ADD CONSTRAINT FK_AF36DF787C83CE70 FOREIGN KEY (intIdPicture) REFERENCES Rooms (intIdRoom)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Accounts DROP FOREIGN KEY FK_33BEFCFA3DE33464');
        $this->addSql('ALTER TABLE Accounts DROP FOREIGN KEY FK_33BEFCFA205E9EB9');
        $this->addSql('ALTER TABLE Canvases DROP FOREIGN KEY FK_AF36DF787C83CE70');
        $this->addSql('DROP TABLE Accounts');
        $this->addSql('DROP TABLE User_Conditions');
        $this->addSql('DROP TABLE Canvases');
        $this->addSql('DROP TABLE Accesses');
        $this->addSql('DROP TABLE Rooms');
    }
}
