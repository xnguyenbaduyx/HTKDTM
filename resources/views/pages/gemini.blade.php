@extends('layout')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel - Gemini Integration</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            background-color: #343541; /* Màu nền tối giống ChatGPT */
            color: #d1d5db; /* Màu chữ xám nhạt */
        }

        #chat-box {
            max-height: 70vh;
            padding-right: 10px; /* Khoảng cách 10px với thanh cuộn */
            padding-left: 10px;  /* Khoảng cách 10px với cạnh trái */
        }
        .chat-container {
            /* max-width: 700px;
            margin: 0 auto;
            padding: 16px; */
            flex: 1; /* Tin nhắn sẽ chiếm hết không gian còn lại */
            overflow-y: auto;
            margin-bottom: 16px;
        }

        .message {
            margin-bottom: 12px;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 16px;
            line-height: 1.5;
        }

        .user-message {
            background-color: #4a5568; /* Màu cho tin nhắn của người dùng */
            color: #fff;
            text-align: right;
        }

        .bot-message {
            background-color: #1a202c; /* Màu cho tin nhắn của bot */
            color: #d1d5db;
        }

        .input-container {
            display: flex;
            margin-right: 16px;
            align-items: center;
            gap: 8px;
            background-color: #40414f; /* Màu nền cho input */
            padding: 8px 16px;
            border-radius: 8px;
            margin-top: 16px;
            position: relative;
            z-index: 1;
        }

        .input-container input {
            flex: 1;
            background-color: transparent;
            border: none;
            outline: none;
            color: #fff;
            font-size: 16px;
            padding: 8px;
        }

        .input-container button {
            background-color: #10a37f; /* Màu nút gửi */
            color: #fff;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .input-container button:hover {
            background-color: #0f8d6d;
        }
        .chat-wrapper {
            max-width: 800px;
            margin: 50px auto;
            background-color: #1e293b; /* Màu nền cho khung chat */
            border-radius: 12px;
            padding: 16px;
            padding-right: 1px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            height: 80vh; /* Đảm bảo chiều cao bằng 80% chiều cao màn hình */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .chat-header {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 16px;
            color: #10a37f;
        }
    </style>
</head>

<<<<<<< HEAD
<body>
    <div class="chat-wrapper">
        <div class="chat-header">
            Chat bot
        </div>
        <div class="chat-container">
            <!-- Khung hiển thị các tin nhắn -->
            <div id="chat-box"  style="max-height: 70vh;">
                <!-- Tin nhắn mẫu sẽ được thêm vào đây -->
            </div>
        </div>
        <!-- Form gửi tin nhắn -->
        <form id="ask" class="input-container">
            @csrf
            <input id="question" name="question" type="text" placeholder="Nhập câu hỏi..." autocomplete="off">
            <button type="submit">Gửi</button>
        </form>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#ask').submit(function(event) {
            event.preventDefault();
            let formData = new FormData($('#ask')[0]);
            let userMessage = $('#question').val();

            if (userMessage.trim() === '') {
                alert('Vui lòng nhập câu hỏi!');
                return;
            }

            $('#chat-box').append(`
                <div class="message user-message">
                    ${userMessage}
                </div>
            `);
            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);

            $.ajax({
                url: '/question',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.answer) {
                        $('#chat-box').append(`
                            <div class="message bot-message">
                                ${data.answer}
                            </div>
                        `);
                        $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                    } else {
                        alert('Không thể nhận được câu trả lời.');
                    }
                },
                error: function(err) {
                    console.log('Error:', err);
                    alert('Có lỗi xảy ra.');
                }
            });

            $('#question').val(''); 
        });

        // Hàm để định dạng câu trả lời
        function formatAnswer(answer) {
            // Tách câu trả lời thành các đoạn nhỏ
            let sentences = answer.split('.'); // Tách theo dấu chấm (.) sau mỗi câu
            let formattedAnswer = sentences.map(sentence => `<p>${sentence.trim()}</p>`).join('');
            return formattedAnswer;
        }
    </script>
</body>
@endsection

