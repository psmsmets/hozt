<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190227212508 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE calendar_event ADD static_page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE calendar_event ADD CONSTRAINT FK_57FA09C995C43776 FOREIGN KEY (static_page_id) REFERENCES static_page (id)');
        $this->addSql('CREATE INDEX IDX_57FA09C995C43776 ON calendar_event (static_page_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE calendar_event DROP FOREIGN KEY FK_57FA09C995C43776');
        $this->addSql('DROP INDEX IDX_57FA09C995C43776 ON calendar_event');
        $this->addSql('ALTER TABLE calendar_event DROP static_page_id');
    }
}
