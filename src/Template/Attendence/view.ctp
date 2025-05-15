<body>
    <link rel="stylesheet" href="/css/home.css">
    <div class="view-container">
        <?= $this->Form->create(null, ['type' => 'get']) ?>
        <h2>View Attendence</h2>
        <div class="filters">
            <label for="date">Select Date:</label>
            <?= $this->Form->input('date', [
                'type' => 'date',
                'value' => $this->request->getQuery('date') ,
                'id' => 'date',
                'label' => false,
                'class' => 'date-input'
            ]) ?>
            <?= $this->Form->button(__('View'), ['type' => 'submit', 'class' => 'button12']) ?>
        </div>
        <?= $this->Form->end() ?>
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('emp_id', 'Employee ID') ?></th>
                    <th>Name</th>
                    <th><?= $this->Paginator->sort('status', 'Status') ?></th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($data)): ?>
                    <tr>
                        <td colspan="4">No records found.</td>
                    </tr>
                <?php endif; ?>
                <?php foreach ($data as $res): ?>
                    <tr>
                        <td>
                            <?php
                          
                                $status = $res->Attendence['status'];
                           
                                $date = $res->Attendence['at_date'];
                           
                            ?>
                            <?= h($res->emp_id) ?>
                        </td>
                        <td><?= h($res->full_name) ?></td>
                        <td><?= h($res->Attendence['status']) ?></td>
                        <td> <?php
                        $pre = strtolower($status) === "present";
                        $abs = strtolower($status) === "absent";
                        $lea = strtolower($status) === "leave";
                        ?>
                            <?= $this->Form->create(null, ['url' => ['action' => 'edit']]) ?>
                            <?= $this->Form->hidden('emp_id', ['value' => $res->emp_id]) ?>
                            <?= $this->Form->hidden('date', ['value' => $date]) ?>
                            <div class="button-group">
                                <?= $this->Form->button('✅ Present', [
                                    'name' => 'status',
                                    'value' => 'Present',
                                    'class' => 'button2',
                                    'disabled' => $pre
                                ]) ?>
                                <?= $this->Form->button('❌ Absent', [
                                    'name' => 'status',
                                    'value' => 'Absent',
                                    'class' => 'button2',
                                    'disabled' => $abs
                                ]) ?>
                                <?= $this->Form->button('🟡 On Leave', [
                                    'name' => 'status',
                                    'value' => 'Leave',
                                    'class' => 'button2',
                                    'disabled' => $lea
                                ]) ?>
                            </div>
                            <?= $this->Form->end() ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Back to Dashboard -->
        <div class="bu">
            <?= $this->Html->link(__('Dashboard'), ['controller' => 'Attendence', 'action' => 'display'], ['class' => 'button1']) ?>
        </div>
    </div>
</body>