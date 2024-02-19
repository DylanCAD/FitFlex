<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240206132406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exercice_musculation_type_exercice_musculation (exercice_musculation_id INT NOT NULL, type_exercice_musculation_id INT NOT NULL, INDEX IDX_7E34EFFAE7880B7F (exercice_musculation_id), INDEX IDX_7E34EFFAB1EA0FCC (type_exercice_musculation_id), PRIMARY KEY(exercice_musculation_id, type_exercice_musculation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_exercice_musculation (id INT AUTO_INCREMENT NOT NULL, nom_type_exercice_musculation VARCHAR(255) NOT NULL, image_type_exercice_musculation VARCHAR(255) DEFAULT NULL, titre_type_exercice_musculation VARCHAR(255) DEFAULT NULL, description_type_exercice_musculation LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exercice_musculation_type_exercice_musculation ADD CONSTRAINT FK_7E34EFFAE7880B7F FOREIGN KEY (exercice_musculation_id) REFERENCES exercice_musculation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercice_musculation_type_exercice_musculation ADD CONSTRAINT FK_7E34EFFAB1EA0FCC FOREIGN KEY (type_exercice_musculation_id) REFERENCES type_exercice_musculation (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercice_musculation_type_exercice_musculation DROP FOREIGN KEY FK_7E34EFFAE7880B7F');
        $this->addSql('ALTER TABLE exercice_musculation_type_exercice_musculation DROP FOREIGN KEY FK_7E34EFFAB1EA0FCC');
        $this->addSql('DROP TABLE exercice_musculation_type_exercice_musculation');
        $this->addSql('DROP TABLE type_exercice_musculation');
    }
}
