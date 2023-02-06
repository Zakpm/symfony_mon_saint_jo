<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230206140156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE post_city (post_id INT NOT NULL, city_id INT NOT NULL, INDEX IDX_E40E653F4B89032C (post_id), INDEX IDX_E40E653F8BAC62AF (city_id), PRIMARY KEY(post_id, city_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post_city ADD CONSTRAINT FK_E40E653F4B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_city ADD CONSTRAINT FK_E40E653F8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_city DROP FOREIGN KEY FK_E40E653F4B89032C');
        $this->addSql('ALTER TABLE post_city DROP FOREIGN KEY FK_E40E653F8BAC62AF');
        $this->addSql('DROP TABLE post_city');
    }
}
