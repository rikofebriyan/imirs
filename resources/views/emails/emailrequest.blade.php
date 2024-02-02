<!DOCTYPE html>
<html>

<head>
    <title>Your Email Subject</title>
</head>

<body>
    <h2>Assalamualakum wr wb</h2>

    <p>We inform you that your Spare Part Repair need approval.</p><br />

    <p>
        No. Ticket : {{ $data['reg_sp'] }}
        Nama Requester : {{ $data['nama_requester'] }}<br />
        Section : {{ $data['section'] }}<br />
        Item Name : {{ $data['spare_part'] }}<br />
        Problem : {{ $data['problem'] }}<br />
    <h3><a href="{{ @url('partrepair/waitingapprove') }}">Please click this link to approve</a></h3>
    <br />
    <br />
    <p>Best regards,
    <p><br /><br /><br /><br />
        PE-Digitalization, Do Not Reply This Message

</body>

</html>
