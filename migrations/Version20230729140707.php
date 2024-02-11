<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230729140707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carousel ADD image1 VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1DD74700C53D045F ON carousel (image)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1DD7470078CD9ED6 ON carousel (image1)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_1DD74700C53D045F ON carousel');
        $this->addSql('DROP INDEX UNIQ_1DD7470078CD9ED6 ON carousel');
        $this->addSql('ALTER TABLE carousel DROP image1');
    }
}
