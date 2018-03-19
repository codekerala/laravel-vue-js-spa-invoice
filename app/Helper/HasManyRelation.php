<?php

namespace App\Helper;

trait HasManyRelation {

    public function storeHasMany($relations)
    {
        $this->save();

        foreach($relations as $key => $items) {
            $newItems = [];

            foreach($items as $item) {
                $model = $this->{$key}()->getModel();
                $newItems[] = $model->fill($item);
            }

            // save
            $this->{$key}()->saveMany($newItems);
        }
    }

    public function updateHasMany($relations)
    {
        $this->save();

        $parentKey = $this->getKeyName();
        $parentId = $this->getAttribute($parentKey);

        foreach($relations as $key => $items) {
            $updatedIds = [];
            $newItems = [];

            // 1. filter and update
            foreach($items as $item) {
                $model = $this->{$key}()->getModel();
                $localKey = $model->getKeyName();
                $foreignKey = $this->{$key}()->getForeignKeyName();

                if(isset($item[$localKey])) {
                    $localId = $item[$localKey];
                    $found = $model->where($foreignKey, $parentId)
                        ->where($localKey, $localId)
                        ->first();

                    if($found) {
                        $found->fill($item);
                        $found->save();
                        $updatedIds[] = $localId;
                    }
                } else {
                    $newItems[] = $model->fill($item);
                }
            }

            // 2. delete non-updated items
            $model = $this->{$key}()->getModel();
            $localKey = $model->getKeyName();
            $foreignKey = $this->{$key}()->getForeignKeyName();
            $model->whereNotIn($localKey, $updatedIds)
                ->where($foreignKey, $parentId)
                ->delete();

            // 3. save new items
            if(count($newItems)) {
                $this->{$key}()->saveMany($newItems);
            }
        }
    }
}
