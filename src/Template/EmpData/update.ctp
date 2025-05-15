<?php
use Twig\Template;
?>

<body>
    <div class="admin-form-container">

        <?= $this->Form->create($emp) ?> <!-- Bound to the entity $emp -->
        <h2>Edit Employee</h2>
        <!-- Hidden input for emp_id -->
        <?= $this->Form->control('emp_id', ['type' => 'hidden']) ?>

        <!-- Full Name -->
        <?= $this->Form->control('Full_name', [
            'label' => 'Full Name',
            'class' => 'form-control',
            'readonly' => true
        ]) ?>

        <!-- Department -->
        <?= $this->Form->control('department', [
            'label' => 'Department',
            'class' => 'form-control'
        ]) ?>

        <!-- Role -->
        <?= $this->Form->control('role', [
            'label' => 'Role',
            'class' => 'form-control'
        ]) ?>

        <!-- Salary -->
        <?= $this->Form->control('salary', [
            'type' => 'number', // Specify the input type for clarity
            'label' => 'Salary',
            'class' => 'form-control'
        ]) ?>

        <!-- Joining Date -->
        <?= $this->Form->control('joining_date', [
            'label' => 'Joining Date',
            'type' => 'date',
            'class' => 'form-control',
        ]) ?>

        <!-- Email -->
        <?= $this->Form->control('email', [
            'label' => 'Email',
            'class' => 'form-control'
        ]) ?>

        <!-- Mobile -->
        <?= $this->Form->control('mobile', [
            'label' => 'Mobile',
            'class' => 'form-control',
            'value' => $emp->mobile // Fix: previously used $emp->phone
        ]) ?>

        <!-- Status -->
        <?= $this->Form->control('status', [
            'label' => 'Status',
            'type' => 'select',
            'options' => ['Active' => 'Active', 'Inactive' => 'Inactive'],
            'class' => 'form-control'
        ]) ?>

        <!-- Submit Button -->
        <?= $this->Form->button(__('Submit'), ['class' => 'button']) ?>

        <!-- End of Form -->
        <?= $this->Form->end() ?>

    </div>

    <link rel="stylesheet" href="/css/home.css">
</body>