<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <section class="bg-white shadow-md rounded-lg p-8 max-w-6xl mx-auto mt-10 text-center">
        <h1 class="text-2xl md:text-4xl font-bold mb-4">Поддержка студентов и наставников в практике</h1>
        <p class="mb-6 text-gray-700">Генерация отчетных документов — быстро и легко!</p>
        <a href="/web/site/login" class="bg-blue-600 text-white px-6 py-2 rounded-xl hover:bg-blue-400 transition">Начать работу</a>
    </section>

    <section class="mt-12 max-w-6xl mx-auto px-4 mb-12">
        <h2 class="text-2xl font-semibold mb-6">Почему выбирают нас?</h2>
        <div class="grid md:grid-cols-4 gap-6 text-center px-4 max-w-6xl mx-auto">
            <!-- Удобство -->
            <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
                <div class="mb-4 flex justify-center">
                    <?= Html::img('@web/images/icons8-настройки-104.png', ['alt' => 'Настройки', 'class' => 'w-12 h-12']) ?>
                </div>
                <h3 class="font-semibold mb-2">Удобство</h3>
                <p>Простая и понятная платформа для студентов и наставников.</p>
            </div>
            <!-- Автоматизация -->
            <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
                <div class="mb-4 flex justify-center">
                    <?= Html::img('@web/images/icons8-робот-96.png', ['alt' => 'Робот', 'class' => 'w-12 h-12']) ?>
                </div>
                <h3 class="font-semibold mb-2">Автоматизация</h3>
                <p>Мгновенная генерация отчетных документов и автоматические напоминания.</p>
            </div>
            <!-- Поддержка -->
            <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
                <div class="mb-4 flex justify-center">
                    <?= Html::img('@web/images/icons8-чат-90.png', ['alt' => 'Чат', 'class' => 'w-12 h-12']) ?>
                </div>
                <h3 class="font-semibold mb-2">Поддержка</h3>
                <p>Всегда готовы помочь и проконсультировать.</p>
            </div>
            <!-- Безопасность -->
            <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
                <div class="mb-4 flex justify-center">
                    <?= Html::img('@web/images/icons8-щит-100.png', ['alt' => 'Щит', 'class' => 'w-12 h-12']) ?>
                </div>
                <h3 class="font-semibold mb-2">Безопасность</h3>
                <p>Все данные защищены современными методами шифрования.</p>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 mb-12">
        <h2 class="text-2xl font-semibold mb-6">Наши основные функции</h2>
        <div class="flex flex-col space-y-4">
            <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
                <div class="flex justify-start mb-4">
                    <?= Html::img('@web/images/icons8-заметка-100.png', ['alt' => 'Заметка', 'class' => 'w-12 h-12']) ?>
                </div>
                <h3 class="font-semibold mb-2 text-2xl">Регистрация и личный кабинет</h3>
                <p>Создавайте учетные записи, чтобы управлять своими практиками и отслеживать прогресс.</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
                <div class="flex justify-start mb-4">
                    <?= Html::img('@web/images/icons8-календарь-100.png', ['alt' => 'Календарь', 'class' => 'w-12 h-12']) ?>
                </div>
                <h3 class="font-semibold mb-2 text-2xl">Планирование практики</h3>
                <p>Удобно планируйте свои мероприятия и отслеживайте сроки завершения задач.</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
                <div class="flex justify-start mb-4">
                    <?= Html::img('@web/images/icons8-блокнот-100.png', ['alt' => 'Блокнот', 'class' => 'w-12 h-12']) ?>
                </div>
                <h3 class="font-semibold mb-2 text-2xl">Ведение дневников</h3>
                <p>Записывайте свои мысли и прогресс прямо в платформу для будущего анализа.</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
                <div class="flex justify-start mb-4">
                    <?= Html::img('@web/images/icons8-предпросмотр-страницы-100.png', ['alt' => 'Предпросмотр страницы', 'class' => 'w-12 h-12']) ?>
                </div>
                <h3 class="font-semibold mb-2 text-2xl">Генерация отчетов</h3>
                <p>Автоматически создавайте профессиональные отчеты по результатам практики.</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
                <div class="flex justify-start mb-4">
                    <?= Html::img('@web/images/icons8-заметки-докладчика-100.png', ['alt' => 'Заметки докладчика', 'class' => 'w-12 h-12']) ?>
                </div>
                <h3 class="font-semibold mb-2 text-2xl">Ведение дневников</h3>
                <p>Записывайте свои мысли и прогресс прямо в платформу для будущего анализа.</p>
            </div>
            <!-- Добавляйте по необходимости -->
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 mb-12">
        <h2 class="text-2xl font-semibold mb-8">Контакты</h2>
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Контакты и описание -->
            <div class="space-y-4">
                <div class="flex items-center">
                    <span class="text-gray-700 text-xl">Телефон: +7 (900) 123-45-67</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-700 text-xl">Email: info@praktikaplus.ru</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-700 text-xl">Адрес: г. Москва, ул. Примерная 123</span>
                </div>
            </div>
            <!-- Можно добавить карту или описание -->
            <div>
                <iframe
                        class="w-full h-64 md:h-auto rounded-lg"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2244.9178795901904!2d37.6173!3d55.7558!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46b54a540a859557%3A0x5ccf4bb249f99999!2z0J7QsdCw0YbQtdC90L7QstC-0LvQsCwg0J7QsdCw0YbQtdC90L7QstC-0LvQsC4g0J7QsdCw0YbQtdC90L7QstC-0LvQsCwgMTMwMCBMw!5e0!3m2!1sru!2sus!4v1616343900000!5m2!1sru!2sus"
                        allowfullscreen=""
                        loading="lazy"></iframe>
            </div>
        </div>
    </section>

</div>
