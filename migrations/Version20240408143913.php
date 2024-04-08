<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240408143913 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game ADD tournament_id INT DEFAULT NULL, ADD player1_id INT DEFAULT NULL, ADD player2_id INT DEFAULT NULL, ADD status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C33D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CC0990423 FOREIGN KEY (player1_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CD22CABCD FOREIGN KEY (player2_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_232B318C33D1A3E7 ON game (tournament_id)');
        $this->addSql('CREATE INDEX IDX_232B318CC0990423 ON game (player1_id)');
        $this->addSql('CREATE INDEX IDX_232B318CD22CABCD ON game (player2_id)');
        $this->addSql('ALTER TABLE registration ADD player_id INT DEFAULT NULL, ADD tournament_id INT DEFAULT NULL, ADD status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A799E6F5DF FOREIGN KEY (player_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A733D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id)');
        $this->addSql('CREATE INDEX IDX_62A8A7A799E6F5DF ON registration (player_id)');
        $this->addSql('CREATE INDEX IDX_62A8A7A733D1A3E7 ON registration (tournament_id)');
        $this->addSql('ALTER TABLE tournament ADD organizer_id INT DEFAULT NULL, ADD winner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tournament ADD CONSTRAINT FK_BD5FB8D9876C4DDA FOREIGN KEY (organizer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tournament ADD CONSTRAINT FK_BD5FB8D95DFCD4B8 FOREIGN KEY (winner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_BD5FB8D9876C4DDA ON tournament (organizer_id)');
        $this->addSql('CREATE INDEX IDX_BD5FB8D95DFCD4B8 ON tournament (winner_id)');
        $this->addSql('ALTER TABLE user ADD status VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C33D1A3E7');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CC0990423');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CD22CABCD');
        $this->addSql('DROP INDEX IDX_232B318C33D1A3E7 ON game');
        $this->addSql('DROP INDEX IDX_232B318CC0990423 ON game');
        $this->addSql('DROP INDEX IDX_232B318CD22CABCD ON game');
        $this->addSql('ALTER TABLE game DROP tournament_id, DROP player1_id, DROP player2_id, DROP status');
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A799E6F5DF');
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A733D1A3E7');
        $this->addSql('DROP INDEX IDX_62A8A7A799E6F5DF ON registration');
        $this->addSql('DROP INDEX IDX_62A8A7A733D1A3E7 ON registration');
        $this->addSql('ALTER TABLE registration DROP player_id, DROP tournament_id, DROP status');
        $this->addSql('ALTER TABLE tournament DROP FOREIGN KEY FK_BD5FB8D9876C4DDA');
        $this->addSql('ALTER TABLE tournament DROP FOREIGN KEY FK_BD5FB8D95DFCD4B8');
        $this->addSql('DROP INDEX IDX_BD5FB8D9876C4DDA ON tournament');
        $this->addSql('DROP INDEX IDX_BD5FB8D95DFCD4B8 ON tournament');
        $this->addSql('ALTER TABLE tournament DROP organizer_id, DROP winner_id');
        $this->addSql('ALTER TABLE user DROP status');
    }
}
