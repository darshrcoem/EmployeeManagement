<?= $this->Form->create(null, ['url' => ['controller' => 'Payslip', 'action' => 'Bouded'], 'class' => 'payslip-container']) ?>
<div class="payslip-header">
  <img src="/img/favicon1.png" alt="Company Logo">
  <h1>Payment Slip</h1>
  <p><?= $month . "-" . $year ?></p>
</div>

<div class="info-row">
  <div class="info-label">Employee Name:</div>
  <div class="info-value"><?= $emp->Full_name ?></div>
</div>

<div class="info-row">
  <div class="info-label">Employee ID:</div>
  <div class="info-value"><?= $emp->emp_id ?></div>
</div>
<div class="info-row">
  <div class="info-label">Departent</div>
  <div class="info-value"><?= $emp->department ?></div>
</div>

<div class="info-row">
  <div class="info-label">Basic Salary:</div>
  <div class="info-value"><?= $emp->salary ?></div>
</div>

<!-- Working Days & Days Worked in One Row -->
<div class="info-row two-cols">
  <div class="info-pair">
    <label>Working Days:</label>
    <?= $workingDaysCount ?>
  </div>
  <div class="info-pair">
    <label>Days Worked:</label>
    <?= $daysWorked ?>
  </div>
   <div class="info-pair">
    <label>Leaves</label>
    <?= $leaves ?>
  </div>
  <div class="info-pair">
    <label>Absenties</label>
    <?= $absenties ?>
  </div>
</div>
<?= $this->Form->hidden('emp_id', ['value' => $emp->emp_id]) ?>
<?= $this->Form->hidden('month', ['value' => $month]) ?>
<?= $this->Form->hidden('year', ['value' => $year]) ?>
<?= $this->Form->hidden('full_name', ['value' => $emp->Full_name]) ?>
<?= $this->Form->hidden('salary', ['value' => $emp->salary]) ?>
<?= $this->Form->hidden('working_days', ['value' => $workingDaysCount]) ?>
<?= $this->Form->hidden('days_worked', ['value' => $daysWorked]) ?>
<?= $this->Form->hidden('department', ['value' => $emp->department]) ?>
<!-- Bonuses in One Row -->
<div class="info-row two-cols">
  <div class="info-pair">
    <label>Performance Bonus:</label>
    ₹ <?= $this->Form->number('performance_bonus', ['step' => '0.01', 'id' => 'performance_bonus']) ?>
  </div>
  <div class="info-pair">
    <label>Festival Bonus:</label>
    ₹ <?= $this->Form->number('festival_bonus', ['step' => '0.01', 'id' => 'festival_bonus']) ?>
  </div>
</div>

<!-- Deductions in One Row -->
<div class="info-row two-cols">
  <div class="info-pair">
    <label>Tax Deduction:</label>
    ₹ <?= $this->Form->number('tax_deduction', ['step' => '0.01', 'id' => 'tax_deduction']) ?>
  </div>
  <div class="info-pair">
    <label>Unpaid Leave Deduction:</label>
    ₹ <?= $this->Form->number('unpaid_leave_deduction', ['step' => '0.01', 'id' => 'unpaid_leave_deduction']) ?>
  </div>
</div>

<!-- Net Salary -->
<div class="info-row">
  <div class="net-salary">
    Net Salary: ₹ <span id="net_salary"><?= number_format(10000, 2) ?></span>
  </div>
</div>

<div class="bu">
  <?= $this->Form->button(__('Generate Payslip'), ['class' => 'button1']) ?>
</div>
<?= $this->Form->end() ?>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const salary = parseFloat(<?= json_encode($emp->salary) ?>);
    const workingDays = parseFloat(<?= json_encode($workingDaysCount) ?>);
    const daysWorked = parseFloat(<?= json_encode($daysWorked) ?>);

    const performanceBonus = document.getElementById('performance_bonus');
    const festivalBonus = document.getElementById('festival_bonus');
    const taxDeduction = document.getElementById('tax_deduction');
    const unpaidLeaveDeduction = document.getElementById('unpaid_leave_deduction');
    const netSalarySpan = document.getElementById('net_salary');

    function calculateNetSalary() {
      const perfBonus = parseFloat(performanceBonus.value) || 0;
      const festBonus = parseFloat(festivalBonus.value) || 0;
      const taxDed = parseFloat(taxDeduction.value) || 0;
      const unpaidDed = parseFloat(unpaidLeaveDeduction.value) || 0;

      const base = (salary / workingDays) * daysWorked;

      const net = base + perfBonus + festBonus - taxDed - unpaidDed;
      netSalarySpan.textContent = net.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    [performanceBonus, festivalBonus, taxDeduction, unpaidLeaveDeduction].forEach(input => {
      input.addEventListener('input', calculateNetSalary);
    });
    calculateNetSalary();
  });
</script>