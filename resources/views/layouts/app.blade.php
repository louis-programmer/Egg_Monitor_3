<!DOCTYPE html>
<html>
<head>
    <title>Egg Monitor 3</title>

    <style>

        .machine-grid {
            display:flex;
            flex-wrap:wrap;
            gap:10px;
        }

        .machine-card {
            width:120px;
            height:120px;
            border:4px solid #ccc;
            display:flex;
            align-items:center;
            justify-content:center;
            border-radius:12px;
        }

        .vacant {
            border-color:green;
        }

        .occupied {
            border-color:orange;
        }

        .inactive {
            border-color:red;
        }


body{
    background:#f1f3f5;
    font-family:Arial, Helvetica, sans-serif;
    margin:0;
    padding:20px;
}

.summary-card,
.machine-card{
    background:#ffffff;
}
    </style>

</head>
<body>

    @yield('content')

</body>
</html>