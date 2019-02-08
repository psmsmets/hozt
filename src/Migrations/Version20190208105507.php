<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190208105507 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE training_schedule_exception (id INT AUTO_INCREMENT NOT NULL, enabled TINYINT(1) NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, comment VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training_schedule_exception_training_schedule (training_schedule_exception_id INT NOT NULL, training_schedule_id INT NOT NULL, INDEX IDX_CA36DACA8BFD5DD4 (training_schedule_exception_id), INDEX IDX_CA36DACA60B802 (training_schedule_id), PRIMARY KEY(training_schedule_exception_id, training_schedule_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training_schedule_exception_training_team (training_schedule_exception_id INT NOT NULL, training_team_id INT NOT NULL, INDEX IDX_973FBA738BFD5DD4 (training_schedule_exception_id), INDEX IDX_973FBA73F45248A0 (training_team_id), PRIMARY KEY(training_schedule_exception_id, training_team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE training_schedule_exception_training_schedule ADD CONSTRAINT FK_CA36DACA8BFD5DD4 FOREIGN KEY (training_schedule_exception_id) REFERENCES training_schedule_exception (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE training_schedule_exception_training_schedule ADD CONSTRAINT FK_CA36DACA60B802 FOREIGN KEY (training_schedule_id) REFERENCES training_schedule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE training_schedule_exception_training_team ADD CONSTRAINT FK_973FBA738BFD5DD4 FOREIGN KEY (training_schedule_exception_id) REFERENCES training_schedule_exception (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE training_schedule_exception_training_team ADD CONSTRAINT FK_973FBA73F45248A0 FOREIGN KEY (training_team_id) REFERENCES training_team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE training_schedule ADD persistent TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE training_schedule_exception_training_schedule DROP FOREIGN KEY FK_CA36DACA8BFD5DD4');
        $this->addSql('ALTER TABLE training_schedule_exception_training_team DROP FOREIGN KEY FK_973FBA738BFD5DD4');
        $this->addSql('DROP TABLE training_schedule_exception');
        $this->addSql('DROP TABLE training_schedule_exception_training_schedule');
        $this->addSql('DROP TABLE training_schedule_exception_training_team');
        $this->addSql('ALTER TABLE training_schedule DROP persistent');
    }
}
