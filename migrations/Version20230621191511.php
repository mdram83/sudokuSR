<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230621191511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE finished_game ADD active_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE finished_game ADD CONSTRAINT FK_32E5B8624226F8B FOREIGN KEY (active_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_32E5B8624226F8B ON finished_game (active_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE finished_game DROP CONSTRAINT FK_32E5B8624226F8B');
        $this->addSql('DROP INDEX IDX_32E5B8624226F8B');
        $this->addSql('ALTER TABLE finished_game DROP active_user_id');
    }
}
