<body><div class="admin-form-container">
    <?= $this->Form->create(null, ['class' => 'admin-form']) ?>
    <fieldset>
        <legend>🔐 <?= __('Admin Login') ?></legend>

        <?= $this->Form->control('username', [
            'label' => 'Username',
            'class' => 'form-control'
        ]) ?>

        <?= $this->Form->control('password', [
            'label' => 'Password',
            'class' => 'form-control'
        ]) ?>

        <?= $this->Form->control('CR_time', [
            'type' => 'hidden',
            'value' => date('Y-m-d H:i:s')
        ]) ?>

        <?= $this->Form->control('Md_time', [
            'type' => 'hidden',
            'value' => date('Y-m-d H:i:s')
        ]) ?>
    </fieldset>

    <?= $this->Form->button(__('Login'), ['class' => 'button']) ?>
    <?= $this->Form->end() ?>
</div>
<link rel="stylesheet" href="/css/home.css">
</body>