<!DOCTYPE html>
<html>
    <head>
        <title>Tanaza | Cloud Wi-Fi Access Point management for any AP model/vendor</title>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <meta name="Description" content="Tanaza is a WiFi Access Points management system offered through the cloud, that allows users to configure and monitor virtually any WiFi Access Point model." />
        <meta name="keywords" content="tanaza,wifi,access,point,management,cloud,hotspot,monitor,configure,centralized,central,centrally" />
        <link rel="shortcut icon" href="static/images/favicon.ico" />
        <!-- Style -->
        <link type="text/css" rel="stylesheet" href="static/css/captive.css?v=<?php echo time(); ?>" />
        <script type="text/javascript">
            var closePop=false;
            function closeCaptivePopup(){
                closePop=true;
                document.getElementById('logoffframe').src="<?php echo (isset($_REQUEST["url"])?$_REQUEST["url"]:"");?>";
            }
            function evaluateClose(){
                if(closePop){
                    window.close();
                }
            }
            function refreshFrame(){
                document.getElementById('refreshframe').src="<?php echo (isset($_REQUEST["refreshUrl"])?$_REQUEST["refreshUrl"]:"");?>?t="+((new Date()).getTime());
            }
            var timeoutMills=3*60*1000;
            setInterval('refreshFrame()',timeoutMills);
        </script>
    </head>
    <body class="claro" style="background-color: #F6F7F7">
        <table style="width: 100%">
            <tr>
                <td style="background-color: black;width: 100%">
                    <img src="static/images/logo.png" alt="Tanaza" class="pngimg" />
                    <div style="width: 100%; background-color: #f4770e; height: 3px;"></div>
                </td>
            </tr>
            <tr>
                <td style="">
                    Please don't close this windows otherwise the session expires. <br/>
                    If you want to close the session please click on the following button.<br/>
                    <input type="button" onclick="closeCaptivePopup()" value="Logout"/>
                </td>
            </tr>
        </table>
        <iframe id="logoffframe" onload="evaluateClose()" style="display: none;width:1px;height: 1px;">
        </iframe>
        <iframe id="refreshframe" style="display: none;width:1px;height: 1px;">
        </iframe>
    </body>
</html>

