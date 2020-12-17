<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201108130758 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories_menu ADD proprietaire_id INT NOT NULL');
        $this->addSql('ALTER TABLE categories_menu ADD CONSTRAINT FK_A536621576C50E4A FOREIGN KEY (proprietaire_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_A536621576C50E4A ON categories_menu (proprietaire_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories_menu DROP FOREIGN KEY FK_A536621576C50E4A');
        $this->addSql('DROP INDEX IDX_A536621576C50E4A ON categories_menu');
        $this->addSql('ALTER TABLE categories_menu DROP proprietaire_id');
    }
}
