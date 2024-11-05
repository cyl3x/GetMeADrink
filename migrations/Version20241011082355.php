<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241011082355 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_entity_product_category_entity (product_entity_id INT NOT NULL, product_category_entity_id INT NOT NULL, INDEX IDX_78F392B0EF85CBD0 (product_entity_id), INDEX IDX_78F392B0B4932A11 (product_category_entity_id), PRIMARY KEY(product_entity_id, product_category_entity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE `product_category` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE product_category_entity_product_entity (product_category_entity_id INT NOT NULL, product_entity_id INT NOT NULL, INDEX IDX_E661AE7EB4932A11 (product_category_entity_id), INDEX IDX_E661AE7EEF85CBD0 (product_entity_id), PRIMARY KEY(product_category_entity_id, product_entity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE product_entity_product_category_entity ADD CONSTRAINT FK_78F392B0EF85CBD0 FOREIGN KEY (product_entity_id) REFERENCES `product` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_entity_product_category_entity ADD CONSTRAINT FK_78F392B0B4932A11 FOREIGN KEY (product_category_entity_id) REFERENCES `product_category` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_category_entity_product_entity ADD CONSTRAINT FK_E661AE7EB4932A11 FOREIGN KEY (product_category_entity_id) REFERENCES `product_category` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_category_entity_product_entity ADD CONSTRAINT FK_E661AE7EEF85CBD0 FOREIGN KEY (product_entity_id) REFERENCES `product` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_entity_product_category_entity DROP FOREIGN KEY FK_78F392B0EF85CBD0');
        $this->addSql('ALTER TABLE product_entity_product_category_entity DROP FOREIGN KEY FK_78F392B0B4932A11');
        $this->addSql('ALTER TABLE product_category_entity_product_entity DROP FOREIGN KEY FK_E661AE7EB4932A11');
        $this->addSql('ALTER TABLE product_category_entity_product_entity DROP FOREIGN KEY FK_E661AE7EEF85CBD0');
        $this->addSql('DROP TABLE product_entity_product_category_entity');
        $this->addSql('DROP TABLE `product_category`');
        $this->addSql('DROP TABLE product_category_entity_product_entity');
    }
}
