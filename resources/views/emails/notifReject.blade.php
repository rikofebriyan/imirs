<!DOCTYPE html>
<html>

<head>
    <title>Your Email Subject</title>
</head>

<body>
    <h2>Assalamualakum wr wb</h2>

    <p>Kami ingin menginformasikan status ticket repair anda :</p>

    <table>
        <tbody>
            <tr>
                <th>No Ticket</th>
                <td>:</td>
                <td>{{ $dataSend['reg_sp'] }}</td>
            </tr>
            <tr>
                <th>Item Name</th>
                <td>:</td>
                <td>{{ $dataSend['item_name'] }}</td>
            </tr>
            <tr>
                <th>Item Type</th>
                <td>:</td>
                <td>{{ $dataSend['item_type'] }}</td>
            </tr>
            <tr>
                <th>Problem</th>
                <td>:</td>
                <td>{{ $dataSend['problem'] }}</td>
            </tr>
            <tr>
                <th>Section</th>
                <td>:</td>
                <td>{{ $dataSend['section'] }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>:</td>
                <td>
                    <h3>{{ $dataSend['status'] }}</h3>
                </td>
            </tr>
            <tr>
                <th>Reason</th>
                <td>:</td>
                <td>{{ $dataSend['reason'] }}</td>
            </tr>
        </tbody>
    </table>

    <br><br>
    <p>Best regards</p>

    <br><br><br><br>
    <p>
        PE-Digitalization, Do Not Reply This Message
    </p>

</body>

</html>