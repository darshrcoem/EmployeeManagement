<body>
    <div class="view-container">
        <?= $this->Form->create(null, ['type' => 'get']) ?>
        <h2>Mark and Edit Attendance</h2>
        <div class="filters">
            <label for="date">Select Date:</label>
            <?= $this->Form->control('date', [
                'type' => 'date',
                'value' => $date = $this->request->getQuery('date'),
                'id' => 'date',
                'label' => false,
                'class' => 'date-input',
                'max' => date('Y-m-d')
            ]) ?>
            <?= $this->Form->button(__('View'), ['type' => 'submit', 'class' => 'button12']) ?>
        </div>
        <?= $this->Form->end() ?>

        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('emp_id', 'Employee ID') ?></th>
                    <th>Name</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; ?>
                <?php foreach ($emp as $res): ?>
                    <?php $hasAttendance = (isset($data[$i]) && $data[$i]->emp_id == $res->emp_id); ?>
                    <tr>
                        <td><?= h($res->emp_id) ?></td>
                        <td><?= h($res->full_name ?? $res->Full_name) ?></td>
                        <td>
                            <?php if ($hasAttendance): ?>
                                <?php
                                $status = strtolower($data[$i]->Attendence['status']);
                                $access = $data[$i]->Attendence['access'];
                                $isPresent = $status === "present";
                                $isAbsent = $status === "absent";
                                $isLeave = $status === "leave";
                                ?>
                                <?php if ($access == "0"): ?>
                                    Payslip Generated
                                <?php else: ?>
                                    <form class="attendance-form" data-emp-id="<?= h($res->emp_id) ?>"
                                        data-date="<?= h("{$date['year']}-{$date['month']}-{$date['day']}") ?>">
                                        <input type="hidden" name="emp_id" value="<?= h($res->emp_id) ?>">
                                        <input type="hidden" name="date"
                                            value="<?= h("{$date['year']}-{$date['month']}-{$date['day']}") ?>">
                                        <div class="button-group">
                                            <button type="button" class="button2 mark-btn" data-status="Present" <?= $isPresent ? 'disabled' : '' ?>>✅ Present</button>
                                            <button type="button" class="button2 mark-btn" data-status="Absent" <?= $isAbsent ? 'disabled' : '' ?>>❌ Absent</button>
                                            <button type="button" class="button2 mark-btn" data-status="Leave" <?= $isLeave ? 'disabled' : '' ?>>🟡 On Leave</button>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            <?php else: ?>
                                <form class="attendance-form" data-emp-id="<?= h($res->emp_id) ?>"
                                    data-date="<?= h("{$date['year']}-{$date['month']}-{$date['day']}") ?>">
                                    <input type="hidden" name="emp_id" value="<?= h($res->emp_id) ?>">
                                    <input type="hidden" name="date"
                                        value="<?= h("{$date['year']}-{$date['month']}-{$date['day']}") ?>">

                                    <div class="button-group">
                                        <button type="button" class="button2 mark-btn" data-status="Present">✅ Present</button>
                                        <button type="button" class="button2 mark-btn" data-status="Absent">❌ Absent</button>
                                        <button type="button" class="button2 mark-btn" data-status="Leave">🟡 On Leave</button>
                                    </div>
                                    <div class="remark-box">
                                        <textarea class="remark" placeholder="Enter remark" rows="1" cols="25"></textarea>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php if ($hasAttendance)
                        $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Back to Dashboard -->
        <div class="bu">
            <?= $this->Html->link(__('Dashboard'), ['controller' => 'Attendence', 'action' => 'display'], ['class' => 'button1']) ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".mark-btn").click(function (e) {
                e.preventDefault();

                const button = $(this);
                const form = button.closest(".attendance-form");
                const empId = form.data("emp-id");
                const date = form.data("date");
                const status = button.data("status");
                const remark = form.find(".remark").val();

                if (!empId || !date || !status) {
                    alert("Employee ID, date and status are required.");
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "<?= $this->Url->build(['controller' => 'Attendence', 'action' => 'mark']) ?>",
                    data: {
                        emp_id: empId,
                        date: date,
                        status: status,
                        remark: remark
                    },
                    headers: {
                        'X-CSRF-Token': '<?= h($this->request->getParam('_csrfToken')) ?>'
                    },
                    success: function (response) {
                        alert(response.message);
                        if (response.success) {
                            // Disable all buttons and textarea after success
                            form.find(".mark-btn, .remark").attr("disabled", true);
                        }
                    },
                    error: function (xhr) {
                        alert("Error while submitting attendance: " + xhr.status);
                    }
                });
            });
        });
    </script>
</body>