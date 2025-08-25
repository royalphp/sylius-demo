<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250719203614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE app_product_demonstration_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE app_product_demonstration (id INT NOT NULL, product_id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, capacity INT NOT NULL, featured BOOLEAN NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, completed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AF0754844584665A ON app_product_demonstration (product_id)');
        $this->addSql('COMMENT ON COLUMN app_product_demonstration.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN app_product_demonstration.completed_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE app_product_demonstration ADD CONSTRAINT FK_AF0754844584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE app_product_demonstration_id_seq CASCADE');
        $this->addSql('ALTER TABLE app_product_demonstration DROP CONSTRAINT FK_AF0754844584665A');
        $this->addSql('DROP TABLE app_product_demonstration');
    }
}
