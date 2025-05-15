<body>
    <link rel="stylesheet" href="/css/home.css">
    <div class="view-container">
        <h2>Mark Today's Attendance</h2>
        <table>
            <tr>
                <th>Employee ID</th>
                <th>Full Name</th>
                <th>Department</th>
                <th>Email</th>
                <th>Status</th>
                <th>Mark & Remark</th>
            </tr>

            <?php foreach ($emp as $res): ?>
                <tr>
                    <td><?= h($res->emp_id) ?></td>
                    <td><?= h($res->Full_name) ?></td>
                    <td><?= h($res->department) ?></td>
                    <td><?= h($res->email) ?></td>
                    <td><?= h($res->status) ?></td>
                    <td>
                        <?php
                            $isInactive = strtolower($res->status) === 'inactive';
                            $isMarked = isset($attendence[$res->emp_id]);
                            $disabled = $isInactive || $isMarked;
                        ?>

                        <?= $this->Form->create(null, ['url' => ['action' => 'mark']]) ?>
                        <?= $this->Form->hidden('emp_id', ['value' => $res->emp_id]) ?>

                        <div class="button-group">
                            <?= $this->Form->button('✅ Present', [
                                'name' => 'status',
                                'value' => 'Present',
                                'class' => 'button2',
                                'disabled' => $disabled
                            ]) ?>
                            <?= $this->Form->button('❌ Absent', [
                                'name' => 'status',
                                'value' => 'Absent',
                                'class' => 'button2',
                                'disabled' => $disabled
                            ]) ?>
                            <?= $this->Form->button('🟡 On Leave', [
                                'name' => 'status',
                                'value' => 'Leave',
                                'class' => 'button2',
                                'disabled' => $disabled
                            ]) ?>
                        </div>

                        <div class="remark-box">
                            <?= $this->Form->textarea('remark', [
                                'placeholder' => 'Enter remark',
                                'rows' => 1,
                                'cols' => 25,
                                'disabled' => $disabled
                            ]) ?>
                        </div>

                        <?= $this->Form->end() ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="bu">
            <?= $this->Html->link(__('Dashboard'), ['controller' => 'Attendence', 'action' => 'display'], ['class' => 'button1']) ?>
        </div>
    </div>
</body>
