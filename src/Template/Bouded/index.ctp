<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bouded[]|\Cake\Collection\CollectionInterface $bouded
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Bouded'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Emp Data'), ['controller' => 'EmpData', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Emp Data'), ['controller' => 'EmpData', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="bouded index large-9 medium-8 columns content">
    <h3><?= __('Bouded') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('emp_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('record_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fest_bounse') ?></th>
                <th scope="col"><?= $this->Paginator->sort('perf_bounse') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tax_ded') ?></th>
                <th scope="col"><?= $this->Paginator->sort('unpaid_ded') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bouded as $bouded): ?>
            <tr>
                <td><?= $this->Number->format($bouded->id) ?></td>
                <td><?= $bouded->has('emp_data') ? $this->Html->link($bouded->emp_data->emp_id, ['controller' => 'EmpData', 'action' => 'view', $bouded->emp_data->emp_id]) : '' ?></td>
                <td><?= h($bouded->record_date) ?></td>
                <td><?= $this->Number->format($bouded->fest_bounse) ?></td>
                <td><?= $this->Number->format($bouded->perf_bounse) ?></td>
                <td><?= $this->Number->format($bouded->tax_ded) ?></td>
                <td><?= $this->Number->format($bouded->unpaid_ded) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $bouded->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $bouded->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $bouded->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bouded->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
