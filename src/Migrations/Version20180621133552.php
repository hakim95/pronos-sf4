<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180621133552 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pronostics ADD pronouser_id INT NOT NULL');
        $this->addSql('ALTER TABLE pronostics ADD CONSTRAINT FK_7A837B047E55179E FOREIGN KEY (pronouser_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_7A837B047E55179E ON pronostics (pronouser_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pronostics DROP FOREIGN KEY FK_7A837B047E55179E');
        $this->addSql('DROP INDEX IDX_7A837B047E55179E ON pronostics');
        $this->addSql('ALTER TABLE pronostics DROP pronouser_id');
    }
}
