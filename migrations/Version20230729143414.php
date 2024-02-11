<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230729143414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carousel ADD image2 VARCHAR(255) DEFAULT NULL, ADD image3 VARCHAR(255) DEFAULT NULL, ADD image4 VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1DD74700E1C4CF6C ON carousel (image2)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1DD7470096C3FFFA ON carousel (image3)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1DD747008A76A59 ON carousel (image4)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_1DD74700E1C4CF6C ON carousel');
        $this->addSql('DROP INDEX UNIQ_1DD7470096C3FFFA ON carousel');
        $this->addSql('DROP INDEX UNIQ_1DD747008A76A59 ON carousel');
        $this->addSql('ALTER TABLE carousel DROP image2, DROP image3, DROP image4');
    }
}
