<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210811062118 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sale_announcement DROP FOREIGN KEY FK_7ECB88281D55B925');
        $this->addSql('ALTER TABLE auto DROP FOREIGN KEY FK_66BA25FAF92F3E70');
        $this->addSql('CREATE TABLE `autos` (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, mark VARCHAR(255) NOT NULL, build_year DATETIME NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_46006E2CF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `countries` (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `sale_announcements` (id INT AUTO_INCREMENT NOT NULL, auto_id INT NOT NULL, price NUMERIC(10, 2) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_2EC5AC791D55B925 (auto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `autos` ADD CONSTRAINT FK_46006E2CF92F3E70 FOREIGN KEY (country_id) REFERENCES `countries` (id)');
        $this->addSql('ALTER TABLE `sale_announcements` ADD CONSTRAINT FK_2EC5AC791D55B925 FOREIGN KEY (auto_id) REFERENCES `autos` (id)');
        $this->addSql('DROP TABLE auto');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE sale_announcement');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `sale_announcements` DROP FOREIGN KEY FK_2EC5AC791D55B925');
        $this->addSql('ALTER TABLE `autos` DROP FOREIGN KEY FK_46006E2CF92F3E70');
        $this->addSql('CREATE TABLE auto (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, mark VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, build_year DATETIME NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_66BA25FAF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sale_announcement (id INT AUTO_INCREMENT NOT NULL, auto_id INT NOT NULL, price NUMERIC(10, 2) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_7ECB88281D55B925 (auto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE auto ADD CONSTRAINT FK_66BA25FAF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE sale_announcement ADD CONSTRAINT FK_7ECB88281D55B925 FOREIGN KEY (auto_id) REFERENCES auto (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE `autos`');
        $this->addSql('DROP TABLE `countries`');
        $this->addSql('DROP TABLE `sale_announcements`');
    }
}
