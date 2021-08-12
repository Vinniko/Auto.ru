<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210810190755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE auto (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, mark VARCHAR(255) NOT NULL, build_year DATETIME NOT NULL, INDEX IDX_66BA25FAF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale_announcement (id INT AUTO_INCREMENT NOT NULL, auto_id INT NOT NULL, price NUMERIC(3, 2) NOT NULL, INDEX IDX_7ECB88281D55B925 (auto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE auto ADD CONSTRAINT FK_66BA25FAF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE sale_announcement ADD CONSTRAINT FK_7ECB88281D55B925 FOREIGN KEY (auto_id) REFERENCES auto (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sale_announcement DROP FOREIGN KEY FK_7ECB88281D55B925');
        $this->addSql('ALTER TABLE auto DROP FOREIGN KEY FK_66BA25FAF92F3E70');
        $this->addSql('DROP TABLE auto');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE sale_announcement');
    }
}
