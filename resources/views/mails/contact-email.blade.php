<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Page Title</title>
    </head>
    <body>

        <div style="margin: 0 auto; width: 65%;">
            <h2>You have received a message from FlowerShoplk contact form.</h2>
            <table style='border-collapse:collapse; border: 1px outset; width: 100%;' cellpadding='10'>
                <tr style='background-color: #f5f5f5;'>
                    <td style="width: 15%;"><strong>Sender's Name : </strong></td>
                    <td>{{ $contact_name }}</td>
                </tr>
                <tr style='background-color: #f5f5f5;'>
                    <td style="width: 15%;"><strong>Email : </strong></td>
                    <td>{{ $contact_email }}</td>
                </tr>
                <tr style='background-color: #f5f5f5;'>
                    <td style="width: 15%;"><strong>Message : </strong></td>
                    <td>{{ $content }}</td>
                </tr>        
            </table>
        </div>

    </body>
</html>
