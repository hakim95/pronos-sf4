<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180620161402 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE matchs ADD results VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE matchs RENAME INDEX fk_6b1e6041d0d064e2 TO IDX_6B1E6041D0D064E2');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE matchs DROP results');
        $this->addSql('ALTER TABLE matchs RENAME INDEX idx_6b1e6041d0d064e2 TO FK_6B1E6041D0D064E2');
    }
}
