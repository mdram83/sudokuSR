<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230618141812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_game ADD active_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE active_game ADD CONSTRAINT FK_CD4BA35C24226F8B FOREIGN KEY (active_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_CD4BA35C24226F8B ON active_game (active_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE active_game DROP CONSTRAINT FK_CD4BA35C24226F8B');
        $this->addSql('DROP INDEX IDX_CD4BA35C24226F8B');
        $this->addSql('ALTER TABLE active_game DROP active_user_id');
    }
}
