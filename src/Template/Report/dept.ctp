
    <link rel="stylesheet" href="/css/home.css">

    <div class="view-container">
        <?= $this->Form->create(null, ['type' => 'get']) ?>
        <h2>Departments Monthly Salary</h2>

        <div class="filters">
            <?= $this->Form->control('selectedMonth', [
                'type' => 'select',
                'options' => array_combine($monthList, $monthList),
                'empty' => 'Select Month',
                'value' => $selectedMonth
            ]) ?>

            <?= $this->Form->button(__('Select Month'), ['type' => 'submit', 'class' => 'button12']) ?>
            <?= $this->Form->end()?>
        </div>
        <table>
            <tr>
                <th>Department</th>
                <th>Total Base Pay</th>
                <th>Total Bonus</th>
                <th>Total Deduction</th>
                <th>Total Net Salary</th>
            </tr>
            <?php foreach ($report as $res): ?>
                <tr>
                    <td><?= h($res->department) ?></td>
                    <td><?= h($res->total_base_pay) ?></td>
                    <td><?= h($res->total_bonus) ?></td>
                    <td><?= h($res->total_deduction) ?></td>
                    <td><?= h($res->total_net_salary) ?></td>
                    
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="bu">
            <?= $this->Html->link(__('Dashboard'), ['controller' => 'Report', 'action' => 'display'], ['class' => 'button1']) ?>
        </div>
        </div>
</body>