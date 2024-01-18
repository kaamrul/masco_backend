<!DOCTYPE html>
<html lang="en">
<head>
  <title>Verify Email</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-8">

            <form method="post" action="{{ route('public.store.verify.email', ['member' => $member->id, 'type' => $type]) }}">
                @csrf

                <div class="card shadow-sm">
                    <div class="card-header">
                        <h2>Verify Your Email Address</h2>
                    </div>
                    <div class="card-body" style="padding: 50px 10px;">
                        <h4 class="text-center">Are you sure to verify your email?</h4>
                    </div>
                    <div class="card-footer">
                        <div class="text-center">
                            <button class="btn btn-danger" onclick="window.close();">Close</button>
                            <button type="submit" class="btn btn-success">Yes</button>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

</body>
</html>
