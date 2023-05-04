<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230429102047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification ADD url VARCHAR(255) DEFAULT NULL, ADD target VARCHAR(255) DEFAULT NULL, ADD channel VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_user ADD notifications_read_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user_user` DROP notifications_read_at');
        $this->addSql('ALTER TABLE `notification` DROP url, DROP target, DROP channel');
    }
}
