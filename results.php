
<?php
// Database connection
$db = new SQLite3('hi.db');

$roll = $_GET['roll'] ?? '';
$result = null;

if ($roll) {
    $stmt = $db->prepare('SELECT * FROM student_results WHERE roll_number = ?');
    $stmt->bindValue(1, $roll, SQLITE3_TEXT);
    $result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Results, Audit, and Transaction History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #2c3e50, #4ca1af);
            color: #333;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }
        h1, h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #e0e0e0;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4ca1af;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f8f8f8;
        }
        tr:hover {
            background-color: #e0f0ff;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4ca1af;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            margin: 0 10px;
            cursor: pointer;
            border: none;
            font-weight: bold;
        }
        .button:hover {
            background-color: #357ca5;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        #auditTable, #historyTable {
            display: none;
        }
        .green {
            background-color: #e6ffe6;
        }
        .red {
            background-color: #ffe6e6;
        }
        p {
            color: #e74c3c;
            text-align: center;
            font-weight: bold;
        }
        .download-options {
            text-align: right;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student Information Center</h1>
        
        <div class="button-container">
            <button class="button" onclick="showSection('resultsTable')">View Results</button>
            <button class="button" onclick="showSection('auditTable')">View and Download Data for Audit</button>
            <button class="button" onclick="showSection('historyTable')">View History</button>
            <a href="index.php" class="button">Back to Home</a>
        </div>

        <div id="resultsTable">
            <h2>Student Results</h2>
            <?php if ($result): ?>
                <table>
                    <tr>
                        <th>Roll Number</th>
                        <td><?php echo htmlspecialchars($result['roll_number']); ?></td>
                    </tr>
                    <tr>
                        <th>Semester</th>
                        <td><?php echo htmlspecialchars($result['semester']); ?></td>
                    </tr>
                    <?php for ($i = 1; $i <= 9; $i++): ?>
                        <tr>
                            <th>Subject <?php echo $i; ?></th>
                            <td>
                                <?php
                                $grade = $result["subject$i"];
                                echo $grade == 1 ? 'A' : ($grade == 2 ? 'B' : ($grade == 3 ? 'C' : ($grade == 0 ? 'F' : 'N/A')));
                                ?>
                            </td>
                        </tr>
                    <?php endfor; ?>
                </table>
            <?php elseif ($roll): ?>
                <p>No results found for the given roll number.</p>
            <?php endif; ?>
        </div>

        <div id="auditTable" style="display:none;">
            <h2>View and Download Data for Audit</h2>
            <div class="download-options">
                <button class="button" onclick="downloadAuditData('csv')">Download as CSV</button>
                <button class="button" onclick="downloadAuditData('json')">Download as JSON</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Timestamp</th>
                        <th>Hash</th>
                        <th>XNO Asset Value</th>
                        <th>Sender</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div id="historyTable" style="display:none;">
            <h2>Transaction History</h2>
            <table>
                <thead>
                    <tr>
                        <th>Timestamp</th>
                        <th>Roll Number</th>
                        <th>Semester</th>
                        <th>Grades</th>
                        <th>Sender</th>
                        <th>Transaction Hash</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <script>
        const nanoAddress = "nano_1yiqeaskez38key1iicnaxg5jrubrhk8btezgtcicq1cxy9ue55q6ok1zi93";
        let auditData = [];

        function showSection(sectionId) {
            document.getElementById('resultsTable').style.display = 'none';
            document.getElementById('auditTable').style.display = 'none';
            document.getElementById('historyTable').style.display = 'none';
            document.getElementById(sectionId).style.display = 'block';

            if (sectionId === 'auditTable' && document.querySelector("#auditTable tbody").children.length === 0) {
                loadAuditData();
            } else if (sectionId === 'historyTable' && document.querySelector("#historyTable tbody").children.length === 0) {
                loadHistoryData();
            }
        }

        function loadAuditData() {
            fetch(`https://node.somenano.com/proxy/?action=account_history&account=${nanoAddress}&count=100`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector("#auditTable tbody");
                    tableBody.innerHTML = ''; // Clear existing data
                    auditData = data.history.filter(transaction => transaction.type === "receive").map(transaction => ({
                        timestamp: new Date(transaction.local_timestamp * 1000).toLocaleString(),
                        hash: transaction.hash,
                        xnoValue: transaction.amount,
                        sender: transaction.account
                    }));
                    auditData.forEach(transaction => {
                        const row = document.createElement("tr");
                        row.innerHTML = `
                            <td>${transaction.timestamp}</td>
                            <td><small>${transaction.hash}</small></td>
                            <td>${transaction.xnoValue}</td>
                            <td>${transaction.sender}</td>
                        `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => console.error("Error fetching audit data:", error));
        }

        function loadHistoryData() {
            fetch(`https://node.somenano.com/proxy/?action=account_history&account=${nanoAddress}&count=100`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector("#historyTable tbody");
                    tableBody.innerHTML = ''; // Clear existing data
                    data.history.forEach(transaction => {
                        const row = document.createElement("tr");
                        const amount = BigInt(transaction.amount);
                        
                        const rawData = amount.toString().padStart(25, '0');
                        const rollNumber = rawData.slice(1, 13);
                        const semester = parseInt(rawData.slice(12, 13));
                        const grades = rawData.slice(13, 22).split('').map(grade => 
                            grade === '1' ? 'A' : (grade === '2' ? 'B' : (grade === '3' ? 'C' : 'F'))
                        ).join(', ');

                        if (transaction.type === "receive") {
                            row.classList.add("green");
                        } else {
                            row.classList.add("red");
                        }

                        row.innerHTML = `
                            <td>${new Date(transaction.local_timestamp * 1000).toLocaleString()}</td>
                            <td>${rollNumber}</td>
                            <td>${semester}</td>
                            <td>${grades}</td>
                            <td>${transaction.account}</td>
                            <td><small>${transaction.hash}</small></td>
                        `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => console.error("Error fetching history data:", error));
        }

        function downloadAuditData(format) {
            if (format === 'csv') {
                const csvContent = "data:text/csv;charset=utf-8," 
                    + "Timestamp,Hash,XNO Asset Value,Sender\n"
                    + auditData.map(row => Object.values(row).join(",")).join("\n");
                const encodedUri = encodeURI(csvContent);
                const link = document.createElement("a");
                link.setAttribute("href", encodedUri);
                link.setAttribute("download", "audit_data.csv");
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else if (format === 'json') {
                const jsonContent = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(auditData));
                const link = document.createElement("a");
                link.setAttribute("href", jsonContent);
                link.setAttribute("download", "audit_data.json");
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }

        // Show results by default
        showSection('resultsTable');
    </script>
</body>
</html>

