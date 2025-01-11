@extends('layout')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel - Gemini Integration</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .gemini-answer {
            color: black;
            background-color: #f8f8f8; /* Màu nền nhạt cho dễ đọc */
            border: 1px solid #ddd;
            padding: 8px;
            font-family: sans-serif;
            line-height: 1.6;
            width: 100%; /* Đảm bảo textarea chiếm toàn bộ chiều rộng */
            box-sizing: border-box; /* Tính cả padding và border vào chiều rộng */
            margin-top: 10px;
        }
    </style>
</head>

<body class="bg-gray-900 text-white">
    <div class="container mx-auto px-4 h-screen flex flex-col items-center justify-start pt-6">
        <form id="ask" class="bg-gray-800 rounded-lg p-8 w-full max-w-3xl mb-6" method="POST" action="/question">
            @csrf
            <h1 class="text-2xl font-bold text-white mb-4 text-center">ChatBot</h1>
            <div class="mb-4">
                <label class="block text-white text-sm font-bold mb-2" for="question">
                    Đặt câu hỏi của bạn?
                </label>
                <input class="border border-gray-600 rounded w-full py-2 px-3 text-gray-900" id="question" name="question" type="text" placeholder="Ask Gemini">
                <div class="text-red-500 text-sm mt-2" id="question_help"></div>
            </div>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">
                Gửi
            </button>
        </form>

        <div id="chat" class="container mx-auto px-4 mt-6 w-full max-w-3xl"></div>
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

            $.ajax({
                url: '/question',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.question && data.answer) {
                        let formattedAnswer = formatAnswer(data.answer);
                        $('#chat').prepend(`
                            <div class="bg-gray-800 text-white rounded p-4 mb-4">
                                <h4 class="font-bold">Question:</h4>
                                <p>${data.question}</p>
                            </div>
                            <div class="bg-gray-800 rounded p-4 mb-4">
                                <h5 class="font-bold text-white">Answer:</h5>
                                <div class="gemini-answer">${formattedAnswer}</div>
                            </div>
                        `);
                        $('#question').val(''); // Xóa nội dung câu hỏi sau khi gửi thành công
                    } else if (data.error) {
                        alert(data.error);
                    }
                },
                error: function(err) {
                    console.log('Error:', err);
                    alert('There was an error processing your request.');
                }
            });
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
