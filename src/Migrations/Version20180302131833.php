<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180302131833 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX User_Email_uindex ON Accounts');
        $this->addSql('DROP INDEX IDX_AF36DF781620F05 ON Canvases');
        $this->addSql('ALTER TABLE Canvases CHANGE idroom intIdRoom INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Canvases ADD CONSTRAINT FK_AF36DF787C83CE70 FOREIGN KEY (intIdRoom) REFERENCES Rooms (intIdRoom)');
        $this->addSql('CREATE INDEX IDX_AF36DF787C83CE70 ON Canvases (intIdRoom)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE INDEX User_Email_uindex ON Accounts (email)');
        $this->addSql('ALTER TABLE Canvases DROP FOREIGN KEY FK_AF36DF787C83CE70');
        $this->addSql('DROP INDEX IDX_AF36DF787C83CE70 ON Canvases');
        $this->addSql('ALTER TABLE Canvases CHANGE intidroom idRoom INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_AF36DF781620F05 ON Canvases (idRoom)');
    }
}
