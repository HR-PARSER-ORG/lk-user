<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240218082814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE hhindustry_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE hhsub_industry_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE hhindustry (id INT NOT NULL, hh_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE hhsub_industry (id INT NOT NULL, hh_industry_id INT DEFAULT NULL, hh_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_364FA57D34BE324E ON hhsub_industry (hh_industry_id)');
        $this->addSql('ALTER TABLE hhsub_industry ADD CONSTRAINT FK_364FA57D34BE324E FOREIGN KEY (hh_industry_id) REFERENCES hhindustry (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE hhindustry_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE hhsub_industry_id_seq CASCADE');
        $this->addSql('ALTER TABLE hhsub_industry DROP CONSTRAINT FK_364FA57D34BE324E');
        $this->addSql('DROP TABLE hhindustry');
        $this->addSql('DROP TABLE hhsub_industry');
    }
}
