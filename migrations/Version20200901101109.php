<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200901101109 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE membership_product');
        $this->addSql('DROP TABLE membership_zone');
        $this->addSql('DROP TABLE package_product');
        $this->addSql('ALTER TABLE circuit DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE reception ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL, DROP CreatedAt, DROP UpdatedAt');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE membership_product (membership_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_5AE792FC1FB354CD (membership_id), INDEX IDX_5AE792FC4584665A (product_id), PRIMARY KEY(membership_id, product_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE membership_zone (membership_id INT NOT NULL, zone_id INT NOT NULL, INDEX IDX_DBD4F5CC1FB354CD (membership_id), INDEX IDX_DBD4F5CC9F2C3FAB (zone_id), PRIMARY KEY(membership_id, zone_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE package_product (package_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_5C1161214584665A (product_id), INDEX IDX_5C116121F44CABFF (package_id), PRIMARY KEY(package_id, product_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE membership_product ADD CONSTRAINT FK_5AE792FC1FB354CD FOREIGN KEY (membership_id) REFERENCES membership (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE membership_product ADD CONSTRAINT FK_5AE792FC4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE membership_zone ADD CONSTRAINT FK_DBD4F5CC1FB354CD FOREIGN KEY (membership_id) REFERENCES membership (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE membership_zone ADD CONSTRAINT FK_DBD4F5CC9F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE package_product ADD CONSTRAINT FK_5C1161214584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE package_product ADD CONSTRAINT FK_5C116121F44CABFF FOREIGN KEY (package_id) REFERENCES package (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE circuit ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE reception ADD CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, DROP created_at, DROP updated_at');
    }
}
