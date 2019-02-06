<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190206111618 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE carousel_slide ADD event_id INT DEFAULT NULL, ADD url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE carousel_slide ADD CONSTRAINT FK_BD7937A471F7E88B FOREIGN KEY (event_id) REFERENCES calendar_event (id)');
        $this->addSql('CREATE INDEX IDX_BD7937A471F7E88B ON carousel_slide (event_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE carousel_slide DROP FOREIGN KEY FK_BD7937A471F7E88B');
        $this->addSql('DROP INDEX IDX_BD7937A471F7E88B ON carousel_slide');
        $this->addSql('ALTER TABLE carousel_slide DROP event_id, DROP url');
    }
}
