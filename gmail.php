
<?php

    $username = 'binh27112004@gmail.com'; //Your email
    $password = 'ekko2711'; //Your password

?>































<!DOCTYPE html>
<html>
<head>
<style>
body {
    font-family: Arial;
}

.list-form-container {
    background: #F0F0F0;
    border: #e0dfdf 1px solid;
    padding: 20px;
    border-radius: 2px;
}

.column {
    float: left;
    padding: 10px 0px;
}

table {
    width: 100%;    
    background: #FFF;
}

td, th {
    border-bottom: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
    width: auto;
}

.content-div {
    position:relative;
}

.content-div span.column {
    width: 90%;
}

.date {
    position: absolute;
    right: 8px;
    padding: 10px 0px;
}
</style>
<title>Get momo transfer history</title>
</head>

<body>
    <h1>Get momo transfer history</h1>
    <?php
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $d = date('d', strtotime("-1 days"));
        $m = date('m', strtotime("-1 days"));
        $y = date('Y', strtotime("-1 days"));
        $m = date('F', mktime(0, 0, 0, $m, 10));
        $date = $d. ' ' . $m . ' ' . $y;
    ?>
    
    <?php
    if (! function_exists('imap_open')) {
        echo "IMAP is not configured.";
        exit();
    } else {
        ?>
    <div id="listData" class="list-form-container">
            <?php
        $connection = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', $username, $password) or die('Cannot connect to Gmail: ' . imap_last_error());
        $emailData = imap_search($connection, 'FROM "no-reply@momo.vn"');
        
        if (! empty($emailData)) {
            ?>
            <table>
            <?php
            foreach ($emailData as $emailIdent) {
                $overview = imap_fetch_overview($connection, $emailIdent, 0);
                if(preg_match("/Giao dịch thành công/",imap_utf8($overview[0]->subject))) continue;
                if(!preg_match("/Bạn vừa nhận được tiền từ/",imap_utf8($overview[0]->subject))) continue;
                $message = ((imap_fetchbody($connection, $emailIdent,1)));
                $message = preg_replace( "/\s+/", " ", $message);
                preg_match('/(?<=li= ne-height: 1.2em; font-weight: 500;"> )(.*?)(?= <\/td>)/', $message, $matches);
                $money =  ($matches[0]);
                preg_match('/(?<=height: 1.55em;" width=3D"50%"> <div style=3D"color:#3C4043;margin:0px;font-size:12px;li= ne-height:22px; font-weight: normal; font-size: 15px; padding-right: 10px;= "> M=C3=A3 giao d=E1=BB=8Bch<\/div> <\/td> <td class=3D"" style=3D"padding-top: 5px; padding-bottom: 5px; font-si= ze: 14px; font-family: Helvetica Neue, Arial, sans-serif; color: #3C4043; t= ext-align: left; line-height: 1.55em;" width=3D"50%"> <div style=3D"color:#3C4043;margin:0px;font-size:12px;li= ne-height:22px; font-weight: normal; font-size: 15px;"> )(.*?)(?=<\/div>)/', $message, $matches);
                $code =  ($matches[0]);
                
                preg_match('/(?<=ADi<\/div> <\/td> <td class=3D"" style=3D"padding-top: 5px; padding-bottom: 5px; font-si= ze: 14px; font-family: Helvetica Neue, Arial, sans-serif; color: #3C4043; t= ext-align: left; line-height: 1.55em;" width=3D"50%"> <div style=3D"color:#3C4043;margin:0px;font-size:12px;li= ne-height:22px; font-weight: normal; font-size: 15px;"> )(.*?)(?=<\/div>)/', $message, $matches);
                $name =  str_replace("=",'%',$matches[0]);
                $name =  str_replace("%\s",'',$name);
                $name =  urldecode($name);
                preg_match('/(?<=tho=E1=BA=A1i ng=C6=B0= =E1=BB=9Di g=E1=BB=ADi<\/div> <\/td> <td class=3D"" style=3D"padding-top: 5px; padding-bottom: 5px; font-si= ze: 14px; font-family: Helvetica Neue, Arial, sans-serif; color: #3C4043; t= ext-align: left; line-height: 1.55em;" width=3D"50%"> <div style=3D"color:#3C4043;margin:0px;font-size:12px;li= ne-height:22px; font-weight: normal; font-size: 15px;"> )(.*?)(?=<\/div>)/', $message, $matches);
                $phone =  str_replace("=",'%',$matches[1]);
                preg_match('/(?<=gian<\/div> <\/td> <td class=3D"" style=3D"padding-top: 5px; padding-bottom: 5px; font-si= ze: 14px; font-family: Helvetica Neue, Arial, sans-serif; color: #3C4043; t= ext-align: left; line-height: 1.55em;" width=3D"50%"> <div style=3D"color:#3C4043;margin:0px;font-size:12px;li= ne-height:22px; font-weight: normal; font-size: 15px;"> )(.*?)(?=<\/div>)/', $message, $matches);
                $time =  str_replace("=",'%',$matches[1]);
                preg_match('/(?<=L=E1=BB=9Di nh=E1=BA=AFn<\/div> <\/td> <td class=3D"" style=3D"padding-top: 5px; padding-bottom: 5px; font-si= ze: 14px; font-family: Helvetica Neue, Arial, sans-serif; color: #3C4043; t= ext-align: left; line-height: 1.55em;" width=3D"50%"> <div style=3D"color:#3C4043;margin:0px;font-size:12px;li= ne-height:22px; font-weight: normal; font-size: 15px;"> )(.*?)(?=<\/div>)/', $message, $matches);
                $content =  str_replace('<div style="color:#3C4043;margin:0px;font-size:12px;li% ne-height:22px; font-weight: normal; font-size: 15px;"> ','',urldecode(str_replace("=",'%',$matches[1])));
                $date = date("d F, Y", strtotime($overview[0]->date));
                ?>
                <tr>
                        <td style="width:15%;">
                            <span class="column"><?php echo $overview[0]->from; ?></span>
                        </td>
                        <td class="content-div">
                            <span class="column"><?php echo imap_utf8($overview[0]->subject); ?> : 
                                <br> [Money] = <?php echo $money; ?> 
                                <br> [Code] = <?php echo $code; ?>
                                <br> [Name] = <?php echo $name; ?>
                                <br> [Phone] = <?php echo $phone; ?>
                                <br> [Content] = <?php echo $content; ?>
                            </span>
                            <span class="date"><?php echo $date; ?></span>
                        </td>
                </tr>
                <?php
            } // End foreach
            ?>
            </table>
            <?php
        } // end if
        else echo "Không tìm thấy mail";
        imap_close($connection);
    }
    ?>
    </div>
</body>
</html>
