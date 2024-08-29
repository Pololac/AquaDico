<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240829213033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fish_family (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fish ADD family_id INT NOT NULL');
        $this->addSql('ALTER TABLE fish ADD CONSTRAINT FK_3F744433C35E566A FOREIGN KEY (family_id) REFERENCES fish_family (id)');
        $this->addSql('CREATE INDEX IDX_3F744433C35E566A ON fish (family_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fish DROP FOREIGN KEY FK_3F744433C35E566A');
        $this->addSql('DROP TABLE fish_family');
        $this->addSql('DROP INDEX IDX_3F744433C35E566A ON fish');
        $this->addSql('ALTER TABLE fish DROP family_id');
    }
}
