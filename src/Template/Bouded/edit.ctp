<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bouded $bouded
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $bouded->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $bouded->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Bouded'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Emp Data'), ['controller' => 'EmpData', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Emp Data'), ['controller' => 'EmpData', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="bouded form large-9 medium-8 columns content">
    <?= $this->Form->create($bouded) ?>
    <fieldset>
        <legend><?= __('Edit Bouded') ?></legend>
        <?php
            echo $this->Form->control('emp_id', ['options' => $empData, 'empty' => true]);
            echo $this->Form->control('record_date', ['empty' => true]);
            echo $this->Form->control('fest_bounse');
            echo $this->Form->control('perf_bounse');
            echo $this->Form->control('tax_ded');
            echo $this->Form->control('unpaid_ded');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
