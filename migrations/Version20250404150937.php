<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250404150937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal_visitado (id INT AUTO_INCREMENT NOT NULL, visita_id INT NOT NULL, tipo VARCHAR(100) NOT NULL, raza VARCHAR(150) DEFAULT NULL, INDEX IDX_BFF066704EA74B0E (visita_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal_visitado ADD CONSTRAINT FK_BFF066704EA74B0E FOREIGN KEY (visita_id) REFERENCES visita (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal_visitado DROP FOREIGN KEY FK_BFF066704EA74B0E');
        $this->addSql('DROP TABLE animal_visitado');
    }
}
