<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190220115904 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE competition_document_category CHANGE name title VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE competition_document CHANGE name document VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE blog_post DROP views');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE blog_post ADD views INT NOT NULL');
        $this->addSql('ALTER TABLE competition_document CHANGE document name VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE competition_document_category CHANGE title name VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
