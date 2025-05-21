<body>
    <link rel="stylesheet" href="/css/home.css">

    <div class="view-container">
        <?= $this->Form->create(null, ['type' => 'get']) ?>
        <h2>Employees Monthly Salary</h2>

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
                <th>Full Name</th>
                <th>Department</th>
                <th>Year</th>
                <th> Base Pay</th>
                <th> Bonus</th>
                <th> Deduction</th>
                <th>Net Salary</th>
            </tr>
            <?php foreach ($data AS $res): ?>
                <tr>
                    <td><?= h($res->full_name) ?></td>
                    <td><?= h($res->department) ?></td>
                    <td><?= h($res->year) ?></td>
                    <td><?= h($res->base_pay) ?></td>
                    <td><?= h($res->total_bonus) ?></td>
                    <td><?= h($res->total_deduction)?></td>
                    <td><?= h($res->net_pay)?></td>
                    
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="bu">
            <?= $this->Html->link(__('Dashboard'), ['controller' => 'Report', 'action' => 'display'], ['class' => 'button1']) ?>
        </div>
        </div>
</body>