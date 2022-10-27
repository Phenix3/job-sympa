<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221027093936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job_job DROP FOREIGN KEY FK_3F0D7369979B1AD6');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('CREATE TABLE `job_application` (id INT AUTO_INCREMENT NOT NULL, job_id INT DEFAULT NULL, candidate_id INT DEFAULT NULL, cv_id INT DEFAULT NULL, message LONGTEXT DEFAULT NULL, status VARCHAR(255) DEFAULT \'pending\' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C737C688BE04EA9 (job_id), INDEX IDX_C737C68891BD8781 (candidate_id), INDEX IDX_C737C688CFE419E2 (cv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user_candidate` (id INT NOT NULL, job_type_id INT DEFAULT NULL, job_title VARCHAR(255) DEFAULT NULL, experience INT DEFAULT NULL, INDEX IDX_C85203A05FA33B08 (job_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user_candidate_cvs` (id INT AUTO_INCREMENT NOT NULL, candidate_id INT NOT NULL, file_id INT NOT NULL, is_default TINYINT(1) DEFAULT 0, title VARCHAR(255) NOT NULL, job_title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_1ACD996F91BD8781 (candidate_id), UNIQUE INDEX UNIQ_1ACD996F93CB796C (file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user_candidate_skill` (id INT AUTO_INCREMENT NOT NULL, candidate_id INT NOT NULL, skill_id INT NOT NULL, level INT DEFAULT NULL, INDEX IDX_7401630491BD8781 (candidate_id), INDEX IDX_740163045585C142 (skill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user_employer` (id INT NOT NULL, location JSON DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user_user` (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, about LONGTEXT DEFAULT NULL, is_verified TINYINT(1) NOT NULL, avatar_name VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, birth DATETIME DEFAULT NULL, social_accounts JSON DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F7129A80E7927C74 (email), INDEX IDX_F7129A8012469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `job_application` ADD CONSTRAINT FK_C737C688BE04EA9 FOREIGN KEY (job_id) REFERENCES `job_job` (id)');
        $this->addSql('ALTER TABLE `job_application` ADD CONSTRAINT FK_C737C68891BD8781 FOREIGN KEY (candidate_id) REFERENCES `user_candidate` (id)');
        $this->addSql('ALTER TABLE `job_application` ADD CONSTRAINT FK_C737C688CFE419E2 FOREIGN KEY (cv_id) REFERENCES `user_candidate_cvs` (id)');
        $this->addSql('ALTER TABLE `user_candidate` ADD CONSTRAINT FK_C85203A05FA33B08 FOREIGN KEY (job_type_id) REFERENCES `job_type` (id)');
        $this->addSql('ALTER TABLE `user_candidate` ADD CONSTRAINT FK_C85203A0BF396750 FOREIGN KEY (id) REFERENCES `user_user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `user_candidate_cvs` ADD CONSTRAINT FK_1ACD996F91BD8781 FOREIGN KEY (candidate_id) REFERENCES `user_candidate` (id)');
        $this->addSql('ALTER TABLE `user_candidate_cvs` ADD CONSTRAINT FK_1ACD996F93CB796C FOREIGN KEY (file_id) REFERENCES `attachment` (id)');
        $this->addSql('ALTER TABLE `user_candidate_skill` ADD CONSTRAINT FK_7401630491BD8781 FOREIGN KEY (candidate_id) REFERENCES `user_candidate` (id)');
        $this->addSql('ALTER TABLE `user_candidate_skill` ADD CONSTRAINT FK_740163045585C142 FOREIGN KEY (skill_id) REFERENCES `job_skill` (id)');
        $this->addSql('ALTER TABLE `user_employer` ADD CONSTRAINT FK_3EC11466BF396750 FOREIGN KEY (id) REFERENCES `user_user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `user_user` ADD CONSTRAINT FK_F7129A8012469DE2 FOREIGN KEY (category_id) REFERENCES `job_category` (id)');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1CFE419E2');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC191BD8781');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1BE04EA9');
        $this->addSql('ALTER TABLE candidate DROP FOREIGN KEY FK_C8B28E445FA33B08');
        $this->addSql('ALTER TABLE candidate DROP FOREIGN KEY FK_C8B28E44BF396750');
        $this->addSql('ALTER TABLE candidate_cvs DROP FOREIGN KEY FK_F443343F91BD8781');
        $this->addSql('ALTER TABLE candidate_cvs DROP FOREIGN KEY FK_F443343F93CB796C');
        $this->addSql('ALTER TABLE candidate_skill DROP FOREIGN KEY FK_66DD0F8B91BD8781');
        $this->addSql('ALTER TABLE candidate_skill DROP FOREIGN KEY FK_66DD0F8B5585C142');
        $this->addSql('ALTER TABLE employer DROP FOREIGN KEY FK_DE4CF066BF396750');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64912469DE2');
        $this->addSql('DROP TABLE application');
        $this->addSql('DROP TABLE candidate');
        $this->addSql('DROP TABLE candidate_cvs');
        $this->addSql('DROP TABLE candidate_skill');
        $this->addSql('DROP TABLE employer');
        $this->addSql('DROP TABLE user');
        // $this->addSql('ALTER TABLE job_job DROP FOREIGN KEY FK_3F0D7369979B1AD6');
        $this->addSql('ALTER TABLE job_job ADD CONSTRAINT FK_3F0D7369979B1AD6 FOREIGN KEY (company_id) REFERENCES `user_employer` (id)');
        // $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES `user_user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `job_job` DROP FOREIGN KEY FK_3F0D7369979B1AD6');
        $this->addSql('ALTER TABLE `reset_password_request` DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('CREATE TABLE application (id INT AUTO_INCREMENT NOT NULL, job_id INT DEFAULT NULL, candidate_id INT DEFAULT NULL, cv_id INT DEFAULT NULL, message LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'pending\' NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_A45BDDC191BD8781 (candidate_id), INDEX IDX_A45BDDC1BE04EA9 (job_id), INDEX IDX_A45BDDC1CFE419E2 (cv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE candidate (id INT NOT NULL, job_type_id INT DEFAULT NULL, job_title VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, experience INT DEFAULT NULL, INDEX IDX_C8B28E445FA33B08 (job_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE candidate_cvs (id INT AUTO_INCREMENT NOT NULL, candidate_id INT NOT NULL, file_id INT NOT NULL, is_default TINYINT(1) DEFAULT 0, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, job_title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_F443343F93CB796C (file_id), INDEX IDX_F443343F91BD8781 (candidate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE candidate_skill (id INT AUTO_INCREMENT NOT NULL, candidate_id INT NOT NULL, skill_id INT NOT NULL, level INT DEFAULT NULL, INDEX IDX_66DD0F8B5585C142 (skill_id), INDEX IDX_66DD0F8B91BD8781 (candidate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE employer (id INT NOT NULL, location JSON DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles JSON NOT NULL, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, username VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, address VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, phone VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, about LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, is_verified TINYINT(1) NOT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, avatar_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, country VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, city VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, birth DATETIME DEFAULT NULL, social_accounts JSON DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D64912469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1CFE419E2 FOREIGN KEY (cv_id) REFERENCES candidate_cvs (id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC191BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1BE04EA9 FOREIGN KEY (job_id) REFERENCES job_job (id)');
        $this->addSql('ALTER TABLE candidate ADD CONSTRAINT FK_C8B28E445FA33B08 FOREIGN KEY (job_type_id) REFERENCES job_type (id)');
        $this->addSql('ALTER TABLE candidate ADD CONSTRAINT FK_C8B28E44BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidate_cvs ADD CONSTRAINT FK_F443343F91BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id)');
        $this->addSql('ALTER TABLE candidate_cvs ADD CONSTRAINT FK_F443343F93CB796C FOREIGN KEY (file_id) REFERENCES attachment (id)');
        $this->addSql('ALTER TABLE candidate_skill ADD CONSTRAINT FK_66DD0F8B91BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id)');
        $this->addSql('ALTER TABLE candidate_skill ADD CONSTRAINT FK_66DD0F8B5585C142 FOREIGN KEY (skill_id) REFERENCES job_skill (id)');
        $this->addSql('ALTER TABLE employer ADD CONSTRAINT FK_DE4CF066BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64912469DE2 FOREIGN KEY (category_id) REFERENCES job_category (id)');
        $this->addSql('ALTER TABLE `job_application` DROP FOREIGN KEY FK_C737C688BE04EA9');
        $this->addSql('ALTER TABLE `job_application` DROP FOREIGN KEY FK_C737C68891BD8781');
        $this->addSql('ALTER TABLE `job_application` DROP FOREIGN KEY FK_C737C688CFE419E2');
        $this->addSql('ALTER TABLE `user_candidate` DROP FOREIGN KEY FK_C85203A05FA33B08');
        $this->addSql('ALTER TABLE `user_candidate` DROP FOREIGN KEY FK_C85203A0BF396750');
        $this->addSql('ALTER TABLE `user_candidate_cvs` DROP FOREIGN KEY FK_1ACD996F91BD8781');
        $this->addSql('ALTER TABLE `user_candidate_cvs` DROP FOREIGN KEY FK_1ACD996F93CB796C');
        $this->addSql('ALTER TABLE `user_candidate_skill` DROP FOREIGN KEY FK_7401630491BD8781');
        $this->addSql('ALTER TABLE `user_candidate_skill` DROP FOREIGN KEY FK_740163045585C142');
        $this->addSql('ALTER TABLE `user_employer` DROP FOREIGN KEY FK_3EC11466BF396750');
        $this->addSql('ALTER TABLE `user_user` DROP FOREIGN KEY FK_F7129A8012469DE2');
        $this->addSql('DROP TABLE `job_application`');
        $this->addSql('DROP TABLE `user_candidate`');
        $this->addSql('DROP TABLE `user_candidate_cvs`');
        $this->addSql('DROP TABLE `user_candidate_skill`');
        $this->addSql('DROP TABLE `user_employer`');
        $this->addSql('DROP TABLE `user_user`');
        $this->addSql('ALTER TABLE `job_job` DROP FOREIGN KEY FK_3F0D7369979B1AD6');
        $this->addSql('ALTER TABLE `job_job` ADD CONSTRAINT FK_3F0D7369979B1AD6 FOREIGN KEY (company_id) REFERENCES employer (id)');
        $this->addSql('ALTER TABLE `reset_password_request` DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE `reset_password_request` ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }
}
