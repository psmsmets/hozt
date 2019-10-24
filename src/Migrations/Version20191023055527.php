<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191023055527 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE enrolment_input (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, event_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, help VARCHAR(255) DEFAULT NULL, value DOUBLE PRECISION DEFAULT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_37F56E1D12469DE2 (category_id), INDEX IDX_37F56E1D71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE enrolment_input ADD CONSTRAINT FK_37F56E1D12469DE2 FOREIGN KEY (category_id) REFERENCES enrolment_input_category (id)');
        $this->addSql('ALTER TABLE enrolment_input ADD CONSTRAINT FK_37F56E1D71F7E88B FOREIGN KEY (event_id) REFERENCES enrolment_event (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE enrolment_input');
    }
}
