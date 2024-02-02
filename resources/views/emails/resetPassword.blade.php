<!DOCTYPE html>
<html>

<head>
    <title>Your Email Subject</title>
</head>

<body>
    <h2>Assalamualakum wr wb</h2>

    <p>Kami ingin menginformasikan bahwa anda telah meminta link untuk reset password akun ada</p>

    <table>
        <tbody>
            <tr>
                <th>NPK</th>
                <td>:</td>
                <td>{{ $dataSend['npk'] }}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>:</td>
                <td>{{ $dataSend['name'] }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>:</td>
                <td>{{ $dataSend['email'] }}</td>
            </tr>
        </tbody>
    </table>

    <p>
        Silahkan klik link berikut untuk reset password anda :
        <h3><a href="{{ $dataSend['link'] }}">Please click this link to reset</a></h3>
    </p>

    <br><br>
    <p>Best regards</p>

    <br><br><br><br>
    <p>
        PE-Digitalization, Do Not Reply This Message
    </p>

</body>

</html>
