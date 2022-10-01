<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220929164116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidate ADD job_type_id INT DEFAULT NULL, ADD job_title VARCHAR(255) DEFAULT NULL, ADD experience INT DEFAULT NULL');
        $this->addSql('ALTER TABLE candidate ADD CONSTRAINT FK_C8B28E445FA33B08 FOREIGN KEY (job_type_id) REFERENCES job_type (id)');
        $this->addSql('CREATE INDEX IDX_C8B28E445FA33B08 ON candidate (job_type_id)');
        $this->addSql('ALTER TABLE user ADD birth DATETIME DEFAULT NULL, ADD social_accounts JSON DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP birth, DROP social_accounts');
        $this->addSql('ALTER TABLE candidate DROP FOREIGN KEY FK_C8B28E445FA33B08');
        $this->addSql('DROP INDEX IDX_C8B28E445FA33B08 ON candidate');
        $this->addSql('ALTER TABLE candidate DROP job_type_id, DROP job_title, DROP experience');
    }
}
