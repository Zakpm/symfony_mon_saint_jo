<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230729165634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE advertising ADD image1 VARCHAR(255) DEFAULT NULL, ADD image2 VARCHAR(255) DEFAULT NULL, ADD image3 VARCHAR(255) DEFAULT NULL, ADD image4 VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_50219E7878CD9ED6 ON advertising (image1)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_50219E78E1C4CF6C ON advertising (image2)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_50219E7896C3FFFA ON advertising (image3)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_50219E788A76A59 ON advertising (image4)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_50219E7878CD9ED6 ON advertising');
        $this->addSql('DROP INDEX UNIQ_50219E78E1C4CF6C ON advertising');
        $this->addSql('DROP INDEX UNIQ_50219E7896C3FFFA ON advertising');
        $this->addSql('DROP INDEX UNIQ_50219E788A76A59 ON advertising');
        $this->addSql('ALTER TABLE advertising DROP image1, DROP image2, DROP image3, DROP image4');
    }
}
