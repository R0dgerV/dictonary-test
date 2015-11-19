<?php

class clearFileCacheCommand extends CConsoleCommand
{

    public function run($args)
    {
        //Yii::app()->cache->flush();
        Yii::app()->db->schema->getTables();
        Yii::app()->db->schema->refresh();
    }
}

