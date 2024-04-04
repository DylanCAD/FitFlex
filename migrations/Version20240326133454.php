<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240326133454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD nom_user VARCHAR(255) NOT NULL, ADD prenom_user VARCHAR(255) NOT NULL, ADD sexe_user INT NOT NULL, ADD avatar_user VARCHAR(255) DEFAULT NULL, ADD age_user INT DEFAULT NULL, ADD taille_user DOUBLE PRECISION DEFAULT NULL, ADD poids_user DOUBLE PRECISION DEFAULT NULL, ADD level_user VARCHAR(255) DEFAULT NULL, ADD objectif_user VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP nom_user, DROP prenom_user, DROP sexe_user, DROP avatar_user, DROP age_user, DROP taille_user, DROP poids_user, DROP level_user, DROP objectif_user');
    }
}
