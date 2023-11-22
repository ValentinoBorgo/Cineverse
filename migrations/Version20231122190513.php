<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231122190513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cliente DROP FOREIGN KEY FK_F41C9B25189E045D');
        $this->addSql('DROP INDEX UNIQ_F41C9B25189E045D ON cliente');
        $this->addSql('ALTER TABLE cliente DROP suscripcion_id, CHANGE one_to_one nombre_usuario VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE titulo ADD descripcion VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cliente ADD suscripcion_id INT DEFAULT NULL, CHANGE nombre_usuario one_to_one VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE cliente ADD CONSTRAINT FK_F41C9B25189E045D FOREIGN KEY (suscripcion_id) REFERENCES suscripcion (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F41C9B25189E045D ON cliente (suscripcion_id)');
        $this->addSql('ALTER TABLE titulo DROP descripcion');
    }
}
