<!-- filepath: c:\Users\admin\Desktop\Project\my_app_name\src\Template\EmpData\viewemp.ctp -->

<body>
    <link rel="stylesheet" href="/css/home.css">
    <div class="view-container">
        <?= $this->Form->create(null, ['type' => 'get']) ?>
        <h2>View Employees</h2>

        <!-- Filters -->
        <div class="filters">
            <label for="department">Department:</label>
            <?= $this->Form->select('department', $departments, ['empty' => 'All', 'value' => $this->request->getQuery('department')]) ?>

            <label for="role">Role:</label>
            <?= $this->Form->select('role', $roles, ['empty' => 'All', 'value' => $this->request->getQuery('role')]) ?>

            <label for="status">Status:</label>
            <?= $this->Form->select('status', ['active' => 'Active', 'inactive' => 'Inactive'], ['empty' => 'All', 'value' => $this->request->getQuery('status')]) ?>

            <?= $this->Form->button(__('Filter'), ['type' => 'submit', 'class' => 'filter-button']) ?>
        </div>
        <?= $this->Form->end() ?>

        <!-- Employee Table -->
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('emp_id', 'Employee ID') ?></th>
                    <th><?= $this->Paginator->sort('Full_name', 'Full Name') ?></th>
                    <th><?= $this->Paginator->sort('department', 'Department') ?></th>
                    <th><?= $this->Paginator->sort('role', 'Role') ?></th>
                    <th><?= $this->Paginator->sort('salary', 'Salary') ?></th>
                    <th><?= $this->Paginator->sort('joining_date', 'Joining Date') ?></th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th><?= $this->Paginator->sort('status', 'Status') ?></th>
                </tr>
            </thead>
            <tbody>
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
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            <?= $this->Paginator->prev('« Previous') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('Next »') ?>
        </div>

        <!-- Back to Dashboard -->
        <div class="bu">
            <?= $this->Html->link(__('Dashboard'), ['controller' => 'EmpData', 'action' => 'display'], ['class' => 'button1']) ?>
        </div>
    </div>
</body>