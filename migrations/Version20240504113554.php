<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240504113554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tlog (id INT AUTO_INCREMENT NOT NULL, fk_login_id INT DEFAULT NULL, uri VARCHAR(255) DEFAULT NULL, method VARCHAR(255) DEFAULT NULL, ip VARCHAR(255) DEFAULT NULL, status_code VARCHAR(255) DEFAULT NULL, action VARCHAR(255) DEFAULT NULL, message VARCHAR(255) DEFAULT NULL, state TINYINT(1) DEFAULT NULL, edit TINYINT(1) DEFAULT NULL, date DATETIME DEFAULT NULL, date_edit DATETIME DEFAULT NULL, date_delete DATETIME DEFAULT NULL, INDEX IDX_B56759006E9AA383 (fk_login_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tlog ADD CONSTRAINT FK_B56759006E9AA383 FOREIGN KEY (fk_login_id) REFERENCES t_login (id)');
        $this->addSql('ALTER TABLE t_rendez_vous ADD code VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tlog DROP FOREIGN KEY FK_B56759006E9AA383');
        $this->addSql('DROP TABLE tlog');
        $this->addSql('ALTER TABLE t_rendez_vous DROP code');
    }
}
