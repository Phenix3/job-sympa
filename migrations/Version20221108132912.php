<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221108132912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `bookmark` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, job_id INT DEFAULT NULL, cv_id INT DEFAULT NULL, rating INT DEFAULT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_DA62921DA76ED395 (user_id), INDEX IDX_DA62921DBE04EA9 (job_id), INDEX IDX_DA62921DCFE419E2 (cv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `bookmark` ADD CONSTRAINT FK_DA62921DA76ED395 FOREIGN KEY (user_id) REFERENCES `user_user` (id)');
        $this->addSql('ALTER TABLE `bookmark` ADD CONSTRAINT FK_DA62921DBE04EA9 FOREIGN KEY (job_id) REFERENCES `job_job` (id)');
        $this->addSql('ALTER TABLE `bookmark` ADD CONSTRAINT FK_DA62921DCFE419E2 FOREIGN KEY (cv_id) REFERENCES `user_candidate_cvs` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `bookmark` DROP FOREIGN KEY FK_DA62921DA76ED395');
        $this->addSql('ALTER TABLE `bookmark` DROP FOREIGN KEY FK_DA62921DBE04EA9');
        $this->addSql('ALTER TABLE `bookmark` DROP FOREIGN KEY FK_DA62921DCFE419E2');
        $this->addSql('DROP TABLE `bookmark`');
    }
}
