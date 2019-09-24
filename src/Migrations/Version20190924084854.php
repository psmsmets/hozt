<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190924084854 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE competition_enrolment DROP FOREIGN KEY FK_6BAD1D767597D3FE');
        $this->addSql('DROP INDEX IDX_6BAD1D767597D3FE ON competition_enrolment');
        $this->addSql('ALTER TABLE competition_enrolment CHANGE member_id competitor_id INT NOT NULL');
        $this->addSql('ALTER TABLE competition_enrolment ADD CONSTRAINT FK_6BAD1D7678A5D405 FOREIGN KEY (competitor_id) REFERENCES member (id)');
        $this->addSql('CREATE INDEX IDX_6BAD1D7678A5D405 ON competition_enrolment (competitor_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE competition_enrolment DROP FOREIGN KEY FK_6BAD1D7678A5D405');
        $this->addSql('DROP INDEX IDX_6BAD1D7678A5D405 ON competition_enrolment');
        $this->addSql('ALTER TABLE competition_enrolment CHANGE competitor_id member_id INT NOT NULL');
        $this->addSql('ALTER TABLE competition_enrolment ADD CONSTRAINT FK_6BAD1D767597D3FE FOREIGN KEY (member_id) REFERENCES member (id)');
        $this->addSql('CREATE INDEX IDX_6BAD1D767597D3FE ON competition_enrolment (member_id)');
    }
}
