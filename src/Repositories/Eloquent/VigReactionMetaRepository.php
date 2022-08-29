<?php

namespace Botble\VigReactions\Repositories\Eloquent;

use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;
use Botble\VigReactions\Repositories\Interfaces\VigReactionMetaInterface;
use Botble\VigReactions\Models\VigReactionMeta;
use Illuminate\Support\Arr;

class VigReactionMetaRepository extends RepositoriesAbstract implements VigReactionMetaInterface
{
    public function saveMetaReactionData($object, $value): bool
    {
        try {
            $fieldMeta = $this->getFirstBy([
                'reactable_id'   => $object->id,
                'reactable_type' => get_class($object),
            ]);

            if (!$fieldMeta) {
                $fieldMeta = $this->getModel();
                $fieldMeta->reactable_id = $object->id;
                $fieldMeta->reactable_type = get_class($object);
            }

            $fieldMeta->value = $value;
            $this->createOrUpdate($fieldMeta);

            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    public function getMetaData($object, array $select = ['value'])
    {
        if ($object instanceof VigReactionMeta) {
            $field = $object;
        } else {
            $field = $this->getMeta($object, $select);
        }

        if (!$field) {
            return '';
        }

        return $field->value;
    }

    public function getMeta($object, array $select = ['value'])
    {
        return $this->getFirstBy([
            'reactable_id'   => $object->id,
            'reactable_type' => get_class($object),
        ], $select);
    }
}
