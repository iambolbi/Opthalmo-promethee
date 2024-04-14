<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240414164517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tprestation (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, valeur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trendez_prestation (id INT AUTO_INCREMENT NOT NULL, fk_prestation_id INT DEFAULT NULL, fk_assurance_id INT DEFAULT NULL, fk_rendez_vous_id INT DEFAULT NULL, fk_medecin_id INT DEFAULT NULL, INDEX IDX_E8D21163FA0FB096 (fk_prestation_id), INDEX IDX_E8D211639355C1FA (fk_assurance_id), INDEX IDX_E8D21163E4E19743 (fk_rendez_vous_id), INDEX IDX_E8D21163F49DD017 (fk_medecin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trole (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, roles JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tuser_role (id INT AUTO_INCREMENT NOT NULL, fk_login_id INT DEFAULT NULL, fk_role_id INT DEFAULT NULL, INDEX IDX_D7C99F996E9AA383 (fk_login_id), INDEX IDX_D7C99F99262C1F80 (fk_role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trendez_prestation ADD CONSTRAINT FK_E8D21163FA0FB096 FOREIGN KEY (fk_prestation_id) REFERENCES tprestation (id)');
        $this->addSql('ALTER TABLE trendez_prestation ADD CONSTRAINT FK_E8D211639355C1FA FOREIGN KEY (fk_assurance_id) REFERENCES t_assurance (id)');
        $this->addSql('ALTER TABLE trendez_prestation ADD CONSTRAINT FK_E8D21163E4E19743 FOREIGN KEY (fk_rendez_vous_id) REFERENCES t_rendez_vous (id)');
        $this->addSql('ALTER TABLE trendez_prestation ADD CONSTRAINT FK_E8D21163F49DD017 FOREIGN KEY (fk_medecin_id) REFERENCES t_medecin (id)');
        $this->addSql('ALTER TABLE tuser_role ADD CONSTRAINT FK_D7C99F996E9AA383 FOREIGN KEY (fk_login_id) REFERENCES t_login (id)');
        $this->addSql('ALTER TABLE tuser_role ADD CONSTRAINT FK_D7C99F99262C1F80 FOREIGN KEY (fk_role_id) REFERENCES trole (id)');
        $this->addSql('ALTER TABLE t_rendez_vous ADD fk_login_id INT DEFAULT NULL, ADD fk_patient_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE t_rendez_vous ADD CONSTRAINT FK_35B98E0B6E9AA383 FOREIGN KEY (fk_login_id) REFERENCES t_login (id)');
        $this->addSql('ALTER TABLE t_rendez_vous ADD CONSTRAINT FK_35B98E0B9BE758EA FOREIGN KEY (fk_patient_id) REFERENCES t_patient (id)');
        $this->addSql('CREATE INDEX IDX_35B98E0B6E9AA383 ON t_rendez_vous (fk_login_id)');
        $this->addSql('CREATE INDEX IDX_35B98E0B9BE758EA ON t_rendez_vous (fk_patient_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trendez_prestation DROP FOREIGN KEY FK_E8D21163FA0FB096');
        $this->addSql('ALTER TABLE trendez_prestation DROP FOREIGN KEY FK_E8D211639355C1FA');
        $this->addSql('ALTER TABLE trendez_prestation DROP FOREIGN KEY FK_E8D21163E4E19743');
        $this->addSql('ALTER TABLE trendez_prestation DROP FOREIGN KEY FK_E8D21163F49DD017');
        $this->addSql('ALTER TABLE tuser_role DROP FOREIGN KEY FK_D7C99F996E9AA383');
        $this->addSql('ALTER TABLE tuser_role DROP FOREIGN KEY FK_D7C99F99262C1F80');
        $this->addSql('DROP TABLE tprestation');
        $this->addSql('DROP TABLE trendez_prestation');
        $this->addSql('DROP TABLE trole');
        $this->addSql('DROP TABLE tuser_role');
        $this->addSql('ALTER TABLE t_rendez_vous DROP FOREIGN KEY FK_35B98E0B6E9AA383');
        $this->addSql('ALTER TABLE t_rendez_vous DROP FOREIGN KEY FK_35B98E0B9BE758EA');
        $this->addSql('DROP INDEX IDX_35B98E0B6E9AA383 ON t_rendez_vous');
        $this->addSql('DROP INDEX IDX_35B98E0B9BE758EA ON t_rendez_vous');
        $this->addSql('ALTER TABLE t_rendez_vous DROP fk_login_id, DROP fk_patient_id');
    }
}
