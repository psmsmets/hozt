<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190507080531 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tryout_enrolment (id INT AUTO_INCREMENT NOT NULL, tryout_id INT NOT NULL, category_id INT NOT NULL, uuid VARCHAR(128) NOT NULL, enrolled_at DATETIME NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, telephone VARCHAR(15) NOT NULL, birthdate DATE NOT NULL, address VARCHAR(255) NOT NULL, message LONGTEXT DEFAULT NULL, email_sent TINYINT(1) NOT NULL, withdrawn TINYINT(1) NOT NULL, withdrawn_at DATETIME DEFAULT NULL, INDEX IDX_B8C5D372690E7CBB (tryout_id), INDEX IDX_B8C5D37212469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tryout (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(128) NOT NULL, enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, start_time DATETIME NOT NULL, end_time DATETIME NOT NULL, max_enrolments INT NOT NULL, publish_at DATETIME NOT NULL, description VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F2FF0646D17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tryout_enrolment ADD CONSTRAINT FK_B8C5D372690E7CBB FOREIGN KEY (tryout_id) REFERENCES tryout (id)');
        $this->addSql('ALTER TABLE tryout_enrolment ADD CONSTRAINT FK_B8C5D37212469DE2 FOREIGN KEY (category_id) REFERENCES training_team_category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tryout_enrolment DROP FOREIGN KEY FK_B8C5D372690E7CBB');
        $this->addSql('DROP TABLE tryout_enrolment');
        $this->addSql('DROP TABLE tryout');
    }
}
