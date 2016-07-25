<?php

class PluginForum_ModuleForum_EntityForum extends EntityORM {
    protected $aRelations = array(
        'hash'=>array(EntityORM::RELATION_TYPE_BELONGS_TO,'PluginForum_ModuleForum_EntityCategory','category_id'),
        'link'=>array(EntityORM::RELATION_TYPE_BELONGS_TO,'ModuleUser_EntityUser','user_id'),
        'description'=>array(EntityORM::RELATION_TYPE_BELONGS_TO,'PluginForum_ModuleForum_EntityTopic','topic_id'),
    );
}