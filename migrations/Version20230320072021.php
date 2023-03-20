<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320072021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `ownership_type` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_16DC78CB5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_employer ADD ownership_type_id INT DEFAULT NULL, ADD ceo VARCHAR(255) DEFAULT NULL, ADD established_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user_employer ADD CONSTRAINT FK_3EC114669338D186 FOREIGN KEY (ownership_type_id) REFERENCES `ownership_type` (id)');
        $this->addSql('CREATE INDEX IDX_3EC114669338D186 ON user_employer (ownership_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user_employer` DROP FOREIGN KEY FK_3EC114669338D186');
        $this->addSql('DROP TABLE `ownership_type`');
        $this->addSql('DROP INDEX IDX_3EC114669338D186 ON `user_employer`');
        $this->addSql('ALTER TABLE `user_employer` DROP ownership_type_id, DROP ceo, DROP established_at');
    }
}
