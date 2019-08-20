<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190820130012 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE training_schedule DROP FOREIGN KEY FK_C5E959FB9C24126');
        $this->addSql('DROP TABLE training_day');
        $this->addSql('ALTER TABLE training_exception DROP enabled');
        $this->addSql('DROP INDEX IDX_BD5D026C9C24126 ON training_schedule');
        $this->addSql('ALTER TABLE training_schedule DROP day_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE training_day (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, abbr VARCHAR(10) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE training_exception ADD enabled TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE training_schedule ADD day_id INT NOT NULL');
        $this->addSql('ALTER TABLE training_schedule ADD CONSTRAINT FK_C5E959FB9C24126 FOREIGN KEY (day_id) REFERENCES training_day (id)');
        $this->addSql('CREATE INDEX IDX_BD5D026C9C24126 ON training_schedule (day_id)');
    }
}
