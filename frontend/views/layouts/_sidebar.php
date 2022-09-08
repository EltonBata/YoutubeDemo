

<aside class="shadow">
    <?php echo \yii\bootstrap4\Nav::widget([

    'options' => [
        'class' => 'd-flex flex-column nav-pills'
    ],
    'items' => [
        [
            'label' => 'Home',
            'url' => ['/site/index']
        ],
        [
            'label' => 'Videos',
            'url' => ['/video/history']
        ]
    ]

]) ?>
</aside>
