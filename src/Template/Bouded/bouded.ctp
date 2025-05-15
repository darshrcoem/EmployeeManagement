<link rel="stylesheet" href="/css/home.css">

<div class="admin-form-container">
    <?= $this->Form->create(null) ?>

    <h2 style="text-align: center;">Select Month and Year</h2>

    <div class="filters">
        <?= $this->Form->control('month', [
            'type' => 'month',
            'label' => false,
            'value' => $this->request->getData('month') ?: date('Y-m'),
            'id' => 'month',
            'class' => 'date-input',
        ]) ?>

        <?= $this->Form->control('year', [
            'type' => 'year',
            'label' => false,
            'value' => $this->request->getData('year') ?: date('Y'),
            'min' => 2000,
            'max' => date('Y'),
            'id' => 'year',
            'class' => 'date-input',
        ]) ?>
    </div>
        <h2 style="text-align: center;">Add Bonuses and Deductions for
            <span class="date-box"><?= h($emp->Full_name) ?></span>
        </h2>

        <?= $this->Form->control('emp_id', [
            'type' => 'hidden',
            'value' => $emp->emp_id,
        ]) ?>

        <?= $this->Form->control('fest_bounse', [
            'label' => 'Festival Bonus',
            'type' => 'number',
            'step' => '0.01',
            'value' => 0,
            'class' => 'form-control'
        ]) ?>

        <?= $this->Form->control('perf_bounse', [
            'label' => 'Performance Bonus',
            'type' => 'number',
            'step' => '0.01',
            'value' => 0,
            'class' => 'form-control'
        ]) ?>

        <?= $this->Form->control('tax_ded', [
            'label' => 'Tax Deduction',
            'type' => 'number',
            'step' => '0.01',
            'value' => 0,
            'class' => 'form-control'
        ]) ?>

        <?= $this->Form->control('unpaid_ded', [
            'label' => 'Unpaid Leave Deduction',
            'type' => 'number',
            'step' => '0.01',
            'value' => 0,
            'class' => 'form-control'
        ]) ?>

        <?= $this->Form->button(__('Submit'), ['class' => 'button']) ?>
        <?= $this->Form->end() ?>
        <div class="bu">
            <?= $this->Html->link(__('List'), ['controller' => 'Payslip', 'action' => 'add'], ['class' => 'button1']) ?>
        </div>

</div>

<style>
    .filters {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .date-input {
        margin-right: 10px;
        padding: 5px;
        font-size: 14px;
    }

    .form-control {
        margin-bottom: 15px;
    }

    .button {
        display: block;
        margin: 0 auto;
        padding: 10px 20px;
        font-size: 16px;
    }
</style>