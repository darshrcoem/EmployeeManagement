<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bouded $bouded
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Bouded'), ['action' => 'edit', $bouded->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Bouded'), ['action' => 'delete', $bouded->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bouded->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Bouded'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Bouded'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Emp Data'), ['controller' => 'EmpData', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Emp Data'), ['controller' => 'EmpData', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="bouded view large-9 medium-8 columns content">
    <h3><?= h($bouded->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Emp Data') ?></th>
            <td><?= $bouded->has('emp_data') ? $this->Html->link($bouded->emp_data->emp_id, ['controller' => 'EmpData', 'action' => 'view', $bouded->emp_data->emp_id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($bouded->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fest Bounse') ?></th>
            <td><?= $this->Number->format($bouded->fest_bounse) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Perf Bounse') ?></th>
            <td><?= $this->Number->format($bouded->perf_bounse) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tax Ded') ?></th>
            <td><?= $this->Number->format($bouded->tax_ded) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Unpaid Ded') ?></th>
            <td><?= $this->Number->format($bouded->unpaid_ded) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Record Date') ?></th>
            <td><?= h($bouded->record_date) ?></td>
        </tr>
    </table>
</div>
