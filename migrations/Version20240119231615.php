<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240119231615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recette_negative (id INT AUTO_INCREMENT NOT NULL, nom_recette_negative VARCHAR(255) NOT NULL, image_recette_negative VARCHAR(255) DEFAULT NULL, personne_recette_negative VARCHAR(255) DEFAULT NULL, preparation_recette_negative LONGTEXT DEFAULT NULL, cuisson_recette_negative VARCHAR(255) DEFAULT NULL, ingredient_recette_negative LONGTEXT DEFAULT NULL, preparationduree_recette_negative VARCHAR(255) DEFAULT NULL, type_recette_negative VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE recette_negative');
    }
}
