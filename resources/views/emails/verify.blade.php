<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Thực Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }
        h2 {
            color: #333;
        }
        p {
            color: #555;
            font-size: 16px;
        }
        .button {
            display: inline-block;
            background-color: #28a745;
            color: #ffffff !important;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #218838;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Chào bạn!</h2>
        <p>Cảm ơn bạn đã đăng ký tài khoản. Để hoàn tất việc đăng ký, vui lòng xác thực email của bạn bằng cách nhấn vào nút bên dưới:</p>
        <a href="{{ url('/api/v1/verify-email?token=' . $token) }}" class="button">Xác Thực Email</a>
        <p class="footer">Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này.</p>
        <p class="footer">Trân trọng, <br> <strong>Đội ngũ Hỗ trợ</strong></p>
    </div>
</body>
</html>
