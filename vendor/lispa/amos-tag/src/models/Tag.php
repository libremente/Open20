<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\tag
 * @category   CategoryName
 */

namespace lispa\amos\tag\models;

use creocoder\nestedsets\NestedSetsBehavior;
use lispa\amos\tag\models\search\TagQuery;

/**
 * This is the model class for table "tag".
 */
class Tag extends \lispa\amos\tag\models\base\BaseTag
{

    public static function find()
    {
        return new TagQuery(get_called_class());
    }

    public function behaviors()
    {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'depthAttribute' => 'lvl',
                'treeAttribute' => 'root',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {

        if (isset($_POST['Tag']) && isset($_POST['Tag']['id'])) {
            $tagId = $_POST['Tag']['id'];

            // set of all occurence of $tagId
            if (isset($_POST['ModelsRoles'])) {
                // delete all occurence of $tagId
                TagModelsAuthItemsMm::deleteAll(['tag_id' => $tagId]);
                $modelsRoles = $_POST['ModelsRoles'];
                foreach ($modelsRoles as $moduleName => $rolesArray) {
                    foreach ($rolesArray as $key => $roleName) {
                        $modelTagModels = new TagModelsAuthItemsMm();
                        $modelTagModels->tag_id = $tagId;
                        $modelTagModels->classname = $moduleName;
                        $modelTagModels->auth_item = $roleName;
                        // TODO Su database sono da aggiungere i campi per le behaviors, e qua è togliere il detach!
                        $modelTagModels->detachBehaviors();
                        $modelTagModels->save(false);
                    }
                }
            } else {
                TagModelsAuthItemsMm::deleteAll(['tag_id' => $tagId]);
            }
            $moduleCwh = \Yii::$app->getModule('cwh');
            if(isset($moduleCwh)) {
                if (isset($_POST['CwhTagInterestMm'])) {
                    // delete all occurence of $tagId
                    \lispa\amos\cwh\models\CwhTagInterestMm::deleteAll(['tag_id' => $tagId]);
                    $CwhTagInterestMm = $_POST['CwhTagInterestMm'];
                    foreach ($CwhTagInterestMm as $moduleName => $rolesArray) {
                        foreach ($rolesArray as $key => $roleName) {
                            $modelTagModels = new \lispa\amos\cwh\models\CwhTagInterestMm();
                            $modelTagModels->tag_id = $tagId;
                            $modelTagModels->classname = $moduleName;
                            $modelTagModels->auth_item = $roleName;
                            $modelTagModels->detachBehaviors();
                            $modelTagModels->save(false);
                        }
                    }
                } else {
                    \lispa\amos\cwh\models\CwhTagInterestMm::deleteAll(['tag_id' => $tagId]);
                }
            }
        }

        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }


    /**
     * @return array - the list of distinct classname of the models
     */
    public function getClassname()
    {
        $ret = [];
        $listaElementi = TagModelsAuthItemsMm::findAll(['tag_id' => $this->id]);
        foreach ($listaElementi as $elemento) {
            $ret[] = $elemento->classname;
        }
        return $ret;
    }

    /**
     *
     * @return array
     */
    public function getRoles()
    {
        $ret = [];
        $listaElementi = TagModelsAuthItemsMm::findAll(['tag_id' => $this->id]);
        foreach ($listaElementi as $elemento) {
            $ret[] = $elemento->auth_item;
        }
        return $ret;
    }

    public function getModelsRoles()
    {
        $ret = [];
        $listaElementi = TagModelsAuthItemsMm::findAll(['tag_id' => $this->id]);
        foreach ($listaElementi as $elemento) {
            $ret[] = $elemento->getAttributes();
        }
        return $ret;
    }

    public function isModelRole($id, $classname, $role)
    {
        $listaElementi = TagModelsAuthItemsMm::findAll(['tag_id' => $this->id]);
        foreach ($listaElementi as $elemento) {
            $valori = $elemento->getAttributes();
            if ($valori['tag_id'] == $id && $valori['classname'] == $classname && $valori['auth_item'] == $role) {
                return true;
            }
        }
        return false;
    }

    public function getAssignedRolesByClassname($classname)
    {
        $ret = [];
        $listaElementi = TagModelsAuthItemsMm::findAll(['tag_id' => $this->id, 'classname' => $classname]);
        foreach ($listaElementi as $elemento) {
            $ret[] = $elemento->auth_item;
        }
        return $ret;
    }

    public function getAssignedInterestByClassname($classname)
    {
        $ret = [];
        $moduleCwh = \Yii::$app->getModule('cwh');
        if(isset($moduleCwh)) {
            $listaElementi = \lispa\amos\cwh\models\CwhTagInterestMm::findAll([
                'tag_id' => $this->id,
                'classname' => $classname
            ]);
            foreach ($listaElementi as $elemento) {
                $ret[] = $elemento->auth_item;
            }
        }
        return $ret;
    }

    /**
     * @return string
     */
    public function getPath(){
        $pathParents = $this->parents()->orderBy('lvl ASC')->all();

        $parentsPath = [];
        foreach ($pathParents as $padre) {
            //esclude la root in quanto è già indicata
            if ($padre->lvl != 0) {
                $parentsPath[] = $padre->nome;
            }
        }
        $path = implode(" / ", $parentsPath);
        return $path;
    }

    /**
     * @return mixed
     */
    public function getTagRoot(){
        $root = Tag::find()->andWhere(['id' => $this->root])->one();
        return $root;
    }

}