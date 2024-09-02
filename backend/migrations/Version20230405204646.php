<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230405204646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE resultat_questionnaire_reponse (resultat_questionnaire_id INT NOT NULL, reponse_id INT NOT NULL, INDEX IDX_55820428CF09632B (resultat_questionnaire_id), INDEX IDX_55820428CF18BB82 (reponse_id), PRIMARY KEY(resultat_questionnaire_id, reponse_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE resultat_questionnaire_reponse ADD CONSTRAINT FK_55820428CF09632B FOREIGN KEY (resultat_questionnaire_id) REFERENCES resultat_questionnaire (id)');
        $this->addSql('ALTER TABLE resultat_questionnaire_reponse ADD CONSTRAINT FK_55820428CF18BB82 FOREIGN KEY (reponse_id) REFERENCES reponse (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponse_resultat_questionnaire DROP FOREIGN KEY FK_AD833B0ACF18BB82');
        $this->addSql('ALTER TABLE reponse_resultat_questionnaire DROP FOREIGN KEY FK_AD833B0ACF09632B');
        $this->addSql('DROP TABLE reponse_resultat_questionnaire');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reponse_resultat_questionnaire (reponse_id INT NOT NULL, resultat_questionnaire_id INT NOT NULL, INDEX IDX_AD833B0ACF18BB82 (reponse_id), INDEX IDX_AD833B0ACF09632B (resultat_questionnaire_id), PRIMARY KEY(reponse_id, resultat_questionnaire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE reponse_resultat_questionnaire ADD CONSTRAINT FK_AD833B0ACF18BB82 FOREIGN KEY (reponse_id) REFERENCES reponse (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponse_resultat_questionnaire ADD CONSTRAINT FK_AD833B0ACF09632B FOREIGN KEY (resultat_questionnaire_id) REFERENCES resultat_questionnaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resultat_questionnaire_reponse DROP FOREIGN KEY FK_55820428CF09632B');
        $this->addSql('ALTER TABLE resultat_questionnaire_reponse DROP FOREIGN KEY FK_55820428CF18BB82');
        $this->addSql('DROP TABLE resultat_questionnaire_reponse');
    }
}
