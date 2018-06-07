<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180607143843 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE team DROP FOREIGN KEY IDX_C4E0A61FD0D064E2');
        $this->addSql('CREATE TABLE groups (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61FD0D064E2');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61FD0D064E2 FOREIGN KEY (groupstage_id) REFERENCES groups (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61FD0D064E2');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE groups');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61FD0D064E2');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61FD0D064E2 FOREIGN KEY (groupstage_id) REFERENCES `group` (id)');
    }
}
