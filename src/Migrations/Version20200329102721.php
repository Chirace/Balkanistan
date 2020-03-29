<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200329102721 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE politicien_affaire (politicien_id INT NOT NULL, affaire_id INT NOT NULL, INDEX IDX_91F17A497C1FA7B6 (politicien_id), INDEX IDX_91F17A49F082E755 (affaire_id), PRIMARY KEY(politicien_id, affaire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE politicien_affaire ADD CONSTRAINT FK_91F17A497C1FA7B6 FOREIGN KEY (politicien_id) REFERENCES politicien (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE politicien_affaire ADD CONSTRAINT FK_91F17A49F082E755 FOREIGN KEY (affaire_id) REFERENCES affaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE politicien CHANGE mairie_id mairie_id INT DEFAULT NULL, CHANGE parti_id parti_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE politicien_affaire');
        $this->addSql('ALTER TABLE politicien CHANGE mairie_id mairie_id INT DEFAULT NULL, CHANGE parti_id parti_id INT DEFAULT NULL');
    }
}
