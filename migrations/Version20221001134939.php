<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221001134939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidate_cvs (id INT AUTO_INCREMENT NOT NULL, candidate_id INT NOT NULL, file_id INT NOT NULL, is_default TINYINT(1) DEFAULT 0, title VARCHAR(255) NOT NULL, INDEX IDX_F443343F91BD8781 (candidate_id), UNIQUE INDEX UNIQ_F443343F93CB796C (file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidate_cvs ADD CONSTRAINT FK_F443343F91BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id)');
        $this->addSql('ALTER TABLE candidate_cvs ADD CONSTRAINT FK_F443343F93CB796C FOREIGN KEY (file_id) REFERENCES attachment (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidate_cvs DROP FOREIGN KEY FK_F443343F91BD8781');
        $this->addSql('ALTER TABLE candidate_cvs DROP FOREIGN KEY FK_F443343F93CB796C');
        $this->addSql('DROP TABLE candidate_cvs');
    }
}
