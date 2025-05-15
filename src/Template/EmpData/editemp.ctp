<body>
    <link rel="stylesheet" href="/css/home.css">
    <div class="view-container">
        <?= $this->Form->create('EmpData') ?>
        <h2>Edit Employee</h2>
        <table>
            <tr>
                <th>Employee ID</th>
                <th>Full Name</th>
                <th>Department</th>
                <th>Role</th>
                <th>Salary</th>
                <th>Joining Date</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Status</th>
                <th>Action </th>
            </tr>
            <?php foreach ($emp as $res): ?>
                <tr>
                    <td><?= h($res->emp_id) ?></td>
                    <td><?= h($res->Full_name) ?></td>
                    <td><?= h($res->department) ?></td>
                    <td><?= h($res->role) ?></td>
                    <td><?= h($res->salary) ?></td>
                    <td><?= h($res->joining_date->format('Y-m-d')) ?></td>
                    <td><?= h($res->email) ?></td>
                    <td><?= h($res->mobile) ?></td>
                    <td><?= h($res->status) ?></td>
                    <td>
                        <?= $this->Html->link(
                            __('Edit'),
                            ['controller' => 'EmpData', 'action' => 'update', $res->emp_id], // Ensure this is the primary key
                            ['class' => 'linke']
                        ) ?>

                    </td>

                </tr>
            <?php endforeach; ?>

        </table>
        <div class="bu">
            <?= $this->Html->link(__('Dashboard'), ['controller' => 'EmpData', 'action' => 'display'], ['class' => 'button1']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</body>