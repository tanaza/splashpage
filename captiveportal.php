<?php
$logonerror=false;
$urlRedirect=null;
$urlRefresh=null;
$urlLogoff=null;
if (isset($_REQUEST["submit"])) {
    ob_clean();
    /**
     * Retrieve user specified credentials
     */    
    $username=(isset($_REQUEST["user"])?$_REQUEST["user"]:"");
    $password=(isset($_REQUEST["passwd"])?$_REQUEST["passwd"]:"");
    
    /**
     * Login to radius backend
     */
    $logonerror=!executeRadiusLogin($username,$password);
    
    if(!$logonerror){
        /**
        * If login is successful redirect user to ap logon page to enable session
        * Retrieve redirect url  
        */
        $url = "http://" . (isset($_REQUEST["ap_ip"])?$_REQUEST["ap_ip"]:""). ":" . (isset($_REQUEST["ap_port"])?$_REQUEST["ap_port"]:"") . "/logon?";
        $urlRefresh = "http://" . (isset($_REQUEST["ap_ip"])?$_REQUEST["ap_ip"]:""). ":" . (isset($_REQUEST["ap_port"])?$_REQUEST["ap_port"]:"") . "/refresh";
        $urlLogoff = "http://" . (isset($_REQUEST["ap_ip"])?$_REQUEST["ap_ip"]:""). ":" . (isset($_REQUEST["ap_port"])?$_REQUEST["ap_port"]:"") . "/logoff";
        foreach ($_REQUEST as $key => $value) {
            if ($key != "ap_ip" && $key != "ap_port" && $key != "submit") {
                $url.=$key . "=" . urlencode($value) . "&";
            }
        }
        if (substr($url, strlen($url) - 1, 1) == "&") {
            $url = substr($url, 0, strlen($url) - 1);
        }
        $urlRedirect=$url;
    }
}
function executeRadiusLogin($username,$password){
    //here you should implement you radius login procedure
    //in this example we suppose login is always ok
    return true;
}
?>
<?php ob_start(); ?>
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
            function openCaptivePopup(){
                var w = 400;
                var h = 250;
                var l = Math.floor((screen.width-w)/2);
                var t = Math.floor((screen.height-h)/2);
                return window.open("captiveportal_popup.php?url=<?php echo urlencode($urlLogoff); ?>&refreshUrl=<?php echo urlencode($urlRefresh); ?>","captivepopup","width=" + w + ",height=" + h + ",top=" + t + ",left=" + l+",status=0,scrollbars=0,menubar=0,resizable=0,toolbar=0,location=0",true);
            }
        </script>
    </head>
    <body class="claro">
        <div id="headerExt">
            <div id="header">
                <div id="logoContainer"  onclick="window.location.href='/'">
                    <img src="static/images/logo.png" alt="Tanaza" class="pngimg" />
                </div>

                <div style="float:right;margin-top:10px">
                    
                </div>

                <div class="cleared"></div>
            </div>
        </div>        
        <div style="width: 100%; background-color: #f4770e; height: 3px;"></div>
        <div id="mainExt">
            <div id="main">
                <div style="width:100%">
                    <?php
                    if(isset($urlRedirect)){ ?>
                            
                        <div  id="regForm">
                            <div style="width:100%; margin-left:14px;position:relative">
                                <table cellspacing="5px" class="table_content registrationTable">
                                    <tr>
                                        <td class="leftColumnRegistration">
                                            <img src="static/images/cloud.png"/><br/><br/>
                                            Visit <a href="http://www.tanaza.com" target="_blank"> Tanaza.com</a> for more info
                                        </td>
                                        <td class="rightColumnRegistration">
                                            <table cellspacing="5px" style="width:100%">
                                                <tr>
                                                    <td>
                                                        <div class="info" style="margin-left:0px;margin-top:-10px;">
                                                            <div class="art-post">
                                                                <div class="art-post-body">
                                                                    <div class="art-postcontent">
                                                                        <table>
                                                                            <tr>
                                                                                <td align="left">Login successful<br/>
                                                                                    <div id="popupok" style="display: none">
                                                                                         Redirecting user in 5 seconds... please wait...
                                                                                    </div>
                                                                                    <div id="popupblocked" style="display: none">
                                                                                        <input type="button" value="Click here to proceed surfing" onclick="window.location.href='<?php echo $urlRedirect; ?>'"/>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    <?php
                    }
                    else{ ?>
                    <form id="regForm" action="/captiveportal.php" method="post" enctype="application/x-www-form-urlencoded" name="regForm" >
                        <?php
                        /**
                         * Create html input hidden fields to store params received 
                         */
                        foreach ($_REQUEST as $key => $value) {
                            ?>
                            <input type="hidden" name="<?php echo htmlentities($key) ?>" value="<?php echo htmlentities($value) ?>">
                            <?php
                        }
                        ?>
                        <div class="">
                            <div style="width:100%; margin-left:14px;position:relative">
                                <table cellspacing="5px" class="table_content registrationTable">
                                    <tr>
                                        <td class="leftColumnRegistration">
                                            <img src="static/images/cloud.png"/><br/><br/>
                                            Visit <a href="http://www.tanaza.com" target="_blank"> Tanaza.com</a> for more info
                                        </td>

                                        <td class="rightColumnRegistration">
                                            <table cellspacing="5px" class="">
                                                <tbody>
                                                    <tr>
                                                        <td style="color:red;font-weight: bold;line-height: 30px" colspan="2">
                                                            <h2>Tanaza Captive Login Form</h2>
                                                        </td>
                                                    </tr>
                                                    <?php 
                                                    /**
                                                     * If logon fails show an error to user 
                                                     */
                                                    if ($logonerror) { ?>                                                    
                                                        <tr>
                                                            <td colspan="2">
                                                                <div class="alert" style="margin-left:0px;margin-top:-10px;" id="validationError">
                                                                    <div class="art-post">
                                                                        <div class="art-post-body" style="padding: 0px">
                                                                            <div class="art-postcontent">
                                                                                <table>
                                                                                    <tr>
                                                                                        <td align="left">Invalid username or password.</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td align="left" style="width:130px">User Name</td>
                                                        <td><input  type="text" valign="center" id="firstName" name="user" value="" class="idleField" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">Password</td>
                                                        <td><input  type="text" maxlength="40" valign="center" id="lastName" name="passwd" value="" class="idleField" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="">
                                                            <input type="submit" name="submit" value="Submit"/>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </form>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="cleared"></div>
        </div>

        <div style="width: 100%; background-color: #f4770e; height: 3px;"></div>
        <div id="footerExt">
            <div id="footer">
                <div id="copyright" style="text-align:center; margin-top:20px">
                    <span style="color: white; font-family: Arial; font-size: 11px">
                        Copyright &copy; 2012-2013 Tanaza. <a href="terms.php" target="_blank">Terms of Use</a> All rights reserved.
                    </span>
                </div>
                <div class="cleared"></div>
            </div>
        </div>
        <?php
        if(isset($urlRedirect)){ ?>
            <script type="text/javascript">
                //openpopup
                var newWin=openCaptivePopup();
                if(!newWin || newWin.closed || typeof newWin.closed=='undefined'){
                    document.getElementById('popupblocked').style.display='block';
                    alert("Please allow this page to open popup else you cannot logoff from the session");
                }
                else{
                    document.getElementById('popupok').style.display='block';
                    setTimeout("window.location.href='<?php echo $urlRedirect; ?>'",5000);
                }
            </script>                                
        <?php
        }?>
    </body>
</html>

