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
            ->add('type', 'customSelect', [
                'label'      => trans('core/base::forms.type'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
                'choices'    => [
                    'like'  => ' Like',
                    'love'  =>  'Love',
                    'haha'  =>  'Haha',
                    'wow'   =>  'WoW',
                    'sad'   =>  'Sad',
                    'angry' =>  'Angry',
                ],
            ])
            ->add('reactable_id', 'number', [
                'label'      => 'reaction_id',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'name' => 'reaction_id'
                ],
            ])
            ->add('reactable_type', 'text', [
                'label'      => 'reaction_type',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'name' => 'reaction_type'
                ],
            ])
            ->setBreakFieldPoint('reactable_id', 'reactable_type');
    }
}
