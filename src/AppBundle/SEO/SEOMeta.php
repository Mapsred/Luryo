<?php

$container->loadFromExtension('sonata_seo', array(
    'page' => array(
        'title' => 'lala',
        'metas' => array(
            'name' => array(
                'description' => 'default description',
                'keywords' => 'default, key, other',
            ),
        ),
    ),
));