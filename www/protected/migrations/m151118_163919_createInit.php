<?php

class m151118_163919_createInit extends CDbMigration
{
	public function safeUp()
	{

        $now = new CDbExpression('NOW()');

		$this->createTable('Users', [
			'id'        => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
			'uuid'    	=> 'varchar(32) NOT NULL',
			'name'   	=> 'varchar(64) NOT NULL',
			'created'   => 'datetime NOT NULL',
			'modified'  => 'datetime NOT NULL',
			'PRIMARY KEY (id)',
            'KEY created (created)',
            'KEY modified (modified)',
			'KEY uuid (uuid)',
		],
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci'
		);
        $this->insert('Users', ['uuid'=>'1c47e5d5e2d2c8dfd56336b79c54788b','name'=>'Rodger', 'created'=>$now, 'modified'=>$now]);

		$this->createTable('Dictonary', [
			'id' 		=> 'int(11) unsigned NOT NULL AUTO_INCREMENT',
			'nameEn'    => 'varchar(64) NOT NULL',
			'nameRu'   	=> 'varchar(64) NOT NULL',
			'created'   => 'datetime NOT NULL',
			'modified'  => 'datetime NOT NULL',
			'PRIMARY KEY (id)',
            'KEY created (created)',
            'KEY modified (modified)',
			'KEY nameEn (nameEn)',
			'KEY nameRu (nameRu)',
			'UNIQUE KEY en_ru (nameEn, nameRu)',
		],
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci'
		);

		$this->createTable('Answers', [
			'userId' 		=> 'int(11) unsigned NOT NULL',
			'dictonaryId'   => 'int(11) unsigned NOT NULL',
			'flags'   		=> 'int(11) unsigned NOT NULL DEFAULT 0',
			'created'   => 'datetime NOT NULL',
            'modified'  => 'datetime NOT NULL',
			'KEY userId (userId)',
			'KEY dictonaryId (dictonaryId)',
            'KEY created (created)',
            'KEY modified (modified)',
			'UNIQUE KEY user_answere (userId, dictonaryId)',
		],
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci'
		);

        $this->addForeignKey('Answers_ibfk_userId',  'Answers', 'userId', 'Users', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('Answers_ibfk_dictonaryId',  'Answers', 'dictonaryId', 'Dictonary', 'id', 'CASCADE', 'CASCADE');

        $this->insert('Dictonary', ['nameEn'=>'apple','nameRu'=>'яблоко', 'created'=>$now, 'modified'=>$now]);
        $this->insert('Dictonary', ['nameEn'=>'pear','nameRu'=>'персик', 'created'=>$now, 'modified'=>$now]);
        $this->insert('Dictonary', ['nameEn'=>'orange','nameRu'=>'апельсин', 'created'=>$now, 'modified'=>$now]);
        $this->insert('Dictonary', ['nameEn'=>'grape','nameRu'=>'виноград', 'created'=>$now, 'modified'=>$now]);
        $this->insert('Dictonary', ['nameEn'=>'lemon','nameRu'=>'лимон', 'created'=>$now, 'modified'=>$now]);
        $this->insert('Dictonary', ['nameEn'=>'pineapple','nameRu'=>'ананас', 'created'=>$now, 'modified'=>$now]);
        $this->insert('Dictonary', ['nameEn'=>'watermelon','nameRu'=>'арбуз', 'created'=>$now, 'modified'=>$now]);
        $this->insert('Dictonary', ['nameEn'=>'coconut','nameRu'=>'кокос', 'created'=>$now, 'modified'=>$now]);
        $this->insert('Dictonary', ['nameEn'=>'banana','nameRu'=>'банан', 'created'=>$now, 'modified'=>$now]);
        $this->insert('Dictonary', ['nameEn'=>'pomelo','nameRu'=>'помело', 'created'=>$now, 'modified'=>$now]);
        $this->insert('Dictonary', ['nameEn'=>'strawberry','nameRu'=>'клубника', 'created'=>$now, 'modified'=>$now]);
        $this->insert('Dictonary', ['nameEn'=>'raspberry','nameRu'=>'малина', 'created'=>$now, 'modified'=>$now]);
        $this->insert('Dictonary', ['nameEn'=>'melon','nameRu'=>'дыня', 'created'=>$now, 'modified'=>$now]);
        $this->insert('Dictonary', ['nameEn'=>'apricot','nameRu'=>'абрикос', 'created'=>$now, 'modified'=>$now]);
        $this->insert('Dictonary', ['nameEn'=>'mango','nameRu'=>'манго', 'created'=>$now, 'modified'=>$now]);
        $this->insert('Dictonary', ['nameEn'=>'pear','nameRu'=>'слива', 'created'=>$now, 'modified'=>$now]);
        $this->insert('Dictonary', ['nameEn'=>'pomegranate','nameRu'=>'гранат', 'created'=>$now, 'modified'=>$now]);
        $this->insert('Dictonary', ['nameEn'=>'cherry','nameRu'=>'вишня', 'created'=>$now, 'modified'=>$now]);
	}

	public function safeDown()
	{
		$this->dropTable('Answers');
        $this->dropTable('Dictonary');
        $this->dropTable('Users');
	}
}