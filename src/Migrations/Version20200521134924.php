<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200521134924 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE appointment CHANGE doctor_id doctor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE doctor CHANGE speciality_id speciality_id INT DEFAULT NULL, CHANGE address address VARCHAR(255) DEFAULT NULL, CHANGE img img VARCHAR(255) DEFAULT NULL, CHANGE lastname lastname VARCHAR(255) DEFAULT NULL, CHANGE b b TINYINT(1) DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD name VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) NOT NULL, ADD to_id VARCHAR(255) NOT NULL, ADD to_name VARCHAR(255) DEFAULT NULL, ADD to_lastname VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE post CHANGE nb_comments nb_comments INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON DEFAULT NULL COMMENT \'(DC2Type:json_array)\', CHANGE role role VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE appointment CHANGE doctor_id doctor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE doctor CHANGE speciality_id speciality_id INT DEFAULT NULL, CHANGE address address VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE img img VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE lastname lastname VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE b b TINYINT(1) DEFAULT \'NULL\', CHANGE image image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE message DROP name, DROP lastname, DROP to_id, DROP to_name, DROP to_lastname');
        $this->addSql('ALTER TABLE post CHANGE nb_comments nb_comments INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_bin` COMMENT \'(DC2Type:json_array)\', CHANGE role role VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
