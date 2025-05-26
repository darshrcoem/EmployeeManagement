<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Payslip PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            position: relative;
            background-color: #f3f7fa;
            color: #333;
        }

        .watermark {
            position: fixed;
            top: 35%;
            left: 20%;
            opacity: 0.05;
            font-size: 72px;
            transform: rotate(-30deg);
            z-index: 0;
        }

        .payslip-container {
            padding: 25px;
            border: 2px solid #007bff;
            background-color: #ffffff;
            border-radius: 10px;
            position: relative;
            z-index: 1;
        }

        .payslip-header {
            text-align: center;
            margin-bottom: 25px;
            color: #007bff;
        }

        .payslip-header img {
            max-height: 60px;
            margin-bottom: 10px;
        }

        .info-row {
            display: flex;
            margin-bottom: 10px;
        }

        .info-label {
            width: 180px;
            font-weight: bold;
            color: #0056b3;
        }

        .info-value {
            flex: 1;
        }

        .net-salary {
            font-size: 18px;
            font-weight: bold;
            color: #28a745;
            margin-top: 20px;
            text-align: right;
        }

        .signature {
            text-align: right;
            margin-top: 40px;
        }

        .signature img {
            max-height: 50px;
        }

        .signature span {
            display: block;
            font-weight: bold;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <!-- Watermark -->
    <div class="watermark">Workwise 360</div>

    <div class="payslip-container" role="region" aria-label="Employee Payslip">
        <div class="payslip-header">
          <img src="/img/favicon1.png" alt="Company Logo">

            <h1>Employee Payment Slip</h1>
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

        <div class="net-salary">Net Salary: ₹ <?= number_format($data['net_pay'], 2) ?></div>

        <div class="signature">
            <img src="/img/favicon.png" alt="Company Logo">
            <span>Authorized Signatory</span>
        </div>
    </div>
</body>

</html>
