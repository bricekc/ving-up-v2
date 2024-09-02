<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230315195955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin_rubrique (admin_id INT NOT NULL, rubrique_id INT NOT NULL, INDEX IDX_1B040E7A642B8210 (admin_id), INDEX IDX_1B040E7A3BD38833 (rubrique_id), PRIMARY KEY(admin_id, rubrique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, questionnaire_id INT DEFAULT NULL, reponse_id INT DEFAULT NULL, thematique_id INT DEFAULT NULL, commentaire LONGTEXT NOT NULL, notes LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_67F068BCCE07E8FF (questionnaire_id), UNIQUE INDEX UNIQ_67F068BCCF18BB82 (reponse_id), INDEX IDX_67F068BC476556AF (thematique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur (id INT NOT NULL, verif TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur_type_materiel (fournisseur_id INT NOT NULL, type_materiel_id INT NOT NULL, INDEX IDX_524C559D670C757F (fournisseur_id), INDEX IDX_524C559D5D91DD3E (type_materiel_id), PRIMARY KEY(fournisseur_id, type_materiel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur_type_service (fournisseur_id INT NOT NULL, type_service_id INT NOT NULL, INDEX IDX_A0DDD7B6670C757F (fournisseur_id), INDEX IDX_A0DDD7B6F05F7FC3 (type_service_id), PRIMARY KEY(fournisseur_id, type_service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, sujet_id INT DEFAULT NULL, texte LONGTEXT NOT NULL, date DATETIME NOT NULL, INDEX IDX_5A8A6C8DA76ED395 (user_id), INDEX IDX_5A8A6C8D7C4D497E (sujet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, questionnaire_id INT DEFAULT NULL, thematique_id INT DEFAULT NULL, intitule_question VARCHAR(255) NOT NULL, INDEX IDX_B6F7494ECE07E8FF (questionnaire_id), INDEX IDX_B6F7494E476556AF (thematique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaire (id INT AUTO_INCREMENT NOT NULL, intitule_questionnaire VARCHAR(255) NOT NULL, public TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaire_thematique (questionnaire_id INT NOT NULL, thematique_id INT NOT NULL, INDEX IDX_CD7F1531CE07E8FF (questionnaire_id), INDEX IDX_CD7F1531476556AF (thematique_id), PRIMARY KEY(questionnaire_id, thematique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, commentaire_id INT DEFAULT NULL, reponse VARCHAR(255) NOT NULL, note INT NOT NULL, INDEX IDX_5FB6DEC71E27F6BF (question_id), UNIQUE INDEX UNIQ_5FB6DEC7BA9CD190 (commentaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse_resultat_questionnaire (reponse_id INT NOT NULL, resultat_questionnaire_id INT NOT NULL, INDEX IDX_AD833B0ACF18BB82 (reponse_id), INDEX IDX_AD833B0ACF09632B (resultat_questionnaire_id), PRIMARY KEY(reponse_id, resultat_questionnaire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resultat_questionnaire (id INT AUTO_INCREMENT NOT NULL, questionnaire_id INT DEFAULT NULL, viticulteur_id INT DEFAULT NULL, note INT DEFAULT NULL, commentaire VARCHAR(255) DEFAULT NULL, INDEX IDX_2BB0D92ECE07E8FF (questionnaire_id), INDEX IDX_2BB0D92E681FBEF2 (viticulteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rubrique (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, filename VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, video_link VARCHAR(510) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sujet (id INT AUTO_INCREMENT NOT NULL, intitule_sujet VARCHAR(255) NOT NULL, date_last_update DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thematique (id INT AUTO_INCREMENT NOT NULL, nom_thematique VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_materiel (id INT AUTO_INCREMENT NOT NULL, tag_id INT NOT NULL, description_materiel LONGTEXT DEFAULT NULL, intitule_materiel VARCHAR(255) DEFAULT NULL, INDEX IDX_D52D976DBAD26311 (tag_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_service (id INT AUTO_INCREMENT NOT NULL, tag_id INT NOT NULL, description_service LONGTEXT DEFAULT NULL, intitule_service VARCHAR(255) DEFAULT NULL, INDEX IDX_C9BCF527BAD26311 (tag_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, lastname VARCHAR(35) NOT NULL, firstname VARCHAR(35) NOT NULL, ville VARCHAR(35) DEFAULT NULL, cp VARCHAR(5) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, photo_profil VARCHAR(255) DEFAULT NULL, date_creation DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', discriminator VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE viticulteur (id INT NOT NULL, verif TINYINT(1) NOT NULL, num_siret VARCHAR(14) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admin_rubrique ADD CONSTRAINT FK_1B040E7A642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admin_rubrique ADD CONSTRAINT FK_1B040E7A3BD38833 FOREIGN KEY (rubrique_id) REFERENCES rubrique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCCE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCCF18BB82 FOREIGN KEY (reponse_id) REFERENCES reponse (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC476556AF FOREIGN KEY (thematique_id) REFERENCES thematique (id)');
        $this->addSql('ALTER TABLE fournisseur ADD CONSTRAINT FK_369ECA32BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fournisseur_type_materiel ADD CONSTRAINT FK_524C559D670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fournisseur_type_materiel ADD CONSTRAINT FK_524C559D5D91DD3E FOREIGN KEY (type_materiel_id) REFERENCES type_materiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fournisseur_type_service ADD CONSTRAINT FK_A0DDD7B6670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fournisseur_type_service ADD CONSTRAINT FK_A0DDD7B6F05F7FC3 FOREIGN KEY (type_service_id) REFERENCES type_service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D7C4D497E FOREIGN KEY (sujet_id) REFERENCES sujet (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494ECE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E476556AF FOREIGN KEY (thematique_id) REFERENCES thematique (id)');
        $this->addSql('ALTER TABLE questionnaire_thematique ADD CONSTRAINT FK_CD7F1531CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id)');
        $this->addSql('ALTER TABLE questionnaire_thematique ADD CONSTRAINT FK_CD7F1531476556AF FOREIGN KEY (thematique_id) REFERENCES thematique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC71E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7BA9CD190 FOREIGN KEY (commentaire_id) REFERENCES commentaire (id)');
        $this->addSql('ALTER TABLE reponse_resultat_questionnaire ADD CONSTRAINT FK_AD833B0ACF18BB82 FOREIGN KEY (reponse_id) REFERENCES reponse (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponse_resultat_questionnaire ADD CONSTRAINT FK_AD833B0ACF09632B FOREIGN KEY (resultat_questionnaire_id) REFERENCES resultat_questionnaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resultat_questionnaire ADD CONSTRAINT FK_2BB0D92ECE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id)');
        $this->addSql('ALTER TABLE resultat_questionnaire ADD CONSTRAINT FK_2BB0D92E681FBEF2 FOREIGN KEY (viticulteur_id) REFERENCES viticulteur (id)');
        $this->addSql('ALTER TABLE type_materiel ADD CONSTRAINT FK_D52D976DBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE type_service ADD CONSTRAINT FK_C9BCF527BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE viticulteur ADD CONSTRAINT FK_C978DC4ABF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76BF396750');
        $this->addSql('ALTER TABLE admin_rubrique DROP FOREIGN KEY FK_1B040E7A642B8210');
        $this->addSql('ALTER TABLE admin_rubrique DROP FOREIGN KEY FK_1B040E7A3BD38833');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCCE07E8FF');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCCF18BB82');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC476556AF');
        $this->addSql('ALTER TABLE fournisseur DROP FOREIGN KEY FK_369ECA32BF396750');
        $this->addSql('ALTER TABLE fournisseur_type_materiel DROP FOREIGN KEY FK_524C559D670C757F');
        $this->addSql('ALTER TABLE fournisseur_type_materiel DROP FOREIGN KEY FK_524C559D5D91DD3E');
        $this->addSql('ALTER TABLE fournisseur_type_service DROP FOREIGN KEY FK_A0DDD7B6670C757F');
        $this->addSql('ALTER TABLE fournisseur_type_service DROP FOREIGN KEY FK_A0DDD7B6F05F7FC3');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA76ED395');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D7C4D497E');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494ECE07E8FF');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E476556AF');
        $this->addSql('ALTER TABLE questionnaire_thematique DROP FOREIGN KEY FK_CD7F1531CE07E8FF');
        $this->addSql('ALTER TABLE questionnaire_thematique DROP FOREIGN KEY FK_CD7F1531476556AF');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC71E27F6BF');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7BA9CD190');
        $this->addSql('ALTER TABLE reponse_resultat_questionnaire DROP FOREIGN KEY FK_AD833B0ACF18BB82');
        $this->addSql('ALTER TABLE reponse_resultat_questionnaire DROP FOREIGN KEY FK_AD833B0ACF09632B');
        $this->addSql('ALTER TABLE resultat_questionnaire DROP FOREIGN KEY FK_2BB0D92ECE07E8FF');
        $this->addSql('ALTER TABLE resultat_questionnaire DROP FOREIGN KEY FK_2BB0D92E681FBEF2');
        $this->addSql('ALTER TABLE type_materiel DROP FOREIGN KEY FK_D52D976DBAD26311');
        $this->addSql('ALTER TABLE type_service DROP FOREIGN KEY FK_C9BCF527BAD26311');
        $this->addSql('ALTER TABLE viticulteur DROP FOREIGN KEY FK_C978DC4ABF396750');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE admin_rubrique');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE fournisseur_type_materiel');
        $this->addSql('DROP TABLE fournisseur_type_service');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE questionnaire');
        $this->addSql('DROP TABLE questionnaire_thematique');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE reponse_resultat_questionnaire');
        $this->addSql('DROP TABLE resultat_questionnaire');
        $this->addSql('DROP TABLE rubrique');
        $this->addSql('DROP TABLE sujet');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE thematique');
        $this->addSql('DROP TABLE type_materiel');
        $this->addSql('DROP TABLE type_service');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE viticulteur');
    }
}
