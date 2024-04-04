<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240404090734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favorite_exercise ADD type_exercice_musculation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE favorite_exercise ADD CONSTRAINT FK_48DCDEDB1EA0FCC FOREIGN KEY (type_exercice_musculation_id) REFERENCES type_exercice_musculation (id)');
        $this->addSql('CREATE INDEX IDX_48DCDEDB1EA0FCC ON favorite_exercise (type_exercice_musculation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favorite_exercise DROP FOREIGN KEY FK_48DCDEDB1EA0FCC');
        $this->addSql('DROP INDEX IDX_48DCDEDB1EA0FCC ON favorite_exercise');
        $this->addSql('ALTER TABLE favorite_exercise DROP type_exercice_musculation_id');
    }
}
