<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240301200715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE informe ADD guiaid_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE informe ADD CONSTRAINT FK_7E75E1D95E5BDBB4 FOREIGN KEY (guiaid_id) REFERENCES usuario (id)');
        $this->addSql('CREATE INDEX IDX_7E75E1D95E5BDBB4 ON informe (guiaid_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE informe DROP FOREIGN KEY FK_7E75E1D95E5BDBB4');
        $this->addSql('DROP INDEX IDX_7E75E1D95E5BDBB4 ON informe');
        $this->addSql('ALTER TABLE informe DROP guiaid_id');
    }
}
