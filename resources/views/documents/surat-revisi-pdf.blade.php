
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <style>
        @page {
            size: A4;
            margin: 2.5cm 2.5cm 2.5cm 3cm;
        }

        body {
            font-family: "DejaVu Serif", serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .dokumen {
            width: 100%;
            text-align: justify;
            white-space: normal;
            overflow-wrap: break-word;
        }

        .isi-surat {
            text-align: justify;
            line-height: 1.5;
        }

        .isi-surat p {
            margin-top: 0;
            margin-bottom: 10pt;
            text-align: justify;
        }

        .isi-surat br {
            line-height: 1.5;
        }

        .footer {
            position: fixed;
            bottom: -1.5cm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9pt;
            color: #666;
        }
    </style>
</head>

<body>

    <div class="dokumen">
        <div class="isi-surat">
            {!! nl2br(e($hasil)) !!}
        </div>
    </div>

</body>
</html>
