<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230222144140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `primary` ON job_job_job_category');
        $this->addSql('ALTER TABLE job_job_job_category ADD PRIMARY KEY (job_id, category_id)');
        $this->addSql('DROP INDEX uniq_880e0d76e7927c74 ON user_admin');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6ACCF62EE7927C74 ON user_admin (email)');
        $this->addSql('DROP INDEX uniq_880e0d76f85e0677 ON user_admin');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6ACCF62EF85E0677 ON user_admin (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `PRIMARY` ON job_job_job_category');
        $this->addSql('ALTER TABLE job_job_job_category ADD PRIMARY KEY (category_id, job_id)');
        $this->addSql('DROP INDEX uniq_6accf62ee7927c74 ON `user_admin`');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D76E7927C74 ON `user_admin` (email)');
        $this->addSql('DROP INDEX uniq_6accf62ef85e0677 ON `user_admin`');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D76F85E0677 ON `user_admin` (username)');
    }
}
