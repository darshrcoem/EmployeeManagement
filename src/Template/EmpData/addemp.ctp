<body>
<div class="admin-form-container">
<?= $this->Form->create('EmpData') ?>
<h2>Add Employee</h2>
<script>
    .h2{
        text-align: center;
    }
</script>
<?= $this->Form->control('Full_name', [
    'label' => 'Full_name',
    'class' => 'form-control'
]) ?>

<?= $this->Form->control('department', [
    'label' => 'Department',
    'class' => 'form-control'
]) ?>

<?= $this->Form->control('role', [ // Fixed: was using . instead of ,
    'label' => 'Role Array',
    'class' => 'form-control'
]) ?>

<?= $this->Form->control('salary', [
    'label' => 'Salary',
    'class' => 'form-control'
]) ?>

<?= $this->Form->control('joining_date', [
    'label' => 'Joining Date',
    'type' => 'date',
    'class' => 'date12',
    'templates' => [
        'dateWidget' => '<input type="date" name="{{name}}"{{attrs}}>',
    ]
]) ?>

<?= $this->Form->control('email', [ // Fixed: was using . instead of ,
    'label' => 'Email Array',
    'class' => 'form-control'
]) ?>

<?= $this->Form->control('mobile', [
    'label' => 'Mobile',
    'class' => 'form-control'
]) ?>

<?= $this->Form->control('status', [
    'label' => 'Status',
    'type' => 'select',
    'options' => ['Active' => 'Active', 'Inactive' => 'Inactive'],
    'class' => 'form-control'
]) ?>

<?= $this->Form->button(__('Submit'), ['class' => 'button']) ?>
<?= $this->Form->end() ?>
</div>

<link rel="stylesheet" href="/css/home.css">
</body>
