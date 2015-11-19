<?php

class m151119_075621_createErrorAnswersTable extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('ErrorAnswers', [
			'userId' 		=> 'int(11) unsigned NOT NULL',
			'dictonaryId'   => 'int(11) unsigned NOT NULL',
			'answerId'   => 'int(11) unsigned NOT NULL',
			'created'   => 'datetime NOT NULL',
			'KEY userId (userId)',
			'KEY dictonaryId (dictonaryId)',
            'KEY answerId (answerId)',
			'KEY created (created)',
		],
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci'
		);

        $this->addForeignKey('ErrorAnswers_ibfk_userId',  'ErrorAnswers', 'userId', 'Users', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('ErrorAnswers_ibfk_dictonaryId',  'ErrorAnswers', 'dictonaryId', 'Dictonary', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('ErrorAnswers_ibfk_answerId',  'ErrorAnswers', 'answerId', 'Dictonary', 'id', 'CASCADE', 'CASCADE');
    }

	public function safeDown()
	{
		$this->dropTable('ErrorAnswers');
	}
}