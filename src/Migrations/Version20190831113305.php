<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190831113305 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE competition_part (id INT AUTO_INCREMENT NOT NULL, competition_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', part SMALLINT NOT NULL, date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_474CEED47B39D312 (competition_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competition_part ADD CONSTRAINT FK_474CEED47B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id)');
        $this->addSql('DROP TABLE competition_training_team_category');
        $this->addSql('ALTER TABLE competition_enrolment DROP FOREIGN KEY FK_6BAD1D767B39D312');
        $this->addSql('DROP INDEX IDX_6BAD1D767B39D312 ON competition_enrolment');
        $this->addSql('ALTER TABLE competition_enrolment CHANGE competition_id competition_part_id INT NOT NULL');
        $this->addSql('ALTER TABLE competition_enrolment ADD CONSTRAINT FK_6BAD1D7653568B42 FOREIGN KEY (competition_part_id) REFERENCES competition_part (id)');
        $this->addSql('CREATE INDEX IDX_6BAD1D7653568B42 ON competition_enrolment (competition_part_id)');
        $this->addSql('ALTER TABLE competition CHANGE multi_day overnight TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE competition_enrolment DROP FOREIGN KEY FK_6BAD1D7653568B42');
        $this->addSql('CREATE TABLE competition_training_team_category (competition_id INT NOT NULL, training_team_category_id INT NOT NULL, INDEX IDX_EDEC6DCB7B39D312 (competition_id), INDEX IDX_EDEC6DCB48C8CC32 (training_team_category_id), PRIMARY KEY(competition_id, training_team_category_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE competition_training_team_category ADD CONSTRAINT FK_EDEC6DCB48C8CC32 FOREIGN KEY (training_team_category_id) REFERENCES training_team_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competition_training_team_category ADD CONSTRAINT FK_EDEC6DCB7B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE competition_part');
        $this->addSql('ALTER TABLE competition CHANGE overnight multi_day TINYINT(1) NOT NULL');
        $this->addSql('DROP INDEX IDX_6BAD1D7653568B42 ON competition_enrolment');
        $this->addSql('ALTER TABLE competition_enrolment CHANGE competition_part_id competition_id INT NOT NULL');
        $this->addSql('ALTER TABLE competition_enrolment ADD CONSTRAINT FK_6BAD1D767B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id)');
        $this->addSql('CREATE INDEX IDX_6BAD1D767B39D312 ON competition_enrolment (competition_id)');
    }
}
