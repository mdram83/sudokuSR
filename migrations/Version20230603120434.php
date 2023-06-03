<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230603120434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE finished_game_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE finished_game (id INT NOT NULL, sudoku_id INT NOT NULL, anonymous_user VARCHAR(255) NOT NULL, timer INT NOT NULL, finished_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_32E5B8666CFABE3 ON finished_game (sudoku_id)');
        $this->addSql('COMMENT ON COLUMN finished_game.finished_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE finished_game ADD CONSTRAINT FK_32E5B8666CFABE3 FOREIGN KEY (sudoku_id) REFERENCES sudoku (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE finished_game_id_seq CASCADE');
        $this->addSql('ALTER TABLE finished_game DROP CONSTRAINT FK_32E5B8666CFABE3');
        $this->addSql('DROP TABLE finished_game');
    }
}
