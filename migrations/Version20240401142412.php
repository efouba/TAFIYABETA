<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240401142412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE census_taker (id INT AUTO_INCREMENT NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, retailler_id INT DEFAULT NULL, designation VARCHAR(255) NOT NULL, quantity INT NOT NULL, delivery_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D34A04ADD3FD8D53 (retailler_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE retailler (id INT AUTO_INCREMENT NOT NULL, supplier_id INT DEFAULT NULL, census_taker_id INT NOT NULL, name VARCHAR(255) NOT NULL, gps VARCHAR(255) NOT NULL, monthly_ca INT NOT NULL, quarter VARCHAR(255) NOT NULL, place_said VARCHAR(255) NOT NULL, tafiya_interest TINYINT(1) NOT NULL, exist_supplier TINYINT(1) NOT NULL, take_to_market TINYINT(1) NOT NULL, country VARCHAR(255) NOT NULL, phone_one VARCHAR(255) NOT NULL, phone_two VARCHAR(255) DEFAULT NULL, INDEX IDX_794699D42ADD6D8C (supplier_id), INDEX IDX_794699D47AC3ADF4 (census_taker_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supplier (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, his_lastness VARCHAR(255) NOT NULL, functioning LONGTEXT NOT NULL, place VARCHAR(255) NOT NULL, transport_cost INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADD3FD8D53 FOREIGN KEY (retailler_id) REFERENCES retailler (id)');
        $this->addSql('ALTER TABLE retailler ADD CONSTRAINT FK_794699D42ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE retailler ADD CONSTRAINT FK_794699D47AC3ADF4 FOREIGN KEY (census_taker_id) REFERENCES census_taker (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADD3FD8D53');
        $this->addSql('ALTER TABLE retailler DROP FOREIGN KEY FK_794699D42ADD6D8C');
        $this->addSql('ALTER TABLE retailler DROP FOREIGN KEY FK_794699D47AC3ADF4');
        $this->addSql('DROP TABLE census_taker');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE retailler');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
