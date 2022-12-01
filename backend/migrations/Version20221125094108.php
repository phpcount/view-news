<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221125094108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post ALTER text_overview DROP NOT NULL');
        $this->addSql('ALTER TABLE post ALTER image DROP NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A8A6C8D108B7592 ON post (original_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE post ALTER text_overview SET NOT NULL');
        $this->addSql('ALTER TABLE post ALTER image SET NOT NULL');
        $this->addSql('DROP INDEX UNIQ_5A8A6C8D108B7592');
    }
}
