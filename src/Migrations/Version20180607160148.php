<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180607160148 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE match_team DROP FOREIGN KEY FK_A58F176D2ABEACD6');
        $this->addSql('CREATE TABLE matchs (id INT AUTO_INCREMENT NOT NULL, matchgroup TINYINT(1) NOT NULL, appearance INT NOT NULL, step VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matchs_team (matchs_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_57C16CE888EB7468 (matchs_id), INDEX IDX_57C16CE8296CD8AE (team_id), PRIMARY KEY(matchs_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE matchs_team ADD CONSTRAINT FK_57C16CE888EB7468 FOREIGN KEY (matchs_id) REFERENCES matchs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matchs_team ADD CONSTRAINT FK_57C16CE8296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE `match`');
        $this->addSql('DROP TABLE match_team');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE matchs_team DROP FOREIGN KEY FK_57C16CE888EB7468');
        $this->addSql('CREATE TABLE `match` (id INT AUTO_INCREMENT NOT NULL, matchgroup TINYINT(1) NOT NULL, appearance INT NOT NULL, step VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE match_team (match_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_A58F176D2ABEACD6 (match_id), INDEX IDX_A58F176D296CD8AE (team_id), PRIMARY KEY(match_id, team_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE match_team ADD CONSTRAINT FK_A58F176D296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE match_team ADD CONSTRAINT FK_A58F176D2ABEACD6 FOREIGN KEY (match_id) REFERENCES `match` (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE matchs');
        $this->addSql('DROP TABLE matchs_team');
    }
}
