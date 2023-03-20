<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230319214857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_user ADD country_id INT DEFAULT NULL, DROP country');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A80F92F3E70 FOREIGN KEY (country_id) REFERENCES `country` (id)');
        $this->addSql('CREATE INDEX IDX_F7129A80F92F3E70 ON user_user (country_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user_user` DROP FOREIGN KEY FK_F7129A80F92F3E70');
        $this->addSql('DROP INDEX IDX_F7129A80F92F3E70 ON `user_user`');
        $this->addSql('ALTER TABLE `user_user` ADD country VARCHAR(255) DEFAULT NULL, DROP country_id');
    }
}
