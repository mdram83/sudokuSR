<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523183911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sudoku ADD difficulty_id INT NOT NULL');
        $this->addSql('ALTER TABLE sudoku ADD CONSTRAINT FK_5CEF6AE5FCFA9DAE FOREIGN KEY (difficulty_id) REFERENCES sudoku_difficulty (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5CEF6AE5FCFA9DAE ON sudoku (difficulty_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE sudoku DROP CONSTRAINT FK_5CEF6AE5FCFA9DAE');
        $this->addSql('DROP INDEX IDX_5CEF6AE5FCFA9DAE');
        $this->addSql('ALTER TABLE sudoku DROP difficulty_id');
    }
}
