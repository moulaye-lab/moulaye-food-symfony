<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210428163400 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commandes ADD table_resto INT NOT NULL, CHANGE tables_id tables_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282CA3B324E0 FOREIGN KEY (tables_id_id) REFERENCES tables (id)');
        $this->addSql('CREATE INDEX IDX_35D4282CA3B324E0 ON commandes (tables_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282CA3B324E0');
        $this->addSql('DROP INDEX IDX_35D4282CA3B324E0 ON commandes');
        $this->addSql('ALTER TABLE commandes ADD tables_id INT NOT NULL, DROP tables_id_id, DROP table_resto');
    }
}
