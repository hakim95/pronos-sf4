<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180620130250 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE matchs ADD groupstage_id INT NOT NULL');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E6041D0D064E2 FOREIGN KEY (groupstage_id) REFERENCES groups (id)');
        $this->addSql('CREATE INDEX IDX_6B1E6041D0D064E2 ON matchs (groupstage_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E6041D0D064E2');
        $this->addSql('DROP INDEX IDX_6B1E6041D0D064E2 ON matchs');
        $this->addSql('ALTER TABLE matchs DROP groupstage_id');
    }
}
