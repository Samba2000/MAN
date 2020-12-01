<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201124094349 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE promo_groupe_competence');
        $this->addSql('ALTER TABLE groupe ADD promo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('CREATE INDEX IDX_4B98C21D0C07AFF ON groupe (promo_id)');
        $this->addSql('ALTER TABLE groupe_competence DROP FOREIGN KEY FK_2C3959A3D0C07AFF');
        $this->addSql('DROP INDEX IDX_2C3959A3D0C07AFF ON groupe_competence');
        $this->addSql('ALTER TABLE groupe_competence DROP promo_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE promo_groupe_competence (promo_id INT NOT NULL, groupe_competence_id INT NOT NULL, INDEX IDX_A876B82E89034830 (groupe_competence_id), INDEX IDX_A876B82ED0C07AFF (promo_id), PRIMARY KEY(promo_id, groupe_competence_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE promo_groupe_competence ADD CONSTRAINT FK_A876B82E89034830 FOREIGN KEY (groupe_competence_id) REFERENCES groupe_competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo_groupe_competence ADD CONSTRAINT FK_A876B82ED0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21D0C07AFF');
        $this->addSql('DROP INDEX IDX_4B98C21D0C07AFF ON groupe');
        $this->addSql('ALTER TABLE groupe DROP promo_id');
        $this->addSql('ALTER TABLE groupe_competence ADD promo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE groupe_competence ADD CONSTRAINT FK_2C3959A3D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('CREATE INDEX IDX_2C3959A3D0C07AFF ON groupe_competence (promo_id)');
    }
}
