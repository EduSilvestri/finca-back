<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250423121057 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal_visitado DROP FOREIGN KEY FK_BFF066704EA74B0E');
        $this->addSql('DROP TABLE animal_visitado');
        $this->addSql('ALTER TABLE visita ADD tipo_animal VARCHAR(60) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal_visitado (id INT AUTO_INCREMENT NOT NULL, visita_id INT NOT NULL, tipo VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, raza VARCHAR(150) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_BFF066704EA74B0E (visita_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE animal_visitado ADD CONSTRAINT FK_BFF066704EA74B0E FOREIGN KEY (visita_id) REFERENCES visita (id)');
        $this->addSql('ALTER TABLE visita DROP tipo_animal');
    }
}
