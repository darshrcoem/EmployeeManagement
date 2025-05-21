<body>
    <link rel="stylesheet" href="/css/home.css">
    <div class="view-container">
        <?= $this->Form->create('EmpData') ?>
        <h2>Add Bounses and Deductions</h2>
        <table>
            <tr>
                <th>Employee ID</th>
                <th>Full Name</th>
                <th>Department</th>
                <th>Role</th>
                <th>Salary</th>
                <th>Add Bouses and Deductions</th>
            </tr>
            <?php foreach ($emp as $res): ?>
                <tr>
                    <td><?= h($res->emp_id) ?></td>
                    <td><?= h($res->Full_name) ?></td>
                    <td><?= h($res->department) ?></td>
                    <td><?= h($res->role) ?></td>
                    <td><?= h($res->salary) ?></td>
                    <td>
                        <?= $this->Html->link(
                            __('Add Bounses and Deductions'),
                            ['controller' => 'Bouded', 'action' => 'bouded', $res->emp_id], // Ensure this is the primary key
                            ['class' => 'linke']
                        ) ?>
                    </td>

                </tr>
            <?php endforeach; ?>

        </table>
        <div class="bu">
            <?= $this->Html->link(__('Dashboard'), ['controller' => 'Payslip', 'action' => 'display'], ['class' => 'button1']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</body>