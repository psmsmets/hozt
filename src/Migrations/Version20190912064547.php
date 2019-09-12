<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190912064547 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE member_grouping DROP FOREIGN KEY FK_FF2724F23D8E604F');
        $this->addSql('DROP INDEX IDX_FF2724F23D8E604F ON member_grouping');
        $this->addSql('DROP INDEX UNIQ_FF2724F2989D9B62 ON member_grouping');
        $this->addSql('ALTER TABLE member_grouping DROP parent, DROP fullname, DROP slug');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE member_grouping ADD parent INT DEFAULT NULL, ADD fullname VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD slug VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE member_grouping ADD CONSTRAINT FK_FF2724F23D8E604F FOREIGN KEY (parent) REFERENCES member_grouping (id)');
        $this->addSql('CREATE INDEX IDX_FF2724F23D8E604F ON member_grouping (parent)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FF2724F2989D9B62 ON member_grouping (slug)');
    }
}
