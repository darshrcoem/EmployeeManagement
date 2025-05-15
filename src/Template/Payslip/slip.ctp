<style>
  /* Blur container with background blur + shadow */
  .payslip-container {
    max-width: 450px;
    margin: 40px auto;
    padding: 30px 25px;
    border-radius: 16px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    color: #111;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

  /* Header */
  .payslip-header {
    text-align: center;
    margin-bottom: 20px;
  }

  .payslip-header h1 {
    margin: 0;
    font-size: 1.9rem;
    letter-spacing: 1.5px;
    color: #2c3e50;
  }

  .payslip-header p {
    margin: 4px 0 0;
    font-weight: 600;
    color: #34495e;
    font-size: 1.1rem;
  }

  /* Info rows */
  .info-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.25);
    font-size: 1rem;
  }

  .info-label {
    font-weight: 600;
    color: #34495e;
  }

  .info-value {
    color: #2c3e50;
  }

  /* Net salary highlight */
  .net-salary {
    margin-top: 25px;
    text-align: center;
    font-size: 1.4rem;
    font-weight: 700;
    color: #27ae60;
  }

  /* Responsive */
  @media (max-width: 480px) {
    .payslip-container {
      margin: 20px 15px;
      padding: 20px 15px;
    }
  }
</style>

<div class="payslip-container" role="region" aria-label="Employee Payslip">
  <div class="payslip-header">
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