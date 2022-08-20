<?php

namespace Botble\VigReactions\Forms;

use Botble\Base\Forms\FormAbstract;
use Botble\VigReactions\Http\Requests\VigReactionsRequest;
use Botble\VigReactions\Models\VigReactions;

class VigReactionsForm extends FormAbstract
{

    /**
     * {@inheritDoc}
     */
    public function buildForm()
    {
        $this
            ->setupModel(new VigReactions)
            ->setValidatorClass(VigReactionsRequest::class)
            ->withCustomFields()
            ->add('type', 'text', [
                'label'      => trans('core/base::forms.type'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ]);
    }
}
