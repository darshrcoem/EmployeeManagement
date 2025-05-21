<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Dashboard</title>
    <link rel="stylesheet" href="/css/home.css">
</head>

<body>
    <div class="toolbar">
        <div class="admin-name">Admin: <?=  $username?></div>
        <button class="menu-button" onclick="toggleDropdown()">☰ Menu</button>
    </div>

   <div class="dropdown" id="dropdownMenu">
        <ul>
            <li><a href="<?= $this->Url->build(['controller' => 'EmpData', 'action' => 'display']); ?>">Dashboard</a>
            </li>
            <li><a href="<?= $this->Url->build(['controller' => 'Attendence', 'action' => 'display',$username]); ?>">Attendence
                    Management</a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'Payslip', 'action' => 'display',$username]); ?>">Payroll
                    management</a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'Report', 'action' => 'display',$username]); ?>">Additional
                    Reports</a></li>
        </ul>
    </div>
    <div class="admin-form-container">
        <h2>Welcome to Reports</h2>
        <nav>
            <ul>
                <li><a href="<?= $this->Url->build(['controller' => 'Report', 'action' => 'dept']); ?>"> Department Monthly Salary Report
                       </a></li>
                <li><a href="<?= $this->Url->build(['controller' => 'Report', 'action' => 'empmonth']); ?>">Employee Monthly Salary Report
                    </a></li>
                <li><a href="<?= $this->Url->build(['controller' => 'Report', 'action' => 'empyear']); ?>">Employee Yearly Salary Report</a></li>
            </ul>
        </nav>
        <a href="/logout" class="logout-link">Logout</a>
    </div>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById("dropdownMenu");
            const button = document.querySelector(".menu-button");

            if (dropdown.style.display === "block") {
                dropdown.style.display = "none";
            } else {
                dropdown.style.display = "block";

              
                const buttonRect = button.getBoundingClientRect();
                dropdown.style.top = `${buttonRect.bottom}px`;
                dropdown.style.left = `${buttonRect.left}px`;
            }
        }

        document.addEventListener('click', function (event) {
            const dropdown = document.getElementById("dropdownMenu");
            const button = document.querySelector(".menu-button");
            if (!dropdown.contains(event.target) && !button.contains(event.target)) {
                dropdown.style.display = "none";
            }
        });
    </script>
</body>

</html>