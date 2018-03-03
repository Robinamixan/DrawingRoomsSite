<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180223080258 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Answers (id_answer INT AUTO_INCREMENT NOT NULL, id_question INT DEFAULT NULL, answer_text VARCHAR(100) NOT NULL, flag_right TINYINT(1) DEFAULT NULL, INDEX IDX_9F6DFF9AE62CA5DB (id_question), PRIMARY KEY(id_answer)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Accounts (id_user INT AUTO_INCREMENT NOT NULL, id_access INT DEFAULT NULL, id_condition INT DEFAULT NULL, username VARCHAR(30) NOT NULL, password VARCHAR(100) NOT NULL, email VARCHAR(40) NOT NULL, full_name VARCHAR(60) DEFAULT NULL, token VARCHAR(300) NOT NULL, UNIQUE INDEX UNIQ_33BEFCFAF85E0677 (username), UNIQUE INDEX UNIQ_33BEFCFAE7927C74 (email), INDEX IDX_33BEFCFA205E9EB9 (id_access), INDEX IDX_33BEFCFA3DE33464 (id_condition), INDEX User_Email_uindex (email), INDEX User_Login_uindex (username), PRIMARY KEY(id_user)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Questions (id_question INT AUTO_INCREMENT NOT NULL, question_text VARCHAR(300) NOT NULL, PRIMARY KEY(id_question)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE User_Conditions (id_condition INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id_condition)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Accesses (id_access INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id_access)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Answers ADD CONSTRAINT FK_9F6DFF9AE62CA5DB FOREIGN KEY (id_question) REFERENCES Questions (id_question)');
        $this->addSql('ALTER TABLE Accounts ADD CONSTRAINT FK_33BEFCFA205E9EB9 FOREIGN KEY (id_access) REFERENCES Accesses (id_access)');
        $this->addSql('ALTER TABLE Accounts ADD CONSTRAINT FK_33BEFCFA3DE33464 FOREIGN KEY (id_condition) REFERENCES User_Conditions (id_condition)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Answers DROP FOREIGN KEY FK_9F6DFF9AE62CA5DB');
        $this->addSql('ALTER TABLE Accounts DROP FOREIGN KEY FK_33BEFCFA3DE33464');
        $this->addSql('ALTER TABLE Accounts DROP FOREIGN KEY FK_33BEFCFA205E9EB9');
        $this->addSql('DROP TABLE Answers');
        $this->addSql('DROP TABLE Accounts');
        $this->addSql('DROP TABLE Questions');
        $this->addSql('DROP TABLE User_Conditions');
        $this->addSql('DROP TABLE Accesses');
    }
}
