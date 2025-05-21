<link rel="stylesheet" href="/css/home.css">

<div class="view-container">
    <?= $this->Form->create(null, ['type' => 'get']) ?>
    <h2>View Payslips</h2>
    <div class="filters">
        <?= $this->Form->input('month', [
            'type' => 'month',
            'value' => $month,
            'empty' => 'Select month',
            'id' => 'month',
            'label' => false,
            'class' => 'date-input',
        ]) ?>

        <?= $this->Form->input('year', [
            'type' => 'year',
            'value' => $year,
            'empty' => 'Select year',
            'options' => range(2025, date('Y') + 5),
            'id' => 'year',
            'label' => false,
            'class' => 'date-input',
        ]) ?>
        <?= $this->Form->control('department', [
            'type' => 'select',
            'options' => array_combine($departments, $departments),
            'empty' => 'All Departments',
            'value' => $department,
            'label' => false,
            'class' => 'date-input',
        ]) ?>

        <?= $this->Form->button(__('View'), ['type' => 'submit', 'class' => 'button12']) ?>
        <table>
            <tr>
                <th>Full Name</th>
                <th>Department</th>
                <th>Month</th>
                <th>Year</th>
                <th>Base Pay</th>
                <th>Total Bounses</th>
                <th>Total Deductions</th>
                <th>Net Salary</th>
                <th>View Slip</th>
            </tr>
            <?php foreach ($payslips as $res): ?>
                <tr>
                    <td><?= h($res->full_name)?></td>
                    <td><?= h($res->department) ?></td>
                    <td><?= h($res->month) ?></td>
                    <td><?= h($res->year) ?></td>
                    <td><?= h($res->base_pay) ?></td>
                    <td><?= h($res->total_bonus) ?></td>
                    <td><?= h($res->total_deduction) ?></td>
                    <td><?= h($res->net_pay) ?></td>
                    <td>
                        <?= $this->Html->link(
                            __('View '),
                            ['action' => 'slip', $res->emp_id, $res->month, $res->year],// Ensure this is the primary key
                            ['class' => 'linke']
                        ) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="bu">
        <?= $this->Html->link(__('Dashboard'), ['controller' => 'Payslip', 'action' => 'display'], ['class' => 'button1']) ?>
    </div>
</div>
</body>