<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230930225049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cliente (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, contraseña VARCHAR(50) NOT NULL, correo VARCHAR(50) NOT NULL, suscripcion TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE documental (id INT AUTO_INCREMENT NOT NULL, titulo VARCHAR(50) NOT NULL, genero VARCHAR(50) NOT NULL, director VARCHAR(50) NOT NULL, actores_principales VARCHAR(50) NOT NULL, año_lanzamiento INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE documental_cliente (documental_id INT NOT NULL, cliente_id INT NOT NULL, INDEX IDX_DD2A5905701101F1 (documental_id), INDEX IDX_DD2A5905DE734E51 (cliente_id), PRIMARY KEY(documental_id, cliente_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE interaccion (id INT AUTO_INCREMENT NOT NULL, me_gusta TINYINT(1) NOT NULL, comentario VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE interaccion_cliente (interaccion_id INT NOT NULL, cliente_id INT NOT NULL, INDEX IDX_ECDAA8372A144CCF (interaccion_id), INDEX IDX_ECDAA837DE734E51 (cliente_id), PRIMARY KEY(interaccion_id, cliente_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE interaccion_serie (interaccion_id INT NOT NULL, serie_id INT NOT NULL, INDEX IDX_6FDACD702A144CCF (interaccion_id), INDEX IDX_6FDACD70D94388BD (serie_id), PRIMARY KEY(interaccion_id, serie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE interaccion_pelicula (interaccion_id INT NOT NULL, pelicula_id INT NOT NULL, INDEX IDX_801DC7EE2A144CCF (interaccion_id), INDEX IDX_801DC7EE70713909 (pelicula_id), PRIMARY KEY(interaccion_id, pelicula_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE interaccion_documental (interaccion_id INT NOT NULL, documental_id INT NOT NULL, INDEX IDX_94FD7CFE2A144CCF (interaccion_id), INDEX IDX_94FD7CFE701101F1 (documental_id), PRIMARY KEY(interaccion_id, documental_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pelicula (id INT AUTO_INCREMENT NOT NULL, titulo VARCHAR(50) NOT NULL, genero VARCHAR(50) NOT NULL, actores_principales VARCHAR(50) NOT NULL, año_lanzamiento INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pelicula_cliente (pelicula_id INT NOT NULL, cliente_id INT NOT NULL, INDEX IDX_D82659F770713909 (pelicula_id), INDEX IDX_D82659F7DE734E51 (cliente_id), PRIMARY KEY(pelicula_id, cliente_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serie (id INT AUTO_INCREMENT NOT NULL, titulo VARCHAR(50) NOT NULL, genero VARCHAR(50) NOT NULL, director VARCHAR(50) NOT NULL, actores_principales VARCHAR(50) NOT NULL, año_lanzamiento INT NOT NULL, cantidad_capitulos INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serie_cliente (serie_id INT NOT NULL, cliente_id INT NOT NULL, INDEX IDX_C085E882D94388BD (serie_id), INDEX IDX_C085E882DE734E51 (cliente_id), PRIMARY KEY(serie_id, cliente_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE documental_cliente ADD CONSTRAINT FK_DD2A5905701101F1 FOREIGN KEY (documental_id) REFERENCES documental (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE documental_cliente ADD CONSTRAINT FK_DD2A5905DE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interaccion_cliente ADD CONSTRAINT FK_ECDAA8372A144CCF FOREIGN KEY (interaccion_id) REFERENCES interaccion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interaccion_cliente ADD CONSTRAINT FK_ECDAA837DE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interaccion_serie ADD CONSTRAINT FK_6FDACD702A144CCF FOREIGN KEY (interaccion_id) REFERENCES interaccion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interaccion_serie ADD CONSTRAINT FK_6FDACD70D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interaccion_pelicula ADD CONSTRAINT FK_801DC7EE2A144CCF FOREIGN KEY (interaccion_id) REFERENCES interaccion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interaccion_pelicula ADD CONSTRAINT FK_801DC7EE70713909 FOREIGN KEY (pelicula_id) REFERENCES pelicula (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interaccion_documental ADD CONSTRAINT FK_94FD7CFE2A144CCF FOREIGN KEY (interaccion_id) REFERENCES interaccion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interaccion_documental ADD CONSTRAINT FK_94FD7CFE701101F1 FOREIGN KEY (documental_id) REFERENCES documental (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pelicula_cliente ADD CONSTRAINT FK_D82659F770713909 FOREIGN KEY (pelicula_id) REFERENCES pelicula (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pelicula_cliente ADD CONSTRAINT FK_D82659F7DE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE serie_cliente ADD CONSTRAINT FK_C085E882D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE serie_cliente ADD CONSTRAINT FK_C085E882DE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE documental_cliente DROP FOREIGN KEY FK_DD2A5905701101F1');
        $this->addSql('ALTER TABLE documental_cliente DROP FOREIGN KEY FK_DD2A5905DE734E51');
        $this->addSql('ALTER TABLE interaccion_cliente DROP FOREIGN KEY FK_ECDAA8372A144CCF');
        $this->addSql('ALTER TABLE interaccion_cliente DROP FOREIGN KEY FK_ECDAA837DE734E51');
        $this->addSql('ALTER TABLE interaccion_serie DROP FOREIGN KEY FK_6FDACD702A144CCF');
        $this->addSql('ALTER TABLE interaccion_serie DROP FOREIGN KEY FK_6FDACD70D94388BD');
        $this->addSql('ALTER TABLE interaccion_pelicula DROP FOREIGN KEY FK_801DC7EE2A144CCF');
        $this->addSql('ALTER TABLE interaccion_pelicula DROP FOREIGN KEY FK_801DC7EE70713909');
        $this->addSql('ALTER TABLE interaccion_documental DROP FOREIGN KEY FK_94FD7CFE2A144CCF');
        $this->addSql('ALTER TABLE interaccion_documental DROP FOREIGN KEY FK_94FD7CFE701101F1');
        $this->addSql('ALTER TABLE pelicula_cliente DROP FOREIGN KEY FK_D82659F770713909');
        $this->addSql('ALTER TABLE pelicula_cliente DROP FOREIGN KEY FK_D82659F7DE734E51');
        $this->addSql('ALTER TABLE serie_cliente DROP FOREIGN KEY FK_C085E882D94388BD');
        $this->addSql('ALTER TABLE serie_cliente DROP FOREIGN KEY FK_C085E882DE734E51');
        $this->addSql('DROP TABLE cliente');
        $this->addSql('DROP TABLE documental');
        $this->addSql('DROP TABLE documental_cliente');
        $this->addSql('DROP TABLE interaccion');
        $this->addSql('DROP TABLE interaccion_cliente');
        $this->addSql('DROP TABLE interaccion_serie');
        $this->addSql('DROP TABLE interaccion_pelicula');
        $this->addSql('DROP TABLE interaccion_documental');
        $this->addSql('DROP TABLE pelicula');
        $this->addSql('DROP TABLE pelicula_cliente');
        $this->addSql('DROP TABLE serie');
        $this->addSql('DROP TABLE serie_cliente');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
