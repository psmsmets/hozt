<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190130072500 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE blog_category ADD default_category TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE competition_state ADD default_state TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE calendar_category ADD default_category TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE competition_pool ADD default_pool TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE blog_category DROP default_category');
        $this->addSql('ALTER TABLE calendar_category DROP default_category');
        $this->addSql('ALTER TABLE competition_pool DROP default_pool');
        $this->addSql('ALTER TABLE competition_state DROP default_state');
    }
}
