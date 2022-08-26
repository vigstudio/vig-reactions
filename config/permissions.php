<?php

return [
    [
        'name' => 'Vig reactions',
        'flag' => 'vig-reactions.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'vig-reactions.create',
        'parent_flag' => 'vig-reactions.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'vig-reactions.edit',
        'parent_flag' => 'vig-reactions.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'vig-reactions.destroy',
        'parent_flag' => 'vig-reactions.index',
    ],
    [
        'name'        => 'Copy',
        'flag'        => 'vig-reactions.copy',
        'parent_flag' => 'vig-reactions.index',
    ],
];
