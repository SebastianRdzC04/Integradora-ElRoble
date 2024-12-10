<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Blocked</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .blocked-container {
            max-width: 400px;
            text-align: center;
        }

        .blocked-icon {
            font-size: 5rem;
            color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="blocked-container">
            <div class="blocked-icon mb-4">
                <i class="bi bi-slash-circle"></i>
            </div>
            <h1 class="mb-4">Account Blocked</h1>
            <div class="alert alert-danger" role="alert">
                <p class="mb-0">Your account has been blocked by the administrator.</p>
            </div>
            <p class="text-muted">You cannot perform any actions at this time. Please contact the administrator for
                assistance.</p>
            <button class="btn btn-secondary mt-3" disabled>All Actions Disabled</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</body>

</html>
