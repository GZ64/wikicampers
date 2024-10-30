<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240930085348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE advert (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price_per_day NUMERIC(10, 2) DEFAULT NULL, availability DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', city VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', id_user INT NOT NULL, camping_car_size INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE advert_equipment (advert_id INT NOT NULL, equipment_id INT NOT NULL, INDEX IDX_4905C48FD07ECCB6 (advert_id), INDEX IDX_4905C48F517FE9FE (equipment_id), PRIMARY KEY(advert_id, equipment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment (id INT AUTO_INCREMENT NOT NULL, nameEquipment VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D338D58353D8E78E (nameEquipment), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE search (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE search_advert (search_id INT NOT NULL, advert_id INT NOT NULL, INDEX IDX_8D139B14650760A9 (search_id), INDEX IDX_8D139B14D07ECCB6 (advert_id), PRIMARY KEY(search_id, advert_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE search_user (search_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D689C320650760A9 (search_id), INDEX IDX_D689C320A76ED395 (user_id), PRIMARY KEY(search_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thumbnail (id INT AUTO_INCREMENT NOT NULL, id_advert_id INT DEFAULT NULL, path VARCHAR(255) DEFAULT NULL, INDEX IDX_C35726E6504B7091 (id_advert_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE advert_equipment ADD CONSTRAINT FK_4905C48FD07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE advert_equipment ADD CONSTRAINT FK_4905C48F517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE search_advert ADD CONSTRAINT FK_8D139B14650760A9 FOREIGN KEY (search_id) REFERENCES search (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE search_advert ADD CONSTRAINT FK_8D139B14D07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE search_user ADD CONSTRAINT FK_D689C320650760A9 FOREIGN KEY (search_id) REFERENCES search (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE search_user ADD CONSTRAINT FK_D689C320A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE thumbnail ADD CONSTRAINT FK_C35726E6504B7091 FOREIGN KEY (id_advert_id) REFERENCES advert (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE advert_equipment DROP FOREIGN KEY FK_4905C48FD07ECCB6');
        $this->addSql('ALTER TABLE advert_equipment DROP FOREIGN KEY FK_4905C48F517FE9FE');
        $this->addSql('ALTER TABLE search_advert DROP FOREIGN KEY FK_8D139B14650760A9');
        $this->addSql('ALTER TABLE search_advert DROP FOREIGN KEY FK_8D139B14D07ECCB6');
        $this->addSql('ALTER TABLE search_user DROP FOREIGN KEY FK_D689C320650760A9');
        $this->addSql('ALTER TABLE search_user DROP FOREIGN KEY FK_D689C320A76ED395');
        $this->addSql('ALTER TABLE thumbnail DROP FOREIGN KEY FK_C35726E6504B7091');
        $this->addSql('DROP TABLE advert');
        $this->addSql('DROP TABLE advert_equipment');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE search');
        $this->addSql('DROP TABLE search_advert');
        $this->addSql('DROP TABLE search_user');
        $this->addSql('DROP TABLE thumbnail');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
