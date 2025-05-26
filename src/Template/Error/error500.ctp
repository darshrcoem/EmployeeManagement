<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->layout = 'error';

if (Configure::read('debug')) :
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error500.ctp');

    $this->start('file');
?>
<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?php Debugger::dump($error->params) ?>
<?php endif; ?>
<?php if ($error instanceof Error) : ?>
        <strong>Error in: </strong>
        <?= sprintf('%s, line %s', str_replace(ROOT, 'ROOT', $error->getFile()), $error->getLine()) ?>
<?php endif; ?>
<?php
    echo $this->element('auto_table_warning');

    if (extension_loaded('xdebug')) :
        xdebug_print_function_stack();
    endif;

    $this->end();
endif;
?>
<h2><?= __d('cake', 'An Internal Error Has Occurred') ?></h2>
<p class="error">
    <strong><?= __d('cake', 'Error') ?>: </strong>
    <?= h($message) ?>
</p>
<style>
    body {
        background: linear-gradient(135deg, #ff6a00, #ee0979, #00c3ff, #ffff1c);
        background-size: 400% 400%;
        animation: gradientBG 10s ease infinite;
        min-height: 100vh;
        margin: 0;
        font-family: 'Segoe UI', Arial, sans-serif;
    }
    @keyframes gradientBG {
        0% {background-position: 0% 50%;}
        50% {background-position: 100% 50%;}
        100% {background-position: 0% 50%;}
    }
    h2 {
        color: #fff;
        text-shadow: 2px 2px 8px #000, 0 0 10px #ff6a00;
        font-size: 2.5em;
        margin-top: 60px;
        text-align: center;
        animation: popIn 1s cubic-bezier(.68,-0.55,.27,1.55);
    }
    @keyframes popIn {
        0% {transform: scale(0.7); opacity: 0;}
        80% {transform: scale(1.1);}
        100% {transform: scale(1); opacity: 1;}
    }
    .error {
        background: rgba(255,255,255,0.15);
        border: 2px solid #fff700;
        border-radius: 16px;
        color: #222;
        font-size: 1.3em;
        margin: 30px auto;
        max-width: 600px;
        padding: 30px 40px;
        box-shadow: 0 8px 32px 0 rgba(31,38,135,0.37);
        backdrop-filter: blur(4px);
        animation: fadeInUp 1.2s;
    }
    @keyframes fadeInUp {
        0% {transform: translateY(40px); opacity: 0;}
        100% {transform: translateY(0); opacity: 1;}
    }
    .notice, strong {
        color: #ee0979;
        font-weight: bold;
        font-size: 1.1em;
    }
    .notice {
        background: rgba(255,255,255,0.2);
        border-left: 5px solid #00c3ff;
        padding: 10px 20px;
        margin: 20px 0;
        border-radius: 8px;
        animation: fadeIn 1.5s;
    }
    @keyframes fadeIn {
        from {opacity: 0;}
        to {opacity: 1;}
    }
</style>