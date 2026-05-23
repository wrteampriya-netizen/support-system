<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>comments</title>
</head>


<body class="bg-light">

    <div class="container mt-4">

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Comments List</h5>
            </div>

            <div class="card-body p-0">

                <table class="table table-bordered table-hover mb-0">

                    <thead class="table-dark">
                        <tr>
                            <th>Subject</th>
                            <th>Comment</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($comment as $comments)
                        <tr>
                            <td class="fw-semibold">
                                {{ $comments->subject }}
                            </td>

                            <td>
                                @foreach (explode("\n", $comments->comments) as $singlecomment)
                                <div class="p-2 mb-2 bg-white border rounded shadow-sm text-dark">
                                    <i class="bi bi-chat-text text-primary me-2"></i>
                                    {{ $singlecomment }}
                                </div>
                                @endforeach
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>

    </div>

</body>

</html>