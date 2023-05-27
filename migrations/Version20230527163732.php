<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230527163732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE active_game_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE active_game (id INT NOT NULL, sudoku_id INT NOT NULL, anonymous_user VARCHAR(255) NOT NULL, initial_board JSON NOT NULL, board JSON NOT NULL, board_errors JSON NOT NULL, notes JSON NOT NULL, notes_errors JSON NOT NULL, empty_cells_count SMALLINT NOT NULL, history JSON NOT NULL, difficulty_level JSON NOT NULL, timer INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CD4BA35CE7D1242B ON active_game (anonymous_user)');
        $this->addSql('CREATE INDEX IDX_CD4BA35C66CFABE3 ON active_game (sudoku_id)');
        $this->addSql('ALTER TABLE active_game ADD CONSTRAINT FK_CD4BA35C66CFABE3 FOREIGN KEY (sudoku_id) REFERENCES sudoku (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE active_game_id_seq CASCADE');
        $this->addSql('ALTER TABLE active_game DROP CONSTRAINT FK_CD4BA35C66CFABE3');
        $this->addSql('DROP TABLE active_game');
    }
}
