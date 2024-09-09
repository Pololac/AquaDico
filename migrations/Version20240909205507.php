<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240909205507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fish (id INT AUTO_INCREMENT NOT NULL, family_id INT NOT NULL, origin_id INT NOT NULL, name VARCHAR(255) NOT NULL, latin_name VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, adult_size INT DEFAULT NULL, min_temp INT DEFAULT NULL, max_temp INT DEFAULT NULL, min_ph DOUBLE PRECISION DEFAULT NULL, max_ph DOUBLE PRECISION DEFAULT NULL, min_gh INT DEFAULT NULL, max_gh INT DEFAULT NULL, pic_filename VARCHAR(255) DEFAULT NULL, is_visible TINYINT(1) NOT NULL, INDEX IDX_3F744433C35E566A (family_id), INDEX IDX_3F74443356A273CC (origin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fish_family (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F58D9F95989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE origin (id INT AUTO_INCREMENT NOT NULL, continent VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_DEF1561E989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fish ADD CONSTRAINT FK_3F744433C35E566A FOREIGN KEY (family_id) REFERENCES fish_family (id)');
        $this->addSql('ALTER TABLE fish ADD CONSTRAINT FK_3F74443356A273CC FOREIGN KEY (origin_id) REFERENCES origin (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fish DROP FOREIGN KEY FK_3F744433C35E566A');
        $this->addSql('ALTER TABLE fish DROP FOREIGN KEY FK_3F74443356A273CC');
        $this->addSql('DROP TABLE fish');
        $this->addSql('DROP TABLE fish_family');
        $this->addSql('DROP TABLE origin');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
