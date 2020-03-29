<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200329083103 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE politicien ADD mairie_id INT DEFAULT NULL, ADD parti_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE politicien ADD CONSTRAINT FK_D7F73E4DE7A79AB FOREIGN KEY (mairie_id) REFERENCES mairie (id)');
        $this->addSql('ALTER TABLE politicien ADD CONSTRAINT FK_D7F73E4D712547C6 FOREIGN KEY (parti_id) REFERENCES parti (id)');
        $this->addSql('CREATE INDEX IDX_D7F73E4DE7A79AB ON politicien (mairie_id)');
        $this->addSql('CREATE INDEX IDX_D7F73E4D712547C6 ON politicien (parti_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE politicien DROP FOREIGN KEY FK_D7F73E4DE7A79AB');
        $this->addSql('ALTER TABLE politicien DROP FOREIGN KEY FK_D7F73E4D712547C6');
        $this->addSql('DROP INDEX IDX_D7F73E4DE7A79AB ON politicien');
        $this->addSql('DROP INDEX IDX_D7F73E4D712547C6 ON politicien');
        $this->addSql('ALTER TABLE politicien DROP mairie_id, DROP parti_id');
    }
}
