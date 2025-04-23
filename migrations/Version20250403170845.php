<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250403170845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE maute (id INT AUTO_INCREMENT NOT NULL, lote VARCHAR(255) NOT NULL, cantidad INT NOT NULL, raza VARCHAR(255) NOT NULL, peso_promedio DOUBLE PRECISION NOT NULL, precio_unitario DOUBLE PRECISION DEFAULT NULL, disponible TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE novilla (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, raza VARCHAR(255) NOT NULL, edad INT NOT NULL, peso DOUBLE PRECISION NOT NULL, precio DOUBLE PRECISION DEFAULT NULL, descripcion LONGTEXT DEFAULT NULL, disponible TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE toro (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, raza VARCHAR(255) NOT NULL, peso DOUBLE PRECISION NOT NULL, edad INT NOT NULL, precio DOUBLE PRECISION DEFAULT NULL, descripcion LONGTEXT DEFAULT NULL, disponible TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vaca (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, raza VARCHAR(255) NOT NULL, produccion_leche DOUBLE PRECISION NOT NULL, edad INT NOT NULL, precio DOUBLE PRECISION DEFAULT NULL, descripcion LONGTEXT DEFAULT NULL, disponible TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visita (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, fecha DATETIME NOT NULL, nombre_visitante VARCHAR(255) NOT NULL, telefono VARCHAR(20) NOT NULL, comentario LONGTEXT DEFAULT NULL, estado VARCHAR(255) DEFAULT NULL, INDEX IDX_B7F148A2DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE visita ADD CONSTRAINT FK_B7F148A2DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visita DROP FOREIGN KEY FK_B7F148A2DB38439E');
        $this->addSql('DROP TABLE maute');
        $this->addSql('DROP TABLE novilla');
        $this->addSql('DROP TABLE toro');
        $this->addSql('DROP TABLE vaca');
        $this->addSql('DROP TABLE visita');
    }
}
