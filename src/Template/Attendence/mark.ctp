<head>  <?= $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')) ?></head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<body>
    <div class="view-container">
        <h2>Mark Today's Attendance</h2>
        <table>
            <tr>
                <th>Employee ID</th>
                <th>Full Name</th>
                <th>Department</th>
                <th>Email</th>
                <th>Status</th>
                <th>Mark & Remark</th>
            </tr>
            <?php foreach ($emp as $res): ?>
                <?php
                $isInactive = strtolower($res->status) === 'inactive';
                $isMarked = isset($attendence[$res->emp_id]);
                $disabled = $isInactive || $isMarked;
                ?>

                <tr>
                    <td><?= h($res->emp_id) ?></td>
                    <td><?= h($res->Full_name) ?></td>
                    <td><?= h($res->department) ?></td>
                    <td><?= h($res->email) ?></td>
                    <td><?= h($res->status) ?></td>
                    <td>
                        <form class="attendance-form" data-emp-id="<?= h($res->emp_id) ?>">
                            <?= $this->Form->control('_csrfToken', ['type' => 'hidden', 'value' => $this->request->getAttribute('csrfToken')]) ?>

                            <div class="button-group">
                                <button type="button" class="button2 mark-btn" data-status="Present" <?= $disabled ? 'disabled' : '' ?>>✅ Present</button>
                                <button type="button" class="button2 mark-btn" data-status="Absent" <?= $disabled ? 'disabled' : '' ?>>❌ Absent</button>
                                <button type="button" class="button2 mark-btn" data-status="Leave" <?= $disabled ? 'disabled' : '' ?>>🟡 On Leave</button>
                            </div>
                            <div class="remark-box">
                                <textarea class="remark" placeholder="Enter remark" rows="1" cols="25" <?= $disabled ? 'disabled' : '' ?>></textarea>
                            </div>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="bu">
            <?= $this->Html->link(__('Dashboard'), ['controller' => 'Attendence', 'action' => 'display'], ['class' => 'button1']) ?>
        </div>
    </div>

    <script>
        $(".mark-btn").click(function (e) {
            var csrfToken = $('meta[name="csrfToken"]').attr('content');
            e.preventDefault();
            const button = $(this);
            const form = button.closest(".attendance-form");
            const empId = form.data("emp-id");
            const status = button.data("status");
            const remark = form.find(".remark").val();
            if (!empId || !status) {
                alert("Employee ID and status are required.");
                return;
            }

            $.ajax({
                type: "POST",
                url: "<?= $this->Url->build(['controller' => 'Attendence', 'action' => 'mark']) ?>",
                data: {
                    emp_id: empId,
                    status: status,
                    remark: remark
                },
                headers: {
                    'X-CSRF-Token': '<?=h($this->request->getParam('_csrfToken')) ?>'
                },
    
                success: function (response) {
                    alert("Attendance marked as " + status);
                    form.find(".mark-btn, .remark").attr("disabled", true);
                },
                error: function (xhr) {
                    alert("Error while submitting attendance: " + xhr.status);
                }
            });
        });

    </script>
</body>

</html>