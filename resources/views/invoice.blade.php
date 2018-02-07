<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .note-alt {
            background-color: #f0f7fb;
            border-left: solid 4px #3498db;
            line-height: 18px;
            overflow: hidden;
            padding: 12px;
            margin-bottom: 10px;
        }

        .note {
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
            background-color: #f0f7fb;
            border: solid 1px #3498db;
            border-radius: 6px;
            line-height: 18px;
            overflow: hidden;
            padding: 12px;
            text-align: center;
            margin-bottom: 30px;
        }

        .invoice-details, .invoice-customer {
            float: right;
        }

        p {
            margin: 0;
        }

        .invoice-logo, .invoice-business {
            display: inline-block;
        }

        .invoice-business, .invoice-customer {
            background-color: #F5F5F5;
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
            border-radius: 6px;
            line-height: 18px;
            overflow: hidden;
            padding: 12px;
        }

        .invoice-block {
            margin-bottom: 30px;
        }

        .table {
            margin-bottom: 30px;
        }

        .table-header {
            font-weight: bold;
            background: #eee;
            border-bottom: 1px solid #ddd;
            padding: 8px 0 0 0;
        }

        .table-row, .table-header, .table-footer {
            display: block;
            width: 100%;
            box-sizing: border-box;
        }

        .table-row {
            padding: 8px 0 3px 0;
            border-bottom: 1px #eee solid;
        }

        .table-row:last-child {
            border-bottom: 1px none;
        }

        .table-cell {
            display: inline-block;
            width: 75%;
            padding: 0 0 0 5px;
        }

        .table-footer {
            font-weight: bold;
        }

        .table-footer-group {
            display: inline-block;
            margin-top: 10px;
            border: solid 1px #3a3a3a;
            background-color: #F5F5F5;
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
            border-radius: 6px;
            padding: 12px 25px 8px 0;
            margin-left: 450px;
            width: 180px;
        }

        .cell-two {
            width: 20%;
        }

        .cell-empty {
            width: 0;
        }

        .cell-total {
            width: auto;
        }

        .table-footer .divider {
            margin: 0 0 0 25px;
            opacity: 0.3;
        }


    </style>
</head>

<body>
<div class="invoice-box">
    <div class="invoice-block">
        <div class="invoice-logo">
            <img src="https://camo.githubusercontent.com/7089de92c15e07062f4753149e942182d27845f3/687474703a2f2f692e696d6775722e636f6d2f7439473372464d2e706e67"
                 style="width:100%; max-width:300px;">
        </div>
        <div class="invoice-details">
            <p>Factuur #: {{$group->invoice_number}}</p>
            <p>Datum: {{$group->created_at->format('d/m/y')}}</p>
        </div>
    </div>
    <div class="invoice-block">
        <div class="invoice-business">
            <p>Gîte d'Etape de Villers-Sainte-Gertrude</p>
            <p>Rue du Millénaire, 1</p>
            <p>B-6941 Villers-Sainte-Gertrude Belgique</p>
        </div>
        <div class="invoice-customer">
            <p>{{$group -> last_name}}</p>
            <p>{{$group -> address}}</p>
        </div>
    </div>
    <div class="table">
        <div class="table-header">
            <div class="table-cell">Beschrijving</div>
            <div class="table-cell cell-two">Prijs</div>
        </div>
        <div>
            @foreach ($group->users as $user)
                <div class="table-row">
                    <div class="table-cell">{{$user->last_name}} {{$user->first_name}}</div>
                    <div class="table-cell cell-two">€{{number_format($user->price,2,",",".")}}</div>
                </div>
            @endforeach
        </div>
        <div class="table-footer">
            <div class="table-footer-group">
                <div class="table-footer">
                    <div class="table-cell cell-empty"></div>
                    <div class="table-cell cell-total">Reduction:
                        € {{$group->reduction > 0 ? '' : '+'}}{{number_format(-1 * $group->reduction,2,",",".")}}</div>
                </div>
                <div class="divider">
                    <hr>
                </div>
                <div class="table-footer">
                    <div class="table-cell cell-empty"></div>
                    <div class="table-cell cell-total">Totaal: €{{number_format($group->total_price,2,",",".")}}</div>
                </div>
                <div class="table-footer">
                    <div class="table-cell cell-empty"></div>
                    <div class="table-cell cell-total">Te Betalen: €{{number_format($group->due_price,2,",",".")}}</div>
                </div>
            </div>
        </div>
    </div>
    <p class="note-alt">
        <strong>Mededeling</strong>: {{$group->last_name}} Factuur N° {{$group->invoice_number}} Zomerschool 2018 - 174
    </p>
    <div class="note-alt">
        <strong>Rest van de betaling </strong>: door bank overschrijving (in één of meer keren) te betalen voor 15 juli
    </div>
    <div class="note">
        Compte/Rekening ASN des Bahá'ís de Belgique<br>
        Rue H. Evenepoel, 52-54 , 1030 Bruxelles<br>
        IBAN: <strong>BE71 2100 0642 3169</strong> BIC: <strong>GEBABEBB</strong>
    </div>
</div>
</body>
</html>