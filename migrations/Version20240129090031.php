<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240129090031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apartamento (id INT AUTO_INCREMENT NOT NULL, titulo VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, direccion VARCHAR(255) NOT NULL, precio DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE foto (id INT AUTO_INCREMENT NOT NULL, apartamento_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_EADC3BE58D171536 (apartamento_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reserva (id INT AUTO_INCREMENT NOT NULL, apartamento_id INT DEFAULT NULL, fecha_entrada VARCHAR(255) NOT NULL, fecha_fin_contrato VARCHAR(255) NOT NULL, contacto_reserva VARCHAR(255) NOT NULL, INDEX IDX_188D2E3B8D171536 (apartamento_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE foto ADD CONSTRAINT FK_EADC3BE58D171536 FOREIGN KEY (apartamento_id) REFERENCES apartamento (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B8D171536 FOREIGN KEY (apartamento_id) REFERENCES apartamento (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE foto DROP FOREIGN KEY FK_EADC3BE58D171536');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3B8D171536');
        $this->addSql('DROP TABLE apartamento');
        $this->addSql('DROP TABLE foto');
        $this->addSql('DROP TABLE reserva');
    }
}
