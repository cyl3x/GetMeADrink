<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240913102528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_product DROP FOREIGN KEY FK_2530ADE66BF700BD');
        $this->addSql('DROP INDEX IDX_2530ADE66BF700BD ON order_product');
        $this->addSql('DROP TABLE order_product_status');
        $this->addSql('ALTER TABLE order_product ADD pending_quantity INT NOT NULL, DROP status_id, CHANGE count quantity INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_product_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `order_product` ADD count INT NOT NULL, ADD status_id INT DEFAULT NULL, DROP quantity, DROP pending_quantity');
        $this->addSql('ALTER TABLE `order_product` ADD CONSTRAINT FK_2530ADE66BF700BD FOREIGN KEY (status_id) REFERENCES order_product_status (id)');
        $this->addSql('CREATE INDEX IDX_2530ADE66BF700BD ON `order_product` (status_id)');
    }
}
