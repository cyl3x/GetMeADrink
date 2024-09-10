<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240910074150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, total_price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, table_id INT DEFAULT NULL, status_id INT DEFAULT NULL, INDEX IDX_F5299398ECFF285C (table_id), INDEX IDX_F52993986BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE `order_status` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398ECFF285C FOREIGN KEY (table_id) REFERENCES `table` (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993986BF700BD FOREIGN KEY (status_id) REFERENCES `order_status` (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE `table` ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL');

        $this->addSql('INSERT INTO `order_status` (id, name) VALUES (1, "pending"), (2, "completed"), (3, "canceled")');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398ECFF285C');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993986BF700BD');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE `order_status`');
        $this->addSql('ALTER TABLE `table` DROP created_at, DROP updated_at');
    }
}
