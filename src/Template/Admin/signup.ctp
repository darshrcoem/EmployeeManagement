<body>
    <div class="admin-form-container">
        <?= $this->Form->create(null, ['class' => 'signup-form']) ?>
        <fieldset>
            <legend>📝 <?= __('User Signup') ?></legend>

            <?= $this->Form->control('username', [
                'label' => 'Username',
                'class' => 'form-control',
                'required' => true,
                'minlength' => 3
            ]) ?>

            <?= $this->Form->control('email', [
                'label' => 'Email',
                'class' => 'form-control',
                'type' => 'email',
                'required' => true
            ]) ?>

            <?= $this->Form->control('password', [
                'label' => 'Password',
                'class' => 'form-control',
                'required' => true,
                'pattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!_%*?&#])[A-Za-z\d@$!_%*?&#]{8,}$',

                'title' => 'Minimum 8 characters with at least one uppercase, one lowercase, one digit, and one special character'
            ]) ?>

            <?= $this->Form->control('password_confirm', [
                'label' => 'Confirm Password',
                'class' => 'form-control',
                'required' => true,
                'title' => 'Must match the password above'
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

        <?= $this->Form->button(__('Sign Up'), ['class' => 'button']) ?>
        <?= $this->Form->end() ?>
    </div>
</body>
<script>
    document.querySelector('.signup-form').addEventListener('submit', function (e) {
        const pwd = document.querySelector('[name="password"]').value;
        const confirmPwd = document.querySelector('[name="password_confirm"]').value;
        if (pwd !== confirmPwd) {
            e.preventDefault();
            alert("Passwords do not match!");
        }
    });
</script>