<?php
/**
 * Test RSVP Form Submit
 * File này giúp test xem form RSVP có hoạt động không
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test RSVP Form Submit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: Arial, sans-serif;
        }
        button {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background: #0056b3;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 4px;
            display: none;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>🧪 Test RSVP Form Submit</h1>
        <form id="testForm">
            <div class="form-group">
                <label for="fullname">Họ và tên:</label>
                <input type="text" id="fullname" name="fullname" value="Nguyễn Test" required>
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại:</label>
                <input type="tel" id="phone" name="phone" value="0901234567">
            </div>
            <div class="form-group">
                <label for="guests">Số người tham dự:</label>
                <input type="number" id="guests" name="guests" min="1" max="10" value="2" required>
            </div>
            <div class="form-group">
                <label>Bạn có thể tham dự?</label>
                <select id="attend" name="attend" required>
                    <option value="yes">Vui mừng tham dự</option>
                    <option value="no">Xin phép vắng mặt</option>
                </select>
            </div>
            <div class="form-group">
                <label for="message">Lời nhắn:</label>
                <textarea id="message" name="message" placeholder="Gửi lời chúc đến cô dâu chú rể...">Chúc mừng hai bạn!</textarea>
            </div>
            <button type="submit">📤 Gửi Test</button>
        </form>

        <div class="result" id="result">
            <h3>Kết quả:</h3>
            <pre id="resultText"></pre>
        </div>
    </div>

    <script>
        document.getElementById('testForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const dataToSend = {
                fullname: document.getElementById('fullname').value,
                phone: document.getElementById('phone').value,
                guests: parseInt(document.getElementById('guests').value),
                attend: document.getElementById('attend').value,
                message: document.getElementById('message').value
            };

            try {
                const response = await fetch('api/save-rsvp.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(dataToSend)
                });

                const result = await response.json();

                const resultDiv = document.getElementById('result');
                const resultText = document.getElementById('resultText');

                resultText.textContent = JSON.stringify(result, null, 2);

                if (result.success) {
                    resultDiv.className = 'result success';
                } else {
                    resultDiv.className = 'result error';
                }

                resultDiv.style.display = 'block';

                // Cũng hiển thị comment và data files
                console.log('Response:', result);
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('result').innerHTML = `
                    <p class="error">Lỗi: ${error.message}</p>
                `;
                document.getElementById('result').style.display = 'block';
            }
        });
    </script>
</body>
</html>

