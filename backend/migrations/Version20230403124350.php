<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230403124350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rubrique ADD file_path VARCHAR(255) DEFAULT NULL, DROP titre, DROP filename, DROP description, DROP auteur, DROP video_link');
        $this->addSql('ALTER TABLE user CHANGE photo_profil photo_profil LONGBLOB DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rubrique ADD titre VARCHAR(255) NOT NULL, ADD description VARCHAR(255) DEFAULT NULL, ADD auteur VARCHAR(255) DEFAULT NULL, ADD video_link VARCHAR(510) DEFAULT NULL, CHANGE file_path filename VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE `user` CHANGE photo_profil photo_profil VARCHAR(255) DEFAULT NULL');
    }
}
