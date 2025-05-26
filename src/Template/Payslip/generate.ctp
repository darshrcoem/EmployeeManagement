<link rel="stylesheet" href="/css/home.css">

<div class="view-container">
    <?= $this->Form->create(null, ['type' => 'get']) ?>
    <h2>Generate Payslips</h2>
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
                <th>Emp_id</th>
                <th>Full Name</th>
                <th>Department</th>
                <th>Month</th>
                <th>Year</th>
                <th>Base Pay</th>
                <th>Generate Slip</th>
            </tr>
            <?php foreach ($data as $res): ?>
                <tr>
                    <td><?= h($res->emp_id) ?></td>
                    <td><?= h($res->Full_name) ?></td>
                    <td><?= h($res->department) ?></td>
                    <td><?= h($month) ?></td>
                    <td><?= h($year) ?></td>
                    <td><?= h($res->salary) ?></td>
                    <td>
                        <?php if (isset($generatedSlips[$res->emp_id])): ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-file-alt"></i>', // View icon
                                ['action' => 'slip', $res->emp_id, $month, $year],
                                ['class' => 'linkd', 'escape' => false]
                            ) ?>
                        <?php else: ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-file-invoice-dollar"></i>', // Generate slip icon
                                ['action' => 'payslipformat', $res->emp_id, $month, $year],
                                ['class' => 'linke', 'escape' => false]
                            ) ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="bu">
        <?= $this->Html->link(__('Dashboard'), ['controller' => 'Payslip', 'action' => 'display'], ['class' => 'button1']) ?>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</body>