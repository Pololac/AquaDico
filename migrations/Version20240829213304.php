<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240829213304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE origin (id INT AUTO_INCREMENT NOT NULL, continent VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fish ADD origin_id INT NOT NULL');
        $this->addSql('ALTER TABLE fish ADD CONSTRAINT FK_3F74443356A273CC FOREIGN KEY (origin_id) REFERENCES origin (id)');
        $this->addSql('CREATE INDEX IDX_3F74443356A273CC ON fish (origin_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fish DROP FOREIGN KEY FK_3F74443356A273CC');
        $this->addSql('DROP TABLE origin');
        $this->addSql('DROP INDEX IDX_3F74443356A273CC ON fish');
        $this->addSql('ALTER TABLE fish DROP origin_id');
    }
}
