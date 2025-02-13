<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250213220908 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE issue (id INT AUTO_INCREMENT NOT NULL, order_issue_id INT DEFAULT NULL, cause VARCHAR(1) NOT NULL, message LONGTEXT NOT NULL, is_fixed TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_12AD233EBF82473D (order_issue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE logger (id INT AUTO_INCREMENT NOT NULL, order_to_log_id INT DEFAULT NULL, created_at DATETIME NOT NULL, order_status VARCHAR(1) NOT NULL, message LONGTEXT NOT NULL, INDEX IDX_987E13F370322AE3 (order_to_log_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(1) NOT NULL, total DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, discount DOUBLE PRECISION NOT NULL, address VARCHAR(255) NOT NULL, address_number VARCHAR(20) NOT NULL, postal_code VARCHAR(20) NOT NULL, city VARCHAR(100) NOT NULL, box_id VARCHAR(100) DEFAULT NULL, has_issue TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, quote_id INT DEFAULT NULL, amount INT NOT NULL, unity_price DOUBLE PRECISION NOT NULL, INDEX IDX_52EA1F094584665A (product_id), INDEX IDX_52EA1F09DB805178 (quote_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_shipping (id INT AUTO_INCREMENT NOT NULL, order_to_ship_id INT DEFAULT NULL, company VARCHAR(150) NOT NULL, tracking_number VARCHAR(20) NOT NULL, shipping_label VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_CCE4F595FF14F1DD (order_to_ship_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picking (id INT AUTO_INCREMENT NOT NULL, order_picked_id INT DEFAULT NULL, owner_id INT DEFAULT NULL, status VARCHAR(1) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_3E46E25C1723AB9 (order_picked_id), INDEX IDX_3E46E257E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE issue ADD CONSTRAINT FK_12AD233EBF82473D FOREIGN KEY (order_issue_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE logger ADD CONSTRAINT FK_987E13F370322AE3 FOREIGN KEY (order_to_log_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F094584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09DB805178 FOREIGN KEY (quote_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_shipping ADD CONSTRAINT FK_CCE4F595FF14F1DD FOREIGN KEY (order_to_ship_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE picking ADD CONSTRAINT FK_3E46E25C1723AB9 FOREIGN KEY (order_picked_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE picking ADD CONSTRAINT FK_3E46E257E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE issue DROP FOREIGN KEY FK_12AD233EBF82473D');
        $this->addSql('ALTER TABLE logger DROP FOREIGN KEY FK_987E13F370322AE3');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F094584665A');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09DB805178');
        $this->addSql('ALTER TABLE order_shipping DROP FOREIGN KEY FK_CCE4F595FF14F1DD');
        $this->addSql('ALTER TABLE picking DROP FOREIGN KEY FK_3E46E25C1723AB9');
        $this->addSql('ALTER TABLE picking DROP FOREIGN KEY FK_3E46E257E3C61F9');
        $this->addSql('DROP TABLE issue');
        $this->addSql('DROP TABLE logger');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE order_shipping');
        $this->addSql('DROP TABLE picking');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
