<!DOCTYPE html>
<html>
<head>
    <title>LCIMS</title>
</head>
<body>
    <h4>{{ $testMailData['title'] }}</h4>
    <p>Hello <b>{{ $testMailData['body']['customer']->name}} !</b></p>
    <p>{{ $testMailData['data'] }}</p>
    @if($testMailData['status'] == "approved")
    <p>Burial Date and Time <b>{{$testMailData['body']['deceased'][0]->dateof_burial." ".$testMailData['body']['deceased'][0]->burial_time}}</b></p>
    @endif
    @if($testMailData['status'] == "matures")
    <p><b>&nbsp;{{ $testMailData['years'] }} </b> years old from burial</p>
    <p>Should the expiration occur, the deceased individual will be allocated to the services offered by the LGU Cemetery. Rest assured, we will promptly inform you should any decisions be made regarding the reassignment of the deceased from the current resting place. </p>
    @endif
    @if($testMailData['status'] == "plotted")
    <p>Block Cost: <b>&nbsp;₱ {{ number_format($testMailData['block_cost'], 2) }} </b> &nbsp;</p>
    <p>Remaining balance: <b>&nbsp;₱ {{ number_format($testMailData['block_payment'], 2) }} </b> &nbsp;</p>
    <p>Block Name: <b>&nbsp;{{ $testMailData['block_name'] }} </b> &nbsp;</p>
    <p>Should the expiration occur, the deceased individual will be allocated to the services offered by the LGU Cemetery. Rest assured, we will promptly inform you should any decisions be made regarding the reassignment of the deceased from the current resting place. </p>
    @endif
    <p>Be aware that this email can only be received once.</p>
    <h4>This is a system-generated email. Please do not reply.</h4>     
    <br>
    <h4>Truly yours.</h4>
    @if($testMailData['status'] == "matures")
        <b>Lugait Cemetery System</b><br>
        Lugait MEEDO Team
    @endif
    @if($testMailData['status'] != "matures")
        <b>{{ $testMailData['body']['user_name']}}</b><br>
        {{ $testMailData['body']['user_position']}}
    @endif
    <h5>
        <i>
        The information contained in this communication is intended solely for the use of the individual or entity to whom it is addressed and other parties authorized to receive it. It may contain confidential or legally privileged communication. If you are not the intended recipient, you are hereby notified that any disclosure, copying, distribution or taking any action in reliance on the contents of this information is strictly prohibited and may be unlawful. If you have received this communication in error, please notify us immediately by responding to this e-mail and then immediately delete it from your system. Opinions contained in this e-mail or any of its attachments do not necessarily reflect the opinions of the Agency.  
        </i>
    </h5>   
</body>
</html>