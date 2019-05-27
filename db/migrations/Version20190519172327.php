<?php

declare(strict_types=1);

namespace Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190519172327 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Game (id INT AUTO_INCREMENT NOT NULL, sizeField INT NOT NULL, duration INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE GameResult (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, step INT NOT NULL, message VARCHAR(255) DEFAULT NULL, fields LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_E39052E6E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE GameResult ADD CONSTRAINT FK_E39052E6E48FD905 FOREIGN KEY (game_id) REFERENCES Game (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE GameResult DROP FOREIGN KEY FK_E39052E6E48FD905');
        $this->addSql('DROP TABLE Game');
        $this->addSql('DROP TABLE GameResult');
    }
}
