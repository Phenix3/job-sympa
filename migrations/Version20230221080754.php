<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230221080754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `primary` ON job_job_job_category');
        $this->addSql('ALTER TABLE job_job_job_category ADD PRIMARY KEY (category_id, job_id)');
        $this->addSql('ALTER TABLE job_job CHANGE responsibilities responsibilities LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', CHANGE education education LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', CHANGE other_benefits other_benefits LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE requirements requirements LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE user_employer CHANGE location location LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE user_user CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', CHANGE social_accounts social_accounts LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `PRIMARY` ON job_job_job_category');
        $this->addSql('ALTER TABLE job_job_job_category ADD PRIMARY KEY (job_id, category_id)');
        $this->addSql('ALTER TABLE `user_user` CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`, CHANGE social_accounts social_accounts LONGTEXT DEFAULT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE `user_employer` CHANGE location location LONGTEXT DEFAULT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE `job_job` CHANGE responsibilities responsibilities LONGTEXT NOT NULL COLLATE `utf8mb4_bin`, CHANGE education education LONGTEXT NOT NULL COLLATE `utf8mb4_bin`, CHANGE other_benefits other_benefits LONGTEXT DEFAULT NULL COLLATE `utf8mb4_bin`, CHANGE requirements requirements LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
