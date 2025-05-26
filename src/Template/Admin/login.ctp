<body>
    <div class="admin-form-container">
        <?= $this->Form->create(null, ['class' => 'admin-form']) ?>
        <fieldset>
            <legend>🔐 <?= __('Admin Login') ?></legend>

            <?= $this->Form->control('username', [
                'label' => 'Username',
                'class' => 'form-control',
                'required' => true,
                'minlength' => 2,
            ]) ?>

            <?= $this->Form->control('password', [
                'label' => 'Password',
                'class' => 'form-control',
                'required' => true,
                'pattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!_%*?&#])[A-Za-z\d@$!_%*?&#]{8,}$',

                'title' => 'Password must be at least 8 characters and include one uppercase, one lowercase, one number, and one special character'
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
</body>