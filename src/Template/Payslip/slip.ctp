<style>
  body {
    background-color: #0b1c36;
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .payslip-container {
    max-width: 500px;
    margin: 40px auto;
    padding: 30px 25px;
    border-radius: 16px;
    border: 2px solid#00FFFF;
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
    color: #ecf0f1;
    animation: fadeInScale 0.7s ease forwards;
    opacity: 0;
    transform: scale(0.95);
  }

  @keyframes fadeInScale {
    to {
      opacity: 1;
      transform: scale(1);
    }
  }

  .payslip-header {
    text-align: center;
    margin-bottom: 25px;
  }

  .payslip-header img {
    max-height: 60px;
    margin-bottom: 10px;
  }

  .payslip-header h1 {
    margin: 0;
    font-size: 2rem;
    letter-spacing: 1px;
    color: #ffffff;
  }

  .payslip-header p {
    margin: 5px 0 0;
    font-weight: 500;
    font-size: 1.1rem;
    color: #bdc3c7;
  }

  .info-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.15);
    font-size: 1rem;
  }

  .info-label {
    font-weight: 600;
    color: #dcdde1;
  }

  .info-value {
    color: #f5f6fa;
  }

  .net-salary {
    margin-top: 30px;
    text-align: center;
    font-size: 1.4rem;
    font-weight: bold;
    color: #2ecc71;
  }

  .bu {
    text-align: center;
    margin-top: 20px;
  }

  .button1 {
    background-color: #2980b9;
    color: #fff;
    padding: 10px 18px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: background-color 0.3s ease;
  }

  .button1:hover {
    background-color: #1c5980;
  }

  @media (max-width: 480px) {
    .payslip-container {
      margin: 20px 10px;
      padding: 20px 15px;
    }
  }
</style>

<div class="payslip-container" role="region" aria-label="Employee Payslip">
  <div class="payslip-header">
    <!-- Replace with your actual logo -->
    <img src="/img/favicon1.png" alt="Company Logo">
    <h1>Payment Slip</h1>
    <p><?= h($data['month']) ?> - <?= h($data['payment_date']) ?></p>
  </div>

  <div class="info-row">
    <div class="info-label">Employee Name:</div>
    <div class="info-value"><?= h($data['full_name']) ?></div>
  </div>

  <div class="info-row">
    <div class="info-label">Employee ID:</div>
    <div class="info-value"><?= h($data['emp_id']) ?></div>
  </div>

  <div class="info-row">
    <div class="info-label">Month:</div>
    <div class="info-value"><?= h($data['month']) ?></div>
  </div>
  <div class="info-row">
    <div class="info-label">Year:</div>
    <div class="info-value"><?= h($data['year']) ?></div>
  </div>

  <div class="info-row">
    <div class="info-label">Basic Salary:</div>
    <div class="info-value">₹ <?= number_format($data['base_pay'], 2) ?></div>
  </div>

  <div class="info-row">
    <div class="info-label">Days Worked:</div>
    <div class="info-value"><?= h($data['days_worked']) ?></div>
  </div>

  <div class="info-row">
    <div class="info-label">Total Bonus:</div>
    <div class="info-value">₹ <?= number_format($data['total_bonus'], 2) ?></div>
  </div>

  <div class="info-row">
    <div class="info-label">Total Deductions:</div>
    <div class="info-value">₹ <?= number_format($data['total_deduction'], 2) ?></div>
  </div>

  <div class="net-salary">
    Net Salary: ₹ <?= number_format($data['net_pay'], 2) ?>
  </div>
</div>
 <div class="bu">
    <?= $this->Html->link('Download Payslip PDF', ['controller'=>'Payslip','action' => 'pdf', $data['id']], ['class' => 'button12 ']) ?>
  </div>

  <div class="bu">
    <?= $this->Html->link(__('Dashboard'), ['controller' => 'Payslip', 'action' => 'display'], ['class' => 'button1']) ?>
  </div>