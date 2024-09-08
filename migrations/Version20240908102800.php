<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240908102800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fish CHANGE min_temp min_temp INT DEFAULT NULL, CHANGE max_temp max_temp INT DEFAULT NULL, CHANGE min_ph min_ph DOUBLE PRECISION DEFAULT NULL, CHANGE max_ph max_ph DOUBLE PRECISION DEFAULT NULL, CHANGE min_gh min_gh INT DEFAULT NULL, CHANGE max_gh max_gh INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fish_family ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F58D9F95989D9B62 ON fish_family (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fish CHANGE min_temp min_temp INT DEFAULT NULL COMMENT \'10°C minimum\', CHANGE max_temp max_temp INT DEFAULT NULL COMMENT \'30°C maximum\', CHANGE min_ph min_ph DOUBLE PRECISION DEFAULT NULL COMMENT \'1 minimum\', CHANGE max_ph max_ph DOUBLE PRECISION DEFAULT NULL COMMENT \'14 maximum\', CHANGE min_gh min_gh INT DEFAULT NULL COMMENT \'1 minimum\', CHANGE max_gh max_gh INT DEFAULT NULL COMMENT \'34 maximum\'');
        $this->addSql('DROP INDEX UNIQ_F58D9F95989D9B62 ON fish_family');
        $this->addSql('ALTER TABLE fish_family DROP slug');
    }
}
