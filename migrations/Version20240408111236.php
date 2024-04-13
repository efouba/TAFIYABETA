<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240408111236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE retailler DROP FOREIGN KEY FK_794699D42ADD6D8C');
        $this->addSql('DROP INDEX IDX_794699D42ADD6D8C ON retailler');
        $this->addSql('ALTER TABLE retailler DROP supplier_id');
        $this->addSql('ALTER TABLE supplier ADD retailler_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE supplier ADD CONSTRAINT FK_9B2A6C7ED3FD8D53 FOREIGN KEY (retailler_id) REFERENCES retailler (id)');
        $this->addSql('CREATE INDEX IDX_9B2A6C7ED3FD8D53 ON supplier (retailler_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE retailler ADD supplier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE retailler ADD CONSTRAINT FK_794699D42ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('CREATE INDEX IDX_794699D42ADD6D8C ON retailler (supplier_id)');
        $this->addSql('ALTER TABLE supplier DROP FOREIGN KEY FK_9B2A6C7ED3FD8D53');
        $this->addSql('DROP INDEX IDX_9B2A6C7ED3FD8D53 ON supplier');
        $this->addSql('ALTER TABLE supplier DROP retailler_id');
    }
}
