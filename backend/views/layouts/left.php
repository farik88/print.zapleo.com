<aside class="main-sidebar">

    <section class="sidebar">
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => Yii::t('backend_layouts', 'Панель администратора'), 'options' => ['class' => 'header']],
                    ['label' => Yii::t('backend_layouts', 'Логин'), 'url' => ['/site/login'], 'visible' => Yii::$app->user->isGuest],

                    // ['label' => 'Table','icon' => 'fa fa-table','url' => ['/mailbox'],'encode' => false,],
                    [
                        'label' => Yii::t('backend_layouts', 'Товары'),
                        'icon' => 'fa fa-book',
                        'url' => ['/products'],
                        'items'=>[

                        ],
                    ],

                    ['label' => Yii::t('backend_layouts', 'Заказы'),'icon' => 'fa fa-shopping-cart','url' => ['/orders']],
                    [
                        'label' => Yii::t('backend_layouts', 'Клиенты'),
                        'icon' => 'fa fa-users',
                        'url' => ['/users'],
                        'items' => [
                            ['label' => Yii::t('backend_layouts', 'Все пользователи'),'icon' => 'fa fa-users', 'url' => ['/users']],
                            ['label' => Yii::t('backend_layouts', 'Роли'),'icon' => 'fa fa-user-circle-o', 'url' => ['/roles']],
                            ['label' => Yii::t('backend_layouts', 'Права'),'icon' => 'fa fa-id-card-o', 'url' => ['/permissions']]
                        ]
                    ],
                    ['label' => Yii::t('backend_layouts', 'Акции'),'icon' => 'fa  fa-percent','url' => ['/sales']],
                    ['label' => Yii::t('backend_layouts', 'Купоны'),'icon' => 'fa  fa-gift','url' => ['/coupons']],
                    ['label' => Yii::t('backend_layouts', 'Методы доставки'),'icon' => 'fa  fa-truck','url' => ['/deliveries']],
                    ['label' => Yii::t('backend_layouts', 'Методы оплаты'),'icon' => 'fa fa-credit-card-alt','url' => ['/payments']],
                    ['label' => Yii::t('backend_layouts', 'Почта/рассылка'),'icon' => 'fa fa-envelope-o','url' => ['/emails']],
                    [
                        'label' => Yii::t('backend_layouts', 'Конструктор'),
                        'icon' => 'fa fa-wrench',
                        'url' => ['/#'],
                        'items' => [
                            ['label' => Yii::t('backend_layouts', 'Разметки'),'icon' => 'fa fa-map-o','url' => ['/markings']],
                            ['label' => Yii::t('backend_layouts', 'Шрифты'), 'icon' => 'fa fa-font', 'url' => ['/folders/fonts']],
                            ['label' => Yii::t('backend_layouts', 'Фоны'), 'icon' => 'fa fa-picture-o', 'url' => ['/folders/background']],
                            ['label' => Yii::t('backend_layouts', 'Emoji'), 'icon' => 'fa fa-smile-o', 'url' => ['/folders/emoji']],
                            ['label' => Yii::t('backend_layouts', 'Цвета'),'icon' => 'fa fa-eyedropper','url' => ['/colors']],
                        ]
                    ],
                    ['label' => Yii::t('backend_layouts', 'Права доступа'),'icon' => 'fa fa-id-card','url' => ['/accesses']],

                    ['label' => Yii::t('backend_layouts', 'Чехлы'),'icon' => 'fa  fa-mobile','url' => ['/covers']],
                    ['label' => Yii::t('backend_layouts', 'Картинки'),'icon' => 'fa fa-picture-o','url' => ['/images']],

                    ['label' => Yii::t('backend_layouts', 'Марки товаров'),'icon' => 'fa fa-microchip','url' => ['/labels']],

                    ['label' => Yii::t('backend_layouts', 'Панель разработчика'), 'options' => ['class' => 'header']],
                    [
                        'label' => Yii::t('backend_layouts', 'Интернационализация'),
                        'icon' => 'fa fa-handshake-o',
                        'url' => ['/#'],
                        'items' => [
                            ['label' => Yii::t('backend_layouts', 'Языки'),'icon' => 'fa fa-language','url' => ['/languages']],
                            ['label' => Yii::t('backend_layouts', 'Исходные сообщения'),'icon' => 'fa fa-commenting-o','url' => ['/source-langs']],
                            ['label' => Yii::t('backend_layouts', 'Переводы'),'icon' => 'fa fa-globe','url' => ['/translation']],
                        ]
                    ],
                    [
                        'label' => Yii::t('backend_layouts', 'Параметры приложения'),
                        'icon' => 'fa fa-gears',
                        'url' => ['/settings'],
                    ],
                ],
            ]
        ) ?>
    </section>

</aside>
