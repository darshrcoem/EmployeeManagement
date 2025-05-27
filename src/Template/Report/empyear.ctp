<link rel="stylesheet" href="/css/home.css">

<div class="view-container">
    <?= $this->Form->create(null, ['type' => 'get']) ?>
    <h2>Employees Yearly Salary</h2>

    <div class="filters">
        <?= $this->Form->control('year', [
            'type' => 'select',
            'options' => array_combine($yearList, $yearList),
            'empty' => 'Select Year',
            'value' => $year
        ]) ?>

        <?= $this->Form->button(__('Select year'), ['type' => 'submit', 'class' => 'button12']) ?>
        <?= $this->Form->end() ?>
    </div>
    <table>
        <tr>
            <th>Full Name</th>
            <th>Department</th>
            <th>Total Base Pay</th>
            <th>Total Bonus</th>
            <th>Total Deduction</th>
            <th>Net Salary</th>
        </tr>
        <?php foreach ($data as $res): ?>
            <tr>
                <td><?= h($res->full_name) ?></td>
                <td><?= h($res->department) ?></td>
                <td>₹ <?= h($res->total_base_pay) ?></td>
                <td>₹ <?= h($res->total_bonus12) ?></td>
                <td>₹ <?= h($res->total_deduction12) ?></td>
                <td>₹ <?= h($res->total_net_salary) ?></td>
            </tr>
        <?php endforeach; ?>
        <tr class="total-row">
            <td colspan="2"><strong>Total</strong></td>
            <td>₹ <?= h($sum['total_base_pay'] ?? 0) ?></td>
            <td>₹ <?= h($sum['total_bonus12'] ?? 0) ?></td>
            <td>₹ <?= h($sum['total_deduction12'] ?? 0) ?></td>
            <td>₹ <?= h($sum['total_net_salary'] ?? 0) ?></td>
        </tr>
    </table>
    <div class="bu">
        <?= $this->Html->link(__('Dashboard'), ['controller' => 'Report', 'action' => 'display'], ['class' => 'button1']) ?>
    </div>
</div>
</body>