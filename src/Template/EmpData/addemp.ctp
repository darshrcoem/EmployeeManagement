<body>
    <div class="admin-form-container">
        <?= $this->Form->create('EmpData') ?>
        <h2 class="form-title">Add Employee</h2>

        <?= $this->Form->control('Full_name', [
            'label' => 'Full Name',
            'class' => 'form-control',
            'required' => true,
            'minlength' => 3,
            'maxlength' => 50,
            'pattern' => '[A-Za-z ]+',
            'title' => 'Only alphabets and spaces allowed'
        ]) ?>

        <?= $this->Form->control('department', [
            'label' => 'Department',
            'class' => 'form-control',
            'required' => true
        ]) ?>

        <?= $this->Form->control('role', [
            'label' => 'Role',
            'class' => 'form-control',
            'required' => true
        ]) ?>

        <?= $this->Form->control('salary', [
            'label' => 'Salary',
            'type' => 'number',
            'class' => 'form-control',
            'required' => true,
            'min' => 0
        ]) ?>

        <?= $this->Form->control('joining_date', [
            'label' => 'Joining Date',
            'type' => 'date',
            'class' => 'date12',
            'required' => true,
            'templates' => [
                'dateWidget' => '<input type="date" name="{{name}}"{{attrs}}>',
            ]
        ]) ?>

        <?= $this->Form->control('email', [
            'label' => 'Email',
            'type' => 'email',
            'class' => 'form-control',
            'required' => true
        ]) ?>

        <?= $this->Form->control('mobile', [
            'label' => 'Mobile',
            'class' => 'form-control',
            'required' => true,
            'pattern' => '[6-9]{1}[0-9]{9}',
            'title' => 'Enter a valid 10-digit mobile number starting with 6-9'
        ]) ?>

        <?= $this->Form->control('status', [
            'label' => 'Status',
            'type' => 'select',
            'options' => ['Active' => 'Active', 'Inactive' => 'Inactive'],
            'class' => 'form-control',
            'required' => true
        ]) ?>

        <?= $this->Form->button(__('Submit'), ['class' => 'button']) ?>
        <?= $this->Form->end() ?>
    </div>

    <style>
        .form-title {
            text-align: center;
        }
    </style>
</body>
