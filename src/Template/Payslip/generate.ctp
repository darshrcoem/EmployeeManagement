<body>
    <link rel="stylesheet" href="/css/home.css">

    <div class="view-container">
        <?= $this->Form->create(null, ['type' => 'get']) ?>
        <h2>Payslip Generator</h2>

        <div class="filters">
            <?= $this->Form->input('month', [
                'type' => 'month',
                'value' => is_array($this->request->getQuery('month')) ? date('Y-m') : ($this->request->getQuery('month') ?: date('Y-m')),
                'id' => 'month',
                'label' => false,
                'class' => 'date-input',
            ]) ?>

            <?= $this->Form->input('year', [
                'type' => 'year',
                'value' => is_array($this->request->getQuery('year')) ? date('Y') : ($this->request->getQuery('year') ?: date('Y')),
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
        </div>
        <table>
            <tr>
                <th>Employee ID</th>
                <th>Full Name</th>
                <th>Department</th>
                <th>Role</th>
                <th>Salary</th>
                <th>Total Bounses</th>
                <th>Total Deductions</th>
                <th>Net Salary</th>
            </tr>
            <?php foreach ($data as $res): ?>
                <tr>
                    <td><?= h($res->emp_id) ?></td>
                    <td><?= h($res->Full_name) ?></td>
                    <td><?= h($res->department) ?></td>
                    <td><?= h($res->role) ?></td>
                    <td><?= h($res->salary) ?></td>
                    <td>
                        <?php
                        $totalBounses = $res->Bouded['fest_bounse'] + $res->Bouded['perf_bounse'];
                        echo h($totalBounses);
                        ?>
                    </td>
                    <td>
                        <?php
                        $totalDeductions = $res->Bouded['tax_ded'] + $res->Bouded['unpaid_ded'];
                        echo h($totalDeductions);
                        ?>
                    </td>
                    <td>
                        <?= $this->Html->link(
                            __('Generate Payslip'),
                            [ 'action' => 'slip', $res->emp_id], // Ensure this is the primary key
                            ['class' => 'linke']
                        ) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
</body>