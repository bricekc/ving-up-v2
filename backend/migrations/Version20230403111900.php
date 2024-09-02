<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230403111900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vigne (id INT AUTO_INCREMENT NOT NULL, viticulteur_id INT DEFAULT NULL, superficie INT DEFAULT NULL, latitude VARCHAR(255) DEFAULT NULL, longitude VARCHAR(255) DEFAULT NULL, INDEX IDX_7DA054A0681FBEF2 (viticulteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vigne ADD CONSTRAINT FK_7DA054A0681FBEF2 FOREIGN KEY (viticulteur_id) REFERENCES viticulteur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vigne DROP FOREIGN KEY FK_7DA054A0681FBEF2');
        $this->addSql('DROP TABLE vigne');
    }
}
