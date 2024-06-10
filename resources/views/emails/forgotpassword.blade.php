<!DOCTYPE html>
<html>
<head>
    <title>LCIMS Password Recovery</title>
</head>
<body>
    <h4>{{ $testMailData['title']}}</h4>
    <p>Hello <b>{{ $testMailData['name'] }} !</b></p>
    <p>
     There was recently a request to change the password on your account. If you requested this password change, please click the link below to set a new password within 10 Minutes upon clicking:</p>
    <br>
    <p>Click this link to renew your password <b>{{ redirect('/users/reset/changepassword/page/'.$testMailData['user_id']) }}</b> </p>
    
    <br>
    <p>if you dont want to change your password please ignore this message.</p>
  
    <br>
    <p>Best regards,</p>
    <p>LCIMS Developer Team</p>
    <h6><i>This is a system-generated email. Please do not reply</i>.</h6>
    <h5>
        <i>
        The information contained in this communication is intended solely for the use of the individual or entity to whom it is addressed and other parties authorized to receive it. It may contain confidential or legally privileged communication. If you are not the intended recipient, you are hereby notified that any disclosure, copying, distribution or taking any action in reliance on the contents of this information is strictly prohibited and may be unlawful. If you have received this communication in error, please notify us immediately by responding to this e-mail and then immediately delete it from your system. Opinions contained in this e-mail or any of its attachments do not necessarily reflect the opinions of the Agency.  
        </i>
    </h5>   
</body>
</html>