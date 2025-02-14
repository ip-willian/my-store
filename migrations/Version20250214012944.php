<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250214012944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO product(id, name) VALUES (1, "Computer")');
        $this->addSql('INSERT INTO product(id, name) VALUES (2, "Monitor")');
        $this->addSql('INSERT INTO product(id, name) VALUES (3, "Mouse")');
        $this->addSql('INSERT INTO product(id, name) VALUES (4, "Keyboard")');
        $this->addSql('INSERT INTO product(id, name) VALUES (5, "Macbook Air")');
        $this->addSql('INSERT INTO product(id, name) VALUES (6, "Macbook Pro")');
        $this->addSql('INSERT INTO product(id, name) VALUES (7, "Headphone")');
        $this->addSql('INSERT INTO product(id, name) VALUES (8, "Presidential Chair")');
        $this->addSql('INSERT INTO product(id, name) VALUES (9, "Gamer Chair")');
        $this->addSql('INSERT INTO product(id, name) VALUES (10, "Executive Chair")');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
