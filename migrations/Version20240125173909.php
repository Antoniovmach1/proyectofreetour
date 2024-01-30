<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240125173909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ruta_item');
        $this->addSql('DROP INDEX IDX_7E75E1D915ED8D43 ON informe');
        $this->addSql('ALTER TABLE informe DROP tour_id');
        $this->addSql('DROP INDEX IDX_4F68E0104E7121AF ON localidad');
        $this->addSql('ALTER TABLE localidad DROP provincia_id');
        $this->addSql('DROP INDEX UNIQ_188D2E3BD29AA1AC ON reserva');
        $this->addSql('DROP INDEX IDX_188D2E3BDB38439E ON reserva');
        $this->addSql('ALTER TABLE reserva DROP usuario_id, DROP valoracion_id');
        $this->addSql('DROP INDEX IDX_C3AEF08CDB38439E ON ruta');
        $this->addSql('DROP INDEX IDX_C3AEF08C67707C89 ON ruta');
        $this->addSql('ALTER TABLE ruta DROP usuario_id, DROP localidad_id');
        $this->addSql('DROP INDEX IDX_6AD1F969DB38439E ON tour');
        $this->addSql('ALTER TABLE tour DROP usuario_id');
        $this->addSql('ALTER TABLE usuario ADD is_verified TINYINT(1) NOT NULL, CHANGE nombre nombre VARCHAR(25) NOT NULL, CHANGE apellidos apellidos VARCHAR(30) NOT NULL, CHANGE contrasena contrasena LONGBLOB NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ruta_item (ruta_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_837FEAD6ABBC4845 (ruta_id), INDEX IDX_837FEAD6126F525E (item_id), PRIMARY KEY(ruta_id, item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE informe ADD tour_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_7E75E1D915ED8D43 ON informe (tour_id)');
        $this->addSql('ALTER TABLE localidad ADD provincia_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_4F68E0104E7121AF ON localidad (provincia_id)');
        $this->addSql('ALTER TABLE reserva ADD usuario_id INT DEFAULT NULL, ADD valoracion_id INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_188D2E3BD29AA1AC ON reserva (valoracion_id)');
        $this->addSql('CREATE INDEX IDX_188D2E3BDB38439E ON reserva (usuario_id)');
        $this->addSql('ALTER TABLE ruta ADD usuario_id INT DEFAULT NULL, ADD localidad_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_C3AEF08CDB38439E ON ruta (usuario_id)');
        $this->addSql('CREATE INDEX IDX_C3AEF08C67707C89 ON ruta (localidad_id)');
        $this->addSql('ALTER TABLE tour ADD usuario_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_6AD1F969DB38439E ON tour (usuario_id)');
        $this->addSql('ALTER TABLE usuario DROP is_verified, CHANGE nombre nombre VARCHAR(25) DEFAULT NULL, CHANGE apellidos apellidos VARCHAR(30) DEFAULT NULL, CHANGE contrasena contrasena LONGBLOB DEFAULT NULL');
    }
}
