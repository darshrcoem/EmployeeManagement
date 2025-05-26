<?php
use Twig\Template;
?>

<body>
    <div class="admin-form-container">

        <?= $this->Form->create($emp) ?> 
        <h2 class="form-title">Edit Employee</h2>

        <?= $this->Form->control('emp_id', ['type' => 'hidden']) ?>

        <?= $this->Form->control('Full_name', [
            'label' => 'Full Name',
            'class' => 'form-control',
            'readonly' => true,
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
            'type' => 'number',
            'label' => 'Salary',
            'class' => 'form-control',
            'required' => true,
            'min' => 0
        ]) ?>
        <?= $this->Form->control('joining_date', [
            'label' => 'Joining Date',
            'type' => 'date',
            'class' => 'form-control',
            'required' => true
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
            'pattern' => '[6-9]{1}[0-9]{9}',
            'title' => 'Enter a valid 10-digit mobile number starting with 6-9',
            'required' => true,
            'value' => $emp->mobile
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
