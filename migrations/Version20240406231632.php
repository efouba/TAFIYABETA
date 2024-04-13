<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240406231632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE retailler DROP FOREIGN KEY FK_794699D47AC3ADF4');
        $this->addSql('DROP INDEX IDX_794699D47AC3ADF4 ON retailler');
        $this->addSql('ALTER TABLE retailler ADD user_id INT DEFAULT NULL, DROP census_taker_id');
        $this->addSql('ALTER TABLE retailler ADD CONSTRAINT FK_794699D4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_794699D4A76ED395 ON retailler (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE retailler DROP FOREIGN KEY FK_794699D4A76ED395');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_794699D4A76ED395 ON retailler');
        $this->addSql('ALTER TABLE retailler ADD census_taker_id INT NOT NULL, DROP user_id');
        $this->addSql('ALTER TABLE retailler ADD CONSTRAINT FK_794699D47AC3ADF4 FOREIGN KEY (census_taker_id) REFERENCES census_taker (id)');
        $this->addSql('CREATE INDEX IDX_794699D47AC3ADF4 ON retailler (census_taker_id)');
    }
}
