<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231201182916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cliente (id INT AUTO_INCREMENT NOT NULL, tipo_suscripcion_id INT DEFAULT NULL, cliente_suscripcion_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, contraseña VARCHAR(255) NOT NULL, correo_electronico VARCHAR(255) NOT NULL, rol JSON NOT NULL, nombre_usuario VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F41C9B25944DCBFD (tipo_suscripcion_id), INDEX IDX_F41C9B25BC6AFBEE (cliente_suscripcion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cliente_titulo (cliente_id INT NOT NULL, titulo_id INT NOT NULL, INDEX IDX_A872D211DE734E51 (cliente_id), INDEX IDX_A872D21161AD3496 (titulo_id), PRIMARY KEY(cliente_id, titulo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suscripcion (id INT AUTO_INCREMENT NOT NULL, fecha_caducidad VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_suscripcion (id INT AUTO_INCREMENT NOT NULL, precio INT NOT NULL, meses_restantes INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE titulo (id INT AUTO_INCREMENT NOT NULL, titulo VARCHAR(255) DEFAULT NULL, tipo VARCHAR(255) DEFAULT NULL, genero VARCHAR(255) NOT NULL, actores_principales VARCHAR(255) NOT NULL, descripcion VARCHAR(2083) NOT NULL, fecha_lanzamiento VARCHAR(255) NOT NULL, me_gusta INT NOT NULL, comentario JSON NOT NULL, premium JSON NOT NULL, imagen VARCHAR(2083) NOT NULL, video VARCHAR(2083) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cliente ADD CONSTRAINT FK_F41C9B25944DCBFD FOREIGN KEY (tipo_suscripcion_id) REFERENCES tipo_suscripcion (id)');
        $this->addSql('ALTER TABLE cliente ADD CONSTRAINT FK_F41C9B25BC6AFBEE FOREIGN KEY (cliente_suscripcion_id) REFERENCES suscripcion (id)');
        $this->addSql('ALTER TABLE cliente_titulo ADD CONSTRAINT FK_A872D211DE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cliente_titulo ADD CONSTRAINT FK_A872D21161AD3496 FOREIGN KEY (titulo_id) REFERENCES titulo (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cliente DROP FOREIGN KEY FK_F41C9B25944DCBFD');
        $this->addSql('ALTER TABLE cliente DROP FOREIGN KEY FK_F41C9B25BC6AFBEE');
        $this->addSql('ALTER TABLE cliente_titulo DROP FOREIGN KEY FK_A872D211DE734E51');
        $this->addSql('ALTER TABLE cliente_titulo DROP FOREIGN KEY FK_A872D21161AD3496');
        $this->addSql('DROP TABLE cliente');
        $this->addSql('DROP TABLE cliente_titulo');
        $this->addSql('DROP TABLE suscripcion');
        $this->addSql('DROP TABLE tipo_suscripcion');
        $this->addSql('DROP TABLE titulo');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
