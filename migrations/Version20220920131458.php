<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920131458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE job_job_job_category (job_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_B38EC913BE04EA9 (job_id), INDEX IDX_B38EC91312469DE2 (category_id), PRIMARY KEY(job_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_job_job_skill (job_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_330FE8DABE04EA9 (job_id), INDEX IDX_330FE8DA5585C142 (skill_id), PRIMARY KEY(job_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_skill (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE job_job_job_category ADD CONSTRAINT FK_B38EC913BE04EA9 FOREIGN KEY (job_id) REFERENCES job_job (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_job_job_category ADD CONSTRAINT FK_B38EC91312469DE2 FOREIGN KEY (category_id) REFERENCES job_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_job_job_skill ADD CONSTRAINT FK_330FE8DABE04EA9 FOREIGN KEY (job_id) REFERENCES job_job (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_job_job_skill ADD CONSTRAINT FK_330FE8DA5585C142 FOREIGN KEY (skill_id) REFERENCES job_skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_category_pivot DROP FOREIGN KEY FK_E6E56678BE04EA9');
        $this->addSql('ALTER TABLE job_category_pivot DROP FOREIGN KEY FK_E6E5667812469DE2');
        $this->addSql('DROP TABLE job_category_pivot');
        $this->addSql('ALTER TABLE candidate CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE job_job CHANGE responsibilities responsibilities JSON NOT NULL, CHANGE education education JSON NOT NULL, CHANGE other_benefits other_benefits JSON DEFAULT NULL, CHANGE requirements requirements JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE job_category_pivot (job_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_E6E56678BE04EA9 (job_id), INDEX IDX_E6E5667812469DE2 (category_id), PRIMARY KEY(job_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE job_category_pivot ADD CONSTRAINT FK_E6E56678BE04EA9 FOREIGN KEY (job_id) REFERENCES job_job (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_category_pivot ADD CONSTRAINT FK_E6E5667812469DE2 FOREIGN KEY (category_id) REFERENCES job_category (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_job_job_category DROP FOREIGN KEY FK_B38EC913BE04EA9');
        $this->addSql('ALTER TABLE job_job_job_category DROP FOREIGN KEY FK_B38EC91312469DE2');
        $this->addSql('ALTER TABLE job_job_job_skill DROP FOREIGN KEY FK_330FE8DABE04EA9');
        $this->addSql('ALTER TABLE job_job_job_skill DROP FOREIGN KEY FK_330FE8DA5585C142');
        $this->addSql('DROP TABLE job_job_job_category');
        $this->addSql('DROP TABLE job_job_job_skill');
        $this->addSql('DROP TABLE job_skill');
        $this->addSql('ALTER TABLE candidate CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE job_job CHANGE responsibilities responsibilities LONGTEXT NOT NULL, CHANGE education education LONGTEXT NOT NULL, CHANGE other_benefits other_benefits LONGTEXT DEFAULT NULL, CHANGE requirements requirements LONGTEXT NOT NULL');
    }
}
