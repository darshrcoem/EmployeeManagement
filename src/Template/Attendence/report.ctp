<body>
    <link rel="stylesheet" href="/css/home.css">

    <div class="view-container">
        <?= $this->Form->create(null, ['type' => 'get']) ?>
        <h2>Attendance Report</h2>

        <div class="filters">
            <?= $this->Form->input('month', [
                'type' => 'month',
                'value' => is_array($this->request->getQuery('month')) ? date('Y-m') : ($this->request->getQuery('month') ?: date('Y-m')),
                'id' => 'month',
                'label' => false,
                'class' => 'date-input',
            ]) ?>

            <?= $this->Form->input('year', [
                'type' => 'year',
                'value' => is_array($this->request->getQuery('year')) ? date('Y') : ($this->request->getQuery('year') ?: date('Y')),
                'id' => 'year',
                'label' => false,
                'class' => 'date-input',
            ]) ?>
            <?= $this->Form->control('department', [
                'type' => 'select',
                'options' => array_combine($departments, $departments),
                'empty' => 'All Departments',
                'value' => $department,
                'label' => false,
                'class' => 'date-input',
            ]) ?>

            <?= $this->Form->button(__('View'), ['type' => 'submit', 'class' => 'button12']) ?>
        </div>

        <h2 class="report-heading">
            Report from
            <span class="date-box"><?= $startDateString ?></span>
            to
            <span class="date-box"><?= $endDateString ?></span>
        </h2>

        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('emp_id', 'Employee ID') ?></th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>✅ Present</th>
                    <th>❌ Absent</th>
                    <th>🟡 On Leave</th>
                    <th>View Calendar</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($attendanceSummary)): ?>
                    <tr>
                        <td colspan="6">No records found.</td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($attendanceSummary as $empId => $res): ?>
                    <tr>
                        <td><?= h($empId) ?></td>
                        <td><?= h($res['name']) ?></td>
                        <td><?= h($res['department']) ?></td>
                        <td><?= h($res['present']) ?></td>
                        <td><?= h($res['absent']) ?></td>
                        <td><?= h($res['leave']) ?></td>
                        <td><button type="button" onclick="showCalendar('<?= h($empId) ?>')">View Calendar</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- 📅 External Calendar Container -->
        <div id="calendar-container" style="display: none; margin-top: 20px;">
            <h3 id="calendar-title"></h3>
            <div id="calendar-box" style="display: flex; flex-wrap: wrap; gap: 10px;"></div>
        </div>

        <!-- 🔙 Back to Dashboard -->
        <div class="bu">
            <?= $this->Html->link(__('Dashboard'), ['controller' => 'Attendence', 'action' => 'display'], ['class' => 'button1']) ?>
        </div>
    </div>
    <script>
        const attendanceData = <?= json_encode($attendanceSummary) ?>;
        const rawMonth = <?= json_encode($month) ?>;
        const rawYear = <?= json_encode($year) ?>;

        // Extract values from object or primitive
        const month = typeof rawMonth === 'object' && rawMonth !== null ? parseInt(rawMonth.month) : parseInt(rawMonth);
        const year = typeof rawYear === 'object' && rawYear !== null ? parseInt(rawYear.year) : parseInt(rawYear);

        console.log(attendanceData, year, month);

        function showCalendar(empId) {
            const container = document.getElementById('calendar-container');
            const box = document.getElementById('calendar-box');
            const title = document.getElementById('calendar-title');

            box.innerHTML = '';
            container.style.display = 'block';

            const empData = attendanceData[empId];
            if (!empData) {
                title.textContent = 'No data available for this employee.';
                return;
            }

            title.textContent = `Attendance Calendar for ${empData.name} (${empId})`;

            const days = empData.days || {};
            const totalDays = new Date(year, month, 0).getDate(); // month is 1-based: May = 5

            console.log('Days:', days);
            console.log('Total Days in month:', totalDays);

            for (let day = 1; day <= totalDays; day++) {
                const dayStr = String(day).padStart(2, '0');
                const fullDate = `${year}-${String(month).padStart(2, '0')}-${dayStr}`;
                const status = days[fullDate] || 'unmarked';

                let className = '';
                if (status === 'present') className = 'present';
                else if (status === 'absent') className = 'absent';
                else if (status === 'leave') className = 'leave';
                else className = 'unmarked';

                const dayBox = document.createElement('div');
                dayBox.className = `day-box ${className}`;
                dayBox.innerHTML = `<div class="day">${dayStr}</div>`;
                box.appendChild(dayBox);
            }
        }
    </script>
</body>